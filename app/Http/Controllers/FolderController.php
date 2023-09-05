<?php

namespace App\Http\Controllers;

use App\Http\Actions\FileAction;
use App\Http\Actions\FolderAction;
use App\Http\Requests\FolderRequest;
use App\Models\File;
use App\Models\Folder;
use App\Repositories\File\FileRepository;
use App\Repositories\Folder\FolderRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FolderController extends Controller
{
    protected $folderAction;
    private $folderRepository;
    private $fileRepository;
    private $fileAction;

    public function __construct(
        FolderAction     $folderAction,
        FolderRepository $folderRepository,
        FileRepository   $fileRepository,
        FileAction       $fileAction
    )
    {
        $this->folderAction = $folderAction;
        $this->fileAction = $fileAction;
        $this->folderRepository = $folderRepository;
        $this->fileRepository = $fileRepository;
    }

    public function index(Request $request)
    {
        $slug = $request->get('slug');
        $data = $this->folderAction->show($request);
        $folderParent = Folder::where([
            ['id', Auth::id()],
            ['parent_id', null],
        ])->first();
        $statusFolder = $this->folderAction->activeStatusFolder($request);
        return view('dashboard.document.index', $data, compact('folderParent', 'slug', 'statusFolder'));
    }

    public function store(FolderRequest $request)
    {
        $folder = $this->folderAction->create($request);

        return redirect()->route('web.folders.show', ['folders' => $folder]);
    }

    public function show(Request $request, $slug)
    {
        $is_back = 0;
        $statusFolder = $this->folderAction->activeStatusFolder($request);
        $folderParent = Folder::where([
            ['id', Auth::id()],
            ['parent_id', null],
        ])->first();
        $data = $this->folderAction->showBySlug($request, $slug);
        if ($slug) {
            $is_back = 1;
        }
        return view('dashboard.document.index', $data, compact('folderParent', 'slug', 'statusFolder', 'is_back'));
    }

    public function destroy($id)
    {
        $this->folderAction->delete($id);

        return redirect()->back();
    }

    public function showFolderAjax(Request $request)
    {
        $files_id = $request->input('id_file');
        $id = $request->input('id');
        $folder = Folder::where([
            ['user_id', Auth::id()],
            ['parent_id', null]
        ])->first()->children->where('id', '<>', $id);
        $folderParent = Folder::where([
            ['user_id', Auth::id()],
            ['parent_id', null]
        ])->first();

        return view('dashboard.document.folder_parent', compact('folder'));
    }

    public function searchAjax(Request $request)
    {
        $search = '';
        if ($request->input('search')) {
            $search = $request->input('search');
        }

        $folder = Folder::where([
            ['id', Auth::id()],
            ['parent_id', null],
        ])->first()->children()->where([
            ["name", "LIKE", "%{$search}%"],
            ["id", '<>', $request->input('id_folder')]
        ])->get();
        return view('dashboard.document.searchAjax_folder', compact('folder'));
    }

    public function showFolderChild(Request $request)
    {
        $filesId = $request->input('files_id');
        $folderId = $request->input('folder_id');
        $id = $request->input('id');
        $folders = Folder::find($id);

        return view('dashboard.document.folder_child', compact('folders', 'id', 'filesId', 'folderId'));
    }

    public function folderMoved(Request $request)
    {
        $id = $request->input('id');
        $folderId = $request->input('folder_id');
        $folderParentId = Folder::where([
            ['user_id', Auth::id()],
            ['parent_id', null]
        ])->first();
        if (!empty($request->input('files_id'))) {
            if ($id) {
                $files = File::find($request->input('files_id'))->update([
                    'folder_id' => $id,
                ]);
            } else {
                $filesParent = File::find($request->input('files_id'))->update([
                    'folder_id' => $folderParentId->id,
                ]);
            }

        } else {
            if ($id) {
                $folder = Folder::where('id', $folderId)->update([
                    'parent_id' => $id
                ]);
            } else {
                $folderParent = Folder::where('id', $folderId)->update([
                    'parent_id' => $folderParentId->id,
                ]);
            }
        }
        if (!empty($folder) || !empty($files)) {
            Session::flash('message', 'Bạn đã di chuyển tài liệu thành công');
            return redirect()->back();
        } else if (!empty($filesParent) || !empty($folderParent)) {
            Session::flash('message', 'Bạn đã di chuyển tài liệu thành công');
            return redirect()->route('web.folders.index');
        }
    }

    public function folderRename(Request $request)
    {
        $id = $request->input('id');
        $folderById = Folder::find($id);
        return view('dashboard.document.rename_child_folder', compact('folderById'));
    }

    public function folderRenameUpdate(Request $request, $id)
    {
        $nameFolder = $request->input('folder_name');
        $folder = Folder::where('id', $id)->update([
            'name' => $nameFolder,
        ]);
        if ($folder) {
            return redirect()->back()->with('message', 'Bạn đã đổi tên folder thành công');
        }
    }

    public function exportFiles(Request $request)
    {
        $zip = new \ZipArchive();
        $user = Auth::user();
        $slug = $request->slug ?? 'export';
        $status = $request->status;
        $typeExport = $request->typeExport ?? 'zip';

        if ($status == config('statuses.trash')) {
            $currentFolder = $this->folderRepository->findFolderOnTrashBySlug($user, $request->slug);

        } elseif ($status == config('statuses.share')) {
            $currentFolder = $this->folderRepository->findFolderSharingViaSlug(Auth::user(), $slug);
        } else {
            $currentFolder = $this->folderRepository->findFolderBySlug($user, $request->slug);
        }

        if (!$currentFolder) {
            return \response()->json(['message' => 'Thư mục không tồn tại, tải xuống không thành công']);
        }

        $fileName = $this->folderAction->generateRandomString() . '.' . $typeExport;

        $path = '';
        $zip->open(public_path($fileName), \ZipArchive::CREATE);

        if ($status == config('statuses.trash')) {
            $this->fileAction->addFileOnTrashToZip($zip, $path, $currentFolder, $currentFolder->folder_soft_deleted);
        } elseif ($status == config('statuses.share')) {
            $this->fileAction->addFileOnShareToZip($zip, $path, $currentFolder);
        } else {
            $this->fileAction->addFileToZip($zip, $path, $currentFolder, $user);
        }

        $zip->close();

        return response()->download($fileName)->deleteFileAfterSend(true);
    }

    public function forceDestroy($id): RedirectResponse
    {
        $this->folderAction->forceDelete($id);

        return redirect()->back();
    }

    public function restore($id): RedirectResponse
    {
        $this->folderAction->restore($id);

        return redirect()->back();
    }

    public function updateFolderPermission(Request $request, $id)
    {
        $this->folderAction->updateFolderPermission($request, $id);
    }

    public function multipleForceDelete(Request $request): RedirectResponse
    {
        $this->folderAction->multipleForceDelete($request);

        return redirect()->back();
    }

    public function multipleRestore(Request $request): RedirectResponse
    {
        $this->folderAction->multipleRestore($request);

        return redirect()->back();
    }
}
