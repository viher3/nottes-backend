<?php

namespace App\Shared\Application\Response;

class ListResponse
{
    private array $items;
    private int $total;

    /**
     * @param array $items
     * @param int $total
     */
    public function __construct(array $items, int $total)
    {
        $this->items = $items;
        $this->total = $total;
    }

    /**
     * @return array
     */
    public function items(): array
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function total(): int
    {
        return $this->total;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return [
            'items' => $this->items,
            'totalRecords' => $this->total,
            'totalItems' => count($this->items)
        ];
    }
}
