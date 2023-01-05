<?php

namespace App\Nottes\Application\Folder\Delete;
use App\Shared\Application\ApplicationServiceResponse;

class FolderDeleterResponse implements ApplicationServiceResponse
{
    public function __construct()
    {
    }

    public function getResponse(): array
    {
        return [];
    }
}
