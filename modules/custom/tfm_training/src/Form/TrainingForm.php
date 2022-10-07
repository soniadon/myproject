<?php

namespace Drupal\tfm_training\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Training edit forms.
 *
 * @ingroup tfm_training
 */
class TrainingForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\tfm_training\Entity\Training */
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
        /*drupal_set_message($this->t('Created the %label Training.', [
          '%label' => $entity->label(),
        ]));*/
        \Drupal::messenger()->addMessage('Created the %label Training.', [
          '%label' => $entity->label()]);
        break;

      default:
        /*drupal_set_message($this->t('Saved the %label Training.', [
          '%label' => $entity->label(),
        ]));*/
        \Drupal::messenger()->addMessage('Saved the %label Training.', [
          '%label' => $entity->label()]);
    }
    $form_state->setRedirect('entity.training.canonical', ['training' => $entity->id()]);
  }

}
