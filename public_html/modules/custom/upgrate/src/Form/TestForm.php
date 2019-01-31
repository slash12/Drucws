<?php

namespace Drupal\upgrate\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Unicode;
use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\Url;
use GuzzleHttp\Exception\ClientException;

/**
 * Class TestForm.
 */
class TestForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'test_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['txt_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#maxlength' => 20,
      '#size' => 64,
      '#weight' => '0',
    ];
    $form['txt_body'] = [
      '#type' => 'textfield',
      '#title' => $this->t('body'),
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

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
    try 
    {
      $serialized_entity = json_encode([
        'title' => [['value' => $form_state->getValue("txt_title")]],
        'body' => [['value' => $form_state->getValue("txt_body")]],
        'type' => [['target_id' => 'test2api']],
        '_links' => ['type' => [
            'href' => 'http://drupal.local/rest/type/node/test2api'
        ]],
      ]);
      
      $response_in = \Drupal::httpClient()
        ->post('http://drupal.local/entity/node?_format=hal_json', [
          'auth' => ['drupal', 'Drupal12.3'],
          'body' => $serialized_entity,
          'headers' => [
            'Content-Type' => 'application/hal+json',
            'X-CSRF-Token' => 'bNwihWR0JQ7f_Ze_Ce5rRiWmF8lsz_p-0bKDORU9lYA'
          ],
        ]);

        drupal_set_message('New record is saved');
    }
    catch (ClientException $e) 
    {
      $responseBody = $e->getResponse()->getBody(true);
      drupal_set_message('Content Type does not exist'); 
    }
  }

}
