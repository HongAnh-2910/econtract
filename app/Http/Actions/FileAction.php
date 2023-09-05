<?php

namespace App\Http\Actions;

use App\Models\Folder;
use App\Models\User;
use App\Repositories\File\FileRepository;
use App\Repositories\Folder\FolderRepository;
use App\Traits\UploadTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FileAction
{
    use UploadTrait;

    protected $fileRepository;
    protected $folderRepository;

    public function __construct(FileRepository $fileRepository, FolderRepository $folderRepository)
    {
        $this->fileRepository = $fileRepository;
        $this->folderRepository = $folderRepository;
    }

    public function create($request)
    {
        $files = $request->file;
        $parentId = $request->parent_id;
        $users = preg_split("/[,]/", $request->users);
        foreach ($files as $file) {
            $fileExtension = $file->extension();
            $fileName = uniqid() . '_' . $file->getClientOriginalName();
            $isIssetFile = $this->fileRepository->findWhere(['path' => $fileName]);
            if (count($isIssetFile) == 0) {
                $fileSize = $file->getSize();
                $fileSizeByKb = number_format($fileSize / 1024, 2);

                $this->uploadOneFile($file, 'uploads', 'storage', $fileName);
                $newFile = $this->fileRepository->create([
                    'name' => $fileName,
                    'created_at' => Carbon::now(),
                    'folder_id' => $parentId,
                    'user_id' => Auth::user()->id,
                    'path' => $fileName,
                    'type' => $fileExtension,
                    'size' => $fileSizeByKb,
                ]);
                if ($users) {
                    $userArray = User::find($users);
                    $newFile->userFile()->attach($userArray);
                }
                Session::flash('message', 'Tải lên tài liệu thành công!');
            } else {
                Session::flash('error_message', 'File đã trùng. Vui lòng tải lại!');
            }
        }

        return [
            "message" => 'success',
        ];
    }

    public function delete($id)
    {
        $status = $this->fileRepository->delete($id);
        if ($status) {
            Session::flash('message', 'Xoá thành công!');
        } else {
            Session::flash('error_message', 'Xoá không thành công. Vui lòng kiểm tra lại!');
        }
    }

    public function restore($id)
    {
        $status = $this->fileRepository->restore($id);

        if ($status) {
            Session::flash('message', 'Khôi phục thành công!');
        } else {
            Session::flash('error_message', 'Khôi phục không thành công. Vui lòng kiểm tra lại!');
        }
    }

    public function forceDelete($id)
    {
        $status = $this->fileRepository->forceDelete($id);

        if ($status) {
            Session::flash('message', 'Xoá vĩnh viễn thành công!');
        } else {
            Session::flash('error_message', 'Xoá vĩnh viễn không thành công. Vui lòng kiểm tra lại!');
        }
    }

    public function updatePermission($request, $id)
    {
        $userArray = $request->users;
        if ($userArray) {
            $this->fileRepository->syncUser($id, $userArray);
            Session::flash('message', 'Thêm quyền thành công!');
        } else {
            $this->fileRepository->syncUser($id, []);
            Session::flash('message', 'Thêm quyền thành công!');
        }
        return [
            "message" => 'success',
        ];
    }

    public function multipleDelete($request)
    {
        $fileList = explode(',', $request->file_list);
        $folderList = explode(',', $request->folder_list);
        foreach ($fileList as $file) {
            if ($file != "" && $file != null) {
                $this->fileRepository->delete((int)$file);
            }
        }
        foreach ($folderList as $folder) {
            if ($folder != "" && $folder != null) {
                $this->folderRepository->delete((int)$folder);
            }
        }
        Session::flash('message', 'Xoá thành công!');
    }

    public function addFileToZip($zip, $path, Folder $folder, User $user)
    {
        $filesByFolderSlug = $this->fileRepository->findFileByFolderSlug($user, $folder);
        $childFolders = $folder->children()->get();

        if (count($filesByFolderSlug)) {
            foreach ($filesByFolderSlug as $item) {
//                $zip->addFile(storage_path('uploads/' . $item->name), $path . $item->name);
                if (file_exists($fileName = storage_path('uploads/' . $item->name))) {
                    $zip->addFile($fileName, $path . $item->name);
                }
            }
        } else {
            $zip->addEmptyDir($path);
        }

        if (count($childFolders)) {
            foreach ($childFolders as $childFolder) {
                $this->addFileToZip($zip, $path . $childFolder->name . '/', $childFolder, $user);
            }
        }

        if (!$zip->numFiles) {
            $zip->addEmptyDir(strtolower($folder->name));
        }
    }

    public function addFileOnTrashToZip($zip, $path, Folder $folder, $folderSoftDeleted)
    {
        $filesChild = $folder->files()->where('file_soft_deleted', '=', $folderSoftDeleted)->withTrashed()->get();
        $childFolders = $folder->children()->where('folder_soft_deleted', '=', $folderSoftDeleted)->withTrashed()->get();

        if (count($filesChild)) {
            foreach ($filesChild as $item) {
//                $zip->addFile(storage_path('uploads/' . $item->name), $path . $item->name);
                if (file_exists($fileName = storage_path('uploads/' . $item->name))) {
                    $zip->addFile($fileName, $path . $item->name);
                }
            }
        } else {
            $zip->addEmptyDir($path);
        }


        if (count($childFolders)) {
            foreach ($childFolders as $childFolder) {
                $this->addFileOnTrashToZip($zip, $path . $childFolder->name . '/', $childFolder, $folderSoftDeleted);
            }
        }

        if (!$zip->numFiles) {
            $zip->addEmptyDir(strtolower($folder->name));
        }
    }

    public function addFileOnShareToZip($zip, $path, Folder $folder)
    {
        $filesByFolderSlug = $folder->files()->get();
        $childFolders = $this->folderRepository->findChildrenFolderExists($folder->children());

        if (count($filesByFolderSlug)) {
            foreach ($filesByFolderSlug as $item) {
                //$zip->addFile(storage_path('uploads/' . $item->name), $path . $item->name);
                if (file_exists($fileName = storage_path('uploads/' . $item->name))) {
                    $zip->addFile($fileName, $path . $item->name);
                }
            }
        } else {
            $zip->addEmptyDir($path);
        }

        if (count($childFolders)) {
            foreach ($childFolders as $childFolder) {
                $this->addFileOnShareToZip($zip, $path . $childFolder->name . '/', $childFolder);
            }
        }

        if (!$zip->numFiles) {
            $zip->addEmptyDir(strtolower($folder->name));
        }
    }
}
