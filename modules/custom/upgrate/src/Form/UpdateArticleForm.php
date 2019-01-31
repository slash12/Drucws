<?php

namespace Drupal\upgrate\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Url;

/**
 * Class UpdateArticleForm.
 */
class UpdateArticleForm extends FormBase 
{

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'update_article_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $id=NULL) 
  {
    $response = \Drupal::httpClient()
    ->get('http://drupal.local/example-node-rest/'.$id.'?_format=json', [
        'headers' => ['Accept' => 'application/json'],
        'auth' => ['drupal', 'Drupal12.3']
        ]);
    
    $json_str = (string)$response->getBody()->getContents();

    //response array
    $json_d = Json::decode($json_str);

    // ksm($json_d[0]['title']);

    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
      '#default_value' => $json_d[0]['title'],
    ];
    
    $form['body'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Body'),
      '#weight' => '0',
      '#default_value' => $json_d[0]['body'],
    ];

    $form['hnid'] = [
      '#type' => 'hidden',
      '#value' => $json_d[0]['id'],
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
  public function validateForm(array &$form, FormStateInterface $form_state) 
  {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) 
  {
    $token_generator = \Drupal::csrfToken()->get();

    $serialized_entity = json_encode([
      'title' => [['value' => $form_state->getValue('title')]],
      'body' => [['value' => $form_state->getValue('body')]],
      'type' => [['target_id' => 'article']],
    ]);

    $response = \Drupal::httpClient()
      ->patch('http://drupal.local/example-node-rest/'.$form_state->getValue('hnid').'?_format=json', [
        'auth' => ['drupal', 'Drupal12.3'],
        'body' => $serialized_entity,
        'headers' => [
          'Content-Type' => 'application/json',
          'Accept' => 'application/json',
          'X-CSRF-Token' => $token_generator,
        ],
      ]);

    drupal_set_message('Article updated');

    $url = Url::fromRoute('upgrate_controller.article_list');
    $form_state->setRedirectUrl($url);
  }

}
