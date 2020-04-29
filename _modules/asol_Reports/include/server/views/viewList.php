<?php
$reportsVersion = str_replace('.', '', asol_ReportsUtils::$reports_version);
?>
<link type="text/css" href="modules/asol_Reports/include/client/css/styleList.css?version=<?= $reportsVersion ?>" rel="stylesheet">
<script type="text/javascript" src="modules/asol_Reports/include/client/controllers/controllerList.js?version=<?= $reportsVersion ?>"></script>
<div style="display: <?php if ($selected): ?> block <?php else: ?> none <?php endif; ?>" id="listContainer" class="alineasol_reports">
	
	<div class="moduleTitle">
		<h2><?= $mod_strings['LBL_REPORT_SEARCH']; ?></h2>
	</div>
	<div class="clear"></div>
	<div class="actionsContainer">
		<input type="button" value="<?= $mod_strings['LBL_REPORT_CREATE']; ?>" onclick="controllerReportList.createReport();" class="button createReport">
		<?php
		//***********************//
		//***AlineaSol Premium***//
		//***********************//
		$createMetaButton = asol_ReportsUtils::managePremiumFeature("getCreateMetaReportButton", "reportFunctions.php", "getCreateMetaReportButton", null);
		echo ($createMetaButton !== false) ? $createMetaButton : '' ;
		//***********************//
		//***AlineaSol Premium***//
		//***********************//
		?>
	</div>
	<div class="listViewBody">
	
		<table style="width: 100%">
			<tbody>
				<tr>
					<td>
						<form id="search_form" name="search_form" class="search_form" action="index.php?module=asol_Reports&action=index" method="post" enctype="multipart/form-data" name="search_form">
							
							<input type="hidden" id="page_number" value="<?= $data['page_number']; ?>" name="page_number">
							<input type="hidden" id="sort_field" value="<?= $sort_field; ?>" name="sort_field">
							<input type="hidden" id="sort_direction" value="<?= $sort_direction; ?>" name="sort_direction">

							<div class="edit view search" style="" id="Reportsbasic_searchSearchReport">
								<table cellspacing="0" cellpadding="0" border="0" width="100%">
									<tbody>
										<tr>
											<td nowrap="nowrap" width="8.333%" scope="row">
												<?= $mod_strings['LBL_REPORT_NAME']; ?>
											</td>
											<td nowrap="nowrap" width="25%">
												<input type="text" value="<?= $name; ?>" maxlength="" size="30" id="name" name="name" onKeyDown="controllerReportList.searchOnKeyPressed(event);">
											</td>
											<td nowrap="nowrap" width="8.333%" scope="row">
												<?= $mod_strings['LBL_REPORT_DATA_SOURCE']; ?>
											</td>
											<td nowrap="nowrap" width="25%">
												<select style="max-width: 150px;" id="data_source_type" name="data_source_type" onChange="controllerReportList.manageDataSourceType(this);" onKeyDown="controllerReportList.searchOnKeyPressed(event);">
													<option value=""></option>
													<?= '<option value="0" '.($data_source['type'] == "0" ? 'selected' : '').'>'.$mod_strings['LBL_REPORT_DATA_SOURCE_DB'].'</option>' ?>
													<?= (!empty($availableApis) ? '<option value="1" '.($data_source['type'] == "1" ? 'selected' : '').'>'.$mod_strings['LBL_REPORT_DATA_SOURCE_API'].'</option>' : '') ?>
												</select>
												<select style="max-width: 150px; visibility: <?= (isset($data_source['type']) && $data_source['type'] !== '' ? 'inherit' : 'hidden') ?>" id="data_source_value" name="data_source_value" onChange="controllerReportList.manageDataSourceValue(this);" onKeyDown="controllerReportList.searchOnKeyPressed(event);">
													<option value="" tables="[]"></option>
													<option value="-1" <?= (isset($data_source['value']['database']) && $data_source['value']['database'] == "-1" ? 'selected' : '') ?> tables="<?= rawurlencode(json_encode($nativeModules)) ?>">CRM</option>
													<?php
													$availableModules = array();
													foreach ($availableDatabases as $dbKey=>$currentDb) {
	
														//***********************//
														//***AlineaSol Premium***//
														//***********************//
														$extraParams = array(
															'database' => $dbKey,
															'noRestrictions' => false,
														);
														$externalAvailableTables = asol_ReportsUtils::managePremiumFeature("externalDatabasesReports", "reportFunctions.php", "getExternalAvailableTables", $extraParams);
														$availableModules[$dbKey] = ($externalAvailableTables !== false) ? $externalAvailableTables : null;
														//***********************//
														//***AlineaSol Premium***//
														//***********************//
	
														echo '<option value="'.$dbKey.'" tables="'.(isset($availableModules[$dbKey]) ? urlencode(json_encode($availableModules[$dbKey])) : '[]').'" '.($data_source['value']['database'] === (string)$dbKey ? 'selected' : '').'>'.$currentDb.'</option>';
													
													}
													?>
												</select>
												<select style="width: 150px; visibility: <?= (empty($availableDatabases) || empty($data_source['value']['database']) ? 'hidden' : 'inherit') ?>" name="data_source_module" id="data_source_module" onKeyDown="controllerReportList.searchOnKeyPressed(event);">
													<option value=""></option>
											
													<?php
													if (empty($availableDatabases) || ($data_source['value']['database'] === "-1")) {
														foreach ($nativeModules as $keyModule=>$currentModule) {
															echo '<option value="'.$keyModule.'" '.($module == $keyModule ? 'selected' : '').'>'.$currentModule.'</option>';
														}
													} else {
														foreach ($availableModules[$data_source['value']['database']] as $keyModule=>$currentModule) {
															echo '<option value="'.$keyModule.'" '.($module == $keyModule ? 'selected' : '').'>'.$currentModule.'</option>';
														}
													}
													?>
													
												</select>
											</td>
											<td nowrap="nowrap" width="8.333%" scope="row">
												<?= $mod_strings['LBL_REPORT_ASSIGNED_TO']; ?>
											</td>
											<td nowrap="nowrap" width="25%">
												<input type="hidden" value="<?= $assigned_user_id; ?>" id="assigned_user_id" name="assigned_user_id">
												<input type="text" value="<?= $assigned_user_name; ?>" maxlength="" size="30" id="assigned_user_name" name="assigned_user_name" onKeyDown="controllerReportList.searchOnKeyPressed(event);">
												<i class="icn-search" onclick="open_popup('Users', 600, 400, '', true, false, {'call_back_function':'set_return','form_name':'search_form','field_to_name_array':{'id':'assigned_user_id','user_name':'assigned_user_name'}}, 'single', true);" title="<?= $app_strings['LBL_SELECT_BUTTON_LABEL']; ?>" id="btn_assigned_user_name" name="btn_assigned_user_name"></i>
												<i class="icn-cancel" onclick="document.search_form.assigned_user_id.value = ''; document.search_form.assigned_user_name.value = '';" title="<?= $app_strings['LBL_CLEAR_BUTTON_LABEL']; ?>" class="button" id="btn_clr_assigned_user_name" name="btn_clr_assigned_user_name"></i>
											</td>
										</tr>
										<tr>
											<td nowrap="nowrap" width="8.333%" scope="row">
												<?= $mod_strings['LBL_REPORT_SCOPE']; ?>
											</td>
											<td nowrap="nowrap" width="25%">
												<select id="scope" name="scope" onKeyDown="controllerReportList.searchOnKeyPressed(event);">
													<option value=""></option>
													<option value="private" <?php if ($scope == 'private'): ?> selected <?php endif; ?>><?= $mod_strings['LBL_REPORT_PRIVATE']; ?></option>
													<option value="public" <?php if ($scope == 'public'): ?> selected <?php endif; ?>><?= $mod_strings['LBL_REPORT_PUBLIC']; ?></option>
													<option value="role" <?php if ($scope == 'role'): ?> selected <?php endif; ?>><?= $mod_strings['LBL_REPORT_ROLE']; ?></option>
												</select>
											</td>
											<td nowrap="nowrap" width="8.333%" scope="row">
												<?= $mod_strings['LBL_REPORT_TYPE']; ?>
											</td>
											<td nowrap="nowrap" width="25%">
												<select id="type" name="type" onKeyDown="controllerReportList.searchOnKeyPressed(event);">
													<option value=""></option>
													<option value="manual" <?php if ($type == 'manual'): ?> selected <?php endif; ?>><?= $mod_strings['LBL_REPORT_MANUAL']; ?></option>
													<option value="internal" <?php if ($type == 'internal'): ?> selected <?php endif; ?>><?= $mod_strings['LBL_REPORT_INTERNAL']; ?></option>
													<option value="external" <?php if ($type == 'external'): ?> selected <?php endif; ?>><?= $mod_strings['LBL_REPORT_EXTERNAL']; ?></option>
													<option value="scheduled" <?php if ($type == 'scheduled'): ?> selected <?php endif; ?>><?= $mod_strings['LBL_REPORT_SCHEDULED']; ?></option>
													<option value="stored" <?php if ($type == 'stored'): ?> selected <?php endif; ?>><?= $mod_strings['LBL_REPORT_STORED']; ?></option>
													
													<?php 
													//***********************//
													//***AlineaSol Premium***//
													//***********************//
													$webServiceReportTypeOptions = asol_ReportsUtils::managePremiumFeature("WebServiceReports", "reportFunctions.php", "getWebServiceReportTypeOptions", array('selectedValue' => null));
													echo ($webServiceReportTypeOptions !== false ? $webServiceReportTypeOptions : '');
													//***********************//
													//***AlineaSol Premium***//
													//***********************//
													?>
													
												</select>
											</td>
											
											<?php 
											//***********************//
											//***AlineaSol Premium***//
											//***********************//
											$metaSearchCells = asol_ReportsUtils::managePremiumFeature("MetaReport", "reportFunctions.php", "getMetaSearchCells", array('selectedValue' => $meta));
											echo ($metaSearchCells !== false ? $metaSearchCells : '');
											//***********************//
											//***AlineaSol Premium***//
											//***********************//
											?>
											
											<td nowrap="nowrap" width="8.333%" scope="row"></td>
											<td nowrap="nowrap" width="25%"></td>
										</tr>
									</tbody>
								</table>
							</div>

							<input type="button" value="<?= $app_strings['LBL_SEARCH']; ?>" class="button" onclick="$('#page_number').val(0); controllerReportList.listReports();" title="<?= $app_strings['LBL_SEARCH']; ?>">
							<input type="button" value="<?= $app_strings['LBL_CLEAR_BUTTON_LABEL']; ?>" class="button" onclick="SUGAR.searchForm.clear_form(this.form);" title="<?= $app_strings['LBL_CLEAR_BUTTON_LABEL']; ?>">
			
						</form>
			
						<!-- List View Content -->
						<?php include("modules/asol_Reports/include/server/views/partials/listViewTable.php"); ?>
						<!-- List View Content -->
					
					</td>
				</tr>
			</tbody>
		</table>

	</div>

</div>