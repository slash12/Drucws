<?php

/**
 * @file
 * Contains \Drupal\hello_world\Routing\HelloRouting.
 */

namespace Drupal\hello_world\Routing;

use Symfony\Component\Routing\Route;

/**
 * Defines dynamic routes.
 */
class HelloRouting {

  /**
   * {@inheritdoc}
   */
  public function routes() {
    $routes = [];
    // Declares a single route under the name 'example.content'.
    // Returns an array of Route objects. 
    $routes['hello_world.content'] = new Route(
      // Path to attach this route to:
      '/hello',
      // Route defaults:
      [
        '_controller' => '\Drupal\hello_world\Controller\HelloController::content',
        '_title' => 'Hello World'
      ],
      // Route requirements:
      [
        '_permission'  => 'access content',
      ]
    );

    $routes['hello_world.content_name'] = new Route(
      // Path to attach this route to:
      '/hello/{name}',
      // Route defaults:
      [
        '_controller' => '\Drupal\hello_world\Controller\HelloController::content_name',
        '_title' => 'Hello World Name'
      ],
      // Route requirements:
      [
        '_permission'  => 'access content',
      ]
    );

    $routes['hello_world.admin_settings_form'] = new Route(
      // Path to attach this route to:
      '/admin/config/hello_world/adminsettings',
      // Route defaults:
      [
        '_title' => 'MessagesForm',
        '_form' => '\Drupal\hello_world\Form\MessagesForm'
      ],
      // Route requirements:
      [
        '_permission'  => 'access administration pages',
      ],
      [
        '_admin_route' => 'TRUE',
      ]
    );

    return $routes;
  }

}
