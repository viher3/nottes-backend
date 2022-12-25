<?php

namespace App\Nottes\Application\Folder\FolderContent;

class FolderContentSearcherQuery
{
    public function __construct(
        private string $folderId
    )
    {
    }

    /**
     * @return string
     */
    public function getFolderId(): string
    {
        return $this->folderId;
    }
}
