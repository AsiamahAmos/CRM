<?php 

require_once('modules/asol_Common/include/commonUtils.php');
require_once("modules/asol_Reports/include/server/controllers/controllerReports.php");
require_once("modules/asol_Reports/include/manageReportsFunctions.php");

$displayNoDataMsg = (($noDataReport) && ((empty($filtersPanel)) || ((!empty($filtersPanel)) && (!empty($searchCriteria)))));
$columnsCount = ($hasRowIndexDisplay ? count($columns)+1 : count($columns));

$hasUserInputsFilters = !empty($filtersPanel);

$detailViewHttpFile = '';

if ($availableReport) {

	if ($maxAllowedNotIndexedOrderBy && $hasDeletedNotIndexedOrderBy) {
	
		$detailViewHttpFile .= asol_ReportsGenerationFunctions::getReportNotIndexedOrderByAlert();
	
	}
	
	$detailViewHttpFile .= '<div class="asolReportExecution">';

	//***AlineaSol Premium***//
	if (!empty($currentReportCss)) {
		$detailViewHttpFile .= $currentReportCss;
	}
	//***AlineaSol Premium***//
	
	if (!$getExportData) {
	
		if (!$isDashlet) {
			
			$detailViewHttpFile .= '
			<form id="display_form" name="display_form" method="post" action="index.php" style="display: none;">
			
				<input type="hidden" value="asol_Reports" name="module">
				<input type="hidden" value="EditView" name="action">
				<input type="hidden" value="" name="return_module">
				<input type="hidden" value="" name="return_action">
				<input type="hidden" value="'.$report_data['record'].'" name="record">
				<input type="hidden" value="'.$pagination['current_page'].'" name="page_number">
				
				<input type="hidden" value="'.(($isDashlet) ? "true": "false").'" name="dashlet">
				
				<input type="hidden" value="'.$orders[0]['original'].'" name="sort_field">
				<input type="hidden" value="'.$orders[0]['index'].'" name="sort_index">
				<input type="hidden" value="'.$orders[0]['direction'].'" name="sort_direction">
			
				<input type="hidden" value="" name="pngs">
				<input type="hidden" value="" name="legends">
				<input type="hidden" value="" name="engines">
				<input type="hidden" value="'.implode(",", $chartSubGroupsValues).'" id="chartSubGroupsValues">
			
				<input type="hidden" id="display_external_filters" name="external_filters" value="'.str_replace(' ', '${nbsp}', $external_filters).'">
				<input type="hidden" id="display_search_criteria" name="search_criteria" value="'.$searchCriteria.'">
			
			</form>
			
			'.asol_ReportsGenerationFunctions::getReportExportForm('', $exportedReportFile, $executionMode, $isWsExecution);
	
		} else {
		
			$detailViewHttpFile .= '<input type="hidden" value="'.$pagination['current_page'].'" id="page_number_'.$dashletId.'" name="page_number_'.$dashletId.'">';
			$detailViewHttpFile .= '<input type="hidden" value="'.$orders[0]['original'].'" id="sort_field_'.$dashletId.'" name="sort_field_'.$dashletId.'">';
			$detailViewHttpFile .= '<input type="hidden" value="'.$orders[0]['direction'].'" id="sort_direction_'.$dashletId.'" name="sort_direction_'.$dashletId.'">';
			$detailViewHttpFile .= '<input type="hidden" value="'.$orders[0]['index'].'" id="sort_index_'.$dashletId.'" name="sort_index_'.$dashletId.'">';
			$detailViewHttpFile .= '<input type="hidden" value="'.implode(",", $chartSubGroupsValues).'" id="chartSubGroupsValues">';
				
			if ( ( ( (!$hasStaticFilters) || $isWsExecution) || $enableExport ) && $dashletExportButtons) {
			
				if ($isWsExecution) {
					
					$detailViewHttpFile .= '
					<form id="display_form" name="display_form" method="post" action="index.php" style="display: none;">
			
						<input type="hidden" value="asol_Reports" name="module">
						<input type="hidden" value="EditView" name="action">
						<input type="hidden" value="" name="return_module">
						<input type="hidden" value="" name="return_action">
						<input type="hidden" value="'.$report_data['record'].'" name="record">
						<input type="hidden" value="'.$pagination['current_page'].'" name="page_number">
						
						<input type="hidden" value="false" name="dashlet">
				
						<input type="hidden" value="'.$orders[0]['original'].'" name="sort_field">
						<input type="hidden" value="'.$orders[0]['index'].'" name="sort_index">
						<input type="hidden" value="'.$orders[0]['direction'].'" name="sort_direction">
					
					</form>';

					$detailViewHttpFile .= asol_ReportsGenerationFunctions::getReportDetailButtons($report_data['record'], $isMetaReport, $dataVisibility['filter'], $report_data['asol_domain_id'], $report_data['created_by'], $report_data['assigned_user_id'], $report_data['report_scope'], $report_data['report_attachment_format'], $sendEmailquestion, $reportScheduledTypeInfo, $filtersHiddenInputs, $searchCriteria, $isDashlet, $dashletId, $staticFilters, $externalCall, $getLibraries, $override_entries, $override_info, $scheduledEmailHideButtons, $displayNoDataMsg, $isWsExecution, $isPreview, $enableExport);	
					foreach ($availableMassiveButtons as $currentMassiveButton) {
						$detailViewHttpFile .= $currentMassiveButton;
					}
					
				}
				
				$detailViewHttpFile .= asol_ReportsGenerationFunctions::getReportExportForm($dashletId, $exportedReportFile, $executionMode, $isWsExecution);
			
			}
			
		}
		
		//***********************//
		//***AlineaSol Premium***//
		//***********************//
		$languagesJsonFieldHiddenInputs = asol_CommonUtils::managePremiumFeature("commonMultiLingualManagement", "commonFunctions.php", "getLanguagesJsonFieldHiddenInputs", null);
		$detailViewHttpFile .= ($languagesJsonFieldHiddenInputs !== false ? $languagesJsonFieldHiddenInputs : '');
		//***********************//
		//***AlineaSol Premium***//
		//***********************//
	
	}
	
	$detailViewHttpFile .= '

	<div id="reportDiv">';
	
			if (!$getExportData && $displayButtons != "bottom") {
				$detailViewHttpFile .= asol_ReportsGenerationFunctions::getReportDetailButtons($report_data['record'], $isMetaReport, $dataVisibility['filter'], $report_data['asol_domain_id'], $report_data['created_by'], $report_data['assigned_user_id'], $report_data['report_scope'], $report_data['report_attachment_format'], $sendEmailquestion, $reportScheduledTypeInfo, $filtersHiddenInputs, $searchCriteria, $isDashlet, $dashletId, $staticFilters, $externalCall, $getLibraries, $override_entries, $override_info, $scheduledEmailHideButtons, $displayNoDataMsg, $isWsExecution, $isPreview, $enableExport);
				foreach ($availableMassiveButtons as $currentMassiveButton) {
					$detailViewHttpFile .= $currentMassiveButton;
				}
			}

			if (!$searchCriteria) {
				$detailViewHttpFile .= asol_ReportsGenerationFunctions::getReportDetailSearchCriteria($report_data['record'], $dataVisibility['filter'], $filtersPanel, $filtersHiddenInputs, $external_filters, $searchCriteria, $currentUserId, $hasStaticFilters, $isDashlet, $dashletId, $cleanUpStyling, (isset($filterslayoutConfig) ? $filterslayoutConfig : null), (isset($search_mode) ? $search_mode : null));
			}
			
			if ($oversizedReport) {
				
				if ($searchCriteria) {
					$detailViewHttpFile .= asol_ReportsGenerationFunctions::getReportDetailSearchCriteria($report_data['record'], $dataVisibility['filter'], $filtersPanel, $filtersHiddenInputs, $external_filters, $searchCriteria, $currentUserId, $hasStaticFilters, $isDashlet, $dashletId, $cleanUpStyling, (isset($filterslayoutConfig) ? $filterslayoutConfig : null), (isset($search_mode) ? $search_mode : null));
				}
				
				$detailViewHttpFile .= asol_ReportsGenerationFunctions::getOversizedReportMessage($maxAllowedDisplayed, $maxAllowedParseMultiTable, $maxAllowedGroupByEntries, $totalEntries, $totalUngroupedEntries, $isDashlet, $externalCall);
				
			} else if (($filtersHiddenInputs == false) || ($searchCriteria == true)) {
				
				if (!empty($chartInfo)) {

					require_once("modules/asol_Reports/include/manageReportsFunctions.php");
					
					$chartDef= asol_ReportsCharts::getCrmChartHtml($focus->id, $report_charts_engine, $urlChart, $chartInfo, $dataReferences['charts'], $current_language, $theme, $isStoredReport, $isDashlet, $dashletId, $chartLayoutConfig);
					$chartScript .= $chartDef["chartHtml"];
					$chartDef = $chartDef["returnedCharts"];
					
					if (!$getExportData) {
						
						$returnedChartScript = "<input class='asolChartScript' type='hidden' value='".rawurlencode($chartScript)."' proccess='1'>";
						
						if (!$isMetaReport) {
							$containerSelector = ($isDashlet ? "#detailContainer".$dashletId : "#detailContainer"); 
							$returnedChartScript .= '
								<script type="text/javascript">
									$("div'.$containerSelector.'").find(".asolChartScript[proccess=\'1\']").each(function() {
										eval(decodeURIComponent($(this).val()));
									});
									$("div'.$containerSelector.'").find(".asolChartScript").attr("proccess", "0");
								</script>';
						}
						
					}
					
				}
				
				$detailViewHttpFileCharts = asol_ReportsGenerationFunctions::getChartContentsContainer($report_data['record'], $report_charts_engine, $urlChart, $chartDef, $getExportData);
				
				
				$detailViewHttpFile .=
					'<div '.( $hasUserInputsFilters ? 'id="resultSearchView" class="list view"' : '').'>';
					
					if ($searchCriteria) {
						$detailViewHttpFile .= asol_ReportsGenerationFunctions::getReportDetailSearchCriteria($report_data['record'], $dataVisibility['filter'], $filtersPanel, $filtersHiddenInputs, $external_filters, $searchCriteria, $currentUserId, $hasStaticFilters, $isDashlet, $dashletId, $cleanUpStyling, (isset($filterslayoutConfig) ? $filterslayoutConfig : null), (isset($search_mode) ? $search_mode : null));
					}

				 	if ((!$displayNoDataMsg) && ($dataVisibility['chart']) && ($report_data['report_charts'] == "Htob")) {
				 		$detailViewHttpFile .= $detailViewHttpFileCharts.$returnedChartScript;
				 	}
				 
					if ($dataVisibility['field']) {
					
						if (!$isDashlet) {

							if ($displayNoDataMsg) {

								if ($reportedError != null) {
									
									$reportHeaderMessage = asol_ReportsUtils::translateReportsLabel($focus->data_source['type'] == '0' ? 'LBL_REPORT_MYSQL_ERROR' : 'LBL_REPORT_API_ERROR');
									$reportHeaderInfo = '<span style="color:red">'.$reportedError.'</span>';
									$collapsibleHeaderId = null;
									
								} else {
									
									$reportHeaderMessage = asol_ReportsUtils::translateReportsLabel('LBL_REPORT_NO_RESULTS');
									$reportHeaderInfo = null;
									$collapsibleHeaderId = null;
								
								}
								
							} else {
								
								$reportHeaderMessage = ($displayTitles ? asol_ReportsUtils::translateReportsLabel('LBL_REPORT_RESULTS') : null);
								$reportHeaderInfo = null;
								$collapsibleHeaderId = 'resultDiv';
								
							}
							
							$detailViewHttpFile .= asol_ReportsGenerationFunctions::getReportHeaderInfo($isDashlet, $externalCall, $reportHeaderMessage, $reportHeaderInfo, ($getExportData ? null : $collapsibleHeaderId));
														
						} else {
							
							if ($displayNoDataMsg) {

								if ($reportedError != null) {
									
									$reportHeaderMessage = asol_ReportsUtils::translateReportsLabel($focus->data_source['type'] == '0' ? 'LBL_REPORT_MYSQL_ERROR' : 'LBL_REPORT_API_ERROR');
									$reportHeaderInfo = '<span style="color:red">'.$reportedError.'</span>';
									
								} else {
									
									$reportHeaderMessage = asol_ReportsUtils::translateReportsLabel('LBL_REPORT_NO_RESULTS');
									
								}
								
								$detailViewHttpFile .= ($reportHeaderInfo !== null) ? '<em class="asolReportMessage">'.$reportHeaderMessage.'</em>'.' : '.$reportHeaderInfo : '<em class="asolReportMessage">'.$reportHeaderMessage.'</em>';
								
							}
							
						}
						
						if (!$displayNoDataMsg) {
						
							$detailViewHttpFile .= '<div id="resultDiv">';

							if (!$isDetailedReport) {
					
								$detailViewHttpFile .=
								'<table id="resultTable" class="'.($cleanUpStyling ? '' : 'list ').'view asolReportsResultsTable">
									<tbody>';
									
								if ((!$hasNoPagination) && (in_array($displayPagination, array('top', 'all')))) {
									$detailViewHttpFile .= asol_ReportsGenerationFunctions::getReportDetailPagination($report_data['record'], $columnsCount, $externalCall, $getLibraries, $override_entries, $override_info, $override_config, $isDashlet, $dashletId, $pagination['total_pages'], $pagination['current_page'], $pagination['total_entries'], $orders[0]['original'], $orders[0]['direction'], $orders[0]['index'], $staticFilters, $hasUserInputsFilters);
								}
									
								if ($displayHeaders) {
								
									$detailViewHttpFile .=
										'<tr class="asolReportsHeadersRow">';
									
										//***********************//
										//***AlineaSol Premium***//
										//***********************//
										$massiveActionCheck = asol_ReportsUtils::managePremiumFeature("reportButtonFormat", "reportFunctions.php", "getMassiveActionCheck", array('dashletId' => $dashletId, 'availableMassiveButtons' => $availableMassiveButtons, 'isHeader' => true));
										$detailViewHttpFile .= ($massiveActionCheck !== false ? $massiveActionCheck : '');
										//***********************//
										//***AlineaSol Premium***//
										//***********************//
									
										if ($hasRowIndexDisplay) {
											$dataType = 'index';
											$dataWidthStyle = 'width: '.$columnsDataWidths['rowIndexDisplay'].'%';
											
											if (!$lightWeightHtml) {
												$cellClasses = 'data_header data_cell report_header report_cell data_header_'.$dataType.' data_cell_'.$dataType.' report_header_'.$dataType.' report_cell_'.$dataType;
											}
											
											$detailViewHttpFile .= '<th class="'.$cellClasses.'" style="'.$dataWidthStyle.'">N&deg;</th>';
										}
										
									$previousDataType = null;
											
									foreach ($columns as $cKey => $column) {
	
										$dataRef = $columnsDataRefs[$cKey];
										if (isset($dataReferences['fields']) && !in_array($dataRef, $dataReferences['fields']))
											continue;
										
										$dataType = $columnsDataTypes[$cKey];
										$dataVisible = $columnsDataVisible[$cKey];
										$dataWidthStyle = (isset($columnsDataWidths[$cKey]) ? 'width: '.$columnsDataWidths[$cKey].'%' : '');
										
										$cellClasses = '';
										if (!$lightWeightHtml) {
											$cellClasses = 'data_header data_cell report_header report_cell data_header_'.$dataType.' data_cell_'.$dataType.' report_header_'.$dataType.' report_cell_'.$dataType;
										}
										$isHiddenCell = in_array($dataVisible, array('html', 'internal'));
										$dataHiddenStyle = ($isHiddenCell ? 'display: none;' : '');
										
										$cellClasses .= ($isHiddenCell ? ' headerCellHidden '.$dataVisible : '');
										
										//***********************//
										//***AlineaSol Premium***//
										//***********************//
										$extraParams = array(
											'dataType' => $dataType,
											'previousDataType' => $previousDataType,
											'cellClasses' => $cellClasses,
											'dataWidthStyle' => $dataWidthStyle,
											'dataHiddenStyle' => $dataHiddenStyle
										);
										$hoverButtonTypeHeader = asol_ReportsUtils::managePremiumFeature("reportButtonFormat", "reportFunctions.php", "generateButtonHeaderHtml", $extraParams);
										//***********************//
										//***AlineaSol Premium***//
										//***********************//
										
										if ($hoverButtonTypeHeader !== false) {
											
											$detailViewHttpFile .= $hoverButtonTypeHeader;
											
										} else {
											 
											//***********************//
											//***AlineaSol Premium***//
											//***********************//
											$panelIdAttribute = '';
											if ($dataVisible == 'html') {
						    					$panelIdAttribute = asol_ReportsUtils::managePremiumFeature("reportButtonFormat", "reportFunctions.php", "generateButtonHeaderPanelAttribute", array('delimiterToken' => $delimiterToken, 'headerLabel' => $column['u']));
											}
						    				//***********************//
											//***AlineaSol Premium***//
											//***********************//
													
											$detailViewHttpFile .= '<th '.$panelIdAttribute.' class="'.$cellClasses.'" style="'.$dataHiddenStyle.$dataWidthStyle.'">';
										
											$avoidOrderingByNotIndexedField = ($maxAllowedNotIndexedOrderBy ? asol_ControllerQuery::avoidOrderingByNotIndexedField($report_table, $column['n'], $alternativeDb) : false);
	
							    			if (($column['o'] != "") && (!$externalCall) && (!$avoidOrderingByNotIndexedField) && (!$getExportData)) {
	
						    					if (!empty($column)) {
						    						
						    						if ($orders[0]['direction'] == '') {
						    							$orders[0]['direction'] = ($orders[0]['direction'] == 'ASC' ? 'DESC' : 'ASC');
						    						}
						    						   						
							    					if ($orders[0]['original'] !== $column['o'])
								    					$sortDirection = "ASC";
								    				else if ($orders[0]['direction'] == 'ASC')
								    					$sortDirection = "DESC";
								    				else
								    					$sortDirection = "ASC";
							    				
								    				$sortingClass = "";
								    				if (($orders[0]['original'] == $column['o']) && ($column['i'] == $orders[0]['index'])) {
								    					if ($orders[0]['direction'] == 'ASC') {
									    					$sortingClass = "up";
									    				} else if ($orders[0]['direction'] == 'DESC') { 
									    					$sortingClass = "down";
									    				}
								    				}
								    				
								    				$detailViewHttpFile .= '<a class="listViewThLinkS1 clickable Sorting_'.$column['r'].'" onclick="controllerReportDetail.reloadReport(this, \''.$report_data['record'].'\', false, {\'dashlet\':'.($isDashlet ? 'true' : 'false').', \'dashletId\':\''.$dashletId.'\', \'currentUserId\':\''.$current_user->id.'\', \'page_number\':\''.$pagination['current_page'].'\', \'sort_field\':\''.$column['o'].'\', \'sort_direction\':\''.$sortDirection.'\', \'sort_index\':\''.$column['i'].'\', \'getLibraries\':\''.($isDashlet && $getLibraries ? 'true' : 'false').'\', \'overrideEntries\':'.(!empty($override_entries) ? '\''.$override_entries.'\'' : 'null').', \'overrideInfo\':'.(!empty($override_info) ? '\''.urlencode(json_encode($override_info)).'\'' : 'null').', \'overrideConfig\':'.(!empty($override_config) ? '\''.urlencode(json_encode($override_config)).'\'' : 'null').', \'staticFilters\':'.(!empty($staticFilters) ? '\''.$staticFilters.'\'' : 'null').'});">'.$cKey.'</a>';				    				
									    			$detailViewHttpFile .= '&nbsp;<i class="icn-sort double '.$sortingClass.'"></i>';
								    			
							    				}
								    			
							    			} else {
							    				$detailViewHttpFile .= $cKey;
							    			}
								    			
							    			$detailViewHttpFile .= '</th>';
							    			
										}
										
										$previousDataType = $dataType;
							    		
									}
	
									$detailViewHttpFile .=
									'</tr>';
								
								}
							
								foreach ($reportFields as $fieldKey=>$field) {
								
									$rowStyle = $field['asolRowStyle'];
									$rowClass = $field['asolRowClass'];
									
									$rowZebraClass = ((($fieldKey + 1) % 2) == 0 ? 'evenListRowS1' : 'oddListRowS1');
									$cellZebraClass = ((($fieldKey + 1) % 2) == 0 ? 'row-even' : 'row-uneven');
									
									$detailViewHttpFile .=
							    	'<tr class="'.$rowZebraClass.(isset($rowClass) ? ' '.$rowClass : '').' asolReportsExecutionRow">';
							    		
										//***********************//
										//***AlineaSol Premium***//
										//***********************//
										$massiveActionCheck = asol_ReportsUtils::managePremiumFeature("reportButtonFormat", "reportFunctions.php", "getMassiveActionCheck", array('dashletId' => $dashletId, 'availableMassiveButtons' => $availableMassiveButtons, 'isHeader' => false));
										$detailViewHttpFile .= ($massiveActionCheck !== false ? $massiveActionCheck : '');
										//***********************//
										//***AlineaSol Premium***//
										//***********************//
									
										if ($hasRowIndexDisplay) {
											$dataType = 'index';
											$dataWidthStyle = 'width: '.$columnsDataWidths['rowIndexDisplay'].'%';
											
											if (!$lightWeightHtml) {
												$cellClasses = 'data_value data_cell report_value report_cell data_value_'.$dataType.' data_cell_'.$dataType.' report_value_'.$dataType.' report_cell_'.$dataType;
											}
											
											$detailViewHttpFile .= '<td class="'.$cellClasses.' '.$cellZebraClass.'" style="'.$dataWidthStyle.";".$rowStyle.'">'.($pagination['current_page']*$pagination['entries_per_page']+$fieldKey+1).'</td>';
										}
										
										$previousDataType = null;
										
										foreach ($columns as $key3 => $item3) {
											
											if (in_array($key3, array('asolRowStyle', 'asolRowClass'))) continue;

											$dataRef = $columnsDataRefs[$key3];
											if (isset($dataReferences['fields']) && !in_array($dataRef, $dataReferences['fields']))
												continue;
											
											$dataType = $columnsDataTypes[$key3];
											$dataVisible = $columnsDataVisible[$key3];
											$dataWidthStyle = (isset($columnsDataWidths[$key3]) ? 'width: '.$columnsDataWidths[$key3].'%;' : '');
											
											$cellClasses = '';
											if (!$lightWeightHtml) {
												$cellClasses = 'data_value data_cell report_value report_cell data_value_'.$dataType.' data_cell_'.$dataType.' report_value_'.$dataType.' report_cell_'.$dataType;
											}
											$isHiddenCell = in_array($dataVisible, array('html', 'internal'));
											$dataHiddenStyle = ($isHiddenCell ? 'display: none;' : '');
											
											$cellClasses .= ($isHiddenCell ? ' dataCellHidden '.$dataVisible : '');
											
											if ($dataType !== 'noHeaderButton') {
												
												$detailViewHttpFile .= ($previousDataType === 'noHeaderButton' ? '</div></td>' : '');
												$detailViewHttpFile .= '<td class="'.$cellClasses.' '.$cellZebraClass.'" style="'.$dataWidthStyle.$dataHiddenStyle.$rowStyle.'">'.$field[$key3].'</td>';
											
											} else {
													
												$detailViewHttpFile .= ($previousDataType !== 'noHeaderButton' ? '<td class="'.$cellClasses.' '.$cellZebraClass.'" style="'.$dataWidthStyle.$rowStyle.'"><div style="white-space: nowrap;">' : '').$field[$key3];
												
											}
											
											$previousDataType = $dataType;
											
										}
										
									$detailViewHttpFile .= 
									'</tr>';
			
								}
								
								if ($displayTotals) {

									if ($isGroupedReport && $hasGroupedTotalBelowColumn) {
									
										$detailViewHttpFile .=
										'<tr class="asolReportsGroupedTotal">';
										
										if ($hasRowIndexDisplay) {
											$dataWidthStyle = 'width: '.$columnsDataWidths['rowIndexDisplay'].'%';
											$detailViewHttpFile .= '<th class="totalCellInvisible" style="'.$dataWidthStyle.'"></th>';
										}
										
										foreach ($columns as $cKey => $column) {

											foreach ($rsTotals as $total) {
												
												$dataRef = $columnsDataRefs[$cKey];
												if (isset($dataReferences['fields']) && !in_array($dataRef, $dataReferences['fields']))
													continue;
												
												$dataType = $columnsDataTypes[$cKey];
												$dataVisible = $columnsDataVisible[$cKey];
												$dataWidthStyle = (isset($columnsDataWidths[$cKey]) ? 'width: '.$columnsDataWidths[$cKey].'%' : '');
												
												$isHiddenCell = in_array($dataVisible, array('html', 'internal'));
												$dataHiddenStyle = ($isHiddenCell ? 'display: none;' : '');
												
												if (isset($total[$cKey])) {
													
													$cellClasses = '';
													if (!$lightWeightHtml) {
														$cellClasses = 'total_value total_cell report_value report_cell total_value_'.$dataType.' total_cell_'.$dataType.' report_value_'.$dataType.' report_cell_'.$dataType;
													}
													$cellClasses .= ($isHiddenCell ? ' totalCellHidden '.$dataVisible : '');
												
													$detailViewHttpFile .= '<th class="'.$cellClasses.'" style="'.$dataHiddenStyle.$dataWidthStyle.'">'.$total[$cKey].'</th>';
	
												} else {
													
													$cellClass = ($isHiddenCell ? 'totalCellHidden' : 'totalCellInvisible');
													$detailViewHttpFile .= '<th class="'.$cellClass.'" style="'.$dataHiddenStyle.$dataWidthStyle.'"></th>';
													
												}
												
											}
												
										}
										
										$detailViewHttpFile .=
										'</tr>';
										
									}
								
								}
								
								if ((!$hasNoPagination) && (in_array($displayPagination, array('bottom', 'all')))) {
									$detailViewHttpFile .= asol_ReportsGenerationFunctions::getReportDetailPagination($report_data['record'], $columnsCount, $externalCall, $getLibraries, $override_entries, $override_info, $override_config, $isDashlet, $dashletId, $pagination['total_pages'], $pagination['current_page'], $pagination['total_entries'], $orders[0]['original'], $orders[0]['direction'], $orders[0]['index'], $staticFilters, $hasUserInputsFilters);
			  					}
								
								$detailViewHttpFile .= 
									'</tbody>
								</table>';
								
							} else {
								
								if ((!$hasNoPagination) && ($pagination['total_pages'] > 0) && (in_array($displayPagination, array('bottom', 'all')))) {
									
									$detailViewHttpFile .= '<table class="list view asolReportsPaginationTable"><tbody>';
									$detailViewHttpFile .= asol_ReportsGenerationFunctions::getReportDetailPagination($report_data['record'], $columnsCount, $externalCall, $getLibraries, $override_entries, $override_info, $override_config, $isDashlet, $dashletId, $pagination['total_pages'], $pagination['current_page'], $pagination['total_entries'], $orders[0]['original'], $orders[0]['direction'], $orders[0]['index'], $staticFilters, $hasUserInputsFilters);
									$detailViewHttpFile .= '</tbody></table>';
									
			  					}
			  					
								foreach ($reportFields as $key=>$item) {
								
									$detailViewHttpFile .=
									'<div class="'.($cleanUpStyling ? '' : 'list ').'view asolReportsDetailSection">
									<h4><em>'.$key.'</em></h4>
									<table class="asolReportsResultsTable">
										<tbody>';
									
									if ($displayHeaders) {
									
										$detailViewHttpFile .= '<tr>';
										
										//***********************//
										//***AlineaSol Premium***//
										//***********************//
										$massiveActionCheck = asol_ReportsUtils::managePremiumFeature("reportButtonFormat", "reportFunctions.php", "getMassiveActionCheck", array('dashletId' => $dashletId, 'availableMassiveButtons' => $availableMassiveButtons, 'isHeader' => true));
										$detailViewHttpFile .= ($massiveActionCheck !== false ? $massiveActionCheck : '');
										//***********************//
										//***AlineaSol Premium***//
										//***********************//
										
										if ($hasRowIndexDisplay) {
											$dataType = 'index';
											$dataWidthStyle = 'width: '.$columnsDataWidths['rowIndexDisplay'].'%';
											
											if (!$lightWeightHtml) {
												$cellClasses = 'data_header data_cell report_header report_cell data_header_'.$dataType.' data_cell_'.$dataType.' report_header_'.$dataType.' report_cell_'.$dataType;
											}
											
											$detailViewHttpFile .= '<th class="'.$cellClasses.'" style="'.$dataWidthStyle.'">N&deg;</th>';
										}
										
										$previousDataType = null;
									
										foreach ($columns as $cKey => $column) {
						
											$dataRef = $columnsDataRefs[$cKey];
											if (isset($dataReferences['fields']) && !in_array($dataRef, $dataReferences['fields']))
												continue;
											
											$dataType = $columnsDataTypes[$cKey];
											$dataVisible = $columnsDataVisible[$cKey];
											$dataWidthStyle = (isset($columnsDataWidths[$cKey]) ? 'width: '.$columnsDataWidths[$cKey].'%;' : '');
											
											$cellClasses = '';
											if (!$lightWeightHtml) {
												$cellClasses = 'data_header data_cell report_header report_cell data_header_'.$dataType.' data_cell_'.$dataType.' report_header_'.$dataType.' report_cell_'.$dataType;
											}
											
											$isHiddenCell = in_array($dataVisible, array('html', 'internal'));
											$dataHiddenStyle = ($isHiddenCell ? 'display: none;' : '');
											
											$cellClasses .= ($isHiddenCell ? ' headerCellHidden '.$dataVisible : '');
											
											//***********************//
											//***AlineaSol Premium***//
											//***********************//
											$extraParams = array(
												'dataType' => $dataType,
												'previousDataType' => $previousDataType,
												'cellClasses' => $cellClasses,
												'dataWidthStyle' => $dataWidthStyle,
												'dataHiddenStyle' => $dataHiddenStyle
											);
											$hoverButtonTypeHeader = asol_ReportsUtils::managePremiumFeature("reportButtonFormat", "reportFunctions.php", "generateButtonHeaderHtml", $extraParams);
											//***********************//
											//***AlineaSol Premium***//
											//***********************//
									
											if ($hoverButtonTypeHeader !== false) {
											
												$detailViewHttpFile .= $hoverButtonTypeHeader;
												
											} else {
												
												//***********************//
												//***AlineaSol Premium***//
												//***********************//
												$panelIdAttribute = '';
												if ($dataVisible == 'html') {
							    					$panelIdAttribute = asol_ReportsUtils::managePremiumFeature("reportButtonFormat", "reportFunctions.php", "generateButtonHeaderPanelAttribute", array('delimiterToken' => $delimiterToken, 'headerLabel' => $column['u']));
												}
							    				//***********************//
												//***AlineaSol Premium***//
												//***********************//
														
												$detailViewHttpFile .= '<th '.$panelIdAttribute.' class="'.$cellClasses.'" style="'.$dataHiddenStyle.$dataWidthStyle.'">';
											
												$avoidOrderingByNotIndexedField = ($maxAllowedNotIndexedOrderBy ? asol_ControllerQuery::avoidOrderingByNotIndexedField($report_table, $column['n'], $alternativeDb) : false);
	
								    			if (($column['o'] != "") && (!$externalCall) && (!$avoidOrderingByNotIndexedField) && (!$getExportData)) {

									    			if (!empty($column)) {
									    				
									    				if ($orders[0]['direction'] == '') {
									    					$orders[0]['direction'] = ($orders[0]['direction'] == 'ASC' ? 'DESC' : 'ASC');
									    				}
									    					
									    				if ($orders[0]['original'] !== $column['o'])
										    				$sortDirection = "ASC";
										    			else if ($orders[0]['direction'] == 'ASC')
										    				$sortDirection = "DESC";
										   				else
										   					$sortDirection = "ASC";
									    					
										   				$sortingClass = "";										   					
							    						if (($orders[0]['original'] == $column['o']) && ($orders[0]['direction'] == 'ASC')) {
							    							$sortingClass = "up";
							    						} else if (($orders[0]['original'] == $column['o']) && ($orders[0]['direction'] == 'DESC')) {
							    							$sortingClass = "down";
							    						}	
							    						
							    						$detailViewHttpFile .= '<a class="listViewThLinkS1 clickable Sorting_'.$column['r'].'" onclick="controllerReportDetail.reloadReport(this, \''.$report_data['record'].'\', false, {\'dashlet\':'.($isDashlet ? 'true' : 'false').', \'dashletId\':\''.$dashletId.'\', \'currentUserId\':\''.$current_user->id.'\', \'page_number\':\''.$pagination['current_page'].'\', \'sort_field\':\''.$column['o'].'\', \'sort_direction\':\''.$sortDirection.'\', \'sort_index\':\''.$column['i'].'\', \'getLibraries\':\''.($isDashlet && $getLibraries ? 'true' : 'false').'\', \'overrideEntries\':'.(!empty($override_entries) ? '\''.$override_entries.'\'' : 'null').', \'overrideInfo\':'.(!empty($override_info) ? '\''.urlencode(json_encode($override_info)).'\'' : 'null').', \'overrideConfig\':'.(!empty($override_config) ? '\''.urlencode(json_encode($override_config)).'\'' : 'null').', \'staticFilters\':'.(!empty($staticFilters) ? '\''.$staticFilters.'\'' : 'null').'});">'.$cKey.'</a>';
								    					$detailViewHttpFile .= '&nbsp;<i class="icn-sort double '.$sortingClass.'"></i>';
								    					
							    					}
							    						
						    					} else {
						    						$detailViewHttpFile .= $cKey;
						    					}
							    					
							    				$detailViewHttpFile .= '</th>';
												
											}
		
											$previousDataType = $dataType;
											
										}
				  						
										$detailViewHttpFile .=
				  						'</tr>';
									
									}
			  						
									foreach ($item as $key2=>$item2) {
			  							
										$rowStyle = $item2['asolRowStyle'];
										$rowClass = $field['asolRowClass'];
										
										$rowZebraClass = ((($key2 + 1) % 2) == 0) ? 'evenListRowS1' : 'oddListRowS1';
										$cellZebraClass = ((($key2 + 1) % 2) == 0 ? 'row-even' : 'row-uneven');
										
										$detailViewHttpFile .=
			  							'<tr class="'.$rowZebraClass.(isset($rowClass) ? ' '.$rowClass : '').' asolReportsExecutionRow">';
										
											//***********************//
											//***AlineaSol Premium***//
											//***********************//
											$massiveActionCheck = asol_ReportsUtils::managePremiumFeature("reportButtonFormat", "reportFunctions.php", "getMassiveActionCheck", array('dashletId' => $dashletId, 'availableMassiveButtons' => $availableMassiveButtons, 'isHeader' => false));
											$detailViewHttpFile .= ($massiveActionCheck !== false ? $massiveActionCheck : '');
											//***********************//
											//***AlineaSol Premium***//
											//***********************//
										
											if ($hasRowIndexDisplay) {
												
												$dataType = 'index';
												$dataWidthStyle = 'width: '.$columnsDataWidths['rowIndexDisplay'].'%';
												
												if (!$lightWeightHtml) {
													$cellClasses = 'data_value data_cell report_value report_cell data_value_'.$dataType.' data_cell_'.$dataType.' report_value_'.$dataType.' report_cell_'.$dataType;
												}
												
												$detailViewHttpFile .= '<td class="'.$cellClasses.' '.$cellZebraClass.'" style="'.$dataWidthStyle.";".$rowStyle.'">'.($key2+1).'</td>';
												
											}
										
											$previousDataType = null;
											
											foreach ($columns as $key3 => $item3) {
			  									
			  									if (in_array($key3, array('asolRowStyle', 'asolRowClass'))) continue;
			  									
			  									$dataRef = $columnsDataRefs[$key3];
			  									if (isset($dataReferences['fields']) && !in_array($dataRef, $dataReferences['fields']))
			  										continue;
			  									
			  									$dataType = $columnsDataTypes[$key3];
			  									$dataVisible = $columnsDataVisible[$key3];
			  									$dataWidthStyle = (isset($columnsDataWidths[$key3]) ? 'width: '.$columnsDataWidths[$key3].'%;' : '');
			  									
			  									$cellClasses = '';
			  									if (!$lightWeightHtml) {
													$cellClasses = 'data_value data_cell report_value report_cell data_value_'.$dataType.' data_cell_'.$dataType.' report_value_'.$dataType.' report_cell_'.$dataType;
			  									}
			  									$isHiddenCell = in_array($dataVisible, array('html', 'internal'));
			  									$dataHiddenStyle = ($isHiddenCell ? 'display: none;' : '');
			  									
			  									$cellClasses .= ($isHiddenCell ? ' dataCellHidden '.$dataVisible : '');

				  								if ($dataType !== 'noHeaderButton') {
													
													$detailViewHttpFile .= ($previousDataType === 'noHeaderButton' ? '</div></td>' : '');
													$detailViewHttpFile .= '<td class="'.$cellClasses.' '.$cellZebraClass.'" style="'.$dataWidthStyle.$dataHiddenStyle.$rowStyle.'">'.$item2[$key3].'</td>';
												
												} else {
														
													$detailViewHttpFile .= ($previousDataType !== 'noHeaderButton' ? '<td class="'.$cellClasses.' '.$cellZebraClass.'" style="'.$dataWidthStyle.'"><div style="white-space: nowrap;">' : '').$item2[$key3];
													
												}
												
												$previousDataType = $dataType;
													
		  									}
	
			  							$detailViewHttpFile .=
			  							'</tr>';
			  						
			  						}

			  						
			  						// Subtotals beginning
			  						if ($displaySubtotals) {
			  							
			  							if ($isGroupedReport && $hasGroupedTotalBelowColumn) {
	
		  									$detailViewHttpFile .=
		  									'<tr class="asolReportsGroupedTotal">';

		  									if ($hasRowIndexDisplay) {
		  										$detailViewHttpFile .= '<th class="totalCellInvisible"></th>';
		  									}
		  									
		  									foreach ($columns as $cKey => $column) {

		  										$dataRef = $columnsDataRefs[$cKey];
		  										if (isset($dataReferences['fields']) && !in_array($dataRef, $dataReferences['fields']))
		  											continue;
		  										
		  										$dataType = $columnsDataTypes[$cKey];
			  									$dataVisible = $columnsDataVisible[$cKey];
			  									$dataWidthStyle = (isset($columnsDataWidths[$cKey]) ? 'width: '.$columnsDataWidths[$cKey].'%' : '');
			  									
			  									$isHiddenCell = in_array($dataVisible, array('html', 'internal'));
			  									$dataHiddenStyle = ($isHiddenCell ? 'display: none;' : '');
			  										
			  									if (isset($subTotals[$key][$cKey])) {
			  												
			  										$cellClasses = '';
			  										if (!$lightWeightHtml) {
			  											$cellClasses = 'total_value total_cell report_value report_cell total_value_'.$dataType.' total_cell_'.$dataType.' report_value_'.$dataType.' report_cell_'.$dataType;
			  										}
			  										
			  										$cellClasses .= ($isHiddenCell ? ' totalCellHidden '.$dataVisible : '');
		  										
			  										$detailViewHttpFile .= '<th class="'.$cellClasses.'" style="'.$dataHiddenStyle.$dataWidthStyle.'">'.$subTotals[$key][$cKey].'</th>';
			  											
		  										} else {
		  											
		  											$cellClass = ($isHiddenCell ? 'totalCellHidden' : 'totalCellInvisible');
			  										$detailViewHttpFile .= '<th class="'.$cellClass.'" style="'.$dataHiddenStyle.$dataWidthStyle.'"></th>';
			  										
		  										}
		  										
		  									}
		  										
		  									$detailViewHttpFile .=
		  									'</tr>';

			  							} else {
			  							
					  						$detailViewHttpFile .=
					  						'<tr><td colspan='.$columnsCount.'>
					  						
					  						<table class="view asolReportsResultsTable" border=1>';
					  						
				  							$detailViewHttpFile .= '
					  						<tr>
					  						<td rowspan=2 class="asolReportsSubTotalTitle"><center><h3><em>'.$key.' '.$mod_strings['LBL_REPORT_SUBTOTALS'].'</em></h3></center></td>';
					  						
				  							if ($displayHeaders) {
				  								
												foreach ($subTotals[$key] as $key4=>$item4) {
													
													$dataRef = $columnsDataRefs[$key4];
													if (isset($dataReferences['fields']) && !in_array($dataRef, $dataReferences['fields']))
														continue;
													
				  									$dataType = $columnsDataTypes[$key4];
				  									$dataVisible = $columnsDataVisible[$key4];
				  									
				  									$isHiddenCell = in_array($dataVisible, array('html', 'internal'));
				  									$dataHiddenStyle = ($isHiddenCell ? 'display: none;' : '');
				  									
				  									$cellClasses = '';
				  									if (!$lightWeightHtml) {
														$cellClasses = 'subtotal_header subtotal_cell report_header report_cell subtotal_header_'.$dataType.' subtotal_cell_'.$dataType.' report_header_'.$dataType.' report_cell_'.$dataType;
				  									}
													$cellClasses .= ($isHiddenCell ? ' subHeaderCellHidden '.$dataVisible : '');
		
													$detailViewHttpFile .= '<th class="'.$cellClasses.'" style="'.$dataHiddenStyle.'">'.$key4.'</th>';
													
												}
				  							
				  							}
				  							
											$detailViewHttpFile .= 
											'</tr>';
	
					
											$detailViewHttpFile .= '<tr>';
											
											foreach ($subTotals[$key] as $key5=>$item5) {
												
												$dataRef = $columnsDataRefs[$key5];
												if (isset($dataReferences['fields']) && !in_array($dataRef, $dataReferences['fields']))
													continue;
												
			  									$dataType = $columnsDataTypes[$key5];
			  									$dataVisible = $columnsDataVisible[$key5];
			  									
			  									$isHiddenCell = in_array($dataVisible, array('html', 'internal'));
			  									$dataHiddenStyle = ($isHiddenCell ? 'display: none;' : '');
			  									
			  									$cellClasses = '';
			  									if (!$lightWeightHtml) {
													$cellClasses = 'subtotal_value subtotal_cell report_value report_cell subtotal_value_'.$dataType.' subtotal_cell_'.$dataType.' report_value_'.$dataType.' report_cell_'.$dataType;
			  									}
												$cellClasses .= ($isHiddenCell ? ' subtotalCellHidden '.$dataVisible : '');
												
												$detailViewHttpFile .= '<td class="'.$cellClasses.'" style="'.$dataHiddenStyle.'">'.$item5.'</td>';
												
											}
											
											$detailViewHttpFile .= '</tr>
											</table></td></tr>';
											
			  							}
			  						
			  						}
									// Subtotals end
									
			  						
									$detailViewHttpFile .= 
									'</tbody>
									</table>';
									
									$detailViewHttpFile .= '</div>';
									
								}
								
								if ((!$hasNoPagination) && ($pagination['total_pages'] > 0) && (in_array($displayPagination, array('bottom', 'all')))) {
									
									$detailViewHttpFile .= '<table class="list view asolReportsPaginationTable"><tbody>';
									$detailViewHttpFile .= asol_ReportsGenerationFunctions::getReportDetailPagination($report_data['record'], $columnsCount, $externalCall, $getLibraries, $override_entries, $override_info, $override_config, $isDashlet, $dashletId, $pagination['total_pages'], $pagination['current_page'], $pagination['total_entries'], $orders[0]['original'], $orders[0]['direction'], $orders[0]['index'], $staticFilters, $hasUserInputsFilters);
									$detailViewHttpFile .= '</tbody></table>';
			  					
								}

							}

							
							// Totals beginning
							if ($displayTotals && ($isDetailedReport || !$isGroupedReport || !$hasGroupedTotalBelowColumn)) {
								
								if (!$isDashlet) {
									
									$detailViewHttpFile .= '
									<div class="'.($cleanUpStyling ? '' : 'list ').'view">
									'.($displayTitles ? '<h4>'.$mod_strings['LBL_REPORT_TOTALS'].'</h4>' : '').'
									<table id="totalTable" class="asolReportsTotalsTable">';
									
								} else {
									$detailViewHttpFile .= '
									<div>
									<table id="totalTable" class="'.($cleanUpStyling ? '' : 'list ').'view asolReportsTotalsTable">';
								}
						
								
								$detailViewHttpFile .=
									'<tbody>';
										
										if ($displayHeaders) {
								
											if ($isGroupedReport && $hasGroupedTotalBelowColumn) {
											
												foreach ($rsTotals as $total) {
												
													$detailViewHttpFile .=
													'<tr class="asolReportsGroupedTotal">';
												
													if ($hasRowIndexDisplay) {
														$dataWidthStyle = 'width: '.$columnsDataWidths['rowIndexDisplay'].'%';
														$detailViewHttpFile .= '<th class="totalCellInvisible" style="'.$dataWidthStyle.'"></th>';
													}

													foreach ($columns as $cKey => $column) {
												
														$dataRef = $columnsDataRefs[$cKey];
														if (isset($dataReferences['fields']) && !in_array($dataRef, $dataReferences['fields']))
															continue;
														
														$dataType = $columnsDataTypes[$cKey];
														$dataVisible = $columnsDataVisible[$cKey];
														$dataWidthStyle = (isset($columnsDataWidths[$cKey]) ? 'width: '.$columnsDataWidths[$cKey].'%' : '');
												
														$isHiddenCell = in_array($dataVisible, array('html', 'internal'));
														$dataHiddenStyle = ($isHiddenCell ? 'display: none;' : '');
														
														if (isset($total[$cKey])) {
																
															$cellClasses = '';
															if (!$lightWeightHtml) {
																$cellClasses = 'total_header total_cell report_header report_cell total_header_'.$dataType.' total_cell_'.$dataType.' report_header_'.$dataType.' report_cell_'.$dataType;
															}
															$cellClasses .= ($isHiddenCell ? ' totalCellHidden '.$dataVisible : '');
												
															$detailViewHttpFile .= '<th class="'.$cellClasses.'" style="'.$dataHiddenStyle.$dataWidthStyle.'">'.$cKey.'</th>';
												
														} else {
																
															$cellClass = ($isHiddenCell ? 'totalCellHidden' : 'totalCellInvisible');
															$detailViewHttpFile .= '<th class="'.$cellClass.'" style="'.$dataHiddenStyle.$dataWidthStyle.'"></th>';
																
														}
												
													}
												
													$detailViewHttpFile .=
													'</tr>';
											
												}
												
											} else {
											
												$detailViewHttpFile .=
												'<tr>';
												
													foreach ($totals as $totalColumn) {
														
														$dataRef = $columnsDataRefs[$totalColumn['alias']];
														if (isset($dataReferences['fields']) && !in_array($dataRef, $dataReferences['fields']))
															continue;
														
														$dataType = $columnsDataTypes[$totalColumn['alias']];
														$dataVisible = $columnsDataVisible[$totalColumn['alias']];
														$dataWidthStyle = (isset($columnsDataWidths[$totalColumn['alias']]) ? 'width: '.$columnsDataWidths[$totalColumn['alias']].'%' : '');
														
														$isHiddenCell = in_array($dataVisible, array('html', 'internal'));
														$dataHiddenStyle = ($isHiddenCell ? 'display: none;' : '');
														
														$cellClasses = '';
														if (!$lightWeightHtml) {
															$cellClasses = 'total_header total_cell report_header report_cell total_header_'.$dataType.' total_cell_'.$dataType.' report_header_'.$dataType.' report_cell_'.$dataType;
														}
														$cellClasses .= ($isHiddenCell ? ' totalHeaderCellHidden '.$dataVisible : '');
														
										    			$detailViewHttpFile .= '<th class="'.$cellClasses.'" style="'.$dataHiddenStyle.'">'.$totalColumn['alias'].'</th>';
													
													}
				
										    	$detailViewHttpFile .=
												'</tr>';

											}
									    	
										}
										
								    	foreach ($rsTotals as $total) {
				
								    		if ($isGroupedReport && $hasGroupedTotalBelowColumn) {
								    		
							    				$detailViewHttpFile .=
							    				'<tr class="asolReportsGroupedTotal">';
							    			
							    				if ($hasRowIndexDisplay) {
							    					$dataWidthStyle = 'width: '.$columnsDataWidths['rowIndexDisplay'].'%';
							    					$detailViewHttpFile .= '<td class="totalCellInvisible" style="'.$dataWidthStyle.'"></td>';
							    				}

							    				foreach ($columns as $cKey=>$column) {
							    			
							    					$dataRef = $columnsDataRefs[$cKey];
							    					if (isset($dataReferences['fields']) && !in_array($dataRef, $dataReferences['fields']))
							    						continue;
							    					
							    					$dataType = $columnsDataTypes[$cKey];
							    					$dataVisible = $columnsDataVisible[$cKey];
							    					$dataWidthStyle = (isset($columnsDataWidths[$cKey]) ? 'width: '.$columnsDataWidths[$cKey].'%' : '');
							    			
							    					$isHiddenCell = in_array($dataVisible, array('html', 'internal'));
							    					$dataHiddenStyle = ($isHiddenCell ? 'display: none;' : '');
							    					
							    					if (isset($total[$cKey])) {
							    			
							    						$cellClasses = '';
							    						if (!$lightWeightHtml) {
							    							$cellClasses = 'total_value total_cell report_value report_cell total_value_'.$dataType.' total_cell_'.$dataType.' report_value_'.$dataType.' report_cell_'.$dataType;
							    						}
							    						$cellClasses .= ($isHiddenCell ? ' totalCellHidden '.$dataVisible : '');
							    			
							    						$detailViewHttpFile .= '<td class="'.$cellClasses.'" style="'.$dataHiddenStyle.$dataWidthStyle.'">'.$total[$cKey].'</td>';
							    			
							    					} else {
							    			
							    						$cellClass = ($isHiddenCell ? 'totalCellHidden' : 'totalCellInvisible');
							    						$detailViewHttpFile .= '<td class="'.$cellClass.'" style="'.$dataHiddenStyle.$dataWidthStyle.'"></td>';
							    			
							    					}
							    			
							    				}
							    			
							    				$detailViewHttpFile .=
							    				'</tr>';
								    			
								    		} else {
									    		
								    			$detailViewHttpFile .=
									    		'<tr>';
									    		
									    			foreach ($total as $key=>$value) {
									    				
									    				$dataRef = $columnsDataRefs[$key];
									    				if (isset($dataReferences['fields']) && !in_array($dataRef, $dataReferences['fields']))
									    					continue;
									    				
									    				$dataType = $columnsDataTypes[$key];
									    				$dataVisible = $columnsDataVisible[$key];
									    				$dataWidthStyle = (isset($columnsDataWidths[$key]) ? 'width: '.$columnsDataWidths[$key].'%' : '');
									    				
									    				$isHiddenCell = in_array($dataVisible, array('html', 'internal'));
									    				$dataHiddenStyle = ($isHiddenCell ? 'display: none;' : '');
									    				
									    				$cellClasses = '';
									    				if (!$lightWeightHtml) {
									    					$cellClasses = 'total_value total_cell report_value report_cell total_value_'.$dataType.' total_cell_'.$dataType.' report_value_'.$dataType.' report_cell_'.$dataType;
									    				}
														$cellClasses .= ($isHiddenCell ? ' totalCellHidden '.$dataVisible : '');
	
														$detailViewHttpFile .= '<td class="'.$cellClasses.'" style="'.$dataHiddenStyle.'">'.$value.'</td>';
														
									    			}
						
												$detailViewHttpFile .=
												'</tr>';
					
								    		}
								    	
								    	}
								    	
							$detailViewHttpFile .=				
									'</tbody>
								</table>
								</div>';
						}
						// Totals end
						
				    	$detailViewHttpFile .=				
							'</div>';
						
					} else {
						
						$detailViewHttpFile .=
						'<style>
							#dashletExport'.$dashletId.' {
								display: none;
							}
						</style>';
						
					}
					
				} else if (isset($displayPagination)) {
					
					$detailViewHttpFile .= asol_ReportsGenerationFunctions::getReportDetailPagination($report_data['record'], $columnsCount, $externalCall, $getLibraries, $override_entries, $override_info, $override_config, $isDashlet, $dashletId, $pagination['total_pages'], $pagination['current_page'], $pagination['total_entries'], $orders[0]['original'], $orders[0]['direction'], $orders[0]['index'], $staticFilters, $hasUserInputsFilters);
					
				} else if ($displayNoDataMsg) {

					if ($reportedError != null) {
						
						$reportHeaderMessage = asol_ReportsUtils::translateReportsLabel($focus->data_source['type'] == '0' ? 'LBL_REPORT_MYSQL_ERROR' : 'LBL_REPORT_API_ERROR');
						$reportHeaderInfo = '<span style="color:red">'.$reportedError.'</span>';
						
					} else {
						
						$reportHeaderMessage = asol_ReportsUtils::translateReportsLabel('LBL_REPORT_NO_RESULTS');
						$reportHeaderInfo = null;

					}
					
					$detailViewHttpFile .= asol_ReportsGenerationFunctions::getReportHeaderInfo($isDashlet, $externalCall, $reportHeaderMessage, $reportHeaderInfo);
					
					$detailViewHttpFile .=
					'<style>
						#dashletExport'.$dashletId.' {
							display: none;
						}
					</style>';
					
				}

				if ((!$displayNoDataMsg) && ($dataVisibility['chart']) && in_array($report_data['report_charts'], array("Both", "Char"))) {
					 $detailViewHttpFile .= $detailViewHttpFileCharts.$returnedChartScript;
				}
					
				$detailViewHttpFile .= '</div>';
					
			}
			
			if (!$getExportData && $displayButtons != "top") {
				$detailViewHttpFile .= asol_ReportsGenerationFunctions::getReportDetailButtons($report_data['record'], $isMetaReport, $dataVisibility['filter'], $report_data['asol_domain_id'], $report_data['created_by'], $report_data['assigned_user_id'], $report_data['report_scope'], $report_data['report_attachment_format'], $sendEmailquestion, $reportScheduledTypeInfo, $filtersHiddenInputs, $searchCriteria, $isDashlet, $dashletId, $staticFilters, $externalCall, $getLibraries, $override_entries, $override_info, $scheduledEmailHideButtons, $displayNoDataMsg, $isWsExecution, $isPreview, $enableExport);
				foreach ($availableMassiveButtons as $currentMassiveButton) {
					$detailViewHttpFile .= $currentMassiveButton;
				}
			}
	
	
	$detailViewHttpFile .= 
		'</div>
	</div>';
		

	
	if ((isset($justDisplay)) && ($justDisplay)) {
	
		if ($returnHtml) {
			return $detailViewHttpFile;
		} else {
			echo $detailViewHttpFile;
		}
		
	} else {
		
		$exportHttpFile = fopen($tmpFilesDir.$httpHtmlFile, "w");
		fwrite($exportHttpFile, $detailViewHttpFile);
		fclose($exportHttpFile);
		
		if ($returnHtml)
			return false;
		
	}
		
		
} else {

	$detailViewHttpFile .=
	'<style>
		#dashletExport'.$dashletId.' {
			display: none;
		}
	</style>
	
	<div class="detail view">
		'.asol_ReportsGenerationFunctions::getReportHeaderInfo($isDashlet, $externalCall, asol_ReportsUtils::translateReportsLabel('LBL_REPORT_NOT_AVAILABLE'), null, null).'
	</div>';
	
	if ($returnHtml) {
		return $detailViewHttpFile;
	} else {
		echo $detailViewHttpFile;
	}
	
}

		
?>
