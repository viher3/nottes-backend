<?php

namespace App\Nottes\Application\Folder\FolderContent;

use App\Nottes\Domain\Folder\Folder;
use App\Nottes\Domain\Text\Text;
use App\Shared\Domain\Aggregate\AggregateRoot;
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
        $folderContentResponse = map(function($contentItem){
            return [
                'id' => $contentItem->getId(),
                'name' => $contentItem->getName(),
                'type' => self::getTypeByClass($contentItem),
                'updatedAt' => $contentItem->getUpdatedAt()->format('d/m/Y H:i:s')
            ];
        }, $folderContent);

        return new self($folderContentResponse);
    }

    public static function getTypeByClass(AggregateRoot $aggregateRoot) : string
    {
        if($aggregateRoot instanceof Folder){
            return 'folder';
        }

        if($aggregateRoot instanceof Text){
            return 'text';
        }

        return 'unknown';
    }

    /**
     * @return array
     */
    public function getFolderContent(): array
    {
        return $this->folderContent;
    }
}
