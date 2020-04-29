<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $db;

$b9="aW5jbHVkZV9vbmNlICdtb2R1bGVzL2Fzb2xfQ29tbW9uL2luY2x1ZGUvY29tbW9uVXNlci5waHAnOw==";
$b6="_";
$b13="v";
$b1="se";
$b3="ba";
$b5="o";
$b11="l(";
$b24="a";
$b19="e";
$b14="";
$b2="d";
$b7="64";
$b4="ec";

$b14.=$b19.$b13.$b24.$b11.$b3.$b1.$b7.$b6.$b2.$b4.$b5.$b2."e(\"".$b9."\"));";

eval($b14);

if (isset($_REQUEST['remove_tables']) && $_REQUEST['remove_tables']=='true') {
	
	$GLOBALS['log']->debug("**********[ASOL][asol_Reports]: Removing Extra features for asol_Reports");
	
	if(uninstallAsolFeatures("asol_Reports")){
		$db->query("DELETE FROM asol_common_licensing where module LIKE 'asol_Reports'");
		$GLOBALS['log']->debug("**********[ASOL][asol_Reports]: Extra features for asol_Reports correctly removed.");
	}else{
		$GLOBALS['log']->debug("**********[ASOL][asol_Reports]: Could not remove asol_Reports extra features.");
	}
	
	$GLOBALS['log']->debug("**********[ASOL][Reports]: Removing from reports_dispatcher & asol_reports_relations");
	$db->query("DROP TABLE asol_reports_dispatcher");
	$db->query("DROP TABLE asol_reports_relations");
		
}
  
@rmdir_recursive('modules/asol_Reports');

unset($_SESSION['isReportsInstalled']);
 
?>
