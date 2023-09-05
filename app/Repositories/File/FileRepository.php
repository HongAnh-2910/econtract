<?php

namespace App\Repositories\File;

use App\Models\File;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FileRepository implements FileRepositoryInterface
{
    protected $file;

    /**
     * FileRepositories constructor.
     *
     * @param File $file
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }

    /**
     * Create a new file
     * @param $request
     *
     * @return mixed
     */
    public function create($request)
    {
        // TODO: Implement create() method.

        return $this->file->create($request);
    }

    /**
     * @param $id
     *
     * @return bool|null
     * @throws mixed
     */
    public function delete($id)
    {
        // TODO: Implement delete() method.
        $file = $this->file->findOrFail($id);

        $file->file_soft_deleted = 'file_' . $file->slug;
        $file->save();
        return $file->delete();
    }

    /**
     * @param $where
     * @return mixed
     */
    public function findWhere($where)
    {
        return $this->file->where($where)->get();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function forceDelete($id)
    {
        $file = $this->file->withTrashed()->where('id', $id)->firstOrFail();
        $path = storage_path() . '/' . 'uploads/' . $file->name;

        if (file_exists($path)) {
            unlink($path);
        }

        $file->forceDelete();
        return true;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function findFilename($id)
    {
        // TODO: Implement find() method.
        return $this->file->findOrFail($id)->name;
    }

    /**
     * @param $id
     *
     * @return bool|null
     */
    public function restore($id)
    {
        // TODO: Implement restore() method.
        $file = $this->file->withTrashed()->where('id', $id)->firstOrFail();

        $file->file_soft_deleted = null;
        $file->save();
        return $file->restore();
    }


    /**
     * @param $fileId
     * @param $user
     */
    public function attachUser($fileId, $user)
    {
        $this->file->findOrFail($fileId)->userFile()->attach($user);
    }

    /**
     * @param $fileId
     * @param $userArray
     */
    public function syncUser($fileId, $userArray)
    {
        $this->file->findOrFail($fileId)->userFile()->sync($userArray);
    }

    public function findFileByFolderSlug(User $user, Folder $folder)
    {
        return $this->file::where('folder_id', '=', $folder->id)
            ->where('user_id', '=', $user->id)
            ->get();
    }

    /**
     * @param User $user
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function findFileOnTrash(User $user)
    {
        return $this->file::onlyTrashed()->select('files.*')->join('folders', 'folders.id', 'files.folder_id')
            ->where('files.user_id', $user->id)->whereRaw('(folders.parent_id is null OR folders.deleted_at is null OR folders.folder_soft_deleted != files.file_soft_deleted)')
            ->orderByDesc('files.deleted_at')
            ->paginate(15);
    }

    public function findFilesOnShare($files = null)
    {
        if (!$files) {
            return Auth::user()
                ->files()
                ->join('folders', 'folders.id', 'files.folder_id')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('folder_share')
                        ->whereRaw('folder_share.folder_id = folders.id')
                        ->whereRaw('folder_share.user_id = ' . Auth::id());
                })->paginate();
        } else {
            return $files->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('file_share')
                    ->whereRaw('file_share.file_id = files.id')
                    ->whereRaw('file_share.user_id = ' . Auth::id());
            })->paginate();
        }
    }

    public function findFilesOnFolderOfUser($files)
    {
        return $files->select('files.*')
            ->join('folders', 'folders.id', 'files.folder_id')
            ->orWhere('folders.deleted_at', '!=', null)
            ->orderBy('files.created_at', 'desc')
            ->paginate();
    }
}
