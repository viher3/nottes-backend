<?php

namespace App\Shared\Domain;

use App\Shared\Domain\ValueObject\DateValueObject;

class DateTime extends DateValueObject
{
    /**
     * @param \DateTimeInterface $dateTime
     * @return static
     */
    public static function create(\DateTimeInterface $dateTime): self
    {
        return new self($dateTime);
    }
}
