<?php

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;

class HelloController extends ControllerBase 
{
  public function content() 
  {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Hello, World! test test'),
    ];
  }

  public function content_name($name) 
  {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Hello, World! @name', 
      [
        '@name' => $name,
      ]),
    ];
  }
}
