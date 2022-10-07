<?php

/**
 * @file
 * Contains assessment.page.inc.
 *
 * Page callback for assessment entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for assessment templates.
 *
 * Default template: assessment.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_assessment(array &$variables) {
  // Fetch assessment Entity Object.
  $assessment = $variables['elements']['#assessment'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
