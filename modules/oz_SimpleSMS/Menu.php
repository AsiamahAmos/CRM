<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
global $mod_strings, $app_strings;
global $mod_strings;
//if(ACLController::checkAccess('Calls', 'edit', true))$module_menu[]=Array("index.php?module=Calls&action=EditView&return_module=Calls&return_action=DetailView", $mod_strings['LNK_NEW_CALL'],"CreateCalls");
$module_menu[]=Array("index.php?module=oz_SimpleSMS&action=index", $mod_strings['LNK_SIMPLE_SMS'],"CreateSMS");
$module_menu[]=Array("index.php?module=oz_SimpleSMS&action=index&param=contact", $mod_strings['LNK_CONTACT_SMS'],"ContactSMS");
//$module_menu[]=Array("index.php?module=oz_SimpleSMS&action=index&param=config", $mod_strings['LNK_CONFIG_SMS'],"ConfigureSMS");

if (is_admin($current_user)){
	$module_menu[]=Array("index.php?module=oz_SimpleSMS&action=index&param=config", $mod_strings['LNK_CONFIG_SMS'],"ConfigureSMS");
}
?>
