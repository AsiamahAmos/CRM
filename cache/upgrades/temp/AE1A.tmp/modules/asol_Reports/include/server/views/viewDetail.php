<?php

require_once("modules/asol_Reports/include/server/controllers/controllerReports.php");

$reportLibrariesHtml = '';
$reportHeadersHtml = '';

if (!$isDashlet && $selected) {

	$isMetaReport = ($focus->is_meta === '1');
	$reportLibrariesHtml = (!$isMetaReport ? asol_ReportsUtils::getElementLibraries($focus->id) : '');
	$reportHeadersHtml .= '
	<script type="text/javascript">
		$LAB
		.script("modules/asol_Reports/include/client/helpers/reportsRouter.js?version='.str_replace('.', '', asol_ReportsUtils::$reports_version).'").wait()
		.script("modules/asol_Reports/include/client/helpers/reportsApi.js?version='.str_replace('.', '', asol_ReportsUtils::$reports_version).'").wait(function() {
			reportsApi.setLanguage({
				"blocking" : {
					"load" : "'.translate("LBL_COMMON_LOADING_DATA", "asol_Common").'",
					"save" : "'.translate("LBL_COMMON_SAVING_DATA", "asol_Common").'",
					"loadReport" : "'.translate("LBL_REPORT_LOADING", "asol_Reports").'",
				}
			});
		})
		.script("modules/asol_Reports/include/client/controllers/controllerDetail.js?version='.str_replace('.', '', asol_ReportsUtils::$reports_version).'").wait(function() {
			controllerReportDetail.setLanguage({
				"searchMode" : {
					"basic" : "'.asol_ReportsUtils::translateReportsLabel("LBL_REPORT_BASIC_SEARCH").'",
					"advanced" : "'.asol_ReportsUtils::translateReportsLabel("LBL_REPORT_ADVANCED_SEARCH").'",
				}
			});
		});
	</script>';
	
	$reportHeadersHtml .= '<link type="text/css" href="modules/asol_Reports/include/client/css/styleDetail.css?version='.str_replace('.', '', asol_ReportsUtils::$reports_version).'" rel="stylesheet">';

}


if (isset($_REQUEST['sourceCall']) && $_REQUEST['sourceCall'] == 'httpReportRequest' || $_REQUEST['onlyExecuted']) {
	
	$htmlContent = 
	'<div id="detailContainer'.($isDashlet ? $dashletId : '').'" class="detailContainer alineasol_reports">'
		.asol_ControllerReports::generateExecutedReport($focus->id, $isDashlet, $dashletId).
	'</div>';
	
} else {
	
	$htmlContent = $reportLibrariesHtml.
			
	'<div style="display: '.($selected ? 'block' : 'none').';" id="detailContainer'.($isDashlet ? $dashletId : '').'" class="detailContainer '.(!$isDashlet ? 'alineasol_reports' : '').'" preview="'.asol_ReportsUtils::getPreviewContextString($isPreview).'">
	
		'.$reportHeadersHtml.'
		'.($selected ? asol_ControllerReports::getReportDetailTitle($focus->name, $isDashlet, $focus->report_fields) : '').'
		'.($selected ? asol_ControllerReports::getReportPublicDescription($focus->description, $isDashlet) : '' ).
		'<div class="asolReportExecution">
		'.($selected ? asol_ControllerReports::generateExecutedReport($focus->id, $isDashlet, $dashletId) : '').
		'</div>'.

	'</div>';

}

//********Manage Form Domain*********//
if (asol_CommonUtils::isDomainsInstalled()) {

	global $current_user;

	$currentReportDomain = (empty($focus->id) ? $current_user->asol_default_domain : $focus->asol_domain_id);
	$manageReportDomain = asol_CommonUtils::manageElementDomain('asol_reports', $focus->id, $current_user->asol_default_domain, $currentReportDomain);

	$reportTypeData = json_decode(rawurldecode($focus->report_type), true);
	$reportType = $reportTypeData['type'];
	
	if ($reportType != 'external' && !$manageReportDomain) {
		$htmlContent = asol_ReportsUtils::translateReportsLabel('LBL_REPORT_NOT_AVAILABLE');
	}

}
//********Manage Form Domain*********//
if ($returnHtml) {
	return $htmlContent;
} else {
	echo $htmlContent;
}

