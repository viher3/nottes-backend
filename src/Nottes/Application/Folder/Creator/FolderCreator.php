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
     * @param FolderCreatorRequest $request
     * @return void
     */
    public function execute(FolderCreatorRequest $request) : FolderCreatorResponse
    {
        $parentFolderId = $request->getParent() ? new FolderId($request->getParent()) : null;
        $parentFolder = $parentFolderId ? $this->folderRepository->find($parentFolderId) : null;

        $folder = Folder::create(
            FolderId::random(),
            $request->getName(),
            $parentFolder,
            $request->getDescription()
        );

        $this->folderRepository->save($folder);

        return new FolderCreatorResponse();
    }
}
