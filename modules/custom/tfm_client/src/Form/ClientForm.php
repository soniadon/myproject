<?php

namespace Drupal\tfm_client\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Client edit forms.
 *
 * @ingroup tfm_client
 */
class ClientForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\tfm_client\Entity\Client */
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
        // drupal_set_message($this->t('Created the %label Client.', [
        //   '%label' => $entity->label(),
        // ]));
        \Drupal::messenger()->addMessage('Created the %label Assessment.', [
          '%label' => $entity->label()]);
        break;

      default:
        // drupal_set_message($this->t('Saved the %label Client.', [
        //   '%label' => $entity->label(),
        // ]));
        \Drupal::messenger()->addMessage('Created the %label Assessment.', [
          '%label' => $entity->label()]);
    }
    $form_state->setRedirect('entity.client.canonical', ['client' => $entity->id()]);
  }

}
