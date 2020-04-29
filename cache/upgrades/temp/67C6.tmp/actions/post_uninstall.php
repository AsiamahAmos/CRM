<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $db, $current_user, $theme;

if (isset($_REQUEST['remove_tables']) && $_REQUEST['remove_tables']=='true') {
	
	$GLOBALS['log']->debug("*********************** ASOL: Removing from asol_common");
	$db->query("DROP TABLE asol_common_config");
	$db->query("DROP TABLE asol_common_templates");
	$db->query("DROP TABLE asol_common_properties");
	$db->query("DROP TABLE asol_common_licensing");
		
}

@unlink("custom/Extension/modules/Administration/Ext/Administration/AlineaSolConfig.php");

	
//Repair and Rebuild
$module = array('All Modules');
$selected_actions = array('clearJsFiles', 'clearTpls', 'clearJsFiles', 'clearDashlets', 'clearSugarFeedCache', 'clearThemeCache');

require_once ('modules/Administration/QuickRepairAndRebuild.php');
$randc = new RepairAndClear();
$randc->repairAndClearAll ( $selected_actions, $module, false, false );
//Repair and Rebuild


@rmdir_recursive('modules/asol_Common');

?>