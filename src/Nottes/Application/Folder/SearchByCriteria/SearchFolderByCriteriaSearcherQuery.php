<?php

namespace App\Nottes\Application\Folder\SearchByCriteria;

final class SearchFolderByCriteriaSearcherQuery
{
    /**
     * @param array $filters
     * @param string|null $orderBy
     * @param string|null $order
     * @param int|null $limit
     * @param int|null $offset
     */
    public function __construct(
        private array $filters,
        private ?string $orderBy = null,
        private ?string $order = null,
        private ?int $limit = null,
        private ?int $offset = null
    ) {
    }

    public function filters(): array
    {
        return $this->filters;
    }

    public function orderBy(): ?string
    {
        return $this->orderBy;
    }

    public function order(): ?string
    {
        return $this->order;
    }

    public function limit(): ?int
    {
        return $this->limit;
    }

    public function offset(): ?int
    {
        return $this->offset;
    }
}
