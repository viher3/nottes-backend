<?php

namespace App\Shared\Domain\ValueObject;

abstract class DateValueObject
{
    protected $value;

    public function __construct(\DateTimeInterface $value)
    {
        $this->value = $value;
    }

    public function value(): \DateTimeInterface
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value()->format('Y-m-d H:i:s');
    }

    public function toDateTimeString() : string
    {
        return $this->value()->format('d/m/Y H:i:s');
    }
}
