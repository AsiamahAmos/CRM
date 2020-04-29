<?php
//auto-generated file DO NOT EDIT
 $layout_defs['Accounts']['subpanel_setup']['contacts']['override_subpanel_name'] = 'Account_subpanel_contacts';


$layout_defs["Accounts"]["subpanel_setup"]["contacts"] = array (
		'order' => 30,
			'sort_by' => 'name',
			'sort_order' => 'desc',
			'module' => 'Contacts',
			'subpanel_name' => 'default',
			'get_subpanel_data' => 'contacts',
			'title_key' => 'LBL_PROSPECTLISTS_ACCOUNTS_FROM_PROSPECTLISTS_TITLE',
			'top_buttons' => array(
			    array('widget_class' => 'SubPanelTopButtonQuickCreate'),
				array('widget_class'=>'SubPanelTopSelectButton','mode'=>'MultiSelect'),
                array('widget_class'=>'SubPanelTopFilterButton'),
            ),
);
$layout_defs["Accounts"]["subpanel_setup"]["contacts"]['searchdefs'] =
    array ( 'name' =>
        array (
            'name' => 'name',
            'default' => true,
            'width' => '10%',
        ),
    );


// $layout_defs["Accounts"]["subpanel_setup"]['contacts']['top_buttons'] =
//   array (
//     0 => 
//     array (
//       'widget_class' => 'SubPanelTopButtonQuickCreate',
//     ),
//     1 => 
//     array (
//       'widget_class' => 'SubPanelTopSelectButton',
//       'mode' => 'MultiSelect',
//     ), 
//     2 => 
//     array (
//       'widget_class' => 'SubPanelTopFilterButton',
//     ), 

//   );

//   $layout_defs["Accounts"]["subpanel_setup"]['contacts']['searchdefs'] =
// array ( 'name' =>
//         array (
//             'name' => 'name',
//             'default' => true,
//             'width' => '10%',
//         ),
//         );

?>