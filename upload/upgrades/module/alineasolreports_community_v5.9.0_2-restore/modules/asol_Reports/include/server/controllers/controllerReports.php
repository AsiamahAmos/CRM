<?php

/**
 * @author AlineaSol
 */
class asol_ControllerReports {

	private static $moduleName = "asol_Reports";
	private static $moduleTable = "asol_reports";

	static public function displayReport($reportId, $staticFilters, $sort_field, $sort_direction, $sort_index, $page_number = '', $isDashlet = false, $dashletId = '', $getLibraries = true, $getReloadFunctions = true, $returnHtml = false, $getExportData = false, $override_entries = null, $override_info = null, $override_filters = null, $avoidAjaxRequest = false, $contextDomainId = null) {
		
		error_reporting(1); //E_ERROR
		
		global $current_user, $timedate, $mod_strings, $app_strings, $theme, $db, $app_list_strings, $beanList, $beanFiles, $current_language, $sugar_config;
		
		require_once('modules/asol_Common/include/commonUtils.php');
		require_once('modules/asol_Reports/include/server/reportsUtils.php');
		require_once('modules/asol_Reports/include/ReportChart.php');
		require_once('modules/asol_Reports/ReportsDashletChart.php');
		require_once('modules/asol_Reports/include/generateReportsFunctions.php');
		
		
		//****************************//
		//****Instance Report Bean****//
		//****************************//
		$focus = asol_Reports::getReportBean($reportId);
		$isPreview = ((isset($_REQUEST['isPreview'])) && ($_REQUEST['isPreview'] == 'true'));
		
		if ($isPreview) {
			asol_ControllerReports::previewFocus($focus);
		} else {
			$focus->data_source = (!is_array($focus->data_source) ? json_decode(rawurldecode($focus->data_source), true) : $focus->data_source);
			
			$focus->report_fields = json_decode(rawurldecode($focus->report_fields), true);
			$focus->report_filters = json_decode(rawurldecode($focus->report_filters), true);
			$focus->report_charts_detail = json_decode(rawurldecode($focus->report_charts_detail), true);
			$focus->description = unserialize(base64_decode($focus->description));
		}
		
		$storedSelectedFields = $focus->report_fields;
		$storedSelectedFilters = $focus->report_filters;
		$storedSelectedCharts = $focus->report_charts_detail;
		$storedSelectedDescription = $focus->description;
		
		
		//****************************//
		//****Variables Definition****//
		//****************************//
		$initialTimestamp = microtime(true);
		
		$hasSecurityGroupsDisabled = ((isset($sugar_config["asolReportsSecurityGroupsDisabled"])) && ($sugar_config["asolReportsSecurityGroupsDisabled"] == true));
		$hasCurlRequestEnabled = (isset($sugar_config["asolReportsCurlRequestUrl"]) ? true : false);
		$hasNoPagination = ((isset($sugar_config["asolReportsAvoidReportsPagination"])) && ($sugar_config["asolReportsAvoidReportsPagination"] == true));
		$dispatcherMaxRequests = (isset($sugar_config['asolReportsDispatcherMaxRequests']) ? $sugar_config['asolReportsDispatcherMaxRequests'] : 0);
		$dashletExportButtons = (isset($sugar_config['asolReportsDashletExportButtons']) ? $sugar_config['asolReportsDashletExportButtons'] : true);
		
		$isHttpReportRequest = ((isset($_REQUEST['sourceCall'])) && ($_REQUEST['sourceCall'] == "httpReportRequest"));
		$isWsExecution = ((isset($_REQUEST['asolReportsWebServiceExecution'])) && ($_REQUEST['asolReportsWebServiceExecution']));
		$isMetaReport = ($focus->is_meta === '1');
		
		$entryPointExecuted = (isset($_REQUEST['entryPoint']) && in_array($_REQUEST['entryPoint'], array('viewReport')));
		$executeReportDirectly = ((!$hasCurlRequestEnabled) || ($avoidAjaxRequest));
		$isScheduledExecution = ((isset($_REQUEST['schedulerCall'])) && ($_REQUEST['schedulerCall'] == 'true'));
		
		$override_export = (isset($_REQUEST['overrideExport']) && ($_REQUEST['overrideExport'] || $_REQUEST['overrideExport'] == '1'));
		
		$reorderDetailGroups = true;
		
		
		//*********************//
		//***Data Visibility***//
		//*********************//
		$dataVisibility = array(
			'field' => ($focus->report_charts !== 'Char'),
			'filter' => true,
			'chart' => ($focus->report_charts !== 'Tabl'),
		);
		//*********************//
		//***Data Visibility***//
		//*********************//
		
		
		
		//***********************//
		//***AlineaSol Premium***//
		//***********************//
		if ($isMetaSubReport) {
			$overriddenReportData = asol_ReportsUtils::managePremiumFeature("overrideMetaReportData", "reportFunctions.php", "overrideMetaReportData", array('overrideInfo' => $override_info, 'overrideFilters' => $override_filters, 'fields' => $storedSelectedFields, 'filters' => $storedSelectedFilters, 'charts' => $storedSelectedCharts));
		} else {
			$overriddenReportData = asol_ReportsUtils::managePremiumFeature("overrideReportData", "reportFunctions.php", "overrideReportData", array('overrideInfo' => $override_info, 'overrideFilters' => $override_filters, 'fields' => $storedSelectedFields, 'filters' => $storedSelectedFilters, 'charts' => $storedSelectedCharts));
		}
		$storedSelectedFields = (($overriddenReportData!== false) ? $overriddenReportData['data']['fields'] : $storedSelectedFields);
		$storedSelectedFilters = (($overriddenReportData!== false) ? $overriddenReportData['data']['filters'] : $storedSelectedFilters);
		$storedSelectedCharts = (($overriddenReportData!== false) ? $overriddenReportData['data']['charts'] : $storedSelectedCharts);
		
		$dataVisibility = (($overriddenReportData!== false) && isset($overriddenReportData['display']) ? $overriddenReportData['display'] : $dataVisibility);
		//***********************//
		//***AlineaSol Premium***//
		//***********************//
		
		
		//***********************//
		//***AlineaSol Premium***//
		//***********************//
		$filteringSourceData = asol_ReportsUtils::managePremiumFeature("filteringSourceData", "reportFunctions.php", "getFilteringSourceData", array('staticFilters' => $staticFilters, 'filteringConfig' => $storedSelectedFilters['config']));
		$staticFilters = (($filteringSourceData !== false) ? $filteringSourceData : $staticFilters);
		$hasStaticFilters = (!empty($staticFilters));
		//***********************//
		//***AlineaSol Premium***//
		//***********************//
		
		
		//***********************//
		//***AlineaSol Premium***//
		//***********************//
		$predefinedTemplatesResult = asol_CommonUtils::managePremiumFeature("templatesCommon", "commonFunctions.php", "getPredefinedTemplates", null);
		$predefinedTemplates = ($predefinedTemplatesResult !== false ? $predefinedTemplatesResult : null);
		//***********************//
		//***AlineaSol Premium***//
		//***********************//
		
		
		//***********************//
		//***AlineaSol Premium***//
		//***********************//
		$isMetaSubReport = (isset($override_info) && (array_keys($override_info) === range(0, count($override_info) - 1))); // Is indexed array
		$containerSelector = (!empty($dashletId) ? ($isMetaSubReport ? 'div[id="detailMetaContainer"][class="'.$dashletId.'"]' : 'div[id="detailContainer'.$dashletId.'"]').' ' : '');
		
		$currentReportCss = asol_CommonUtils::managePremiumFeature("cssPerElement", "commonFunctions.php", "getCurrentElementCss", array('commonTemplates' => $storedSelectedFields['tables'][0]['templates'], 'selectedValue' => $storedSelectedFields['tables'][0]['css'], 'jsonCssTemplates' => $predefinedTemplates['css'], 'dashletId' => $dashletId, 'containerSelector' => $containerSelector));
		$currentReportCss = ($currentReportCss !== false ? $currentReportCss : '');
		//***********************//
		//***AlineaSol Premium***//
		//***********************//
		
		
		
		//********************************************//
		//****Check if External App/FTP is defined****//
		//********************************************//
		$reportScheduledTypeArray = explode(':', $focus->report_scheduled_type);
		$reportScheduledTypeInfo = json_decode(urldecode($reportScheduledTypeArray[1]), true);
		$executionMode = ($reportScheduledTypeArray[0] == 'app' && $reportScheduledTypeInfo['popup'] ? 'popup' : '');
		
		
		//*****************************************//
		//********Report Attachment Format*********//
		//*****************************************//
		$attachmentFormatArray = explode(':', $focus->report_attachment_format);
		$reportAttachmentFormat = $attachmentFormatArray[0];
		$reportAttachmentConfig = (!empty($attachmentFormatArray[1]) ? json_decode(urldecode($attachmentFormatArray[1]), true) : null);
		
		$isMassiveScheduleCsvExport = ($isScheduledExecution && ($reportAttachmentFormat == 'CSVC') && ($reportAttachmentConfig['massive']));
		
		
		//****************************************//
		//********Get External Parameters*********//
		//****************************************//
		$externalParams = asol_ReportsGenerationFunctions::getExternalRequestParams();
		
		$current_language = $externalParams["current_language"];
		$mod_strings = $externalParams["mod_strings"];
		$current_user = $externalParams["current_user"];
		
		
		//****************************************//
		//****Clean DataBase Report Dispatcher****//
		//****************************************//
		if (empty($staticFilters)) {
			asol_ReportsGenerationFunctions::cleanDataBaseReportDispatcher();
		}
		
		
		$reportTypeData = json_decode(rawurldecode($focus->report_type), true);
		$reportType = $reportTypeData['type']; //report_type
		
		if ($isMetaReport && ($entryPointExecuted || $executeReportDirectly || $getExportData)) {
			
			//***********************//
			//***AlineaSol Premium***//
			//***********************//
			$extraParams = array(
				'reportId' => $reportId,
				'isDashlet' => $isDashlet,
				'dashletId' => $dashletId,
				'getLibraries' => $getLibraries,
				'returnHtml' => $returnHtml,
				'getExportData' => $getExportData,
				'contextDomainId' => $contextDomainId,
				'currentReportCss' => $currentReportCss
			);
			$metaReportExecution = asol_ReportsUtils::managePremiumFeature("metaReport", "reportFunctions.php", "executeMetaReport", $extraParams);
			if ($metaReportExecution === false) {
				die("Cannot get metaReport Premium Feature. executeMetaReport() Function Called.");
			} else {
				
				$justDisplay = (!$isHttpReportRequest);
				
				if ((isset($justDisplay)) && ($justDisplay)) {
					if ($returnHtml) {
						return $metaReportExecution;
					}
				}
				
			}
			//***********************//
			//***AlineaSol Premium***//
			//***********************//
			
		} else if (($reportType === 'webservice_remote') && $entryPointExecuted) {
			
			//***********************//
			//***AlineaSol Premium***//
			//***********************//
			$extraParams = array(
				'reportId' => $reportId,
				'staticFilters' => $staticFilters,
				'sort_field' => $sort_field,
				'sort_direction' => $orders[0]['direction'],
				'sort_index' => $sort_index,
				'page_number' => $page_number,
				'isDashlet' => $isDashlet,
				'dashletId' => $dashletId,
				'getLibraries' => $getLibraries
			);
			$executedWebServiceReport = asol_ReportsUtils::managePremiumFeature("webServiceReport", "reportFunctions.php", "executeWebServiceReport", $extraParams);
			$executedWebServiceReportHtml = ($executedWebServiceReport !== false ? $executedWebServiceReport : null);
			//***********************//
			//***AlineaSol Premium***//
			//***********************//
			
			
			$tmpFilesDir = "modules/asol_Reports/tmpReportFiles/";
			$httpHtmlFile = $_REQUEST['httpHtmlFile'];
			$justDisplay = (!$isHttpReportRequest);
			
			if ((isset($justDisplay)) && ($justDisplay)) {
				
				if ($returnHtml) {
					return $executedWebServiceReportHtml;
				} else {
					echo $executedWebServiceReportHtml;
				}
				
			} else {
				
				$exportHttpFile = fopen($tmpFilesDir.$httpHtmlFile, "w");
				fwrite($exportHttpFile, $executedWebServiceReportHtml);
				fclose($exportHttpFile);
				
				if ($returnHtml)
					return false;
					
			}
			
		} else if (($reportType === 'stored') && ($_REQUEST['entryPoint'] != 'viewReport')) { // Stored Report!
			
			//****************************************//
			//*********Get Stored Report Data*********//
			//****************************************//
			$storedReportDataHtml = asol_ReportsGenerationFunctions::getStoredReportData($reportTypeData['data'], $reportId, $isDashlet, $dashletId, $focus->report_charts);
			
			if ($returnHtml) {
				return $storedReportDataHtml;
			} else {
				echo $storedReportDataHtml;
			}
			
		} else { // Anything else Report!
			
			$currentReportConfig = asol_ReportsGenerationFunctions::getTableConfiguration($storedSelectedFields, 0);
			
			if ($entryPointExecuted || $executeReportDirectly || $getExportData) {
				
				//*********************************//
				//****Check Access To Reports******//
				//*********************************//
				if ((!ACLController::checkAccess('asol_Reports', 'view', true)) && ($reportType !== 'internal') && (!$hasStaticFilters)) {
					die("<font color='red'>".$app_strings["LBL_EMAIL_DELETE_ERROR_DESC"]."</font>");
				}
				
				
				//*************************************************//
				//******Requiring FilesGet External Parameters*****//
				//*************************************************//
				require_once('modules/asol_Reports/include/ReportExcel.php');
				require_once('modules/asol_Reports/include/ReportFile.php');
				require_once('modules/asol_Reports/include/ReportChart.php');
				require_once('modules/asol_Reports/include/manageReportsFunctions.php');
				require_once('modules/asol_Reports/include/server/controllers/controllerQuery.php');
				
				//*****************************//
				//****Variable Definition******//
				//*****************************//
				$reportHeadersHtml = '';
				$fixedReportId = str_replace("-", "", $focus->id);
				$fixedDashletId = str_replace("-", "", $dashletId);
				
				$return_action = (isset($_REQUEST['return_action'])) ? $_REQUEST['return_action'] : "";
				
				$report_data['record'] = $focus->id;
				$report_data['name'] = $focus->name;
				$report_data['description'] = $storedSelectedDescription;
				$report_data['assigned_user_id'] = $focus->assigned_user_id;
				$report_data['created_by'] = $focus->created_by;
				$report_data['report_scope'] = $focus->report_scope;
				$report_data['report_attachment_format'] = $focus->report_attachment_format;
				$report_data['report_charts'] = $focus->report_charts;
				$report_data['report_charts_engine'] = $focus->report_charts_engine;
				$report_data['scheduled_images'] = $focus->scheduled_images;
				$report_data['row_index_display'] = $focus->row_index_display;
				$report_data['results_limit'] = $focus->results_limit;
				$report_data['table_config'] = $currentReportConfig;
				
				$audited_report = ($focus->data_source['value']['audit'] == '1');
				$hasRowIndexDisplay = ($report_data['row_index_display'] == '1');
				
				$availableReport = true;
				$oversizedReport = false;
				
				$detailMultiQuery = ((isset($currentReportConfig['multiQuery'])) && ($currentReportConfig['multiQuery']));
				$grossExecution = ((isset($currentReportConfig['grossExecution'])) && ($currentReportConfig['grossExecution']));
				$trustedExecution = ((isset($currentReportConfig['trustedExecution'])) && ($currentReportConfig['trustedExecution']));
				$displayTitles = ((!isset($currentReportConfig['titles']['visible'])) || ($currentReportConfig['titles']['visible']));
				$displayHeaders = ((!isset($currentReportConfig['headers']['visible'])) || ($currentReportConfig['headers']['visible']));
				$displaySubtotals = ((!isset($currentReportConfig['subtotals']['visible'])) || ($currentReportConfig['subtotals']['visible']));
				$displayTotals = ((!isset($currentReportConfig['totals']['visible'])) || ($currentReportConfig['totals']['visible']));
				$paginationType = (isset($currentReportConfig['pagination']['visible']) ? $currentReportConfig['pagination']['visible'] : 'all');
				$displayPagination = ($isMetaSubReport ? null : $paginationType);
				
				$allowExportGeneratedFile = ((!$isDashlet && !isset($staticFilters)) || $isWsExecution || $override_export);
				
				$externalCall = false;
				$schedulerCall = false;
				$userTZ = null;
				
				$searchCriteria = isset($_REQUEST['search_criteria']);
				$currentUserId = $_REQUEST['currentUserId'];
				
				
				//***********************//
				//***AlineaSol Premium***//
				//***********************//
				$extraParams = array(
					'isDynamic' => ($focus->dynamic_tables == '1'),
					'dynamicTableValue' => $focus->dynamic_sql,
					'usedDb' => ($focus->data_source['value']['database'] >= 0 ? $focus->data_source['value']['database'] : false),
				);
				$matchTablesResult = asol_ReportsUtils::managePremiumFeature("dynamicTablesReport", "reportFunctions.php", "getMatchTablesResult", $extraParams);
				$reportUsedModules = ($matchTablesResult !== false ? $matchTablesResult : array($focus->data_source['value']['module']));
				$multiModuleReport = ($matchTablesResult !== false && count($matchTablesResult) > 1);
				$hasNoPagination = ($multiModuleReport ? true : $hasNoPagination);
				//***********************//
				//***AlineaSol Premium***//
				//***********************//
				
				
				//****************************************//
				//****External Dispatcher Management******//
				//****************************************//
				if ((!$hasStaticFilters) && (isset($_REQUEST['sourceCall'])) && ($_REQUEST['sourceCall'] == "external")) {
					asol_ReportsGenerationFunctions::manageReportExternalDispatcher($dispatcherMaxRequests);
					asol_ReportsUtils::reports_log('asol', 'Executing Report with Id ['.$reportId.']'.(asol_CommonUtils::isDomainsInstalled() ? ' Domain ['.$contextDomainId.']' : ''), __FILE__, __METHOD__, __LINE__);
				}
				
				
				if (((isset($_REQUEST['sourceCall'])) && ($_REQUEST['sourceCall'] == "external")) || ((isset($_REQUEST['schedulerCall'])) && ($_REQUEST['schedulerCall'] == "true"))) {
					
					//**********************************************************//
					//********Manage External Execution Report Variables********//
					//**********************************************************//
					$externalCall = true;
					$overridedExternalVariables = asol_ReportsGenerationFunctions::overrideExternalReportVariables($report_data['created_by']);
					
					$theUser = $overridedExternalVariables["theUser"];
					$current_user = $overridedExternalVariables["current_user"];
					$allowExportGeneratedFile = $overridedExternalVariables["allowExportGeneratedFile"];
					$schedulerCall = $overridedExternalVariables["schedulerCall"];
					$externalUserDateFormat = $overridedExternalVariables["externalUserDateFormat"];
					$externalUserDateTimeFormat = $overridedExternalVariables["externalUserDateTimeFormat"];
					
				}
				
				
				//*************************************//
				//********Manage Report Domain*********//
				//*************************************//
				if (asol_CommonUtils::isDomainsInstalled()) {
					
					$reportDomain = ($contextDomainId !== null ? $contextDomainId : $current_user->asol_default_domain);
					
					if ($reportType !== 'external') {
						
						$currentReportDomain = (empty($reportId) ? $reportDomain : $focus->asol_domain_id);
						$manageReportDomain = asol_CommonUtils::manageElementDomain('asol_reports', $reportId, $reportDomain, $currentReportDomain);
						
						if (!$manageReportDomain) {
							
							$availableReport = false;
							if ($returnHtml) {
								return (include "modules/asol_Reports/include/DetailViewHttpSave.php");
							} else {
								include "modules/asol_Reports/include/DetailViewHttpSave.php";
								exit();
							}
							
						}
						
					}
					
				}
				
				
				//*********************************************************//
				//********Reset Global Format & UserPrefs Variables********//
				//*********************************************************//
				$userSourceDateFormat = ($externalCall ? $externalUserDateFormat : $current_user->getPreference('datef'));
				
				$current_user_datef = ($current_language == 'fa_ir' ? strrev($current_user->getPreference('datef')) : $current_user->getPreference('datef'));
				$current_user_timef = $current_user->getPreference('timef');
				
				$userDateFormat = ($externalCall ? $externalUserDateFormat : $current_user_datef);
				$userDateTimeFormat = ($externalCall ? $externalUserDateTimeFormat : $current_user_datef.' '.$current_user_timef);
				
				$gmtZone = ($externalCall ? $theUser->getUserDateTimePreferences() : $current_user->getUserDateTimePreferences());
				$userTZlabel = ($externalCall ? $theUser->getPreference("timezone")." ".$gmtZone["userGmt"] : $current_user->getPreference("timezone")." ".$gmtZone["userGmt"]);
				
				$userTZ = ($externalCall ? $theUser->getPreference("timezone") : $current_user->getPreference("timezone"));
				$userTZ = (empty($userTZ) ? date_default_timezone_get() : $userTZ);
				date_default_timezone_set($userTZ);
				
				$phpDateTime = new DateTime(null, new DateTimeZone($userTZ));
				$hourOffset = $phpDateTime->getOffset()*-1;
				
				
				//****************************************//
				//*****Get Current User Configuration*****//
				//****************************************//
				$currentConfig = asol_ReportsGenerationFunctions::getCurrentConfig($current_user->id);
				
				$quarter_month = $currentConfig["quarter_month"];
				$entriesPerPage = $currentConfig["entriesPerPage"];
				$pdf_orientation = $currentConfig["pdf_orientation"];
				$pdf_pageFormat = $currentConfig["pdf_pageFormat"];
				$week_start = $currentConfig["week_start"];
				$pdf_img_scaling_factor = $currentConfig["pdf_img_scaling_factor"];
				$scheduled_files_ttl = $currentConfig["scheduled_files_ttl"];
				$host_name = $currentConfig["host_name"];
				
				
				
				//*********************************************//
				//****Avoid auto adding "deleted" filtering****//
				//*********************************************//
				$hasDeletedUsage = (isset($storedSelectedFields['tables'][0]['config']['deletedUsage']) && $storedSelectedFields['tables'][0]['config']['deletedUsage']);
				
				
				
				//****************************************************//
				//****Show totals below column for grouped reports****//
				//****************************************************//
				$hasGroupedTotalBelowColumn = (!isset($storedSelectedFields['tables'][0]['config']['expandGroupedTotals']) || !$storedSelectedFields['tables'][0]['config']['expandGroupedTotals']);
				
				
				
				//************************//
				//****Clean Up Styling****//
				//************************//
				$cleanUpStyling = (isset($storedSelectedFields['tables'][0]['config']['cleanUpStyling']) && $storedSelectedFields['tables'][0]['config']['cleanUpStyling']);
				$lightWeightHtml = (isset($storedSelectedFields['tables'][0]['config']['lightWeightHtml']) && $storedSelectedFields['tables'][0]['config']['lightWeightHtml']);
				
				
				//****************************************//
				//******Pagination report management******//
				//****************************************//
				$reportPaginationUsage = (isset($storedSelectedFields['tables'][0]['config']['paginationUsage']) && $storedSelectedFields['tables'][0]['config']['paginationUsage']);
				$reportPaginationEntries = $storedSelectedFields['tables'][0]['config']['paginationEntries'];
				
				if ($focus->report_charts == 'Char') {
					$hasNoPagination = true;
					$displayPagination = null;
				} else if ($reportPaginationUsage) {
					$hasNoPagination = false;
					$entriesPerPage = (!empty($reportPaginationEntries) ? $reportPaginationEntries : $entriesPerPage);
				}
				
				//***AlineaSol Premium***//
				$paginationEntries = asol_ReportsUtils::managePremiumFeature("reportFieldsManagement", "reportFunctions.php", "getReportFieldsManagementPaginationEntries", array('hasStaticFilters' => $hasStaticFilters, 'actualEntries' => $entriesPerPage, 'overrideEntries' => $override_entries));
				if ($paginationEntries !== false) {
					$hasNoPagination = false;
					$entriesPerPage = $paginationEntries;
				}
				//***AlineaSol Premium***//
				
				if ($externalCall || $hasNoPagination || $getExportData) {
					$hasNoPagination = true;
					$entriesPerPage = null;
				}
				
				
				//*********************************************//
				//**Execute report with default filter values**//
				//*********************************************//
				$initialExecution = $storedSelectedFilters['config']['initialExecution'];
				$saveSearch = $storedSelectedFilters['config']['saveSearch'];
				if ((isset($initialExecution)) && ($initialExecution)) {
					$searchCriteria = true;
				}
				
				
				//*****************************//
				//*****Variable Definition*****//
				//*****************************//
				$reportType = json_decode(rawurldecode($focus->report_type), true);
				
				$report_data['report_type'] = $reportType['type'];
				$report_data['report_type_stored_data'] = $reportType['data'];
				
				$isStoredReport = ($report_data['report_type'] == 'stored');
				
				$report_data['email_list'] = $focus->email_list;
				
				$report_name = $report_data['name'];
				$report_charts_engine = $report_data['report_charts_engine'];
				
				
				
				//********************************************//
				//*****Resultation Arrays Initialization******//
				//********************************************//
				$rs = array();
				$rsTotals = array();
				
				$subGroups = array();
				$subTotals = array();
				$subTotalsC = array();
				
				
				
				foreach ($reportUsedModules as $moduleIteration => $currentUsedModule) {
					
					$lastModuleIteration = ($moduleIteration === (count($reportUsedModules) - 1));
					
					//******************************//
					//***Get Back Report Elements***//
					//******************************//
					$selectedFields = $storedSelectedFields;
					$selectedFilters = $storedSelectedFilters;
					$selectedCharts = $storedSelectedCharts;
					$selectedDescription = $storedSelectedDescription;
					
					
					//*****************************//
					//*****Variable Definition*****//
					//*****************************//
					$publicDescription = $selectedDescription['public'];
					$report_module = $report_data['report_module'] = $focus->data_source['value']['module'] = $currentUsedModule;
						
					
					//***********************************************//
					//*******Manage Filters & External Filters*******//
					//***********************************************//
					$displayButtons = $selectedFilters['config']['buttons']['visible'];
					
					$avoidTrim = $selectedFilters['config']['avoidTrim'];
					$avoidEmptyFilters = $selectedFilters['config']['avoidEmptyFilters'];
					$avoidAutocomplete = $selectedFilters['config']['avoidAutocomplete'];
					$extFilters = asol_ReportsGenerationFunctions::buildExternalFilters($_REQUEST["external_filters"], $staticFilters, $userSourceDateFormat);
					
					//***AlineaSol Premium***//
					if (isset($selectedFilters['layout'])) {
						$filterslayoutConfig = $selectedFilters['layout'];
					}
					if (isset($_REQUEST['search_mode'])) {
						$search_mode = $_REQUEST['search_mode'];
					}
					//***AlineaSol Premium***//
					
					$filteringParams = asol_ReportsGenerationFunctions::getFilteringParams($focus->data_source, $selectedFilters, $extFilters, $search_mode, $filterslayoutConfig, $report_module, $predefinedTemplates, $isMetaSubReport, $dashletId, $userSourceDateFormat, $audited_report, $reportId, $searchCriteria, $saveSearch);
					
					$filterValuesData = $filteringParams["filterValues"]["data"];
					$filtersPanel = $filteringParams["filtersPanel"];
					$filtersHiddenInputs = $filteringParams["filtersHiddenInputs"];
					
					$searchCriteria = (isset($filteringParams["searchCriteria"]) ? $filteringParams["searchCriteria"] : $searchCriteria);
					
					
					if ($focus->data_source['type'] == '0') { //Database
					
						//********************************************//
						//*****Managing External Database Queries*****//
						//********************************************//
						$alternativeDb = ($focus->data_source['value']['database'] >= 0 ? $focus->data_source['value']['database'] : false);
						$externalDataBaseQueryParams = asol_ReportsGenerationFunctions::manageExternalDatabaseQueries($alternativeDb, $report_module);
						
						$useExternalDbConnection = true;
						
						$useAlternativeDbConnection = $externalDataBaseQueryParams["useAlternativeDbConnection"];
						$domainField = $externalDataBaseQueryParams["domainField"];
						$gmtDates = $externalDataBaseQueryParams["gmtDates"];
						$report_table = $externalDataBaseQueryParams["report_table"];
						
						$report_table_primary_key = $externalDataBaseQueryParams["report_table_primary_key"];
						
						
						
						//*****************************//
						//*******Temporal Fixes********//
						//*****************************//
						asol_ReportsGenerationFunctions::doTemporalFixes($report_table, $selectedFields, $selectedFilters);
						
						
						//*************************************//
						//******Generate Chart Info Array******//
						//*************************************//
						$urlChart = array();
						$chartSubGroupsValues = array();
						
						$chartInfoParams = asol_ReportsGenerationFunctions::getChartInfoParams($selectedCharts, $audited_report, $report_table);
						
						$hasStackChart = $chartInfoParams["hasStackChart"];
						$chartInfo = $chartInfoParams["chartInfo"];
						$chartConfig = $chartInfoParams["chartConfig"];
						$chartLayoutConfig = str_replace(',', '.', $selectedCharts['layout']); 
						
						if (($filtersHiddenInputs == false) || ($searchCriteria == true)) {
							
							//************************************//
							//*******Prepare SQL SubClauses*******//
							//************************************//
							foreach ($selectedFields['tables'][0]['data'] as $index => & $currentValues) {
								
								//***********************//
								//***AlineaSol Premium***//
								//***********************//
								$currentSql = asol_ReportsUtils::managePremiumFeature("predefinedTemplates", "reportFunctions.php", "getSqlTemplateValue", array('currentSQL' => $currentValues['sql'], 'template' => $currentValues['templates']['sql'], 'sqlTemplates' => $predefinedTemplates['sql']));
								$currentValues['sql'] = ($currentSql !== false) ? $currentSql : $currentValues['sql'];
								asol_ControllerQuery::validateSqlRemovedFields($currentValues['sql'], $alternativeDb, $report_table, $hasDeletedUsage);
								
								if (empty($currentValues['sql']) && !empty($currentValues["subQuery"]["module"])) {
									$externalDataBaseQueryParams = asol_ReportsGenerationFunctions::manageExternalDatabaseQueries($alternativeDb, $currentValues["subQuery"]['module']);
									$domainSubField = $externalDataBaseQueryParams["domainField"];
									
									$currentSql = asol_ReportsUtils::managePremiumFeature("subReports", "reportFunctions.php", "getSqlFromReport", array('convertDates' => false, 'isSubQuery' => true, 'alternativeDb' => $alternativeDb, 'hasDeletedUsage' => $hasDeletedUsage, 'userConfig' => $currentConfig, 'currentConfig' => null, 'currentQuery' => $currentValues["subQuery"], 'index' => $index, 'hourOffset' => $hourOffset, 'currentUser' => $current_user, 'schedulerCall' => $schedulerCall, 'reportDomain' => $reportDomain, 'domainField' => $domainSubField, 'sqlTemplates' => $predefinedTemplates['sql'], 'avoidTrim' => $avoidTrim, 'avoidEmptyFilters' => $avoidEmptyFilters, 'avoidAutocomplete' => $avoidAutocomplete));
									$currentValues['sql'] = ($currentSql !== false ? $currentSql : $currentValues['sql']);
								}
								//***********************//
								//***AlineaSol Premium***//
								//***********************//
								
							}
							
							
							//*********************************//
							//*******Get Queries [Joins]*******//
							//*********************************//
							$fieldsByRef = array();
							$joinQueryArray = asol_ControllerQuery::getSqlJoinQuery($selectedFields, $filterValuesData, $hasDeletedUsage, $report_data['results_limit'], $report_module, $report_table, $audited_report, $alternativeDb, $fieldsByRef, '', $domainField);
							
							$moduleCustomJoined = $joinQueryArray["moduleCustomJoined"];
							$moduleCountCustomJoined = $joinQueryArray["moduleCountCustomJoined"];
							$aliasIndexTable = $joinQueryArray["aliasIndexTable"];
							$sqlJoin = $joinQueryArray["querys"]["Join"];
							$sqlCountJoin = $joinQueryArray["querys"]["CountJoin"];
							
							
							
							foreach ($selectedFields['tables'][0]['data'] as $index => & $currentValues) {
								
								//***********************//
								//***AlineaSol Premium***//
								//***********************//
								$extraParams = array('currentSql' => $currentValues['sql'], 'fieldsByRef' => $fieldsByRef, 'suppressChars' => true);
								$currentSql = asol_ReportsUtils::managePremiumFeature("sqlWithReferences", "reportFunctions.php", "replaceSqlReferenceByValue", $extraParams);
								$currentValues['sql'] = ($currentSql !== false ? $currentSql : $currentValues['sql']);
								//***********************//
								//***AlineaSol Premium***//
								//***********************//
								
							}
							
							
							$availableData = asol_ControllerQuery::getAvailableColumns($focus->data_source, $selectedFields, $predefinedTemplates, array('field' => $sort_field, 'direction' => $sort_direction, 'index' => $sort_index), $displayTotals, $displaySubtotals, $report_table, $week_start, $quarter_month, $hourOffset, $aliasIndexTable, '');
							
							$resulset_fields = $availableData["fields"];
							$columns = $availableData["columns"];
							$totals = $availableData["totals"];
							$orders = $availableData["orders"];
							
							$isDetailedReport = $availableData["flags"]["isDetailed"];
							$details = $availableData["grouping"]["details"];
							$isGroupedReport = $availableData["flags"]["isGrouped"];
							$groups = $availableData["grouping"]["groups"];
							
							$referenceAlias = $availableData['referenceAlias'];
							
							$hasFunctionField = $availableData["flags"]["hasFunctionField"];
							
							//**********************************//
							//*******Get Queries [Select]*******//
							//**********************************//
							$filtersByRef = array();
							asol_ControllerQuery::generateSqlWhere($selectedFields, $filterValuesData, $report_table, $hourOffset, $currentConfig, $fieldsByRef, $filtersByRef, $avoidTrim, $avoidEmptyFilters, $avoidAutocomplete);
							$selectQueryArray = asol_ControllerQuery::getSqlSelectQuery($selectedFields, $chartInfo, $currentReportConfig, $focus->data_source, $report_table, $hourOffset, $quarter_month, $week_start, $displayTotals, $displaySubtotals, $fieldsByRef, $filtersByRef, $aliasIndexTable, '');
							
							$isGroupedReport = $selectQueryArray["hasGrouped"];
							$hasGroupedFunctionWithSQL = ($isGroupedReport && $selectQueryArray["hasFunctionWithSQL"]);
							$availableMassiveButtons = array();
							
							$sqlTotalsC = $selectQueryArray["querys"]["Charts"];
							//***AlineaSol Premium***//
							$fieldSqlFilterReference  = asol_ReportsUtils::managePremiumFeature("sqlFilterReference", "reportFunctions.php", "replaceReportsFilterVars", array('filtersByRef' => $filtersByRef, 'currentField' => null, 'sqlContent' => $sqlTotalsC));
							if ($fieldSqlFilterReference !== false) {
								$sqlTotalsC = (isset($fieldSqlFilterReference['sql']) ? $fieldSqlFilterReference['sql'] : $sqlTotalsC);
							}
							//***AlineaSol Premium***//
							
							$sqlSelect = $selectQueryArray["querys"]["Select"];
							//***AlineaSol Premium***//
							$fieldSqlFilterReference  = asol_ReportsUtils::managePremiumFeature("sqlFilterReference", "reportFunctions.php", "replaceReportsFilterVars", array('filtersByRef' => $filtersByRef, 'currentField' => null, 'sqlContent' => $sqlSelect));
							if ($fieldSqlFilterReference !== false) {
								$sqlSelect = (isset($fieldSqlFilterReference['sql']) ? $fieldSqlFilterReference['sql'] : $sqlSelect);
							}
							//***AlineaSol Premium***//
							
							$sqlTotals = $selectQueryArray["querys"]["Totals"];
							//***AlineaSol Premium***//
							$fieldSqlFilterReference  = asol_ReportsUtils::managePremiumFeature("sqlFilterReference", "reportFunctions.php", "replaceReportsFilterVars", array('filtersByRef' => $filtersByRef, 'currentField' => null, 'sqlContent' => $sqlTotals));
							if ($fieldSqlFilterReference !== false) {
								$sqlTotals = (isset($fieldSqlFilterReference['sql']) ? $fieldSqlFilterReference['sql'] : $sqlTotals);
							}
							//***AlineaSol Premium***//
							
							
							
							//********************************//
							//*******Get Queries [From]*******//
							//********************************//
							$sqlFrom = asol_ControllerQuery::getSqlFromQuery($report_table, $audited_report, '');
							
							
							//*********************************//
							//*******Get Queries [Where]*******//
							//*********************************//
							asol_ControllerQuery::replaceFiltersWithNamedFieldAlias($selectedFields, $filtersByRef, $isGroupedReport);
							$filteringQueryArray = asol_ControllerQuery::getSqlFilteringQuery($filtersByRef, $hasDeletedUsage, $report_table, $useAlternativeDbConnection, '');
							$hasGroupedFunctionWithHaving = ($isGroupedReport && $filteringQueryArray["hasHavingFilters"]);
							$sqlWhere = $filteringQueryArray["querys"]['Where'];
							$sqlHaving = $filteringQueryArray["querys"]['Having'];
							
							//***AlineaSol Premium***//
							$extraParams = array('currentSql' => $sqlWhere, 'fieldsByRef' => $fieldsByRef, 'suppressChars' => true);
							$currentSql = asol_ReportsUtils::managePremiumFeature("sqlWithReferences", "reportFunctions.php", "replaceSqlReferenceByValue", $extraParams);
							$sqlWhere = ($currentSql !== false) ? $currentSql : $sqlWhere;
							
							$extraParams = array('currentSql' => $sqlHaving, 'fieldsByRef' => $fieldsByRef, 'suppressChars' => true);
							$currentHaving = asol_ReportsUtils::managePremiumFeature("sqlWithReferences", "reportFunctions.php", "replaceSqlReferenceByValue", $extraParams);
							$sqlHaving = ($currentHaving !== false) ? $currentHaving : $sqlHaving;
							//***AlineaSol Premium***//
							
							if (asol_CommonUtils::isDomainsInstalled()) {
								asol_CommonUtils::modifySqlWhereForAsolDomainsQuery($sqlWhere, $report_table, $current_user, $schedulerCall, $reportDomain, $domainField, '');
							}
							
							if (asol_ReportsUtils::isSecurityGroupsInstalled() && !$hasSecurityGroupsDisabled && $alternativeDb === false) {
								asol_ControllerQuery::modifySqlWhereForSecurityGroups($sqlWhere, $report_module, $report_table, $current_user);
							}
							
							//***********************//
							//****Get Email Alert****//
							//***********************//
							$sendEmailquestion = asol_ReportsGenerationFunctions::getSendEmailAlert($focus->email_list, $reportDomain);
							
							
							//***********************************//
							//*******Get Queries [GroupBy]*******//
							//***********************************//
							$groupQueryArray = asol_ControllerQuery::getSqlGroupByQuery($selectedFields, $report_table, $details, $groups, $filtersByRef);
							
							$sqlGroup = $groupQueryArray["querys"]["Group"];
							$sqlChartGroup = $groupQueryArray["querys"]["ChartGroup"];
							
							$hasAnyGroupVisible = $groupQueryArray["hasAnyGroupVisible"];
							$massiveData = $groupQueryArray["massiveData"];
							
							
							//***********************************//
							//****Manage Query Autoprotection****//
							//***********************************//
							if (!$trustedExecution) {
								
								if (!$grossExecution) {
									$totalEntriesArray = asol_ReportsGenerationFunctions::getReportTotalEntries($sqlFrom, $sqlCountJoin, $sqlWhere, $sqlGroup, $sqlHaving, $details, $groups, $useExternalDbConnection, $alternativeDb, $report_table);
									$totalEntries = $totalEntriesArray['totalEntries'];
									$totalUngroupedEntries = $totalEntriesArray['totalUngroupedEntries'];
								}
								
								$checkMaxAllowedResults = (isset($sugar_config['asolReportsMaxAllowedResults']) ? true : false);
								$checkMaxAllowedNotIndexedOrderBy = (isset($sugar_config['asolReportsMaxAllowedNotIndexedOrderBy']) ? true : false);
								$checkMaxAllowedGroupByEntries = (isset($sugar_config['asolReportsMaxAllowedGroupByEntries']) ? true : false);
								$checkMaxAllowedDisplayed = (!$grossExecution) && (isset($sugar_config['asolReportsMaxAllowedDisplayed']) ? true : false);
								$checkMaxAllowedParseMultiTable = (!$grossExecution) && (isset($sugar_config['asolReportsMaxAllowedParseMultiTable']) ? true : false);
								
								$maxAllowedResults = false;
								$maxAllowedNotIndexedOrderBy = false;
								
								if ($checkMaxAllowedResults || $checkMaxAllowedNotIndexedOrderBy || $checkMaxAllowedDisplayed || $checkMaxAllowedGroupByEntries || $checkMaxAllowedParseMultiTable) {
									
									$maxAllowedResultsQuery = "EXPLAIN ".$sqlSelect.$sqlFrom.$sqlJoin.$sqlWhere.$sqlGroup.$sqlHaving.$sqlLimit;
									$maxAllowedResultsRow = asol_Reports::getSelectionResults($maxAllowedResultsQuery, null, $useExternalDbConnection, $alternativeDb, null, null, null, true);
									
									$productResults = 1;
									
									foreach ($maxAllowedResultsRow as $maxAllowedResult) {
										if ($maxAllowedResult['select_type'] == 'PRIMARY') {
											$productResults *= $maxAllowedResult['rows'];
										}
									}
									
									$maxAllowedResults = ($checkMaxAllowedResults && ($sugar_config['asolReportsMaxAllowedResults'] < $productResults));
									$maxAllowedNotIndexedOrderBy = ($checkMaxAllowedNotIndexedOrderBy && ($sugar_config['asolReportsMaxAllowedNotIndexedOrderBy'] < $totalEntries));
									
									$entriesPhpProcessed = (($hasNoPagination || $allowExportGeneratedFile) ? $totalEntries : $entriesPerPage);
									$maxAllowedGroupByEntries = ($checkMaxAllowedGroupByEntries && $isGroupedReport && ($sugar_config['asolReportsMaxAllowedGroupByEntries'] < $totalUngroupedEntries));
									$maxAllowedDisplayed = ($checkMaxAllowedDisplayed && ($totalEntries > 0) && ($sugar_config['asolReportsMaxAllowedDisplayed'] < $entriesPhpProcessed));
									$maxAllowedParseMultiTable = ($checkMaxAllowedParseMultiTable && $multiModuleReport && ($sugar_config['asolReportsMaxAllowedParseMultiTable'] < $entriesPhpProcessed));
									
									if ($maxAllowedResults) {
										asol_Reports::manageMaxAllowedResultsReached($schedulerCall, $productResults, $sqlSelect.$sqlFrom.$sqlJoin.$sqlWhere.$sqlGroup.$sqlHaving.$sqlLimit);
									}
									
									if ($maxAllowedDisplayed || $maxAllowedGroupByEntries || $maxAllowedParseMultiTable) {
										$oversizedReport = true;
									}
									
								}
								
								//***********************//
								//***AlineaSol Premium***//
								//***********************//
								$extraSaveSearch = array(
									'saveSearch' => $saveSearch,
									'totalEntries' => $totalEntries,
									'reportId' => $reportId,
								);
								asol_ReportsUtils::managePremiumFeature("setLastExecutionLimit", "reportFunctions.php", "setLastExecutionLimit", $extraSaveSearch );
								//***********************//
								//***AlineaSol Premium***//
								//***********************//
								
							}
							
							$entriesPerPage = (!isset($entriesPerPage) ? 1000000 : $entriesPerPage);
							
							if (!$oversizedReport) {
								
								//***********************************//
								//*******Get Queries [OrderBy]*******//
								//***********************************//
								$initialSortDirection = $orders[0]['direction'];
								$orderQueryArray = asol_ControllerQuery::getSqlOrderByQuery($selectedFields, $report_table, $alternativeDb, $orders, ($grossExecution ? true : $maxAllowedNotIndexedOrderBy), $fieldsByRef);
								
								$hasDeletedNotIndexedOrderBy = $orderQueryArray['hasDeletedNotIndexedOrderBy'];
								$sqlOrder = $orderQueryArray["query"];
								
								
								//***********************************//
								//*******Pagination Management*******//
								//***********************************//
								if ($hasNoPagination) {
									
									$sqlLimit = "";
									$sqlLimitExport = "";
									$total_entries_basic = $totalEntries;
									
								} else {
									
									//*********************************//
									//*******Get Queries [Limit]*******//
									//*********************************//
									$orderQueryArray = asol_ControllerQuery::getSqlLimitQuery($report_data['results_limit'], $entriesPerPage, $page_number, $totalEntries, $externalCall);
									
									$sqlLimit = $orderQueryArray["querys"]["Limit"];
									$sqlLimitExport = $orderQueryArray["querys"]["LimitExport"];
									$total_entries_basic = $orderQueryArray["totalEntriesBasic"];
									
								}
								
								
								//******************************************//
								//*****Correct Fields for Empty Reports*****//
								//******************************************//
								$correctedEmptyReport = asol_ReportsGenerationFunctions::correctEmptyReport($sqlSelect, $sqlTotals, $alternativeDb, $report_table, $groups);
								
								if ($displayHeaders) {
									if ($correctedEmptyReport["select"] !== null) {
										$columns[$correctedEmptyReport["select"]] = null;
									}
								}
								$sqlSelect .= ($correctedEmptyReport["select"] !== null ? $correctedEmptyReport["select"] : "");
								$sqlOrder .= ($correctedEmptyReport["select"] !== null ? $correctedEmptyReport["select"] : "");
								
								$sqlTotals .= ($correctedEmptyReport["totals"]["sql"] !== null ? $correctedEmptyReport["totals"]["sql"] : "");
								$totals[0]['alias'] = ($correctedEmptyReport["totals"]["column"] !== null ? $correctedEmptyReport["totals"]["column"] : $totals[0]['alias']);
								
								
								//*******************************************************//
								//*****Get Extended Where Clause for Limited Reports*****//
								//*******************************************************//
								$sqlLimitSubSet = asol_ControllerQuery::getSqlSubSetLimitQuery($focus->data_source['value']['database'], $report_data['results_limit'], $totalEntries, $entriesPerPage, $page_number, $report_table, $report_table_primary_key, $sqlFrom, $sqlJoin, $sqlWhere, $sqlGroup, $sqlHaving);
								
								
								if ($audited_report) {
									
									//************************************//
									//********Manage Audited Field********//
									//************************************//
									$auditedFieldInfo = asol_CommonUtils::getFieldInfoFromVardefs($report_module, $filterValuesData[0]['parameters']['first'][0]);
									$auditedFieldType = $auditedFieldInfo["type"];
									
									$auditedAppliedFields = array($report_table."_audit.before_value_string", $report_table."_audit.after_value_string", $report_table."_audit.before_value_text", $report_table."_audit.after_value_text");
									
								}
								
								
								//************************************************************//
								//********Override Chart Names If Http Request Enabled********//
								//************************************************************//
								$chartsHttpQueryUrls = (!isset($_REQUEST['chartsHttpQueryUrls'])) ? array() : explode('${pipe}', $_REQUEST['chartsHttpQueryUrls']);
								
								if (!$isMassiveScheduleCsvExport) {
									
									//*************************//
									//******DETAIL REPORT******//
									//*************************//
									if ($isDetailedReport) {
										
										asol_ReportsUtils::reports_log('debug', 'Detailed Report', __FILE__, __METHOD__, __LINE__);
										
										//***************************************//
										//******Initialize Detail Variables******//
										//***************************************//
										$currentSubGroups = array();
										$currentSubTotals = array();
										$currentSubTotalsC = array();
										
										
										$detailFieldInfo = $details[0];
										
										switch ($detailFieldInfo['grouping']) {
											
											case "Detail":
												
												//*****Calculate Detail Pagination Variables*****//
												$orderPaginationDetailVars = asol_ReportsGenerationFunctions::getOrderPaginationSingleDetailVars($detailFieldInfo, $detailMultiQuery, $report_data['results_limit'], $sqlFrom, $sqlJoin, $sqlWhere, $sqlGroup, $sqlHaving, $useExternalDbConnection, $alternativeDb, $report_table, $groups);
												
												$rsGroups = $orderPaginationDetailVars["rsGroups"];
												$sizes = $orderPaginationDetailVars["sizes"];
												$fullSizes = $orderPaginationDetailVars["fullSizes"];
												
												break;
												
											case "Minute Detail":
											case "Quarter Hour Detail":
											case "Hour Detail":
											case "Day Detail":
											case "DoW Detail":
											case "WoY Detail":
											case "Month Detail":
											case "Natural Quarter Detail":
											case "Fiscal Quarter Detail":
											case "Natural Year Detail":
											case "Fiscal Year Detail":
												
												//*****Calculate Day/DoW/Month Detail Pagination Variables*****//
												$orderPaginationMonthDayDetailVars = asol_ReportsGenerationFunctions::getOrderPaginationDateDetailVars($detailFieldInfo, $detailMultiQuery, $report_data['results_limit'], $sqlFrom, $sqlJoin, $sqlWhere, $useExternalDbConnection, $alternativeDb, $report_table, $groups, $week_start);
												
												$rsGroups = $orderPaginationMonthDayDetailVars["rsGroups"];
												$sizes = $orderPaginationMonthDayDetailVars["sizes"];
												$fullSizes = $orderPaginationMonthDayDetailVars["fullSizes"];
												$reorderDetailGroups = false;
												
												break;
												
										}
										
										
										//*****Manage Pagination Variables*****//
										$paginationMainVariables = asol_ReportsGenerationFunctions::getPaginationMainVariables($page_number, $entriesPerPage, $sizes);
										
										$init_group = $paginationMainVariables["init_group"];
										$end_group = $paginationMainVariables["end_group"];
										$current_entries = $paginationMainVariables["current_entries"];
										$first_entry = $paginationMainVariables["first_entry"];
										
										
										$groupField = array();
										$subGroup = array();
										
										if ($dataVisibility['field'] || ($hasStackChart && $hasAnyGroupVisible) || ($report_data['results_limit'] != 'all')) {
											
											$subGroupsExport = Array();
											$subTotalsExport = Array();
											$subTotalsExportNoFormat = Array();
											
											$groupField = array();
											$subGroup = array();
											
											if ($detailMultiQuery) {
												
												foreach ($rsGroups as $index=>$currentGroup) {
													
													if (($report_data['results_limit'] == "all") && (!$allowExportGeneratedFile) && (($index < $init_group) || ($index > $end_group)))
														continue;
														
														//********************************************//
														//******Limit Clause For Detail Grouping******//
														//********************************************//
														$detailWhereGrouping = asol_ControllerQuery::getDetailWhereGrouping($sqlWhere, $currentGroup['group'], $detailFieldInfo);
														
														$subGroup = $detailWhereGrouping["subGroup"];
														$sqlDetailWhere = $detailWhereGrouping["sqlDetailWhere"];
														
														$sqlLimit = asol_ControllerQuery::getSqlDetailLimitQuery($report_data['results_limit'], $fullSizes[$index]);
														
														$sqlDetailQuery = $sqlSelect.$sqlFrom.$sqlJoin.$sqlDetailWhere.$sqlGroup.$sqlHaving.$sqlOrder.$sqlLimit;
														$rsDetail = asol_Reports::getSelectionResults($sqlDetailQuery, null, $useExternalDbConnection, $alternativeDb);
														
														
														//***************************//
														//******Format SubGroup******//
														//***************************//
														if ((!$grossExecution) && ($detailFieldInfo['function'] == '0')) {
															$subGroup = asol_ControllerQuery::formatDateSpecialsGroup($reportId, $dashletId, $subGroup, $detailFieldInfo, $userDateFormat, $userTZ, $gmtDates);
														}
														
														
														if ((empty($subGroup)) && ($subGroup !== "0"))
															continue;
															
															
															foreach ($rsDetail as $currentDetail) {
																if (($index >= $init_group) && ($index <= $end_group)) {
																	$currentSubGroups[$subGroup][] = $currentDetail;
																}
																$subGroupsExport[$subGroup][] = $currentDetail;
															}
															
															//***********************************************//
															//*******Subtotals Query for Current Group*******//
															//***********************************************//
															if ($displaySubtotals) {
																
																$limitedGroupTotals = array();
																
																if (($report_data['results_limit'] == "all") && (!$hasGroupedFunctionWithSQL) && (!$hasGroupedFunctionWithHaving)) {
																	
																	$sqlSubQueryTotals = $sqlTotals.$sqlFrom.$sqlCountJoin.$sqlDetailWhere;
																	$rsSubTotals = asol_Reports::getSelectionResults($sqlSubQueryTotals, null, $useExternalDbConnection, $alternativeDb);
																	
																} else if (!$isGroupedReport) {
																	
																	$limitedIds = array();
																	$limitIds = asol_Reports::getSelectionResults("SELECT ".$report_table.".".$report_table_primary_key." ".$sqlFrom.$sqlCountJoin.$sqlDetailWhere.$sqlOrder.$sqlLimit, null, $useExternalDbConnection, $alternativeDb);
																	foreach ($limitIds as $limitId)
																		$limitedIds[] = $limitId[$report_table_primary_key];
																		
																		$sqlLimitWhere = " AND ".$report_table.".".$report_table_primary_key." IN ('".implode("','", $limitedIds)."')";
																		
																		$sqlSubQueryTotals = $sqlTotals.$sqlFrom.$sqlCountJoin.$sqlDetailWhere.$sqlLimitWhere;
																		$rsSubTotals = asol_Reports::getSelectionResults($sqlSubQueryTotals, null, $useExternalDbConnection, $alternativeDb);
																		
																} else {
																	
																	//**************************************//
																	//******Generate SubTotals Manually*****//
																	//**************************************//
																	$limitedGroupTotals = $limitedGroupTotalsExport = asol_ControllerQuery::generateManuallySubTotals($rsDetail, $totals, $report_data['results_limit']);
																	
																}
																
																$rsSubTotalsExport = $rsSubTotals;
																
																if (!empty($limitedGroupTotalsExport[0])) {
																	if (($index >= $init_group) && ($index <= $end_group)) {
																		$rsSubTotals[0] = $limitedGroupTotals[0];
																	}
																	$rsSubTotalsExport[0] = $limitedGroupTotalsExport[0];
																}
																
																
																//Obtenemos el resultado de la query de los SubTotales para el subgrupo actual
																$subTotalsLimit[] = $rsSubTotalsExport[0];
																
																$subTotalsExportNoFormat[$subGroup] = $rsSubTotalsExport[0];
																
																//**********************************//
																//******Apply Displaying Format*****//
																//**********************************//
																if (!$grossExecution) {
																	$rsSubTotals = asol_ControllerQuery::formatGroupTotals($reportId, $dashletId, $rsSubTotals, $totals, $userDateFormat, $userDateTimeFormat, $userTZ, $gmtDates, $audited_report, $auditedAppliedFields, $auditedFieldType);
																	$rsSubTotalsExport = asol_ControllerQuery::formatGroupTotals($reportId, $dashletId, $rsSubTotalsExport, $totals, $userDateFormat, $userDateTimeFormat, $userTZ, $gmtDates, $audited_report, $auditedAppliedFields, $auditedFieldType);
																}
																
																$currentSubTotals[$subGroup] = $rsSubTotals[0];
																$subTotalsExport[$subGroup] = $rsSubTotalsExport[0];
																
															}
															
												}
												
												
												//***********************//
												//***AlineaSol Premium***//
												//***********************//
												$extraParams = array(
													'isGroupedReport' => $isGroupedReport,
													'groups' => $groups,
													'currentSubGroups' => $currentSubGroups,
													'subGroups' => $subGroups,
													'resulsetTotals' => $totals,
													'moduleIteration' => $moduleIteration
												);
												$returnedSubGroups = asol_ReportsUtils::managePremiumFeature("dynamicTablesReport", "reportFunctions.php", "parseMergeDetailResultsets", $extraParams);
												$subGroups = $subGroupsExport = ($returnedSubGroups !== false ? $returnedSubGroups : $currentSubGroups);
												//***********************//
												//***AlineaSol Premium***//
												//***********************//
												
												
												//***********************//
												//***AlineaSol Premium***//
												//***********************//
												$extraParams = array(
													'currentSubTotals' => $currentSubTotals,
													'subTotals' => $subTotals,
													'resulsetTotals' => $totals,
													'moduleIteration' => $moduleIteration,
													'isChartsTotals' => false,
												);
												$returnedSubTotals = asol_ReportsUtils::managePremiumFeature("dynamicTablesReport", "reportFunctions.php", "parseMergeDetailTotalsResultsets", $extraParams);
												$subTotals = ($returnedSubTotals !== false ? $returnedSubTotals : $currentSubTotals);
												//***********************//
												//***AlineaSol Premium***//
												//***********************//
												
												if ($hasNoPagination) {
													$subTotalsExport = $subTotals;
												}
												
											} else {
												
												$formatInfo = array(
													'reportId' => $reportId,
													'dashletId' => $dashletId,
													'userDateFormat' => $userDateFormat,
													'userTZ' => $userTZ,
													'gmtDates' => $gmtDates
												);
												
												$sqlDetailGroupBy = (!empty($sqlGroup) ? $sqlGroup.', '.$detailFieldInfo['field'] : '');
												$sqlDetailQuery = $sqlSelect.",".$detailFieldInfo['field']." AS 'asol_grouping_field' ".$sqlFrom.$sqlJoin.$sqlWhere.$sqlDetailGroupBy.$sqlHaving.$sqlOrder;
												$rsDetail = asol_Reports::getSelectionResults($sqlDetailQuery, null, $useExternalDbConnection, $alternativeDb, null, $detailFieldInfo, $formatInfo, false);
												
												
												if ($hasNoPagination) {
													
													if ($report_data['results_limit'] !== "all") {
														
														foreach($rsDetail as $subGroup=>$currentDetail) {
															$res_limit = explode('${dp}', $report_data['results_limit']);
															if ($res_limit[1] == 'first') {
																$currentDetail = array_slice($currentDetail, 0, $res_limit[2]);
															} else if ($res_limit[1] == 'last') {
																$currentDetail = array_slice($currentDetail, -$res_limit[2]);
															}
															$currentSubGroups[$subGroup] = $currentDetail;
														}
														
													} else {
														
														$currentSubGroups = $rsDetail;
														
													}
													
													//***********************//
													//***AlineaSol Premium***//
													//***********************//
													$extraParams = array(
														'isGroupedReport' => $isGroupedReport,
														'groups' => $groups,
														'currentSubGroups' => $currentSubGroups,
														'subGroups' => $subGroups,
														'resulsetTotals' => $totals,
														'moduleIteration' => $moduleIteration
													);
													$returnedSubGroups = asol_ReportsUtils::managePremiumFeature("dynamicTablesReport", "reportFunctions.php", "parseMergeDetailResultsets", $extraParams);
													$subGroups = $subGroupsExport = ($returnedSubGroups !== false ? $returnedSubGroups : $currentSubGroups);
													//***********************//
													//***AlineaSol Premium***//
													//***********************//
													
												} else {
													
													$index = 0;
													foreach($rsDetail as $subGroup=>$currentDetail) {
														
														if ($report_data['results_limit'] !== "all") {
															$res_limit = explode('${dp}', $report_data['results_limit']);
															if ($res_limit[1] == 'first') {
																$currentDetail = array_slice($currentDetail, 0, $res_limit[2]);
															} else if ($res_limit[1] == 'last') {
																$currentDetail = array_slice($currentDetail, -$res_limit[2]);
															}
														}
														
														if (($index >= $init_group) && ($index <= $end_group)) {
															$currentSubGroups[$subGroup] = $currentDetail;
														}
														
														if ($allowExportGeneratedFile || $report_data['report_charts'] != 'Tabl') {
															$subGroupsExport[$subGroup] = $currentDetail;
														}
														
														$index++;
														
													}
													
													$subGroups = $currentSubGroups;
													
												}
												
												
												if ($displaySubtotals) {
													
													$limitedGroupTotals = array();
													
													if (($report_data['results_limit'] == "all") && (!$hasGroupedFunctionWithSQL) && (!$hasGroupedFunctionWithHaving)) {
														
														$sqlDetailGroupBy = ' GROUP BY '.$detailFieldInfo['field'];
														$sqlSubQueryTotals = $sqlTotals.",".$detailFieldInfo['field']." AS 'asol_grouping_field' ".$sqlFrom.$sqlCountJoin.$sqlWhere.$sqlDetailGroupBy.$sqlHaving;
														$rsSubTotals  = asol_Reports::getSelectionResults($sqlSubQueryTotals, null, $useExternalDbConnection, $alternativeDb, null, null, null, false);
														
													} else if (!$isGroupedReport) {
														
														$sqlDetailGroupBy = ' GROUP BY '.$report_table.".".$report_table_primary_key;
														$sqlSubQueryTotals = $sqlTotals.",".$detailFieldInfo['field']." AS 'asol_grouping_field' ".$sqlFrom.$sqlCountJoin.$sqlWhere.$sqlDetailGroupBy.$sqlHaving;
														$sqlSubQueryTotals .= ($report_data['results_limit'] == "all" ? '' : $sqlOrder);
														$rsSubTotals = asol_Reports::getSelectionResults($sqlSubQueryTotals, null, $useExternalDbConnection, $alternativeDb, null, null, null, false);
														
														//******Generate SubTotals Manually*****//
														$rsSubTotals = asol_ControllerQuery::generateManuallySubTotals($rsSubTotals, $totals, $report_data['results_limit'], true);
														
													} else {
														
														$sqlDetailGroupBy = (!empty($sqlGroup) ? $sqlGroup.', '.$detailFieldInfo['field'] : '');
														$sqlSubQueryTotals = $sqlTotals.",".$detailFieldInfo['field']." AS 'asol_grouping_field' ".$sqlFrom.$sqlCountJoin.$sqlWhere.$sqlDetailGroupBy.$sqlHaving;
														$sqlSubQueryTotals .= ($report_data['results_limit'] == "all" ? '' : $sqlOrder);
														$rsSubTotals  = asol_Reports::getSelectionResults($sqlSubQueryTotals, null, $useExternalDbConnection, $alternativeDb, null, null, null, false);
														
														//******Generate SubTotals Manually*****//
														$rsSubTotals = asol_ControllerQuery::generateManuallySubTotals($rsSubTotals, $totals, $report_data['results_limit'], true);
														
													}
													
													foreach ($rsSubTotals as $rsSubTotal) {
														
														//**********************************//
														//******Apply Displaying Format*****//
														//**********************************//
														$theGroup = $rsSubTotal['asol_grouping_field'];
														
														if (!$grossExecution) {
															$theGroup = asol_ControllerQuery::formatDateSpecialsGroup($reportId, $dashletId, $theGroup, $detailFieldInfo, $userDateFormat, $userTZ, $gmtDates);
															$theGroup = (($theGroup === '') ? $mod_strings['LBL_REPORT_NAMELESS'] : $theGroup);
														}
														
														$currentSubTotals[$theGroup] = $rsSubTotal;
														
													}
													
													
													//***********************//
													//***AlineaSol Premium***//
													//***********************//
													$extraParams = array(
														'currentSubTotals' => $currentSubTotals,
														'subTotals' => $subTotals,
														'resulsetTotals' => $totals,
														'moduleIteration' => $moduleIteration,
														'isChartsTotals' => false,
													);
													$returnedSubTotals = asol_ReportsUtils::managePremiumFeature("dynamicTablesReport", "reportFunctions.php", "parseMergeDetailTotalsResultsets", $extraParams);
													$subTotals = ($returnedSubTotals !== false ? $returnedSubTotals : $currentSubTotals);
													//***********************//
													//***AlineaSol Premium***//
													//***********************//
													
													if ($lastModuleIteration) {
														
														foreach ($subTotals as & $subTotal) {
															
															//**********************************//
															//******Apply Displaying Format*****//
															//**********************************//
															unset($subTotal['asol_grouping_field']);
															if (!$grossExecution) {
																$subTotal = asol_ControllerQuery::formatGroupTotals($reportId, $dashletId, array($subTotal), $totals, $userDateFormat, $userDateTimeFormat, $userTZ, $gmtDates, $audited_report, $auditedAppliedFields, $auditedFieldType);
																$subTotal = $subTotal[0];
															}
															
														}
														
													}
													
													$subTotalsExport = $subTotals;
													
												}
												
											}
											
											//Order resultset for grouped totals
											if ($reorderDetailGroups) {
												
												if ($details[0]['order'] == 'DESC') {
													krsort($subGroups);
													krsort($subGroupsExport);
												} else if ($details[0]['order'] == 'ASC') {
													ksort($subGroups);
													ksort($subGroupsExport);
												}
												
											}
											
										}
										
										
										//***********************//
										//***AlineaSol Premium***//
										//***********************//
										$extraParams = array(
											'subGroups' => $subGroups,
											'resulsetFields' => $resulset_fields,
											'referenceAlias' => $referenceAlias
										);
										$returnedPhpSubGroups = asol_ReportsUtils::managePremiumFeature("reportPhpFunctions", "reportFunctions.php", "formatPhpDetailResultSet", $extraParams);
										$subGroups = ($returnedPhpSubGroups !== false) ? $returnedPhpSubGroups : $subGroups;
										//***********************//
										//***AlineaSol Premium***//
										//***********************//
										
										
										if (($report_data['results_limit'] != "all") || ($allowExportGeneratedFile)) {
											
											//***********************//
											//***AlineaSol Premium***//
											//***********************//
											$extraParams = array(
												'subGroups' => $subGroupsExport,
												'resulsetFields' => $resulset_fields,
												'referenceAlias' => $referenceAlias
											);
											$returnedPhpSubGroups = asol_ReportsUtils::managePremiumFeature("reportPhpFunctions", "reportFunctions.php", "formatPhpDetailResultSet", $extraParams);
											$subGroupsExport = ($returnedPhpSubGroups !== false) ? $returnedPhpSubGroups : $subGroupsExport;
											//***********************//
											//***AlineaSol Premium***//
											//***********************//
											
										}
										
										
										//**********************************************//
										//******Generate Values for Chart Totals********//
										//**********************************************//
										
										if ($dataVisibility['chart'] && (count($chartInfo) > 0) && (strlen($sqlTotalsC) > 7)) {
											if ($report_data['results_limit'] != 'all') {
												
												$currentSubTotalsC = $subTotalsExportNoFormat;
												
											} else {
												
												switch ($detailFieldInfo['grouping']) {
													
													case "Detail":
														$rsSubTotalsC = asol_Reports::getSelectionResults($sqlTotalsC.",".$detailFieldInfo['field']." AS 'asol_grouping_field' ".$sqlFrom.$sqlCountJoin.$sqlWhere.$sqlChartGroup.$sqlHaving, null, $useExternalDbConnection, $alternativeDb);
														
														foreach ($rsSubTotalsC as $rsSubTotalC) {
															
															$theGroup = $rsSubTotalC['asol_grouping_field'];
															unset($rsSubTotalC['asol_grouping_field']);
															$theGroup = (($theGroup === '') ? $mod_strings['LBL_REPORT_NAMELESS'] : $theGroup);
															
															if (!$grossExecution) {
																$theGroup = asol_ControllerQuery::formatSubGroup($reportId, $dashletId, $theGroup, $detailFieldInfo, $userTZ, $gmtDates);
															}
															
															if (!$massiveData)
																$currentSubTotalsC[$theGroup] = $rsSubTotalC;
															else
																$currentSubTotalsC[$theGroup][] = $rsSubTotalC;
																	
														}
														
														break;
														
														
													case "Minute Detail":
													case "Quarter Hour Detail":
													case "Hour Detail":
													case "Day Detail":
													case "DoW Detail":
													case "WoY Detail":
													case "Month Detail":
													case "Natural Quarter Detail":
													case "Fiscal Quarter Detail":
													case "Natural Year Detail":
													case "Fiscal Year Detail":
														
														foreach ($rsGroups as $currentGroup) {
															
															$monthDayDetailGroupWhereExtensionQuery = asol_ReportsGenerationFunctions::getDateDetailGroupWhereExtensionQuery($sqlWhere, $detailFieldInfo['field'], $detailFieldInfo['grouping'], $currentGroup['group']);
															
															$subGroupC = $monthDayDetailGroupWhereExtensionQuery['subGroup'];
															$sqlDetailWhereC = $monthDayDetailGroupWhereExtensionQuery['sqlDetailWhere'];
															
															//***************************//
															//******Format SubGroup******//
															//***************************//
															if ((!$grossExecution) && ($detailFieldInfo['function'] == '0')) {
																$subGroupC = asol_ControllerQuery::formatDateSpecialsGroup($reportId, $dashletId, $subGroupC, $detailFieldInfo, $userDateFormat, $userTZ, $gmtDates);
															}
															
															//Obtenemos el resultado de la query de los SubTotales para el subgrupo actual
															$sqlSubQueryTotalsC = $sqlTotalsC.$sqlFrom.$sqlCountJoin.$sqlDetailWhereC;
															$rsSubTotalsC = asol_Reports::getSelectionResults($sqlSubQueryTotalsC, null, $useExternalDbConnection, $alternativeDb);
															$currentSubTotalsC[$subGroupC] = ($massiveData ? $rsSubTotalsC : $rsSubTotalsC[0]);
															
														}
														
														break;
														
												}
												
											}
											
											//***********************//
											//***AlineaSol Premium***//
											//***********************//
											$extraParams = array(
												'currentSubTotals' => $currentSubTotalsC,
												'subTotals' => $subTotalsC,
												'resulsetTotals' => $chartInfo,
												'moduleIteration' => $moduleIteration,
												'isChartsTotals' => true,
											);
											$returnedSubTotalsC = asol_ReportsUtils::managePremiumFeature("dynamicTablesReport", "reportFunctions.php", "parseMergeDetailTotalsResultsets", $extraParams);
											$subTotalsC = ($returnedSubTotalsC !== false ? $returnedSubTotalsC : $currentSubTotalsC);
											//***********************//
											//***AlineaSol Premium***//
											//***********************//
																				
										}
										
										
										//**********************************//
										//******Apply Displaying Format*****//
										//**********************************//
										$subGroupsNoFormat = $subGroups;
										$subGroupsExportNoFormat = $subGroupsExport;
										
										if (!$grossExecution) {
											
											if ($lastModuleIteration) {
												$subGroups = asol_ControllerQuery::formatDetailResultSet($reportId, $dashletId, $subGroups, $resulset_fields, $userDateFormat, $userDateTimeFormat, $userTZ, $gmtDates, $isGroupedReport, $audited_report, $auditedAppliedFields, $auditedFieldType, $predefinedTemplates, $referenceAlias, $availableMassiveButtons);
												$subGroups = asol_ControllerQuery::formatDetailGroupedFields($subGroups, $resulset_fields, $userDateFormat);
											}
											
											//Order resultsetExport for grouped totals
											$subGroupsExport = (empty($subGroupsExport) ? array() : $subGroupsExport);
											
											if ((($report_data['results_limit'] != "all") || $allowExportGeneratedFile) && $lastModuleIteration) {
												$subGroupsExport = asol_ControllerQuery::formatDetailResultSet($reportId, $dashletId, $subGroupsExport, $resulset_fields, $userDateFormat, $userDateTimeFormat, $userTZ, $gmtDates, $isGroupedReport, $audited_report, $auditedAppliedFields, $auditedFieldType, $predefinedTemplates, $referenceAlias, $availableMassiveButtons);
												$subGroupsExport = asol_ControllerQuery::formatDetailGroupedFields($subGroupsExport, $resulset_fields, $userDateFormat);
											}
											
										}
										
										
										//Obtenemos los valores relaciones con el paginado
										if ($report_data['results_limit'] != "all") {
											$total_entries_basic = 0;
											foreach ($subGroupsExport as $subExp)
												$total_entries_basic += count($subExp);
												$pagination['total_entries'] = $total_entries_basic;
										} else {
											$pagination['total_entries'] = $totalEntries;
										}
										
										
										$data['first_entry'] = $first_entry;
										$data['current_entries'] = (!empty($current_entries_limit) ? $current_entries_limit : $current_entries);
										
										//Calculate number of pages
										$parcial = 0;
										$num_pages = 0;
										
										foreach ($sizes as $currentSize) {
											$parcial += $currentSize;
											if (($parcial >= $entriesPerPage)) {
												$num_pages++;
												$parcial = 0;
											}
										}
										
										$pagination['current_page'] = $page_number;
										$pagination['total_pages'] = ($parcial == 0 ? $num_pages-1 : $num_pages);
										
										
										//*************************//
										//******SIMPLE REPORT******//
										//*************************//
									} else {
										
										asol_ReportsUtils::reports_log('debug', 'Simple Report', __FILE__, __METHOD__, __LINE__);
										
										$sqlLimit = (!empty($sqlLimitSubSet)) ? $sqlLimitSubSet : $sqlLimit;
										
										//Obtenemos el resultado de la Query generada
										$sqlQuery = $sqlSelect.$sqlFrom.$sqlJoin.$sqlWhere.$sqlGroup.$sqlHaving.$sqlOrder.$sqlLimit;
										$currentRs = asol_Reports::getSelectionResults($sqlQuery, null, $useExternalDbConnection, $alternativeDb);
										
										
										//***********************//
										//***AlineaSol Premium***//
										//***********************//
										$extraParams = array(
											'isGroupedReport' => $isGroupedReport,
											'groups' => $groups,
											'currentRs' => $currentRs,
											'rs' => $rs,
											'resulsetTotals' => $totals,
											'moduleIteration' => $moduleIteration
										);
										$returnedRs = asol_ReportsUtils::managePremiumFeature("dynamicTablesReport", "reportFunctions.php", "parseMergeSingleResultsets", $extraParams);
										$rs = ($returnedRs !== false ? $returnedRs : $currentRs);
										
										$extraParams = array(
											'rs' => $rs,
											'resulsetFields' => $resulset_fields,
											'referenceAlias' => $referenceAlias
										);
										$returnedPhpRs = asol_ReportsUtils::managePremiumFeature("reportPhpFunctions", "reportFunctions.php", "formatPhpResultSet", $extraParams);
										$rs = ($returnedPhpRs !== false ? $returnedPhpRs : $rs);
										//***********************//
										//***AlineaSol Premium***//
										//***********************//
										
										if ($multiModuleReport && $lastModuleIteration & !empty($orders[0]['alias'])) {
											asol_CommonUtils::sortAssocArray($rs, $orders[0]['alias'], true, ($initialSortDirection === 'ASC'), (in_array($orders[0]['type'], array('int', 'bigint', 'decimal', 'double', 'currency'))));
										}
										
										if ($allowExportGeneratedFile || $report_data['report_charts'] != 'Tabl') {
											
											if ($hasNoPagination) {
												
												$rsExport = $rs;
												
											} else {
												
												$sqlQueryExport = $sqlSelect.$sqlFrom.$sqlJoin.$sqlWhere.$sqlGroup.$sqlHaving.$sqlOrder.$sqlLimitExport;
												$rsExport = asol_Reports::getSelectionResults($sqlQueryExport, null, $useExternalDbConnection, $alternativeDb);
												
												//***********************//
												//***AlineaSol Premium***//
												//***********************//
												$extraParams = array(
													'rs' => $rsExport,
													'resulsetFields' => $resulset_fields,
													'referenceAlias' => $referenceAlias
												);
												$returnedPhpRs = asol_ReportsUtils::managePremiumFeature("reportPhpFunctions", "reportFunctions.php", "formatPhpResultSet", $extraParams);
												$rsExport = ($returnedPhpRs !== false ? $returnedPhpRs : $rsExport);
												//***********************//
												//***AlineaSol Premium***//
												//***********************//
												
												if ($multiModuleReport && $lastModuleIteration & !empty($orders[0]['alias'])) {
													asol_CommonUtils::sortAssocArray($rsExport, $orders[0]['alias'], true, ($initialSortDirection === 'ASC'), (in_array($orders[0]['type'], array('int', 'bigint', 'decimal', 'double', 'currency'))));
												}
												
											}
											
										}
										
										// Totals beginning
										if ($displayTotals) {
											
											if ((($isGroupedReport) && (($report_data['results_limit'] != 'all') || $multiModuleReport)) || $hasGroupedFunctionWithSQL || $hasGroupedFunctionWithHaving) {
												
												//**************************************//
												//******Generate SubTotals Manually*****//
												//**************************************//
												$limitedTotals = asol_ControllerQuery::generateManuallySubTotals($rsExport, $totals, $report_data['results_limit'], false, $subTotalsLimit);
												
											}
											
										}
										// Totals end
										
										$rsNoFormat = $rs;
										$rsExportNoFormat = $rsExport;
										
										if (!$grossExecution) {
											
											//***********************************//
											//********ResultSet Formatting*******//
											//***********************************//
											if ($lastModuleIteration) {
												$rs = asol_ControllerQuery::formatResultSet($reportId, $dashletId, $rs, $resulset_fields, $userDateFormat, $userDateTimeFormat, $userTZ, $gmtDates, $isGroupedReport, $audited_report, $auditedAppliedFields, $auditedFieldType, $predefinedTemplates, $referenceAlias, $availableMassiveButtons);
												$rs = asol_ControllerQuery::formatGroupedFields($rs, $groups, $userDateFormat);
											}
											//***********************************//
											//********ResultSet Formatting*******//
											//***********************************//
											
											
											//***********************************//
											//***Exported ResultSet Formatting***//
											//***********************************//
											if ($lastModuleIteration && $allowExportGeneratedFile) {
												$rsExport = asol_ControllerQuery::formatResultSet($reportId, $dashletId, $rsExport, $resulset_fields, $userDateFormat, $userDateTimeFormat, $userTZ, $gmtDates, $isGroupedReport, $audited_report, $auditedAppliedFields, $auditedFieldType, $predefinedTemplates, $referenceAlias, $availableMassiveButtons);
												$rsExport = asol_ControllerQuery::formatGroupedFields($rsExport, $groups, $userDateFormat);
											}
											//***********************************//
											//***Exported ResultSet Formatting***//
											//***********************************//
											
										}
										
										$pagination['total_entries'] = $total_entries_basic;
										$pagination['entries_per_page'] = $entriesPerPage;
										$data['current_entries'] = count($rs);
										
										$pagination['current_page'] = $page_number;
										$pagination['total_pages'] = (($pagination['total_entries'] % $entriesPerPage) != 0 ? floor($pagination['total_entries'] / $entriesPerPage) : floor($pagination['total_entries'] / $entriesPerPage) -1);
										
									}
									
									
									// Totals beginning
									if ($displayTotals) {
										
										$sqlQueryTotals = $sqlTotals.$sqlFrom.$sqlCountJoin.$sqlWhere;
										$currentRsTotals = asol_Reports::getSelectionResults($sqlQueryTotals, null, $useExternalDbConnection, $alternativeDb);
										
										//***********************//
										//***AlineaSol Premium***//
										//***********************//
										$extraParams = array(
											'currentRsTotals' => $currentRsTotals,
											'rsTotals' => $rsTotals,
											'resulsetTotals' => $totals,
											'moduleIteration' => $moduleIteration
										);
										$returnedRsTotals = asol_ReportsUtils::managePremiumFeature("dynamicTablesReport", "reportFunctions.php", "parseMergeTotalsResultsets", $extraParams);
										$rsTotals = ($returnedRsTotals !== false ? $returnedRsTotals : $currentRsTotals);
										
										
										//**********************************//
										//******Apply Displaying Format*****//
										//**********************************//
										if ((!$grossExecution) && ($lastModuleIteration)) {
											
											$rsTotals = asol_ControllerQuery::formatGroupTotals($reportId, $dashletId, $rsTotals, $totals, $userDateFormat, $userDateTimeFormat, $userTZ, $gmtDates, $audited_report, $auditedAppliedFields, $auditedFieldType);
											
											if (($report_data['results_limit'] != "all") || ($allowExportGeneratedFile)) {
												$limitedTotals = asol_ControllerQuery::formatGroupTotals($reportId, $dashletId, $limitedTotals, $totals, $userDateFormat, $userDateTimeFormat, $userTZ, $gmtDates, $audited_report, $auditedAppliedFields, $auditedFieldType);
											}
											
											$rsTotals = (!empty($limitedTotals) ? $limitedTotals : $rsTotals);
											
										}
										
									}
									// Totals end
									
								}
								
							}
							
						}
				
					} else { //Api
					
						if (($filtersHiddenInputs == false) || ($searchCriteria == true)) {
						
							//******Generate Chart Info******//
							$urlChart = array();
							$chartSubGroupsValues = array();
							
							$chartInfoParams = asol_ReportsGenerationFunctions::getChartInfoParams($selectedCharts, false, $focus->data_source['value']['module']);
							
							$hasStackChart = $chartInfoParams["hasStackChart"];
							$chartInfo = $chartInfoParams["chartInfo"];
							$chartConfig = $chartInfoParams["chartConfig"];
							
							
							//***AlineaSol Premium***//
							$extraParams = array('api' => $focus->data_source['value']['api']);
							$gmtDates = asol_ReportsUtils::managePremiumFeature("externalApiReports", "reportFunctions.php", "getExternalApiGmtDates", $extraParams);
							//***AlineaSol Premium***//
						
							$availableData = asol_ControllerQuery::getAvailableColumns($focus->data_source, $selectedFields, $predefinedTemplates, array('field' => $sort_field, 'direction' => $sort_direction, 'index' => $sort_index), $displayTotals, $displaySubtotals, $report_table, $week_start, $quarter_month, $hourOffset, null, '');
							
							$resulset_fields = $availableData["fields"];
							$columns = $availableData["columns"];
							$subTotals = $availableData["subtotals"];
							$totals = $availableData["totals"];
							$orders = $availableData["orders"];
							
							$isDetailedReport = $availableData["flags"]["isDetailed"];
							$details = $availableData["grouping"]["details"];
							$isGroupedReport = $availableData["flags"]["isGrouped"];
							$groups = $availableData["grouping"]["groups"];
							
							$referenceAlias = $availableData['referenceAlias'];
							
							$hasFunctionField = $availableData["flags"]["hasFunctionField"];
							
							$pagination = array(
								'current_page' => $page_number,
								'entries_per_page' => (!isset($entriesPerPage) ? 1000000 : $entriesPerPage)
							);
							
							//***AlineaSol Premium***//
							$extraParams = array('data_source' => $focus->data_source, 'flags' => $availableData["flags"], 'grouping' => $availableData["grouping"], 'config' => array('fields' => $resulset_fields, 'filters' => $filterValuesData, 'orders' => $orders, 'pagination' => $pagination, 'totals' => $totals, 'limit' => $report_data['results_limit'], 'config' => $selectedFilters['config']));
							$apiReportResult = asol_ReportsUtils::managePremiumFeature("externalApiReports", "reportFunctions.php", "getExternalApiResultset", $extraParams);
							if ($isDetailedReport) {
								$subGroups = ($apiReportResult !== false ? $apiReportResult['resultset'] : array());
								
								//***AlineaSol Premium***//
								$extraParams = array(
									'subGroups' => $subGroups,
									'resulsetFields' => $resulset_fields,
									'referenceAlias' => $referenceAlias
								);
								$returnedPhpRs = asol_ReportsUtils::managePremiumFeature("reportPhpFunctions", "reportFunctions.php", "formatPhpDetailResultSet", $extraParams);
								$subGroups = ($returnedPhpRs !== false ? $returnedPhpRs : $subGroups);
								//***AlineaSol Premium***//
								
								$subGroupsExport = ($apiReportResult !== false ? $apiReportResult['resultsetExport'] : array());
	
								//***AlineaSol Premium***//
								$extraParams = array(
									'subGroups' => $subGroupsExport,
									'resulsetFields' => $resulset_fields,
									'referenceAlias' => $referenceAlias
								);
								$returnedPhpRs = asol_ReportsUtils::managePremiumFeature("reportPhpFunctions", "reportFunctions.php", "formatPhpDetailResultSet", $extraParams);
								$subGroupsExport = ($returnedPhpRs !== false ? $returnedPhpRs : $subGroupsExport);
								//***AlineaSol Premium***//
								
								$subTotals = ($apiReportResult !== false ? $apiReportResult['subtotals'] : array());
								$subTotalsExport = ($apiReportResult !== false ? $apiReportResult['subtotalsExport'] : array());
							} else {
								$rs = ($apiReportResult !== false ? $apiReportResult['resultset'] : array());
								
								//***AlineaSol Premium***//
								$extraParams = array(
									'rs' => $rs,
									'resulsetFields' => $resulset_fields,
									'referenceAlias' => $referenceAlias
								);
								$returnedPhpRs = asol_ReportsUtils::managePremiumFeature("reportPhpFunctions", "reportFunctions.php", "formatPhpResultSet", $extraParams);
								$rs = ($returnedPhpRs !== false ? $returnedPhpRs : $rs);
								//***AlineaSol Premium***//
								
								$rsExport = ($apiReportResult !== false ? $apiReportResult['resultsetExport'] : array());
								
								//***AlineaSol Premium***//
								$extraParams = array(
									'rs' => $rsExport,
									'resulsetFields' => $resulset_fields,
									'referenceAlias' => $referenceAlias
								);
								$returnedPhpRs = asol_ReportsUtils::managePremiumFeature("reportPhpFunctions", "reportFunctions.php", "formatPhpResultSet", $extraParams);
								$rsExport = ($returnedPhpRs !== false ? $returnedPhpRs : $rsExport);
								//***AlineaSol Premium***//
							}
							$rsTotals = ($apiReportResult !== false ? $apiReportResult['totals'] : array());
							$pagination = ($apiReportResult !== false ? $apiReportResult['pagination'] : $pagination);
							//***AlineaSol Premium***//
							
							$rsNoFormat = $rs;
							$rsExportNoFormat = $rsExport;
							$subGroupsNoFormat = $subGroups;
							$subGroupsExportNoFormat = $subGroupsExport;
							if (!$grossExecution) {
								//********ResultSet Formatting*******//
								if ($isDetailedReport) {
									
									$detailFieldInfo = $details[0];
									
									//******Format SubGroup******//
									foreach ($subGroups as $key => $currentGroup) {
										if ($detailFieldInfo['function'] == '0') {
											$formattedKey = asol_ControllerQuery::formatDateSpecialsGroup($reportId, $dashletId, $key, $detailFieldInfo, $userDateFormat, $userTZ, $gmtDates);
											$subGroups[$formattedKey] = $subGroups[$key];
											unset($subGroups[$key]);
										}
									}
									
									$subGroups = asol_ControllerQuery::formatDetailResultSet($reportId, $dashletId, $subGroups, $resulset_fields, $userDateFormat, $userDateTimeFormat, $userTZ, $gmtDates, $isGroupedReport, $audited_report, $auditedAppliedFields, $auditedFieldType, $predefinedTemplates, $referenceAlias, $availableMassiveButtons);
									$subGroups = asol_ControllerQuery::formatDetailGroupedFields($subGroups, $resulset_fields, $userDateFormat);
									foreach ($subTotals as & $subTotal) {
										//******Apply Displaying Format*****//
										$subTotal = asol_ControllerQuery::formatGroupTotals($reportId, $dashletId, array($subTotal), $totals, $userDateFormat, $userDateTimeFormat, $userTZ, $gmtDates, $audited_report, $auditedAppliedFields, $auditedFieldType);
										$subTotal = $subTotal[0];
										//******Apply Displaying Format*****//
									}
									
									//******Format SubGroup******//
									foreach ($subGroupsExport as $key => $currentGroup) {
										if ($detailFieldInfo['function'] == '0') {
											$formattedKey = asol_ControllerQuery::formatDateSpecialsGroup($reportId, $dashletId, $key, $detailFieldInfo, $userDateFormat, $userTZ, $gmtDates);
											$subGroupsExport[$formattedKey] = $subGroupsExport[$key];
											unset($subGroupsExport[$key]);
										}
									}
									
									$subGroupsExport = asol_ControllerQuery::formatDetailResultSet($reportId, $dashletId, $subGroupsExport, $resulset_fields, $userDateFormat, $userDateTimeFormat, $userTZ, $gmtDates, $isGroupedReport, $audited_report, $auditedAppliedFields, $auditedFieldType, $predefinedTemplates, $referenceAlias, $availableMassiveButtons);
									$subGroupsExport = asol_ControllerQuery::formatDetailGroupedFields($subGroupsExport, $resulset_fields, $userDateFormat);
									foreach ($subTotalsExport as & $subTotalExport) {
										//******Apply Displaying Format*****//
										$subTotalExport = asol_ControllerQuery::formatGroupTotals($reportId, $dashletId, array($subTotalExport), $totals, $userDateFormat, $userDateTimeFormat, $userTZ, $gmtDates, $audited_report, $auditedAppliedFields, $auditedFieldType);
										$subTotalExport = $subTotal[0];
										//******Apply Displaying Format*****//
									}
								} else {
									$rs = asol_ControllerQuery::formatResultSet($reportId, $dashletId, $rs, $resulset_fields, $userDateFormat, $userDateTimeFormat, $userTZ, $gmtDates, $isGroupedReport, $audited_report, $auditedAppliedFields, $auditedFieldType, $predefinedTemplates, $referenceAlias, $availableMassiveButtons);
									$rs = asol_ControllerQuery::formatGroupedFields($rs, $groups, $userDateFormat);
									
									$rsExport = asol_ControllerQuery::formatResultSet($reportId, $dashletId, $rsExport, $resulset_fields, $userDateFormat, $userDateTimeFormat, $userTZ, $gmtDates, $isGroupedReport, $audited_report, $auditedAppliedFields, $auditedFieldType, $predefinedTemplates, $referenceAlias, $availableMassiveButtons);
									$rsExport = asol_ControllerQuery::formatGroupedFields($rsExport, $groups, $userDateFormat);
								}
								//********ResultSet Formatting*******//
							}
						
							$subTotalsC = $subTotalsExport;
							$massiveData = ($isDetailedReport && !$isGroupedReportped && !$hasFunctionField);
							
						}
						
					}
					
					
					if ($isDetailedReport) {
						
						//***Data For Charts Generation***//
						$dataForChartsGeneration = asol_ReportsCharts::getDataForChartsGeneration($chartInfo, $chartConfig, $selectedFields, $subTotalsC, $subGroupsExportNoFormat, $massiveData, true, $isGroupedReport, $hasFunctionField,  $groups, $groupExport, $userDateFormat);
						
						$subGroupsChart = $dataForChartsGeneration['subGroupsChart'];
						$chartValues = $dataForChartsGeneration['chartValues'];
						$chartConfigs = $dataForChartsGeneration['chartConfigs'];
						$chartTemplates = $dataForChartsGeneration['chartTemplates'];
						$chartYAxisLabels = $dataForChartsGeneration['chartYAxisLabels'];
						//***Data For Charts Generation***//
						
						//***Generate Chart Files & ExtraData***//
						$chartFilesWithExtraData = asol_ReportsCharts::getChartFilesWithExtraData($focus->report_charts_engine, true, $massiveData, $chartInfo, $chartConfigs, $chartTemplates, $predefinedTemplates['color'], $chartYAxisLabels, $chartValues, $subGroupsChart, $reportId, $dashletId, $report_module, $chartsHttpQueryUrls, $isDetailedReport, $isGroupedReport, $isStoredReport);
						
						$urlChart = $chartFilesWithExtraData['urlChart'];
						$chartSubGroupsValues = $chartFilesWithExtraData['chartSubGroupsValues'];
						//***Generate Chart Files & ExtraData***//
						
					} else if ($isGroupedReport) {
						
						//***Data For Charts Generation***//
						$dataForChartsGeneration = asol_ReportsCharts::getDataForChartsGeneration($chartInfo, $chartConfig, $selectedFields, $rsExportNoFormat, null, null, false, true, $hasFunctionField, $groups, null, $userDateFormat);
						
						$subGroupsChart = $dataForChartsGeneration['subGroupsChart'];
						$chartValues = $dataForChartsGeneration['chartValues'];
						$chartConfigs = $dataForChartsGeneration['chartConfigs'];
						$chartTemplates = $dataForChartsGeneration['chartTemplates'];
						$chartYAxisLabels = $dataForChartsGeneration['chartYAxisLabels'];
						//***Data For Charts Generation***//
						
						//***Generate Chart Files & ExtraData***//
						$chartFilesWithExtraData = asol_ReportsCharts::getChartFilesWithExtraData($focus->report_charts_engine, false, false, $chartInfo, $chartConfigs, $chartTemplates, $predefinedTemplates['color'], $chartYAxisLabels, $chartValues, $subGroupsChart, $reportId, $dashletId, $report_module, $chartsHttpQueryUrls, false, false, $isStoredReport);
						
						$urlChart = $chartFilesWithExtraData['urlChart'];
						$chartSubGroupsValues = $chartFilesWithExtraData['chartSubGroupsValues'];
						//***Generate Chart Files & ExtraData***//
						
					}
					
					$hasDisplayedCharts = ((count($urlChart) > 0) && ($report_data['report_charts'] != 'Tabl'));
					
						
				}
					
				
				if (!$oversizedReport) {
					
					$columnsDataFields = array();
					$columnsDataRefs = array();
					$columnsDataTypes = array();
					$columnsDataFunctions = array();
					$columnsDataWidths = array();
					$columnsDataVisible = array();
					
					foreach ($resulset_fields as $currentField) {
						
						$currentType = (!empty($currentField['format']['type']) ? $currentField['format']['type'] : $currentField['type']);
						$currentVisible = $currentField['visible'];
						$parenthesesPosition = strpos($currentType, '(');
						if ($parenthesesPosition != false) {
							$currentType = substr($currentType, 0, $parenthesesPosition);
						}
						
						//***********************//
						//***AlineaSol Premium***//
						//***********************//
						$extraParams = array(
							'dataType' => $currentType,
							'dataFormat' => $currentField['format'],
						);
						$buttonTypeResult = asol_ReportsUtils::managePremiumFeature("reportButtonFormat", "reportFunctions.php", "getButtonTypeClass", $extraParams);
						$buttonTypeClass = $buttonTypeResult['class'];
						$delimiterToken = (empty($buttonTypeResult['delimiter']) ? $delimiterToken : $buttonTypeResult['delimiter']);
						//***********************//
						//***AlineaSol Premium***//
						//***********************//
						
						$columnsDataFields[$currentField['alias']] = $currentField['notModifiedFieldName'];
						$columnsDataRefs[$currentField['alias']] = $currentField['fieldReference'];
						$columnsDataTypes[$currentField['alias']] = ($buttonTypeClass !== false ? $buttonTypeClass : $currentType);
						$columnsDataFunctions[$currentField['alias']] = ($currentField['function'] === '0' ? null : $currentField['function']);
						$columnsDataVisible[$currentField['alias']] = $currentVisible;
						
					}
					
					
					$typesWeightedWidth = asol_ReportsGenerationFunctions::getTypesWeightedWidthArray();
					$totalWeightedWidth = asol_ReportsGenerationFunctions::getRowTotalWeightedWidth($columnsDataTypes, $columnsDataFunctions, $columnsDataVisible, $typesWeightedWidth, $isGroupedReport, $hasRowIndexDisplay);
					if ($hasRowIndexDisplay) {
						$columnsDataWidths['rowIndexDisplay'] = asol_ReportsGenerationFunctions::getCellWidthBasedOnTypology('index', $typesWeightedWidth, $totalWeightedWidth);
					}
					foreach ($columnsDataTypes as $columnsDataKey => $columnsDataType) {
						if ((!in_array($columnsDataVisible[$columnsDataKey], array('html', 'internal'))) && ($isGroupedReport || !isset($columnsDataFunctions[$columnsDataKey]))) {
							$columnsDataWidths[$columnsDataKey] = asol_ReportsGenerationFunctions::getCellWidthBasedOnTypology($columnsDataType, $typesWeightedWidth, $totalWeightedWidth);
						}
					}
					
					
					//**************************************//
					//****Save Report Data into Txt File****//
					//**************************************//
					if ($allowExportGeneratedFile) {
						
						$exportedReport = Array();
						
						$exportedReport['id'] = $reportId;
						$exportedReport['name'] = $report_name;
						$exportedReport['report_type'] = $report_data['report_type'];
						$exportedReport['report_type_stored_data'] = $report_data['report_type_stored_data'];
						$exportedReport['module'] = $report_module;
						$exportedReport['description'] = $report_data['description'];
						$exportedReport['report_charts'] = $report_data['report_charts'];
						$exportedReport['report_charts_engine'] = $report_data['report_charts_engine'];
						$exportedReport['report_attachment_format'] = $report_data['report_attachment_format'];
						$exportedReport['row_index_display'] = $report_data['row_index_display'];
						$exportedReport['results_limit'] = $report_data['results_limit'];
						$exportedReport['email_list'] = $focus->email_list;
						$exportedReport['created_by'] = $focus->created_by;
						
						if (asol_CommonUtils::isDomainsInstalled()) {
							$exportedReport['asol_domain_id'] = $focus->asol_domain_id;
							$exportedReport['asol_domain_external'] = BeanFactory::getBean('asol_Domains', $focus->asol_domain_id)->external_id;
						}
						
						$exportedReport['displayTitles'] = $displayTitles;
						$exportedReport['displayHeaders'] = $displayHeaders;
						$exportedReport['displayTotals'] = $displayTotals;
						$exportedReport['displaySubtotals'] = $displaySubtotals;
						$exportedReport['hasGroupedTotalBelowColumn'] = $hasGroupedTotalBelowColumn;
						$exportedReport['pdf_pageFormat'] = $pdf_pageFormat;
						$exportedReport['pdf_orientation'] = $pdf_orientation;
						$exportedReport['pdf_img_scaling_factor'] = $pdf_img_scaling_factor;
						
						$exportedReport['totals'] = $rsTotals;
						$exportedReport['headers'] = $columns;						
						
						$exportedReport['headersTotals'] = $totals;
						
						$exportedReport['current_user_id'] = $current_user->id;
						$exportedReport['context_domain_id'] = $reportDomain;
						
						$exportedReport['isDetailedReport'] = $isDetailedReport;
						$exportedReport['isGroupedReport'] = $isGroupedReport;
						$exportedReport['hasDisplayedCharts'] = $hasDisplayedCharts;
						
						$exportedReport['reportScheduledType'] = $focus->report_scheduled_type;
						
						if ($isDetailedReport) {
							$exportedReport['resultset'] = $subGroupsExport;
							$exportedReport['resultsetNoFormat'] = $subGroupsExportNoFormat;
							$exportedReport['subTotals'] = $subTotalsExport;
							$exportedReport['subTotalsNoFormat'] = $subTotalsExportNoFormat;
						} else {
							$exportedReport['resultset'] = $rsExport;
							$exportedReport['resultsetNoFormat'] = $rsExportNoFormat;
						}
						
						$exportedReport['columnsDataFields'] = $columnsDataFields;
						$exportedReport['columnsDataTypes'] = $columnsDataTypes;
						$exportedReport['columnsDataFunctions'] = $columnsDataFunctions;
						$exportedReport['columnsDataVisible'] = $columnsDataVisible;
						$exportedReport['columnsDataWidths'] = $columnsDataWidths;
						
						$exportedReport['currentReportCss'] = $currentReportCss;
						
						$exportedReport['chatLayout'] = str_replace(',', '.', $focus->report_charts_detail['layout']);
						
						//Guardamos el fichero en disco por si surge un export
						$exportedReportFile = asol_ReportsGenerationFunctions::getReportExportedFileName($report_data['name']).".txt";
						
						$exportFolder = "modules/asol_Reports/tmpReportFiles/";
						$storedReportsSubFolder = "storedReports/";
						
						//If Scheduled-Stored Report, save report in StoredReports subfolder & update Report with reportFileName
						if ($report_data['report_type'] == 'stored') {
							
							$storedReportData = (empty($exportedReport['report_type_stored_data'])) ? array() : unserialize(base64_decode($exportedReport['report_type_stored_data']));
							
							$chartFiles = array();
							
							foreach ($chartInfo as $key=>$info) {
								
								if (!empty($urlChart[$key])) {
									$chartFiles[] = array(
										'file' => $urlChart[$key],
										'type' => $info["type"],
										'subGroups' => $info["subgroups"]
									);
								}
								
							}
							
							$accessKey = (asol_CommonUtils::isDomainsInstalled()) ? $reportDomain : 'base';
							
							$storedReportData[$accessKey] = array(
								'infoTxt' => $storedReportsSubFolder.$exportedReportFile,
								'chartFiles' => $chartFiles
							);
							
							$storedType = array(
								'type' => 'stored',
								'data' => base64_encode(serialize($storedReportData))
							);
							$setStoredReportFile = "UPDATE asol_reports SET report_type = '".rawurlencode(json_encode($storedType))."' WHERE id = '".$reportId."' LIMIT 1";
							$db->query($setStoredReportFile);
							
							$exportFolder .= $storedReportsSubFolder;
							
						}
						
						
						$exportFile = fopen($exportFolder.$exportedReportFile, "w");
						fwrite($exportFile, serialize($exportedReport));
						fclose($exportFile);
						
					}
					
					//********************************************//
					//****Do Final Action for Executed Reports****//
					//********************************************//
					if ((!isset($_REQUEST['return_action'])) && (!$hasStaticFilters)) {
						asol_ReportsGenerationFunctions::doFinalExecuteReportActions($reportId, $initialTimestamp, $dispatcherMaxRequests);
					}
					
				}
				
				
				$externalCssUsage = (isset($_REQUEST['useExternalCss']) && $_REQUEST['useExternalCss'] == 'true');
				if (($reportType === 'external') && $externalCssUsage) {
					$reportHeadersHtml .= '<link rel="stylesheet" type="text/css" href="modules/asol_Reports/include/css/external.css?version='.str_replace('.', '', asol_ReportsUtils::$reports_version).'">';
				}
				
				
				//***********************//
				//***AlineaSol Premium***//
				//***********************//
				$extraParams = array('overrideParam' => (!isset($staticFilters) ? null : $staticFilters));
				$staticFilters = asol_ReportsUtils::managePremiumFeature("reportFieldsManagement", "reportFunctions.php", "getStaticFilterRequest", $extraParams);
				//***********************//
				//***AlineaSol Premium***//
				//***********************//
				
				if ($getReloadFunctions) {
					$reportHeadersHtml .= '<script type="text/javascript">'.asol_ReportsGenerationFunctions::getLoadCurrentDashletScriptFunction($reportId, $isDashlet, $dashletId, $getLibraries, $staticFilters, $override_entries, $current_user->id).'</script>';
				}
				
				//***********************//
				//***AlineaSol Premium***//
				//***********************//
				if (!empty($currentReportCss)) {
					$reportHeadersHtml .= $currentReportCss;
				}
				//***********************//
				//***AlineaSol Premium***//
				//***********************//
				
				//Asignamos los valores para el ordenado
				$report_data['sort_field'] = $orders[0]['field'];
				$report_data['sort_direction'] = $orders[0]['direction'];
				$report_data['sort_index'] = $orders[0]['index'];
				
				
				$rsTotals = (!empty($limitedTotals) ? $limitedTotals : (empty($rsTotals) ? array() : $rsTotals));
				
				$reportFields = ($isDetailedReport ? $subGroups : $rs);
				$reportNoFormatFields = ($isDetailedReport ? $subGroupsNoFormat : $rsNoFormat);
				
				if ($isHttpReportRequest) {
					
					if ($isScheduledExecution) {
						
						if ($report_data['report_type'] == "scheduled") {
							
							$reportScheduledTypeArray = explode(':', $focus->report_scheduled_type);
							$reportScheduledType = (empty($reportScheduledTypeArray[0])) ? 'email' : $reportScheduledTypeArray[0];
							$reportScheduledTypeInfo = (empty($reportScheduledTypeArray[1])) ? null : json_decode(urldecode($reportScheduledTypeArray[1]), true);
							
							if ($reportScheduledType == 'app') { // Send Application
								
								//***********************//
								//***AlineaSol Premium***//
								//***********************//
								$extraParams = array(
									'scheduledTypeInfo' => $reportScheduledTypeInfo,
									'csvData' => array(
										'reportName' => $report_data['name'],
										'headers' => $columns,
										'resultset' => $rsExport,
										'resultsetNoFormat' => $rsExportNoFormat,
										'subtotals' => $subTotalsExport,
										'isDetailed' => $isDetailedReport,
										'rowIndexDisplay' => $report_data['row_index_display']
									)
								);
								
								asol_ReportsUtils::managePremiumFeature("externalApplicationReports", "reportFunctions.php", "sendReportToExternalApplication", $extraParams);
								//***********************//
								//***AlineaSol Premium***//
								//***********************//
								
							} else if ($reportScheduledType == 'tl') { // Send Target list
								
								//***********************//
								//***AlineaSol Premium***//
								//***********************//
								$extraParams = array(
									'scheduledTypeInfo' => $reportScheduledTypeInfo,
									'reportModule' => $report_module,
									'columnsDataFields' => $columnsDataFields,
									'resultset' => $rsExport,
								);
								
								asol_ReportsUtils::managePremiumFeature("externalApplicationReports", "reportFunctions.php", "sendReportToTargetList", $extraParams);
								//***********************//
								//***AlineaSol Premium***//
								//***********************//
								
							} else {
									
								$tmpFilesDir = "modules/asol_Reports/tmpReportFiles/";
								$attachment = null;
								
								$rsExport = ($isDetailedReport ? $subGroups : $rs);
								$subTotalsExport = ($isDetailedReport ? $subTotals : '');
								
								
								if ($report_data['report_charts'] != 'Char') { //If only charts Report, do not attach a generated file
									
									$descriptionArray = unserialize(base64_decode($report_data["description"]));
									$description = $descriptionArray['public'];
																		
									switch ($reportAttachmentFormat) {
										
										case "PDF":
											$attachment = generateFile($reportAttachmentConfig, $report_data['name'], $app_list_strings["moduleList"][$report_data['report_module']], $description, $displayTitles, $displayHeaders, array_keys($columns), $rsExport, $rsExportNoFormat, $totals, $rsTotals, $subTotalsExport, $isDetailedReport, $isGroupedReport, $hasGroupedTotalBelowColumn, $pdf_orientation, Array(), Array(), Array(), false, $pdf_img_scaling_factor, time(), $userTZlabel, $report_data['row_index_display'], $report_data['report_charts'], $columnsDataTypes, $columnsDataFunctions, $columnsDataVisible, $columnsDataWidths, $currentReportCss, $reportDomain,$pdf_pageFormat);
											break;
										case "HTML":
											$attachment = generateFile($reportAttachmentConfig, $report_data['name'], $app_list_strings["moduleList"][$report_data['report_module']], $description, $displayTitles, $displayHeaders, array_keys($columns), $rsExport, $rsExportNoFormat, $totals, $rsTotals, $subTotalsExport, $isDetailedReport, $isGroupedReport, $hasGroupedTotalBelowColumn, $pdf_orientation, Array(), Array(), Array(), true, 100, time(), $userTZlabel, $report_data['row_index_display'], $report_data['report_charts'], $columnsDataTypes, $columnsDataFunctions, $columnsDataVisible, $columnsDataWidths, $currentReportCss, $reportDomain,$pdf_pageFormat);
											break;
										case "CSV":
											$attachment = generateCsv($reportAttachmentConfig, $report_data['name'], array_keys($columns), $rsExport, $rsExportNoFormat, $totals, $rsTotals, $subTotalsExport, $isDetailedReport, $isGroupedReport, $hasGroupedTotalBelowColumn, false, $report_data['row_index_display'], $columnsDataTypes, $columnsDataVisible, false, !$displayTitles, !$displayHeaders);
											break;
										case "CSVC":
											if ($reportAttachmentConfig['massive']) {
												//***********************//
												//***AlineaSol Premium***//
												//***********************//
												$currentQuery = $sqlSelect.$sqlFrom.$sqlJoin.$sqlWhere.$sqlGroup.$sqlHaving.$sqlLimit;
												$massiveExportResult = asol_ReportsUtils::managePremiumFeature("executeMassiveExport", "reportFunctions.php", "executeMassiveExport", array('fileConfig' => $reportAttachmentConfig, 'currentQuery' => $currentQuery, 'reportName' => $report_data['name'], 'useAlternativeDbConnection' => $useAlternativeDbConnection, 'alternativeDb' => $alternativeDb));
												$attachment = ($massiveExportResult !== false ? $massiveExportResult : null);
												//***********************//
												//***AlineaSol Premium***//
												//***********************//
											} else {
												$attachment = generateCsv($reportAttachmentConfig, $report_data['name'], array_keys($columns), $rsExport, $rsExportNoFormat, $totals, $rsTotals, $subTotalsExport, $isDetailedReport, $isGroupedReport, $hasGroupedTotalBelowColumn, false, $report_data['row_index_display'], $columnsDataTypes, $columnsDataVisible, true, true, false, false, true);
											}
											break;
										case "XLS":
											$attachment = generateXls($reportAttachmentConfig, $report_data['name'], array_keys($columns), $rsExport, $rsExportNoFormat, $totals, $rsTotals, $subTotalsExport, $isDetailedReport, $isGroupedReport, $hasGroupedTotalBelowColumn, false, $report_data['row_index_display'], $columnsDataTypes, $columnsDataVisible, false, !$displayTitles, !$displayHeaders);
											break;
										case "XLSC":
											$attachment = generateXls($reportAttachmentConfig, $report_data['name'], array_keys($columns), $rsExport, $rsExportNoFormat, $totals, $rsTotals, $subTotalsExport, $isDetailedReport, $isGroupedReport, $hasGroupedTotalBelowColumn, false, $report_data['row_index_display'], $columnsDataTypes, $columnsDataVisible, true, true, false, true, true);
											break;
											
									}
									
									
									//***********************//
									//***AlineaSol Premium***//
									//***********************//
									$autoZipScheduledAttachmentResult = asol_ReportsUtils::managePremiumFeature("autoZipScheduledAttachments", "reportFunctions.php", "generateAutoZipAttachment", array('attachment' => $attachment, 'reportName' => $report_data['name'], 'fileConfig' => $reportAttachmentConfig));
									$attachment = ($autoZipScheduledAttachmentResult !== false ? $autoZipScheduledAttachmentResult : $attachment);
									//***********************//
									//***AlineaSol Premium***//
									//***********************//
									
								}
								
								if ($reportScheduledType == 'email') { //Send Email
									
									$noDataReport = ((empty($urlChart)) && (asol_ReportsGenerationFunctions::isEmptyResultSet($reportFields)));
									$doNotSendIfEmpty = ($reportScheduledTypeInfo == null) ? false : $reportScheduledTypeInfo['doNotSendIfEmpty'];
									
									if ((!$noDataReport) || ($noDataReport && (!$doNotSendIfEmpty))) {
										
										$mail = asol_ReportsGenerationFunctions::getRetrievedReportMailer($focus->email_list, $report_data['created_by'], $report_data['name'], $report_data['report_module'], $descriptionArray['public'], $reportDomain);
										
										if ($report_data['scheduled_images'] == "1") {
											
											$chartFiles = array();
											
											foreach ($chartInfo as $key=>$info) {
												if (!empty($urlChart[$key])) {
													$chartFiles[] = array(
														'file' => $urlChart[$key],
														'type' => $info["type"],
														'subGroups' => $info["subgroups"]
													);
												}
											}
											
											$accessKey = 'base';
											
											$storedReportData[$accessKey] = array(
												'infoTxt' => $exportedReportFile,
												'chartFiles' => $chartFiles
											);
											
											$serializedStoredData = base64_encode(serialize($storedReportData));
											
											$uri = (!empty($host_name)) ? $host_name : $sugar_config['site_url'];
											$uri .= "/index.php";
											$uri .= "?entryPoint=scheduledEmailReport&module=asol_Reports&getLibraries=true&storedReportInfo=".$serializedStoredData;
											
											asol_ReportsUtils::reports_log('asol', 'scheduledImages is enabled - URI Rebuild: '.$uri, __FILE__, __METHOD__, __LINE__);
											
											$mail->Body .= "<br><br>";
											$mail->Body .= "<a href='".$uri."'>".$mod_strings['LBL_REPORT_EMAIL_TTL_TEXT_1']."</a> ".$mod_strings['LBL_REPORT_EMAIL_TTL_TEXT_2']."<br><br>";
											$mail->Body .= "<i>".$mod_strings['LBL_REPORT_EMAIL_AVAILABLE_TEXT_1']." ".$scheduled_files_ttl." ".$mod_strings['LBL_REPORT_EMAIL_AVAILABLE_TEXT_2']."</i>";
											
											$mail->AltBody .= "\n\n";
											$mail->AltBody .= $mod_strings['LBL_REPORT_ALT_EMAIL_TTL_TEXT'].": ".$uri."\n\n";
											$mail->AltBody .= $mod_strings['LBL_REPORT_EMAIL_AVAILABLE_TEXT_1']." ".$scheduled_files_ttl." ".$mod_strings['LBL_REPORT_EMAIL_AVAILABLE_TEXT_2'];
											
										}
										
										if (isset($attachment)) {
											$mail->AddAttachment(getcwd()."/".$tmpFilesDir.$attachment, $attachment);
										}
										
										$success = $mail->Send();
										
										$tries=1;
										while ((!$success) && ($tries < 5)) {
											
											sleep(5);
											$success = $mail->Send();
											$tries++;
											
										}
									}
									
								} else if ($reportScheduledType == 'ftp') { //Send FTP
									
									//***********************//
									//***AlineaSol Premium***//
									//***********************//
									$extraParams = array(
										'scheduledTypeInfo' => $reportScheduledTypeInfo,
										'attachment' => $attachment,
									);
									asol_ReportsUtils::managePremiumFeature("externalApplicationReports", "reportFunctions.php", "sendReportToServerFtp", $extraParams);
									//***********************//
									//***AlineaSol Premium***//
									//***********************//
									
								}
								
								if ($report_data['report_charts'] != 'Char') {
									unlink(getcwd()."/".$tmpFilesDir.$attachment);
								}
									
							}
								
						}
						
					} else {
						
						$tmpFilesDir = "modules/asol_Reports/tmpReportFiles/";
						$httpHtmlFile = $_REQUEST['httpHtmlFile'];
						
						$noDataReport = ((empty($urlChart)) && (asol_ReportsGenerationFunctions::isEmptyResultSet($reportFields)));
						$reportedError = asol_Reports::$reported_error;
						
						if ($returnHtml) {
							return $reportHeadersHtml.(include "modules/asol_Reports/include/DetailViewHttpSave.php");
						} else {
							echo $reportHeadersHtml;
							include "modules/asol_Reports/include/DetailViewHttpSave.php";
						}
						
					}
					
				} else {
					
					$justDisplay = true;
					
					$noDataReport = ((empty($urlChart)) && (asol_ReportsGenerationFunctions::isEmptyResultSet($reportFields)));
					$reportedError = asol_Reports::$reported_error;
					
					if (!isset($returnHtml)) {
						
						return array(
							'fields' => $selectedFields['tables'][0]['data'],
							'domain' => null,
							'data' => array(
								'values' => $reportNoFormatFields,
								'labels' => $reportFields
							)
						);
						
					} else if ($returnHtml) {
						
						if ($isMetaSubReport) {
							
							//***********************//
							//***AlineaSol Premium***//
							//***********************//
							$retunedHtmls = array();
							foreach ($override_info as $singleKey => $singleInfo) {
								
								$dataReferences = $singleInfo['data'];
								$reportVisibility = $singleInfo['visibility'];
								
								$dataVisibility = array(
									'field' => (isset($dataReferences['fields'])),
									'filter' => (isset($dataReferences['filters'])),
									'chart' => (isset($dataReferences['charts']))
								);
								$displayTitles = $reportVisibility['titles'];
								$displayHeaders = $reportVisibility['headers'];
								$displaySubtotals = $reportVisibility['subtotals'];
								$displayTotals = $reportVisibility['totals'];
								$displayPagination = ($reportVisibility['pagination'] ? $paginationType : null);
								
								$hasGroupedTotalBelowColumn = !$reportVisibility['expand'];
								$cleanUpStyling = $reportVisibility['cleanup'];
								
								$retunedHtmls[] = $currentReportCss.(include "modules/asol_Reports/include/DetailViewHttpSave.php");
								
							}
							
							return $retunedHtmls;
							//***********************//
							//***AlineaSol Premium***//
							//***********************//
							
						} else {
							
							if (isset($override_info)) {
								$dataReferences = $override_info['data'];
								$dataVisibility = array(
									'field' => (isset($dataReferences['fields'])),
									'filter' => (isset($dataReferences['filters'])),
									'chart' => (isset($dataReferences['charts']))
								);
							}
							
							return $reportHeadersHtml.(include "modules/asol_Reports/include/DetailViewHttpSave.php");
						}
						
					} else {
						
						if ($isMetaSubReport) {
							
							//***********************//
							//***AlineaSol Premium***//
							//***********************//
							$justDisplay = true;
							$returnHtml = true;
							
							$retunedHtmls = array();
							foreach ($override_info as $singleKey => $singleInfo) {
								
								$dataReferences = $singleInfo['data'];
								$reportVisibility = $singleInfo['visibility'];
								
								$dataVisibility = array(
									'field' => (isset($dataReferences['fields'])),
									'filter' => (isset($dataReferences['filters'])),
									'chart' => (isset($dataReferences['charts']))
								);
								$displayTitles = $reportVisibility['titles'];
								$displayHeaders = $reportVisibility['headers'];
								$displaySubtotals = $reportVisibility['subtotals'];
								$displayTotals = $reportVisibility['totals'];
								$displayPagination = ($reportVisibility['pagination'] ? $paginationType : null);
								
								$hasGroupedTotalBelowColumn = !$reportVisibility['expand'];
								$cleanUpStyling = $reportVisibility['cleanup'];
								
								$retunedHtmls[] = $currentReportCss.(include "modules/asol_Reports/include/DetailViewHttpSave.php");
								
							}
							
							echo json_encode($retunedHtmls);
							//***********************//
							//***AlineaSol Premium***//
							//***********************//
							
						} else {
							echo $reportHeadersHtml;
							
							if (isset($override_info)) {
								$dataReferences = $override_info['data'];
								$dataVisibility = array(
									'field' => (isset($dataReferences['fields'])),
									'filter' => (isset($dataReferences['filters'])),
									'chart' => (isset($dataReferences['charts']))
								);
							}
							
							include "modules/asol_Reports/include/DetailViewHttpSave.php";
						}
						
						exit();
						
					}
					
				}
				
			} else {
				
				require_once('modules/asol_Reports/include/ReportChart.php');
				require_once('modules/asol_Reports/include/server/controllers/controllerQuery.php');
				require_once('modules/asol_Reports/include/generateReportsFunctions.php');
				require_once('modules/asol_Reports/include/manageReportsFunctions.php');
				
				asol_ReportsUtils::reports_log('debug', 'HttpRequest REPORT!!', __FILE__, __METHOD__, __LINE__);
				
				$shortTermExecution = ((isset($currentReportConfig['shortTermExecution'])) && ($currentReportConfig['shortTermExecution']));
				
				$hasSearchCriteria = (!isset($_REQUEST['search_criteria'])) ? false : true;
				
				$pageNumber = (empty($_REQUEST['page_number'])) ? "" : "&page_number=".$_REQUEST['page_number'];
				$sortingField = (empty($_REQUEST['sort_field'])) ? "" : "&sort_field=".$_REQUEST['sort_field']."&sort_direction=".$_REQUEST['sort_direction']."&sort_index=".$_REQUEST['sort_index'];
				
				$externalFilters = (!isset($_REQUEST['external_filters'])) ? "" : "&external_filters=".html_entity_decode($_REQUEST['external_filters']);
				
				//***********************//
				//***AlineaSol Premium***//
				//***********************//
				$extraParams = array('overrideParam' => (!isset($staticFilters) ? null : $staticFilters));
				$staticFilters = asol_ReportsUtils::managePremiumFeature("reportFieldsManagement", "reportFunctions.php", "getStaticFilterRequest", $extraParams);
				//***********************//
				//***AlineaSol Premium***//
				//***********************//
				
				$overrideEntries = (empty($override_entries) ? "" : "&overrideEntries=".$override_entries);
				$overrideExport = (empty($override_export) ? "" : "&overrideExport=1");
				$overrideInfo = (empty($override_info['data']) ? "" : "&overrideInfo=".urldecode(json_encode($override_info)));
				$staticFiltersP = (empty($staticFilters) ? "" : "&staticFilters=".$staticFilters);
				$searchCriteria = (!isset($_REQUEST['search_criteria']) ? "" : "&search_criteria=1");
				$filtersHiddenInputs = (empty($_REQUEST['filters_hidden_inputs']) ? "" : "&filters_hidden_inputs=".$_REQUEST['filters_hidden_inputs']);
				$currentUserId = (isset($_REQUEST['currentUserId']) ? "&currentUserId=".$_REQUEST['currentUserId'] : "&currentUserId=".$current_user->id);
				$contextDomain = (isset($contextDomainId) ? "&contextDomainId=".$contextDomainId : "");
				$returnHtmlParam = (isset($returnHtml) && $returnHtml ? "&returnHtml=true" : "");
				
				$isDashletQuery = (!empty($isDashlet) ? "&dashlet=true" : "");
				$isDashletQuery .= (!empty($dashletId) ? "&dashletId=".$dashletId : "");
				
				$focus = asol_Reports::getReportBean($reportId);
				
				//*************************************//
				//********Manage Report Domain*********//
				//*************************************//
				if (asol_CommonUtils::isDomainsInstalled()) {
					
					$reportDomain = ($contextDomainId !== null) ? $contextDomainId : $current_user->asol_default_domain;
					
					$currentReportDomain = (empty($reportId) ? $reportDomain : $focus->asol_domain_id);
					$manageReportDomain = asol_CommonUtils::manageElementDomain('asol_reports', $reportId, $reportDomain, $currentReportDomain);
					
					if (!$manageReportDomain) {
						
						$availableReport = false;
						if ($returnHtml) {
							return (include "modules/asol_Reports/include/DetailViewHttpSave.php");
						} else {
							include "modules/asol_Reports/include/DetailViewHttpSave.php";
							exit();
						}
						
					}
					
				}
				
				
				$rsHttp = asol_Reports::getSelectionResults("SELECT * FROM asol_reports WHERE id = '".$reportId."' LIMIT 1", null, false);
				
				//Guardamos el fichero en disco por si surge un export
				$httpHtmlFile = asol_ReportsGenerationFunctions::getReportExportedFileName($rsHttp[0]['name']).".html";
				
				$reportHtml = '';
				
				if (!$isMetaReport) {
					
					//Ver si hay charts para pasar los nombres
					$chartsUrls = array();
					$chartsInfo = array();
					
					
					$filtersArray = json_decode(rawurldecode($rsHttp[0]['report_filters']), true);
					
					//Check if there is some user_input fiter to show
					$hasUserInputsFilters = false;
					
					foreach ($filtersArray['data'] as $currentFilter){
						if ($currentFilter['behavior'] == 'user_input') {
							$hasUserInputsFilters = true;
							break;
						}
					}
					//Check if there is some user_inut fiter to show
					
					// Execute report with default filter values
					if ((isset($filtersArray['config']['initialExecution'])) && ($filtersArray['config']['initialExecution'])) {
						$hasSearchCriteria = true;
						$searchCriteria = "&search_criteria=1";
					}
					// Execute report with default filter values
					
					
					
					$selectedCharts = json_decode(rawurldecode($rsHttp[0]['report_charts_detail']), true);
					$chartsUrls = asol_ReportsGenerationFunctions::generateChartFileNames($focus->report_charts_engine, $selectedCharts);
					$chartsQueryUrls = (empty($chartsUrls)) ? "" : "&chartsHttpQueryUrls=".implode('${pipe}', $chartsUrls);
					
					
					$setUpInputCalendarsScript = asol_ReportsGenerationFunctions::getSetUpInputCalendarsScriptFunction($dashletId,$reportId, $filtersArray['data']);
					if (isset($setUpInputCalendarsScript)) {
						$reportHtml .= '<script type="text/javascript">'.$setUpInputCalendarsScript.'</script>';
					}
					
					
				}
				
				
				$waitForReport = false;
				$reportRequestId = "";
				
				$asolUrlQuery = $pageNumber.$sortingField.$overrideEntries.$overrideExport.$overrideInfo.$externalFilters.$staticFiltersP.$searchCriteria.$filtersHiddenInputs.$currentUserId.$contextDomain.$returnHtmlParam.$isDashletQuery;
				
				$baseRequestedUrl = (isset($sugar_config["asolReportsCurlRequestUrl"]) ? $sugar_config["asolReportsCurlRequestUrl"] : $sugar_config["site_url"]).'/index.php';
				$curlRequestedUrl = 'entryPoint=viewReport&module=asol_Reports&record='.$reportId.'&sourceCall=httpReportRequest'.$chartsQueryUrls.$asolUrlQuery.'&httpHtmlFile='.$httpHtmlFile.$reportRequestId;
				$curlRequestTimeout = (isset($sugar_config["asolReportsCurlRequestTimeout"]) ? $sugar_config["asolReportsCurlRequestUrl"] : 1);
				
				//REPORTS DISPATCHER
				$hasStaticFilters = (!empty($staticFilters));
				$manageDispatcher = (($dispatcherMaxRequests > 0) && ((!$hasUserInputsFilters) || (($hasUserInputsFilters) && (isset($_REQUEST['external_filters'])))) && (!$hasStaticFilters));
				if ($manageDispatcher) {
					
					$requestId = create_guid();
					$currentGMTTime = time();
					$currentGMTDate = date('Y-m-d H:i:s', $currentGMTTime);
					
					asol_ReportsUtils::reports_log('debug', 'Init GMDate(): '.$currentGMTDate, __FILE__, __METHOD__, __LINE__);
					
					$reportRequestId = "&reportRequestId=".$requestId;
					$initRequestTimeStamp = "&initRequestDateTimeStamp=".$currentGMTTime;
					
					$curlRequestedUrl .= $reportRequestId.$initRequestTimeStamp;
					
					
					asol_ReportsUtils::reports_log('debug', 'Reporting Queue Feature Enabled.', __FILE__, __METHOD__, __LINE__);
					
					
					$reportsDispatcherSql = "SELECT COUNT(DISTINCT id) as 'reportsThreads' FROM asol_reports_dispatcher WHERE status = 'executing'";
					$reportsDispatcherRs = $db->query($reportsDispatcherSql);
					$reportsDispatcherRow = $db->fetchByAssoc($reportsDispatcherRs);
					
					$currentReportsRunningThreads = $reportsDispatcherRow["reportsThreads"];
					
					$waitForReport = ($currentReportsRunningThreads >= $dispatcherMaxRequests);
					$dispatcherReportSql = "INSERT INTO asol_reports_dispatcher VALUES ('".$requestId."', '".$reportId."', '".$baseRequestedUrl.'?'.$curlRequestedUrl."', '".($waitForReport ? 'waiting' : 'executing')."', '".$currentGMTDate."', '".$currentGMTDate."', 'manual', '".$current_user->id."',  NULL)";
					$db->query($dispatcherReportSql);
					
				}
				//REPORTS DISPATCHER
				
				if (!$shortTermExecution && !$waitForReport) { //Execute report if not is waiting in queue
					
					$systemCurlUsage = (isset($sugar_config["asolReportsSystemCurlUsage"]) && $sugar_config["asolReportsSystemCurlUsage"]);
					if ($systemCurlUsage) {
						
						$shellCommand = "curl --data '".$curlRequestedUrl."' ".$baseRequestedUrl." > /dev/null 2>&1 &";
						shell_exec($shellCommand);
						
					} else {
						
						session_write_close();
						
						$ch = curl_init();
						
						curl_setopt($ch, CURLOPT_URL, $baseRequestedUrl.'?'.$curlRequestedUrl);
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_TIMEOUT_MS, $curlRequestTimeout);
						curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
						curl_setopt($ch, CURLOPT_COOKIE, 'PHPSESSID='.$_COOKIE['PHPSESSID'].'; path=/');
						
						curl_exec($ch);
						curl_close($ch);
						
					}
					
				}
				
				$checkHttpFileTimeout = (isset($sugar_config["asolReportsCheckHttpFileTimeout"])) ? $sugar_config["asolReportsCheckHttpFileTimeout"] : "1000";
				
				$reportHtml .= '<span class="loadingContainer">
						<i class="loadingGIF icn-loading"></i>
						<span class="loadingTEXT">'.translate('LBL_REPORT_LOADING_DATA', 'asol_Reports').'</span>
					</span>';
				
				$reportHtml .= '<script type="text/javascript">';
				
				$reportHtml .= asol_ReportsGenerationFunctions::getSendAjaxRequestScriptFunction($reportId, $dashletId, $checkHttpFileTimeout, $httpHtmlFile, $reportRequestId, $initRequestTimeStamp, $hasCalendarInputs);
				$reportHtml .= asol_ReportsGenerationFunctions::getInitialAjaxRequest2GenerateReportScript($reportId, $shortTermExecution);
				
				if ($getReloadFunctions) {
					$reportHtml .= asol_ReportsGenerationFunctions::getLoadCurrentDashletScriptFunction($reportId, $isDashlet, $dashletId, $getLibraries, $staticFilters, $override_entries, $current_user->id);
				}
				
				$reportHtml .= '</script>';
				
				if (!$isDashlet) {
					$reportHtml .= asol_ReportsGenerationFunctions::getStandByReportHtml('', $waitForReport);
				}
				
				if ($returnHtml) {
					return $reportHtml;
				} else {
					echo $reportHtml;
				}
				
			}
			
		}
		
	}
	
	static public function deleteReport($record) {

		global $db;

		if (is_array($record)) {
			$db->query("UPDATE asol_reports SET deleted=1 WHERE id IN('".implode("','", $record)."')");
		} else {
			$db->query("UPDATE asol_reports SET deleted=1 WHERE id='".$record."' LIMIT 1");
		}
		
		//***********************//
		//***AlineaSol Premium***//
		//***********************//
		asol_ReportsUtils::managePremiumFeature("draftModeManagement", "reportFunctions.php", "deleteDraftReports", array('record' => $record));
		//***********************//
		//***AlineaSol Premium***//
		//***********************//

	}

	static public function getReportDetailTitle($name, $isDashlet, $fields = false) {
	
		global $mod_strings;
		
		$currentFields = json_decode(rawurldecode($fields), true);
		$title = $currentFields['tables'][0]['title'];
		
		$result = '';
		
		if ($_REQUEST['module'] == 'asol_Reports' && !$isDashlet) {
			$result = $mod_strings['LBL_REPORT_RUN'].': ';
		}
		
		if ($isDashlet && empty($title['text'])) {
			
			return '';
	
		} else {
	
			//***********************//
			//***AlineaSol Premium***//
			//***********************//
			if (isset($title) && !empty($title['text'])) {
				$extraParams = array('label' => $title);
				$returnedMultiLanguage = asol_CommonUtils::managePremiumFeature("multiLanguageSupport", "commonFunctions.php", "getMultiLanguageLabel", $extraParams);
				$result .= ($returnedMultiLanguage !== false ? $returnedMultiLanguage : $title['text']);
			} else {
				$result .= $name;
			}
			//***********************//
			//***AlineaSol Premium***//
			//***********************//
			
			return '<div class="moduleTitle">
						<h2>'.$result.'</h2>
				    </div>
					<div class="clear"></div>';
			
		}
	
	}
	
	static public function getReportPublicDescription($description, $isDashlet){
	
		global $mod_strings;
		
		$description = unserialize(base64_decode($description));
		
		if ((!empty($description['public'])) && (!$isDashlet)) {
			
			return '
			<div id="reportInfoDivWrapper" class="detail view">
				'.self::getHeaderInfo($isDashlet, $mod_strings['LBL_REPORT_DESCRIPTION'], null, ($getExportData ? null : "reportInfoDiv")).'
				<div id="reportInfoDiv">
					<table id="resultTable">
						<tbody>
							<tr>
								<td>'.nl2br($description['public']).'</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>';
	
		}
	
	}
	
	static private function getHeaderInfo($isDashlet,$headerMessage, $headerInfo = null, $collapsibleHeaderId = null){
	
		$headerHtml='';
	
		if (isset($headerMessage)) {
	
			$headerHtml = (!$isDashlet) ? '<h4>' : '';
			$headerHtml .= ($collapsibleHeaderId !== null) ? self::getCollapseImg($collapsibleHeaderId) : '';
			$headerHtml .= ($reportHeaderInfo !== null) ? '<em>'.$headerMessage.'</em>'.' : '.$headerInfo : '<em>'.$headerMessage.'</em>';
			$headerHtml .= (!$isDashlet) ? '</h4>' : '';
	
		}
	
		return $headerHtml;
	
	}
	
	static private function getCollapseImg($containerId) {
	
		return '<img onclick="if( $(&quot;#'.$containerId.'&quot;).is(&quot;:visible&quot;) ) { $(&quot;#'.$containerId.'&quot;).hide(); $(&quot;#'.$containerId.'_collapseImg&quot;).attr(&quot;src&quot;, &quot;themes/default/images/advanced_search.gif&quot;) } else { $(&quot;#'.$containerId.'&quot;).show(); $(&quot;#'.$containerId.'_collapseImg&quot;).attr(&quot;src&quot;, &quot;themes/default/images/basic_search.gif&quot;) } " onmouseout="this.style.cursor=&quot;default&quot;" onmouseover="this.style.cursor=&quot;pointer&quot;" src="themes/default/images/basic_search.gif" id="'.$containerId.'_collapseImg" style="cursor: default;">&nbsp';
	
	}
	
	static public function getReportDetailButtons($bean, $isDashlet, $dashletId, $isMetaReport, $isFilterVisible, $sendEmailquestion, $filtersHiddenInputs, $searchCriteria, $staticFilters, $externalCall, $getLibraries, $overrideEntries, $overrideInfo, $scheduledEmailHideButtons, $displayNoDataMsg, $isWsExecution, $isPreview) {
	
		global $current_user, $sugar_config, $db, $mod_strings;
	
		
		//***********************//
		//***AlineaSol Premium***//
		//***********************//
		$scheduledTypeInfoArray = explode(':', $bean->report_scheduled_type);
		$scheduledTypeInfo = json_decode(urldecode($scheduledTypeInfoArray[1]), true);
		
		$hasExternalApp = (!empty($scheduledTypeInfo) && (isset($scheduledTypeInfo['application'])));
		$hasExternalFtp = (!empty($scheduledTypeInfo) && (isset($scheduledTypeInfo['ftp'])));
		$hasExternalTl = (!empty($scheduledTypeInfo) && (isset($scheduledTypeInfo['tl'])));
		
		$readOnlyMode = asol_ReportsUtils::managePremiumFeature("reportReadOnlyMode", "reportFunctions.php", "getReadOnlyModeFlag", null);
		//***********************//
		//***AlineaSol Premium***//
		//***********************//
		
		$attachmentFormatArray = explode(':', $bean->report_attachment_format);
		$attachmentFormat = strtolower($attachmentFormatArray[0]);
		
		$dashletExportButtons = (isset($sugar_config['asolReportsDashletExportButtons']) ? $sugar_config['asolReportsDashletExportButtons'] : true);
		
		$hasStaticFilters = (!empty($staticFilters));
		
		
		$returnedHTML = '';
		
		$allowedButtons = (($_REQUEST['module'] === 'asol_Reports') && !$isDashlet);
		
		if ($allowedButtons) {
		
			if ((!$externalCall) && (!$filtersHiddenInputs) && (!$isPreview)) {
				$returnedHTML .= '<input type="button" class="button reloadButton" onclick="controllerReportDetail.reloadReport(this, \''.$bean->id.'\', true, {\'dashlet\':'.($isDashlet ? 'true' : 'false').', \'dashletId\':\''.$dashletId.'\', \'currentUserId\':\''.$current_user->id.'\'});" value="'.$mod_strings['LBL_REPORT_REFRESH'].'"> ';
			}
			
			$domainReportModifiable = (asol_CommonUtils::isDomainsInstalled() ? asol_CommonUtils::domainCanModifyElement($bean->asol_domain_id) : true);
			$userReportModifiable = asol_CommonUtils::userCanModifyElement($bean->created_by, $bean->assigned_user_id);
	
			if (($userReportModifiable) && ($domainReportModifiable) && (ACLController::checkAccess('asol_Reports', 'edit', true))) {
				$returnedHTML .= '<input type="button" class="button editButton" onclick="controllerReportDetail.editReport();" value="'.$mod_strings['LBL_REPORT_EDIT'].'"> ';
			}
	
			$returnedHTML .= '<input type="button" class="button cancelButton" onclick="controllerReportDetail.cancelReport(\''.($isDashlet ? $dashletId : '').'\');" value="'.$mod_strings['LBL_REPORT_CANCEL'].'">';

		}
		
		if (!$isMetaReport) {
		
			if ($filtersHiddenInputs && (!$externalCall) && (!isset($scheduledEmailHideButtons))) {
		
				$returnedHTML .= '<button class="button executeReportBtn" style="display: '.($isFilterVisible ? 'inline' : 'none').'" onClick="controllerReportDetail.reloadReport(this, \''.$reportId.'\', false, {\'dashlet\':'.($isDashlet ? 'true' : 'false').', \'dashletId\':\''.$dashletId.'\', \'currentUserId\':\''.$current_user->id.'\', \'page_number\':\'0\', \'sort_field\':\'\', \'sort_direction\':\'\', \'sort_index\':\'\', \'getLibraries\':\''.($isDashlet && $getLibraries ? 'true' : 'false').'\', \'overrideEntries\':'.(!empty($overrideEntries) ? '\''.$overrideEntries.'\'' : 'null').', \'overrideInfo\':'.(!empty($overrideInfo) ? '\''.urlencode(json_encode($overrideInfo)).'\'' : 'null').', \'overrideConfig\':'.(!empty($override_config) ? '\''.urlencode(json_encode($override_config)).'\'' : 'null').', \'staticFilters\':'.(!empty($staticFilters) ? '\''.$staticFilters.'\'' : 'null').'});">'.asol_ReportsUtils::translateReportsLabel('LBL_REPORT_RUN').'</button> ';
				$returnedHTML .= '<button class="button clearReportBtn" style="display: '.($isFilterVisible ? 'inline' : 'none').'" onClick="clearUserInputs(this, '.($isDashlet ? 'true' : 'false').');">'.asol_ReportsUtils::translateReportsLabel('LBL_REPORT_CLEAR').'</button> ';
		
				$returnedHTML .= '<script type="text/javascript">
					'.self::getAttachedScript2ExecuteCriteriaOnKeyPressed($dashletId).'
					asolFancyMultiEnum.generate($(".asolFirstParameter select"), 3, true);
					asolFancyMultiEnum.generate($(".asolSecondParameter select"), 3, true);
					asolFancyMultiEnum.generate($(".asolThirdParameter select"), 3, true);
				</script>';
		
			}
		
		}
		
		if (($isDashlet && (!$hasStaticFilters || $isWsExecution) && $dashletExportButtons) || (!$isDashlet && !$externalCall && !$isPreview)) {
		
			$domainReportModifiable = (asol_CommonUtils::isDomainsInstalled()) ? asol_CommonUtils::domainCanModifyElement($bean->asol_domain_id) : true;
			$userReportModifiable = asol_CommonUtils::userCanModifyElement($bean->created_by, $bean->assigned_user_id);
			$roleReportModifiable = asol_ReportsUtils::roleCanModifyReport($bean->report_scope);
				
		
			if ((!$isDashlet) && (!$isWsExecution) && (($roleReportModifiable) || ($userReportModifiable)) && ($domainReportModifiable) && (ACLController::checkAccess('asol_Reports', 'edit', true) && !$readOnlyMode) && (!isset($scheduledEmailHideButtons))) {
				$returnedHTML .= '<button id="reportbutton_edit" title="'.asol_ReportsUtils::translateReportsLabel('LBL_REPORT_EDIT').'" class="button" onClick="controllerReportDetail.editReport(\''.$reportId.'\', false);">'.asol_ReportsUtils::translateReportsLabel('LBL_REPORT_EDIT').'</button> '.
				'<button id="reportbutton_cancel" title="'.asol_ReportsUtils::translateReportsLabel('LBL_REPORT_CANCEL').'" class="button" onClick="controllerReportDetail.cancelReport(\''.$reportId.'\')">'.asol_ReportsUtils::translateReportsLabel('LBL_REPORT_CANCEL').'</button> ';
			}
				
		
			if ((($filtersHiddenInputs == false) || ($searchCriteria == true)) && (!$displayNoDataMsg)) {
					
				if (!$isDashlet) {
					$returnedHTML .= '<button id="reportbutton_export" title="'.asol_ReportsUtils::translateReportsLabel('LBL_REPORT_EXPORT_ONE').'" class="button" onmouseover="openExportReportDialog(this, \''.$dashletId.'\');" onmouseout="clearTimeout(window[\'exportButtonTimeout\']); $(\'#asolReportExportDiv'.$dashletId.'\').hide();">'.asol_ReportsUtils::translateReportsLabel('LBL_REPORT_EXPORT_ONE').'<div class="asolReportsListArrowDown"></div></button> ';
				}
		
				$returnedHTML .= '<ul class="asolReportExportDiv" id="asolReportExportDiv'.$dashletId.'" style="display: none; z-index: 1001;" onmouseover="$(this).show();" onmouseout="$(this).hide();">';
		
				$returnedHTML .= '<li><a href="javascript:void(0)" id="reportbutton_html" onclick="generateExportedFile(\'html\', null, \''.$reportId.'\', '.($isDashlet ? 'true' : 'false').', \''.$dashletId.'\');">'.asol_ReportsUtils::translateReportsLabel('LBL_REPORT_HTML').'</a></li>';
		
				if (!$isMetaReport) {
		
					$returnedHTML .= '<li><a href="javascript:void(0)" id="reportbutton_pdf" onclick="generateExportedFile(\'pdf\', null, \''.$reportId.'\', '.($isDashlet ? 'true' : 'false').', \''.$dashletId.'\');">'.asol_ReportsUtils::translateReportsLabel('LBL_REPORT_PDF').'</a></li>';
		
					$returnedHTML .= '<li><a href="javascript:void(0)" id="reportbutton_csv" onclick="generateExportedFile(\'csv\', null, \''.$reportId.'\', '.($isDashlet ? 'true' : 'false').', \''.$dashletId.'\');">'.asol_ReportsUtils::translateReportsLabel('LBL_REPORT_CSV').'</a></li>';
					$returnedHTML .= '<li><a href="javascript:void(0)" id="reportbutton_csvc" onclick="generateExportedFile(\'csvc\', null, \''.$reportId.'\', '.($isDashlet ? 'true' : 'false').', \''.$dashletId.'\');">'.asol_ReportsUtils::translateReportsLabel('LBL_REPORT_CSV_CLEAN').'</a></li>';
		
					$returnedHTML .= '<li><a href="javascript:void(0)" id="reportbutton_xls" onclick="generateExportedFile(\'xls\', null, \''.$reportId.'\', '.($isDashlet ? 'true' : 'false').', \''.$dashletId.'\');">'.asol_ReportsUtils::translateReportsLabel('LBL_REPORT_XLS').'</a></li>';
					$returnedHTML .= '<li><a href="javascript:void(0)" id="reportbutton_xlsc" onclick="generateExportedFile(\'xlsc\', null, \''.$reportId.'\', '.($isDashlet ? 'true' : 'false').', \''.$dashletId.'\');">'.asol_ReportsUtils::translateReportsLabel('LBL_REPORT_XLS_CLEAN').'</a></li>';
						
				}
		
				$returnedHTML .= '</ul>';
		
		
				if ((!$isDashlet) && (!$isWsExecution) && (ACLController::checkAccess('asol_Reports', 'edit', true) && !$readOnlyMode)) {
		
					$returnedHTML .= '<button id="reportbutton_email" title="'.asol_ReportsUtils::translateReportsLabel('LBL_REPORT_SEND_EMAIL').'" class="button" onclick="if (confirm(\''.$sendEmailquestion.'\')){ generateExportedFile(\'email\', \''.$attachmentFormat.'\', \''.$reportId.'\', '.($isDashlet ? 'true' : 'false').', \''.$dashletId.'\'); }">'.asol_ReportsUtils::translateReportsLabel('LBL_REPORT_SEND_EMAIL').'</button> ';
						
					if (isset($sugar_config['asolReportsExternalApplicationFixedParams']) && $hasExternalApp && !$isMetaReport) {
						//***********************//
						//***AlineaSol Premium***//
						//***********************//
						$extraParams = array(
							'reportId' => $reportId,
							'isDashlet' => $isDashlet,
							'dashletId' => $dashletId,
						);
						$sendAppButtonHtml = asol_ReportsUtils::managePremiumFeature("externalApplicationsFTP", "reportFunctions.php", "getSendAppButtonHtml", $extraParams);
						$returnedHTML .= ($sendAppButtonHtml !== false ? $sendAppButtonHtml : '');
						//***********************//
						//***AlineaSol Premium***//
						//***********************//
					}
						
					if ($hasExternalFtp && !$isMetaReport) {
						//***********************//
						//***AlineaSol Premium***//
						//***********************//
						$extraParams = array(
							'reportId' => $reportId,
							'attachmentFormat' => $attachmentFormat,
							'isDashlet' => $isDashlet,
							'dashletId' => $dashletId,
						);
						$sendFtpButtonHtml = asol_ReportsUtils::managePremiumFeature("externalApplicationsFTP", "reportFunctions.php", "getSendFtpButtonHtml", $extraParams);
						$returnedHTML .= ($sendFtpButtonHtml !== false ? $sendFtpButtonHtml : '');
						//***********************//
						//***AlineaSol Premium***//
						//***********************//
					}
						
					if ($hasExternalTl && !$isMetaReport) {
						//***********************//
						//***AlineaSol Premium***//
						//***********************//
						$extraParams = array(
							'reportId' => $reportId,
							'isDashlet' => $isDashlet,
							'dashletId' => $dashletId,
						);
						$sendTlButtonHtml = asol_ReportsUtils::managePremiumFeature("externalApplicationsTL", "reportFunctions.php", "getSendTlButtonHtml", $extraParams);
						$returnedHTML .= ($sendTlButtonHtml !== false ? $sendTlButtonHtml : '');
						//***********************//
						//***AlineaSol Premium***//
						//***********************//
					}
						
				}
		
			}
		
		}
		
		return '<div class="actionsContainer">'.$returnedHTML.'</div>';
	
	}
	
	static public function generateExecutedReport($reportId, $isDashlet, $dashletId, $reportDomain = null) {
		
		require_once('modules/asol_Reports/include/generateReportsFunctions.php');
		require_once('modules/asol_Reports/include/server/controllers/controllerReports.php');
		require_once('modules/asol_Reports/include/server/reportsUtils.php');
		
		$sortField = (isset($_REQUEST['sort_field']) ? $_REQUEST['sort_field'] : "");
		$sortDirection = (isset($_REQUEST['sort_direction']) ? $_REQUEST['sort_direction'] : "");
		$sortIndex = (isset($_REQUEST['sort_index']) ? $_REQUEST['sort_index'] : "");
		$pageNumber = (isset($_REQUEST['page_number']) ? $_REQUEST['page_number'] : "");
		$getLibraries = ((isset($_REQUEST['getLibraries'])) && ($_REQUEST['getLibraries'] == 'false') ? false : true);
		$overrideEntries = (isset($_REQUEST['overrideEntries']) ? $_REQUEST['overrideEntries'] : null);
		$overrideInfo = (isset($_REQUEST['overrideInfo']) ? json_decode(html_entity_decode(urldecode($_REQUEST['overrideInfo'])), true) : null);
		$overrideFilters = (isset($_REQUEST['overrideFilters']) ? json_decode(html_entity_decode(urldecode($_REQUEST['overrideFilters'])), true) : null);
		$avoidAjaxRequest = ((isset($_REQUEST['avoidAjaxRequest'])) && ($_REQUEST['avoidAjaxRequest'] == 'true') ? true : false);
		$contextDomainId = (isset($_REQUEST['contextDomainId']) ? $_REQUEST['contextDomainId'] : $reportDomain);
		
		$multiExecution = ((isset($_REQUEST['multiExecution'])) && ($_REQUEST['multiExecution'] == 'true') ? true : false);
		
		//***********************//
		//***AlineaSol Premium***//
		//***********************//
		$extraParams = array(
			'staticFilters' => (isset($_REQUEST['staticFilters']) && !empty($_REQUEST['staticFilters']) ? $_REQUEST['staticFilters'] : null)
		);
		$staticFilterParam = asol_ReportsUtils::managePremiumFeature("reportFieldsManagement", "reportFunctions.php", "getStaticFilterParam", $extraParams);
		$staticFilters = ($staticFilterParam !== false ? $staticFilterParam : null);
		//***********************//
		//***AlineaSol Premium***//
		//***********************//
		
		$executedReportHtml = self::displayReport($reportId, $staticFilters, $sortField, $sortDirection, $sortIndex, $pageNumber, $isDashlet, $dashletId, $getLibraries, true, true, false, $overrideEntries, $overrideInfo, $overrideFilters, $avoidAjaxRequest, $contextDomainId);
		
		if ($multiExecution) {
				
			//***********************//
			//***AlineaSol Premium***//
			//***********************//
			$extraParams = array(
				'mainExecutedReport' => $executedReportHtml,
				'staticFilters' => $staticFilters,
				'isDashlet' => $isDashlet,
				'getLibraries' => $getLibraries,
				'overrideEntries' => $overrideEntries,
				'avoidAjaxRequest' => $avoidAjaxRequest,
				'contextDomainId' => $contextDomainId,
			);
			return asol_ReportsUtils::managePremiumFeature("metaReport", "reportFunctions.php", "executeMultiReport", $extraParams);
			//***********************//
			//***AlineaSol Premium***//
			//***********************//
				
		} else if (is_array($executedReportHtml)) {
			$executedReportHtml = $executedReportHtml[0];
		}
		
		return $executedReportHtml;
		
	}
	
	static public function previewFocus(& $focus) {
		
		$previewData = json_decode(urldecode($_REQUEST['actionContext']['preview']), true);
		
		$focus->name = $previewData['name'];
		$focus->description = json_decode(urldecode(html_entity_decode($previewData['description'])), true);
		
		$focus->is_meta = $previewData['isMeta'];
		$focus->data_source = $previewData['data_source'];
		
		$focus->dynamic_tables = $previewData['dynamicTables'];
		$focus->dynamic_sql = urldecode(html_entity_decode($previewData['dynamicSql']));
		
		$focus->report_charts = $previewData['display'];
		$focus->report_charts_engine = $previewData['chartsEngine'];
		$focus->row_index_display = $previewData['indexDisplay'];
		$focus->results_limit = urldecode(html_entity_decode($previewData['resultsLimit']));
		
		$focus->report_fields = json_decode(urldecode(html_entity_decode($previewData['fields'])), true);
		$focus->report_filters = json_decode(urldecode(html_entity_decode($previewData['filters'])), true);
		asol_ReportsGenerationFunctions::convertDateFiltersToDatabaseFormat($focus->report_filters);
		$focus->report_charts_detail = json_decode(rawurldecode(html_entity_decode($previewData['charts'])), true);
		
	}
	
	static private function getCurrentUserAvailableModules($alternativeDb) {
	
		global $sugar_config, $current_user;
	
		$dbKey = ($alternativeDb === false ? 'crm' : 'ext'.$alternativeDb);
	
		if (!isset($_SESSION['currentUserAvailableModules'][$dbKey])) {
	
			$acl_modules = ACLAction::getUserActions($current_user->id);
			$currentUserAvailableModules = array();
	
			foreach ($acl_modules as $key=>$mod) {
					
				if ($mod['module']['access']['aclaccess'] >= 0) {
						
					if ((isset($sugar_config['asolModulesPermissions']['asolAllowedTables'])) || (isset($sugar_config['asolModulesPermissions']['asolForbiddenTables']))) {
						//Restrictive
							
						if ( (isset($sugar_config['asolModulesPermissions']['asolForbiddenTables']['domains'][$current_user->asol_default_domain])) &&
								(in_array($key, $sugar_config['asolModulesPermissions']['asolForbiddenTables']['domains'][$current_user->asol_default_domain])) ) {
										
									$currentUserAvailableModules[$key] = false;
										
								} else if ( (isset($sugar_config['asolModulesPermissions']['asolForbiddenTables']['instance'])) &&
										(in_array($key, $sugar_config['asolModulesPermissions']['asolForbiddenTables']['instance']))) {
												
											$currentUserAvailableModules[$key] = false;
												
										}
	
										if ( (isset($sugar_config['asolModulesPermissions']['asolAllowedTables']['domains'][$current_user->asol_default_domain])) &&
												(in_array($key, $sugar_config['asolModulesPermissions']['asolAllowedTables']['domains'][$current_user->asol_default_domain])) ) {
														
													if (!isset($currentUserAvailableModules[$key]))
														$currentUserAvailableModules[$key] = true;
	
												} else if ( (isset($sugar_config['asolModulesPermissions']['asolAllowedTables']['instance'])) &&
														(in_array($key, $sugar_config['asolModulesPermissions']['asolAllowedTables']['instance'])) ) {
																
															if (!isset($currentUserAvailableModules[$key]))
																$currentUserAvailableModules[$key] = true;
	
														}
															
					} else {
							
						$currentUserAvailableModules[$key] = true;
	
					}
						
				}
					
			}
				
			$_SESSION['currentUserAvailableModules'][$dbKey] = $currentUserAvailableModules;
	
		} else {
				
			$currentUserAvailableModules = $_SESSION['currentUserAvailableModules'][$dbKey];
				
		}
	
		return $currentUserAvailableModules;
	
	}
	
	static public function exportReport($record) {
		
		require_once("modules/asol_Common/include/commonUtils.php");
		require_once("modules/asol_Reports/include/server/reportsUtils.php");
		
		$getContent = ($_REQUEST['getContent'] === 'true' ? true : false);
		
		if ($getContent) {
			
			$notExportingFields = array('id', 'modified_user_id', 'created_by', 'assigned_user_id', 'deleted', 'last_run', 'report_scope',	'asol_domain_id', 'asol_domain_published_mode', 'asol_domain_child_share_depth', 'asol_multi_create_domain', 'asol_published_domain');
			$exportedReports = asol_CommonUtils::manageExportElements('asol_reports', $record, asol_ReportsUtils::$reports_version, $notExportingFields);
		
			foreach ($exportedReports as & $exportedReport) {
					
				if ($exportedReport['is_meta'] == '1') {
						
					//***********************//
					//***AlineaSol Premium***//
					//***********************//
					$extraParams = array(
						'metaHtml' => $exportedReport['meta_html'],
						'notExportingFields' => $notExportingFields,
					);
					$exportedMetaReportResult = asol_ReportsUtils::managePremiumFeature("metaReport", "reportFunctions.php", "getExportedMetaReport", $extraParams);
					if ($exportedMetaReportResult !== false) {
						$exportedReport['meta_html'] = $exportedMetaReportResult['metaHtml'];
						$exportedReport['linkedMetaReports'] = $exportedMetaReportResult['linkedMetaReports'];
					}
					//***********************//
					//***AlineaSol Premium***//
					//***********************//
						
				}
					
			}
				
			$exportName = (count($record) > 1 ? "ASOL Report"."_".date("Ymd")."T".date("Hi") : $exportedReports[0]['name']);
			$exportedFile = $exportedReports;
			
			header("Content-Type: text/plain");
			header("Content-Disposition: attachment; filename=\"".$exportName.".txt\"");
			header("Content-Description: File Transfer");
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: ".mb_strlen(serialize($exportedFile), "8bit")."\"");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Pragma: public");
				
			ob_clean();
			flush();
		
			return serialize($exportedFile);
		
		}
		
	}
	
	static public function importReport() {
		
		require_once("modules/asol_Reports/include/manageReportsFunctions.php");
		require_once("modules/asol_Reports/include/migrationReportsFunctions.php");
		
		$currentDir = getcwd()."/";
		$tmpFilesDir = "modules/asol_Reports/tmpReportFiles/";
		
		$size = $_FILES['importedReports']['size'];
		$type = $_FILES['importedReports']['type'];
		$name = $_FILES['importedReports']['name'];
		$tmpName = $_FILES['importedReports']['tmp_name'];
		
		if (!empty($name)) {
		
			$target =  $currentDir.$tmpFilesDir.time()."_".$name;
			copy($_FILES['importedReports']['tmp_name'], $target);
			$descriptor = fopen($target, "r");
		
			$serializedReport = fread($descriptor, filesize($target));
			$reports = unserialize($serializedReport);
		
			fclose($descriptor);
			unlink($target);
		
			$focus = BeanFactory::newBean('asol_Reports');
			
			foreach ($reports as $currentReport) {
		
				if ($currentReport['is_meta'] == '1') {
		
					//***********************//
					//***AlineaSol Premium***//
					//***********************//
					$extraParams = array(
						'metaReportRow' => $currentReport,
						'focus' => $focus
					);
					$importedMetaReport = asol_ReportsUtils::managePremiumFeature("metaReport", "reportFunctions.php", "saveImportedMetaReports", $extraParams);
					if ($importedMetaReport !== false) {
						$currentReport = $importedMetaReport;
					}
					//***********************//
					//***AlineaSol Premium***//
					//***********************//
		
				}
		
				asol_ReportsManagementFunctions::manageImportReportValues($focus, $currentReport);
		
			}
		
		}
		
	}
	
	static public function checkReport() {

		global $db, $sugar_config, $current_language;
		
		require_once("modules/asol_Reports/include/server/reportsUtils.php");
		
		$tmpFilesDir = "modules/asol_Reports/tmpReportFiles/";
		$httpHtmlFile = $_REQUEST['httpHtmlFile'];
		
		if (!file_exists($tmpFilesDir.$httpHtmlFile)) {
		
			$returnedString = "false";
		
			if ((isset($sugar_config['asolReportsDispatcherMaxRequests'])) && ($sugar_config['asolReportsDispatcherMaxRequests'] > 0) && (isset($_REQUEST["reportRequestId"]))) { //Only if dispatcher is activated
		
				//************************************************//
				//***Clean database report_dispatcher if exists***//
				//************************************************//
				if (asol_ReportsUtils::dispatcherTableExists()) {
						
					$currentTime = time();
						
					$checkHttpFileTimeout = (isset($sugar_config["asolReportsCheckHttpFileTimeout"])) ? $sugar_config["asolReportsCheckHttpFileTimeout"] : "1000";
					$timedOutStamp = $currentTime - $checkHttpFileTimeout; //Time to check report execution expiration time
					$closedWindowStamp = $currentTime - ($checkHttpFileTimeout / 500);  //Time to check last recall not updated for manual Reports (browser screen closed).
						
					$cleanDispatcherTableSql = "DELETE FROM asol_reports_dispatcher WHERE (status IN ('terminated', 'timeout')) OR (request_init_date < '".date("Y-m-d H:i:s", $timedOutStamp)."') OR ((status = 'waiting') AND (request_type = 'manual') AND (last_recall < '".date("Y-m-d H:i:s", $closedWindowStamp)."'))";
					$db->query($cleanDispatcherTableSql);
						
				}
				//************************************************//
				//***Clean database report_dispatcher if exists***//
				//************************************************//
		
		
				$reportsDispatcherSql = "SELECT COUNT(DISTINCT id) as 'reportsThreads' FROM asol_reports_dispatcher WHERE status = 'executing'";
				$reportsDispatcherRs = $db->query($reportsDispatcherSql);
				$reportsDispatcherRow = $db->fetchByAssoc($reportsDispatcherRs);
		
				$currentReportsRunningThreads = $reportsDispatcherRow["reportsThreads"];

				if ($currentReportsRunningThreads < $sugar_config['asolReportsDispatcherMaxRequests']) { //Execute Report
		
					$sqlExecuting = "SELECT * FROM asol_reports_dispatcher WHERE id='".$_REQUEST["reportRequestId"]."' LIMIT 1";
					$rsExecuting = $db->query($sqlExecuting);
					$rowExecuting = $db->fetchByAssoc($rsExecuting);
						
					if ($rowExecuting["status"] == "waiting") {
		
						//Check if Report is ready to Run (order by time ascending)
						$availableReportThreads = $sugar_config['asolReportsDispatcherMaxRequests'] - $currentReportsRunningThreads;
		
						$sqlWaitingReports = "SELECT id FROM asol_reports_dispatcher WHERE status = 'waiting' ORDER BY request_init_date ASC LIMIT ".$availableReportThreads;
						$rsWaitingReports = $db->query($sqlWaitingReports);
		
						$firtReports = array();
		
						while($row = $db->fetchByAssoc($rsWaitingReports))
							$firtReports[] = $row['id'];
						//Check if Report is ready to Run (order by time ascending)
		
						if (in_array($_REQUEST["reportRequestId"], $firtReports)) {
								
							//********//
							//**Curl**//
							//********//
							$ch = curl_init();
								
							$curlRequestedUrl = $rowExecuting["curl_requested_url"];
		
							curl_setopt($ch, CURLOPT_URL, $curlRequestedUrl);
							curl_setopt($ch, CURLOPT_HEADER, 0);
							curl_setopt($ch, CURLOPT_TIMEOUT, 1);
							curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
								
							curl_exec($ch);
							curl_close($ch);
							//********//
							//**Curl**//
							//********//
		
							$sqlExecutingStatus = "UPDATE asol_reports_dispatcher SET status = 'executing' WHERE id='".$_REQUEST["reportRequestId"]."' AND status = 'waiting' LIMIT 1";
							$db->query($sqlExecutingStatus);
							$returnedString = "exec";
								
						}
		
					}
		
				}
		
		
				$recallGMTTime = time();
				$recallGMTDate = date('Y-m-d H:i:s', $recallGMTTime);
		
				$initGMTDateTimeStamp = $_REQUEST["initRequestDateTimeStamp"];
				$recallGMTDateTimeStamp = $recallGMTDate;
		
		
				//Check Max Report Execution time
				$runningTimeSeconds = $recallGMTDateTimeStamp - $initGMTDateTimeStamp;
				asol_ReportsUtils::reports_log('debug', 'Running Time: '.$runningTimeSeconds, __FILE__, __METHOD__, __LINE__);
		
				if ((isset($sugar_config['asolReportsMaxExecutionTime'])) && ($sugar_config['asolReportsMaxExecutionTime'] > 0)) {
						
					if ($runningTimeSeconds > $sugar_config['asolReportsMaxExecutionTime']) {
		
						$returnedString = "timeout";
		
					}
						
				}
		
				$sqlLastRecall = "UPDATE asol_reports_dispatcher SET last_recall='".$recallGMTDate."' WHERE id='".$_REQUEST["reportRequestId"]."' LIMIT 1";
				$db->query($sqlLastRecall);
					
			}
		
			return $returnedString;
		
		} else {
		
			$importHttpFile = fopen($tmpFilesDir.$httpHtmlFile, "r");
			$HttpContent = fread($importHttpFile, filesize($tmpFilesDir.$httpHtmlFile));
			fclose($importHttpFile);
		
			return $HttpContent;
		
		}
		
		
	}
	
	static public function saveReport($data) {
		
		global $timedate, $current_user;
		
		require_once("modules/asol_Reports/include/manageReportsFunctions.php");
		require_once('modules/asol_Reports/include/generateReportsFunctions.php');
				
		$data = json_decode(html_entity_decode($data), true);
		
		$bean = BeanFactory::getBean("asol_Reports", $data['record']);
				
		$isNewReport = (empty($bean->id));
		
		if ($isNewReport) {
			if (!empty($data['record'])) {
				$bean->new_with_id = true;
				$bean->id = $data['record'];
			}
			$bean->assigned_user_id = $current_user->id;
			$bean->parent_id = (!empty($data['parent_id']) ? $data['parent_id'] : create_guid());
		}
		
		$bean->name = rawurldecode($data['name']);
		
		if (!empty($data['report_type']['data'])) {
			
			if (asol_CommonUtils::isDomainsInstalled()) {
				require_once("modules/asol_Domains/AlineaSolDomainsFunctions.php");
				$domainIdsToDelete = asol_manageDomains::getDomainPublicationDiff('asol_reports', $bean->id, false);
			}
			
			$domainIdsToDelete = ($data['report_type']['type'] !== 'stored' ? null : $domainIdsToDelete);
			$cleanUpData = asol_ReportsManagementFunctions::cleanUpStoredReportFiles($data['report_type']['data'], $domainIdsToDelete);
			if (isset($cleanUpData)) {
				$data['report_type']['data'] = $cleanUpData;
			} else {
				unset ($data['report_type']['data']);
			}
			
		}
		
		if (!isset($data['report_type']['draft']) || empty($data['report_type']['draft'])) {
			unset($data['report_type']['draft']);
		}
		$bean->report_type = rawurlencode(json_encode($data['report_type']));
		$bean->report_scheduled_type = $data['report_scheduled_type'];
		$bean->report_attachment_format = (isset($data['report_attachment_format']) ? $data['report_attachment_format'] : $bean->report_attachment_format).(!empty($data['report_format_file_config']) ? ':'.$data['report_format_file_config'] : '');
		
		$bean->report_scope = $data['report_scope'];
		$bean->scheduled_images = $data['scheduled_images'];
		$bean->description = base64_encode(serialize($data['description']));
		$bean->email_list = $data['email_list']['from'].'${pipe}'.implode('${comma}', $data['email_list']['to']['users']).'${pipe}'.implode('${comma}', $data['email_list']['cc']['users']).'${pipe}'.implode('${comma}', $data['email_list']['bcc']['users']).'${pipe}'.implode('${comma}', $data['email_list']['to']['roles']).'${pipe}'.implode('${comma}', $data['email_list']['cc']['roles']).'${pipe}'.implode('${comma}', $data['email_list']['bcc']['roles']).'${pipe}'.$data['email_list']['to']['list'].'${pipe}'.$data['email_list']['cc']['list'].'${pipe}'.$data['email_list']['bcc']['list'];
		$bean->assigned_user_id = $data['assigned_user_id'];
		$bean->report_charts = $data['report_charts'];
		$bean->report_fields = rawurlencode(json_encode($data['content']['fields']));
		
		if (isset($data['is_meta']) && ($data['is_meta'])) { //Is Meta report
			
			$bean->is_meta = true;
			$bean->meta_html = $data['meta_html'];
			
		} else {
			
			$bean->data_source = rawurlencode(json_encode($data['data_source']));
			$bean->report_module = $data['report_module'];
			$bean->dynamic_tables = $data['dynamic_tables'];
			$bean->dynamic_sql = $data['dynamic_sql'];
			asol_ReportsGenerationFunctions::convertDateFiltersToDatabaseFormat($data['content']['filters']);
			$bean->report_filters = rawurlencode(json_encode($data['content']['filters']));
			$bean->report_charts_detail = rawurlencode(json_encode($data['content']['charts_detail']));
			$bean->report_charts_engine = $data['content']['charts_engine'];
			$bean->row_index_display = $data['row_index_display'];
			$bean->results_limit = $data['content']['results_limit'];
			$bean->dynamic_sql = $data['dynamic_sql'];
			
			// Reformatear la fecha de finalizacion de las areas progrmadas al formato de la BDD		
			$scheduledTasks = $data['content']['tasks']['data'];
			$userTZ = $current_user->getPreference("timezone");
			$phpDateTime = new DateTime(null, new DateTimeZone($userTZ));
			$hourOffset = $phpDateTime->getOffset()*-1;
			
			foreach ($scheduledTasks as & $currentTask) {
			
				if ((!$timedate->check_matching_format($currentTask['end'], $GLOBALS['timedate']->dbDayFormat)) && ($currentTask['end'] != "")) {
					$currentTask['end'] = $timedate->swap_formats($currentTask['end'], $timedate->get_date_format(), $GLOBALS['timedate']->dbDayFormat );
				}
			
				$currentTime = explode(":", $currentTask['time']);
				$currentTask['time'] = date("H:i", @mktime($currentTime[0], $currentTime[1], 0, date("m"), date("d"), date("Y"))+$hourOffset);
			
			}
			
			$bean->report_tasks = urlencode(json_encode(
				array(
					'data' => $scheduledTasks,
					'offset' => $phpDateTime->getOffset(),
				)
			));
			
			if (asol_CommonUtils::isDomainsInstalled()) {
				$bean->asol_domain_id = $data['domains']['id'];
				$bean->asol_domain_published_mode = $data['domains']['mode'];
				$bean->asol_domain_child_share_depth = $data['domains']['level'];
				$bean->asol_multi_create_domain = $data['domains']['publish'];
				$bean->asol_published_domain = $data['domains']['enable'];
			}
			
		}
				
		return $bean->save();
		
	}
	
	static public function getEditReport($record) {
		
		global $sugar_config;
		
		require_once("modules/asol_Reports/include/manageReportsFunctions.php");
		
		$bean = BeanFactory::getBean("asol_Reports", $record);
		
		if (empty($bean->id)) {
			return json_encode(array('notExists' => $record));
		}

		//**********************************//
		//***Get Config_Override Features***//
		//**********************************//
		$translateFieldLabels = ((!isset($sugar_config['asolReportsTranslateLabels'])) || ($sugar_config['asolReportsTranslateLabels']) ? true : false);
		$defaultLanguage = (isset($sugar_config["asolReportsDefaultExportedLanguage"]) ? $sugar_config["asolReportsDefaultExportedLanguage"] : "en_us");
		$mySQLinsecurityScope = (isset($sugar_config["asolReportsMySQLinsecuritySubSelectScope"]) ? $sugar_config["asolReportsMySQLinsecuritySubSelectScope"] : 1);
		//**********************************//
		//***Get Config_Override Features***//
		//**********************************//
		
		$bean->data_source = json_decode(rawurldecode($bean->data_source), true);
		$bean->content = json_decode(urldecode($bean->content), true);
		$currentReportsDomains = array();
		
		if (asol_CommonUtils::isDomainsInstalled()) {
			foreach (array_keys($bean->content['domains']) as $currentDomainId) {
				$currentReportsDomains[] = array(
					'key' => $currentDomainId,
					'label' => BeanFactory::getBean('asol_Domains', $currentDomainId)->name
				);
			}
		}
		
		$results_limit = explode('${dp}', $bean->results_limit);
		
		/****** email_list *******/
		
		$emailListData = explode('${pipe}', urldecode($bean->email_list));
		$usersListToData = explode('${comma}', $emailListData[1]);
		$usersListCcData = explode('${comma}', $emailListData[2]);
		$usersListBccData = explode('${comma}', $emailListData[3]);
		$rolesListToData = explode('${comma}', $emailListData[4]);
		$rolesListCcData = explode('${comma}', $emailListData[5]);
		$rolesListBccData = explode('${comma}', $emailListData[6]);
		$distributionListToData = explode('${comma}', $emailListData[7]);
		$distributionListCcData = explode('${comma}', $emailListData[8]);
		$distributionListBccData = explode('${comma}', $emailListData[9]);
		
		$emailListData = array(
			'from' => $emailListData[0],
			'to' => array(
				'users' => $usersListToData,
				'roles'	=> $rolesListToData,
				'list'	=> $distributionListToData,
			),
			'cc' => array(
				'users' => $usersListCcData,
				'roles'	=> $rolesListCcData,
				'list'	=> $distributionListCcData,
			),
			'bcc' => array(
				'users' => $usersListBccData,
				'roles'	=> $rolesListBccData,
				'list'	=> $distributionListBccData,
			),
		);
		
		/****** email_list *******/
		
		$report_charts_detail = json_decode(rawurldecode($bean->report_charts_detail), true);
		$preparedChartsArray = ($report_charts_detail ? $report_charts_detail : '');
		$preparedFieldsArray = asol_ReportsManagementFunctions::prepareReportFields($bean->data_source, $bean->report_fields, $translateFieldLabels, $fieldsToBeRemoved);
		$preparedFiltersArray = asol_ReportsManagementFunctions::prepareReportFilters($bean->data_source, $bean->report_filters, $translateFieldLabels, $fieldsToBeRemoved);
		
		$reportFields = json_decode(rawurldecode($bean->report_fields), true);
		$css = (isset($reportFields['tables'][0]['css']) ? $reportFields['tables'][0]['css'] : '');
		$commonTemplates = (isset($reportFields['tables'][0]['templates']) ? $reportFields['tables'][0]['templates'] : array());
			
		$reportScope = explode('${dp}', $bean->report_scope);
		
		$returnObject = array(
			'id' => $bean->id,
			'name' => $bean->name,
			'description' => unserialize(base64_decode($bean->description)),
			'assigned_user_id' => $bean->assigned_user_id,
			'assigned_user_name' => $bean->assigned_user_name,
			'data_source' => $bean->data_source,
			'parent_id' => $bean->parent_id,
			'scheduled_images' => $bean->scheduled_images,
			'report_charts' => $bean->report_charts,
			'report_attachment_format' => $bean->report_attachment_format,
			'report_scope' => array(
				'type' => $reportScope[0],
				'roles' => explode('${comma}', $reportScope[1])
			),
			'report_type' => json_decode(rawurldecode($bean->report_type), true),
			'report_scheduled_type' => $bean->report_scheduled_type,
			'css' => $css,
			'commonTemplates' => $commonTemplates,
			'is_meta' => $bean->is_meta,
			'meta_html' => htmlspecialchars_decode(urldecode($bean->meta_html)),
			'report_charts' => 	$bean->report_charts,
			'email_list' => $emailListData,
			'dynamic_sql' => $bean->dynamic_sql,
				
			'domains' => array(
				'id' => $bean->asol_domain_id,
				'name' => $bean->asol_domain_name,
				'mode' => $bean->asol_domain_published_mode,
				'level' => $bean->asol_domain_child_share_depth,
				'publish' => $bean->asol_multi_create_domain,
				'enable' => $bean->asol_published_domain
			),
			
			'content' => array(
				'fields' => $preparedFieldsArray['array'],
				'filters' => $preparedFiltersArray['array'],
				'results_limit'	=> ($results_limit[0] !== 'all' ? $results_limit[0].'${dp}'.$results_limit[1].'${dp}'.$results_limit[2] : $results_limit[0]),
				'tasks' => json_decode(urldecode(asol_ReportsManagementFunctions::prepareReportTasks($bean->report_tasks, $bean->date_modified, null))),
				'charts_detail' => $preparedChartsArray,
				'charts_engine' => $bean->report_charts_engine,
				'domains' => $currentReportsDomains,
			),
		);
		
		asol_CommonUtils::ajaxTracker($bean->id, $bean->name, 'asol_Reports');
		
		return json_encode($returnObject);
		
	}
	
}
