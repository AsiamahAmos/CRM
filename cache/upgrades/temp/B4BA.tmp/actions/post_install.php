<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $sugar_config;

// FIXME sugarcrm 7.5
if (version_compare($sugar_config['sugar_version'], '7', '<')) {

	//*************************//
	//***ACL Install Actions***//
	//*************************//
	global $current_user, $beanFiles, $mod_strings;

	require_once("modules/asol_Reports/asol_Reports.php");
	$mod = new asol_Reports();

	$GLOBALS['log']->debug("**********[ASOL][Reports]: DOING asol_Reports");

	if($mod->bean_implements('ACL') && empty($mod->acl_display_only)){

		if(!isset($_REQUEST['upgradeWizard'])) {
			echo translate('LBL_ADDING','ACL','') . $mod->module_dir . '<br>';
		}

		if(!empty($mod->acltype)) {
			ACLAction::addActions('asol_Reports', $mod->acltype);
		} else {
			ACLAction::addActions('asol_Reports');
		}

	}
}

//*************************//
//***ACL Install Actions***//
//*************************//

//*************************//
//***  ASOL Licensing   ***//
//*************************//

global $sugar_version;
if(preg_match( "/^6.*/", $sugar_version)) {
	echo "<script type='text/javascript'> document.location = 'index.php?module=asol_Reports&action=index'; </script>";
} else {
	echo "<script type='text/javascript'>
                var app = window.parent.SUGAR.App;
                window.parent.SUGAR.App.sync({
                    callback: function(){
                        app.router.navigate('#bwc/index.php?module=asol_Reports&action=index', {trigger:true});
                    }});
            </script>";
}

//*************************//
//***  ASOL Licensing   ***//
//*************************//
?>