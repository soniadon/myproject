<?php

namespace Drupal\menublock\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a block with a simple text.
 *

 * @Block(

 *   id = "my_block_example_block",

 *   admin_label = @Translation("My block"),

 * )

 */

class Block extends BlockBase {

  /**

   * {@inheritdoc}

   */

  public function build() {

    //return [
    //   '#markup' => $this->t('This is a simple block!'),
    // ];

    $build = [];
    $data= "";
    $vid = 'primary_skill';
    $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid);  
    foreach ($terms as $term) {  
      $data .= '<a href="/project_training/adobe/'.$term->tid.'">'.$term->name.'</a>'.'<br>';    
    }
    return [
         '#markup' =>  $data,
    ];      
    return $build;  

  }      

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access content');

  }

}