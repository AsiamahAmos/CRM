<?php

if (is_file("modules/asol_Common/include/commonUtils.php")) {
				
	require_once("modules/asol_Common/include/commonUtils.php");
		
	$common_menu_configuration = array(
		"module" => "Accounts",
		"override" => false,
		"menus" => array (
)
	);

	asol_CommonUtils::getModuleMenus($common_menu_configuration, $module_menu);

}
		
?>