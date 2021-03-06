<?php

require_once('modules/asol_Common/include/commonUtils.php');

class asol_ReportsGenerationFunctions {
	
	static public function getReportExportedFileName($reportName) {
		
		$exportedReportName = preg_replace ('/[^a-zA-Z0-9]/', '', $reportName);
		$reportNameNoSpaces = strtolower(str_replace(":", "", str_replace(" ", "_", $exportedReportName)));
		$httpHtmlFile = $reportNameNoSpaces."_".dechex(time()).dechex(rand(0,999999));
		
		return $httpHtmlFile;
		
	}
	
	static public function getReportNotIndexedOrderByAlert() {
		
		return '<script type="text/javascript">
			ajaxStatus.showStatus("'.asol_ReportsUtils::translateReportsLabel("LBL_REPORT_MAX_ALLOWED_NOT_INDEXED_ORDERBY_ALERT").'");
			setTimeout(function(){ ajaxStatus.hideStatus() }, 10000);
		</script>';
		
	}
	
	static public function getReportPublicDescription($publicDescription, $isDashlet, $externalCall, $getExportData) {
		
		global $mod_strings;
		
		if ((!empty($publicDescription)) && (!$isDashlet)) {
		
			return 
			'<tr>
				<td>
					<div id="reportInfoDivWrapper" class="detail view">
						'.self::getReportHeaderInfo($isDashlet, $externalCall, $mod_strings['LBL_REPORT_DESCRIPTION'], null, ($getExportData ? null : "reportInfoDiv")).'
						<div id="reportInfoDiv">
							<table id="resultTable">
								<tbody>
									<tr>
										<td>'.nl2br($publicDescription).'</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</td>
			</tr>';
		
		}
		
	}
	
	static public function getOversizedReportMessage($maxAllowedDisplayed, $maxAllowedParseMultiTable, $maxAllowedGroupByEntries, $totalEntries, $totalUngroupedEntries, $isDashlet, $externalCall) {
		
		global $sugar_config;
		
		if ($maxAllowedDisplayed) {
			$reportHeaderMessage = asol_ReportsUtils::translateReportsLabel('LBL_REPORT_OVERSIZED');
			$reportHeaderInfo = null; //'<span style="color:red">'.$totalEntries.' entries to be processed by AlineaSolReports Engine ('.$sugar_config['asolReportsMaxAllowedDisplayed'].' max allowed).</span>';
		} else if ($maxAllowedParseMultiTable) {
			$reportHeaderMessage = asol_ReportsUtils::translateReportsLabel('LBL_REPORT_OVERSIZED');
			$reportHeaderInfo = null; //'<span style="color:red">'.$totalEntries.' entries to be processed by AlineaSolReports Engine ('.$sugar_config['asolReportsMaxAllowedParseMultiTable'].' max allowed).</span>';
		} else if ($maxAllowedGroupByEntries) {
			$reportHeaderMessage = asol_ReportsUtils::translateReportsLabel('LBL_REPORT_OVERSIZED');
			$reportHeaderInfo = null; //'<span style="color:red">'.$totalUngroupedEntries.' entries to be processed as grouped by AlineaSolReports Engine ('.$sugar_config['asolReportsMaxAllowedGroupByEntries'].' max allowed).</span>';
		}
		
		return '<div class="detail view">
					'.self::getReportHeaderInfo($isDashlet, $externalCall, $reportHeaderMessage, $reportHeaderInfo).'
				</div>';
		
	}
	
	static public function getChartContentsContainer($reportId, $chartsEngine, $urlChart, $chartDef, $getExportData) {

		global $mod_strings;
		
		$chartsHtml = '';
		
		if (count($urlChart) > 0) {
		
			$fixedReportId = str_replace("-", "", $reportId);
			
			$chartsHtml .= '<div id="chartsContent">';
				
			switch ($chartsEngine) {
			
				case "flash":
					foreach ($urlChart as $key=>$value) {
						if ($getExportData) {
							$chartsHtml .= '<chart key="'.$fixedReportId.'_'.$key.'"/>';
						} else {
							$chartsHtml .=
							'<div class="asolChartContainer" engine="flash">
								<div id="ASOLflash_'.$fixedReportId.'_'.$key.'">
									<strong>'.$mod_strings['LBL_REPORT_FLASH_WARNING'].'</strong>
		  							<a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Descargar Adobe Flash Player" /></a>
			
								</div>
							</div>';
						}
					}
					break;
						
				case "html5":
					$chartsHtml .= "<input type='hidden' id='showHideChartButton' value='true'>";
					foreach ($chartDef as $key=>$html5) {
						if (isset($html5)) {
							if ($getExportData) {
								$chartsHtml .= '<chart key="'.$fixedReportId.'_'.$key.'"/>';
							} else {
								$chartsHtml .= '<div class="asolChartContainer" engine="html5" id="ASOLhtml5_'.$fixedReportId.'_'.$key.'" style="width: '.$html5['dimensions']['width'].';">'.$html5['html'].'</div>';
							}
						}
					}
					break;
						
				case "nvd3":
					foreach ($chartDef as $key=>$nvd3) {
						if (isset($nvd3)) {
							if ($getExportData) {
								$chartsHtml .= '<chart key="'.$fixedReportId.'_'.$key.'"/>';
							} else {								
								$chartsHtml .= $nvd3['html'].'
								<div class="asolChartContainer" engine="nvd3" id="ASOLnvd3_'.$fixedReportId.'_'.$key.'" style="'.(strpos($nvd3['dimensions']['width'],'px') != false ? '' : 'display: inline-block;').' height: '.$nvd3['dimensions']['height'].'; width:'.$nvd3['dimensions']['width'].';">
									<svg xmlns="http://www.w3.org/2000/svg" id="ASOLsvg_'.$fixedReportId.'_'.$key.'" style="height:100%; width:100%; direction:ltr;"></svg>
								</div>';
							}
						}
					}
					break;
						
				default:
					break;
						
			}
				
			$chartsHtml .= '</div>';
		
		}
		
		return $chartsHtml;
		
	}
	
	static public function getReportDetailButtons($reportId, $isMetaReport, $isFilterVisible, $reportDomainId, $created_by, $assigned_user_id, $report_scope, $attachmentFormat, $sendEmailquestion, $scheduledTypeInfo, $filtersHiddenInputs, $searchCriteria, $isDashlet, $dashletId, $staticFilters, $externalCall, $getLibraries, $overrideEntries, $overrideInfo, $scheduledEmailHideButtons, $displayNoDataMsg, $isWsExecution, $isPreview, $enableExport) {
	
		global $current_user, $sugar_config, $db, $mod_strings;
		
		//***********************//
		//***AlineaSol Premium***//
		//***********************//
		$hasExternalApp = (!empty($scheduledTypeInfo) && (isset($scheduledTypeInfo['application'])));
		$hasExternalFtp = (!empty($scheduledTypeInfo) && (isset($scheduledTypeInfo['ftp'])));
		$hasExternalTl = (!empty($scheduledTypeInfo) && (isset($scheduledTypeInfo['tl'])));
		
		$readOnlyMode = asol_ReportsUtils::managePremiumFeature("reportReadOnlyMode", "reportFunctions.php", "getReadOnlyModeFlag", null);
		//***********************//
		//***AlineaSol Premium***//
		//***********************//
		
		$attachmentFormatArray = explode(':', $attachmentFormat);
		$attachmentFormat = strtolower($attachmentFormatArray[0]);
		
		$dashletExportButtons = (isset($sugar_config['asolReportsDashletExportButtons']) ? $sugar_config['asolReportsDashletExportButtons'] : true);
		
		$hasStaticFilters = (!empty($staticFilters));
		
		$returnedHTML = "";
		
		if ((!$isDashlet) && (!$externalCall) && (!$filtersHiddenInputs) && (!$isPreview)) {

			$returnedHTML .= '<button id="reportbutton_refresh" class="button" onclick="controllerReportDetail.reloadReport(this, \''.$reportId.'\', true, {\'dashlet\':'.($isDashlet ? 'true' : 'false').', \'dashletId\':\''.$dashletId.'\', \'currentUserId\':\''.$current_user->id.'\'});">'.asol_ReportsUtils::translateReportsLabel('LBL_REPORT_REFRESH').'</button> ';

		}
		
		if (!$isMetaReport) {

			if ($filtersHiddenInputs && (!$externalCall) && (!isset($scheduledEmailHideButtons))) {
				
				$returnedHTML .= '<button class="button executeReportBtn" style="display: '.($isFilterVisible ? 'inline' : 'none').'" onClick="controllerReportDetail.reloadReport(this, \''.$reportId.'\', false, {\'dashlet\':'.($isDashlet ? 'true' : 'false').', \'dashletId\':\''.$dashletId.'\', \'currentUserId\':\''.$current_user->id.'\', \'page_number\':\'0\', \'sort_field\':\'\', \'sort_direction\':\'\', \'sort_index\':\'\', \'getLibraries\':\''.($isDashlet && $getLibraries ? 'true' : 'false').'\', \'overrideEntries\':'.(!empty($overrideEntries) ? '\''.$overrideEntries.'\'' : 'null').', \'overrideInfo\':'.(!empty($overrideInfo) ? '\''.urlencode(json_encode($overrideInfo)).'\'' : 'null').', \'overrideConfig\':'.(!empty($overrideConfig) ? '\''.urlencode(json_encode($overrideConfig)).'\'' : 'null').', \'staticFilters\':'.(!empty($staticFilters) ? '\''.$staticFilters.'\'' : 'null').'});">'.asol_ReportsUtils::translateReportsLabel('LBL_REPORT_RUN').'</button> ';
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
	
			$domainReportModifiable = (asol_CommonUtils::isDomainsInstalled()) ? asol_CommonUtils::domainCanModifyElement($reportDomainId) : true;
			$userReportModifiable = asol_CommonUtils::userCanModifyElement($created_by, $assigned_user_id);
			$roleReportModifiable = asol_ReportsUtils::roleCanModifyReport($report_scope);
			
	
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
			
	
	static public function getReportDetailPagination($reportId, $columnsCount, $externalCall, $getLibraries, $overrideEntries, $overrideInfo, $overrideConfig, $isDashlet, $dashletId, $numPages, $pageNumber, $totalEntries, $sortField, $sortDirection, $sortIndex, $staticFilters, $hasUserInputsFilters) {
		
		global $mod_strings, $app_strings;
	
		$returnedHTML = "";
		
		$previousPage = ($pageNumber > 0 ? $pageNumber-1 : '0');
		$nextPage = ($pageNumber < $numPages ? $pageNumber+1 : $numPages);
		
		$paginationSortDirection = (isset($_REQUEST['sort_direction']) ? $_REQUEST['sort_direction'] : $sortDirection);
		$paginationSortIndex = (isset($_REQUEST['sort_index']) ? $_REQUEST['sort_index'] : $sortIndex);
		
		$disabledPaginationButtonsBack = (($numPages == 0) || ($pageNumber == 0) ? "disabled" : "");
		$disabledPaginationButtonsForward = (($numPages == 0) || ($pageNumber == $numPages) || ($totalEntries == 0) ? "disabled" : "");
		
		if ((!$externalCall) && ($numPages > 0)) {
	
			$returnedHTML .= 
			'<tr class="pagination">
				<td colspan="'.$columnsCount.'">
					<table cellspacing="0" cellpadding="0" border="0" width="100%" class="paginationTable">
						<tbody>
							<tr>
								<td nowrap="nowrap" align="right" width="1%" class="paginationChangeButtons">
									<button '.$disabledPaginationButtonsBack.' title="'.$app_strings['LNK_LIST_START'].'" class="button paginationStart" type="button" onClick="controllerReportDetail.reloadReport(this, \''.$reportId.'\', false, {\'dashlet\':'.($isDashlet ? 'true' : 'false').', \'dashletId\':\''.$dashletId.'\', \'currentUserId\':\''.$current_user->id.'\', \'page_number\':\'0\', \'sort_field\':\''.$sortField.'\', \'sort_direction\':\''.$paginationSortDirection.'\', \'sort_index\':\''.$paginationSortIndex.'\', \'getLibraries\':\''.($isDashlet && $getLibraries ? 'true' : 'false').'\', \'overrideEntries\':'.(!empty($overrideEntries) ? '\''.$overrideEntries.'\'' : 'null').', \'overrideInfo\':'.(!empty($overrideInfo) ? '\''.urlencode(json_encode($overrideInfo)).'\'' : 'null').', \'overrideConfig\':'.(!empty($overrideConfig) ? '\''.urlencode(json_encode($overrideConfig)).'\'' : 'null').', \'staticFilters\':'.(!empty($staticFilters) ? '\''.$staticFilters.'\'' : 'null').'});">
										<i class="icn-fast-forward down" title="'.$app_strings['LNK_LIST_START'].'"  '.( (($numPages == 0) || ($pageNumber == 0)) ? 'style="opacity:0.2"' : '').'></i>
									</button>
									<button '.$disabledPaginationButtonsBack.' title="'.$app_strings['LNK_LIST_PREVIOUS'].'" class="button paginationPrev" type="button"  onClick="controllerReportDetail.reloadReport(this, \''.$reportId.'\', false, {\'dashlet\':'.($isDashlet ? 'true' : 'false').', \'dashletId\':\''.$dashletId.'\', \'currentUserId\':\''.$current_user->id.'\', \'page_number\':\''.$previousPage.'\', \'sort_field\':\''.$sortField.'\', \'sort_direction\':\''.$paginationSortDirection.'\', \'sort_index\':\''.$paginationSortIndex.'\', \'getLibraries\':\''.($isDashlet && $getLibraries ? 'true' : 'false').'\', \'overrideEntries\':'.(!empty($overrideEntries) ? '\''.$overrideEntries.'\'' : 'null').', \'overrideInfo\':'.(!empty($overrideInfo) ? '\''.urlencode(json_encode($overrideInfo)).'\'' : 'null').', \'overrideConfig\':'.(!empty($overrideConfig) ? '\''.urlencode(json_encode($overrideConfig)).'\'' : 'null').', \'staticFilters\':'.(!empty($staticFilters) ? '\''.$staticFilters.'\'' : 'null').'});">
										<i class="icn-play down" title="'.$app_strings['LNK_LIST_PREVIOUS'].'" '.( (($numPages == 0) || ($pageNumber == 0)) ? 'style="opacity:0.2"' : '').'></i>
									</button>
									<span class="pageNumbers">'.asol_ReportsUtils::translateReportsLabel('LBL_REPORT_PAGINATION_PAGE', 'asol_Reports').' '.($pageNumber + 1).' '.asol_ReportsUtils::translateReportsLabel('LBL_REPORT_PAGINATION_OF', 'asol_Reports').' '.($numPages + 1).'</span>
									<button '.$disabledPaginationButtonsForward.' title="'.$app_strings['LNK_LIST_NEXT'].'" class="button paginationNext" type="button" onClick="controllerReportDetail.reloadReport(this, \''.$reportId.'\', false, {\'dashlet\':'.($isDashlet ? 'true' : 'false').', \'dashletId\':\''.$dashletId.'\', \'currentUserId\':\''.$current_user->id.'\', \'page_number\':\''.$nextPage.'\', \'sort_field\':\''.$sortField.'\', \'sort_direction\':\''.$paginationSortDirection.'\', \'sort_index\':\''.$paginationSortIndex.'\', \'getLibraries\':\''.($isDashlet && $getLibraries ? 'true' : 'false').'\', \'overrideEntries\':'.(!empty($overrideEntries) ? '\''.$overrideEntries.'\'' : 'null').', \'overrideInfo\':'.(!empty($overrideInfo) ? '\''.urlencode(json_encode($overrideInfo)).'\'' : 'null').', \'overrideConfig\':'.(!empty($overrideConfig) ? '\''.urlencode(json_encode($overrideConfig)).'\'' : 'null').', \'staticFilters\':'.(!empty($staticFilters) ? '\''.$staticFilters.'\'' : 'null').'});">
										<i class="icn-play" title="'.$app_strings['LNK_LIST_NEXT'].'" '.( (($numPages == 0) || ($pageNumber == $numPages) || ($totalEntries == 0)) ? 'style="opacity:0.2"' : '').'></i>
									</button>
									<button '.$disabledPaginationButtonsForward.' title="'.$app_strings['LNK_LIST_END'].'" class="button paginationEnd" type="button"  onClick="controllerReportDetail.reloadReport(this, \''.$reportId.'\', false, {\'dashlet\':'.($isDashlet ? 'true' : 'false').', \'dashletId\':\''.$dashletId.'\', \'currentUserId\':\''.$current_user->id.'\', \'page_number\':\''.$numPages.'\', \'sort_field\':\''.$sortField.'\', \'sort_direction\':\''.$paginationSortDirection.'\', \'sort_index\':\''.$paginationSortIndex.'\', \'getLibraries\':\''.($isDashlet && $getLibraries ? 'true' : 'false').'\', \'overrideEntries\':'.(!empty($overrideEntries) ? '\''.$overrideEntries.'\'' : 'null').', \'overrideInfo\':'.(!empty($overrideInfo) ? '\''.urlencode(json_encode($overrideInfo)).'\'' : 'null').', \'overrideConfig\':'.(!empty($overrideConfig) ? '\''.urlencode(json_encode($overrideConfig)).'\'' : 'null').', \'staticFilters\':'.(!empty($staticFilters) ? '\''.$staticFilters.'\'' : 'null').'});">
										<i class="icn-fast-forward" title="'.$app_strings['LNK_LIST_END'].'" '.( (($numPages == 0) || ($pageNumber == $numPages) || ($totalEntries == 0)) ? 'style="opacity:0.2"' : '').'></i>
									</button>
					 			</td>
							</tr>
						 </tbody>
					</table>
				</td>
			</tr>';
			
		} else if( $hasUserInputsFilters ) $returnedHTML .= '<tr class="voidPagination"><td><div></div></td></tr>';
	 	
		return $returnedHTML;
		
	}
	
	static private function getCollapseImg($containerId) {
	
		return '<img onclick="if( $(&quot;#'.$containerId.'&quot;).is(&quot;:visible&quot;) ) { $(&quot;#'.$containerId.'&quot;).hide(); $(&quot;#'.$containerId.'_collapseImg&quot;).attr(&quot;src&quot;, &quot;themes/default/images/advanced_search.gif&quot;) } else { $(&quot;#'.$containerId.'&quot;).show(); $(&quot;#'.$containerId.'_collapseImg&quot;).attr(&quot;src&quot;, &quot;themes/default/images/basic_search.gif&quot;) } " onmouseout="this.style.cursor=&quot;default&quot;" onmouseover="this.style.cursor=&quot;pointer&quot;" src="themes/default/images/basic_search.gif" id="'.$containerId.'_collapseImg" style="cursor: default;">&nbsp';
	
	}
	
	static public function getReportHeaderInfo($isDashlet, $externalCall, $reportHeaderMessage, $reportHeaderInfo = null, $collapsibleHeaderId = null) {
	
		if (isset($reportHeaderMessage)) {
		
			$headerHtml = (!$isDashlet) ? '<h4>' : '';
			if (!$externalCall) {
				$headerHtml .= ($collapsibleHeaderId !== null) ? self::getCollapseImg($collapsibleHeaderId) : '';
			}
			$headerHtml .= ($reportHeaderInfo !== null ? '<em class="asolReportMessage">'.$reportHeaderMessage.'</em>'.' : '.$reportHeaderInfo : '<em class="asolReportMessage">'.$reportHeaderMessage.'</em>');
			$headerHtml .= (!$isDashlet) ? '</h4>' : '';
		
		}
		
		return $headerHtml;
	
	}
	
	static public function getReportExportForm($dashletId, $exportedReportFile, $executionMode, $isWsExecution) {
		
		return 
		'<form id="export_form'.$dashletId.'" name="export_form'.$dashletId.'" method="post" action="index.php" style="display: none;">
		
			<input type="hidden" name="module" value="asol_Reports">
			<input type="hidden" name="entryPoint" value="reportAjaxActions">
			<input type="hidden" name="actionTarget" value="downloadExportedReport">
			<input type="hidden" name="getContent" value="true">
		
			<input type="hidden" name="fileName" value="'.$exportedReportFile.'">
			<input type="hidden" name="fileType" value="">
			<input type="hidden" name="executionMode" value="'.$executionMode.'">
			<input type="hidden" name="mimeType" value="">
			
			<input type="hidden" name="pngs" value="">
			<input type="hidden" name="legends" value="">
			<input type="hidden" name="engines" value="">
			
			<input type="hidden" name="isWsExecution" value="'.($isWsExecution ? '1' : '0').'">
		
		</form>';
		
	}
	
	static public function getReportDetailSearchCriteria($reportId, $filterVisibility, $filtersPanel, $filtersHiddenInputs, $external_filters, $searchCriteria, $currentUserId, $hasStaticFilters, $isDashlet, $dashletId, $cleanUpStyling, $filterslayoutConfig, $search_mode) {
		
		global $mod_strings;
		
		$returnedHTML = "";
		
		if (!empty($filtersPanel)) {
							
			$returnedHTML .=
				'<div class="'.($cleanUpStyling ? '' : 'detail ').'view search_criteria" style="display: '.($filterVisibility ? 'block' : 'none').';">
					
					<h4>'.asol_ReportsUtils::translateReportsLabel('LBL_REPORT_SEARCH_CRITERIA').'</h4>
					
					<form id="criteria_form" name="criteria_form" onsubmit="return false;">
					<input type="hidden" id="filters_hidden_inputs'.$dashletId.'" name="filters_hidden_inputs'.$dashletId.'" value="'.$filtersHiddenInputs.'">
					<input type="hidden" id="external_filters" name="external_filters" value="'.$external_filters.'">
					<input type="hidden" id="search_criteria" name="search_criteria" value="'.$searchCriteria.'">
					<input type="hidden" id="currentUserId" name="currentUserId" value="'.$currentUserId.'">
						
					<table id="search_criteria" class="asolReportsCriteriaTable">';
	
					//***********************//
					//***AlineaSol Premium***//
					//***********************//
					$extraParams = array(
						'filtersPanel' => $filtersPanel,
						'layoutConfig' => $filterslayoutConfig ,
						'search_mode' => $search_mode,
					);
											
					$premiumSearch = asol_ReportsUtils::managePremiumFeature("filtersLayoutDefinition", "reportFunctions.php", "getFiltersLayoutTable", $extraParams);					
					//***********************//
					//***AlineaSol Premium***//
					//***********************//
					if (!$premiumSearch) {
						
							$numFilters = count($filtersPanel);
							
							$filtersPerRow = ($isDashlet && !$hasStaticFilters ? 1 : 2);
							$filterWidth = round((100.0 / $filtersPerRow / 5), 2);
							
							$returnedHTML .= '<colgroup>';
							for($i=0; $i<$filtersPerRow; $i++) {
								$returnedHTML .= '<col span="5" style="width: '.$filterWidth.'%;" />';
							}
							$returnedHTML .= '</colgroup>';
							
							$returnedHTML .= '<tbody>';
							$index = 1;
							
							foreach ($filtersPanel as $key=>$item) {
								
								if (($index % $filtersPerRow) == 1) { // first filter
									$returnedHTML .= '<tr>';
								}
								
								$returnedHTML .= '
									<td class="asolFilterInfo" scope="col" valign="top">
										<input class="filterType" type="hidden" value="'.$item['type'].'">
										<input class="filterRef" type="hidden" value="'.$item['reference'].'">
										<b>'.$item['label'].'</b>
									</td>
									<td valign="top">
										'.$item['genLabel'].'
									</td>';
								
								if (empty($item['input2']) && empty($item['input3'])) {
									$returnedHTML .= '
									<td class="asolFirstParameter" valign="top" colspan="3">
										'.$item['input1'].'
									</td>';
								} else if (empty($item['input3'])) {
									$returnedHTML .= '
									<td class="asolFirstParameter" valign="top">
										'.$item['input1'].'
									</td>
									<td class="asolSecondParameter" valign="top" colspan="2">
										'.$item['input2'].'
									</td>';
								} else {
									$returnedHTML .= '
									<td class="asolFirstParameter" valign="top">
										'.$item['input1'].'
									</td>
									<td class="asolSecondParameter" valign="top">
										'.$item['input2'].'
									</td>
									<td class="asolThirdParameter" valign="top">
										'.$item['input3'].'
									</td>';
								}
								
								if ((($index % $filtersPerRow) == 0) || ($index == $numFilters)) {
									if (($index == $numFilters) && ($index % 2 != 0) && (!$isDashlet)) {
										$returnedHTML .= '
										<td scope="col" style="width: 10%;"></td>
										<td colspan="4" style="width: 40%;"></td>';								
									}
									
									$returnedHTML .= '</tr>';
								}
								
								$index++;
								
							}
							$returnedHTML .= '</tbody>';
					} else {
						$returnedHTML .= $premiumSearch;
					}
			$returnedHTML .= '
						</table>
					</form>
				</div>';
		}
		
		return $returnedHTML;
		
	}
	
	public static function getEmailInfo($emailList) {
	
		global $mod_strings, $db;
		
		$email_list_field = explode('${pipe}', urldecode($emailList));
						
		$users_to = explode('${comma}', urldecode($email_list_field[1]));
		$users_cc = explode('${comma}', urldecode($email_list_field[2]));
		$users_bcc = explode('${comma}', urldecode($email_list_field[3]));
		$roles_to = explode('${comma}', urldecode($email_list_field[4]));
		$roles_cc = explode('${comma}', urldecode($email_list_field[5]));
		$roles_bcc = explode('${comma}', urldecode($email_list_field[6]));
		$emails_to = explode(',', urldecode($email_list_field[7]));
		$emails_cc = explode(',', urldecode($email_list_field[8]));
		$emails_bcc = explode(',', urldecode($email_list_field[9]));
		
		return array(
			"emailFrom" => $email_list_field[0],
			"emailArrays" => array(
				"users_to" => $users_to,
				"users_cc" => $users_cc,
				"users_bcc" => $users_bcc,
				"roles_to" => $roles_to,
				"roles_cc" => $roles_cc,
				"roles_bcc" => $roles_bcc,
				"emails_to" => $emails_to,
				"emails_cc" => $emails_cc,
				"emails_bcc" => $emails_bcc
			)
		);
		
	}
		
	public static function setSendEmailAddresses(& $reportMailer, $emailArray, $contextDomainId = null) {
		
		global $current_user, $db;
		
		if (asol_CommonUtils::isDomainsInstalled()) {
			$domainId = ($contextDomainId != null) ? $contextDomainId : $current_user->asol_default_domain;
		}
		
		
		//***********************//
		//****** TO EMAILS ******//
		//***********************//
		foreach ($emailArray['users_to'] as $key=>$value) {
			$userBean = BeanFactory::getBean('Users', $value);
			if (!empty($userBean)) {
				$userEmail = $userBean->getUsersNameAndEmail();
				$validUserMail = (asol_CommonUtils::isDomainsInstalled()) ? (($userEmail['email'] != "") && (($userBean->asol_domain_id == $domainId) || $userBean->is_admin)) : ($userEmail['email'] != "");
				if ($validUserMail) {
					$reportMailer->AddAddress($userEmail['email']);
				}
			}
		}
		foreach($emailArray['roles_to'] as $key => $value) {
			$usersFromRole = Array();
			if (asol_CommonUtils::isDomainsInstalled()) {
				$usersFromRoleSql = "SELECT acl_roles_users.user_id FROM acl_roles_users LEFT JOIN users ON acl_roles_users.user_id=users.id WHERE acl_roles_users.role_id = '".$value."' AND users.deleted=0 AND users.asol_domain_id='".$domainId."'";
			} else {
				$usersFromRoleSql = "SELECT user_id FROM acl_roles_users WHERE role_id = '".$value."'";
			}
			$usersFromRoleRs = $db->query($usersFromRoleSql);
			while($userFromRole_Row = $db->fetchByAssoc($usersFromRoleRs))
				$usersFromRole[] = $userFromRole_Row['user_id'];
			foreach($usersFromRole as $key=>$value) {
				$userEmail = BeanFactory::getBean('Users', $value)->getUsersNameAndEmail();
				if ($userEmail['email'] != "") {
					$reportMailer->AddAddress($userEmail['email']);
				}
			}
		}
		foreach ($emailArray['emails_to'] as $key=>$value){
			if ($value != "") {
				$reportMailer->AddAddress($value);
			}	
		}
		
		//***********************//
		//****** CC EMAILS ******//
		//***********************//
		//Emails de los destinatarios copias
		foreach ($emailArray['users_cc'] as $key=>$value) {
			$userBean = BeanFactory::getBean('Users', $value);
			if (!empty($userBean)) {
				$userEmail = $userBean->getUsersNameAndEmail();
				$validUserMail = (asol_CommonUtils::isDomainsInstalled()) ? (($userEmail['email'] != "") && (($userBean->asol_domain_id == $domainId) || $userBean->is_admin)) : ($userEmail['email'] != "");
				if ($validUserMail) {
					$reportMailer->AddCC($userEmail['email']);
				}
			}
		}
		foreach($emailArray['roles_cc'] as $key => $value) {
			$usersFromRole = Array();
			if (asol_CommonUtils::isDomainsInstalled()) {
				$usersFromRoleSql = "SELECT acl_roles_users.user_id FROM acl_roles_users LEFT JOIN users ON acl_roles_users.user_id=users.id WHERE acl_roles_users.role_id = '".$value."' AND users.deleted=0 AND users.asol_domain_id='".$domainId."'";
			} else {
				$usersFromRoleSql = "SELECT user_id FROM acl_roles_users WHERE role_id = '".$value."'";
			}
			$usersFromRoleRs = $db->query($usersFromRoleSql);
			while($userFromRole_Row = $db->fetchByAssoc($usersFromRoleRs))
				$usersFromRole[] = $userFromRole_Row['user_id'];
			foreach($usersFromRole as $key=>$value) {
				$userEmail = BeanFactory::getBean('Users', $value)->getUsersNameAndEmail();
				if ($userEmail['email'] != "") {
					$reportMailer->AddCC($userEmail['email']);
				}
			}
		}
		foreach ($emailArray['emails_cc'] as $key=>$value){
			if ($value != "") {
				$reportMailer->AddCC($value);
			}
		}
		
		//***********************//
		//***** BCC EMAILS ******//
		//***********************//
		foreach ($emailArray['users_bcc'] as $key=>$value) {
			$userBean = BeanFactory::getBean('Users', $value);
			if (!empty($userBean)) {
				$userEmail = $userBean->getUsersNameAndEmail();
				$validUserMail = (asol_CommonUtils::isDomainsInstalled()) ? (($userEmail['email'] != "") && (($userBean->asol_domain_id == $domainId) || $userBean->is_admin)) : ($userEmail['email'] != "");
				if ($validUserMail) {
					$reportMailer->AddBCC($userEmail['email']);
				}
			}
		}
		foreach($emailArray['roles_bcc'] as $key => $value) {
			$usersFromRole = Array();
			if (asol_CommonUtils::isDomainsInstalled()) {
				$usersFromRoleSql = "SELECT acl_roles_users.user_id FROM acl_roles_users LEFT JOIN users ON acl_roles_users.user_id=users.id WHERE acl_roles_users.role_id = '".$value."' AND users.deleted=0 AND users.asol_domain_id='".$domainId."'";
			} else {
				$usersFromRoleSql = "SELECT user_id FROM acl_roles_users WHERE role_id = '".$value."'";
			}
			$usersFromRoleRs = $db->query($usersFromRoleSql);
			while($userFromRole_Row = $db->fetchByAssoc($usersFromRoleRs))
				$usersFromRole[] = $userFromRole_Row['user_id'];
			foreach($usersFromRole as $key=>$value) {
				$userEmail = BeanFactory::getBean('Users', $value)->getUsersNameAndEmail();
				if ($userEmail['email'] != "") {
					$reportMailer->AddBCC($userEmail['email']);
				}
			}
		}
		foreach ($emailArray['emails_bcc'] as $key=>$value){
			if ($value != "") {
				$reportMailer->AddBCC($value);
			}
		}
		
	}
	
	public static function getSendEmailAlert($emailList, $contextDomainId = null) {
	
		global $mod_strings, $db, $current_user;
		

		if (asol_CommonUtils::isDomainsInstalled()) {
			$domainId = ($contextDomainId != null) ? $contextDomainId : $current_user->asol_default_domain;
		}
		
		$emailInfo = self::getEmailInfo($emailList);
		$emailInfoArray = $emailInfo['emailArrays'];
		
		$sendEmailquestion = $mod_strings['MSG_REPORT_SEND_EMAIL_ALERT'].'\n\n';
		
		if (!empty($emailInfoArray['users_to'][0])) {
			$usersToAux = array();
			if (asol_CommonUtils::isDomainsInstalled())
				$usersToQuery = $db->query("SELECT id, user_name FROM users WHERE id IN('".implode("','", $emailInfoArray['users_to'])."') AND ((asol_domain_id = '".$domainId."') OR (is_admin = 1))");
			else
				$usersToQuery = $db->query("SELECT id, user_name FROM users WHERE id IN('".implode("','", $emailInfoArray['users_to'])."')");
			while ($usersToRow = $db->fetchByAssoc($usersToQuery))
				$usersToAux[] = $usersToRow['user_name'];
			
			if (!empty($usersToAux))
				$sendEmailquestion .= 'Users To: '.implode(', ', $usersToAux).'\n';
		}
		
		if (!empty($emailInfoArray['users_cc'][0])) {
			$usersCcAux = array();
			if (asol_CommonUtils::isDomainsInstalled())
				$usersCcQuery = $db->query("SELECT id, user_name FROM users WHERE id IN('".implode("','", $emailInfoArray['users_cc'])."') AND ((asol_domain_id = '".$domainId."') OR (is_admin = 1))");
			else
				$usersCcQuery = $db->query("SELECT id, user_name FROM users WHERE id IN('".implode("','", $emailInfoArray['users_cc'])."')");
			while ($usersCcRow = $db->fetchByAssoc($usersCcQuery))
				$usersCcAux[] = $usersCcRow['user_name'];
				
			if (!empty($usersCcAux))
				$sendEmailquestion .= 'Users CC: '.implode(', ', $usersCcAux).'\n';
		}
		
		if (!empty($emailInfoArray['users_bcc'][0])) {
			$usersBccAux = array();
			if (asol_CommonUtils::isDomainsInstalled())
				$usersBccQuery = $db->query("SELECT id, user_name FROM users WHERE id IN('".implode("','", $emailInfoArray['users_bcc'])."') AND ((asol_domain_id = '".$domainId."') OR (is_admin = 1))");
			else
				$usersBccQuery = $db->query("SELECT id, user_name FROM users WHERE id IN('".implode("','", $emailInfoArray['users_bcc'])."')");
			while ($usersBccRow = $db->fetchByAssoc($usersBccQuery))
				$usersBccAux[] = $usersBccRow['user_name'];
			
			if (!empty($usersBccAux))
				$sendEmailquestion .= 'Users BCC: '.implode(', ', $usersBccAux).'\n\n';
		}
		
		if (!empty($emailInfoArray['roles_to'][0])) {
			$rolesToAux = array();
			if (asol_CommonUtils::isDomainsInstalled())
				$rolesToQuery = $db->query("SELECT Role.name as name FROM acl_roles Role LEFT JOIN asol_domains_aclroles RoleDomain ON (Role.id=RoleDomain.aclrole_id) WHERE Role.id IN('".implode("','", $emailInfoArray['roles_to'])."') AND RoleDomain.asol_domain_id = '".$domainId."'");
			else
				$rolesToQuery = $db->query("SELECT name FROM acl_roles WHERE id IN('".implode("','", $emailInfoArray['roles_to'])."')");
			while ($rolesToRow = $db->fetchByAssoc($rolesToQuery))
				$rolesToAux[] = $rolesToRow['name'];
				
			if (!empty($rolesToAux))
				$sendEmailquestion .= 'Roles To: '.implode(', ', $rolesToAux).'\n';
		}
		
		if (!empty($emailInfoArray['roles_cc'][0])) {
			$rolesCcAux = array();
			if (asol_CommonUtils::isDomainsInstalled())
				$rolesCcQuery = $db->query("SELECT Role.name as name FROM acl_roles Role LEFT JOIN asol_domains_aclroles RoleDomain ON (Role.id=RoleDomain.aclrole_id) WHERE Role.id IN('".implode("','", $emailInfoArray['roles_cc'])."') AND RoleDomain.asol_domain_id = '".$domainId."'");
			else
				$rolesCcQuery = $db->query("SELECT name FROM acl_roles WHERE id IN('".implode("','", $emailInfoArray['roles_cc'])."')");
			while ($rolesCcRow = $db->fetchByAssoc($rolesCcQuery))
				$rolesCcAux[] = $rolesCcRow['name'];
			
			if (!empty($rolesCcAux))
				$sendEmailquestion .= 'Roles CC: '.implode(', ', $rolesCcAux).'\n';
		}
		
		if (!empty($emailInfoArray['roles_bcc'][0])) {
			$rolesBccAux = array();
			if (asol_CommonUtils::isDomainsInstalled())
				$rolesBccQuery = $db->query("SELECT Role.name as name FROM acl_roles Role LEFT JOIN asol_domains_aclroles RoleDomain ON (Role.id=RoleDomain.aclrole_id) WHERE Role.id IN('".implode("','", $emailInfoArray['roles_bcc'])."') AND RoleDomain.asol_domain_id = '".$domainId."'");
			else
				$rolesBccQuery = $db->query("SELECT name FROM acl_roles WHERE id IN('".implode("','", $emailInfoArray['roles_bcc'])."')");
			while ($rolesBccRow = $db->fetchByAssoc($rolesBccQuery))
				$rolesBccAux[] = $rolesBccRow['name'];
			
			if (!empty($rolesBccAux))
				$sendEmailquestion .= 'Roles BCC: '.implode(', ', $rolesBccAux).'\n\n';
		}
		
		$sendEmailquestion .= (!empty($emailInfoArray['emails_to'][0])) ? 'Emails To: '.implode(', ', $emailInfoArray['emails_to']).'\n' : '';
		$sendEmailquestion .= (!empty($emailInfoArray['emails_cc'][0])) ? 'Emails CC: '.implode(', ', $emailInfoArray['emails_cc']).'\n' : '';
		$sendEmailquestion .= (!empty($emailInfoArray['emails_bcc'][0])) ? 'Emails BCC: '.implode(', ', $emailInfoArray['emails_bcc']) : '';
			
		return $sendEmailquestion;
		
	}
	
	
	public static function cleanDataBaseReportDispatcher() {
			
		global $db, $sugar_config;
		
		if (asol_ReportsUtils::dispatcherTableExists()) {
	
			$currentTime = time();
			
			$checkHttpFileTimeout = (isset($sugar_config["asolReportsCheckHttpFileTimeout"])) ? $sugar_config["asolReportsCheckHttpFileTimeout"] : "1000";
			$timedOutStamp = $currentTime - $sugar_config['asolReportsMaxExecutionTime']; //Time to check report execution expiration time
			$closedWindowStamp = $currentTime - ($checkHttpFileTimeout / 500);  //Time to check last recall not updated for manual Reports (browser screen closed). 
			
			$cleanDispatcherTableSql = "DELETE FROM asol_reports_dispatcher WHERE (status IN ('terminated', 'timeout')) OR (request_init_date < '".date("Y-m-d H:i:s", $timedOutStamp)."') OR ((status = 'waiting') AND (request_type = 'manual') AND (last_recall < '".date("Y-m-d H:i:s", $closedWindowStamp)."'))";
			$db->query($cleanDispatcherTableSql);
			
		}
		
	}
	
	
	public static function manageReportExternalDispatcher($dispatcherMaxRequests) {
	
		global $db, $sugar_config;
		
		if ($dispatcherMaxRequests > 0) {
			
			$_REQUEST["reportRequestId"] = $requestId;
			
			$waitForReport = false;
			
			$curlRequestedUrl = (isset($sugar_config["asolReportsCurlRequestUrl"]) ? $sugar_config["asolReportsCurlRequestUrl"].'/': '')."index.php?entryPoint=viewReport&module=asol_Reports&sourceCall=external&record=".$reportId."&external_filters=".$external_filters."&language=".$_REQUEST['language'];
				
			$requestId = create_guid();
			$currentGMTTime = time();
			$currentGMTDate = date('Y-m-d H:i:s', $currentGMTTime);
			
			$reportRequestId = "&reportRequestId=".$requestId;
			$curlRequestedUrl .= $reportRequestId;			
			$curlRequestedUrl .= "&initRequestDateTimeStamp=".$currentGMTTime;
			
			
			//******************************************************//
			//***This requested parameters must be sent with curl***//
			//******************************************************//
			if (!isset($_REQUEST["reportRequestId"]))
				$_REQUEST["reportRequestId"] = $requestId;
			if (!isset($_REQUEST["initRequestDateTimeStamp"]))
				$_REQUEST["initRequestDateTimeStamp"] = $currentGMTTime;
			//******************************************************//
			//***This requested parameters must be sent with curl***//
			//******************************************************//
				
			asol_ReportsUtils::reports_log('asol', 'Reporting Queue Feature Enabled', __FILE__, __METHOD__, __LINE__);
				
			$reportsDispatcherSql = "SELECT COUNT(DISTINCT id) as 'reportsThreads' FROM asol_reports_dispatcher WHERE status = 'executing'";
			$reportsDispatcherRs = $db->query($reportsDispatcherSql);
			$reportsDispatcherRow = $db->fetchByAssoc($reportsDispatcherRs);
			
			$currentReportsRunningThreads = $reportsDispatcherRow["reportsThreads"];

			$waitForReport = ($currentReportsRunningThreads >= $dispatcherMaxRequests);
			$dispatcherReportSql = "INSERT INTO asol_reports_dispatcher VALUES ('".$requestId."', '".$reportId."', '".$curlRequestedUrl."', '".($waitForReport ? 'waiting' : 'executing')."', '".$currentGMTDate."', '".$currentGMTDate."', 'external', '".$currentUserId."', NULL)";
			$db->query($dispatcherReportSql);
			
			
			$checkHttpFileTimeout = (isset($sugar_config["asolReportsCheckHttpFileTimeout"])) ? $sugar_config["asolReportsCheckHttpFileTimeout"] : "1000";
			$micro_seconds = $checkHttpFileTimeout * 1000;
			
			if ($waitForReport) {
				
				$isInReadyArray = false;
				
				while (($currentReportsRunningThreads >= $dispatcherMaxRequests) && (!$isInReadyArray)) {
					
					usleep($micro_seconds);
					
					$initGMTTime = $_REQUEST["initRequestDateTimeStamp"];
					$recallGMTTime = time();
					$recallGMTDate = date('Y-m-d H:i:s', $recallGMTTime);
					
					
					//Check Max Report Execution time
					$runningTimeSeconds = $recallGMTTime - $initGMTTime;
					asol_ReportsUtils::reports_log('debug', 'Running Time: '.$runningTimeSeconds, __FILE__, __METHOD__, __LINE__);
					
					
					if ($runningTimeSeconds > $sugar_config['asolReportsMaxExecutionTime']) {
				
						asol_ReportsUtils::reports_log('asol', 'Report with Id ['.$reportId.'] has TimedOut!!', __FILE__, __METHOD__, __LINE__);
							
						$sqlExecutingStatus = "UPDATE asol_reports_dispatcher SET last_recall='".$recallGMTDate."', status = 'timeout' WHERE id='".$_REQUEST["reportRequestId"]."' LIMIT 1";
						$db->query($sqlExecutingStatus);
						die($mod_strings['LBL_REPORT_TIMEOUT']);
						
					}
					//Check Max Report Execution time
					
		
					$reportsDispatcherSql = "SELECT COUNT(DISTINCT id) as 'reportsThreads' FROM asol_reports_dispatcher WHERE status = 'executing'";
					$reportsDispatcherRs = $db->query($reportsDispatcherSql);
					$reportsDispatcherRow = $db->fetchByAssoc($reportsDispatcherRs);
					
					$currentReportsRunningThreads = $reportsDispatcherRow["reportsThreads"];
					
					$sqlLastRecall = "UPDATE asol_reports_dispatcher SET last_recall='".$recallGMTDate."' WHERE id='".$_REQUEST["reportRequestId"]."' LIMIT 1";
					$db->query($sqlLastRecall);
					
					//Check if Report is ready to Run (order by time ascending)
					if ($currentReportsRunningThreads < $dispatcherMaxRequests) {
					
						$availableReportThreads = $dispatcherMaxRequests - $currentReportsRunningThreads;
						
						$sqlWaitingReports = "SELECT id FROM asol_reports_dispatcher WHERE status = 'waiting' ORDER BY request_init_date ASC LIMIT ".$availableReportThreads;
						$rsWaitingReports = $db->query($sqlWaitingReports);
						
						$firtReports = array();
						
						while($row = $db->fetchByAssoc($rsWaitingReports))
							$firtReports[] = $row['id'];
						//Check if Report is ready to Run (order by time ascending)
						
						if (in_array($_REQUEST["reportRequestId"], $firtReports))
							$isInReadyArray = true;
					
					}
							
				}
				
				$sqlSetExecuting = "UPDATE asol_reports_dispatcher SET status = 'executing' WHERE id='".$_REQUEST["reportRequestId"]."' LIMIT 1";
				$db->query($sqlSetExecuting);
				
			}
	
		}
			
	}
	
	
	public static function getExternalRequestParams() {
					
		global $current_user, $current_language, $mod_strings;
		
		//Get language from url request parameter
		if (isset($_REQUEST['language']) && !empty($_REQUEST['language'])) {
			
			$current_language = $_REQUEST['language'];
			$mod_strings = return_module_language($current_language, "asol_Reports");
		
		}
		
		//Check if current user is setted on request
		if (isset($_REQUEST['currentUserId']) && !empty($_REQUEST['currentUserId'])) {
			
			$current_user = BeanFactory::getBean('Users', $_REQUEST['currentUserId']);

		}
		
		return array (
			"current_language" => $current_language,
			"mod_strings" => $mod_strings,
			"current_user" => $current_user
		);
	
	}
	
	public static function getCurrentConfig($userId) {

		global $sugar_config;
		
		require_once("modules/asol_Common/include/commonUtils.php");
		$userConfiguration = asol_CommonUtils::getUserConfiguration($userId);
		$globalConfiguration = asol_CommonUtils::getGlobalConfiguration();
		$fiscalMonthInit = $userConfiguration['fiscalMonthInit'];
		$entriesPerPage = (!empty($userConfiguration['entriesPerPage'])) ? $userConfiguration['entriesPerPage'] : (isset($sugar_config['asolOverrideDefaultEntriesPerPage']) ? $sugar_config['asolOverrideDefaultEntriesPerPage'] : 15);
		$pdfOrientation = $userConfiguration['pdfOrientation'];
		$pdf_pageFormat = $userConfiguration['pdfPageFormat'];
		$weekStartsOn = $userConfiguration['weekStartsOn'];
		$pdfImgScalingFactor = $userConfiguration['pdfImgScalingFactor'];
		
		$storedFilesTtl = (!empty($globalConfiguration['storedFilesTtl'])) ? $globalConfiguration['storedFilesTtl'] : '7';
		$hostName = $globalConfiguration['hostName'];
		
		return array(
			"quarter_month" => $fiscalMonthInit,
			"entriesPerPage" => $entriesPerPage,
			"pdf_orientation" => $pdfOrientation,
			"week_start" => $weekStartsOn,
			"pdf_img_scaling_factor" => $pdfImgScalingFactor,
			"scheduled_files_ttl" => $storedFilesTtl,
			"host_name" => $hostName,
			"pdf_pageFormat"=>$pdf_pageFormat
		);
		
	}
				
	public static function doFinalExecuteReportActions($reportId, $initialTimestamp, $dispatcherMaxRequests = null) {
			
		global $db;
		
		if (isset($dispatcherMaxRequests)) {
		
			if (($dispatcherMaxRequests > 0) && (isset($_REQUEST["reportRequestId"]))) { //Only if dispatcher is activated
				$db->query("UPDATE asol_reports_dispatcher SET status = 'terminated', last_recall = '".date("Y-m-d H:i:s", time())."' WHERE id = '".$_REQUEST["reportRequestId"]."' LIMIT 1");
			}	
				
		}
		
		if (!empty($reportId)) {
		
			$db->query("UPDATE asol_reports SET last_run = '".gmdate("Y-m-d H:i:s")."' WHERE id = '".$reportId."' LIMIT 1");			
			asol_ReportsUtils::reports_log('asol', 'Updated last_run for Report with Id ['.$reportId.']. Total Execution time: '.round(microtime(true) - $initialTimestamp, 3).'s (SQL/Api Execution time: '.round(asol_Reports::$elapsed_time, 3).'s)', __FILE__, __METHOD__, __LINE__);
		
		}
		
	}
					
	
	public static function getStandByReportHtml($dashletId, $waitForReport) {
		
		global $mod_strings;
		
		$returnHtml .= '
		<body>
			<div id="reportDiv" class="alineasol_reports">
			</div>
		</body>';
		
		return $returnHtml;
			    
	}
	
	
	public static function getSetUpInputCalendarsScriptFunction($dashletId,$reportId, $filtersArrayData) {
		
		global $timedate;
		
		$hasDateFilters = false;
		$returnedHTML = "function setUpUserInputCalendars_".str_replace("-", "", $reportId)."() {";
			
		foreach ($filtersArrayData as $oneFilterValues) {

			if ((in_array($oneFilterValues['type'], array("date", "datetime", "datetimecombo", "timestamp"))) && ($oneFilterValues['behavior'] == "user_input") && (!empty($oneFilterValues['filterReference']))) {	
						 		
				if (in_array($oneFilterValues['operator'], array("equals", "not equals", "before date", "after date", "between", "not between")))
					$returnedHTML .= "asolCalendar.initialize('detailContainer".$dashletId."','".$oneFilterValues['filterReference']."_1',null);";
					
				if (in_array($oneFilterValues['operator'], array("between", "not between")))
					$returnedHTML .= "asolCalendar.initialize('detailContainer".$dashletId."','".$oneFilterValues['filterReference']."_2',null);";
					
				$hasDateFilters = true;
					
			}
						 		
		}
		
		$returnedHTML .= "}";
		
		return ($hasDateFilters ? $returnedHTML : null);
		
	}
	
	
	public static function getLoadCurrentDashletScriptFunction($reportId, $isDashlet, $dashletId, $getLibraries, $staticFilters, $overrideEntries, $currentUserId) {
				
		global $current_user, $sugar_config;
		
		$isPreview = ((isset($_REQUEST['isPreview'])) && ($_REQUEST['isPreview'] == 'true'));
		$fixedDashletId = str_replace("-", "", $dashletId);
		
		return '
		function reloadCurrentDashletReport'.$fixedDashletId.'(buttonRef, refresh, pageNumber, sortField, sortDirection, sortIndex, externalParams, staticFilters) {

			var postParameters = new Object();
			var isMetaReport = ((typeof window.hasPremiumReportsJsFeatures == "function") && ($(buttonRef).closest("#metaReportExecution").length > 0));

			var mainReportSelector = (isMetaReport ? "'.($isDashlet ? '[id=\'detailContainer\'].'.$dashletId : '[id=\'detailContainer\']').'" : "'.($isDashlet ? '[id=\'detailContainer'.$dashletId.'\']' : '[id=\'detailContainer\']').'");
			var pushedReportsSelector = (isMetaReport ? "[pushed=\''.$dashletId.'\']" : null);

			var isMainSelectorBlocked = $("div"+mainReportSelector).data("blockUI.isBlocked") == 1; 		
			if (!isMainSelectorBlocked) {
				$("div"+mainReportSelector).block({ message: reportsApi.getBlockingMessage("load") });
			}
			if (pushedReportsSelector != null) {
				var isPushedSelectorBlocked = $("div"+pushedReportsSelector).data("blockUI.isBlocked") == 1;
				if (!isPushedSelectorBlocked) { 		
					$("div"+pushedReportsSelector).block({ message: reportsApi.getBlockingMessage("load") });
				}
			}
		
			var multiExecution = (isMetaReport ? $("div"+pushedReportsSelector).length > 0 : false);		

			postParameters["entryPoint"] = "viewReport";
			postParameters["module"] = "asol_Reports";
			postParameters["record"] = "'.$reportId.'";
			postParameters["isPreview"] = "'.($isPreview ? 'true':  'false').'";
			postParameters["currentUserId"] = "'.$currentUserId.'";
			postParameters["dashlet"] = "'.($isDashlet ? 'true' : 'false').'";
			postParameters["dashletId"] = "'.$dashletId.'";
			postParameters["getLibraries"] = "false";
									
			postParameters["page_number"] = pageNumber;
			postParameters["sort_field"] = sortField;
			postParameters["sort_direction"] = sortDirection;
			postParameters["sort_index"] = sortIndex;
			
			if (!refresh) {
				postParameters["search_criteria"] = "1";
				postParameters["external_filters"] = encodeURIComponent(formatExternalFilters("'.$dashletId.'"));
			}
					
			if ((externalParams != null) && (externalParams != "")) {
				externalParams.substring(1).split("&").forEach(function(currentParam) {
					var splittedParam = currentParam.split("=");
					postParameters[splittedParam[0]] = splittedParam[1];
				});
			}
			if ((staticFilters != null) && (staticFilters != "")) {
				postParameters["staticFilters"] = staticFilters;
			}
			if ((typeof window.hasPremiumReportsJsFeatures == "function") && (isMetaReport)) {
				postParameters["overrideInfo"] = getMetaReportInfo("'.$dashletId.'");
				postParameters["overrideFilters"] = getMetaReportFilters("'.$dashletId.'");
			}		
			if ((typeof window.hasPremiumReportsJsFeatures == "function") && (isMetaReport && multiExecution)) {
				var multiExecutionData = getMultiExecutionData(pushedReportsSelector, "'.$dashletId.'");
				postParameters["multiExecution"] = "true";
				postParameters["pushedRecords"] = multiExecutionData["pushedRecords"];
				postParameters["pushedInfos"] = multiExecutionData["pushedInfos"];
				postParameters["pushedFilters"] = multiExecutionData["pushedFilters"];
			}

			postParameters["previewDatabase"] = '.(isset($_REQUEST['previewDatabase']) && $_REQUEST['previewDatabase'] !== '' ? '"'.$_REQUEST['previewDatabase'].'"' : '""').';
			postParameters["previewAudit"] = '.(isset($_REQUEST['previewAudit']) && $_REQUEST['previewAudit'] !== "" ? '"'.$_REQUEST['previewAudit'].'"' : '""').';
			postParameters["previewModule"] = '.(isset($_REQUEST['previewModule']) && !empty($_REQUEST['previewModule']) ? '"'.$_REQUEST['previewModule'].'"' : '""').';
			postParameters["previewDynamicTables"] = '.(isset($_REQUEST['previewDynamicTables']) && $_REQUEST['previewDynamicTables'] !== '' ? '"'.$_REQUEST['previewDynamicTables'].'"' : '""').';
			postParameters["previewDynamicSql"] = '.(isset($_REQUEST['previewDynamicSql']) && !empty($_REQUEST['previewDynamicSql']) ? '"'.$_REQUEST['previewDynamicSql'].'"' : '""').';
			postParameters["previewName"] = '.(isset($_REQUEST['previewName']) && !empty($_REQUEST['previewName']) ? '"'.$_REQUEST['previewName'].'"' : '""').';
			postParameters["previewDisplay"] = '.(isset($_REQUEST['previewDisplay']) && !empty($_REQUEST['previewDisplay']) ? '"'.$_REQUEST['previewDisplay'].'"' : '""').';
			postParameters["previewChartsEngine"] = '.(isset($_REQUEST['previewChartsEngine']) && !empty($_REQUEST['previewChartsEngine']) ? '"'.$_REQUEST['previewChartsEngine'].'"' : '""').';
			postParameters["previewIndexDisplay"] = '.(isset($_REQUEST['previewIndexDisplay']) && $_REQUEST['previewIndexDisplay'] !== '' ? '"'.$_REQUEST['previewIndexDisplay'].'"' : '""').';
			postParameters["previewResultsLimit"] = '.(isset($_REQUEST['previewResultsLimit']) && !empty($_REQUEST['previewResultsLimit']) ? '"'.$_REQUEST['previewResultsLimit'].'"' : '""').';
			postParameters["previewDescription"] = '.(isset($_REQUEST['previewDescription']) && !empty($_REQUEST['previewDescription']) ? '"'.$_REQUEST['previewDescription'].'"' : '""').';
			postParameters["previewFields"] = '.(isset($_REQUEST['previewFields']) && !empty($_REQUEST['previewFields']) ? '"'.$_REQUEST['previewFields'].'"' : '""').';
			postParameters["previewFilters"] = '.(isset($_REQUEST['previewFilters']) && !empty($_REQUEST['previewFilters']) ? '"'.$_REQUEST['previewFilters'].'"' : '""').';
			postParameters["previewCharts"] = '.(isset($_REQUEST['previewCharts']) && !empty($_REQUEST['previewCharts']) ? '"'.$_REQUEST['previewCharts'].'"' : '""').';
			
			$.post("index.php", postParameters).done(function(data) {
				if (isMetaReport) {
		        	reloadMetaReport(multiExecution, data, mainReportSelector, pushedReportsSelector);
		        } else {
					'.($isDashlet ? '$("div"+mainReportSelector).html(data);' : '$("div"+mainReportSelector).replaceWith(data)').'
					asolFancyMultiEnum.generate($(".asolFirstParameter select"), 3, true);
					asolFancyMultiEnum.generate($(".asolSecondParameter select"), 3, true);
					asolFancyMultiEnum.generate($(".asolThirdParameter select"), 3, true);
					if (typeof $.blockUI !== "undefined") {
						$("div"+mainReportSelector).unblock();
					}
					'.self::getAttachedScript2ExecuteCriteriaOnKeyPressed($dashletId).'
							
					$("div"+mainReportSelector).find(".asolChartScript[proccess=\'1\']").each(function() {
			    		eval(decodeURIComponent($(this).val()));
					});
					$("div"+mainReportSelector).find(".asolChartScript").attr("proccess", "0");
							
					'.self::getReportsCallbackFuntion().'
				}
			});
			
		}
							
		function loadCurrentDashletReport'.$fixedDashletId.'(refresh) {
				
			refresh = (typeof refresh !== "undefined" ? refresh : false);
				
			var currentPage = ($("#page_number_'.$fixedDashletId.'").val() ? $("#page_number_'.$fixedDashletId.'").val() : "");
			var currentSortField = ($("#sort_field_'.$fixedDashletId.'").val() ? $("#sort_field_'.$fixedDashletId.'").val() : "");
			var currentSortDirection = ($("#sort_direction_'.$fixedDashletId.'").val() ? $("#sort_direction_'.$fixedDashletId.'").val() : "");
			var currentSortIndex = ($("#sort_index_'.$fixedDashletId.'").val() ? $("#sort_index_'.$fixedDashletId.'").val() : "");
			var externalFilters = (typeof formatExternalFilters !== "undefined" ? encodeURIComponent(formatExternalFilters("'.$dashletId.'")) : "");
			var reloadReport = function(){ controllerReportDetail.reloadReport(this, "'.$reportId.'", refresh, {"dashlet":'.($isDashlet ? 'true' : 'false').', "dashletId":"'.$dashletId.'", "isPreview":"'.($isPreview ? 'true' : 'false').'", "page_number":currentPage, "sort_field":currentSortField, "sort_direction":currentSortDirection, "sort_index":currentSortIndex, "overrideEntries":"'.$overrideEntries.'", "external_filters":externalFilters, "staticFilters":"'.$staticFilters.'"}) }; 

			if (typeof reportsWait != "undefined") {
				reportsWait.wait(reloadReport);
			} else {
				reloadReport();
			}
		}';
	
	}
	
	private static function getReportsCallbackFuntion() {
		
		return '
		if (typeof alineaSolReportsCallback == "function") {
			alineaSolReportsCallback();
		}
		';
		
	}
	
	private static function getAttachedScript2ExecuteCriteriaOnKeyPressed($dashletId) {
		
		return
		'if ($("#detailContainer'.$dashletId.'").find("#search_criteria input").size() > 0) {
		    $("#detailContainer'.$dashletId.'").find("#search_criteria input").unbind("keypress").bind("keypress", function (e){
		        if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
		            $("#detailContainer'.$dashletId.'").find(".executeReportBtn").get(0).click();
		        }
		    });
		}';
		
	}
	
	public static function getSendAjaxRequestScriptFunction($reportId, $dashletId, $checkHttpFileTimeout, $httpHtmlFile, $reportRequestId, $initRequestTimeStamp, $hasCalendarInputs) {
		
		global $sugar_config, $mod_strings;
		
		$fixedReportId = str_replace("-", "", $reportId);
		$fixedDashletId = str_replace("-", "", $dashletId);
		
		return '
		function sendAjaxRequest_'.$fixedReportId.'(shortTerm, firstLoad) {
		
			shortTerm = (typeof shortTerm != "undefined" ? shortTerm : false);
			firstLoad = (typeof firstLoad != "undefined" ? firstLoad : false);
			var checkHttpFileTimeout = (firstLoad ? '.($checkHttpFileTimeout / 2).' : '.$checkHttpFileTimeout.');
			
			$(function () {
	
				if (shortTerm) {

					window["loadCurrentDashletReport'.$fixedDashletId.'"](true);
					
				} else {
						
					$.ajax({
				        type: "POST",
						url: \'index.php?entryPoint=asolReportsApi&module=asol_Reports&actionTarget=check_report&httpHtmlFile='.$httpHtmlFile.$reportRequestId.$initRequestTimeStamp.'\',
						async: true,
				        cache: false,
				        success: function(data) {
				        
				        	data = data.replace(/^\s+/g,\'\').replace(/\s+$/g,\'\'); //Trim equivalent PHP function
				        
				        	if (data.substring(0, 5) == "false") {
				        		
				        		setTimeout("sendAjaxRequest_'.$fixedReportId.'(false)", checkHttpFileTimeout);
				        	
							} else if (data.substring(0, 4) == "exec") {
							
								$("#loadingText").html("'.$mod_strings['LBL_REPORT_LOADING'].'");
								setTimeout("sendAjaxRequest_'.$fixedReportId.'(false)", checkHttpFileTimeout);
							
							} else if (data.substring(0, 7) == "timeout") {
							
								$("#detailContainer'.$dashletId.'").html("'.$mod_strings['LBL_REPORT_TIMEOUT'].'");
							
							} else {
			
								if (typeof window.blockUI == "function") {
									$.unblockUI();
								}
								
					            $("#detailContainer'.$dashletId.' .asolReportExecution").html(data);
					            '.self::getAttachedScript2ExecuteCriteriaOnKeyPressed($dashletId).'
	
					            $("#detailContainer'.$dashletId.'").find(".asolChartScript[proccess=\'1\']").each(function() {
						    		eval(decodeURIComponent($(this).val()));
								});
					           	$("#detailContainer'.$dashletId.'").find(".asolChartScript").attr("proccess", "0");
					           			
				        		'.self::getReportsCallbackFuntion().'
					           	'.($hasCalendarInputs ? 'setUpUserInputCalendars_'.$fixedReportId.'();' : '').'
				        		
				            }
				            	
						}
					           			
				    });
					           			
				}
	
			}); 
		
		}';
		
	}
	
	public static function getInitialAjaxRequest2GenerateReportScript($reportId, $shortTermExecution = false) {
		
		return '
		if (typeof window.SUGAR.util.doWhen == \'function\') {

			SUGAR.util.doWhen(function(){ return (typeof $ != \'undefined\')}, function(){
				sendAjaxRequest_'.str_replace("-", "", $reportId).'('.($shortTermExecution ? 'true' : 'false').', true);
			});
			
		} else {
		
			$(document).ready(function() {
				sendAjaxRequest_'.str_replace("-", "", $reportId).'('.($shortTermExecution ? 'true' : 'false').', true);
			});
			
		}';
		
	} 
				
	public static function getStoredReportData($storedData, $reportId, $isDashlet, $dashletId, $reportType) {
				
		global $sugar_config;
		
		$storedData = (empty($storedData)) ? 'false' : $storedData;		
		$storedUrl = 'index.php?entryPoint=scheduledStoredReport&module=asol_Reports&storedReportInfo='.$storedData;
		
		if ($isDashlet) {
			$storedUrl .= '&dashlet=true&dashletId='.$dashletId;
		}
			
		$returnedHtml = '<head>
		
			<script type="text/javascript">
		
			if (typeof window.blockUI == "function")
				blockUI();
			
			function sendAjaxRequest_'.str_replace("-", "", $reportId).'() {
			
				$(function () { 
				    $.ajax({
				        type: "POST",
				        url: "'.$storedUrl.'",
				        async: true,
				        cache: false,
				        success: function (data) {
				        	
							$("#detailContainer'.$dashletId.'").html(data);
							asolFancyMultiEnum.generate($(".asolFirstParameter select"), 3, true);
							asolFancyMultiEnum.generate($(".asolSecondParameter select"), 3, true);
							asolFancyMultiEnum.generate($(".asolThirdParameter select"), 3, true);
				        	'.self::getAttachedScript2ExecuteCriteriaOnKeyPressed($dashletId).'
				        	
				        	$("#detailContainer'.$dashletId.'").find(".asolChartScript[proccess=\'1\']").each(function() {
					    		eval(decodeURIComponent($(this).val()));
							});
				        	$("#detailContainer'.$dashletId.'").find(".asolChartScript").attr("proccess", "0");
							
				        	'.self::getReportsCallbackFuntion().'
									
						}		
				    });
				});
				
			}
	
			</script>
			
			<script type="text/javascript">
		
				if(typeof window.SUGAR.util.doWhen == \'function\') {
		
					SUGAR.util.doWhen(function(){ return (typeof $ != \'undefined\')}, function(){
						sendAjaxRequest_'.str_replace("-", "", $reportId).'();
					});
					
				} else {
					$(document).ready(function() {
						sendAjaxRequest_'.str_replace("-", "", $reportId).'();
					});
					
				}
			</script>';
	
		$returnedHtml .= '
		</head>';
		
		
		
		if (!$isDashlet) {
		
			$returnedHtml .= self::getStandByReportHtml($dashletId, false);
			$returnedHtml .= '</html>';
		
		}
	
		return $returnedHtml;
		
	}
			
	
	public static function overrideExternalReportVariables($created_by) {
	
		global $sugar_config;
		
		$theUser = new User();
	
		if ((isset($_REQUEST['schedulerCall'])) && ($_REQUEST['schedulerCall'] == "true")) {
			
			$theUser->retrieve($created_by);
			
			$current_user = $theUser;
			$allowExportGeneratedFile = true;
			$schedulerCall = true;
			
		} else {
	
			$userId = (isset($sugar_config["BSS_Admin_WebService_User_Id"]) ? $sugar_config["BSS_Admin_WebService_User_Id"] : $created_by);
			$theUser->retrieve($userId); 
			
			$current_user = $theUser;
			$allowExportGeneratedFile = false;
			$schedulerCall = false;
			
		}
		
		$theUser->getUserDateTimePreferences();
		$userPrefs = $theUser->getUserDateTimePreferences();
		
		$externalUserDateFormat = $userPrefs["date"];
		$externalUserDateTimeFormat = $userPrefs["date"]." ".$userPrefs["time"];
			
		return array(
			"theUser" => $theUser,
			"current_user" => $current_user,
			
			"allowExportGeneratedFile" => $allowExportGeneratedFile,
			"schedulerCall" => $schedulerCall,
			
			"externalUserDateFormat" => $externalUserDateFormat,
			"externalUserDateTimeFormat" => $externalUserDateTimeFormat
		);
		
	}
					
	
	public static function manageExternalDatabaseQueries($alternativeDb, $report_module) {

		require_once("modules/asol_Reports/include/server/controllers/controllerQuery.php");
		
		if ($alternativeDb !== false) {

			$domainField = null;
			$useAlternativeDbConnection = true;
	
			$report_table = $report_module;
			$report_table_primary_key = asol_ControllerQuery::getExternalTablePrimaryKey($alternativeDb, $report_table);
			
			
			//***********************//
			//***AlineaSol Premium***//
			//***********************//
			$extraParams = array('database' => $alternativeDb, 'module' => $report_table);
			$domainField = asol_ReportsUtils::managePremiumFeature("externalDatabasesReports", "reportFunctions.php", "getExternalDatabaseDomainField", $extraParams);
			
			$extraParams = array('database' => $alternativeDb);
			$gmtDates = asol_ReportsUtils::managePremiumFeature("externalDatabasesReports", "reportFunctions.php", "getExternalDatabaseGmtDates", $extraParams);
			//***********************//
			//***AlineaSol Premium***//
			//***********************//
				
		} else {

			$useAlternativeDbConnection = false;
			$gmtDates = true;

			$report_table = BeanFactory::newBean(BeanFactory::getObjectName($report_module))->table_name;
			$report_table = ($report_table == false ? BeanFactory::newBean($report_module)->table_name : $report_table);
			$report_table = (empty($report_table) ? strtolower($report_module) : $report_table); 
			$report_table_primary_key = "id";
			
		}
		
		return array(
			"useAlternativeDbConnection" => $useAlternativeDbConnection,
			"domainField" => $domainField,
			"gmtDates" => $gmtDates,
			"report_table" => $report_table,
			"report_table_primary_key" => $report_table_primary_key
		);
		
	}
	
	
	public static function getChartInfoParams($selectedCharts, $auditedReport, $reportTable) {
				
		$stackedAvailableCharts = array('stack', 'horizontal', 'line', 'scatter', 'area', 'bubble', 'parallel');
		
		$hasStackChart = false;
		$chartInfo = array();
		$chartConf = array();
		
		foreach ($selectedCharts['charts'] as $info) {

			$chartData = $info['data'];
			$chartConfig = $info['config'];
			
			if ($chartData['type'] != 'parallel') {
				
				$chartData['yAxis'] = $chartData['yAxis'][0];
				
				//***********************//
				//***AlineaSol Premium***//
				//***********************//
				$extraParams = array(
					'chartData' => $chartData,
				);
				$chartDataSubChart = asol_ReportsUtils::managePremiumFeature("combineReportCharts", "reportFunctions.php", "transformYAxisSubChart", $extraParams);
				if ($chartDataSubChart !== false) {
					$chartData = $chartDataSubChart;
				}
				//***********************//
				//***AlineaSol Premium***//
				//***********************//
			}
			
			if ($auditedReport) {
				$chartData['yAxis'] = (count(explode(".", $chartData['yAxis'])) == 1) ? $reportTable."_audit.".$chartData['yAxis'] : $chartData['yAxis'];
			}
			
			$hasStackChart = (($hasStackChart) || (($chartData['display'] == 'yes') && (in_array($chartData['type'], $stackedAvailableCharts)))) ? true : false;
			
			$chartInfo[] = $chartData;
			$chartConf[] = $chartConfig;
			
		}
		
		return array(
			"hasStackChart" => $hasStackChart,
			"chartInfo" => $chartInfo,
			"chartConfig" => $chartConf
		);
	
	}
	
	public static function buildExternalFilters($externalFilters, $staticFilters, $userDateFormat) {
					
		global $timedate, $current_user;
		
		if (isset($externalFilters)) {
			$externalFilters= str_replace('${nbsp}', " ", urldecode(html_entity_decode($externalFilters, ENT_QUOTES)));
		}
		
		$jsonFilters = json_decode(rawurldecode($externalFilters), true);
		if (isset($jsonFilters)) {
			
			$extFilters = $jsonFilters;
			
		} else {
		
			$extFilters = array();
			$auxFilters = explode('${pipe}', rawurldecode($externalFilters));
				
			foreach ($auxFilters as $auxFilter) {
				
				$filterValues = explode('${dp}', $auxFilter);
				$secondFilterArray = explode('${comma}', $filterValues[3]);
				$hasThirdFilter = (count($secondFilterArray) == 1 ? false : true);
				
				//*****************//
				//***First Input***//
				//****************//
				if ((!$timedate->check_matching_format($filterValues[2], $GLOBALS['timedate']->dbDayFormat)) && ($timedate->check_matching_format($filterValues[2], $userDateFormat)) && ($filterValues[2] != "")) { 
					$filterValues[2] = $timedate->swap_formats($filterValues[2], $userDateFormat, $GLOBALS['timedate']->dbDayFormat );
				}
						
				//******************//
				//***Second Input***//
				//******************//
				if ((!$timedate->check_matching_format($secondFilterArray[0], $GLOBALS['timedate']->dbDayFormat)) && ($timedate->check_matching_format($secondFilterArray[0], $userDateFormat)) && ($secondFilterArray[0]!="")) {
					$secondFilterArray[0] = $timedate->swap_formats($secondFilterArray[0], $userDateFormat, $GLOBALS['timedate']->dbDayFormat );
				}
					
				//*****************//
				//***Third Input***//
				//*****************//
				if ($hasThirdFilter) {
					if ((!$timedate->check_matching_format($secondFilterArray[1], $GLOBALS['timedate']->dbDayFormat)) && ($timedate->check_matching_format($secondFilterArray[1], $userDateFormat)) && ($secondFilterArray[1]!="")) {
						$secondFilterArray[1] = $timedate->swap_formats($secondFilterArray[1], $userDateFormat, $GLOBALS['timedate']->dbDayFormat );
					}
				}
	
				$operator = str_replace('+', ' ', $filterValues[1]);
				
				$firstParameter = (in_array($operator, array('one of', 'not one of')) ? explode('${dollar}', $filterValues[2]) : array($filterValues[2]));
				$secondParameter = array($secondFilterArray[0]);
				$thirdParameter = array($secondFilterArray[1]);
				
				$extFilters[$filterValues[0]] = array(
					'operator' => $operator,
					'parameters' => array(
						'first' => $firstParameter,
						'second' => $secondParameter,
						'third' => $thirdParameter,
					),
				);
				
			}
			
		}
		
		if (isset($staticFilters)) {
	
			foreach ($staticFilters as $reference => $currentFilter) {
				$extFilters[$reference] = array(
					'operator' => str_replace("+", " ", $currentFilter["operator"]),
					'parameters' => array(
						'first' => $currentFilter['parameters']['first'],
						'second' => $currentFilter['parameters']['second'],
						'third' => $currentFilter['parameters']['third'],
					),
				);
			}

		}
		
		unset($extFilters['']);
			
		return $extFilters;
		
	}

	public static function getFilteringParams($data_source, $filters, $extFilters, $search_mode, $layoutConfig, $report_module, $predefinedTemplates, $isMetaSubReport, $dashletId, $userDateFormat, $auditedReport, $reportId, $searchCriteria, $saveSearch) {

		require_once("modules/asol_Common/include/commonUtils.php");
		
		global $current_user, $app_strings, $timedate, $beanList, $beanFiles;

		$avoidAutocomplete = ($filters['config']['avoidAutocomplete'] ? ' autocomplete="off"' : '');
		
		$filtersPanel = array();
		$filtersHiddenInputs = "";
		
		$fixedDashletId = str_replace("-", "", $dashletId);

		//***********************//
		//***AlineaSol Premium***//
		//***********************//
		$saveLastSearchExtraParams = array(
			'extFilters' => $extFilters,
			'saveSearch' =>	$saveSearch,
			'searchCriteria' =>	$searchCriteria,		
			'reportId' => $reportId,
		);
		$results = asol_ReportsUtils::managePremiumFeature("SaveLastSearch", "reportFunctions.php", "saveLastSearch", $saveLastSearchExtraParams);
		if ($results !== false) {
			$extFilters = $results['extFilters'];
			$searchCriteria = $results['searchCriteria'];
		}
		//***********************//
		//***AlineaSol Premium***//
		//***********************//

		
		foreach ($filters['data'] as & $currentFilter) {
				
			if (($currentFilter['apply'] === '0') || !asol_ControllerQuery::propertyApplies($currentFilter['visibilityConfig']['properties']))
				continue;
			
			$filterField = $currentFilter['field'];
			$filterReference = $currentFilter['filterReference'];
			$filterType = $currentFilter['type'];
			$filterBehavior = $currentFilter['behavior'];
			
			$filterUserOptions = $currentFilter['userOptions']['data'];
			$filterEnumOperator = $currentFilter['enumOperator'];
			$filterEnumReference = $currentFilter['enumReference'];
			$filterEnumTemplate = (isset($currentFilter['templates']['enum']) ? $currentFilter['templates']['enum'] : null);
			
			$hasCustomEnum = ((!empty($filterUserOptions)) || (!empty($filterEnumTemplate)));
			if ($hasCustomEnum) {
				//***AlineaSol Premium***//
				$filterUserOptionsResult = asol_ReportsUtils::managePremiumFeature("templatesReports", "reportFunctions.php", "getFilterTemplateUserOptions", array('filterEnumTemplate' => $filterEnumTemplate, 'predefinedEnumTemplates' => $predefinedTemplates['enum']));
				$filterUserOptions = ($filterUserOptionsResult !== false ? $filterUserOptionsResult : (isset($filterUserOptions['data']) ? $filterUserOptions['data'] : $filterUserOptions));
				//***AlineaSol Premium***//	
								
				$customGeneratedDropdownValues = self::getCustomGeneratedDropdownValues($filterUserOptions);
			}
			
			
			//Update filter values with external filters if exists
			if ((!empty($filterReference)) && (!empty($extFilters[$filterReference]))) {
				
				$currentFilter['operator'] = (($extFilters[$filterReference]['operator'] !== '') && ($extFilters[$filterReference]["operator"] !== NULL) ? $extFilters[$filterReference]["operator"] : $currentFilter['operator']);
				$currentFilter['parameters']['first'] = (($extFilters[$filterReference]['parameters']['first'][0] !== '') && ($extFilters[$filterReference]['parameters']['first'][0] !== NULL) ? $extFilters[$filterReference]['parameters']['first'] : $currentFilter['parameters']['first']);
				$currentFilter['parameters']['second'] = (($extFilters[$filterReference]['parameters']['second'][0] !== '') && ($extFilters[$filterReference]['parameters']['second'][0] !== NULL) ? $extFilters[$filterReference]['parameters']['second'] : $currentFilter['parameters']['second']);
				$currentFilter['parameters']['third'] = (($extFilters[$filterReference]['parameters']['third'][0] !== '') && ($extFilters[$filterReference]['parameters']['third'][0] !== NULL) ? $extFilters[$filterReference]['parameters']['third'] : $currentFilter['parameters']['third']);

			}

			$filterOperator = $currentFilter['operator'];
			$filterFirstParameter = $currentFilter['parameters']['first'];
			$filterSecondParameter = $currentFilter['parameters']['second'];
			$filterThirdParameter = $currentFilter['parameters']['third'];

			if (in_array($filterBehavior, array("user_input", "visible"))) {
				
				if ((substr($currentFilter['field'], -2) != 'id') && ($filterType == 'char(36)'))
					$currentFilter['type'] = 'relate';

					
				switch ($filterType) {
					
					case "enum" :
					case "radioenum" :

						$selectedOpts = $currentFilter['parameters']['first'];
	
						//Get dropdown list field
						if (in_array($filterEnumOperator, array('options', 'function'))) {
						
							if (!$hasCustomEnum) {
								$opts = asol_Reports::getEnumValues($data_source, $filterField, $filterEnumOperator, $filterEnumReference);
								$optsLabels = asol_Reports::getEnumLabels($data_source, $filterField, $filterEnumOperator, $filterEnumReference);
							} else { 
								$opts = $customGeneratedDropdownValues['opts'];
								$optsLabels = $customGeneratedDropdownValues['optsLabels'];
							}
							
						}
							
						if ($filterBehavior == "user_input") {
							
							if (in_array($currentFilter['operator'], array("like", "not like", "starts with", "ends with"))) {
								$theInput1 = (!$hasCustomEnum) ? "<input type='text' id='".$filterReference.$fixedDashletId."_1' value='".$selectedOpts[0]."' '.$avoidAutocomplete.'>" : "<select id='".$filterReference."_1'>";
							} else {
								$selectMultiple = (in_array($currentFilter['operator'], array("one of", "not one of"))) ? "multiple size=1" : "";
								$selectStyle = (in_array($currentFilter['operator'], array("one of", "not one of"))) ? "visibility: hidden;" : "";
								$theInput1 = "<select id='".$filterReference.$fixedDashletId."_1' ".$selectMultiple." style='".$selectStyle."'>";
							}

							if ((!in_array($currentFilter['operator'], array("like", "not like", "starts with", "ends with"))) || ($hasCustomEnum)) {
								
								foreach ($opts as $opt) {
									$theInput1 .= "<option value='".$opt."' ".(in_array($opt, $selectedOpts) ? "selected" : "")." title='".$optsLabels[$opt]."'>".$optsLabels[$opt]."</option>";
								}
								
								$theInput1 .= "</select>";
								
							}

						} else if ($filterBehavior == "visible") {
							
							$theInput1 = '<span>';
							
							foreach ($opts as $opt) {
								if (in_array($opt, $selectedOpts))
									$theInput1 .= $optsLabels[$opt]."<br>";
							}
							
							$theInput1 = substr($theInput1, 0, -4);
							
							$theInput1 .= '</span>';
							
						}
						
						$theInput2 = null;
						$theInput3 = null;
						break;
						
					case "multienum" :

						$selectedOpts = $currentFilter['parameters']['first'];
	
						//Get dropdown list field
						if (in_array($filterEnumOperator, array('options', 'function'))) {
						
							if (!$hasCustomEnum) {
								$opts = asol_Reports::getEnumValues($data_source, $filterField, $filterEnumOperator, $filterEnumReference);
								$optsLabels = asol_Reports::getEnumLabels($data_source, $filterField, $filterEnumOperator, $filterEnumReference);
							} else { 
								$opts = $customGeneratedDropdownValues['opts'];
								$optsLabels = $customGeneratedDropdownValues['optsLabels'];
							}
							
						}
							
						if ($filterBehavior == "user_input") {

							$theInput1 = "<select id='".$filterReference.$fixedDashletId."_1' multiple size=1 style='visibility: hidden;'>";

							foreach ($opts as $opt) {
								$theInput1 .= "<option value='".$opt."' ".(in_array($opt, $selectedOpts) ? "selected" : "")." title='".$optsLabels[$opt]."'>".$optsLabels[$opt]."</option>";
							}
							
							$theInput1 .= "</select>";

						} else if ($filterBehavior == "visible") {
							
							$theInput1 = '<span>';
							
							foreach ($opts as $opt) {
								if (in_array($opt, $selectedOpts))
									$theInput1 .= $optsLabels[$opt]."<br>";
							}
							
							$theInput1 = substr($theInput1, 0, -4);
							
							$theInput1 .= '</span>';
							
						}
						
						$theInput2 = null;
						$theInput3 = null;
						break;
						
					case "date":
					case "datetime":
					case "datetimecombo":
					case "timestamp":
						
						switch ($currentFilter['operator']) {
							
							case "equals":
							case "not equals":
							case "before date":
							case "after date":
								
								switch ($currentFilter['parameters']['first'][0]) {
									
									case "calendar":
										
										$date2 = $filterSecondParameter[0];
										
										if ($date2 != "")
											$date2 = $timedate->swap_formats($date2, $GLOBALS['timedate']->dbDayFormat, $userDateFormat);
									
										if ($filterBehavior == "user_input") {
											
											$theInput1 = "<input type='hidden' id='".$filterReference.$fixedDashletId."_1' value='".$filterFirstParameter[0]."' /><span>".asol_ReportsUtils::translateReportsLabel('LBL_REPORT_CALENDAR')."</span>";
											$theInput2 = "<input type='text' id='".$filterReference.$fixedDashletId."_2' class='calendarValue' '.$avoidAutocomplete.' value='".$date2."' readonly />";
											$currentContainer = ($isMetaSubReport? 'detailMetaContainer.'.$dashletId : 'detailContainer'.$dashletId);
											$theInput2 .= "<script type='text/javascript'> asolCalendar.initialize('".$currentContainer."', '".$filterReference.$fixedDashletId."_2', '".$date2."', null); </script>";
										
										} else if ($filterBehavior == "visible") {
											
											$theInput1 = "<span>".asol_ReportsUtils::translateReportsLabel('LBL_REPORT_CALENDAR')."</span>";
											$theInput2 = "<span>".$date2."</span>";
											
										}
									
										break;
										
									case "dayofweek":
										
										$selectedOpts = $filterSecondParameter;

										if (!$hasCustomEnum) {
											$dowEnumArray = self::getDOWEnumArrays();
											$opts = $dowEnumArray["opts"];
											$optsLabels = $dowEnumArray["optsLabels"];
										} else {
											$opts = $customGeneratedDropdownValues['opts'];
											$optsLabels = $customGeneratedDropdownValues['optsLabels'];
										}
										
										if ($filterBehavior == "user_input") {
											
											$theInput1 = "<input type='hidden' id='".$filterReference.$fixedDashletId."_1' value='".$currentFilter['parameters']['first'][0]."'><span>".asol_ReportsUtils::translateReportsLabel('LBL_REPORT_DAYOFWEEK')."</span>";
											
											$theInput2 = "<select id='".$filterReference.$fixedDashletId."_2' multiple size=1 style='visibility: hidden;'>";
											foreach ($opts as $opt) {
												$theInput2 .= "<option value='".$opt."' ".(in_array($opt, $selectedOpts) ? "selected" : "")." title='".$optsLabels[$opt]."'>".$optsLabels[$opt]."</option>";
											}
											$theInput2 .= "</select>";
											
										} else if ($filterBehavior == "visible") {
											
											$theInput1 = "<span>".asol_ReportsUtils::translateReportsLabel('LBL_REPORT_DAYOFWEEK')."</span>";
											
											$theInput2 = '<span>';
											
											foreach ($opts as $opt) {
												if (in_array($opt, $selectedOpts)) {
													$theInput2 .= $optsLabels[$opt]."<br>";
												}
											}
											
											$theInput2 = substr($theInput2, 0, -4);
											
											$theInput2 .= '</span>';
											
										}
										
										break;
										
									case "weekofyear":
										
										if (!$hasCustomEnum) {
											$woyEnumArray = self::getWOYEnumArrays();
											$opts = $woyEnumArray["opts"];
											$optsLabels = $woyEnumArray["optsLabels"];
										} else {
											$opts = $customGeneratedDropdownValues['opts'];
											$optsLabels = $customGeneratedDropdownValues['optsLabels'];
										}
										
										if ($filterBehavior == "user_input") {
											
											$theInput1 = "<input type='hidden' id='".$filterReference.$fixedDashletId."_1' value='".$currentFilter['parameters']['first'][0]."'><span>".asol_ReportsUtils::translateReportsLabel('LBL_REPORT_WEEKOFYEAR')."</span>";
											
											$theInput2 = "<select id='".$filterReference.$fixedDashletId."_2'>";
											foreach ($opts as $opt) {
												$theInput2 .= "<option value='".$opt."' ".($opt == $filterSecondParameter[0] ? "selected" : "")." title='".$optsLabels[$opt]."'>".$optsLabels[$opt]."</option>";
											}
											$theInput2 .= "</select>";
											
										} else if ($filterBehavior == "visible") {
											
											$theInput1 = "<span>".asol_ReportsUtils::translateReportsLabel('LBL_REPORT_WEEKOFYEAR')."</span>";
											$theInput2 = "<span>".$filterSecondParameter[0]."</span>";
											
										}
										
										break;
										
									case "monthofyear":

										$selectedOpts = $filterSecondParameter;

										if (!$hasCustomEnum) {
											$moyEnumArray = self::getMOYEnumArrays();
											$opts = $moyEnumArray["opts"];
											$optsLabels = $moyEnumArray["optsLabels"];
										} else {
											$opts = $customGeneratedDropdownValues['opts'];
											$optsLabels = $customGeneratedDropdownValues['optsLabels'];
										}
										
										if ($filterBehavior == "user_input") {
											
											$theInput1 = "<input type='hidden' id='".$filterReference.$fixedDashletId."_1' value='".$currentFilter['parameters']['first'][0]."'><span>".asol_ReportsUtils::translateReportsLabel('LBL_REPORT_MONTHOFYEAR')."</span>";
											
											$theInput2 = "<select id='".$filterReference.$fixedDashletId."_2' multiple size=1 style='visibility: hidden;'>";
											foreach ($opts as $opt) {
												$theInput2 .= "<option value='".$opt."' ".(in_array($opt, $selectedOpts) ? "selected" : "")." title='".$optsLabels[$opt]."'>".$optsLabels[$opt]."</option>";
											}
											$theInput2 .= "</select>";
											
										} else if ($filterBehavior == "visible") {
											
											$theInput1 = "<span>".asol_ReportsUtils::translateReportsLabel('LBL_REPORT_MONTHOFYEAR')."</span>";
											
											$theInput2 = '<span>';
											
											foreach ($opts as $opt) {
												if (in_array($opt, $selectedOpts)) {
													$theInput2 .= $optsLabels[$opt]."<br>";
												}
											}
											
											$theInput2 = substr($theInput2, 0, -4);
											
											$theInput2 .= '</span>';
											
										}
										
										break;
											
									case "naturalquarterofyear":
									case "fiscalquarterofyear":
										
										$selectedOpts = $filterSecondParameter;
										
										if (!$hasCustomEnum) {
											$qoyEnumArray = self::getQOYEnumArrays();
											$opts = $qoyEnumArray["opts"];
											$optsLabels = $qoyEnumArray["optsLabels"];
										} else {
											$opts = $customGeneratedDropdownValues['opts'];
											$optsLabels = $customGeneratedDropdownValues['optsLabels'];
										}
										
										$userInputLabel = ($currentFilter['parameters']['first'][0] == "naturalquarterofyear") ? "LBL_REPORT_NATURALQUARTEROFYEAR" : "LBL_REPORT_FISCALQUARTEROFYEAR";
										
										if ($filterBehavior == "user_input") {
											
											$theInput1 = "<input type='hidden' id='".$filterReference.$fixedDashletId."_1' value='".$currentFilter['parameters']['first'][0]."'><span>".asol_ReportsUtils::translateReportsLabel($userInputLabel)."</span>";
											
											$theInput2 = "<select id='".$filterReference.$fixedDashletId."_2' multiple size=1 style='visibility: hidden;'>";
											foreach ($opts as $opt) {
												$theInput2 .= "<option value='".$opt."' ".(in_array($opt, $selectedOpts) ? "selected" : "")." title='".$optsLabels[$opt]."'>".$optsLabels[$opt]."</option>";
											}
											$theInput2 .= "</select>";
											
										} else if ($filterBehavior == "visible") {
											
											$theInput1 = "<span>".asol_ReportsUtils::translateReportsLabel($userInputLabel)."</span>";
											
											$theInput2 = '<span>';
											
											foreach ($opts as $opt) {
												if (in_array($opt, $selectedOpts)) {
													$theInput2 .= $optsLabels[$opt]."<br>";
												}
											}
											
											$theInput2 = substr($theInput2, 0, -4);
											
											$theInput2 .= '</span>';
											
										}
										
										break;
										
									case "naturalyear":
									case "fiscalyear":
										
										$userInputLabel = ($currentFilter['parameters']['first'][0] == "naturalyear") ? "LBL_REPORT_NATURALYEAR" : "LBL_REPORT_FISCALYEAR";
										
										if (empty($filterSecondParameter))
											$filterSecondParameter = array(date("Y"));
										
										if ($filterBehavior == "user_input") {
											
											$theInput1 = "<input type='hidden' id='".$filterReference.$fixedDashletId."_1' value='".$currentFilter['parameters']['first'][0]."'><span>".asol_ReportsUtils::translateReportsLabel($userInputLabel)."</span>";
											$theInput2 = "<input type='text' id='".$filterReference.$fixedDashletId."_2' style='width:80px' value='".$filterSecondParameter[0]."' '.$avoidAutocomplete.'>";
										
										} else if ($filterBehavior == "visible") {
											
											$theInput1 = "<span>".asol_ReportsUtils::translateReportsLabel($userInputLabel)."</span>";
											$theInput2 = "<span>".$filterSecondParameter[0]."</span>";
											
										}
										
										break;
										
								}
								
								$theInput3 = null;
								
								break;
								
							case "before date":
							case "after date":
								
								$date1 = $currentFilter['parameters']['first'][0];
									
								if ($date1 != "")
									$date1 = $timedate->swap_formats($date1, $GLOBALS['timedate']->dbDayFormat, $userDateFormat);

								if ($filterBehavior == "user_input") {
									
									$theInput1 = "<input type='text' id='".$filterReference.$fixedDashletId."_1_date' class='calendarValue' value='".$date1."' readonly '.$avoidAutocomplete.'/>";
									$currentContainer = ($isMetaSubReport? 'detailMetaContainer.'.$dashletId : 'detailContainer'.$dashletId);
									$theInput1 .= "<script type='text/javascript'> asolCalendar.initialize('".$currentContainer."', '".$filterReference.$fixedDashletId."_1', '".$date1."', null); </script>";
								
								} else if ($filterBehavior == "visible") {
									
									$theInput1 = "<span>".$date1."</span>";											
									
								}
								
								$theInput2 = null;
								$theInput3 = null;
								
								break;
								
							case "between":
							case "not between":

								$input1 = $filterSecondParameter[0];
								$input2 = $filterThirdParameter[0];
								
								switch ($currentFilter['parameters']['first'][0]) {
									
									case "calendar":

										if((!$timedate->check_matching_format($input1, $userDateFormat)) && ($input1 != ""))
											$input1 = $timedate->swap_formats($input1, $GLOBALS['timedate']->dbDayFormat, $userDateFormat );

										if((!$timedate->check_matching_format($input2, $userDateFormat)) && ($input2 != ""))
											$input2 = $timedate->swap_formats($input2, $GLOBALS['timedate']->dbDayFormat, $userDateFormat );

											
										if ($filterBehavior == "user_input") {
											
											$currentContainer = ($isMetaSubReport? 'detailMetaContainer.'.$dashletId : 'detailContainer'.$dashletId);
											
											$theInput1 = "<input type='hidden' id='".$filterReference.$fixedDashletId."_1' value='".$currentFilter['parameters']['first'][0]."' /><span>".asol_ReportsUtils::translateReportsLabel('LBL_REPORT_CALENDAR')."</span>";
											
											$theInput2 = "<input type='text' id='".$filterReference.$fixedDashletId."_2' class='calendarValue' value='".$input1."' readonly '.$avoidAutocomplete.'/>";
											$theInput2 .= "<script type='text/javascript'> asolCalendar.initialize('".$currentContainer."', '".$filterReference.$fixedDashletId."_2', '".$input1."', null); </script>";
											$theInput3 = "<input type='text' id='".$filterReference.$fixedDashletId."_3' class='calendarValue' value='".$input2."' readonly '.$avoidAutocomplete.'/>";
											$theInput3 .= "<script type='text/javascript'> asolCalendar.initialize('".$currentContainer."', '".$filterReference.$fixedDashletId."_3', '".$input2."', null); </script>";
										
										} else if ($filterBehavior == "visible") {
											
											$theInput1 = "<span>".asol_ReportsUtils::translateReportsLabel('LBL_REPORT_CALENDAR')."</span>";
											
											$theInput2 = "<span>".$input1."</span>";
											$theInput3 = "<span>".$input2."</span>";
											
										}

										break;
										
									case "weekofyear":
										
										if (!$hasCustomEnum) {
											$woyEnumArray = self::getWOYEnumArrays();
											$opts = $woyEnumArray["opts"];
											$optsLabels = $woyEnumArray["optsLabels"];
										} else {
											$opts = $customGeneratedDropdownValues['opts'];
											$optsLabels = $customGeneratedDropdownValues['optsLabels'];
										}
										
										if ($filterBehavior == "user_input") {
											
											$theInput1 = "<input type='hidden' id='".$filterReference.$fixedDashletId."_1' value='".$currentFilter['parameters']['first'][0]."'><span>".asol_ReportsUtils::translateReportsLabel('LBL_REPORT_WEEKOFYEAR')."</span>";
											
											$theInput2 = "<select id='".$filterReference.$fixedDashletId."_2'>";
											foreach ($opts as $opt) {
												$theInput2 .= "<option value='".$opt."' ".($opt == $input1 ? "selected" : "")." title='".$optsLabels[$opt]."'>".$optsLabels[$opt]."</option>";
											}
											$theInput2 .= "</select>";
											$theInput3 = "<span style='display: block'>".asol_ReportsUtils::translateReportsLabel('LBL_REPORT_AND')."</span>";
											$theInput3 .= "<select id='".$filterReference.$fixedDashletId."_3'>";
											foreach ($opts as $opt) {
												$theInput3 .= "<option value='".$opt."' ".($opt == $input2 ? "selected" : "")." title='".$optsLabels[$opt]."'>".$optsLabels[$opt]."</option>";
											}
											$theInput3 .= "</select>";
											
										} else if ($filterBehavior == "visible") {
											
											$theInput1 = "<span>".asol_ReportsUtils::translateReportsLabel('LBL_REPORT_WEEKOFYEAR')."</span>";
											$theInput2 = "<span>".$input1."</span>";
											$theInput3 = "<span style='display: block'>".asol_ReportsUtils::translateReportsLabel('LBL_REPORT_AND')."</span>";
											$theInput3 .= "<span>".$input2."</span>";
											
										}
										
										break;
										
									case "naturalyear":
									case "fiscalyear":
										
										$userInputLabel = ($currentFilter['parameters']['first'][0] == "naturalyear") ? "LBL_REPORT_NATURALYEAR" : "LBL_REPORT_FISCALYEAR";
										
										if (empty($input1))
											$input1 = date("Y");
										if (empty($input2))
											$input2 = date("Y");
										
										if ($filterBehavior == "user_input") {
											
											$theInput1 = "<input type='hidden' id='".$filterReference.$fixedDashletId."_1' value='".$currentFilter['parameters']['first'][0]."'><span>".asol_ReportsUtils::translateReportsLabel($userInputLabel)."</span>";
											$theInput2 = "<input type='text' id='".$filterReference.$fixedDashletId."_2' style='width:80px' value='".$input1."' '.$avoidAutocomplete.'>";
											$theInput3 = "<span style='display: block'>".asol_ReportsUtils::translateReportsLabel('LBL_REPORT_AND')."</span>";
											$theInput3 .= "<input type='text' id='".$filterReference.$fixedDashletId."_3' style='width:80px' value='".$input2."' '.$avoidAutocomplete.'>";
											
										} else if ($filterBehavior == "visible") {
											
											$theInput1 = "<span>".asol_ReportsUtils::translateReportsLabel($userInputLabel)."</span>";
											$theInput2 = "<span>".$input1."</span>";
											$theInput3 = "<span style='display: block'>".asol_ReportsUtils::translateReportsLabel('LBL_REPORT_AND')."</span>";
											$theInput3 .= "<span>".$input2."</span>";
											
										}
										
										break;
									
								}
								
								break;
								
							case "last":
							case "not last":
								
								if (!$hasCustomEnum) {
									$doaEnumArray = self::getDateOperatorArrays();
									$opts = $doaEnumArray["opts"];
									$optsLabels = $doaEnumArray["optsLabels"];
								} else {
									$opts = $customGeneratedDropdownValues['opts'];
									$optsLabels = $customGeneratedDropdownValues['optsLabels'];
								}
																
								
								if ($filterBehavior == "user_input") {
								
									$theInput1 = "<select id='".$filterReference.$fixedDashletId."_1' onChange='if (this.selectedIndex >= 7) { document.getElementById(\"".$filterReference."_2\").style.display=\"none\"; } else { document.getElementById(\"".$filterReference."_2\").style.display=\"inline\"; } '>";
									foreach ($opts as $opt) {
										$theInput1 .= "<option value='".$opt."' ".($opt == $currentFilter['parameters']['first'][0] ? "selected" : "")." title='".$optsLabels[$opt]."'>".$optsLabels[$opt]."</option>";
									}
									$theInput1 .= "</select>";
									
								} else if ($filterBehavior == "visible") {

									$theInput1 = (!empty($extFilters[$filterReference]["param1"])) ? '<span>'.$optsLabels[$extFilters[$filterReference]["param1"]].'</span>' : '<span>'.$optsLabels[$currentFilter['parameters']['first'][0]].'</span>';
									
								}
								
								switch ($currentFilter['parameters']['first'][0]) {
									
									case "day":
									case "week":
									case "month":
									case "Nquarter":
									case "Fquarter":
									case "Nyear":
									case "Fyear":
										
										if ($filterBehavior == "user_input")
											$theInput2 = '<input id="'.$filterReference.$fixedDashletId.'_2" type="text" value="'.$filterSecondParameter[0].'" '.$avoidAutocomplete.'>';
										else if ($filterBehavior == "visible")
											$theInput2 = '<span>'.$filterSecondParameter[0].'</span>';
										
										break;
										
									default:
										
										if ($filterBehavior == "user_input")
											$theInput2 = '<input id="'.$filterReference.$fixedDashletId.'_2" style="display: none;" type="text" value="'.$filterSecondParameter[0].'" '.$avoidAutocomplete.'>';
										else if ($filterBehavior == "visible")
											$theInput2 = '<span>'.$filterSecondParameter[0].'</span>';
										
										break;
									
								}
								
								$theInput3 = null;
								
								break;
								
							case "this":
							case "not this":
								
								if (!$hasCustomEnum) {
									$rdoaEnumArray = self::getReducedDateOperatorArrays();
									$opts = $rdoaEnumArray["opts"];
									$optsLabels = $rdoaEnumArray["optsLabels"];
								} else {
									$opts = $customGeneratedDropdownValues['opts'];
									$optsLabels = $customGeneratedDropdownValues['optsLabels'];
								}
								
								if ($filterBehavior == "user_input") {
									
									$theInput1 = "<select id='".$filterReference.$fixedDashletId."_1'>";
									foreach ($opts as $opt) {
										$theInput1 .= "<option value='".$opt."' ".($opt == $currentFilter['parameters']['first'][0] ? "selected" : "")." title='".$optsLabels[$opt]."'>".$optsLabels[$opt]."</option>";
									}
									$theInput1 .= "</select>";
								
								} else if ($filterBehavior == "visible") {
									
									$theInput1 = '<span>'.$optsLabels[$currentFilter['parameters']['first'][0]].'</span>';
									
								}
								
								$theInput2 = null;
								$theInput3 = null;
								
								break;
								
							case "next":
							case "not next":
							case "these":	
														
								if (!$hasCustomEnum) {
									$rdoaEnumArray = self::getReducedDateOperatorArrays();
									$opts = $rdoaEnumArray["opts"];
									$optsLabels = $rdoaEnumArray["optsLabels"];
								} else {
									$opts = $customGeneratedDropdownValues['opts'];
									$optsLabels = $customGeneratedDropdownValues['optsLabels'];
								}
								
								if ($filterBehavior == "user_input") {
									
									$theInput1 = "<select id='".$filterReference.$fixedDashletId."_1'>";
									foreach ($opts as $opt) {
										$theInput1 .= "<option value='".$opt."' ".($opt == $currentFilter['parameters']['first'][0] ? "selected" : "")." title='".$optsLabels[$opt]."'>".$optsLabels[$opt]."</option>";
									}
									$theInput1 .= "</select>";
									
								} else if ($filterBehavior == "visible") {
									
									$theInput1 = '<span>'.$optsLabels[$currentFilter['parameters']['first'][0]].'</span>';
									
								}
								
								if ($filterBehavior == "user_input") {

									$theInput2 = '<input id="'.$filterReference.$fixedDashletId.'_2" type="text" value="'.$filterSecondParameter[0].'" '.$avoidAutocomplete.'>';
								
								} else if ($filterBehavior == "visible") {

									$theInput2 = '<span>'.$filterSecondParameter[0].'</span>';
								
								}
								
								$theInput3 = null;
									
								break;
							
						}
						
						break;
						
					case "bool":
					case "tinyint(1)":
						if (!empty($extFilters[$filterReference]["param1"]))
							$currentFilter['parameters']['first'][0] = $extFilters[$filterReference]["param1"];

						if ($filterBehavior == "user_input")
							$theInput1 = ($currentFilter['parameters']['first'][0] == "true") ? "<select id='".$filterReference.$fixedDashletId."_1' name='".$filterReference."_1'><option value='true' selected>".asol_ReportsUtils::translateReportsLabel("LBL_REPORT_TRUE")."</option><option value='false'>".asol_ReportsUtils::translateReportsLabel("LBL_REPORT_FALSE")."</option></select>" : "<select id='".$filterReference.$fixedDashletId."_1'><option value='true'>".asol_ReportsUtils::translateReportsLabel("LBL_REPORT_TRUE")."</option><option value='false' selected>".asol_ReportsUtils::translateReportsLabel("LBL_REPORT_FALSE")."</option></select>";
						else if ($filterBehavior == "visible")
							$theInput1 = "<span>".$currentFilter['parameters']['first'][0]."</span>";
						
						$theInput2 = null;
						$theInput3 = null;
						
						break;

					case "relate" :
						if (!empty($extFilters[$filterReference]["param1"]))
							$currentFilter['parameters']['first'][0] = $extFilters[$filterReference]["param1"];

						$tmpField = explode(".", $filterField);
						
						$relateField = (count($tmpField) == 2) ? $tmpField[1] : $filterField;

						if ($auditedReport) {
							if ($filterField == 'parent_id')
								$relateModule = $report_module;
							else if ($filterField == 'created_by')
								$relateModule = "Users";
						} else {
							$relateModule = asol_CommonUtils::getRelateFieldModule($report_module, $relateField);
						}
						
						if (($filterOperator === 'my items') && (empty($currentFilter['parameters']['first'][0])))
							$moduleFieldValue = $current_user->id;
						else 
							$moduleFieldValue = $currentFilter['parameters']['first'][0];
						
						$relateId = "id";
						$relateName = ($relateModule == 'Users') ? "user_name" : "name";
						$fieldInputId = $filterReference.$fixedDashletId."_1";
						$fieldInputName = $filterReference.$fixedDashletId."_1_name";

						//Create new ModuleObject and get Name field Value
						$moduleFieldName = BeanFactory::getBean($relateModule, $moduleFieldValue)->$relateName;
						//Create new ModuleObject and get Name field Value
						
						if ($currentFilter['operator'] === 'my items') {
							$popup_selector = '<input type="checkbox" id="'.$filterReference.$fixedDashletId.'_1'.'"'.( $moduleFieldValue == 'true' ? ' checked' : '').'>';
						} else {
							$popup_selector = 
							"<input type='hidden' id='".$filterReference.$fixedDashletId."_1"."' value='".$moduleFieldValue."'><input readonly type='text' autocomplete='off' title='' value='".$moduleFieldName."' id='".$filterReference.$fixedDashletId."_1_name"."' class='asolInputPopupSelector'>
							<i class='icn-search' onclick=\"open_popup('".$relateModule."', 600, 400, '', true, false, {'call_back_function':'set_return','form_name':'criteria_form','field_to_name_array':{'".$relateId."':'".$fieldInputId."','".$relateName."':'".$fieldInputName."'}}, 'single', true);\" title='".$app_strings['LBL_SELECT_BUTTON_LABEL']."'></i>
							<i class='icn-cancel' onclick=\"document.getElementById('".$filterReference.$fixedDashletId."_1_name').value =''; document.getElementById('".$filterReference.$fixedDashletId."_1').value = ''\" value='".$app_strings['LBL_CLEAR_BUTTON_LABEL']."'></i>";
						}
						if ($filterBehavior == "user_input")
							$theInput1 = $popup_selector;
						else if ($filterBehavior == "visible")
							$theInput1 = "<span>".$moduleFieldName."</span>";
						
						$theInput2 = null;
						$theInput3 = null;
						
						break;
						
						
					default:

						if ($filterBehavior == "user_input") {

							$selectMultiple = (in_array($currentFilter['operator'], array("one of", "not one of"))) ? "multiple size=1" : "";
							$selectStyle = (in_array($currentFilter['operator'], array("one of", "not one of"))) ? "visibility: hidden;" : "";
							
							if (!$hasCustomEnum) {
		
								$theInput1 = '<input id="'.$filterReference.$fixedDashletId.'_1" type="text" value="'.$currentFilter['parameters']['first'][0].'" '.$avoidAutocomplete.'>';

							} else {
								
								$selectedOpts = $currentFilter['parameters']['first'];
								
								$opts = $customGeneratedDropdownValues['opts'];
								$optsLabels = $customGeneratedDropdownValues['optsLabels'];							

								$theInput1 = '<select id="'.$filterReference.$fixedDashletId.'_1" '.$selectMultiple.' style="'.$selectStyle.'">';
								foreach ($opts as $opt) {
									$theInput1 .= "<option value='".$opt."' ".(in_array($opt, $selectedOpts) ? "selected" : "")." title='".$optsLabels[$opt]."'>".$optsLabels[$opt]."</option>";
								}
								
								$theInput1 .= "</select>";		
	
							}

						} else if ($filterBehavior == "visible") {
							
							if (!$hasCustomEnum) {
							
								$theInput1 = '<span>'.$currentFilter['parameters']['first'][0].'</span>';
							
							} else {
								
								$selectedOpts = $currentFilter['parameters']['first'];
								
								$opts = $customGeneratedDropdownValues['opts'];
								$optsLabels = $customGeneratedDropdownValues['optsLabels'];
								
								$theInput1 = '<span>';
							
								foreach ($opts as $opt) {
									if (in_array($opt, $selectedOpts))
										$theInput1 .= $optsLabels[$opt]."<br>";
								}
								
								$theInput1 = substr($theInput1, 0, -4);
								
								$theInput1 .= '</span>';
								
							}
							
						}
						
						$theInput2 = null;
						$theInput3 = null;
						break;
					
				}
				
				
				if ($filterBehavior == "user_input") {
					
					if ($theInput3 != null)
						$filtersHiddenInputs .= $filterReference.'${dp}'.$currentFilter['operator'].'${dp}3${pipe}';
					else if ($theInput2 != null)
						$filtersHiddenInputs .= $filterReference.'${dp}'.$currentFilter['operator'].'${dp}2${pipe}';
					else
						$filtersHiddenInputs .= $filterReference.'${dp}'.$currentFilter['operator'].'${dp}1${pipe}';
					
				}

				
				$hasCustomFilterLabel = false;
				
				if ($filterBehavior == "visible") {
				
					$filterLabel = "LBL_REPORT_".strtoupper(str_replace(" ", "_", $currentFilter['operator']))."_".strtoupper(str_replace(" ", "_", $currentFilter['parameters']['first'][0]));
					$filterLabel .= (!empty($filterSecondParameter[0])) ? "_".$filterSecondParameter[0] : "";

					$filterLabelValue = asol_ReportsUtils::translateReportsLabel($filterLabel);
					
					if (empty($filterLabelValue) || $filterLabel === $filterLabelValue) {
						$filterLabel = "LBL_REPORT_".strtoupper(str_replace(" ", "_", $currentFilter['operator']));
					} else {
						$hasCustomFilterLabel = true;
					}
					
				} else {

					$filterLabel = "LBL_REPORT_".strtoupper(str_replace(" ", "_", $currentFilter['operator']));
					
				}
				
				$filterLabelValue = asol_ReportsUtils::translateReportsLabel($filterLabel);
				$filterNegateLabel = ($currentFilter['logicalOperators']['negate'] == '1' && $currentFilter['logicalOperators']['parenthesis'] <= '0' ? asol_ReportsUtils::translateReportsLabel('LBL_REPORT_NOT').' ' : '');
				
				//***********************//
				//***AlineaSol Premium***//
				//***********************//
				$extraParams = array('label' => $currentFilter);
				$returnedPremiumAlias = asol_ReportsUtils::managePremiumFeature("multiLanguageReport", "reportFunctions.php", "getMultiLanguageLabel", $extraParams);
				$currentFilter['alias'] = ($returnedPremiumAlias !== false) ? $returnedPremiumAlias : $currentFilter['alias'];
				//***********************//
				//***AlineaSol Premium***//
				//***********************//
				
				
				$filtersPanel[] = array(
					"type" => $filterType,
					"label" => $currentFilter['alias'],
					"reference" => $filterReference,
					"operator" => $currentFilter['operator'],
					"input1" => ($hasCustomFilterLabel ? '' : $theInput1),
					"input2" => ($hasCustomFilterLabel ? '' : $theInput2),
					"input3" => ($hasCustomFilterLabel ? '' : $theInput3),
					"genLabel" => $filterNegateLabel.(!empty($filterLabelValue) ? $filterLabelValue: $currentFilter['operator']),
				);
								  
		  
			}
		
			//***********************//
			//***AlineaSol Premium***//
			//***********************//
			$saveLastSearchExtraParams = array(
				'filterReference' => $filterReference,
				'filterBehavior' => $filterBehavior,
				'search_mode' => $search_mode,
				'layoutConfig' => $layoutConfig,
			);
			$searchModeAppliesResult = asol_ReportsUtils::managePremiumFeature("FiltersLayoutDefinition", "reportFunctions.php", "currentFilterSearchModeApplies", $saveLastSearchExtraParams);
			$currentFilter['apply'] = ($searchModeAppliesResult!== false ? $searchModeAppliesResult: $currentFilter['apply']);
			//***********************//
			//***AlineaSol Premium***//
			//***********************//
			
		}
	
		$filtersHiddenInputs = urlencode(substr($filtersHiddenInputs, 0, -7));
		$filtersHiddenInputs = (!empty($filtersHiddenInputs)) ? $filtersHiddenInputs : false;
	
		return array(
			"filterValues" => $filters,
			"filtersPanel" => $filtersPanel,
			"filtersHiddenInputs" => $filtersHiddenInputs,
			"searchCriteria" => $searchCriteria,
		);
		
	}
	
	private static function getUserOptionsReadableFormat($userOptions) {
		if ($userOptions == null) {
			$userOptions = array();
		}
		
		$ret = "";
		foreach($userOptions as $entry) {
			$key = $entry['key'];
			$value = $entry['value'];
			
			$ret .= $key;
			if (isset($value)) {
				$ret .= '='.$value;
			}
			$ret .= ",";
			
		}
		
		return substr($ret, 0, -1);
	}
	
	private static function getCustomGeneratedDropdownValues($generatedDropdown) {
		
		global $current_language;
		
		$opts = array();
		$optsLabels = array();
		
		foreach ($generatedDropdown as $dropdownValues) {
			if (!isset($dropdownValues['hidden']) || !$dropdownValues['hidden']) { 
				$opts[] = $dropdownValues['key'];
				$optsLabels[$dropdownValues['key']] = (isset($dropdownValues['language'][$current_language]) ? $dropdownValues['language'][$current_language] : (isset($dropdownValues['value']) ? $dropdownValues['value'] : $dropdownValues['key']));
			}
		}

		return array(
			"opts" => $opts,
			"optsLabels" => $optsLabels
		);
		
	}
	
	
	public static function getReportTotalEntries($sqlFrom, $sqlCountJoin, $sqlWhere, $sqlGroup, $sqlHaving, $details, $groups, $useExternalDbConnection, $alternativeDb, $reportTable) {
	
		$hasDetail = (count($details) != 0);
		$hasGroup = (count($groups) != 0);
		
		if ($hasDetail) {
			$sqlGroup .= ($hasGroup ? ', '.$details[0]['field'] : '');
		}
		
		$dbKey = ($alternativeDb === false ? 'crm' : 'ext'.$alternativeDb);
		$primaryKey = (array_search('PRIMARY', (array) $_SESSION['asolReportsTableIndexes'][$dbKey][$reportTable], true));
		$primaryKeyCounter = ($primaryKey !== false && !$hasGroup ? 'DISTINCT '.$reportTable.'.'.$primaryKey : '*');
		
		if ($hasGroup) {
			
			$sqlOrder = ' ORDER BY NULL';
		
			$rsG = asol_Reports::getSelectionResults("SELECT COUNT(DISTINCT ".$groups[0]['field'].") AS total ".$sqlFrom.$sqlCountJoin.$sqlWhere.$sqlGroup.$sqlHaving.$sqlOrder, null, $useExternalDbConnection, $alternativeDb);
			$total_entries = count($rsG);

			$total_ungrouped_entries = 0;
			foreach ($rsG as $totalG) {
				$total_ungrouped_entries += $totalG['total'];
			}
			
		} else {
			
			$rs = asol_Reports::getSelectionResults("SELECT COUNT(".$primaryKeyCounter.") AS total ".$sqlFrom.$sqlCountJoin.$sqlWhere, null, $useExternalDbConnection, $alternativeDb);
			$total_entries = $total_ungrouped_entries = $rs[0]['total'];
			
		}

		return array(
			'totalEntries' => $total_entries,
			'totalUngroupedEntries' => $total_ungrouped_entries
		);
	
	}
						
	
	public static function correctEmptyReport($sqlSelect, $sqlTotals, $alternativeDb, $reportTable, $groups) {
						
		$hasGroup = (count($groups) != 0);
		
		$selectReturn = (strlen($sqlSelect) <= 6 ? " id" : null);
		
		$dbKey = ($alternativeDb === false ? 'crm' : 'ext'.$alternativeDb);
		$primaryKey = (array_search('PRIMARY', (array) $_SESSION['asolReportsTableIndexes'][$dbKey][$reportTable], true));
		$primaryKeyCounter = ($primaryKey !== false && !$hasGroup ? 'DISTINCT '.$reportTable.'.'.$primaryKey : '*');

		$totalReturn["sql"] = (strlen($sqlTotals) <= 6 ? " COUNT(".$primaryKeyCounter.") AS 'TOTAL'" : null);
		$totalReturn["column"] = (strlen($sqlTotals) <= 6 ? "TOTAL" : null);
		
		return array(
			"select" => $selectReturn,
			"totals" => $totalReturn
		);
		
	}
	
	
	public static function getOrderPaginationSingleDetailVars($detailFieldInfo, $detailMultiQuery, $results_limit, $sqlFrom, $sqlJoin, $sqlWhere, $sqlGroup, $sqlHaving, $useExternalDbConnection, $alternativeDb, $reportTable, $groups) {
	
		$rsGroups;
		$sizes;
		$fullSizes;
		$sqlOrderGroups = "";
		
		$hasGroup = (count($groups) != 0);
		
		$dbKey = ($alternativeDb === false ? 'crm' : 'ext'.$alternativeDb);
		$primaryKey = (array_search('PRIMARY', (array) $_SESSION['asolReportsTableIndexes'][$dbKey][$reportTable], true));
		$primaryKeyCounter = ($primaryKey !== false && !$hasGroup ? 'DISTINCT '.$reportTable.'.'.$primaryKey : '*');

		if ($detailFieldInfo['order'] != '0') {
			$sqlOrderGroups = " ORDER BY ".$detailFieldInfo['field']." ".$detailFieldInfo['order'];		
		}
		
		if ($detailMultiQuery) {
		
			$sqlGroupsQuery = "SELECT DISTINCT ".$detailFieldInfo['field']." AS 'group' ".$sqlFrom.$sqlJoin.$sqlWhere.$sqlOrderGroups;
			$rsGroups = asol_Reports::getSelectionResults($sqlGroupsQuery, null, $useExternalDbConnection, $alternativeDb);
	
			for ($j=0; $j<count($rsGroups); $j++){
		
				$rsGroups[$j]['group'] = ($rsGroups[$j]['group'] == "") ? "Nameless" : $rsGroups[$j]['group'] = str_replace("&quot;", "\"", str_replace("&#039;", "\'", $rsGroups[$j]['group']));
		
				$groupField = $detailFieldInfo['field'];
				$subGroup = $rsGroups[$j]['group'];
		
				$sqlDetailGroupWhere = ($subGroup != "Nameless") ? $sqlWhere." AND ".$groupField."='".$subGroup."' " : $sqlWhere." AND ".$groupField." IS NULL ";
				$sqlDetailGroupQuery = "SELECT COUNT(".$primaryKeyCounter.") AS total ".$sqlFrom.$sqlJoin.$sqlDetailGroupWhere.$sqlGroup.$sqlHaving;
				
	
				$rsCount = asol_Reports::getSelectionResults($sqlDetailGroupQuery, null, $useExternalDbConnection, $alternativeDb);
		
				if ($results_limit == "all") {
					$sizes[$j] = $rsCount[0]['total'];
				} else {
					$res_limit = explode('${dp}', $results_limit);
					$sizes[$j] = ($rsCount[0]['total'] < $res_limit[2]) ? $rsCount[0]['total'] : $res_limit[2];
				}
		
				$fullSizes[$j] = $rsCount[0]['total'];
		
			}
			
		} else {
			
			$sqlGroupsTotalsQuery = "SELECT DISTINCT ".$detailFieldInfo['field']." AS 'group', COUNT(".$primaryKeyCounter.") AS total ".$sqlFrom.$sqlJoin.$sqlWhere.' GROUP BY '.$detailFieldInfo['field'].' '.$sqlOrderGroups;
			$rsGroupsTotals = asol_Reports::getSelectionResults($sqlGroupsTotalsQuery, null, $useExternalDbConnection, $alternativeDb);
			
			for ($j=0; $j<count($rsGroupsTotals); $j++){
				
				$rsGroups[$j]['group'] = ($rsGroupsTotals[$j]['group'] == "") ? "Nameless" : $rsGroupsTotals[$j]['group'] = str_replace("&quot;", "\"", str_replace("&#039;", "\'", $rsGroupsTotals[$j]['group']));
				
				if ($results_limit == "all") {
					$sizes[$j] = $rsGroupsTotals[$j]['total'];
				} else {
					$res_limit = explode('${dp}', $results_limit);
					$sizes[$j] = ($rsGroupsTotals[$j]['total'] < $res_limit[2]) ? $rsGroupsTotals[$j]['total'] : $res_limit[2];
				}
				
				$fullSizes[$j] = $rsGroupsTotals[$j]['total'];
				
			}
			
		}
		
		return array(
			"rsGroups" => $rsGroups,
			"sizes" => $sizes,
			"fullSizes" => $fullSizes
		);
		
	}
					
	
	public static function getOrderPaginationDateDetailVars($detailFieldInfo, $detailMultiQuery, $results_limit, $sqlFrom, $sqlJoin, $sqlWhere, $useExternalDbConnection, $alternativeDb, $reportTable, $groups, $week_start) {
		
		$hasGroup = (count($groups) != 0);
		
		$dbKey = ($alternativeDb === false ? 'crm' : 'ext'.$alternativeDb);
		$primaryKey = (array_search('PRIMARY', (array) $_SESSION['asolReportsTableIndexes'][$dbKey][$reportTable], true));
		$primaryKeyCounter = ($primaryKey !== false && !$hasGroup ? 'DISTINCT '.$reportTable.'.'.$primaryKey : '*');

		if (in_array($detailFieldInfo['grouping'], array('Minute Detail', 'Quarter Hour Detail', 'Hour Detail', 'Day Detail', 'DoW Detail', 'WoY Detail', 'Month Detail', 'Natural Quarter Detail', 'Fiscal Quarter Detail', 'Natural Year Detail', 'Fiscal Year Detail'))) {
			if ($detailMultiQuery)
				$sqlGroupsQuery = "SELECT DISTINCT ".$detailFieldInfo['field']." AS 'group' ".$sqlFrom.$sqlJoin.$sqlWhere;
			else
				$sqlGroupsQuery = "SELECT DISTINCT ".$detailFieldInfo['field']." AS 'group', COUNT(".$primaryKeyCounter.") AS total ".$sqlFrom.$sqlJoin.$sqlWhere.' GROUP BY '.$detailFieldInfo['field'];
		}
			
		$sqlOrderGroups = "";
		
		if ($detailFieldInfo['order'] != '0') {
			
			if (in_array($detailFieldInfo['grouping'], array('Minute Detail', 'Quarter Hour Detail', 'Hour Detail', 'Day Detail', 'DoW Detail', 'WoY Detail', 'Month Detail', 'Natural Quarter Detail', 'Fiscal Quarter Detail', 'Natural Year Detail', 'Fiscal Year Detail'))) { 
				$sqlOrderGroups = " ORDER BY ".$detailFieldInfo['field']." ".$detailFieldInfo['order'];
			}
				
		} 
			
		$rsGroups = asol_Reports::getSelectionResults($sqlGroupsQuery.$sqlOrderGroups, null, $useExternalDbConnection, $alternativeDb);
	
		
		//*********************************************//
		//***Reorder Groups if Week Starts on Sunday***//
		//*********************************************//
		if (($detailFieldInfo['grouping'] === 'DoW Detail') && ($week_start !== '1')) {
			array_unshift($rsGroups, array_pop($rsGroups));
		}
		//*********************************************//
		//***Reorder Groups if Week Starts on Sunday***//
		//*********************************************//
		
		
		$sizes;
		$fullSizes;
		
		if ($detailMultiQuery) {

			for ($j=0; $j<count($rsGroups); $j++) {
				
				$groupField = $detailFieldInfo['field'];
				$subGroup = $rsGroups[$j]['group'];
				
				if (in_array($detailFieldInfo['grouping'], array('Day Detail', 'DoW Detail', 'WoY Detail', 'Month Detail', 'Natural Quarter Detail', 'Fiscal Quarter Detail', 'Natural Year Detail', 'Fiscal Year Detail')))
					$sqlDetailGroupWhere = $sqlWhere." AND ".$groupField."='".$subGroup."' ";
			
				
				$sqlDetailGroupQuery = "SELECT COUNT(".$primaryKeyCounter.") AS total ".$sqlFrom.$sqlJoin.$sqlDetailGroupWhere.$sqlGroup;
				
				
				$rsCount = asol_Reports::getSelectionResults($sqlDetailGroupQuery, null, $useExternalDbConnection, $alternativeDb);
					
				if ($results_limit == "all") {
					$sizes[$j] = $rsCount[0]['total'];
				} else {
					$res_limit = explode('${dp}', $results_limit);
					$sizes[$j] = ($rsCount[0]['total'] < $res_limit[2]) ? $rsCount[0]['total'] : $res_limit[2];
				}
		
				$fullSizes[$j] = $rsCount[0]['total'];
				
			}
		
		} else {
			
			for ($j=0; $j<count($rsGroups); $j++){
				
				if ($results_limit == "all") {
					$sizes[$j] = $rsGroups[$j]['total'];
				} else {
					$res_limit = explode('${dp}', $results_limit);
					$sizes[$j] = ($rsGroups[$j]['total'] < $res_limit[2]) ? $rsGroups[$j]['total'] : $res_limit[2];
				}
				
				$fullSizes[$j] = $rsGroups[$j]['total'];
				
			}
			
		}
		
		return array(
			"rsGroups" => $rsGroups,
			"sizes" => $sizes,
			"fullSizes" => $fullSizes
		);
		
	}
	
	
	public static function getPaginationMainVariables($page_number, $entriesPerPage, $sizes) {
							
		$current_entries = 0;
		$first_entry = 0;
	
		$init_group = 0;
		$end_group = 0;
		$index = 0;
		
		for ($k=0; $k<=$page_number; $k++) {
				
			$current_entries = 0;
			$current_entries += $sizes[$index];
		
			while (($current_entries < $entriesPerPage) && ($index+1 < count($sizes))){
				$index++;
				$current_entries += $sizes[$index];
			}
				
			if ($k == ($page_number-1)){
				$init_group = $index+1;
			}
				
			if ($k == $page_number){
				$end_group = $index;
			}
				
			$index++;
			$first_entry += $current_entries;
		}
		
		$first_entry -= $current_entries;
		
		return array(
			"init_group" => $init_group,
			"end_group" => $end_group,
			"current_entries" => $current_entries,
			"first_entry" => $first_entry
		);
		
	}
						
	
	public static function getDetailGroupWhereExtensionQuery($sqlWhere, $groupField, $subGroup) {
	
		global $mod_strings;
		
		if ($subGroup != "Nameless")
			$sqlDetailWhere = $sqlWhere." AND ".$groupField."='".$subGroup."' ";
		else {
			$sqlDetailWhere = $sqlWhere." AND ".$groupField." IS NULL ";
			$subGroup = $mod_strings['LBL_REPORT_NAMELESS'];
		}
		
		return array(
			"subGroup" => $subGroup,
			"sqlDetailWhere" => $sqlDetailWhere
		);
	
	}

							
	public static function getDateDetailGroupWhereExtensionQuery($sqlWhere, $groupField, $detailGrouping, $subGroup) {
		
		$sqlWhere = (empty($sqlWhere) ? " WHERE (1=1)" : $sqlWhere);
		
		if (in_array($detailGrouping, array('Minute Detail', 'Quarter Hour Detail', 'Hour Detail', 'Day Detail', 'DoW Detail', 'WoY Detail', 'Month Detail', 'Natural Quarter Detail', 'Fiscal Quarter Detail', 'Natural Year Detail', 'Fiscal Year Detail')))
			$sqlDetailWhere = $sqlWhere." AND ".$groupField."='".$subGroup."' ";

		return array(
			"subGroup" => $subGroup,
			"sqlDetailWhere" => $sqlDetailWhere
		);
		
	}
	
	public static function getTableConfiguration($tables, $index) {
		
		return $tables['tables'][$index]['config'];
		
	}

	private static function getDOWEnumArrays() {
		
		$dowLabels = array(
			"0" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_MONDAY"),
			"1" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_TUESDAY"),
			"2" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_WEDNESDAY"),
			"3" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_THURSDAY"),
			"4" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_FRIDAY"),
			"5" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_SATURDAY"),
			"6" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_SUNDAY")
		);
		$dowValues = array_keys($dowLabels);
		
		return array(
			"opts" => $dowValues,
			"optsLabels" => $dowLabels,
		);
	}
	
	private static function getWOYEnumArrays() {
		$weeksInYear = 53;
		$woyLabels = array();
		
		for ($week = 1; $week <= $weeksInYear; $week++) {
			$woyLabels[$week] = $week;
		}
		
		$woyValues = array_keys($woyLabels);
		
		return array(
			"opts" => $woyValues,
			"optsLabels" => $woyLabels,
		);
		
	}
	
	private static function getMOYEnumArrays() {
		
		$moyLabels = array(
			"1" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_JANUARY"),
			"2" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_FEBRUARY"),
			"3" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_MARCH"),
			"4" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_APRIL"),
			"5" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_MAY"),
			"6" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_JUNE"),
			"7" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_JULY"),
			"8" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_AUGUST"),
			"9" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_SEPTEMBER"),
			"10" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_OCTOBER"),
			"11" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_NOVEMBER"),
			"12" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_DECEMBER")
		);
		$moyValues = array_keys($moyLabels);
		
		return array(
			"opts" => $moyValues,
			"optsLabels" => $moyLabels,
		);
	}
	
	private static function getQOYEnumArrays() {
		$qoyLabels = array(
			"1" => "1º",
			"2" => "2º",
			"3" => "3º",
			"4" => "4º"
		);
		$qoyValues = array_keys($qoyLabels);
		
		return array(
			"opts" => $qoyValues,
			"optsLabels" => $qoyLabels,
		);
	}
	
	private static function getDateOperatorArrays() {
		
		global $mod_strings;
		
		$doaLabels = array(
			"day" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_DAY"),
			"week" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_WEEK"),
			"month" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_MONTH"),
			"Nquarter" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_NQUARTER"),
			"Fquarter" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_FQUARTER"),
			"Nyear" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_NYEAR"),
			"Fyear" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_FYEAR"),
			"monday" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_MONDAY"),
			"tuesday" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_TUESDAY"),
			"wednesday" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_WEDNESDAY"),
			"thursday" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_THURSDAY"),
			"friday" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_FRIDAY"),
			"saturday" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_SATURDAY"),
			"sunday" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_SUNDAY"),
			"january" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_JANUARY"),
			"february" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_FEBRUARY"),
			"march" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_MARCH"),
			"april" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_APRIL"),
			"may" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_MAY"),
			"june" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_JUNE"),
			"july" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_JULY"),
			"august" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_AUGUST"),
			"september" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_SEPTEMBER"),
			"october" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_OCTOBER"),
			"november" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_NOVEMBER"),
			"december" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_DECEMBER")
		);
		$doaValues = array_keys($doaLabels);
		
		return array(
			"opts" => $doaValues,
			"optsLabels" => $doaLabels,
		);
	}
	
	private static function getReducedDateOperatorArrays() {
		
		global $mod_strings;
		
		$rdoaLabels = array(
			"day" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_DAY"),
			"week" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_WEEK"),
			"month" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_MONTH"),
			"Nquarter" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_NQUARTER"),
			"Fquarter" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_FQUARTER"),
			"Nyear" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_NYEAR"),
			"Fyear" => asol_ReportsUtils::translateReportsLabel("LBL_REPORT_FYEAR")
		);
		$rdoaValues = array_keys($rdoaLabels);
		
		return array(
			"opts" => $rdoaValues,
			"optsLabels" => $rdoaLabels,
		);
	}
	
	public static function generateChartFileNames($reportChartsEngine, $charts) {
		
		$tmpFilesDir = "modules/asol_Reports/tmpReportFiles/";
		$fileExtension = ($reportChartsEngine) ? ".xml" : ".js";
		$chartsUrls = array();
		
		foreach ($charts['charts'] as $chart) {

			$xmlName = count($chartsUrls)."_".dechex(time()).dechex(rand(0,999999)).$fileExtension;
			
			if ($chart['data'] == 'yes') {
				$chartsUrls[] = $tmpFilesDir.$xmlName;
			}

		}
		
		return $chartsUrls;
		
	}
	
	public static function isEmptyResultSet($resultSet) {
		
		$emptyResultSet = true;
		
		if (!empty($resultSet)) {
		
			foreach ($resultSet as $currentRow) {
				
				foreach ($currentRow as $currentCell) {
					if (!empty($currentCell)) {
						$emptyResultSet = false;
						break;
					}
				}
				
				if (!$emptyResultSet)
					break;
				
			}
			
		}
		
		return $emptyResultSet;
		
	}
	
	public static function getExportedSerializedReportFileContent($fileName) {
		
		$exportFolder = "modules/asol_Reports/tmpReportFiles/";
		
		$filePath = $exportFolder.$fileName;
		$exportFile = fopen($filePath, "r");
		$serializedReport = fread($exportFile, filesize($filePath));
		fclose($exportFile);
		
		$unserializedReport = unserialize($serializedReport);
		
		$theUser = BeanFactory::getBean('Users', $report["current_user_id"]);
		$gmtZone = $theUser->getUserDateTimePreferences();
		$userTZ = $theUser->getPreference("timezone")." ".$gmtZone["userGmt"];
		
		$reportDate = filectime($exportFolder.$fileName);
		
		return array(
			'unserializedReport' => $unserializedReport,
			'reportDate' => $reportDate,
			'userTZ' => $userTZ
		);
		
	}
	
	public static function processDownloadRequest($report, $userTZ, $fileTime, $fileType, $somePngs, $someLegends, $someEngines) {

		global $mod_strings, $sugar_config;

		require_once("modules/asol_Reports/include/ReportFile.php");
		require_once("modules/asol_Reports/include/ReportExcel.php");
		require_once("modules/asol_Reports/include/generateReportsFunctions.php");
		
		$fileContent = null;
		
		$exportFolder = "modules/asol_Reports/tmpReportFiles/";
		$currentDir = getcwd()."/";
		
		$fileName = $exportFolder.$fileName;

		
		//Volcamos el contenido del report exportado en variables
		$report_name = $report["name"];
		$report_module = $report["module"];
		$descriptionArray = unserialize(base64_decode($report["description"]));
		$description = $descriptionArray['public'];
		$isDetailedReport = $report["isDetailedReport"];
		$isGroupedReport = $report["isGroupedReport"];
		
		$hasGroupedTotalBelowColumn = $report["hasGroupedTotalBelowColumn"];
		
		$reportScheduledTypeArray = explode(':', $report["reportScheduledType"]);
		$reportScheduledType = (empty($reportScheduledTypeArray[0])) ? 'email' : $reportScheduledTypeArray[0];
		$reportScheduledTypeInfo = (empty($reportScheduledTypeArray[1])) ? null : json_decode(urldecode($reportScheduledTypeArray[1]), true);
		
		$displayTitles = $report["displayTitles"];
		$displayHeaders = $report["displayHeaders"];
		$hasDisplayedCharts = $report["hasDisplayedCharts"];
		$pdf_orientation = $report["pdf_orientation"];
		$pdf_img_scaling_factor = $report["pdf_img_scaling_factor"];
		$pdf_pageFormat = $report["pdf_pageFormat"];
		//Only if AlineaSolDomains installed
		$reportDomainId = (isset($report["asol_domain_id"])) ? $report["asol_domain_id"] : null;
		//Only if AlineaSolDomains installed
		
		$report_charts = $report["report_charts"];
		$report_charts_engine = $report["report_charts_engine"];
		
		$attachmentFormatArray = explode(':', $report["report_attachment_format"]);
		$reportAttachmentFormat = $attachmentFormatArray[0];
		$reportAttachmentConfig = (!empty($attachmentFormatArray[1]) ? json_decode(urldecode($attachmentFormatArray[1]), true) : null);
		
		$row_index_display = $report["row_index_display"];
	
		$email_list = $report["email_list"];
		
		$created_by = $report["created_by"];
		
		$columns = $report["headers"];
		$totals = $report["headersTotals"];
		$rsTotals = $report["totals"];
		
		$rs = $report["resultset"];
		$rsNoFormat = $report["resultsetNoFormat"];
		$subGroups = $report["resultset"];

		
		$subTotals = $report["subTotals"];

		$columnsDataFields = $report['columnsDataFields'];
		$columnsDataTypes = $report['columnsDataTypes'];
		$columnsDataFunctions = $report['columnsDataFunctions'];
		$columnsDataVisible	= $report['columnsDataVisible'];
		$columnsDataWidths	= $report['columnsDataWidths'];
			
		$currentReportCss = $report['currentReportCss'];
		
		
		//Only if AlineaSolDomains installed
		$contextDomainId = $report["context_domain_id"];
		//Only if AlineaSolDomains installed
		
		
		
		$rsExport = $rs;
		$rsExportNoFormat = $rsNoFormat;
		$subTotalsExport = ($isDetailedReport ? $subTotals : '');
		
		if ($fileType == 'app') {

			//***********************//
			//***AlineaSol Premium***//
			//***********************//
			$extraParams = array(
				'scheduledTypeInfo' => $reportScheduledTypeInfo,
				'csvData' => array(
					'reportName' => $report['name'],
					'headers' => $columns,
					'resultset' => $rsExport,
					'resultsetNoFormat' => $rsExportNoFormat,
					'subtotals' => $subTotalsExport,
					'isDetailed' => $isDetailedReport,
					'rowIndexDisplay' => $report['row_index_display']
				)
			);
			
			asol_ReportsUtils::managePremiumFeature("externalApplicationReports", "reportFunctions.php", "sendReportToExternalApplication", $extraParams);
			//***********************//
			//***AlineaSol Premium***//
			//***********************//
			
		} else if ($fileType == 'tl') {

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
			
		} else if (in_array($fileType, array('email', 'ftp'))) {
			
			$pngSrcs = Array();
			$legends = Array();
			$engines = Array();
			
			if ($hasDisplayedCharts) {
					
				if (!in_array($reportAttachmentFormat, array('CSV', 'CSVC', 'XLS', 'XLSC'))) {
						
					if (in_array($report_charts, array('Char', 'Both', 'Htob'))) {
			
						//Generamos las imagenes
						$pngs = explode("%pngSeparator", $somePngs);
						foreach ($pngs as $key=>$png) {
							$pngSrcs[$key] = $png;
						}
						$legends = explode("%legendSeparator", $someLegends);
						$engines = explode(";", $someEngines);
							
					}
						
				}
					
			}
			
			switch ($reportAttachmentFormat) {
					
				case "HTML":
					if ($report_charts == "Char") {
						$columns = array();
						$rsExport = array();
						$rsTotals = array();
					}
					$attachment = generateFile($reportAttachmentConfig, $report_name, $report_module, $description, $displayTitles, $displayHeaders, array_keys($columns), $rsExport, $rsExportNoFormat, $totals, $rsTotals, $subTotalsExport, $isDetailedReport, $isGroupedReport, $hasGroupedTotalBelowColumn, $pdf_orientation, $pngs, $legends, $engines, true, 100, $fileTime, $userTZ, $row_index_display, $report_charts, $columnsDataTypes, $columnsDataFunctions, $columnsDataVisible, $columnsDataWidths, $currentReportCss, $contextDomainId, $pdf_pageFormat, $report['chatLayout']);
					break;
						
				case "PDF":
					if ($report_charts == "Char") {
						$columns = array();
						$rsExport = array();
						$rsTotals = array();
					}
					$attachment = generateFile($reportAttachmentConfig, $report_name, $report_module, $description, $displayTitles, $displayHeaders, array_keys($columns), $rsExport, $rsExportNoFormat, $totals, $rsTotals, $subTotalsExport, $isDetailedReport, $isGroupedReport, $hasGroupedTotalBelowColumn, $pdf_orientation, $pngSrcs, $legends, $engines, false, $pdf_img_scaling_factor, $fileTime, $userTZ, $row_index_display, $report_charts, $columnsDataTypes, $columnsDataFunctions, $columnsDataVisible, $columnsDataWidths, $currentReportCss, $contextDomainId, $pdf_pageFormat, $report['chatLayout']);
					break;
						
				case "CSV":
					$attachment = generateCsv($reportAttachmentConfig, $report_name, array_keys($columns), $rsExport, $rsExportNoFormat, $totals, $rsTotals, $subTotalsExport, $isDetailedReport, $isGroupedReport, $hasGroupedTotalBelowColumn, false, $row_index_display, $columnsDataTypes, $columnsDataVisible, false, !$displayTitles, !$displayHeaders);
					break;
						
				case "CSVC":
					$attachment = generateCsv($reportAttachmentConfig, $report_name, array_keys($columns), $rsExport, $rsExportNoFormat, $totals, $rsTotals, $subTotalsExport, $isDetailedReport, $isGroupedReport, $hasGroupedTotalBelowColumn, false, $row_index_display, $columnsDataTypes, $columnsDataVisible, true, true, false, false, true);
					break;
						
				case "XLS":
					$attachment = generateXls($reportAttachmentConfig, $report_name, array_keys($columns), $rsExport, $rsExportNoFormat, $totals, $rsTotals, $subTotalsExport, $isDetailedReport, $isGroupedReport, $hasGroupedTotalBelowColumn, false, $row_index_display, $columnsDataTypes, $columnsDataVisible, false, !$displayTitles, !$displayHeaders);
					break;
						
				case "XLSC":
					$attachment = generateXls($reportAttachmentConfig, $report_name, array_keys($columns), $rsExport, $rsExportNoFormat, $totals, $rsTotals, $subTotalsExport, $isDetailedReport, $isGroupedReport, $hasGroupedTotalBelowColumn, false, $row_index_display, $columnsDataTypes, $columnsDataVisible, true, true, false, true, true);
					break;
						
			}
			
			if ($fileType == 'email') {
			
				$mail = self::getRetrievedReportMailer($email_list, $created_by, $report_name, $report_module, $description, $contextDomainId);
			
				//Añadimos el Report como fichero adjunto del e-mail
				$mail->AddAttachment($currentDir.$exportFolder.$attachment, $attachment);
			
				//Exito sera true si el email se envio satisfactoriamente, false en caso comtrario
				$success = $mail->Send();
					
				$tries=1;
				while ((!$success) && ($tries < 5)) {
			
					sleep(5);
					$success = $mail->Send();
					$tries++;
			
				}
			
			} else if ($fileType == 'ftp') {

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
			
			unlink($currentDir.$exportFolder.$attachment);
			
		} else {
						
			if ($fileType == 'csv') {
	
				$filePath = generateCsv($reportAttachmentConfig, $report_name, array_keys($columns), $rsExport, $rsExportNoFormat, $totals, $rsTotals, $subTotalsExport, $isDetailedReport, $isGroupedReport, $hasGroupedTotalBelowColumn, false, $row_index_display, $columnsDataTypes, $columnsDataVisible, false, !$displayTitles, !$displayHeaders);
				
			} else if ($fileType == 'csvc') {
	
				$filePath = generateCsv($reportAttachmentConfig, $report_name, array_keys($columns), $rsExport, $rsExportNoFormat, $totals, $rsTotals, $subTotalsExport, $isDetailedReport, $isGroupedReport, $hasGroupedTotalBelowColumn, false, $row_index_display, $columnsDataTypes, $columnsDataVisible, true, true, false, false, true);
				
			} else if ($fileType == 'xls') {
	
				$filePath = generateXls($reportAttachmentConfig, $report_name, array_keys($columns), $rsExport, $rsExportNoFormat, $totals, $rsTotals, $subTotalsExport, $isDetailedReport, $isGroupedReport, $hasGroupedTotalBelowColumn, false, $row_index_display, $columnsDataTypes, $columnsDataVisible, false, !$displayTitles, !$displayHeaders);
				
			} else if ($fileType == 'xlsc') {
	
				$filePath = generateXls($reportAttachmentConfig, $report_name, array_keys($columns), $rsExport, $rsExportNoFormat, $totals, $rsTotals, $subTotalsExport, $isDetailedReport, $isGroupedReport, $hasGroupedTotalBelowColumn, false, $row_index_display, $columnsDataTypes, $columnsDataVisible, true, true, false, true, true);
				
			} else if ($fileType == 'html') {
	
				$pngSrcs = ((($hasDisplayedCharts) && (in_array($report_charts, array("Char", "Both", "Htob")))) ? explode("%pngSeparator", $_REQUEST['pngs']) : array());
				$legends = ((($hasDisplayedCharts) && (in_array($report_charts, array("Char", "Both", "Htob")))) ? explode("%legendSeparator", $_REQUEST['legends']) : array());
				$engines = ((($hasDisplayedCharts) && (in_array($report_charts, array("Char", "Both", "Htob")))) ? explode(";", $_REQUEST['engines']) : array());
				
				$rsExport = ($report_charts == "Char" ? array() : $rsExport);
				$rsTotals = ($report_charts == "Char" ? array() : $rsTotals);
	
				$filePath = generateFile($reportAttachmentConfig, $report_name , $report_module, $description, $displayTitles, $displayHeaders, array_keys($columns), $rsExport, $rsExportNoFormat, $totals, $rsTotals, $subTotalsExport, $isDetailedReport, $isGroupedReport, $hasGroupedTotalBelowColumn, $pdf_orientation, $pngSrcs, $legends, $engines, true, 100, $fileTime, $userTZ, $row_index_display, $report_charts, $columnsDataTypes, $columnsDataFunctions, $columnsDataVisible, $columnsDataWidths, $currentReportCss, $contextDomainId,$pdf_pageFormat, $report['chatLayout']);
				
			} else if ($fileType == 'pdf') {
	
				$pngSrcs = Array();
				$legends = Array();
				$engines = Array();
					
				if ($hasDisplayedCharts){
			
					if (in_array($report_charts, array("Char", "Both", "Htob"))) {
					
						//Generamos las imagenes
						$pngs = explode("%pngSeparator", rawurldecode($somePngs));
						foreach ($pngs as $key=>$png) {
							$pngSrcs[$key] = $png;
						}
						$legends = explode("%legendSeparator", $someLegends);
						$engines = explode(";", $someEngines);
						
						
					} 
			
				}
				
				$columns = ($report_charts == "Char" ? array() : $columns);
				$rsExport = ($report_charts == "Char" ? array() : $rsExport);
				$rsTotals = ($report_charts == "Char" ? array() : $rsTotals);
				
				$filePath = generateFile($reportAttachmentConfig, $report_name , $report_module, $description, $displayTitles, $displayHeaders, array_keys($columns), $rsExport, $rsExportNoFormat, $totals, $rsTotals, $subTotalsExport, $isDetailedReport, $isGroupedReport, $hasGroupedTotalBelowColumn, $pdf_orientation, $pngSrcs, $legends, $engines, false, $pdf_img_scaling_factor, $fileTime, $userTZ, $row_index_display, $report_charts, $columnsDataTypes, $columnsDataFunctions, $columnsDataVisible, $columnsDataWidths, $currentReportCss, $contextDomainId, $pdf_pageFormat, $report['chatLayout']);
				
			}
			
			$fileContent = file_get_contents($currentDir.$exportFolder.$filePath);


		}
		
		return array(
			'fileName' => $filePath,
			'fileContent' => $fileContent
		);
		
	}
	
	public static function getRetrievedReportMailer($emailList, $createdBy, $reportName, $reportModule, $reportDescription, $contextDomainId) {

		require_once("include/SugarPHPMailer.php");
		
		global $mod_strings, $app_list_strings, $sugar_config;
		
		//************************//
		//****Get Email Arrays****//
		//************************//
		$emailReportInfo = asol_ReportsGenerationFunctions::getEmailInfo($emailList);
		
		$emailFrom = $emailReportInfo['emailFrom'];
		$emailArrays = $emailReportInfo['emailArrays'];
			
		$users_to = $emailArrays['users_to'];
		$users_cc = $emailArrays['users_cc'];
		$users_bcc = $emailArrays['users_bcc'];
		$roles_to = $emailArrays['roles_to'];
		$roles_cc = $emailArrays['roles_cc'];
		$roles_bcc = $emailArrays['roles_bcc'];
		$emails_to = $emailArrays['emails_to'];
		$emails_cc = $emailArrays['emails_cc'];
		$emails_bcc = $emailArrays['emails_bcc'];
			
		//Generar array con emails a enviar Report
		$mail = new SugarPHPMailer();
		if (asol_CommonUtils::isDomainsInstalled()) {
			$mail->setMailerForSystem($contextDomainId);
		} else {
			$mail->setMailerForSystem();
		}
		
		$user = new User();
		
		//created by
		$mail_config = $user->getEmailInfo($createdBy);
		if (!empty($emailFrom)) {
			$mail->From = $emailFrom;
		} else if (!empty($mail->From)) {
			$mail->From = (isset($sugar_config["asolReportsEmailsFrom"]) ? $sugar_config["asolReportsEmailsFrom"] : $mail_config['email']);
		}
		if (!empty($mail->FromName)) {
			$mail->FromName = (isset($sugar_config["asolReportsEmailsFromName"]) ? $sugar_config["asolReportsEmailsFromName"] : $mail_config['name']);
		}
		
		//Timeout del envio de correo
		$mail->Timeout=30;
		$mail->CharSet = "UTF-8";
		
			
		asol_ReportsGenerationFunctions::setSendEmailAddresses($mail, $emailArrays, $contextDomainId);
		
		
		if (asol_CommonUtils::isDomainsInstalled()) {
		
			$reportDomain = ($contextDomainId !== null) ? $contextDomainId : $current_user->asol_default_domain;
			$mail->Subject = "[".BeanFactory::getBean('asol_Domains', $contextDomainId)->name."] ".$mod_strings['LBL_REPORT_REPORTS_ACTION'].": ".$reportName;
		
		} else {
		
			$mail->Subject = $mod_strings['LBL_REPORT_REPORTS_ACTION'].": ".$reportName;
				
		}
		
		$mail->Body = "<b>".$mod_strings['LBL_REPORT_NAME'].": </b>".$reportName."<br>";
		$mail->Body .= "<b>".$mod_strings['LBL_REPORT_MODULE'].": </b>".$app_list_strings["moduleList"][$reportModule]."<br>";
		$mail->Body .= "<b>".$mod_strings['LBL_REPORT_DESCRIPTION'].": </b>".$reportDescription;
		
		//Mensaje en caso de que el destinatario no admita emails en formato html
		$mail->AltBody = $mod_strings['LBL_REPORT_NAME'].": ".$reportName."\n";
		$mail->AltBody .= $mod_strings['LBL_REPORT_MODULE'].": ".$app_list_strings["moduleList"][$reportModule]."\n";
		$mail->AltBody .= $mod_strings['LBL_REPORT_DESCRIPTION'].": ".$reportDescription;
		
		
		return $mail;
		
	}
	
	public static function doTemporalFixes($reportTable, & $selectedFields, & $selectedFilters) {
		
		foreach ($selectedFields['tables'][0]['data'] as & $selectedField) {
			if ($selectedField['isRelated']) {
				$keyDotExploded = explode('.', $selectedField['key']);
				if ($keyDotExploded[0] == $reportTable.'_cstm') {
					$selectedField['key'] = $keyDotExploded[1];
				}
			}
		}
		
		foreach ($selectedFilters['data'] as & $selectedFilter) {
			if ($selectedFilter['isRelated']) {
				$keyDotExploded = explode('.', $selectedFilter['relationKey']);
				if ($keyDotExploded[0] == $reportTable.'_cstm') {
					$selectedFilter['relationKey'] = $keyDotExploded[1];
				}
			}
		}
		
	}

	public static function getTypesWeightedWidthArray() {
		
		return array(
			"default" => 25,
			"noHeaderButton" => 1,
			"index" => 5,
				
			"int" => 10,
			"bigint" => 10,
			"float" => 10,
			"decimal" => 10,
			"double" => 10,
			"currency" => 10,
			
			"enum" => 15,
			"radioenum" => 15,
			"multienum" => 30,
				
			"date" => 15,
			"datetime" => 20,
			"datetimecombo" => 20,
			"timestamp" => 20,
				
			"bool" => 10,
			"tinyint(1)" => 10,
				
			"percent" => 10,
				
			"varchar" => 20,
			"text" => 30
		);
				
	}
	public static function getRowTotalWeightedWidth($fieldTypes, $fieldFunctions, $fieldVisibles, $typesWeightedWidth, $isGroupedReport, $hasRowIndex) {

		$totalWeightedWidth = ($hasRowIndex ? $typesWeightedWidth['index'] : 0);
		
		foreach ($fieldTypes as $fieldKey => $fieldType) {
			if ((!in_array($fieldVisibles[$fieldKey], array('html', 'internal'))) && ($isGroupedReport || !isset($fieldFunctions[$fieldKey]))) {
				$totalWeightedWidth += (isset($typesWeightedWidth[$fieldType]) ? $typesWeightedWidth[$fieldType] : $typesWeightedWidth['default']);
			}
		}
		
		return $totalWeightedWidth;
		
	}
	
	public static function getCellWidthBasedOnTypology($fieldType, $typesWeightedWidth, $totalWeightedWidth) {

		$currentWeightedWidth = (isset($typesWeightedWidth[$fieldType]) ? $typesWeightedWidth[$fieldType] : $typesWeightedWidth['default']);

		return (($currentWeightedWidth * 100) / $totalWeightedWidth);
		
	}
	
	public static function convertDateFiltersToDatabaseFormat(& $availableFilters) {
		
		global $timedate;
		
		foreach($availableFilters['data'] as & $currentFilter) {
				
			if (in_array($currentFilter['type'], array("date", "datetime", "datetimecombo", "timestamp")) && !in_array($currentFilter['operator'], array("last", "this", "these", "next", "not last", "not this", "not next"))) {
		
				if (!in_array($currentFilter['operator'], array("equals", "not equals", "before date", "after date", "between", "not between"))) {
					foreach($currentFilter['parameters']['first'] as & $currentParameter) {
						if ((!$timedate->check_matching_format($currentParameter, $GLOBALS['timedate']->dbDayFormat)) && ($currentParameter != "")) {
							$NcurrentParameter = $timedate->swap_formats($currentParameter, $timedate->get_date_format(), $GLOBALS['timedate']->dbDayFormat );
							$currentParameter = $NcurrentParameter==''? $currentParameter : $NcurrentParameter;
						}
					}
				}
		
				if ((count($currentFilter['parameters']['first']) > 0) && (in_array($currentFilter['parameters']['first'][0], array("calendar")))) {
					foreach($currentFilter['parameters']['second'] as & $currentParameter) {
						if ((!$timedate->check_matching_format($currentParameter, $GLOBALS['timedate']->dbDayFormat)) && ($currentParameter != "")) {
							$NcurrentParameter = $timedate->swap_formats($currentParameter, $timedate->get_date_format(), $GLOBALS['timedate']->dbDayFormat );
							$currentParameter = $NcurrentParameter==''? $currentParameter : $NcurrentParameter;
						}
					}
		
					if (in_array($currentFilter['operator'], array("between", "not between"))) {
						foreach($currentFilter['parameters']['third'] as & $currentParameter) {
							if((!$timedate->check_matching_format($currentParameter, $GLOBALS['timedate']->dbDayFormat)) && ($currentParameter != "")) {
								$NcurrentParameter = $timedate->swap_formats($currentParameter, $timedate->get_date_format(), $GLOBALS['timedate']->dbDayFormat );
								$currentParameter = $NcurrentParameter==''? $currentParameter : $NcurrentParameter;
							}
						}
					}
						
				}
		
			}
		}
		
	} 
	
}
	
?>
