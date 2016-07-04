<?php

/**
 * @file
 * Contains \Drupal\example_events\Form\DemoEventDispatchForm.
 */

namespace Drupal\example_events\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\example_events\ExampleEvent;

/**
 * Class DemoEventDispatchForm.
 *
 * @package Drupal\example_events\Form
 */
class DemoEventDispatchForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'demo_event_dispatch_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#description' => $this->t('Name'),
      '#maxlength' => 64,
      '#size' => 64,
    );
    $form['dispatch'] = array(
      '#type' => 'submit',
      '#title' => $this->t('Dispatch'),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $dispatcher = \Drupal::service('event_dispatcher');
    $e = new ExampleEvent();
    drupal_set_message($e->myEventDescription());
    $event = $dispatcher->dispatch('example.submit', $e);
  }

}
