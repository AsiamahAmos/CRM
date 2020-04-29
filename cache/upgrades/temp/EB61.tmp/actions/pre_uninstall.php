<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $db;

$modules=array("AlineaSolReports", "AlineaSolForms&Views", "AlineaSolPublishHomePage", "AlineaSolChat", "AlineaSolCalendarEvents", "AlineaSolProjectManagement", "AlineaSolWorkFlowManager");

$result=$db->query("SELECT id_name,name FROM upgrade_history WHERE id_name IN('".implode("','",$modules)."') AND status = 'installed' AND enabled = 1");

if($result->num_rows>0){
	$installedMods=array();
	while($row=$db->fetchByAssoc($result)){
		$installedMods[]=$row['name'];
	}
	die ("<span style='color:orange;'>Warning:</span> Please uninstall or disable the module/s <strong>".implode(", ", $installedMods)."</strong> first.");
}
?>