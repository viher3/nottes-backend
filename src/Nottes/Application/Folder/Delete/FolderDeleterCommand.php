<?php

namespace App\Nottes\Application\Folder\Delete;

use App\Shared\Application\ApplicationServiceRequest;
class FolderDeleterCommand implements ApplicationServiceRequest
{
    public function __construct(
        private string $id
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
}
