<?php

namespace Drupal\upgrate;

use Drupal\node\Entity\Node;

class addImportContent
{
    public static function addImportContentItem($item, &$context)
    {
        //Info about the current item processing in the batch
        $context['sandbox']['current_item'] = $item;
        $message = 'Creating ' . $item['Surname'].' '.$item['Name'];

        $results = array();

        // var_dump($item);

        create_node($item);

        //A text message displayed in the progress page.
        $context['message'] = $message;

        // Store some result for post-processing in the finished callback.
        $context['results'][] = $item;
    }

    public static function addImportContentItemCallback($success, $results, $operations) 
    {
        if ($success) 
        {
          $message = \Drupal::translation()->formatPlural(
            count($results),
            'One item processed.', '@count items processed.'
          );
        }
        else 
        {
          $message = t('Finished with an error.');
        }

        drupal_set_message($message);
    }
}

// This function actually creates each item as a node as type 'Students'
function create_node($item) 
{
    $node_data['type'] = 'students';
    $node_data['title'] = $item['Surname'].' '.$item['Name'];
    $node_data['field_address']['value'] = $item['Address'];
    $node_data['field_name']['value'] = $item['Name'];
    $node_data['field_surname']['value'] = $item['Surname'];
    $node_data['field_telephone']['value'] = $item['Tel'];
    $node_data['field_unique_id']['value'] = $item['Id'];
    $node_data['field_image_']['value'] = $item['Link'];

    $node = Node::create($node_data);
    $node->setPublished(TRUE);
    $node->save();
} 
