<?php

namespace App\Nottes\Domain\Folder;

class FolderNotFound extends \Exception
{
    public function __construct(string $id)
    {
        parent::__construct('Folder ' . $id . ' not found');
    }
}
