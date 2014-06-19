<?php

namespace spec\Everzet\Dates;

use DateTime;
use Everzet\Dates\Month;
use Everzet\Dates\Period;
use Everzet\Dates\Year;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DateSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(15, new Period(Month::fromName('April'), Year::fromNumber(2013)));
    }

    function it_is_a_combination_of_day_and_period()
    {
        $this->getDay()->shouldReturn(15);
        $this->getPeriod()->shouldBeLike(new Period(Month::fromNumber(4), Year::fromNumber(2013)));
    }

    function it_can_not_be_constructed_with_incorrect_date()
    {
        $this->shouldThrow('InvalidArgumentException')->during(
            '__construct',
            [
                32,
                new Period(Month::fromNumber(4), Year::fromNumber(2013))
            ]
        );
    }

    function it_can_tell_the_timestamp()
    {
        $this->toTimestamp()->shouldReturn(
            DateTime::createFromFormat('d.m.Y', '15.04.2013')->getTimestamp()
        );
    }

    function it_can_tell_previous_date()
    {
        $previous = $this->previous();

        $previous->getDay()->shouldReturn(14);
        $this->getPeriod()->__toString()->shouldReturn('April 2013');
    }

    function it_can_tell_previous_date_even_if_it_is_in_previous_month()
    {
        $this->beConstructedWith(1, new Period(Month::fromName('April'), Year::fromNumber(2014)));

        $previous = $this->previous();

        $previous->getDay()->shouldReturn(31);
        $previous->getPeriod()->__toString()->shouldReturn('March 2014');
    }

    function it_can_tell_next_date()
    {
        $previous = $this->next();

        $previous->getDay()->shouldReturn(16);
        $this->getPeriod()->__toString()->shouldReturn('April 2013');
    }

    function it_can_tell_next_date_even_if_it_is_in_next_month()
    {
        $this->beConstructedWith(30, new Period(Month::fromName('April'), Year::fromNumber(2014)));

        $previous = $this->next();

        $previous->getDay()->shouldReturn(1);
        $previous->getPeriod()->__toString()->shouldReturn('May 2014');
    }
}
