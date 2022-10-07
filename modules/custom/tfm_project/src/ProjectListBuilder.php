<?php

namespace Drupal\tfm_project;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Training entities.
 *
 * @ingroup tfm_training
 */
class ProjectListBuilder extends EntityListBuilder {

  // use Link;

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Project ID');
    $header['name'] = $this->t('Project Name');
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
        'entity.project.edit_form', array(
          'project' => $entity->label(),
        )
      )
    );
    return $row + parent::buildRow($entity);
  }

}
