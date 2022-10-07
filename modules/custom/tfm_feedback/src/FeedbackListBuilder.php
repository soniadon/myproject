<?php

namespace Drupal\tfm_feedback;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Feedback entities.
 *
 * @ingroup tfm_feedback
 */
class FeedbackListBuilder extends EntityListBuilder {

  // use Link;

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('ID');
    $header['employee_name'] = $this->t('Employee Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\tfm_feedback\Entity\Feedback */
    $row['id'] = $entity->id();
    $row['employee_name'] = Link::fromTextAndUrl(
      $entity->label(),
      new Url(
        'entity.feedback.edit_form', array(
          'feedback' => $entity->id(),
        )
      )
    );
    return $row + parent::buildRow($entity);
  }

}
