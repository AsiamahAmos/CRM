<?php

global $mod_strings;
$reportsVersion = str_replace('.', '', asol_ReportsUtils::$reports_version);
$commonVersion = str_replace('.', '', asol_CommonUtils::$common_version);

		
//***********************//
//***AlineaSol Premium***//
//***********************//
$fieldReferencesList = asol_ReportsUtils::managePremiumFeature("SQLWithReferences", "reportFunctions.php", "getFieldReferencesList", null);
$htmlContent = ($fieldReferencesList !== false ? $fieldReferencesList : '');
//***********************//
//***AlineaSol Premium***//
//***********************//

require_once("modules/asol_Reports/include/manageReportsFunctions.php");

$htmlContent .= '
<script type="text/javascript" src="modules/asol_Reports/include/client/controllers/controllerEdit.js?version='.$reportsVersion.'"></script>
'.asol_CommonUtils::getHeaderCodeMirrorLinksHtml().'
'.asol_ReportsManagementFunctions::getHeaderLinksHtml().'
'.asol_ReportsManagementFunctions::getReportsJQueryScript().'
'.asol_ReportsManagementFunctions::getVariableClipboardCopyDiv().'
<script type="text/javascript">
	'.asol_ReportsManagementFunctions::getInitJqueryScriptHtml().'
	'.asol_ReportsManagementFunctions::getOnloadJavaScript().'
	'.asol_ReportsManagementFunctions::getInitEmailFrameHtml().'
	'.asol_ReportsManagementFunctions::getInitDragDropElementsHtml().'
	'.asol_ReportsManagementFunctions::getInitReportsJavaScriptsHtml($hasPremiumFeatures, $isMetaReport, $externalApps, $reportType['type'], $reportScheduledType[0]).' /// getInitReportsJavaScriptsHtml: -initScheduledTypeInfo
	window["subQueryMode"] = false;
	window["subQueryLevel"] = 0;
	window["subQueryEditor"] = true;
	window["mainFieldReferences"] = null;
	window["subFieldReferences"] = null;
	window["mainFilteringReferences"] = null;
	window["mainQueryFieldIndex"] = null;
	window["subQueryFieldIndex"] = null;
	window["mainQueryLastSql"] = "";
	window["reportsVersion"] = "'.asol_ReportsUtils::$reports_version.'";
	window["reportsDefaultLang"] = "'.$defaultLanguage.'";
</script>

<link type="text/css" href="modules/asol_Reports/include/client/css/styleEdit.css?version='.$reportsVersion.'" rel="stylesheet">
<div style="display: '.($selected ? 'block' : 'none').';" id="editContainer" class="alineasol_reports">

	<div class="moduleTitle">
		<h2 id="report_title">'.($newReportFlag ? $mod_strings['LBL_REPORT_CREATE'] : $mod_strings['LBL_REPORT_EDIT'].': '.$focus->name).'</h2>
	</div>
	<div class="clear"></div>
	'.getReportDefinitionHtml($focus).'
	<script type="text/javascript">
		'.($selected ? 'reportsUtils.populateEditView(null, false'.((isset($_REQUEST['isMeta']) && $_REQUEST['isMeta']) ? ', true' : '').');' : '').'
	</script>
			
</div>';

if ($returnHtml) {
	return $htmlContent;
} else {
	echo $htmlContent;
}

//********************************//
//*******Report Definition********//
//********************************//
function getReportDefinitionHtml($focus) {
	
	error_reporting(1);
	
	global $current_user, $db, $mod_strings, $sugar_config;
	
	require_once('modules/asol_Common/include/commonUtils.php');
	require_once("modules/asol_Reports/include/server/reportsUtils.php");
	require_once("modules/asol_Reports/include/manageReportsFunctions.php");
	
	$data_source = json_decode(rawurldecode($focus->data_source), true);
	$reportType = json_decode(rawurldecode($focus->report_type), true);
	
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	$readOnlyMode = asol_ReportsUtils::managePremiumFeature("reportReadOnlyMode", "reportFunctions.php", "getReadOnlyModeFlag", null);
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	

	$return_action = (isset($_REQUEST['return_action']) ? $_REQUEST['return_action'] : ""); //devuelve la accion a ejecutar
	
	//**********************************//
	//***Get Config_Override Features***//
	//**********************************//
	$translateFieldLabels = ((!isset($sugar_config['asolReportsTranslateLabels'])) || ($sugar_config['asolReportsTranslateLabels']) ? true : false);
	$defaultLanguage = (isset($sugar_config["asolReportsDefaultExportedLanguage"]) ? $sugar_config["asolReportsDefaultExportedLanguage"] : "en_us");
	$mySQLinsecurityScope = (isset($sugar_config["asolReportsMySQLinsecuritySubSelectScope"]) ? $sugar_config["asolReportsMySQLinsecuritySubSelectScope"] : 1);
	//**********************************//
	//***Get Config_Override Features***//
	//**********************************//
	
	//***********************************//
	//**Get Module Field Current Values**//
	//***********************************//
	
	$isMetaReport = ($newReportFlag && isset($_REQUEST['isMeta']) && $_REQUEST['isMeta'] === '1' ? '1' : $focus->is_meta);
	
	//***********************************//
	//**Get Module Field Current Values**//
	//***********************************//
	
	//Set configuration flags
	$hasDeletedUsage = $reportFieldsArray['tables'][0]['config']['deletedUsage'];
	$initialExecutionFlag = $reportFiltersArray['config']['initialExecution'];
	//Set configuration flags
	
	
	//****************************************//
	//***Get Non Visible Fields for Reports***//
	//****************************************//
	$fieldsToBeRemoved = asol_ReportsManagementFunctions::getNonVisibleFields($data_source['value']['module'], $hasDeletedUsage);
	//****************************************//
	//***Get Non Visible Fields for Reports***//
	//****************************************//
	
	//*********************************//
	//***Get External Databases Info***//
	//*********************************//
	
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	$externalDatabasesInfo = asol_ReportsUtils::managePremiumFeature("externalDatabasesReports", "reportFunctions.php", "getExternalDatabasesInfo", null);
	$availableDatabases = ($externalDatabasesInfo !== false ? $externalDatabasesInfo : array());
	
	$externalApisInfo = asol_ReportsUtils::managePremiumFeature("externalApisReports", "reportFunctions.php", "getExternalApisInfo", null);
	$availableApis = ($externalApisInfo !== false ? $externalApisInfo : array());
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	
	//*********************************//
	//***Get External Databases Info***//
	//*********************************//
	
	
	//***************************//
	//***Get External App Info***//
	//***************************//
	$reportTypeUri = (!empty($reportType['data']) ? $reportType['data'] : "");
	$reportScheduledTypeUri = (!empty($reportScheduledType[1]) ? $reportScheduledType[1] : "");
	
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	$extraParams = array(
		'reportScheduledTypeUri' => $reportScheduledTypeUri,
	);
	
	$externalApplicationInfo = asol_ReportsUtils::managePremiumFeature("externalDatabasesReports", "reportFunctions.php", "getExternalApplicationInfo", $extraParams);
	
	$externalApps = (!$externalApplicationInfo ? array() : $externalApplicationInfo['externalApps']);
	$defaultExternalAppParams = (!$externalApplicationInfo ? '' : $externalApplicationInfo['defaultExternalAppParams']);
	
	$sel_scheduledApp = (!$externalApplicationInfo ? null : $externalApplicationInfo['sel_scheduledApp']);
	$sel_scheduledCustomUrl = (!$externalApplicationInfo ? null : $externalApplicationInfo['sel_scheduledCustomUrl']);
	$sel_scheduledCustomFixedParams = (!$externalApplicationInfo ? null : $externalApplicationInfo['sel_scheduledCustomFixedParams']);
	$sel_scheduledCustomParams = (!$externalApplicationInfo ? null : $externalApplicationInfo['sel_scheduledCustomParams']);
	$sel_scheduledHeaders = (!$externalApplicationInfo ? null : $externalApplicationInfo['sel_scheduledHeaders']);
	$sel_scheduledQuotes = (!$externalApplicationInfo ? null : $externalApplicationInfo['sel_scheduledQuotes']);
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	
	//***************************//
	//***Get External App Info***//
	//***************************//
	
	//******************************//
	//***Get Predefined Templates***//
	//******************************//
	
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	$predefinedTemplatesResult = asol_CommonUtils::managePremiumFeature("templatesCommon", "commonFunctions.php", "getPredefinedTemplates", array('json_encode' => false, 'currentModule' => null/*$selectedModule*/));
	$predefinedTemplates = ($predefinedTemplatesResult !== false ? $predefinedTemplatesResult : null);
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	
	//******************************//
	//***Get Predefined Templates***//
	//******************************//
	
	$report_scope = ($current_user->is_admin) ? "private" : (strpos($report_scope, 'role') !== false) ? str_replace("role", "private", $report_scope) : $report_scope;
	$assigned_user_id = $current_user->id;
	$assigned_user_name = $current_user->name;
	
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	$hasPremiumFeatures = asol_ReportsUtils::managePremiumFeature("managePremiumFeature", "reportFunctions.php", "hasPremiumFeatures", null);
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	
	//****************************//
	//***Display Edition Screen***//
	//****************************//
	//Calculate SubSelectQueries Scope
	$mySQLcheckInsecurity = false;
	if ((($mySQLinsecurityScope === 1) && (!$current_user->is_admin)) || ($mySQLinsecurityScope === 2)) {
		$mySQLcheckInsecurity = true;
	} else if (($mySQLinsecurityScope === 3) && (!$current_user->is_admin)) {
		$userRoles = asol_CommonUtils::getCurrentUserRolesNames();
		foreach ($userRoles as $userRole) {
			if (!in_array($userRole, $sugar_config["asolReportsMySQLinsecuritySubSelectRoles"])) {
				$mySQLcheckInsecurity = true;
				break;
			}
		}
	}
	//Calculate SubSelectQueries Scope
	
	$PHPcheckInsecurity = ($current_user->is_admin) ? false : true;
	
	$availablePhpFunctions = (isset($sugar_config['asolReportsPhpAllowedFunctions'])) ? $sugar_config['asolReportsPhpAllowedFunctions'] : array();
	$availablePhpFunctionsJson = htmlentities(json_encode($availablePhpFunctions));
	
	//****************************//
	//***Display Edition Screen***//
	//****************************//

	$returnedHtml = '
		<form action="index.php" method="post" name="create_form" id="create_form">
			<div class="buttons">
				'.asol_ReportsUtils::getSubmitButtons($reportType, $isMetaReport).'
			</div>
			<div id="DEFAULT" class="alineasol_reports yui-navset detailview_tabs yui-navset-top">
				'.asol_ReportsManagementFunctions::getFilteringDialogDiv().'
				'.asol_ReportsManagementFunctions::getHiddenInputs($focus->id, $rhs_key, $reportScheduledType[1], $mySQLcheckInsecurity, $PHPcheckInsecurity, $availablePhpFunctionsJson, $predefinedTemplates, $dynamic_tables, ($dynamic_tables === '1' ? $dynamic_sql : ''), $isMetaReport, $metaHtml);
	
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	$extraParams = array('isMetaReport' => $isMetaReport, 'reportType' => $reportType['type'], 'hasCharts' => in_array($report_charts, array("Both", "Htob", "Char")));
	$manageReportTabs = asol_ReportsUtils::managePremiumFeature("manageReportTabs", "reportFunctions.php", "getManageReportTabs", $extraParams);
	$returnedHtml .= ($manageReportTabs !== false) ? $manageReportTabs['html'].$manageReportTabs['css'] : '';
	
	$manageWithTabs = ($manageReportTabs !== false ? true : false);
	$mainTabclass = ($manageReportTabs !== false ? 'yui-content' : '');
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	
	if ($manageReportTabs === false) {
		$manageReportTabs = asol_ReportsManagementFunctions::getManageReportTabs($extraParams);
		
		$returnedHtml .= $manageReportTabs['html'].$manageReportTabs['css'];
		
		$manageWithTabs = true;
		$mainTabclass = 'yui-content';
	}
	
	$returnedHtml .= '<div class="'.$mainTabclass.'">
				<div id="mainInfo" class="reportPanel">
					<h4 class="reportPanelHeader">'.$mod_strings['LBL_REPORT_BASIC_INFO'].'</h4>
						<table id="report_info" class="edit view">
							<tbody>
								<tr>
									<td nowrap="nowrap" width="15%" scope="col">
										'.$mod_strings['LBL_REPORT_NAME'].':<span class="required">*</span>
									</td>							
									<td nowrap="nowrap" width="35%">
										<input '.($disabledGeneralData? 'disabled' : '').' type="text" class="name" value="'.$focus->name.'" maxlength="" size="30" id="name" name="name">
									</td>
									<td nowrap="nowrap" width="15%" scope="col">
										'.$mod_strings['LBL_REPORT_ASSIGNED_TO'].':<span class="required">*</span>
									</td>
									<td nowrap="nowrap" width="35%">
										<input type="hidden" name="assigned_user_id" value="'.(!empty($focus->assigned_user_id) ? $focus->assigned_user_id : $current_user->id).'">
										<input type="text" autocomplete="off" title="" value="'.(!empty($focus->assigned_user_name) ? $focus->assigned_user_name: $current_user->user_name).'" size="30" id="assigned_user_name" class="sqsEnabled yui-ac-input" name="assigned_user_name">
										<i class="icn-search" onclick="open_popup(\'Users\', 600, 400, \'\', true, false, {\'call_back_function\':\'set_return\',\'form_name\':\'create_form\',\'field_to_name_array\':{\'id\':\'assigned_user_id\',\'user_name\':\'assigned_user_name\'}}, \'single\', true);" class="button" title="'.$app_strings['LBL_SELECT_BUTTON_LABEL'].'" id="btn_assigned_user_name" name="btn_assigned_user_name"></i>
										<i class="icn-cancel" onclick="document.create_form.assigned_user_id.value = \'\' document.create_form.assigned_user_name.value = \'\';" class="button" title="'.$app_strings['LBL_CLEAR_BUTTON_LABEL'].'" id="btn_clr_assigned_user_name" name="btn_clr_assigned_user_name"></i>
									</td>
								</tr>
			  					<tr valign="top"'.($isMetaReport ? ' style="display: none;"' : '').'>
									<td nowrap="nowrap" width="15%" scope="col">
										'.$mod_strings['LBL_REPORT_DATA_SOURCE'].':
									</td>
									<td nowrap="nowrap" width="35%">
										<select '.($disabledGeneralData ? 'disabled' : '').' id="data_source_type" onChange="controllerReportEdit.manageDataSourceType(); controllerReportEdit.manageDataSourceValue();" style="display: '.(!empty($availableApis) ? 'inline' : 'none').';">
											<option value="0" data="'.rawurlencode(json_encode($availableDatabases)).'">'.$mod_strings['LBL_REPORT_DATA_SOURCE_DB'].'</option>
											'.(!empty($availableApis) ? '<option value="1" data="'.rawurlencode(json_encode($availableApis)).'">'.$mod_strings['LBL_REPORT_DATA_SOURCE_API'].'</option>' : '').'
										</select>
										<select '.($disabledGeneralData ? 'disabled' : '').' id="data_source_value" name="data_source_value" onChange="controllerReportEdit.manageDataSourceValue();"></select>
									</td>
									'.asol_ReportsManagementFunctions::getReportDisplayOptionsHtml('' , false).'
								</tr>
								<tr>
									'.asol_ReportsManagementFunctions::getReportTypeHtml($reportType, $reportTypeUri, $reportScheduledType, $isMetaReport, $disabledGeneralData).'
									<td nowrap="nowrap" width="15%" scope="col">
										'.$mod_strings['LBL_REPORT_FILE_FORMAT'].':<span class="required">*</span>
									</td>
									<td id="reportAttachmentFormatTd" nowrap="nowrap" width="35%">
										'.asol_ReportsManagementFunctions::getReportAttachmentFormatHtml($report_attachment_format, $isMetaReport, $disabledGeneralData).'
									</td>
								</tr>
								<tr>
									'.asol_ReportsManagementFunctions::getReportEmailLinkHtml($scheduled_images, $disabledGeneralData).'
									'.asol_ReportsManagementFunctions::getReportScopeHtml($report_scope, $disabledGeneralData).'
								</tr>
								<tr>
									'.asol_ReportsManagementFunctions::getReportInternalDescriptionHtml($internalDescription, $disabledGeneralData).'
									'.asol_ReportsManagementFunctions::getReportPublicDescriptionHtml($publicDescription, $disabledGeneralData).'
								</tr>
							</tbody>
						</table>
					</div>
					<input type="hidden" id="asolCommonAvailableRoles" value="'.rawurlencode(json_encode(asol_CommonUtils::getCurrentRoles())).'">
					<input type="hidden" id="sugarModuleList" value=\''.json_encode(asol_CommonUtils::getModuleList()).'\'>';
	
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	$subQueryHiddenFieldsHtml = asol_ReportsUtils::managePremiumFeature("subQuerySQLEditor", "reportFunctions.php", "getSubQueryHiddenFields", null);
	$returnedHtml .= ($subQueryHiddenFieldsHtml !== false ? $subQueryHiddenFieldsHtml : '');
	
	$subQueryActionButtons = asol_ReportsUtils::managePremiumFeature("subQuerySQLEditor", "reportFunctions.php", "getSubQueryActionButtons", null);
	$subQueryActionButtonsHtml = ($subQueryActionButtons !== false ? $subQueryActionButtons : '');
	
	$subQuerySqlEditor = asol_ReportsUtils::managePremiumFeature("subQuerySQLEditor", "reportFunctions.php", "getSubQuerySqlEditorPanel", array('jsonSqlTemplates' => $predefinedTemplates['sql']));
	$subQuerySqlEditorHtml = ($subQuerySqlEditor !== false ? $subQuerySqlEditor : '');
	
	$matchedTablesResult = asol_ReportsUtils::managePremiumFeature("dynamicTablesReport", "reportFunctions.php", "getMatchTablesResult", array('isDynamic' => ($dynamic_tables == '1'), 'usedDb' => $data_source['value']['database'], 'dynamicTableValue' => $dynamic_sql));
	$selectedModule = ($matchedTablesResult !== false ? array_pop($matchedTablesResult) : $selectedModule);
	
	$extraParams = array('database' => '-1', 'selectedModule' => $selectedModule, 'hasDeleted' => $hasDeletedUsage, 'isDynamic' => ($dynamic_tables == '1'), 'auditedReport' => $audited_report);
	$fieldsPanelTreeHtml = asol_ReportsUtils::managePremiumFeature("reportFieldsTreeSelector", "reportFunctions.php", "getReportFieldsTreeSelector", $extraParams);
	$fieldsPanelHtml = ($fieldsPanelTreeHtml !== false) ? $fieldsPanelTreeHtml : asol_ReportsManagementFunctions::getFieldsPanelHtml('', ($dynamic_tables == '1' ? '' : $selectedModule), $hasDeletedUsage, ($dynamic_tables == '1'), $audited_report, $sel_autorefresh, $disabledGeneralData);
	$returnedPropertiesJsonFieldsHtml = asol_CommonUtils::managePremiumFeature("propertyTemplatesForm", "commonFunctions.php", "getPropertiesJsonFields", null);
	$fieldsPanelHtml .= ($returnedPropertiesJsonFieldsHtml !== false ? $returnedPropertiesJsonFieldsHtml : '');
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	
	$returnedHtml .= '<div id="fieldsFilters" class="reportPanel" style="z-index: 500; position: relative;">
				<h4 class="reportPanelHeader">'.asol_ReportsManagementFunctions::getCollapsableHeader('LBL_REPORT_FIELDS_FILTERS', 'fieldsFilters').'</h4>
				<table class="edit view editViewClear">
					<tbody>
						'.$subQueryActionButtonsHtml.'
						<tr>
							<td class="fieldsPanel">
								'.$fieldsPanelHtml.'
							</td>
							<td width="100%" valign="top">
								<div id="reportEditorDiv">
									<b>'.$mod_strings['LBL_REPORT_TITLE'].':</b><input type="text" id="asolReportTitle" style="margin:10px 5px" value="'.$reportFieldsArray['tables'][0]['title']['text'].'">';
	
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	$returnedPremiumMultiLanguageHtml = asol_ReportsUtils::managePremiumFeature("getMultiLanguageTitleButton", "reportFunctions.php", "getMultiLanguageTitleButton", array('title' => $reportFieldsArray['tables'][0]['title']));
	$returnedPremiumMultiLanguageHtml = ($returnedPremiumMultiLanguageHtml !== false) ? $returnedPremiumMultiLanguageHtml : '';
	$returnedHtml .= $returnedPremiumMultiLanguageHtml;
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	
	$returnedHtml .=						'<div id="reportFieldsDiv" class="mainReport">
										'.asol_ReportsManagementFunctions::getFieldsHeadersHtml($data_source['value']['database'], $focus->row_index_display).'
									</div>
									<div id="reportFiltersDiv" class="mainReport">
										'.asol_ReportsManagementFunctions::getFiltersHeadersHtml($results_limit).'
									</div>
								</div>
								'.$subQuerySqlEditorHtml.'
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div id="charts" class="reportPanel">
				'.asol_ReportsManagementFunctions::getChartsHeadersHtml($report_charts_engine).'
			</div>';
	
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	$extraParams = array('metaHtml' => '', 'cssValue' => $reportCss);
	$metaHtmlPanel = asol_ReportsUtils::managePremiumFeature("metaReport", "reportFunctions.php", "getMetaHeadersHtml", $extraParams);
	$returnedHtml .= ($metaHtmlPanel !== false) ? $metaHtmlPanel : '';
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	
	$returnedHtml .= ((in_array($reportType['type'], array('scheduled', 'stored'))) && !$manageWithTabs) ? '<div id="scheduledDiv" class="reportPanel">' : '<div id="scheduledDiv" style="display: none" class="reportPanel">';
	
	$returnedHtml .= asol_ReportsManagementFunctions::getTasksHeadersHtml().'
			</div>';
	
	$distributionListVisibility = ($manageWithTabs) ? '' : 'display: none';
	
	$returnedHtml .= ((!in_array($reportType['type'], array('external'))) || $manageWithTabs) ? '<div id="distributionList" class="reportPanel">' : '<div id="distributionList" style="display: none" class="reportPanel">';
	
	$returnedHtml .= '<h4 class="reportPanelHeader">'.asol_ReportsManagementFunctions::getCollapsableHeader('LBL_REPORT_DISTRIBUTION_LIST', 'distributionList', true).'</h4>
				<table id="distribution_List_Table" class="edit view" style="'.$distributionListVisibility.'">
					<tr>
						<td>
							<div id="task_implementation_field" class="yui-navset detailview_tabs yui-navset-top">
								'.asol_ReportsManagementFunctions::getDistributionListPanel($focus->email_list).'
							</div>
						</td>
					</tr>
				</table>
			</div>';
	
	if (asol_CommonUtils::isDomainsInstalled()) {
		
		$domainPublishVisibility = ($manageWithTabs ? '' : 'display: none');
		
		$returnedHtml .= '<div id="domainPublishing" class="reportPanel">
					<h4 class="reportPanelHeader">'.asol_ReportsManagementFunctions::getCollapsableHeader('LBL_ASOL_DOMAINS_PUBLISH_FEATURE_PANEL', 'domainPublishing', true).'</h4>
					<table class="edit view" style="'.$domainPublishVisibility.'">
						<tbody>
							<tr>
								'.asol_manageDomains::getBeanDomainNameHtml().'
								'.asol_manageDomains::getEmptyCellHtml().'
							</tr>
							<tr>
								'.asol_manageDomains::getBeanPublishManagementButtonHtml($focus->id, 'asol_reports').'
								'.asol_manageDomains::getBeanPublishDomainHtml($focus->asol_published_domain).'
							</tr>
						</tbody>
					</table>
				</div>';
	}
	
	$returnedHtml .= '</div>
			</div>
			<div class="buttons actionsContainer end">
				'.asol_ReportsUtils::getSubmitButtons($isMetaReport).'
			</div>
		</form>';
	
	return $returnedHtml;
	
}

