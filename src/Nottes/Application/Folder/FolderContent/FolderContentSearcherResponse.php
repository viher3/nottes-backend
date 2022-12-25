<?php

namespace App\Nottes\Application\Folder\FolderContent;

use function Lambdish\Phunctional\map;

class FolderContentSearcherResponse
{
    /**
     * @param array $folderContent
     */
    public function __construct(
        private array $folderContent
    )
    {
    }

    /**
     * @return static
     */
    public static function create(array $folderContent) : self
    {
        $folderContentResponse = [];

        map(function($folderContentItem) use ($folderContentResponse){
            $folderContentResponse[] = [
                'id' => $folderContentItem->getId(),
                'name' => $folderContentItem->getName()
            ];
        }, $folderContent);

        return new self($folderContentResponse);
    }

    /**
     * @return array
     */
    public function getFolderContent(): array
    {
        return $this->folderContent;
    }
}
