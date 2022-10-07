<?php

namespace Drupal\tfm_training\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Training entities.
 *
 * @ingroup tfm_training
 */
interface TrainingInterface extends  ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Training name.
   *
   * @return string
   *   Name of the Training.
   */
  public function getName();

  /**
   * Sets the Training name.
   *
   * @param string $name
   *   The Training name.
   *
   * @return \Drupal\tfm_training\Entity\TrainingInterface
   *   The called Training entity.
   */
  public function setName($name);

  /**
   * Gets the Training creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Training.
   */
  public function getCreatedTime();

  /**
   * Sets the Training creation timestamp.
   *
   * @param int $timestamp
   *   The Training creation timestamp.
   *
   * @return \Drupal\tfm_training\Entity\TrainingInterface
   *   The called Training entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Training published status indicator.
   *
   * Unpublished Training are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Training is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Training.
   *
   * @param bool $published
   *   TRUE to set this Training to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\tfm_training\Entity\TrainingInterface
   *   The called Training entity.
   */
  public function setPublished($published);

}
