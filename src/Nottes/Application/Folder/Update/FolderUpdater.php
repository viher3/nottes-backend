<?php

namespace App\Nottes\Application\Folder\Update;

use App\Nottes\Domain\Folder\FolderId;
use App\Nottes\Domain\Folder\FolderNotFound;
use App\Nottes\Domain\Folder\FolderRepository;

class FolderUpdater
{
    public function __construct(
        private FolderRepository $folderRepository
    )
    {
    }

    /**
     * @param FolderUpdaterCommand $command
     * @return FolderUpdaterResponse
     * @throws FolderNotFound
     */
    public function execute(FolderUpdaterCommand $command) : FolderUpdaterResponse
    {
        $folder = $this->folderRepository->find(new FolderId($command->getId()));

        if(!$folder){
            throw new FolderNotFound($command->getId());
        }

        $folder->update($command->getBody());
        $this->folderRepository->save($folder);

        return new FolderUpdaterResponse();
    }
}
