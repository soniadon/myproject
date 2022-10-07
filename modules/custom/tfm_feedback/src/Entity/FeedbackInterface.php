<?php

namespace Drupal\tfm_feedback\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Feedback entities.
 *
 * @ingroup tfm_feedback
 */
interface FeedbackInterface extends  ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Feedback name.
   *
   * @return string
   *   Name of the Feedback.
   */
  public function getName();

  /**
   * Sets the Feedback name.
   *
   * @param string $name
   *   The Feedback name.
   *
   * @return \Drupal\tfm_feedback\Entity\FeedbackInterface
   *   The called Feedback entity.
   */
  public function setName($name);

  /**
   * Gets the Feedback creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Feedback.
   */
  public function getCreatedTime();

  /**
   * Sets the Feedback creation timestamp.
   *
   * @param int $timestamp
   *   The Feedback creation timestamp.
   *
   * @return \Drupal\tfm_feedback\Entity\FeedbackInterface
   *   The called Feedback entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Feedback published status indicator.
   *
   * Unpublished Feedback are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Feedback is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Feedback.
   *
   * @param bool $published
   *   TRUE to set this Feedback to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\tfm_feedback\Entity\FeedbackInterface
   *   The called Feedback entity.
   */
  public function setPublished($published);

}
