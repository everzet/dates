<?php

namespace spec\Everzet\Dates;

use Everzet\Dates\Month;
use Everzet\Dates\Year;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PeriodSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(Month::fromName('February'), Year::fromNumber(2014));
    }

    function it_combines_month_and_a_year()
    {
        $this->getMonth()->shouldBeLike(Month::fromNumber(2));
        $this->getYear()->shouldBeLike(Year::fromNumber(2014));
    }

    function it_can_present_itself_as_a_number()
    {
        $this->toNumber()->shouldReturn(2014 * 12 + 2);
    }

    function it_can_present_itself_as_a_string()
    {
        $this->__toString()->shouldReturn('February 2014');
    }

    function it_can_tell_the_next_period()
    {
        $next = $this->next();

        $next->getMonth()->shouldBeLike(Month::fromNumber(3));
        $next->getYear()->shouldBeLike(Year::fromNumber(2014));
    }

    function it_can_tell_the_next_period_even_if_it_is_in_the_next_year()
    {
        $this->beConstructedWith(Month::fromName('December'), Year::fromNumber(2014));

        $next = $this->next();

        $next->getMonth()->shouldBeLike(Month::fromNumber(1));
        $next->getYear()->shouldBeLike(Year::fromNumber(2015));
    }

    function it_can_tell_the_previous_period()
    {
        $next = $this->previous();

        $next->getMonth()->shouldBeLike(Month::fromNumber(1));
        $next->getYear()->shouldBeLike(Year::fromNumber(2014));
    }

    function it_can_tell_the_previous_period_even_if_it_is_in_the_previous_year()
    {
        $this->beConstructedWith(Month::fromName('January'), Year::fromNumber(2014));

        $next = $this->previous();

        $next->getMonth()->shouldBeLike(Month::fromNumber(12));
        $next->getYear()->shouldBeLike(Year::fromNumber(2013));
    }

    function it_can_tell_the_end_date()
    {
        $this->beConstructedWith(Month::fromName('June'), Year::fromNumber(2014));
        $date = $this->getEndDate();

        $date->getDay()->shouldReturn(30);
        $date->getPeriod()->shouldReturn($this);
    }
}
