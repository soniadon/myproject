<?php

namespace Drupal\tfm_client\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Client entities.
 */
class ClientViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
