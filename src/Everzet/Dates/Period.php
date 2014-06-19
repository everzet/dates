<?php

namespace Everzet\Dates;

use DateTime;

final class Period
{
    private $month;
    private $year;

    public function __construct(Month $month, Year $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function getMonth()
    {
        return $this->month;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function next()
    {
        if (12 === $this->month->toNumber()) {
            $month = Month::fromNumber(1);
            $year = $this->year->next();
        } else {
            $month = $this->month->next();
            $year = $this->year;
        }

        return new self($month, $year);
    }

    public function previous()
    {
        if (1 === $this->month->toNumber()) {
            $month = Month::fromNumber(12);
            $year = $this->year->previous();
        } else {
            $month = $this->month->previous();
            $year = $this->year;
        }

        return new self($month, $year);
    }

    public function getEndDate()
    {
        $time = sprintf('%d.%d', $this->month->toNumber(), $this->year->toNumber());
        $day = (int) DateTime::createFromFormat('n.Y', $time)->format('t');

        return new Date($day, $this);
    }

    public function toNumber()
    {
        return $this->year->toNumber() * 12 + $this->month->toNumber();
    }

    public function __toString()
    {
        return sprintf('%s %d', $this->month->toName(), $this->year->toNumber());
    }
}
