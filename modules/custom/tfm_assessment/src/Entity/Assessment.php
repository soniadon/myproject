<?php

namespace Drupal\tfm_assessment\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Assessment entity.
 *
 * @ingroup tfm_assessment
 *
 * @ContentEntityType(
 *   id = "assessment",
 *   label = @Translation("Assessment"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\tfm_assessment\AssessmentListBuilder",
 *     "views_data" = "Drupal\tfm_assessment\Entity\AssessmentViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\tfm_assessment\Form\AssessmentForm",
 *       "add" = "Drupal\tfm_assessment\Form\AssessmentForm",
 *       "edit" = "Drupal\tfm_assessment\Form\AssessmentForm",
 *       "delete" = "Drupal\tfm_assessment\Form\AssessmentDeleteForm",
 *     },
 *     "access" = "Drupal\tfm_assessment\AssessmentAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\tfm_assessment\AssessmentHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "tfm_assessment",
 *   admin_permission = "administer assessment entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/assessment/{assessment}",
 *     "add-form" = "/admin/structure/assessment/add",
 *     "edit-form" = "/admin/structure/assessment/{assessment}/edit",
 *     "delete-form" = "/admin/structure/assessment/{assessment}/delete",
 *     "collection" = "/admin/structure/assessment",
 *   },
 *   field_ui_base_route = "assessment.settings"
 * )
 */
class Assessment extends ContentEntityBase implements AssessmentInterface {

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

      
    $fields['assessment_date'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Assessment Date'))
      ->setDescription(t('The assessment date.'))
      ->setRevisionable(TRUE)
      ->setSettings(array(
        'datetime_type' => 'date'
      ))
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
      		'label' => 'above',
      		'type' => 'datetime_default',
      		'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
      		'type' => 'datetime_default',
      		'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
      
    // $fields['assessment_methodology'] = BaseFieldDefinition::create('string')
    //   ->setLabel(t('Assessment Methodology'))
    //   ->setDescription(t('Select assessment methodology.'))
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
    
      
      $fields['assessment_methodology'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Assessment Methodology'))
      ->setDescription(t('Select assessment methodology.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'taxonomy_term')
      ->setSetting('handler', 'default:taxonomy_term')
      ->setSetting('handler_settings', 
          array(
        'target_bundles' => array(
         'assessment_methodology' => 'assessment_methodology'
        )))
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'author',
        'weight' => 0,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'weight' => 3,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '10',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ),
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);  
      
    $fields['assessment_score'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Assessment Score'))
      ->setDescription(t('The assessment score.'))
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
    
      
    
    $fields['assessment_status'] = BaseFieldDefinition::create("list_string")
      ->setSetting('allowed_values', array(
        t('Present'),
        t('Absent'),
      ))
      ->setLabel('Status')
      ->setRequired(FALSE)
      ->setCardinality(1)
      ->setDisplayOptions('view', array(
        'type' => 'options_buttons',
        'weight' => 5
      ))
      ->setDisplayOptions('form', array(
        'type' => 'options_buttons',
        'weight' => 5
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);


    $fields['areas_of_improvement'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Areas of Improvement'))
      ->setDescription(t('The areas of improvement.'))
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
      ->setDescription(t('The user ID of author of the Assessment entity.'))
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

    
      $fields['name'] = BaseFieldDefinition::create('entity_reference')
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
      ->setDescription(t('A boolean indicating whether the Assessment is published.'))
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
