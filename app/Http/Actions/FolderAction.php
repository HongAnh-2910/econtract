<?php

namespace App\Http\Actions;

use App\Models\File;
use App\Models\Folder;
use App\Repositories\File\FileRepository;
use App\Repositories\Folder\FolderRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use function auth;
use function config;
use function storage_path;

class FolderAction extends BaseAction
{
    protected $folderRepository;
    private $fileRepo;

    public function __construct(FolderRepository $folderRepository, FileRepository $fileRepo)
    {
        $this->folderRepository = $folderRepository;
        $this->fileRepo = $fileRepo;
    }

    public function show($request): array
    {
        $status = $request->status;
        $folder = $this->folderRepository->showParentFolder(auth()->id(), null);
        if ($status == config('statuses.trash')) {
            $folderChildren = $this->folderRepository->findFolderOnTrash(Auth::user());
            $fileOfFolder = $this->fileRepo->findFileOnTrash(Auth::user());
        } elseif ($status == config('statuses.share')) {

            $folderChildren = $this->folderRepository->findFoldersViaUserShare();
            $fileOfFolder = $this->fileRepo->findFilesOnShare();
        } else {
            $folderChildren = $this->folderRepository->findFoldersOfParentFolder($folder->children());
            $fileOfFolder = $this->fileRepo->findFilesOnFolderOfUser($folder->files());
        }

        return [
            'folder' => $folder,
            'folderChildren' => $folderChildren,
            'fileOfFolder' => $fileOfFolder
        ];
    }

    public function showBySlug($request, $slug): array
    {
        $status = $request->status;
        if ($status != config('statuses.share')) {
            $folder = $this->folderRepository->findFolderByUserAndSlug($slug);
            $folderChildren = $folder->children->sortByDesc('created_at');
            $fileOfFolder = $this->paginate($folder->files->sortByDesc('created_at'), 15, $request->page ?? 1);
        } else {
            $folder = $this->folderRepository->findFolderSharingViaSlug(Auth::user(), $slug);
            $folderChildren = $this->folderRepository->findChildrenFolderExists($folder->children());
            $fileOfFolder = $this->fileRepo->findFilesOnShare($folder->files());
        }

        return [
            'folder' => $folder,
            'folderChildren' => $folderChildren,
            'fileOfFolder' => $fileOfFolder
        ];
    }

    public function create($request)
    {
        $folder = $this->folderRepository->create([
            'name' => $request->folder_name,
            'user_id' => Auth::user()->id,
            'parent_id' => $request->parent_id,
            'created_at' => Carbon::now()
        ]);
        if ($folder) {
            Session::flash('message', 'Tạo thư mục thành công!');
        } else {
            Session::flash('error_message', 'Tạo thư mục không thành công. Vui lòng thử lại!');
        }

        return Folder::find($request->parent_id);
    }

    private function getFilesByStatus($status, $request)
    {
        $user = Auth::user();
        $files = [];
        if ($status == config('statuses.share')) {
            $files = $this->paginate($user->files->sortByDesc('created_at'), 15, $request->page ?? 1);
        } else if ($status == config('statuses.trash')) {
//            $files = File::onlyTrashed()->where('user_id', null)->orderByDesc('deleted_at')->paginate(15);
        }

        return $files;
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $status = $this->folderRepository->delete($id);
        if ($status) {
            Session::flash('message', 'Xoá thành công!');
        } else {
            Session::flash('error_message', 'Xoá không thành công. Vui lòng kiểm tra lại!');
        }
    }

    /**
     * @param $request
     */
    public function multipleForceDelete($request)
    {
        $fileList = explode(',', $request->file_list);
        $folderList = explode(',', $request->folder_list);
        foreach ($fileList as $file) {
            if ($file != "" && $file != null) {
                $this->fileRepo->forceDelete((int)$file);
            }
        }
        foreach ($folderList as $folder) {
            if ($folder != "" && $folder != null) {
                $this->forceDelete((int)$folder);
            }
        }
        Session::flash('message', 'Xoá vĩnh viễn thành công!');
    }

    /**
     * @param $request
     */
    public function multipleRestore($request)
    {
        $fileList = explode(',', $request->file_list);
        $folderList = explode(',', $request->folder_list);

        foreach ($fileList as $file) {
            if ($file != "" && $file != null) {
                $this->fileRepo->restore((int)$file);
            }
        }
        foreach ($folderList as $folder) {
            if ($folder != "" && $folder != null) {
                $this->folderRepository->restore((int)$folder);
            }
        }
        Session::flash('message', 'Khôi phục thành công!');
    }

    /**
     * @param $id
     */
    public function forceDelete($id)
    {
        $dataFolder = $this->folderRepository->findParentAndFolder($id);
        $parent = $dataFolder['parent'];
        $folder = $dataFolder['folder'];
        $dataChild = $this->folderRepository->findChildrenAndFiles($folder);
        $children = $dataChild['children'];
        $remainFiles = $dataChild['remainFiles'];

        $filesInFolderDeleted = $dataChild['filesInFolderDeleted'];
        $childrenOfChildren = $dataChild['childrenOfChildren'];

        $this->moveToFolderOfUser($remainFiles, $children, $parent);
        $this->moveToFolderOfUser($filesInFolderDeleted, $childrenOfChildren, $parent);

        $allFilesToRemove = $this->folderRepository->findAllFilesInFolderToRemove($folder);

        /** @var File $fileToRemove */
        foreach ($allFilesToRemove as $fileToRemove) {
            $path = storage_path() . '/' . 'uploads/' . $fileToRemove->name;

            if (file_exists($path)) {
                unlink($path);
            }
        }

        $status = $this->folderRepository->forceDelete($folder);

        if ($status) {
            Session::flash('message', 'Xoá vĩnh viễn thành công!');
        } else {
            Session::flash('error_message', 'Xoá vĩnh viễn không thành công. Vui lòng kiểm tra lại!');
        }
    }

    /**
     * @param $id
     */
    public function restore($id)
    {
        $status = $this->folderRepository->restore($id);

        if ($status) {
            Session::flash('message', 'Khôi phục thành công!');
        } else {
            Session::flash('error_message', 'Khôi phục không thành công. Vui lòng kiểm tra lại!');
        }
    }

    /**
     * @param $request
     * @param $id
     * @return string[]
     */
    public function updateFolderPermission($request, $id)
    {
        $userArray = $request->users;
        if ($userArray) {
            $this->folderRepository->syncUser($id, $userArray);
            Session::flash('message', 'Thêm quyền thành công!');
        } else {
            $this->folderRepository->syncUser($id, []);
            Session::flash('message', 'Thêm quyền thành công!');
        }
        return [
            "message" => 'success',
        ];
    }

    public function generateRandomString($length = 10)
    {
        $string = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($string, ceil($length / strlen($string)))), 1, $length);
    }

    public function moveToFolderOfUser($remainFiles, $children, Folder $parent)
    {
        if (count($remainFiles)) {
            /** @var File $remainFile */
            foreach ($remainFiles as $remainFile) {
                $remainFile->folder_id = $parent->id;
                $remainFile->save();
            }
        }

        if (count($children)) {
            /** @var Folder $child */
            foreach ($children as $child) {
                $child->parent_id = $parent->id;
                $child->save();
            }
        }
    }

    public function activeStatusFolder($request)
    {
        $statusFolder = 0;
        switch ($request->status) {
            case config('statuses.all'):
                $statusFolder = 0;
                break;
            case config('statuses.trash'):
                $statusFolder = 1;
                break;
            case config('statuses.all_private'):
                $statusFolder = 2;
                break;
            case config('statuses.share'):
                $statusFolder = 3;
                break;
            default:
                $statusFolder = 0;
        }
        return $statusFolder;
    }
}
