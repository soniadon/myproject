<?php

namespace Drupal\tfm_skillmenu\Plugin\Block;
use Drupal\Core\Block\BlockBase; 


/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "block_example_block",
 *   admin_label = @Translation("Block"),
 * )
 */
class Block extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {  
    $build = [];
    $data = " ";
    $tid = 'Training list';
    $uid = 'Assessment Details';
    $data .= '<a href="/project_training/training/add">'. $tid.'</a>'.'<br>';

    $data .= '<a href="/project_training/assessment/add">'. $uid.'</a>'.'<br>';
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