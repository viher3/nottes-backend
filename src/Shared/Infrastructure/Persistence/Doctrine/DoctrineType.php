<?php

namespace App\Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

abstract class DoctrineType extends Type
{
    abstract protected function getFQCN(): string;

    public function getName(): string
    {
        return $this->getTypeName();
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }
        $className = $this->getFQCN();
        return new $className($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (is_object($value)) ? $value->value() : $value;
    }

    protected function getTypeName(): string
    {
        $explode = explode("\\", $this->getFQCN());
        return $explode[count($explode) - 1];
    }
}
