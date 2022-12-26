<?php

namespace App\Nottes\Application\Folder\SearchByCriteria;

use App\Shared\Domain\Criteria\Order;
use App\Shared\Domain\Criteria\Filter;
use App\Shared\Domain\Criteria\Filters;
use App\Shared\Domain\Criteria\Criteria;
use App\Shared\Domain\Criteria\FilterField;
use App\Shared\Domain\Criteria\FilterValue;
use App\Shared\Domain\Criteria\FilterOperator;
use App\Nottes\Domain\Folder\FolderRepository;

final class SearchFolderByCriteriaSearcher
{
    /**
     * @param FolderRepository $folderRepository
     */
    public function __construct(
        private FolderRepository $folderRepository
    )
    {
    }

    /**
     * @param SearchFolderByCriteriaSearcherQuery $query
     * @return SearchFolderByCriteriaSearcherResponse
     */
    public function execute(SearchFolderByCriteriaSearcherQuery $query): SearchFolderByCriteriaSearcherResponse
    {
        $filters = Filters::fromValues($query->filters());

        // If parent folder is not selected, return root folder content.
        if (!$filters->hasKey('parent')) {
            $parentFolder = $this->folderRepository->findRoot();
            $filters = $filters->add(
                new Filter(
                    new FilterField('parent'),
                    new FilterOperator(FilterOperator::EQUAL),
                    new FilterValue($parentFolder->getId())
                )
            );
        }

        $criteria = new Criteria(
            $filters,
            Order::fromValues($query->orderBy(), $query->order()),
            $query->offset(),
            $query->limit()
        );

        $folders = $this->folderRepository->matching($criteria);

        return SearchFolderByCriteriaSearcherResponse::create($folders);
    }
}
