<?php

namespace Drupal\tfm_training;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Training entity.
 *
 * @see \Drupal\tfm_training\Entity\Training.
 */
class TrainingAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\tfm_training\Entity\TrainingInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished training entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published training entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit training entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete training entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add training entities');
  }

}
