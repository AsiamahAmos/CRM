<?php
$dashletData['ContactsDashlet']['searchFields'] = array (
  'date_entered' => 
  array (
    'default' => '',
  ),
  'title' => 
  array (
    'default' => '',
  ),
  'primary_address_country' => 
  array (
    'default' => '',
  ),
  'open_balance_c' => 
  array (
    'default' => '',
  ),
  'searchfields' => 
  array (
    'default' => '',
  ),
  'assigned_user_id' => 
  array (
    'default' => '',
  ),
);
$dashletData['ContactsDashlet']['columns'] = array (
  'client_id_c' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_CLIENT_ID',
    'width' => '10%',
    'name' => 'client_id_c',
  ),
  'name' => 
  array (
    'width' => '30%',
    'label' => 'LBL_NAME',
    'link' => true,
    'default' => true,
    'related_fields' => 
    array (
      0 => 'first_name',
      1 => 'last_name',
      2 => 'salutation',
    ),
    'name' => 'name',
  ),
  'open_balance_c' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_OPEN_BALANCE',
    'width' => '10%',
  ),
  'current_balance_c' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_CURRENT_BALANCE',
    'width' => '10%',
  ),
  'last_debited_c' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_LAST_DEBITED',
    'width' => '10%',
  ),
  'last_credited_c' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_LAST_CREDITED',
    'width' => '10%',
  ),
  'assigned_user_name' => 
  array (
    'width' => '15%',
    'label' => 'LBL_LIST_ASSIGNED_USER',
    'default' => false,
    'name' => 'assigned_user_name',
  ),
  'title' => 
  array (
    'width' => '20s%',
    'label' => 'LBL_TITLE',
    'default' => false,
    'name' => 'title',
  ),
  'account_name' => 
  array (
    'width' => '20%',
    'label' => 'LBL_ACCOUNT_NAME',
    'sortable' => false,
    'link' => true,
    'module' => 'Accounts',
    'id' => 'ACCOUNT_ID',
    'ACLTag' => 'ACCOUNT',
    'name' => 'account_name',
    'default' => false,
  ),
  'phone_mobile' => 
  array (
    'width' => '10%',
    'label' => 'LBL_MOBILE_PHONE',
    'name' => 'phone_mobile',
    'default' => false,
  ),
  'phone_other' => 
  array (
    'width' => '10%',
    'label' => 'LBL_OTHER_PHONE',
    'name' => 'phone_other',
    'default' => false,
  ),
  'date_modified' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_MODIFIED',
    'name' => 'date_modified',
    'default' => false,
  ),
  'created_by' => 
  array (
    'width' => '8%',
    'label' => 'LBL_CREATED',
    'name' => 'created_by',
    'default' => false,
  ),
  'phone_work' => 
  array (
    'width' => '15%',
    'label' => 'LBL_OFFICE_PHONE',
    'default' => false,
    'name' => 'phone_work',
  ),
  'email1' => 
  array (
    'width' => '10%',
    'label' => 'LBL_EMAIL_ADDRESS',
    'sortable' => false,
    'customCode' => '{$EMAIL1_LINK}',
    'name' => 'email1',
    'default' => false,
  ),
  'date_entered' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_ENTERED',
    'default' => false,
    'name' => 'date_entered',
  ),
  'phone_home' => 
  array (
    'width' => '10%',
    'label' => 'LBL_HOME_PHONE',
    'name' => 'phone_home',
    'default' => false,
  ),
);
