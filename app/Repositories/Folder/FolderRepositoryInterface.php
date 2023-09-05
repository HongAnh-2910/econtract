<?php

namespace App\Repositories\Folder;

interface FolderRepositoryInterface
{
    public function create($request);

    public function show($id);

    public function showParentFolder($owner_id, $parent_id);

    public function findFolderByUserAndSlug($slug);

    public function delete($id);
}
