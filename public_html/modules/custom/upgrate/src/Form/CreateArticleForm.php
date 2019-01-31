<?php

namespace Drupal\upgrate\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Class CreateArticleForm.
 */
class CreateArticleForm extends FormBase 
{


  /**
   * {@inheritdoc}
   */
  public function getFormId() 
  {
    return 'create_article_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) 
  {
    $form['txt_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
    ];
    $form['txt_body'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Body'),
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
      'title' => [['value' => $form_state->getValue("txt_title")]],
      'body' => [['value' => $form_state->getValue("txt_body")]],
      'type' => [['target_id' => 'article']],
      'nid' => ['value' => ['']],
    ]);

    $response_in = \Drupal::httpClient()
        ->post('http://drupal.local/example-node-rest?_format=json', [
          'auth' => ['drupal', 'Drupal12.3'],
          'body' => $serialized_entity,
          'headers' => [
            'Content-Type' => 'application/json',
            'X-CSRF-Token' => $token_generator,
            'Accept' => 'application/json',
          ],          
        ]);

    drupal_set_message('New article is added');

    $url = Url::fromRoute('upgrate_controller.article_list');
    $form_state->setRedirectUrl($url);
  }

}
