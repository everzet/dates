<?php

namespace Everzet\Dates;

use DateTime;
use InvalidArgumentException;

final class Date
{
    private $day;
    private $period;

    public function __construct($day, Period $period)
    {
        $this->day = $day;
        $this->period = $period;

        $actualMonth = (int) date('n', $this->toTimestamp());
        $actualDay = (int) date('d', $this->toTimestamp());
        $actualYear = (int) date('Y', $this->toTimestamp());

        if ($actualDay !== $day
            || $actualMonth !== $period->getMonth()->toNumber()
            || $actualYear !== $period->getYear()->toNumber()
        ) {
            throw new InvalidArgumentException(sprintf(
                'Provided date is invalid: `%d.%d.%d`.',
                $day,
                $period->getMonth()->toNumber(),
                $period->getYear()->toNumber()
            ));
        }
    }

    public function getDay()
    {
        return $this->day;
    }

    public function getPeriod()
    {
        return $this->period;
    }

    public function toTimestamp()
    {
        return $this->getDateTime()->getTimestamp();
    }

    public function toWeekdayNumber()
    {
        return (int) $this->getDateTime()->format('N');
    }

    public function previous()
    {
        if (1 === $this->day) {
            return $this->period->previous()->getEndDate();
        }

        return new self($this->day - 1, $this->period);
    }

    public function next()
    {
        if ($this->period->getEndDate() == $this) {
            return new self(1, $this->period->next());
        }

        return new self($this->day + 1, $this->period);
    }

    private function getDateTime()
    {
        $time = sprintf(
            '%d.%d.%d',
            $this->day,
            $this->period->getMonth()->toNumber(),
            $this->period->getYear()->toNumber()
        );

        return DateTime::createFromFormat('d.n.Y', $time);
    }
}
