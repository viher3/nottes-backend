<?php

namespace App\Nottes\Application\Folder\Creator;

use App\Nottes\Domain\Folder\Folder;
use App\Nottes\Domain\Folder\FolderId;
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
     */
    public function execute(FolderCreatorCommand $command) : FolderCreatorResponse
    {
        $parentFolderId = $command->getParent() ? new FolderId($command->getParent()) : null;
        $parentFolder = $parentFolderId ? $this->folderRepository->find($parentFolderId) : null;

        $folder = Folder::create(
            FolderId::random(),
            $command->getName(),
            $parentFolder,
            $command->getDescription()
        );

        $this->folderRepository->save($folder);

        return new FolderCreatorResponse();
    }
}
