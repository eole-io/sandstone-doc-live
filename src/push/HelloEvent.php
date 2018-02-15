<?php

use Symfony\Component\EventDispatcher\Event;

class HelloEvent extends Event
{
    public $name;
}
