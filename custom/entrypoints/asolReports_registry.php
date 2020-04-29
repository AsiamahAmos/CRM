<?php

$entry_point_registry['asolReportsApi'] = array(
	'file' => 'modules/asol_Reports/include/server/reportsApi.php', 
	'auth' => true
);

$entry_point_registry['viewReport'] = array(
	'file' => 'modules/asol_Reports/execute.php',
	'auth' => false
);
$entry_point_registry['scheduledTask'] = array(
	'file' => 'modules/asol_Reports/scheduledTask.php',
	'auth' => false
);
$entry_point_registry['reportCleanUp'] = array(
	'file' => 'modules/asol_Reports/cleanUp.php',
	'auth' => false	
);
$entry_point_registry['reportPopup'] = array(
	'file' => 'modules/asol_Reports/reportPopup.php',
	'auth' => false
);
$entry_point_registry['reportDownload'] = array(
	'file' => 'modules/asol_Reports/reportDownload.php',
	'auth' => false
);
$entry_point_registry['reportGenerateHtml'] = array(
	'file' => 'modules/asol_Reports/generateHTML.php',
	'auth' => true
);
$entry_point_registry['scheduledStoredReport'] = array(
	'file' => 'modules/asol_Reports/scheduledEmailReport.php',
	'auth' => true
);
$entry_point_registry['scheduledEmailReport'] = array(
	'file' => 'modules/asol_Reports/scheduledEmailReport.php',
	'auth' => false
);
$entry_point_registry['asol_CheckHttpFileExists'] = array(
	'file' => 'modules/asol_Reports/CheckHttpFileExists.php',
	'auth' => false
);
$entry_point_registry['reportAjaxActions'] = array(
	'file' => 'modules/asol_Reports/ajaxActions.php',
	'auth' => true
);