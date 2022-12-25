<?php

namespace App\Nottes\Application\Folder\FolderContent;

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
        private TextRepository $textRepository
    )
    {
    }

    /**
     * @param FolderContentSearcherQuery $query
     * @return FolderContentSearcherResponse
     */
    public function execute(FolderContentSearcherQuery $query) : FolderContentSearcherResponse
    {
        $folderContentCollection = [];
        $folderId = new FolderId($query->getFolderId());

        // Get child folders
        $childFoldersCriteria = new Criteria(
            (new Filters([]))->add(
                new Filter(
                    new FilterField('parent_id'),
                    new FilterOperator(FilterOperator::EQUAL),
                    new FilterValue($folderId->value())
                )
            ),
            new Order(
                new OrderBy('asc'),
                new OrderType(OrderType::ASC)
            ),
            null,
            null
        );

        $childFolders = $this->folderRepository->matching($childFoldersCriteria);
        $folderContentCollection = array_merge($folderContentCollection, $childFolders);

        // Get other content type in the folder
        $childFolderContent = $this->textRepository->matching($childFoldersCriteria);
        $folderContentCollection = array_merge($folderContentCollection, $childFolderContent);

        return FolderContentSearcherResponse::create($folderContentCollection);
    }
}
