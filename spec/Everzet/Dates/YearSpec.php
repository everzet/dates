<?php

namespace spec\Everzet\Dates;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class YearSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('fromNumber', [2014]);
    }

    function it_can_be_constructed_from_number()
    {
        $this->toNumber()->shouldReturn(2014);
    }

    function it_accepts_only_integers_as_number_constructor()
    {
        $this->shouldThrow('InvalidArgumentException')->during('fromNumber', ['string']);
    }

    function it_accepts_only_non_zero_positive_integers_as_a_number_constructor()
    {
        $this->shouldThrow('InvalidArgumentException')->during('fromNumber', ['string']);
    }

    function it_accepts_stringed_numbers()
    {
        $this->beConstructedThrough('fromNumber', ['2014']);
        $this->toNumber()->shouldReturn(2014);
    }

    function it_can_tell_previous_year()
    {
        $this->previous()->toNumber()->shouldReturn(2013);
    }

    function it_can_tell_the_next_year()
    {
        $this->next()->toNumber()->shouldReturn(2015);
    }
}
