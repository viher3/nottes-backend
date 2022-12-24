<?php

namespace App\Nottes\Application\Folder\SearchByCriteria;

use App\Nottes\Domain\Folder\FolderRepository;
use App\Shared\Domain\Criteria\Order;
use App\Shared\Domain\Criteria\Filters;
use App\Shared\Domain\Criteria\Criteria;

final class SearchFolderByCriteriaSearcher
{
    public function __construct(
        private FolderRepository $folderRepository
    )
    {
    }

    /**
     * @param SearchFolderByCriteriaSearcherQuery $query
     * @return SearchFolderByCriteriaSearcherResponse
     */
    public function execute(SearchFolderByCriteriaSearcherQuery $query) : SearchFolderByCriteriaSearcherResponse
    {
        $criteria = new Criteria(
            Filters::fromValues($query->filters()),
            Order::fromValues($query->orderBy(), $query->order()),
            $query->offset(),
            $query->limit()
        );

        $folders = $this->folderRepository->matching($criteria);

        return SearchFolderByCriteriaSearcherResponse::create($folders);
    }
}
