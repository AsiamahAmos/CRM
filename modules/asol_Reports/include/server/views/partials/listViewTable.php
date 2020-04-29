<table cellspacing="0" cellpadding="0" border="0" width="100%" class="list view" id="reportRows">
	<thead>
		<tr class="pagination">
			<td colspan="<?php if (asol_CommonUtils::isDomainsInstalled()): ?>11<?php else: ?>10<?php endif; ?>" align="right">
				<table cellspacing="0" cellpadding="0" border="0" width="100%" class="paginationTable">
					<tbody>
						<tr>
							<td nowrap="nowrap" align="right" width="2%" class="paginationChangeButtons">
								<button <?php if ($data["num_pages"] == 0 || $data["page_number"] == 0): ?> disabled <?php endif; ?> class="button" title="<?= $app_strings['LNK_LIST_START']; ?>" name="listViewStartButton" type="button" onClick="document.search_form.page_number.value=0; controllerReportList.listReports();">
									<i class="icn-fast-forward down" title="<?= $app_strings['LNK_LIST_START']; ?>"  <?php if ($data["num_pages"] == 0 || $data["page_number"] == 0): ?> style="opacity:0.2" <?php endif; ?>></i>
								</button>
								<button <?php if ($data["num_pages"] == 0 || $data["page_number"] == 0): ?> disabled <?php endif; ?> class="button" title="<?= $app_strings['LNK_LIST_PREVIOUS']; ?>" name="listViewPrevButton" type="button" onClick="document.search_form.page_number.value=<?= $prev_number_page; ?>; controllerReportList.listReports();"> 						
									<i class="icn-play down" title="<?= $app_strings['LNK_LIST_PREVIOUS']; ?>"  <?php if ($data["num_pages"] == 0 || $data["page_number"] == 0): ?> style="opacity:0.2" <?php endif; ?>></i>
								</button>
								<span class="pageNumbers"><?= $initial_result; ?> - <?= $final_result.' '.asol_ReportsUtils::translateReportsLabel('LBL_REPORT_PAGINATION_OF').' '.$data["total_entries"]; ?></span>
								<button <?php if ($data["num_pages"] == 0 || ($data["page_number"] == $data["num_pages"]) || $data["total_entries"] == 0): ?> disabled <?php endif; ?> class="button" title="<?= $app_strings['LNK_LIST_NEXT']; ?>" name="listViewNextButton" type="button" onClick="document.search_form.page_number.value=<?= $next_number_page; ?>; controllerReportList.listReports();">							
									<i class="icn-play" title="<?= $app_strings['LNK_LIST_NEXT']; ?>"  <?php if ($data["num_pages"] == 0 || $data["page_number"] == $data["num_pages"] || $data["total_entries"] == 0): ?> style="opacity:0.2" <?php endif; ?>></i>
								</button>	
								<button <?php if ($data["num_pages"] == 0 || ($data["page_number"] == $data["num_pages"]) || $data["total_entries"] == 0): ?> disabled <?php endif; ?> class="button" title="<?= $app_strings['LNK_LIST_END']; ?>" name="listViewEndButton" type="button" onClick="document.search_form.page_number.value=<?= $data['num_pages']; ?>; controllerReportList.listReports();"> 					
									<i class="icn-fast-forward" title="<?= $app_strings['LNK_LIST_END']; ?>"  <?php if ($data["num_pages"] == 0 || $data["page_number"] == $data["num_pages"] || $data["total_entries"] == 0): ?> style="opacity:0.2" <?php endif; ?>></i>
								</button>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr height="20">
			<th nowrap="nowrap" width="2%" scope="col">
				<div align="left" width="100%" style="white-space: nowrap;">
					<input type="checkbox" class="massiveCheckAll" onClick="controllerReportList.massiveAction(true, this);"/>
				</div>
			</th>
			
			<?php foreach ($availableColumns as $key => $column): ?>
			<th nowrap="nowrap" width="<?= $availableWidths[$key]; ?>%" scope="col">
				<div align="left" width="100%" style="white-space: nowrap;">
					<a class="listViewThLinkS1" OnMouseOver="this.style.cursor='pointer';" OnMouseOut="this.style.cursor='default';" onclick="$('#sort_direction').val('<?= (($sort_field != $column) || ($sort_direction == "DESC") ? "ASC" : "DESC") ?>'); $('#sort_field').val('<?= $column; ?>'); controllerReportList.listReports();"><?= asol_ReportsUtils::translateReportsLabel($availableLabels[$key]); ?></a>&nbsp;
					<i class="icn-sort double <?= (($sort_field == $column) && ($sort_direction == 'ASC') ? 'up' : ((($sort_field == $column) && ($sort_direction == 'DESC')) ? 'down' : '')) ?>"></i>
				</div>
			</th>
			<?php endforeach; ?>
			<th nowrap="nowrap" width="18%" scope="col"></th>
		</tr>
	</thead>
	
	<?php foreach ($rows as $key => $currentRow): ?>
	<tbody class="asolReportsData">
		<?php foreach ($currentRow as $mode => $currentValues): ?>
		<?php if (isset($currentValues)): ?>
		<tr class="asolReportsRow <?= $mode; ?> <?php if ($key % 2 == 0): ?> evenListRowS1<?php else: ?> oddListRowS1<?php endif; ?>" height="20" style="display: <?php if ($mode == 'main'): ?>table-row<?php else: ?>none<?php endif; ?>;">
			<td align="left" width="3%" valign="top" scope="col">
				<?php if ($currentValues["domain_modifiable"] && (!$currentValues['just_modify'])): ?> <input type="checkbox" class="listViewCheck massiveCheck" value="<?= $currentValues["id"]; ?>" onClick="controllerReportList.massiveAction(false, this);"> <?php endif; ?>
				<?= $currentValues["icon"]; ?>
				<input type="hidden" class="deletableReport" <?php if (($currentValues["user_modifiable"] || $currentValues["role_modifiable"]) && ($currentValues["domain_modifiable"] && !$currentValues["just_modify"]) && ($REPORTS_ACL_DELETE)): ?> value="true" <?php else: ?> value="false" <?php endif; ?> />
			</td>
			<td align="left" width="<?= $availableWidths[0];?>%" valign="top" scope="row">
				<?php
				if ($currentValues['execute']) {
					echo '<a href="javascript: void(0);" onClick="controllerReportList.detailReport(\''.$currentValues["id"].'\');">'.$currentValues['name'].'</a>';
				} else {
					echo $currentValues['name'];
			    }
			    ?>
			</td>
			<td align="left" width="<?= $availableWidths[1];?>%" valign="top" scope="row">
				<?= $currentValues["module"]; ?>
			</td>
			<td align="left" width="<?= $availableWidths[2];?>%" valign="top" scope="row">
				<?= $currentValues["last_run"]; ?>
			</td>
			<td align="left" width="<?= $availableWidths[3];?>%" valign="top" scope="row">
				<?= $currentValues["date_modified"]; ?>
			</td>
			<td align="left" width="<?= $availableWidths[4];?>%" valign="top" scope="row">
				<?= $currentValues["user_name"]; ?>
			</td>
			<td align="left" width="<?= $availableWidths[5];?>%" valign="top" scope="row">
				<?= $currentValues["scope"]; ?>
			</td>
			<td align="left" width="<?= $availableWidths[6];?>%" valign="top" scope="row">
				<?= $currentValues["type"]; ?>
			</td>
			<?php if (asol_CommonUtils::isDomainsInstalled()): ?>
			<td align="left" width="<?= $availableWidths[7];?>%" valign="top" scope="row">
				<?= $currentValues["domain_name"]; ?>
			</td>
			<?php endif;?>
			<td align="right" class="actionsReportList">
				<?php if ($REPORTS_ACL_VIEW): ?>
				<?php
				if ($currentValues['type'] == "stored") {
					echo '<i class="icn-play-circled2" title="'.$mod_strings['LBL_REPORT_SHOW'].'" onClick="controllerReportList.detailReport(\''.$currentValues["id"].'\');"></i>';
				} else {
					if ($currentValues['execute']) {
						echo '<i class="icn-play-circled2" title="'.$mod_strings['LBL_REPORT_RUN'].'" onClick="controllerReportList.detailReport(\''.$currentValues["id"].'\')"></i>';
					} else if ($currentValues['external_url'] != NULL) {
						echo '<a title="'.$mod_strings['LBL_REPORT_RUN'].'" href="#" onClick="alert(\''.$currentValues['external_url'].'\');"><img style="margin-right: 0px" border="0" src="modules/asol_Reports/include/images/asol_reports_url.png"></a>';
					}
				}
				?>
				<?php endif; ?>
				<i class='icn-popup down' title="<?= asol_ReportsUtils::translateReportsLabel("LBL_REPORT_COPY"); ?>" onclick="controllerReportList.editReport('<?= $currentValues['id']; ?>', true, false);" <?= (($mode == 'main') && $currentValues["domain_modifiable"] && (!$currentValues['just_modify']) && $REPORTS_ACL_EXPORT) ? '' : 'style=" visibility: hidden;"' ?>></i>
				<i class="icn-pencil" title="<?= asol_ReportsUtils::translateReportsLabel("LBL_REPORT_EDIT"); ?>" onclick="controllerReportList.editReport('<?= $currentValues['id']; ?>', false, false);" <?= (($currentValues["user_modifiable"] || $currentValues["role_modifiable"]) && $currentValues["domain_modifiable"] && $REPORTS_ACL_EDIT) ? '' : 'style=" visibility: hidden;"' ?>></i>
				<i class="icn-down-circled2" title="<?= asol_ReportsUtils::translateReportsLabel("LBL_REPORT_EXPORT_ONE"); ?>" onClick="controllerReportList.exportReport('<?= $currentValues["id"]; ?>');" <?= (($mode == 'main') && $currentValues["domain_modifiable"] && (!$currentValues['just_modify']) && $REPORTS_ACL_EXPORT)? '' : 'style=" visibility: hidden;"'?>></i>
				<i class="icn-trash" title="<?= asol_ReportsUtils::translateReportsLabel("LBL_REPORT_DELETE"); ?>" onclick="controllerReportList.deleteReport('<?= $currentValues["id"]; ?>', '<?= rawurlencode($currentValues["name"]); ?>');" <?= (($currentValues["user_modifiable"] || $currentValues["role_modifiable"]) && $currentValues["domain_modifiable"] && (!$currentValues['just_modify']) && $REPORTS_ACL_DELETE)? '' : 'style=" visibility: hidden;"' ?>></i>
			</td>
		</tr>
		<?php endif; ?>
		<?php endforeach; ?>
	</tbody>
	<?php endforeach; ?>
	<tfoot>	
		<tr>
			<td colspan=<?php if (asol_CommonUtils::isDomainsInstalled()): ?>11<?php else: ?>10<?php endif; ?> style="border-top: solid 1px black; padding-bottom: 2px; padding-top: 10px;">
				<form id="massive_form" enctype="multipart/form-data" method="post" action="index.php">
					<input type="hidden" name="MAX_FILE_SIZE" value="100000">
					<?php if ($REPORTS_ACL_IMPORT): ?> <?= asol_ReportsUtils::translateReportsLabel("LBL_REPORT_SELECT_FILE") ?>: <input name="importedReports" type="file" accept=".txt">&nbsp;&nbsp;<input type="submit" value="<?= asol_ReportsUtils::translateReportsLabel("LBL_REPORT_IMPORT"); ?>" onClick="controllerReportList.importReport();">&nbsp;<?php endif; ?>
					<?php if ($REPORTS_ACL_EXPORT): ?> <input disabled type="button" value="<?= asol_ReportsUtils::translateReportsLabel("LBL_REPORT_EXPORT"); ?>" class="massiveAction" onClick="controllerReportList.exportReport(null);"> <?php endif; ?>
					<?php if ($REPORTS_ACL_DELETE): ?> <input disabled type="button" value="<?= asol_ReportsUtils::translateReportsLabel("LBL_REPORT_MULTIDELETE"); ?>" class="massiveAction" onClick="controllerReportList.deleteReport(null, null);"> <?php endif; ?>
				</form>
			</td>
		</tr>
	</tfoot>
</table>
