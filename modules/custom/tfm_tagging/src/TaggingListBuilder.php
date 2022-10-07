<?php

namespace Drupal\tfm_tagging;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Tagging entities.
 *
 * @ingroup tfm_tagging
 */
class TaggingListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Tagging ID');
    $header['name'] = $this->t('Project Tagging Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\tfm_tagging\Entity\Tagging */
    $row['id'] = $entity->id();
    $row['name'] = Link::fromTextAndUrl(
      $entity->label(),
      new Url(
        'entity.tagging.edit_form', array(
          'tagging' => $entity->id(),
        )
      )
    );
    return $row + parent::buildRow($entity);
  }

}
