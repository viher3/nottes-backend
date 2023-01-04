<?php

namespace App\Nottes\Domain\Folder\Services;

use App\Nottes\Domain\Folder\Folder;
use App\Nottes\Domain\Folder\FolderId;
use App\Nottes\Domain\Folder\FolderRepository;

final class FolderBreadcrumbGenerator
{
    public function __construct(
        private readonly FolderRepository $folderRepository
    )
    {
    }

    /**
     * @param Folder $folder
     * @return array
     */
    public function execute(Folder $folder) : array
    {
        $breadcrumb[] = [
            'id' => $folder->getId(),
            'name' => $folder->getName()
        ];

        $parent = $folder->getParent();

        if(!$parent){
            return $breadcrumb;
        }

        while(true)
        {
            $parentId = $parent instanceof Folder ? $parent->getId() : $parent;

            if(!$parentId) {
                break;
            }

            $parent = $this->folderRepository->find(new FolderId($parentId));

            $breadcrumb[] = [
                'id' => $parent->getId(),
                'name' => $parent->getName()
            ];

            $parent = $this->getParent($parent);

            $lastKey = count($breadcrumb) - 1;
            $lastBreadcrumbItem = $breadcrumb[$lastKey];
            $parentId = $parent instanceof Folder ? $parent->getId() : $parent;

            if($lastBreadcrumbItem['id'] === $parentId) {
                break;
            }
        }

        return array_reverse($breadcrumb);
    }

    /**
     * @param Folder $folder
     * @return Folder|null
     */
    private function getParent(Folder $folder) : ?Folder
    {
        if(!$folder->getParent()) {
            return null;
        }

        return $this->folderRepository->find(new FolderId($folder->getParent()));
    }
}
