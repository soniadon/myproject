<?php

namespace Drupal\tfm_skillmenu\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\taxonomy\Entity\Term;
use Drupal\Core\Session\AccountInterface;
use Drupal\user\Entity\User;
use Drupal\Core\Database\Driver\mysql\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;  
use Drupal\Core\Link;
use Drupal\Core\Url;

class SkillmenuController extends ControllerBase {

 /**
   * Display.
   *
   * @return string
   *   Return   string.
   */
  public function index() {
    
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Im Default function in Skillmenu Controller Im done my job.')
    ];
     
  } 
  
}