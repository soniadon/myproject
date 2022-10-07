<?php

namespace Drupal\tfm_training;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Training entities.
 *
 * @ingroup tfm_training
 */
class TrainingListBuilder extends EntityListBuilder {

  // use Link;

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Training ID');
    $header['name'] = $this->t('Trainer Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\tfm_training\Entity\Training */
    $row['id'] = $entity->id();
    $row['name'] = Link::fromTextAndUrl(
      $entity->label(),
      new Url(
        'entity.training.edit_form', array(
          'training' => $entity->label(),
        )
      )
    );
    return $row + parent::buildRow($entity);
  }

}
