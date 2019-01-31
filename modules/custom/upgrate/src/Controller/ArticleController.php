<?php

namespace Drupal\upgrate\Controller;

use Drupal\Component\Serialization\Json;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;

class ArticleController 
{
    public function ViewArticle()
    {
        $response = \Drupal::httpClient()
        ->get('http://drupal.local/example-node-rest/article?_format=json', [
            'headers' => ['Accept' => 'application/json'],
            'auth' => ['drupal', 'Drupal12.3']
            ]);

        $json_str = (string)$response->getBody()->getContents();

        //response array
        $json_d = Json::decode($json_str);

        return [
            '#theme' => 'article_list',
            '#article' => $json_d,
            '#title' => 'Article list'
        ];
    }

    public function DeleteArticle($id)
    {
        $user = \Drupal::currentUser()->getAccount()->name;
        $token_generator = \Drupal::csrfToken()->get();

        $response = \Drupal::httpClient()
        ->delete('http://drupal.local/example-node-rest/'.$id, [
            'auth' => ['drupal', 'Drupal12.3'],
            'headers' => ['X-CSRF-Token' => (string)$token_generator],
        ]);

        $path = Url::fromRoute('upgrate_controller.article_list')->toString();
        $response = new RedirectResponse($path);
        $response->send();

        drupal_set_message('Article is removed');
    }
}