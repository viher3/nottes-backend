<?php

namespace App\Nottes\Application\Folder\Creator;

use App\Nottes\Domain\Folder\Folder;
use App\Nottes\Domain\Folder\FolderId;
use App\Nottes\Domain\Folder\FolderNotFound;
use App\Nottes\Domain\Folder\FolderRepository;

final class FolderCreator
{
    private FolderRepository $folderRepository;

    public function __construct(FolderRepository $folderRepository)
    {
        $this->folderRepository = $folderRepository;
    }

    /**
     * @param FolderCreatorCommand $command
     * @return FolderCreatorResponse
     * @throws FolderNotFound
     */
    public function execute(FolderCreatorCommand $command) : FolderCreatorResponse
    {
        $parentFolderId = new FolderId($command->getParent());
        $parentFolder = $this->folderRepository->find($parentFolderId);

        if(!$parentFolder){
            throw new FolderNotFound($parentFolderId, true);
        }

        $folder = Folder::create(
            FolderId::random(),
            $command->getName(),
            $parentFolderId,
            $command->getDescription()
        );

        $this->folderRepository->save($folder);

        return new FolderCreatorResponse();
    }
}
