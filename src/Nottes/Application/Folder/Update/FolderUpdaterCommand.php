<?php

namespace App\Nottes\Application\Folder\Update;

use App\Shared\Application\ApplicationServiceRequest;

class FolderUpdaterCommand implements ApplicationServiceRequest
{
    /**
     * @param string $id
     * @param array $body
     */
    public function __construct(
        private string $id,
        private array $body
    )
    {
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getBody(): array
    {
        return $this->body;
    }
}
