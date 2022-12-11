<?php

declare(strict_types=1);

namespace App\Nottes\Infrastructure\Folder\Persistence\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Symfony\Bridge\Doctrine\Types\AbstractUidType;

final class DoctrineFolderId extends AbstractUidType
{
    private const MY_TYPE = 'FolderId';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return parent::convertToDatabaseValue($value->value(), $platform);
    }

    public function getName(): string
    {
        return self::MY_TYPE;
    }

    protected function getUidClass(): string
    {
        return FolderId::class;
    }
}
