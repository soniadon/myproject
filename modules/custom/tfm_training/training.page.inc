<?php

/**
 * @file
 * Contains training.page.inc.
 *
 * Page callback for Training entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Training templates.
 *
 * Default template: training.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_training(array &$variables) {
  // Fetch Training Entity Object.
  $training = $variables['elements']['#training'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
