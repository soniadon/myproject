<?php

namespace Drupal\tfm_feedback\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Feedback entity.
 *
 * @ingroup tfm_feedback
 *
 * @ContentEntityType(
 *   id = "feedback",
 *   label = @Translation("Feedback"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\tfm_feedback\FeedbackListBuilder",
 *     "views_data" = "Drupal\tfm_feedback\Entity\FeedbackViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\tfm_feedback\Form\FeedbackForm",
 *       "add" = "Drupal\tfm_feedback\Form\FeedbackForm",
 *       "edit" = "Drupal\tfm_feedback\Form\FeedbackForm",
 *       "delete" = "Drupal\tfm_feedback\Form\FeedbackDeleteForm",
 *     },
 *     "access" = "Drupal\tfm_feedback\FeedbackAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\tfm_feedback\FeedbackHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "tfm_feedback",
 *   admin_permission = "administer feedback entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "employee_name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/feedback/{feedback}",
 *     "add-form" = "/admin/structure/feedback/add",
 *     "edit-form" = "/admin/structure/feedback/{feedback}/edit",
 *     "delete-form" = "/admin/structure/feedback/{feedback}/delete",
 *     "collection" = "/admin/structure/feedback",
 *   },
 *   field_ui_base_route = "feedback.settings"
 * )
 */
class Feedback extends ContentEntityBase implements FeedbackInterface {

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
    return $this->get('employee_name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('employee_name', $name);
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

      
    
    // $fields['mentor_name'] = BaseFieldDefinition::create('string')
    //   ->setLabel(t('Mentor Name'))
    //   ->setDescription(t('The mentor name.'))
    //   ->setRevisionable(TRUE)
    //   ->setSettings(array(
    //   		'max_length' => 50,
    //   		'text_processing' => 0,
    //   ))
    //   ->setDefaultValue('')
    //   ->setDisplayOptions('view', array(
    //   		'label' => 'above',
    //   		'type' => 'string',
    //   		'weight' => -4,
    //   ))
    //   ->setDisplayOptions('form', array(
    //   		'type' => 'string_textfield',
    //   		'weight' => -4,
    //   ))
    //   ->setDisplayConfigurable('form', TRUE)
    //   ->setDisplayConfigurable('view', TRUE);
    
      $fields['mentor_name'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Mentor Name'))
      ->setDescription(t('The mentor name.'))
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
    
    $fields['comments'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Comments'))
      ->setDescription(t('The comments.'))
      ->setRevisionable(TRUE)
      ->setSettings(array(
      		'max_length' => 250,
      		'text_processing' => 0,
      ))
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
      		'label' => 'above',
      		'type' => 'basic_string',
      		'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
      		'type' => 'string_textarea',
      		'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE); 
      

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Feedback entity.'))
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

    
      $fields['employee_name'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Employee Name'))
      ->setDescription(t('The Employee name.'))
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

                
    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Feedback is published.'))
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
