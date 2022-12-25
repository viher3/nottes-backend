<?php

namespace App\Nottes\Domain\Folder;

class FolderNotFound extends \Exception
{
    /**
     * @param string $id
     * @param bool $isParent
     */
    public function __construct(string $id, bool $isParent= false)
    {
        $prefix = ($isParent) ? 'Parent folder' : 'Folder';
        parent::__construct($prefix . ' ' . $id . ' not found');
    }
}
