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
        $folder = new Folder(
            FolderId::random(),
            $request->getName(),
            $request->getParent(),
            $request->getDescription()
        );

        $this->folderRepository->save($folder);

        return new FolderCreatorResponse();
    }
}
