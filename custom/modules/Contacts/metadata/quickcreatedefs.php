<?php
$viewdefs ['Contacts'] = 
array (
  'QuickCreate' => 
  array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'hidden' => 
        array (
          0 => '<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">',
          1 => '<input type="hidden" name="case_id" value="{$smarty.request.case_id}">',
          2 => '<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">',
          3 => '<input type="hidden" name="email_id" value="{$smarty.request.email_id}">',
          4 => '<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">',
          5 => '{if !empty($smarty.request.contact_id)}<input type="hidden" name="reports_to_id" value="{$smarty.request.contact_id}">{/if}',
          6 => '{if !empty($smarty.request.contact_name)}<input type="hidden" name="report_to_name" value="{$smarty.request.contact_name}">{/if}',
        ),
      ),
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'useTabs' => true,
      'tabDefs' => 
      array (
        'LBL_CONTACT_INFORMATION' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_PANEL_ADVANCED' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'lbl_contact_information' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'first_name',
            'customCode' => '{html_options name="salutation" id="salutation" options=$fields.salutation.options selected=$fields.salutation.value}&nbsp;<input name="first_name" id="first_name" size="25" maxlength="25" type="text" value="{$fields.first_name.value}">',
          ),
          1 => 
          array (
            'name' => 'last_name',
            'displayParams' => 
            array (
              'required' => true,
            ),
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'other_names_c',
            'label' => 'LBL_OTHER_NAMES',
          ),
          1 => 
          array (
            'name' => 'tax_id_c',
            'label' => 'LBL_TAX_ID',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'client_id_c',
            'label' => 'LBL_CLIENT_ID',
          ),
          1 => 
          array (
            'name' => 'client_since_c',
            'label' => 'LBL_CLIENT_SINCE',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'phone_work',
          ),
          1 => 
          array (
            'name' => 'phone_mobile',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'phone_home',
            'comment' => 'Home phone number of the contact',
            'label' => 'LBL_HOME_PHONE',
          ),
          1 => '',
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'birthdate',
            'comment' => 'The birthdate of the contact',
            'label' => 'LBL_BIRTHDATE',
          ),
          1 => 
          array (
            'name' => 'relation_officer_c',
            'label' => 'LBL_RELATION_OFFICER',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'employer_c',
            'label' => 'LBL_EMPLOYER',
          ),
          1 => 
          array (
            'name' => 'rm_code_c',
            'label' => 'LBL_RM_CODE',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'title',
          ),
          1 => 
          array (
            'name' => 'department',
            'comment' => 'The department of the contact',
            'label' => 'LBL_DEPARTMENT',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'account_name',
          ),
          1 => 
          array (
            'name' => 'phone_fax',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'email1',
          ),
          1 => 
          array (
            'name' => 'segment_c',
            'label' => 'LBL_SEGMENT',
          ),
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'primary_address_street',
            'comment' => 'Street address for primary address',
            'label' => 'LBL_PRIMARY_ADDRESS_STREET',
          ),
          1 => 
          array (
            'name' => 'alt_address_street',
            'comment' => 'Street address for alternate address',
            'label' => 'LBL_ALT_ADDRESS_STREET',
          ),
        ),
        11 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'comment' => 'Full text of the note',
            'label' => 'LBL_DESCRIPTION',
          ),
        ),
        12 => 
        array (
          0 => 
          array (
            'name' => 'photo',
            'studio' => 
            array (
              'listview' => true,
            ),
            'label' => 'LBL_PHOTO',
          ),
          1 => 
          array (
            'name' => 'assigned_user_name',
          ),
        ),
      ),
      'LBL_PANEL_ADVANCED' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'primary_id_number_c',
            'label' => 'LBL_PRIMARY_ID_NUMBER',
          ),
          1 => 
          array (
            'name' => 'primary_id_type_c',
            'label' => 'LBL_PRIMARY_ID_TYPE',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'mother_maiden_name_c',
            'label' => 'LBL_MOTHER_MAIDEN_NAME',
          ),
          1 => 
          array (
            'name' => 'occupation_c',
            'label' => 'LBL_OCCUPATION',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'line_of_business_c',
            'label' => 'LBL_LINE_OF_BUSINESS',
          ),
          1 => 
          array (
            'name' => 'lead_source',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'report_to_name',
            'label' => 'LBL_REPORTS_TO',
          ),
          1 => 
          array (
            'name' => 'campaign_name',
            'comment' => 'The first campaign name for Contact (Meta-data only)',
            'label' => 'LBL_CAMPAIGN',
          ),
        ),
      ),
    ),
  ),
);
;
?>
