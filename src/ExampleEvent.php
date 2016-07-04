<?php

namespace Drupal\example_events;

use Symfony\Component\EventDispatcher\Event;


class ExampleEvent extends Event {

  public function myEventDescription() {
    return "This is test event";
  }

}