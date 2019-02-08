<?php

namespace Drupal\upgrate\Plugin\rest\resource;

use Drupal\Core\Session\AccountProxyInterface;
use Drupal\node\Entity\Node;
use Drupal\rest\ModifiedResourceResponse;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\Core\Entity\EntityInterface;

/**
* Provides a resource to get view modes by entity and bundle.
*
* @RestResource(
* id = "example_node_rest_resource",
* label = @Translation("Example node rest resource"),
* serialization_class = "Drupal\node\Entity\Node",
* uri_paths = {
* "canonical" = "/example-node-rest/{type}",
* "https://www.drupal.org/link-relations/create" = "/example-node-rest"
* }
* )
*/

class ExampleNodeRestResource extends ResourceBase 
{
    /**
    * A current user instance.
    *
    * @var \Drupal\Core\Session\AccountProxyInterface
    */
    protected $currentUser;

    /**
    * Constructs a new ExampleGetRestResource object.
    *
    * @param array $configuration
    *   A configuration array containing information about the plugin instance.
    * @param string $plugin_id
    *   The plugin_id for the plugin instance.
    * @param mixed $plugin_definition
    *   The plugin implementation definition.
    * @param array $serializer_formats
    *   The available serialization formats.
    * @param \Psr\Log\LoggerInterface $logger
    *   A logger instance.
    * @param \Drupal\Core\Session\AccountProxyInterface $current_user
    *   A current user instance.
    */
    public function __construct(
        array $configuration,
        $plugin_id,
        $plugin_definition,
        array $serializer_formats,
        LoggerInterface $logger,
        AccountProxyInterface $current_user) 
        {
            parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);
            $this->currentUser = $current_user;
        }

    /**
    * {@inheritdoc}
    */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) 
    {
        return new static(
          $configuration,
          $plugin_id,
          $plugin_definition,
          $container->getParameter('serializer.formats'),
          $container->get('logger.factory')->get('example_node_rest'),
          $container->get('current_user')
        );
    }

    /**
    * Responds to POST requests.
    *
    * @param \Drupal\Core\Entity\EntityInterface $entity
    *   The entity object.
    *
    * @return \Drupal\rest\ModifiedResourceResponse
    *   The HTTP response object.
    *
    * @throws \Symfony\Component\HttpKernel\Exception\HttpException
    *   Throws exception expected.
    */
    public function post($node_data) 
    {
        // You must to implement the logic of your REST Resource here.
        // Use current user after pass authentication to validate access.
        if (!$this->currentUser->hasPermission('access content')) 
        {
          throw new AccessDeniedHttpException();
        }

        $node = Node::create(
          array(
            'type' => $node_data->type->target_id,
            'title' => $node_data->title->value,
            'body' => [
              'summary' => '',
              'value' => $node_data->body->value,
              'format' => 'full_html',
            ],
          )
        );      
        $node->save();  
        
        return new ResourceResponse($node);     
    }

    /**
    * Responds to GET requests.
    *
    * Returns a list of bundles for specified entity.
    *
    * @throws \Symfony\Component\HttpKernel\Exception\HttpException
    *   Throws exception expected.
    */
    public function get($type) 
    {
        // You must to implement the logic of your REST Resource here.
        // Use current user after pass authentication to validate access.
        if (!$this->currentUser->hasPermission('access content')) 
        {
          throw new AccessDeniedHttpException();
        }

        // Logs an error
        // \Drupal::logger('upgrate')->error($type);

        if(is_numeric($type))
        {
            $node_storage = \Drupal::entityTypeManager()->getStorage('node');
            $node = $node_storage->load($type);

            $data[] = [
                'id' => $node->id(),
                'title' => $node->getTitle(),
                'body' => strip_tags($node->body->value)
            ];

            $response = new ResourceResponse($data);
            $response->addCacheableDependency($data);
            \Drupal::service('page_cache_kill_switch')->trigger();
            return $response;

            \Drupal::logger('upgrate')->error('numeric');
        }
        else
        {
            $nids = \Drupal::entityQuery('node')->condition('type','article')->execute();
            $nodes =  Node::loadMultiple($nids);
            foreach ($nodes as $key => $value) 
            {
                $data[] = [
                    'id' => $value->id(),
                    'title' => $value->getTitle(),
                    'body' => strip_tags($value->body->value)
                ];
            }
            
            if(empty($nodes))
            {
                $data[] = [
                    'id' => 0,
                    'title' => 'No data is available',
                    'body' => 'Message showing no data is available'
                ];
            }


            $response = new ResourceResponse($data);
            // In order to generate fresh result every time (without clearing 
            // the cache), you need to invalidate the cache.
            $response->addCacheableDependency($data);
            \Drupal::service('page_cache_kill_switch')->trigger();
            return $response;

            \Drupal::logger('upgrate')->error('not numeric');
        }

        
    }

    /**
     * Responds to entity DELETE requests.
     *
     * @param \Drupal\Core\Entity\EntityInterface $entity
     *   The entity object.
     *
     * @return \Drupal\rest\ModifiedResourceResponse
     *   The HTTP response object.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function delete($type) 
    { 
        // $entity->id()
        $entity = \Drupal::entityTypeManager()->getStorage('node')->load($type);
        $entity->delete();

        return new ModifiedResourceResponse(NULL, 204);
    }

    /**
     * Responds to entity PATCH requests.
     *
     * @param \Drupal\Core\Entity\EntityInterface $entity
     *   The entity object.
     * 
     * @return \Drupal\rest\ModifiedResourceResponse
     *   The HTTP response object.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function patch($type, $node_data) 
    {
        if (!$this->currentUser->hasPermission('access content'))
        {
            throw new AccessDeniedHttpException();
        }

        $node = Node::load($type);
        $node->set('title', $node_data->title->value);
        $node->set('body', $node_data->body->value);
        $node->save();

        // Logs an error
        // \Drupal::logger('upgrate')->error();

        return new ModifiedResourceResponse(NULL, 204);
    }
}