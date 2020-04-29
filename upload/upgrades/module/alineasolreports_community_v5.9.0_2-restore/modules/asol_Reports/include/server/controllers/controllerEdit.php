<?php

/**
 * @author AlineaSol
 */
class asol_ControllerReportEdit {
	
	/**
	 *
	 * @abstract Displays Edit View
	 */
	static public function display($record = null, $selected = true, $returnHtml = false) {
		
		$focus = BeanFactory::getBean('asol_Reports', $record);
		$newReportFlag = (!isset($record));
		
		if (asol_ReportsUtils::checkEditPermisions($focus)) {
			if ($returnHtml) {
				return (include "modules/asol_Reports/include/server/views/viewEdit.php");
			} else {
				require_once("modules/asol_Reports/include/server/views/viewEdit.php");
			}
		} else if ($selected) {
			SugarApplication::redirect("index.php?module=asol_Reports&action=index");
		}
			
	}
	
}
