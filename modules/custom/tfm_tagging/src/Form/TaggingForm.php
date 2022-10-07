<?php

namespace Drupal\tfm_tagging\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Tagging edit forms.
 *
 * @ingroup tfm_tagging
 */
class TaggingForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\tfm_tagging\Entity\Tagging */
    $form = parent::buildForm($form, $form_state);

    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = &$this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        /*drupal_set_message($this->t('Created the %label Tagging.', [
          '%label' => $entity->label(),
        ]));*/
        \Drupal::messenger()->addMessage('Created the %label Tagging.', [
          '%label' => $entity->label()]);
        break;

      default:
        /*drupal_set_message($this->t('Saved the %label Tagging.', [
          '%label' => $entity->label(),
        ]));*/
        \Drupal::messenger()->addMessage('Saved the %label Tagging.', [
          '%label' => $entity->label()]);
    }
    $form_state->setRedirect('entity.tagging.canonical', ['tagging' => $entity->id()]);
  }

}
