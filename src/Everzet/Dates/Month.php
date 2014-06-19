<?php

namespace Everzet\Dates;

use DateTime;
use InvalidArgumentException;
use LogicException;

final class Month
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
                'Month number can not be less than 1, but `%d` given.',
                $number
            ));
        }
        if ($number > 12) {
            throw new InvalidArgumentException(sprintf(
                'Month number can not be more than 12, but `%d` given.',
                $number
            ));
        }

        return new self($number);
    }

    public static function fromName($name)
    {
        $number = DateTime::createFromFormat('F', $name)->format('n');

        return self::fromNumber($number);
    }

    public function next()
    {
        if (12 === $this->number) {
            throw new LogicException('There is no other month after December.');
        }

        return self::fromNumber($this->number + 1);
    }

    public function previous()
    {
        if (1 === $this->number) {
            throw new LogicException('There is no other month before January.');
        }

        return self::fromNumber($this->number - 1);
    }

    public function toNumber()
    {
        return $this->number;
    }

    public function toName()
    {
        return DateTime::createFromFormat('n', $this->number)->format('F');
    }
}
