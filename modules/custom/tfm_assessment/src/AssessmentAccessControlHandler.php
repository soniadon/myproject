<?php

namespace Drupal\tfm_assessment;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Assessment entity.
 *
 * @see \Drupal\tfm_assessment\Entity\Assessment.
 */
class AssessmentAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\tfm_assessment\Entity\AssessmentInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished assessment entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published assessment entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit assessment entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete assessment entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add assessment entities');
  }

}
