<?php

namespace App\Shared\Infrastructure\Persistence\Doctrine;

use Symfony\Component\Uid\Uuid;
use Doctrine\DBAL\Platforms\AbstractPlatform;

abstract class DoctrineUuidType extends DoctrineType
{
    /**
     * @return string
     */
    abstract protected function getFQCN(): string;

    /**
     * @param array $column
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $column['length'] = 16;
        $column['fixed']  = true;
        return $platform->getBinaryTypeDeclarationSQL($column);
    }

    /**
     * @param $value
     * @param AbstractPlatform $platform
     * @return object|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?object
    {
        if ($value === null) {
            return null;
        }
        $className = $this->getFQCN();
        return new $className(Uuid::fromBinary($value)->toRfc4122());
    }

    /**
     * @param $value
     * @param AbstractPlatform $platform
     * @return string|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }
        $uuid = (is_object($value)) ? $value->value() : $value;
        return Uuid::fromString($uuid)->toBinary();
    }
}
