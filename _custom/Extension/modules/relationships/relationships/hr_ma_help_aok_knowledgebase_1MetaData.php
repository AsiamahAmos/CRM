<?php
// created: 2018-12-03 14:47:44
$dictionary["hr_ma_help_aok_knowledgebase_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'hr_ma_help_aok_knowledgebase_1' => 
    array (
      'lhs_module' => 'HR_Ma_Help',
      'lhs_table' => 'hr_ma_help',
      'lhs_key' => 'id',
      'rhs_module' => 'AOK_KnowledgeBase',
      'rhs_table' => 'aok_knowledgebase',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'hr_ma_help_aok_knowledgebase_1_c',
      'join_key_lhs' => 'hr_ma_help_aok_knowledgebase_1hr_ma_help_ida',
      'join_key_rhs' => 'hr_ma_help_aok_knowledgebase_1aok_knowledgebase_idb',
    ),
  ),
  'table' => 'hr_ma_help_aok_knowledgebase_1_c',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
    ),
    1 => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    2 => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    3 => 
    array (
      'name' => 'hr_ma_help_aok_knowledgebase_1hr_ma_help_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'hr_ma_help_aok_knowledgebase_1aok_knowledgebase_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'hr_ma_help_aok_knowledgebase_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'hr_ma_help_aok_knowledgebase_1_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'hr_ma_help_aok_knowledgebase_1hr_ma_help_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'hr_ma_help_aok_knowledgebase_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'hr_ma_help_aok_knowledgebase_1aok_knowledgebase_idb',
      ),
    ),
  ),
);