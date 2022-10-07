<?php

namespace Drupal\tfm_assessment\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Assessment entities.
 */
class AssessmentViewsData extends EntityViewsData {

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
