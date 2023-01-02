<?php

namespace App\Nottes\Application\Folder\FolderContent;

use App\Nottes\Domain\Folder\Folder;
use App\Nottes\Domain\Folder\FolderId;
use App\Nottes\Domain\Folder\FolderRepository;
use App\Nottes\Domain\Text\TextRepository;
use App\Shared\Domain\Criteria\Criteria;
use App\Shared\Domain\Criteria\Filter;
use App\Shared\Domain\Criteria\FilterField;
use App\Shared\Domain\Criteria\FilterOperator;
use App\Shared\Domain\Criteria\Filters;
use App\Shared\Domain\Criteria\FilterValue;
use App\Shared\Domain\Criteria\Order;
use App\Shared\Domain\Criteria\OrderBy;
use App\Shared\Domain\Criteria\OrderType;

class FolderContentSearcher
{
    public function __construct(
        private FolderRepository $folderRepository,
        private TextRepository   $textRepository
    )
    {
    }

    /**
     * @param FolderContentSearcherQuery $query
     * @return FolderContentSearcherResponse
     */
    public function execute(FolderContentSearcherQuery $query): FolderContentSearcherResponse
    {
        $folderContentCollection = [];
        $folderId = $query->getFolderId() ? new FolderId($query->getFolderId()) : null;

        if(!$folderId){
            $folderRoot = $this->folderRepository->findRoot();
            $folderId = new FolderId($folderRoot->getId());
        }

        /**
         * Get current folder
         * @var Folder $currentFolder
         */
        $currentFolder = $folderRoot ?? $this->folderRepository->find($folderId);

        // Get child folders
        $childFoldersCriteria = new Criteria(
            (new Filters([]))->add(
                new Filter(
                    new FilterField('parent'),
                    new FilterOperator(FilterOperator::EQUAL),
                    new FilterValue($folderId->value())
                )
            ),
            new Order(
                new OrderBy('name'),
                new OrderType(OrderType::ASC)
            ),
            null,
            null
        );

        $childFolders = $this->folderRepository->matching($childFoldersCriteria);

        $folderContentCollection = array_merge($folderContentCollection, $childFolders);

        // Get other content type in the folder
        $parentFolderCriteria = new Criteria(
            (new Filters([]))->add(
                new Filter(
                    new FilterField('folder'),
                    new FilterOperator(FilterOperator::EQUAL),
                    new FilterValue($folderId->value())
                )
            ),
            new Order(
                new OrderBy('name'),
                new OrderType(OrderType::ASC)
            ),
            null,
            null
        );

        $childFolderContent = $this->textRepository->matching($parentFolderCriteria);
        $folderContentCollection = array_merge($folderContentCollection, $childFolderContent);

        return FolderContentSearcherResponse::create(
            $this->folderRepository,
            $currentFolder,
            $folderContentCollection
        );
    }
}
