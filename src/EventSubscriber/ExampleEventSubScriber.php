<?php

/**
 * @file
 * Contains \Drupal\example_events\ExampleEventSubScriber.
 */

namespace Drupal\example_events\EventSubscriber;

use Drupal\Core\Config\ConfigCrudEvent;
use Drupal\Core\Config\ConfigEvents;
use Drupal\example_events\ExampleEvent;
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
    $events[ConfigEvents::SAVE][] = array('onSavingConfig', 800);
    $events[ExampleEvent::SUBMIT][] = array('doSomeAction', 800);
    return $events;

  }

  /**
   * Subscriber Callback for the event.
   * @param ExampleEvent $event
   */
  public function doSomeAction(ExampleEvent $event) {
    drupal_set_message("The Example Event has been subscribed, which has bee dispatched on submit of the form with " . $event->getReferenceID() . " as Reference");
  }

  /**
   * Subscriber Callback for the event.
   * @param ConfigCrudEvent $event
   */
  public function onSavingConfig(ConfigCrudEvent $event) {
    drupal_set_message("You have saved a configuration of " . $event->getConfig()->getName());
  }
}
