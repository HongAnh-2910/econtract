<?php

namespace App\Repositories\File;

interface FileRepositoryInterface
{
    public function create($request);

    public function delete($id);

    public function findFilename($id);

    public function forceDelete($id);

    public function restore($id);

    public function findWhere($where);

    public function attachUser($fileId, $user);

    public function syncUser($fileId, $userArray);
}
