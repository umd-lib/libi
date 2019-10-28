<?php

namespace Drupal\schema_qa_page\Plugin\metatag\Tag;

use Drupal\schema_metatag\Plugin\metatag\Tag\SchemaQuestionBase;

/**
 * Provides a plugin for the 'schema_qa_page' meta tag.
 *
 * - 'id' should be a globally unique id.
 * - 'name' should match the Schema.org element name.
 * - 'group' should match the id of the group that defines the Schema.org type.
 *
 * @MetatagTag(
 *   id = "schema_qa_page_main_entity",
 *   label = @Translation("mainEntity"),
 *   description = @Translation(""),
 *   name = "mainEntity",
 *   group = "schema_qa_page",
 *   weight = 10,
 *   type = "string",
 *   secure = FALSE,
 *   multiple = TRUE
 * )
 */
class SchemaQAPageMainEntity extends SchemaQuestionBase {
  // Nothing here yet. Just a placeholder class for a plugin.
}
