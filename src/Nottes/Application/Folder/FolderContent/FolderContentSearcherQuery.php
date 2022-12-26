<?php

namespace App\Nottes\Application\Folder\FolderContent;

class FolderContentSearcherQuery
{
    public function __construct(
        private ?string $folderId = null
    )
    {
    }

    /**
     * @return string|null
     */
    public function getFolderId(): ?string
    {
        return $this->folderId;
    }
}
