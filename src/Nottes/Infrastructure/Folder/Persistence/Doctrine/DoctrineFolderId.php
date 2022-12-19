<?php

declare(strict_types=1);

namespace App\Nottes\Infrastructure\Folder\Persistence\Doctrine;

use App\Nottes\Domain\Folder\FolderId;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineStringType;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineUuidType;

final class DoctrineFolderId extends DoctrineStringType
{
    protected function getFQCN(): string
    {
        return FolderId::class;
    }
}
