<?php
// created: 2019-05-17 21:00:45
$dictionary["contacts_aos_products_2"] = array (
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'contacts_aos_products_2' => 
    array (
      'lhs_module' => 'Contacts',
      'lhs_table' => 'contacts',
      'lhs_key' => 'id',
      'rhs_module' => 'AOS_Products',
      'rhs_table' => 'aos_products',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'contacts_aos_products_2_c',
      'join_key_lhs' => 'contacts_aos_products_2contacts_ida',
      'join_key_rhs' => 'contacts_aos_products_2aos_products_idb',
    ),
  ),
  'table' => 'contacts_aos_products_2_c',
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
      'name' => 'contacts_aos_products_2contacts_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'contacts_aos_products_2aos_products_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'contacts_aos_products_2spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'contacts_aos_products_2_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'contacts_aos_products_2contacts_ida',
        1 => 'contacts_aos_products_2aos_products_idb',
      ),
    ),
  ),
);