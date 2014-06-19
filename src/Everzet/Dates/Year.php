<?php

namespace Everzet\Dates;

use InvalidArgumentException;

final class Year
{
    private $number;

    private function __construct($number)
    {
        $this->number = $number;
    }

    public static function fromNumber($number)
    {
        $number = intval($number);
        if ($number < 1) {
            throw new InvalidArgumentException(sprintf(
                '`%d` is not a valid year number.',
                $number
            ));
        }

        return new self($number);
    }

    public function previous()
    {
        return new self($this->number - 1);
    }

    public function next()
    {
        return new self($this->number + 1);
    }

    public function toNumber()
    {
        return $this->number;
    }
}
