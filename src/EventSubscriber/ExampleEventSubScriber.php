<?php

/**
 * @file
 * Contains \Drupal\example_events\ExampleEventSubScriber.
 */

namespace Drupal\example_events\EventSubscriber;

use Drupal\Core\Config\ConfigCrudEvent;
use Drupal\Core\Config\ConfigEvents;
use Drupal\example_events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ExampleEventSubScriber.
 *
 * @package Drupal\example_events
 */
class ExampleEventSubScriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[ConfigEvents::SAVE][] = array('sayHello', 800);
    $events['example.submit'][] = array('sayHello2', 800);
    return $events;

  }

  public function sayHello(ConfigCrudEvent $event) {
    drupal_set_message("Manoj");
  }

  public function sayHello2() {
    drupal_set_message("Rakesh");
  }
}
