<?php

namespace spec\Everzet\Dates;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MonthSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('fromNumber', [3]);
    }

    function it_can_be_constructed_from_month_number()
    {
        $this->beConstructedThrough('fromNumber', [2]);

        $this->toNumber()->shouldReturn(2);
    }

    function it_can_not_be_constructed_with_number_less_than_1()
    {
        $this->beConstructedThrough('fromNumber', [2]);
        $this->shouldThrow('InvalidArgumentException')->during('fromNumber', [0]);
    }

    function it_can_not_be_constructed_with_number_more_than_12()
    {
        $this->beConstructedThrough('fromNumber', [2]);
        $this->shouldThrow('InvalidArgumentException')->during('fromNumber', [13]);
    }

    function it_can_be_constructed_from_month_name()
    {
        $this->beConstructedThrough('fromName', ['February']);

        $this->toNumber()->shouldReturn(2);
    }

    function it_can_present_itself_as_a_month_name()
    {
        $this->toName()->shouldReturn('March');
    }

    function it_can_return_next_month()
    {
        $this->next()->toNumber()->shouldReturn(4);
    }

    function it_can_not_return_next_month_if_current_month_is_december()
    {
        $this->beConstructedThrough('fromNumber', [12]);
        $this->shouldThrow('LogicException')->duringNext();
    }

    function it_can_return_previous_month()
    {
        $this->previous()->toNumber()->shouldReturn(2);
    }

    function it_can_not_return_previous_month_if_current_month_is_january()
    {
        $this->beConstructedThrough('fromNumber', [1]);
        $this->shouldThrow('LogicException')->duringPrevious();
    }
}
