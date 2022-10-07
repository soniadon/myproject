<?php

namespace Drupal\tfm_training\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Training entity.
 *
 * @ingroup tfm_training
 *
 * @ContentEntityType(
 *   id = "training",
 *   label = @Translation("Training"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\tfm_training\TrainingListBuilder",
 *     "views_data" = "Drupal\tfm_training\Entity\TrainingViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\tfm_training\Form\TrainingForm",
 *       "add" = "Drupal\tfm_training\Form\TrainingForm",
 *       "edit" = "Drupal\tfm_training\Form\TrainingForm",
 *       "delete" = "Drupal\tfm_training\Form\TrainingDeleteForm",
 *     },
 *     "access" = "Drupal\tfm_training\TrainingAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\tfm_training\TrainingHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "tfm_training",
 *   admin_permission = "administer training entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/training/{training}",
 *     "add-form" = "/admin/structure/training/add",
 *     "edit-form" = "/admin/structure/training/{training}/edit",
 *     "delete-form" = "/admin/structure/training/{training}/delete",
 *     "collection" = "/admin/structure/training",
 *   },
 *   field_ui_base_route = "training.settings"
 * )
 */
class Training extends ContentEntityBase implements TrainingInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += array(
      'user_id' => \Drupal::currentUser()->id(),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? TRUE : FALSE);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);
          
    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Training entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ),
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['training_objectives'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Objectives of Training'))
      ->setDescription(t('The Objectives of Training.'))
      ->setRevisionable(TRUE)
      ->setSettings(array(
      		'max_length' => 250,
      		'text_processing' => 0,
      ))
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
      		'label' => 'above',
      		'type' => 'string',
      		'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
      		'type' => 'string_textarea',
      		'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Trainer Name'))
      ->setDescription(t('Name of the Trainer.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

      $fields['no_of_employees'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Number of Employees'))
      ->setDescription(t('Number of employess for training'))
      ->setRevisionable(TRUE)
      ->setSettings(array(
      		'max_length' => 20,
      		'text_processing' => 0,
      ))
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
      		'label' => 'above',
      		'type' => 'number',
      		'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
      		'type' => 'number',
      		'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['duration'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Training Duration'))
      ->setDescription(t('Duration of the training'))
      ->setRevisionable(TRUE)
      ->setSettings(array(
      		'max_length' => 50,
      		'text_processing' => 0,
      ))
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
      		'label' => 'above',
      		'type' => 'string',
      		'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
      		'type' => 'string_textfield',
      		'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['evaluation'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Evaluation of Trainees'))
      ->setDescription(t('Evaluation of the Trainees'))
      ->setRevisionable(TRUE)
      ->setSettings(array(
      		'max_length' => 50,
      		'text_processing' => 0,
      ))
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
      		'label' => 'above',
      		'type' => 'string',
      		'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
      		'type' => 'string_textfield',
      		'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

      $fields['mentor'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Mentor Name'))
      ->setDescription(t('Name of the mentor for this training.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['requisites'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('System Requisites'))
      ->setDescription(t('System Requisites'))
      ->setRevisionable(TRUE)
      ->setSettings(array(
      		'max_length' => 250,
      		'text_processing' => 0,
      ))
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
      		'label' => 'above',
      		'type' => 'string',
      		'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
      		'type' => 'string_textarea',
      		'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Training is published.'))
      ->setRevisionable(TRUE)
      ->setDefaultValue(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
