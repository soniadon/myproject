<?php

namespace Drupal\tfm_client;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Client entities.
 *
 * @ingroup tfm_client
 */
class ClientListBuilder extends EntityListBuilder {

  // use Link;

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Client ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\tfm_client\Entity\Client */
    $row['id'] = $entity->id();
    $row['name'] = Link::fromTextAndUrl(
      $entity->label(),
      new Url(
        'entity.client.edit_form', array(
          'client' => $entity->id(),
        )
      )
    );
    return $row + parent::buildRow($entity);
  }

}
