<?php

namespace App\Nottes\Application\Folder\Delete;

use App\Nottes\Domain\Folder\FolderId;
use App\Nottes\Domain\Folder\FolderNotFound;
use App\Nottes\Domain\Folder\FolderRepository;

class FolderDeleter
{
    public function __construct(
        private FolderRepository $folderRepository
    )
    {
    }

    /**
     * @param FolderDeleterCommand $command
     * @return FolderDeleterResponse
     * @throws FolderNotFound
     */
    public function execute(FolderDeleterCommand $command) : FolderDeleterResponse
    {
        $folder = $this->folderRepository->find(new FolderId($command->getId()));

        if(!$folder){
            throw new FolderNotFound($command->getId());
        }

        $folder->delete();
        $this->folderRepository->save($folder);

        return new FolderDeleterResponse();
    }
}
