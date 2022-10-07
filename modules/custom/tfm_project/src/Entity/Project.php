<?php

namespace Drupal\tfm_project\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Project entity.
 *
 * @ingroup tfm_project
 *
 * @ContentEntityType(
 *   id = "project",
 *   label = @Translation("Project"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\tfm_project\ProjectListBuilder",
 *     "views_data" = "Drupal\tfm_project\Entity\ProjectViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\tfm_project\Form\ProjectForm",
 *       "add" = "Drupal\tfm_project\Form\ProjectForm",
 *       "edit" = "Drupal\tfm_project\Form\ProjectForm",
 *       "delete" = "Drupal\tfm_project\Form\ProjectDeleteForm",
 *     },
 *     "access" = "Drupal\tfm_project\ProjectAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\tfm_project\ProjectHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "tfm_project",
 *   admin_permission = "administer project entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/project/{project}",
 *     "add-form" = "/admin/structure/project/add",
 *     "edit-form" = "/admin/structure/project/{project}/edit",
 *     "delete-form" = "/admin/structure/project/{project}/delete",
 *     "collection" = "/admin/structure/project",
 *   },
 *   field_ui_base_route = "project.settings"
 * )
 */
class Project extends ContentEntityBase implements ProjectInterface {

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
      ->setDescription(t('The user ID of author of the Project entity.'))
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

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Project Name'))
      ->setDescription(t('The name of the Project entity.'))
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


    $fields['account_name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Account Name'))
      ->setDescription(t('Account Name.'))
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

    // $fields['client_name'] = BaseFieldDefinition::create('entity_reference')
    // ->setLabel(t('Client Name'))
    // ->setDescription(t('Mapping with client entity'))
    // ->setSetting('target_type', 'client')
    // ->setSetting('handler', 'default')
    // ->setDisplayOptions('form', array(
    //   'type' => 'entity_reference_autocomplete',
    //   'weight' => 5,
    //   'settings' => array(
    //     'match_operator' => 'CONTAINS',
    //     'size' => '60',
    //     'autocomplete_type' => 'tags',
    //     'placeholder' => '',
    //   ),
    // ))
	  // ->setRequired(TRUE)
    // ->setDisplayConfigurable('form', TRUE)
    // ->setDisplayConfigurable('view', TRUE);
	  
	  
    $fields['project_manager'] = BaseFieldDefinition::create('entity_reference')
    ->setLabel(t('Project Manager Name'))
    ->setDescription(t('Name of the Project Manager.'))
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
	  
    
	$fields['start_date'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Start date'))
      ->setDescription(t('Project Start date.'))
      ->setSettings(array(
          'datetime_type' => 'date',
          'date_format' => 'd-m-Y',
        ))
      ->setDisplayOptions('view', array(
          'label' => 'above',
          'type' => 'datetime_default',
          'weight' => -4,
        ))
      ->setDisplayOptions('form', array(
          'label' => 'above',
          'type' => 'datetime_default',
          'weight' => -4,
        ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
	  
	  
	$fields['end_date'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('End date'))
      ->setDescription(t('Project End date.'))
      ->setSettings(array(
          'datetime_type' => 'date',
          'date_format' => 'd-m-Y',
        ))
      ->setDisplayOptions('view', array(
          'label' => 'above',
          'type' => 'datetime_default',
          'weight' => -4,
        ))
      ->setDisplayOptions('form', array(
          'label' => 'above',
          'type' => 'datetime_default',
          'weight' => -4,
        ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);	 
	  

    $fields['technology'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Technology'))
      ->setDescription(t('Technology Info'))
      ->setSetting('target_type', 'taxonomy_term')
      ->setSetting('handler_settings', ['target_bundles' => ['taxonomy_term' => 'technology']])
      ->setDisplayOptions('view', array(
          'label' => 'above',
          'type' => 'entity_reference_label',
          'weight' => -4,
          'settings' => array(
            'link' => FALSE,
          ),
      ))
      ->setDisplayOptions('form', array(
        'type' => 'options_select',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);	
	  

    $fields['country'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Country'))
      ->setDescription(t('Country Info'))
      ->setSetting('target_type', 'taxonomy_term')
      ->setSetting('handler_settings', ['target_bundles' => ['taxonomy_term' => 'sector_country']])
      ->setDisplayOptions('view', array(
          'label' => 'above',
          'type' => 'entity_reference_label',
          'weight' => -4,
          'settings' => array(
            'link' => FALSE,
          ),
      ))
      ->setDisplayOptions('form', array(
        'type' => 'options_select',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);	 
	  
	  
    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Project is published.'))
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
