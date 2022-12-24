<?php

namespace App\Nottes\Application\Folder\SearchByCriteria;

use App\Nottes\Domain\Folder\Folder;
use function Lambdish\Phunctional\map;
use const Lambdish\Phunctional\map;

class SearchFolderByCriteriaSearcherResponse
{
    private function __construct(
        private array $folders
    )
    {
    }

    /**
     * @param array $folderCollection
     * @return static
     */
    public static function create(array $folderCollection): self
    {
        $folders = map(function (Folder $folder){
            return [
                'id' => $folder->getId(),
                'name' => $folder->getName(),
                'description' => $folder->getDescription(),
                'updatedAt' => $folder->getUpdatedAt()->format('d/m/Y H:i:s'),
            ];
        }, $folderCollection);

        return new self($folders);
    }

    /**
     * @return array
     */
    public function getFolders(): array
    {
        return $this->folders;
    }
}
