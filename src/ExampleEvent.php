<?php

namespace Drupal\example_events;

use Symfony\Component\EventDispatcher\Event;


class ExampleEvent extends Event {

  const SUBMIT = 'event.submit';

  protected $referenceID;

  public function __construct($referenceID)
  {
    $this->referenceID = $referenceID;
  }

  public function getReferenceID()
  {
    return $this->referenceID;
  }

  public function myEventDescription() {
    return "This is as an example event";
  }

}