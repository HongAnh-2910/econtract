<?php

namespace App\Repositories\Folder;

use App\Models\File;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FolderRepository implements FolderRepositoryInterface
{
    protected $folder;

    /**
     * @var File
     */
    private $file;

    /**
     * FolderRepositories constructor.
     *
     * @param Folder $folder
     */

    public function __construct(Folder $folder, File $file)
    {
        $this->folder = $folder;
        $this->file = $file;
    }

    /**
     * @param $request
     *
     * @return mixed
     */
    public function create($request)
    {
        /** @var Folder $parent */
        $parent = $this->folder->findOrFail($request['parent_id']);
        $userAttach = $parent->folderShare()->pluck('user_id')->toArray();

        /** @var Folder $folder */
        $folder = $this->folder->create($request);
        $folder->folderShare()->sync($userAttach);

        return true;

    }

    /**
     * @param $slug
     * @return mixed
     */
    public function findFolderByUserAndSlug($slug)
    {
        return $this->folder->where('slug', '=', $slug)->where('user_id', Auth::user()->id)->firstOrFail();
    }

    public function show($id)
    {
        // TODO: Implement show() method.
    }

    /**
     * @param $owner_id
     * @param $parent_id
     *
     * @return mixed
     */
    public function showParentFolder($owner_id, $parent_id)
    {
        // TODO: Implement showParentFolder() method.
        return $this->folder->where('user_id', $owner_id)->where('parent_id', $parent_id)->first();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function delete($id)
    {
        $folder = $this->folder->findOrFail($id);

        $this->deleteChild($folder, $folder->slug);

        return true;
    }

    public function deleteChild(Folder $folder, $slug)
    {
        $folder->folder_soft_deleted = $slug;
        $folder->save();
        $folder->delete();
        $this->deleteFilesInFolder($folder, $slug);
        $children = $folder->children();
        if ($children->count()) {
            foreach ($children->get() as $child) {
                $this->deleteFilesInFolder($child, $slug);
                $this->deleteChild($child, $slug);
            }
        }
    }

    public function deleteFilesInFolder(Folder $folder, $slug)
    {
        $files = $folder->files();
        if ($files->count()) {
            /** @var File $file */
            foreach ($files->get() as $file) {
                $file->file_soft_deleted = $slug;
                $file->save();
                $file->delete();
            }
        }
    }

    public function findFolderBySlug(User $user, $slug)
    {
        if ($slug) {
            return $this->folder::where('slug', '=', $slug)->where('user_id', '=', $user->id)->first();
        } else {
            return $this->folder::where('parent_id', '=', NULL)->where('user_id', '=', $user->id)->first();
        }
    }

    public function findFolderOnTrashBySlug(User $user, $slug)
    {
        return $this->folder::onlyTrashed()->where('slug', '=', $slug)->where('user_id', '=', $user->id)->first();
    }

    public function findFolderOnTrash(User $user)
    {
        return $this->folder::onlyTrashed()
            ->selectRaw('folders.*')
            ->join(DB::raw('folders as parent'), 'folders.parent_id', 'parent.id')
//                            ->where('parent.deleted_at', '=', null)
            ->where('folders.user_id', $user->id)
            ->whereRaw('(parent.folder_soft_deleted != folders.folder_soft_deleted OR parent.deleted_at is null)')
            ->orderByDesc('folders.deleted_at')
            ->get();
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function findParentAndFolder($id)
    {
        $parent = $this->folder::where('user_id', '=', Auth::id())->where('parent_id', '=', null)->firstOrFail();
        $folder = $this->folder->withTrashed()->findOrFail($id);

        return ['parent' => $parent, 'folder' => $folder];
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function forceDelete(Folder $folder)
    {
        $folder->forceDelete();

        return true;
    }

    /**
     * @param Folder $folder
     * @param $slug
     * @param Folder $parent
     *
     * @return array
     */
    public function findChildrenAndFiles(Folder $folder)
    {
        $remainFiles = $this->file::withTrashed()
            ->where('folder_id', '=', $folder->id)
            ->whereRaw("(file_soft_deleted != '" . $folder->folder_soft_deleted . "' OR file_soft_deleted is null )")
            ->get();

        $children = $this->folder::withTrashed()
            ->where('parent_id', '=', $folder->id)
            ->whereRaw("(folder_soft_deleted != '" . $folder->folder_soft_deleted . "' OR folder_soft_deleted is null )")
            ->get();

        $filesInFolderDeleted = $this->file::withTrashed()
            ->select('files.*')
            ->join('folders', 'folders.id', 'files.folder_id')
            ->where('folders.id', '!=', $folder->id)
            ->where('folder_soft_deleted', '=', $folder->folder_soft_deleted)
            ->whereRaw("(file_soft_deleted != '" . $folder->folder_soft_deleted . "' OR file_soft_deleted is null )")
            ->get();

        $childrenOfChildren = $this->folder::withTrashed()
            ->select('folders.*')
            ->join(DB::raw('folders as parent'), 'parent.id', 'folders.parent_id')
            ->where('parent.id', '!=', $folder->id)
            ->where('parent.folder_soft_deleted', '=', $folder->folder_soft_deleted)
            ->whereRaw("(folders.folder_soft_deleted != '" . $folder->folder_soft_deleted . "' OR folders.folder_soft_deleted is null )")
            ->get();

        return [
            'remainFiles' => $remainFiles,
            'children' => $children,
            'filesInFolderDeleted' => $filesInFolderDeleted,
            'childrenOfChildren' => $childrenOfChildren
        ];
    }

    public function findAllFilesInFolderToRemove(Folder $folder)
    {
        return $this->file::onlyTrashed()
            ->where('file_soft_deleted', '=', $folder->folder_soft_deleted)
            ->get();
    }

    /**
     * @param $id
     *
     * @return bool|null
     */
    public function restore($id)
    {
        $folder = $this->folder->withTrashed()->findOrFail($id);

        $this->restoreChild($folder, $folder->folder_soft_deleted);

        return true;
    }

    public function restoreChild(Folder $folder, $folderSoftDeleted)
    {
        $folder->folder_soft_deleted = null;
        $folder->save();
        $folder->restore();
        $this->restoreFilesInFolder($folder, $folderSoftDeleted);
        $children = $folder->children()->where('folder_soft_deleted', '=', $folderSoftDeleted)->withTrashed();
        if ($children->count()) {
            foreach ($children->get() as $child) {
                $this->restoreChild($child, $folderSoftDeleted);
            }
        }
    }

    public function restoreFilesInFolder(Folder $folder, $folderSoftDeleted)
    {
        $files = $folder->files()->where('file_soft_deleted', '=', $folderSoftDeleted)->withTrashed();
        if ($files->count()) {
            foreach ($files->get() as $file) {
                $file->file_soft_deleted = null;
                $file->save();
                $file->restore();
            }
        }
    }

    /**
     * @param $folderId
     * @param $userArray
     */
    public function syncUser($folderId, $userArray)
    {
        /** @var Folder $folder */
        $folder = $this->folder->findOrFail($folderId);
        $userDetach = $folder->folderShare()->pluck('user_id')->toArray();
        $userDetach = array_diff($userDetach, $userArray);
        $this->syncUserForFolder($folder, $userArray, $userDetach, true);
    }

    public function syncUserForFolder(Folder $folder, $userArray, $userDetach, $parentFolder = false)
    {
        if ($parentFolder) {
            $folder->folderShare()->sync($userArray);
        } else {
            $folder->folderShare()->sync($userArray);
            $folder->folderShare()->detach($userDetach);
        }

        $filesInFolder = $folder->files();
        $this->syncUserFile($filesInFolder->get(), $userArray, $userDetach);
        $this->syncUserFile($filesInFolder->withTrashed()->get(), $userArray, $userDetach);


        $children = $folder->children();

        $this->syncUserFolderChild($children, $userArray, $userDetach);
        $this->syncUserFolderChild($children->withTrashed(), $userArray, $userDetach);

    }

    public function syncUserFile($files, $userArray, $userDetach)
    {
        foreach ($files as $file) {
            $syncExists = $file->userFile()->pluck('user_id')->toArray();
            $syncExists = array_unique(array_merge($userArray, $syncExists));
            $file->userFile()->sync($syncExists);
            $file->userFile()->detach($userDetach);
        }
    }

    public function syncUserFolderChild($children, $userArray, $userDetach)
    {
        if ($children->count()) {
            /** @var Folder $child */
            foreach ($children->get() as $child) {
                $syncExists = $child->folderShare()->pluck('user_id')->toArray();
                $syncExists = array_unique(array_merge($userArray, $syncExists));
                $this->syncUserForFolder($child, $syncExists, $userDetach);
            }
        }
    }

    public function findFoldersViaUserShare()
    {
        return Auth::user()->userShareFolders()
            ->join(DB::raw('folders as parent'), 'folders.parent_id', 'parent.id')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('folder_share')
                    ->whereRaw('folder_share.folder_id = parent.id')
                    ->whereRaw('folder_share.user_id = ' . Auth::id());
            })->get();
    }

    public function findChildrenFolderExists($children)
    {
        return $children->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('folder_share')
                ->whereRaw('folder_share.folder_id = folders.id')
                ->whereRaw('folder_share.user_id = ' . Auth::id());
        })->get();
    }

    public function findFoldersOfParentFolder($folders)
    {
        return $folders->select('folders.*')
            ->join(DB::raw('folders as parent'), 'parent.id', 'folders.parent_id')
            ->orWhere('parent.deleted_at', '!=', null)
            ->orderBy('folders.created_at', 'desc')
            ->get();        return $folders->select('folders.*')
        ->join(DB::raw('folders as parent'), 'parent.id', 'folders.parent_id')
        ->orWhere('parent.deleted_at', '!=', null)
        ->orderBy('folders.created_at', 'desc')
        ->get();
    }
}
