<?php

/**
 * @file
 */
namespace Drupal\alert\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache; 

/**
 * Creates a 'Foobar' Block
 * @Block(
 * id = "block_foobarblk",
 * admin_label = @Translation("Foo Bar block"),
 * )
 */
class AlertBlock extends BlockBase {

    /**
     * {@inheritdoc}
     */
    public function build() {
      $node = \Drupal::routeMatch()->getParameter('node');
            if ($node instanceof \Drupal\node\NodeInterface) {
              // You can get nid and anything else you need from the node object.
              $nid = $node->id();
            }
      try {
        $connection = \Drupal::database();
        $result = db_query("SELECT field_event_date_value FROM {node__field_event_date} WHERE entity_id = :id", [
          ':id' => $nid,
        ])->fetchField(); 
        $daydiff = \Drupal::service('service.dates')->compareDates($result);;
      }
      catch(Exception $e) {
        // Log the exception to watchdog.
        \Drupal::logger('type')->error($e->getMessage());
      }
      
        return array (
            '#title' => 'Alert',
            '#markup' => $daydiff,
            '#cache' => [
              'max-age' => 0,
            ],
        );
    }

}