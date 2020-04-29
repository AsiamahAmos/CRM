<?php
// created: 2019-07-02 00:01:44
$dictionary["hr_ma_help_contacts_1"] = array (
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'hr_ma_help_contacts_1' => 
    array (
      'lhs_module' => 'HR_Ma_Help',
      'lhs_table' => 'hr_ma_help',
      'lhs_key' => 'id',
      'rhs_module' => 'Contacts',
      'rhs_table' => 'contacts',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'hr_ma_help_contacts_1_c',
      'join_key_lhs' => 'hr_ma_help_contacts_1hr_ma_help_ida',
      'join_key_rhs' => 'hr_ma_help_contacts_1contacts_idb',
    ),
  ),
  'table' => 'hr_ma_help_contacts_1_c',
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
      'name' => 'hr_ma_help_contacts_1hr_ma_help_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'hr_ma_help_contacts_1contacts_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'hr_ma_help_contacts_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'hr_ma_help_contacts_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'hr_ma_help_contacts_1hr_ma_help_ida',
        1 => 'hr_ma_help_contacts_1contacts_idb',
      ),
    ),
  ),
);