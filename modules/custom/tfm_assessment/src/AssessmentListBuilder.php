<?php

namespace Drupal\tfm_assessment;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Assessment entities.
 *
 * @ingroup tfm_assessment
 */
class AssessmentListBuilder extends EntityListBuilder {

  // use Link;

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\tfm_assessment\Entity\Assessment */
    $row['id'] = $entity->id();
    $row['name'] = Link::fromTextAndUrl(
      $entity->label(),
      new Url(
        'entity.assessment.edit_form', array(
          'assessment' => $entity->id(),
        )
      )
    );
    return $row + parent::buildRow($entity);
  }

}
