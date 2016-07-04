<?php

namespace Drupal\example_events\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\InsertCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountProxy;
use Drupal\taxonomy\TermStorageInterface;
use Drupal\user\PrivateTempStoreFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\taxonomy\Entity\Term;

/**
 * Class QuickSearchForm.
 *
 * @package Drupal\quick_search\Form
 */
class Enzo extends FormBase {

  /**
   * Drupal\Core\Session\AccountProxy definition.
   *
   * @var \Drupal\Core\Session\AccountProxy
   */
  protected $currentUser;
  protected $termContentStorage;
  protected $tempStore;
  protected $states;
  protected $cities;
  protected $studies;
  protected $countries;

  public function __construct(
    AccountProxy $current_user,
    TermStorageInterface $storage,
    PrivateTempStoreFactory $temp_store_factory
  ) {
    $this->currentUser = $current_user;
    $this->termContentStorage = $storage;
    $this->tempStore = $temp_store_factory->get('quick_search');

    $this->states = ['A', 'B', 'C'];
    $this->cities = [
      ['D', 'E']
    ];

  }

  public static function create(ContainerInterface $container) {
    $entity_manager = $container->get('entity.manager');

    return new static(
      $container->get('current_user'),
      $entity_manager->getStorage('taxonomy_term'),
      $container->get('user.private_tempstore')
    );
  }


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'quick_search_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['state'] = array(
      '#type' => 'select',
      '#title' => $this->t('State'),
      '#description' => $this->t('Please select your favorite state'),
      '#options' => $this->states,
      '#size' => 1,
      '#empty_option' => $this->t('-select-'),
      '#suffix' => "<div id='enzo-test'></div>",
      '#ajax' => array(
        'callback' => '::updateCities',
        'wrapper' => 'enzo-test',
        'event' => 'change',
        'progress' => array(
          'type' => 'throbber',
          'message' => "searching",
        ),
      )
    );
    if ((!empty($form_state->getValue('state')))) {

      $form['city'] = array(
        '#type' => 'select',
        '#title' => $this->t('City'),
        '#description' => $this->t('Please select your favorite city'),
        '#size' => 1,
        '#empty_option' => array(
          'c1' => 'E',
          'c2' => 'Z'
        ),
      );
    }
    // Disable caching on this form.
    $form_state->setCached(FALSE);

    /*$form['city_wrapper'] = [
        '#type' => 'container',
        '#attributes' => ['id' => 'city-wrapper'],
    ];*/

    /* $form['study_wrapper'] = [
         '#type' => 'container',
         '#attributes' => ['id' => 'study-wrapper'],
     ];*/

    /*$form['study_wrapper']['study'] = array(
        '#attributes' => ['id' => 'study-wrapper'],
        '#type' => 'select',
        '#title' => $this->t('Study'),
        '#description' => $this->t('Please select your desired study'),
        '#size' => 1,
        '#empty_option' => $this->t('-select-'),
        '#options' => $this->studies,
    );*/


    $form['country_wrapper'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'country-wrapper'],
    ];

    /*    $form['country_wrapper']['study'] = array(
            '#attributes' => ['id' => 'country-wrapper'],
            '#type' => 'select',
            '#title' => $this->t('Country'),
            '#description' => $this->t('Please select your nationality'),
            '#size' => 1,
            '#empty_option' => $this->t('-select-'),
            '#options' => $this->countries,
        );*/

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Search'),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {


    drupal_set_message($form_state->getValue('state'));
    drupal_set_message($form_state->getValue('city'));
    drupal_set_message($form_state->getValue('study'));
    drupal_set_message($form_state->getValue('county'));

    // Display result.
    /*foreach ($form_state->getValues() as $key => $value) {
        drupal_set_message($key . ': ' . $value);
    }*/

  }

  /**
   * Gets cities by select state.
   *
   * @return array
   *   An array of cities option.
   */
  function updateCities($form, FormStateInterface $form_state) {
    $form_state->setRebuild(TRUE);

    return $form['city'];
  }
}