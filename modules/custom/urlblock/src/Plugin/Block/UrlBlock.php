<?php

namespace Drupal\urlblock\Plugin\Block;
use Drupal\Core\Block\BlockBase; 


/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "urlblock_example_block",
 *   admin_label = @Translation("UrlBlock"),
 * )
 */
class UrlBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {  
    $build = [];
    $data = " ";
    $tid = 'Training list';
    $data .= '<a href="/project_training/training/add">'. $tid.'</a>'.'<br>'; 
    return [
     //'#markup' => $this->t('This is a simple block!'),
     '#markup' => $data,
    ];
    // $build = [];
    // $item = "";        // menu  i-> term
    // $name="abc";    
    // for($i=1;$i<=10;$i++){
    //   $item .= '<a href="/adobe/"'.$i.'>'.$name.$i.'</a>'.'<br>';      
    // }
    // return [
    //      '#markup' => $item,
    // ];
    return $build;
 
  }     
  
}