<?php 
$commonVersion = str_replace('.', '', asol_CommonUtils::$common_version);
?>
<?= $_COOKIE['sugar_user_theme'] != 'asol_Theme' ? asol_CommonUtils::getLoadJqueryScript(true, true, null, false) : '' ?>
<script type="text/javascript" src="modules/asol_Common/include/client/helpers/commonUtils.js?version=<?= $commonVersion ?>"></script>
<script type="text/javascript" src="modules/asol_Common/include/client/libraries/asolFancyMultiEnum.js?version=<?= $commonVersion ?>"></script>
<link type="text/css" href="modules/asol_Common/include/client/libraries/asolFancyMultiEnum.css?version=<?= $commonVersion ?>" rel="stylesheet">
<?= $_COOKIE['sugar_user_theme'] != 'asol_Theme' ? '<link type="text/css" href="modules/asol_Common/include/client/css/asolicons.css?version='.$commonVersion.'" rel="stylesheet">' : '' ?>

<script type="text/javascript">
	window.currentUser = {
		"is_admin" : <?= ($current_user->is_admin ? 'true' : 'false'); ?>,
		"id" : "<?= $current_user->id; ?>",
		"name" : "<?= $current_user->name; ?>",
		"user_name" : "<?= $current_user->user_name; ?>",
	};
	asolFancyMultiEnum.setLanguage({
		"checkAll" : "<?= translate("LBL_MULTIENUM_CHECK_ALL_ITEMS", "asol_Common"); ?>",
		"allSelected" : "<?= translate("LBL_MULTIENUM_ALL_SELECTED_ITEMS", "asol_Common"); ?>",
		"items" : "<?= translate("LBL_MULTIENUM_SELECTED_ITEMS", "asol_Common"); ?>",
	});
</script>
<?php 
 $version = str_replace('.', '', asol_ReportsUtils::$reports_version);

 //***********************//
 //***AlineaSol Premium***//
 //***********************//
 $premiumFunctionsScript = asol_ReportsUtils::managePremiumFeature("basicPremiumJavascriptFeature", "reportFunctions.php", "getPremiumJavaScriptFunctions", null);
 $premiumFunctionsScript = $premiumFunctionsScript? $premiumFunctionsScript : '';
 //***********************//
 //***AlineaSol Premium***//
 //***********************//
 
?>
<script type="text/javascript" src="modules/asol_Reports/include/js/reports.min.js?version=<?= $version ?>"></script>
<script type="text/javascript" src="modules/asol_Reports/include/client/helpers/reportsRouter.js?version=<?= $version ?>"></script>
<script type="text/javascript" src="modules/asol_Reports/include/client/helpers/reportsApi.js?version=<?= $version ?>"></script>
<?= $premiumFunctionsScript ?>
<script type="text/javascript">
	window["currentRecord"] = "<?= isset($_REQUEST['record'])? $_REQUEST['record'] : '' ?>";
	reportsApi.setLanguage({
		"blocking" : {
			"load" : "<?= translate("LBL_REPORT_LOADING_DATA", "asol_Reports"); ?>",
			"save" : "<?= translate("LBL_REPORT_SAVING_DATA", "asol_Reports"); ?>",
			"loadReport" : "<?= translate("LBL_REPORT_LOADING", "asol_Reports"); ?>",
		}
	});
</script>
<script type="text/javascript" src="modules/asol_Reports/include/client/helpers/reportsUtils.js?version=<?= $version ?>"></script>

<?php

require_once('modules/asol_Common/include/commonUtils.php');
require_once("modules/asol_Reports/include/server/reportsUtils.php");

?> 
