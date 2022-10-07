<?php

namespace Drupal\tfm_assessment\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Assessment entities.
 *
 * @ingroup tfm_assessment
 */
interface AssessmentInterface extends  ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Assessment name.
   *
   * @return string
   *   Name of the Assessment.
   */
  public function getName();

  /**
   * Sets the Assessment name.
   *
   * @param string $name
   *   The Assessment name.
   *
   * @return \Drupal\tfm_assessment\Entity\AssessmentInterface
   *   The called Assessment entity.
   */
  public function setName($name);

  /**
   * Gets the Assessment creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Assessment.
   */
  public function getCreatedTime();

  /**
   * Sets the Assessment creation timestamp.
   *
   * @param int $timestamp
   *   The Assessment creation timestamp.
   *
   * @return \Drupal\tfm_assessment\Entity\AssessmentInterface
   *   The called Assessment entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Assessment published status indicator.
   *
   * Unpublished Assessment are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Assessment is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Assessment.
   *
   * @param bool $published
   *   TRUE to set this Assessment to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\tfm_assessment\Entity\AssessmentInterface
   *   The called Assessment entity.
   */
  public function setPublished($published);

}
