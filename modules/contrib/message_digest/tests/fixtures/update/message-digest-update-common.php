<?php

/**
 * @file
 * Common upgrade data for the Message Digest module.
 *
 * Contains database additions to drupal-8.bare.standard.php.gz that make sure
 * the module and its dependencies exist.
 */

use Drupal\Core\Database\Database;

$connection = Database::getConnection();

// Update core.extension to enable message_digest.
$extensions = $connection->select('config')
  ->fields('config', ['data'])
  ->condition('collection', '')
  ->condition('name', 'core.extension')
  ->execute()
  ->fetchField();
$extensions = unserialize($extensions);
$extensions['module']['message'] = 0;
$extensions['module']['message_digest'] = 0;
$extensions['module']['message_notify'] = 0;
$connection->update('config')
  ->fields([
    'data' => serialize($extensions),
  ])
  ->condition('collection', '')
  ->condition('name', 'core.extension')
  ->execute();

// Install the message template entity type.
$connection->merge('key_value')
  ->condition('collection', 'entity.definitions.installed')
  ->condition('name', 'message_template.entity_type')
  ->fields([
    'value' => 'O:42:"Drupal\Core\Config\Entity\ConfigEntityType":41:{s:16:" * config_prefix";s:8:"template";s:15:" * static_cache";b:0;s:14:" * lookup_keys";a:1:{i:0;s:4:"uuid";}s:16:" * config_export";a:7:{i:0;s:8:"template";i:1;s:5:"label";i:2;s:8:"langcode";i:3;s:11:"description";i:4;s:4:"text";i:5;s:8:"settings";i:6;s:6:"status";}s:21:" * mergedConfigExport";a:0:{}s:15:" * render_cache";b:1;s:19:" * persistent_cache";b:1;s:14:" * entity_keys";a:8:{s:2:"id";s:8:"template";s:5:"label";s:5:"label";s:8:"langcode";s:8:"langcode";s:8:"revision";s:0:"";s:6:"bundle";s:0:"";s:16:"default_langcode";s:16:"default_langcode";s:29:"revision_translation_affected";s:29:"revision_translation_affected";s:4:"uuid";s:4:"uuid";}s:5:" * id";s:16:"message_template";s:16:" * originalClass";s:37:"Drupal\message\Entity\MessageTemplate";s:11:" * handlers";a:5:{s:4:"form";a:3:{s:3:"add";s:39:"Drupal\message\Form\MessageTemplateForm";s:4:"edit";s:39:"Drupal\message\Form\MessageTemplateForm";s:6:"delete";s:48:"Drupal\message\Form\MessageTemplateDeleteConfirm";}s:12:"list_builder";s:41:"Drupal\message\MessageTemplateListBuilder";s:12:"view_builder";s:33:"Drupal\message\MessageViewBuilder";s:6:"access";s:45:"Drupal\Core\Entity\EntityAccessControlHandler";s:7:"storage";s:45:"Drupal\Core\Config\Entity\ConfigEntityStorage";}s:19:" * admin_permission";s:28:"administer message templates";s:25:" * permission_granularity";s:11:"entity_type";s:8:" * links";a:3:{s:8:"add-form";s:37:"/admin/structure/message/template/add";s:9:"edit-form";s:50:"/admin/structure/message/manage/{message_template}";s:11:"delete-form";s:50:"/admin/structure/message/delete/{message_template}";}s:17:" * label_callback";N;s:21:" * bundle_entity_type";N;s:12:" * bundle_of";s:7:"message";s:15:" * bundle_label";N;s:13:" * base_table";N;s:22:" * revision_data_table";N;s:17:" * revision_table";N;s:13:" * data_table";N;s:15:" * translatable";b:0;s:19:" * show_revision_ui";b:0;s:8:" * label";O:48:"Drupal\Core\StringTranslation\TranslatableMarkup":3:{s:9:" * string";s:16:"Message template";s:12:" * arguments";a:0:{}s:10:" * options";a:0:{}}s:19:" * label_collection";s:0:"";s:17:" * label_singular";s:0:"";s:15:" * label_plural";s:0:"";s:14:" * label_count";a:0:{}s:15:" * uri_callback";N;s:8:" * group";s:13:"configuration";s:14:" * group_label";O:48:"Drupal\Core\StringTranslation\TranslatableMarkup":3:{s:9:" * string";s:13:"Configuration";s:12:" * arguments";a:0:{}s:10:" * options";a:1:{s:7:"context";s:17:"Entity type group";}}s:22:" * field_ui_base_route";N;s:26:" * common_reference_target";b:0;s:22:" * list_cache_contexts";a:0:{}s:18:" * list_cache_tags";a:1:{i:0;s:28:"config:message_template_list";}s:14:" * constraints";a:0:{}s:13:" * additional";a:0:{}s:8:" * class";s:37:"Drupal\message\Entity\MessageTemplate";s:11:" * provider";s:7:"message";s:20:" * stringTranslation";N;}',
    'name' => 'message_template.entity_type',
    'collection' => 'entity.definitions.installed',
  ])
  ->execute();

// Install the message entity type.
$connection->merge('key_value')
  ->condition('collection', 'entity.definitions.installed')
  ->condition('name', 'message.entity_type')
  ->fields([
    'value' => 'O:36:"Drupal\Core\Entity\ContentEntityType":38:{s:25:" * revision_metadata_keys";a:0:{}s:15:" * static_cache";b:1;s:15:" * render_cache";b:1;s:19:" * persistent_cache";b:1;s:14:" * entity_keys";a:8:{s:2:"id";s:3:"mid";s:6:"bundle";s:8:"template";s:4:"uuid";s:4:"uuid";s:8:"langcode";s:8:"langcode";s:3:"uid";s:3:"uid";s:8:"revision";s:0:"";s:16:"default_langcode";s:16:"default_langcode";s:29:"revision_translation_affected";s:29:"revision_translation_affected";}s:5:" * id";s:7:"message";s:16:" * originalClass";s:29:"Drupal\message\Entity\Message";s:11:" * handlers";a:6:{s:12:"view_builder";s:33:"Drupal\message\MessageViewBuilder";s:12:"list_builder";s:33:"Drupal\message\MessageListBuilder";s:10:"views_data";s:31:"Drupal\message\MessageViewsData";s:4:"form";a:1:{s:7:"default";s:36:"Drupal\Core\Entity\ContentEntityForm";}s:6:"access";s:45:"Drupal\Core\Entity\EntityAccessControlHandler";s:7:"storage";s:46:"Drupal\Core\Entity\Sql\SqlContentEntityStorage";}s:19:" * admin_permission";N;s:25:" * permission_granularity";s:11:"entity_type";s:8:" * links";a:0:{}s:17:" * label_callback";N;s:21:" * bundle_entity_type";s:16:"message_template";s:12:" * bundle_of";N;s:15:" * bundle_label";O:48:"Drupal\Core\StringTranslation\TranslatableMarkup":3:{s:9:" * string";s:16:"Message template";s:12:" * arguments";a:0:{}s:10:" * options";a:0:{}}s:13:" * base_table";s:7:"message";s:22:" * revision_data_table";N;s:17:" * revision_table";N;s:13:" * data_table";s:18:"message_field_data";s:15:" * translatable";b:1;s:19:" * show_revision_ui";b:0;s:8:" * label";O:48:"Drupal\Core\StringTranslation\TranslatableMarkup":3:{s:9:" * string";s:7:"Message";s:12:" * arguments";a:0:{}s:10:" * options";a:0:{}}s:19:" * label_collection";s:0:"";s:17:" * label_singular";s:0:"";s:15:" * label_plural";s:0:"";s:14:" * label_count";a:0:{}s:15:" * uri_callback";N;s:8:" * group";s:7:"content";s:14:" * group_label";O:48:"Drupal\Core\StringTranslation\TranslatableMarkup":3:{s:9:" * string";s:7:"Content";s:12:" * arguments";a:0:{}s:10:" * options";a:1:{s:7:"context";s:17:"Entity type group";}}s:22:" * field_ui_base_route";s:33:"entity.message_template.edit_form";s:26:" * common_reference_target";b:0;s:22:" * list_cache_contexts";a:0:{}s:18:" * list_cache_tags";a:1:{i:0;s:12:"message_list";}s:14:" * constraints";a:0:{}s:13:" * additional";a:2:{s:6:"module";s:7:"message";s:11:"bundle_keys";a:1:{s:6:"bundle";s:8:"template";}}s:8:" * class";s:29:"Drupal\message\Entity\Message";s:11:" * provider";s:7:"message";s:20:" * stringTranslation";N;}',
    'name' => 'message.entity_type',
    'collection' => 'entity.definitions.installed',
  ])
  ->execute();

// Install the message field storage definitions.
$connection->merge('key_value')
  ->condition('collection', 'entity.definitions.installed')
  ->condition('name', 'message.field_storage_definitions')
  ->fields([
    'value' => 'a:8:{s:3:"mid";O:37:"Drupal\Core\Field\BaseFieldDefinition":5:{s:7:" * type";s:7:"integer";s:9:" * schema";a:4:{s:7:"columns";a:1:{s:5:"value";a:3:{s:4:"type";s:3:"int";s:8:"unsigned";b:1;s:4:"size";s:6:"normal";}}s:11:"unique keys";a:0:{}s:7:"indexes";a:0:{}s:12:"foreign keys";a:0:{}}s:10:" * indexes";a:0:{}s:17:" * itemDefinition";O:51:"Drupal\Core\Field\TypedData\FieldItemDataDefinition":2:{s:18:" * fieldDefinition";r:2;s:13:" * definition";a:2:{s:4:"type";s:18:"field_item:integer";s:8:"settings";a:6:{s:8:"unsigned";b:1;s:4:"size";s:6:"normal";s:3:"min";s:0:"";s:3:"max";s:0:"";s:6:"prefix";s:0:"";s:6:"suffix";s:0:"";}}}s:13:" * definition";a:7:{s:5:"label";O:48:"Drupal\Core\StringTranslation\TranslatableMarkup":3:{s:9:" * string";s:10:"Message ID";s:12:" * arguments";a:0:{}s:10:" * options";a:0:{}}s:11:"description";O:48:"Drupal\Core\StringTranslation\TranslatableMarkup":3:{s:9:" * string";s:15:"The message ID.";s:12:" * arguments";a:0:{}s:10:" * options";a:0:{}}s:9:"read-only";b:1;s:8:"provider";s:7:"message";s:10:"field_name";s:3:"mid";s:11:"entity_type";s:7:"message";s:6:"bundle";N;}}s:4:"uuid";O:37:"Drupal\Core\Field\BaseFieldDefinition":5:{s:7:" * type";s:4:"uuid";s:9:" * schema";a:4:{s:7:"columns";a:1:{s:5:"value";a:3:{s:4:"type";s:13:"varchar_ascii";s:6:"length";i:128;s:6:"binary";b:0;}}s:11:"unique keys";a:1:{s:5:"value";a:1:{i:0;s:5:"value";}}s:7:"indexes";a:0:{}s:12:"foreign keys";a:0:{}}s:10:" * indexes";a:0:{}s:17:" * itemDefinition";O:51:"Drupal\Core\Field\TypedData\FieldItemDataDefinition":2:{s:18:" * fieldDefinition";r:39;s:13:" * definition";a:2:{s:4:"type";s:15:"field_item:uuid";s:8:"settings";a:3:{s:10:"max_length";i:128;s:8:"is_ascii";b:1;s:14:"case_sensitive";b:0;}}}s:13:" * definition";a:7:{s:5:"label";O:48:"Drupal\Core\StringTranslation\TranslatableMarkup":3:{s:9:" * string";s:4:"UUID";s:12:" * arguments";a:0:{}s:10:" * options";a:0:{}}s:11:"description";O:48:"Drupal\Core\StringTranslation\TranslatableMarkup":3:{s:9:" * string";s:16:"The message UUID";s:12:" * arguments";a:0:{}s:10:" * options";a:0:{}}s:9:"read-only";b:1;s:8:"provider";s:7:"message";s:10:"field_name";s:4:"uuid";s:11:"entity_type";s:7:"message";s:6:"bundle";N;}}s:8:"template";O:37:"Drupal\Core\Field\BaseFieldDefinition":5:{s:7:" * type";s:16:"entity_reference";s:9:" * schema";a:4:{s:7:"columns";a:1:{s:9:"target_id";a:3:{s:11:"description";s:28:"The ID of the target entity.";s:4:"type";s:13:"varchar_ascii";s:6:"length";i:32;}}s:7:"indexes";a:1:{s:9:"target_id";a:1:{i:0;s:9:"target_id";}}s:11:"unique keys";a:0:{}s:12:"foreign keys";a:0:{}}s:10:" * indexes";a:0:{}s:17:" * itemDefinition";O:51:"Drupal\Core\Field\TypedData\FieldItemDataDefinition":2:{s:18:" * fieldDefinition";r:75;s:13:" * definition";a:2:{s:4:"type";s:27:"field_item:entity_reference";s:8:"settings";a:3:{s:11:"target_type";s:16:"message_template";s:7:"handler";s:7:"default";s:16:"handler_settings";a:0:{}}}}s:13:" * definition";a:7:{s:5:"label";O:48:"Drupal\Core\StringTranslation\TranslatableMarkup":3:{s:9:" * string";s:8:"Template";s:12:" * arguments";a:0:{}s:10:" * options";a:0:{}}s:11:"description";O:48:"Drupal\Core\StringTranslation\TranslatableMarkup":3:{s:9:" * string";s:21:"The message template.";s:12:" * arguments";a:0:{}s:10:" * options";a:0:{}}s:9:"read-only";b:1;s:8:"provider";s:7:"message";s:10:"field_name";s:8:"template";s:11:"entity_type";s:7:"message";s:6:"bundle";N;}}s:8:"langcode";O:37:"Drupal\Core\Field\BaseFieldDefinition":5:{s:7:" * type";s:8:"language";s:9:" * schema";a:4:{s:7:"columns";a:1:{s:5:"value";a:2:{s:4:"type";s:13:"varchar_ascii";s:6:"length";i:12;}}s:11:"unique keys";a:0:{}s:7:"indexes";a:0:{}s:12:"foreign keys";a:0:{}}s:10:" * indexes";a:0:{}s:17:" * itemDefinition";O:51:"Drupal\Core\Field\TypedData\FieldItemDataDefinition":2:{s:18:" * fieldDefinition";r:111;s:13:" * definition";a:2:{s:4:"type";s:19:"field_item:language";s:8:"settings";a:0:{}}}s:13:" * definition";a:7:{s:5:"label";O:48:"Drupal\Core\StringTranslation\TranslatableMarkup":3:{s:9:" * string";s:13:"Language code";s:12:" * arguments";a:0:{}s:10:" * options";a:0:{}}s:11:"description";O:48:"Drupal\Core\StringTranslation\TranslatableMarkup":3:{s:9:" * string";s:26:"The message language code.";s:12:" * arguments";a:0:{}s:10:" * options";a:0:{}}s:12:"translatable";b:1;s:8:"provider";s:7:"message";s:10:"field_name";s:8:"langcode";s:11:"entity_type";s:7:"message";s:6:"bundle";N;}}s:3:"uid";O:37:"Drupal\Core\Field\BaseFieldDefinition":5:{s:7:" * type";s:16:"entity_reference";s:9:" * schema";a:4:{s:7:"columns";a:1:{s:9:"target_id";a:3:{s:11:"description";s:28:"The ID of the target entity.";s:4:"type";s:3:"int";s:8:"unsigned";b:1;}}s:7:"indexes";a:1:{s:9:"target_id";a:1:{i:0;s:9:"target_id";}}s:11:"unique keys";a:0:{}s:12:"foreign keys";a:0:{}}s:10:" * indexes";a:0:{}s:17:" * itemDefinition";O:51:"Drupal\Core\Field\TypedData\FieldItemDataDefinition":2:{s:18:" * fieldDefinition";r:141;s:13:" * definition";a:2:{s:4:"type";s:27:"field_item:entity_reference";s:8:"settings";a:4:{s:11:"target_type";s:4:"user";s:7:"handler";s:7:"default";s:16:"handler_settings";a:0:{}s:13:"default_value";i:0;}}}s:13:" * definition";a:8:{s:5:"label";O:48:"Drupal\Core\StringTranslation\TranslatableMarkup":3:{s:9:" * string";s:10:"Created by";s:12:" * arguments";a:0:{}s:10:" * options";a:0:{}}s:11:"description";O:48:"Drupal\Core\StringTranslation\TranslatableMarkup":3:{s:9:" * string";s:34:"The user that created the message.";s:12:" * arguments";a:0:{}s:10:" * options";a:0:{}}s:22:"default_value_callback";s:47:"Drupal\message\Entity\Message::getCurrentUserId";s:12:"translatable";b:1;s:8:"provider";s:7:"message";s:10:"field_name";s:3:"uid";s:11:"entity_type";s:7:"message";s:6:"bundle";N;}}s:7:"created";O:37:"Drupal\Core\Field\BaseFieldDefinition":5:{s:7:" * type";s:7:"created";s:9:" * schema";a:4:{s:7:"columns";a:1:{s:5:"value";a:1:{s:4:"type";s:3:"int";}}s:11:"unique keys";a:0:{}s:7:"indexes";a:0:{}s:12:"foreign keys";a:0:{}}s:10:" * indexes";a:0:{}s:17:" * itemDefinition";O:51:"Drupal\Core\Field\TypedData\FieldItemDataDefinition":2:{s:18:" * fieldDefinition";r:179;s:13:" * definition";a:2:{s:4:"type";s:18:"field_item:created";s:8:"settings";a:0:{}}}s:13:" * definition";a:7:{s:5:"label";O:48:"Drupal\Core\StringTranslation\TranslatableMarkup":3:{s:9:" * string";s:10:"Created on";s:12:" * arguments";a:0:{}s:10:" * options";a:0:{}}s:11:"description";O:48:"Drupal\Core\StringTranslation\TranslatableMarkup":3:{s:9:" * string";s:38:"The time that the message was created.";s:12:" * arguments";a:0:{}s:10:" * options";a:0:{}}s:12:"translatable";b:1;s:8:"provider";s:7:"message";s:10:"field_name";s:7:"created";s:11:"entity_type";s:7:"message";s:6:"bundle";N;}}s:9:"arguments";O:37:"Drupal\Core\Field\BaseFieldDefinition":5:{s:7:" * type";s:3:"map";s:9:" * schema";a:4:{s:7:"columns";a:1:{s:5:"value";a:3:{s:4:"type";s:4:"blob";s:4:"size";s:3:"big";s:9:"serialize";b:1;}}s:11:"unique keys";a:0:{}s:7:"indexes";a:0:{}s:12:"foreign keys";a:0:{}}s:10:" * indexes";a:0:{}s:17:" * itemDefinition";O:51:"Drupal\Core\Field\TypedData\FieldItemDataDefinition":2:{s:18:" * fieldDefinition";r:208;s:13:" * definition";a:2:{s:4:"type";s:14:"field_item:map";s:8:"settings";a:0:{}}}s:13:" * definition";a:6:{s:5:"label";O:48:"Drupal\Core\StringTranslation\TranslatableMarkup":3:{s:9:" * string";s:9:"Arguments";s:12:" * arguments";a:0:{}s:10:" * options";a:0:{}}s:11:"description";O:48:"Drupal\Core\StringTranslation\TranslatableMarkup":3:{s:9:" * string";s:55:"Holds the arguments of the message in serialise format.";s:12:" * arguments";a:0:{}s:10:" * options";a:0:{}}s:8:"provider";s:7:"message";s:10:"field_name";s:9:"arguments";s:11:"entity_type";s:7:"message";s:6:"bundle";N;}}s:16:"default_langcode";O:37:"Drupal\Core\Field\BaseFieldDefinition":5:{s:7:" * type";s:7:"boolean";s:9:" * schema";a:4:{s:7:"columns";a:1:{s:5:"value";a:2:{s:4:"type";s:3:"int";s:4:"size";s:4:"tiny";}}s:11:"unique keys";a:0:{}s:7:"indexes";a:0:{}s:12:"foreign keys";a:0:{}}s:10:" * indexes";a:0:{}s:17:" * itemDefinition";O:51:"Drupal\Core\Field\TypedData\FieldItemDataDefinition":2:{s:18:" * fieldDefinition";r:238;s:13:" * definition";a:2:{s:4:"type";s:18:"field_item:boolean";s:8:"settings";a:2:{s:8:"on_label";O:48:"Drupal\Core\StringTranslation\TranslatableMarkup":3:{s:9:" * string";s:2:"On";s:12:" * arguments";a:0:{}s:10:" * options";a:0:{}}s:9:"off_label";O:48:"Drupal\Core\StringTranslation\TranslatableMarkup":3:{s:9:" * string";s:3:"Off";s:12:" * arguments";a:0:{}s:10:" * options";a:0:{}}}}}s:13:" * definition";a:9:{s:5:"label";O:48:"Drupal\Core\StringTranslation\TranslatableMarkup":3:{s:9:" * string";s:19:"Default translation";s:12:" * arguments";a:0:{}s:10:" * options";a:0:{}}s:11:"description";O:48:"Drupal\Core\StringTranslation\TranslatableMarkup":3:{s:9:" * string";s:58:"A flag indicating whether this is the default translation.";s:12:" * arguments";a:0:{}s:10:" * options";a:0:{}}s:12:"translatable";b:1;s:12:"revisionable";b:1;s:13:"default_value";a:1:{i:0;a:1:{s:5:"value";b:1;}}s:8:"provider";s:7:"message";s:10:"field_name";s:16:"default_langcode";s:11:"entity_type";s:7:"message";s:6:"bundle";N;}}}',
    'name' => 'message.field_storage_definitions',
    'collection' => 'entity.definitions.installed',
  ])
  ->execute();

$connection->merge('key_value')
  ->condition('collection', 'entity.definitions.installed')
  ->condition('name', 'message_digest_interval.entity_type')
  ->fields([
    'collection' => 'entity.definitions.installed',
    'name' => 'message_digest_interval.entity_type',
    'value' => 'O:42:"Drupal\Core\Config\Entity\ConfigEntityType":41:{s:16:" * config_prefix";s:8:"interval";s:15:" * static_cache";b:0;s:14:" * lookup_keys";a:1:{i:0;s:4:"uuid";}s:16:" * config_export";a:5:{i:0;s:2:"id";i:1;s:5:"label";i:2;s:8:"interval";i:3;s:8:"langcode";i:4;s:11:"description";}s:21:" * mergedConfigExport";a:0:{}s:15:" * render_cache";b:1;s:19:" * persistent_cache";b:1;s:14:" * entity_keys";a:8:{s:2:"id";s:2:"id";s:5:"label";s:5:"label";s:8:"langcode";s:8:"langcode";s:8:"revision";s:0:"";s:6:"bundle";s:0:"";s:16:"default_langcode";s:16:"default_langcode";s:29:"revision_translation_affected";s:29:"revision_translation_affected";s:4:"uuid";s:4:"uuid";}s:5:" * id";s:23:"message_digest_interval";s:16:" * originalClass";s:50:"Drupal\message_digest\Entity\MessageDigestInterval";s:11:" * handlers";a:4:{s:4:"form";a:3:{s:3:"add";s:53:"\Drupal\message_digest\Form\MessageDigestIntervalForm";s:4:"edit";s:53:"\Drupal\message_digest\Form\MessageDigestIntervalForm";s:6:"delete";s:59:"\Drupal\message_digest\Form\MessageDigestIntervalDeleteForm";}s:12:"list_builder";s:55:"\Drupal\message_digest\MessageDigestIntervalListBuilder";s:6:"access";s:45:"Drupal\Core\Entity\EntityAccessControlHandler";s:7:"storage";s:45:"Drupal\Core\Config\Entity\ConfigEntityStorage";}s:19:" * admin_permission";s:25:"administer message digest";s:25:" * permission_granularity";s:11:"entity_type";s:8:" * links";a:4:{s:8:"add-form";s:49:"/admin/config/message/message-digest/interval/add";s:9:"edit-form";s:69:"/admin/config/message/message-digest/manage/{message_digest_interval}";s:11:"delete-form";s:76:"/admin/config/message/message-digest/manage/{message_digest_interval}/delete";s:10:"collection";s:36:"/admin/config/message/message-digest";}s:17:" * label_callback";N;s:21:" * bundle_entity_type";N;s:12:" * bundle_of";N;s:15:" * bundle_label";N;s:13:" * base_table";N;s:22:" * revision_data_table";N;s:17:" * revision_table";N;s:13:" * data_table";N;s:15:" * translatable";b:0;s:19:" * show_revision_ui";b:0;s:8:" * label";O:48:"Drupal\Core\StringTranslation\TranslatableMarkup":3:{s:9:" * string";s:23:"Message digest interval";s:12:" * arguments";a:0:{}s:10:" * options";a:0:{}}s:19:" * label_collection";s:0:"";s:17:" * label_singular";s:0:"";s:15:" * label_plural";s:0:"";s:14:" * label_count";a:0:{}s:15:" * uri_callback";N;s:8:" * group";s:13:"configuration";s:14:" * group_label";O:48:"Drupal\Core\StringTranslation\TranslatableMarkup":3:{s:9:" * string";s:13:"Configuration";s:12:" * arguments";a:0:{}s:10:" * options";a:1:{s:7:"context";s:17:"Entity type group";}}s:22:" * field_ui_base_route";N;s:26:" * common_reference_target";b:0;s:22:" * list_cache_contexts";a:0:{}s:18:" * list_cache_tags";a:1:{i:0;s:35:"config:message_digest_interval_list";}s:14:" * constraints";a:0:{}s:13:" * additional";a:0:{}s:8:" * class";s:50:"Drupal\message_digest\Entity\MessageDigestInterval";s:11:" * provider";s:14:"message_digest";s:20:" * stringTranslation";N;}',
  ])
  ->execute();

$connection->merge('key_value')
  ->condition('collection', 'entity.storage_schema.sql')
  ->condition('name', 'message.entity_schema_data')
  ->fields([
    'collection' => 'entity.storage_schema.sql',
    'name' => 'message.entity_schema_data',
    'value' => 'a:2:{s:7:"message";a:1:{s:11:"primary key";a:1:{i:0;s:3:"mid";}}s:18:"message_field_data";a:2:{s:11:"primary key";a:2:{i:0;s:3:"mid";i:1;s:8:"langcode";}s:7:"indexes";a:1:{s:39:"message__id__default_langcode__langcode";a:3:{i:0;s:3:"mid";i:1;s:16:"default_langcode";i:2;s:8:"langcode";}}}}',
  ])
  ->execute();

$connection->merge('key_value')
  ->condition('collection', 'entity.storage_schema.sql')
  ->condition('name', 'message.field_schema_data.arguments')
  ->fields([
    'collection' => 'entity.storage_schema.sql',
    'name' => 'message.field_schema_data.arguments',
    'value' => 'a:1:{s:18:"message_field_data";a:1:{s:6:"fields";a:1:{s:9:"arguments";a:4:{s:4:"type";s:4:"blob";s:4:"size";s:3:"big";s:9:"serialize";b:1;s:8:"not null";b:0;}}}}',
  ])
  ->execute();

$connection->merge('key_value')
  ->condition('collection', 'entity.storage_schema.sql')
  ->condition('name', 'message.field_schema_data.created')
  ->fields([
    'collection' => 'entity.storage_schema.sql',
    'name' => 'message.field_schema_data.created',
    'value' => 'a:1:{s:18:"message_field_data";a:1:{s:6:"fields";a:1:{s:7:"created";a:2:{s:4:"type";s:3:"int";s:8:"not null";b:0;}}}}',
  ])
  ->execute();

$connection->merge('key_value')
  ->condition('collection', 'entity.storage_schema.sql')
  ->condition('name', 'message.field_schema_data.default_langcode')
  ->fields([
    'collection' => 'entity.storage_schema.sql',
    'name' => 'message.field_schema_data.default_langcode',
    'value' => 'a:1:{s:18:"message_field_data";a:1:{s:6:"fields";a:1:{s:16:"default_langcode";a:3:{s:4:"type";s:3:"int";s:4:"size";s:4:"tiny";s:8:"not null";b:1;}}}}',
  ])
  ->execute();

$connection->merge('key_value')
  ->condition('collection', 'entity.storage_schema.sql')
  ->condition('name', 'message.field_schema_data.langcode')
  ->fields([
    'collection' => 'entity.storage_schema.sql',
    'name' => 'message.field_schema_data.langcode',
    'value' => 'a:2:{s:7:"message";a:1:{s:6:"fields";a:1:{s:8:"langcode";a:3:{s:4:"type";s:13:"varchar_ascii";s:6:"length";i:12;s:8:"not null";b:1;}}}s:18:"message_field_data";a:1:{s:6:"fields";a:1:{s:8:"langcode";a:3:{s:4:"type";s:13:"varchar_ascii";s:6:"length";i:12;s:8:"not null";b:1;}}}}',
  ])
  ->execute();

$connection->merge('key_value')
  ->condition('collection', 'entity.storage_schema.sql')
  ->condition('name', 'message.field_schema_data.mid')
  ->fields([
    'collection' => 'entity.storage_schema.sql',
    'name' => 'message.field_schema_data.mid',
    'value' => 'a:2:{s:7:"message";a:1:{s:6:"fields";a:1:{s:3:"mid";a:4:{s:4:"type";s:3:"int";s:8:"unsigned";b:1;s:4:"size";s:6:"normal";s:8:"not null";b:1;}}}s:18:"message_field_data";a:1:{s:6:"fields";a:1:{s:3:"mid";a:4:{s:4:"type";s:3:"int";s:8:"unsigned";b:1;s:4:"size";s:6:"normal";s:8:"not null";b:1;}}}}',
  ])
  ->execute();

$connection->merge('key_value')
  ->condition('collection', 'entity.storage_schema.sql')
  ->condition('name', 'message.field_schema_data.template')
  ->fields([
    'collection' => 'entity.storage_schema.sql',
    'name' => 'message.field_schema_data.template',
    'value' => 'a:2:{s:7:"message";a:2:{s:6:"fields";a:1:{s:8:"template";a:4:{s:11:"description";s:28:"The ID of the target entity.";s:4:"type";s:13:"varchar_ascii";s:6:"length";i:32;s:8:"not null";b:1;}}s:7:"indexes";a:1:{s:34:"message_field__template__target_id";a:1:{i:0;s:8:"template";}}}s:18:"message_field_data";a:2:{s:6:"fields";a:1:{s:8:"template";a:4:{s:11:"description";s:28:"The ID of the target entity.";s:4:"type";s:13:"varchar_ascii";s:6:"length";i:32;s:8:"not null";b:1;}}s:7:"indexes";a:1:{s:34:"message_field__template__target_id";a:1:{i:0;s:8:"template";}}}}',
  ])
  ->execute();

$connection->merge('key_value')
  ->condition('collection', 'entity.storage_schema.sql')
  ->condition('name', 'message.field_schema_data.uid')
  ->fields([
    'collection' => 'entity.storage_schema.sql',
    'name' => 'message.field_schema_data.uid',
    'value' => 'a:1:{s:18:"message_field_data";a:2:{s:6:"fields";a:1:{s:3:"uid";a:4:{s:11:"description";s:28:"The ID of the target entity.";s:4:"type";s:3:"int";s:8:"unsigned";b:1;s:8:"not null";b:1;}}s:7:"indexes";a:1:{s:29:"message_field__uid__target_id";a:1:{i:0;s:3:"uid";}}}}',
  ])
  ->execute();

$connection->merge('key_value')
  ->condition('collection', 'entity.storage_schema.sql')
  ->condition('name', 'message.field_schema_data.uuid')
  ->fields([
    'collection' => 'entity.storage_schema.sql',
    'name' => 'message.field_schema_data.uuid',
    'value' => 'a:1:{s:7:"message";a:2:{s:6:"fields";a:1:{s:4:"uuid";a:4:{s:4:"type";s:13:"varchar_ascii";s:6:"length";i:128;s:6:"binary";b:0;s:8:"not null";b:1;}}s:11:"unique keys";a:1:{s:26:"message_field__uuid__value";a:1:{i:0;s:4:"uuid";}}}}',
  ])
  ->execute();

// Create the Message Digest database table.
$connection->schema()->createTable('message_digest', [
  'fields' => [
    'id' => [
      'type' => 'serial',
      'not null' => TRUE,
      'size' => 'normal',
    ],
    'mid' => [
      'type' => 'int',
      'not null' => TRUE,
      'size' => 'normal',
      'default' => '0',
      'unsigned' => TRUE,
    ],
    'entity_type' => [
      'type' => 'varchar',
      'not null' => TRUE,
      'length' => '32',
      'default' => '',
    ],
    'entity_id' => [
      'type' => 'varchar',
      'not null' => TRUE,
      'length' => '128',
      'default' => '',
    ],
    'receiver' => [
      'type' => 'int',
      'not null' => TRUE,
      'size' => 'normal',
      'default' => '0',
      'unsigned' => TRUE,
    ],
    'notifier' => [
      'type' => 'varchar',
      'not null' => TRUE,
      'length' => '255',
      'default' => '',
    ],
    'sent' => [
      'type' => 'int',
      'not null' => TRUE,
      'size' => 'tiny',
      'default' => '0',
    ],
    'timestamp' => [
      'type' => 'int',
      'not null' => TRUE,
      'size' => 'normal',
      'default' => '0',
      'unsigned' => TRUE,
    ],
  ],
  'primary key' => [
    'id',
  ],
  'indexes' => [
    'aggregate' => [
      'timestamp',
      'sent',
      [
        'notifier',
        '191',
      ],
    ],
    'sent' => [
      'receiver',
      [
        'notifier',
        '191',
      ],
    ],
  ],
  'mysql_character_set' => 'utf8mb4',
]);

// Create the database tables for the Message entity.
$connection->schema()->createTable('message', [
  'fields' => [
    'mid' => [
      'type' => 'serial',
      'not null' => TRUE,
      'size' => 'normal',
      'unsigned' => TRUE,
    ],
    'template' => [
      'type' => 'varchar_ascii',
      'not null' => TRUE,
      'length' => '32',
    ],
    'uuid' => [
      'type' => 'varchar_ascii',
      'not null' => TRUE,
      'length' => '128',
    ],
    'langcode' => [
      'type' => 'varchar_ascii',
      'not null' => TRUE,
      'length' => '12',
    ],
  ],
  'primary key' => [
    'mid',
  ],
  'unique keys' => [
    'message_field__uuid__value' => [
      'uuid',
    ],
  ],
  'indexes' => [
    'message_field__template__target_id' => [
      'template',
    ],
  ],
  'mysql_character_set' => 'utf8mb4',
]);

$connection->schema()->createTable('message_field_data', [
  'fields' => [
    'mid' => [
      'type' => 'int',
      'not null' => TRUE,
      'size' => 'normal',
      'unsigned' => TRUE,
    ],
    'template' => [
      'type' => 'varchar_ascii',
      'not null' => TRUE,
      'length' => '32',
    ],
    'langcode' => [
      'type' => 'varchar_ascii',
      'not null' => TRUE,
      'length' => '12',
    ],
    'uid' => [
      'type' => 'int',
      'not null' => TRUE,
      'size' => 'normal',
      'unsigned' => TRUE,
    ],
    'created' => [
      'type' => 'int',
      'not null' => FALSE,
      'size' => 'normal',
    ],
    'arguments' => [
      'type' => 'blob',
      'not null' => FALSE,
      'size' => 'big',
    ],
    'default_langcode' => [
      'type' => 'int',
      'not null' => TRUE,
      'size' => 'tiny',
    ],
  ],
  'primary key' => [
    'mid',
    'langcode',
  ],
  'indexes' => [
    'message__id__default_langcode__langcode' => [
      'mid',
      'default_langcode',
      'langcode',
    ],
    'message_field__template__target_id' => [
      'template',
    ],
    'message_field__uid__target_id' => [
      'uid',
    ],
  ],
  'mysql_character_set' => 'utf8mb4',
]);
