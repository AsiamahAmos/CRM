<?php
 // created: 2019-07-02 00:01:44
$layout_defs["HR_Ma_Help"]["subpanel_setup"]['hr_ma_help_contacts_1'] = array (
  'order' => 100,
  'module' => 'Contacts',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_HR_MA_HELP_CONTACTS_1_FROM_CONTACTS_TITLE',
  'get_subpanel_data' => 'hr_ma_help_contacts_1',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
