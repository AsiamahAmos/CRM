<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('modules/Users/User.php');

global $db, $sugar_config, $timedate, $current_user;

$common_version = "2.10.0";
$result = $db->query("SELECT version FROM upgrade_history WHERE id_name = 'AlineaSolCommonBase' AND status = 'installed' AND enabled = 1");

if ($result->num_rows == 0) {
	die ("<span style='color: orange;'>Warning:</span> Please install the module <strong>AlineaSol Common Base</strong> first.");
} else {
	$res = $result->fetch_assoc();
	if ($res['version'] < $common_version) {
		die ("<span style='color: orange;'>Warning:</span> Please update the module <strong>AlineaSol Common Base</strong> to ".$common_version." version or higher");
	}
}

$result = $db->query("SELECT id_name, name, version FROM upgrade_history WHERE id_name = 'AlineaSolReports' AND status = 'installed'");
if ($result->num_rows == 1) {
	$result = $db->fetchByAssoc($result);
	die ("<span style='color: orange;'>Warning:</span> Please uninstall the module <strong>AlineaSol Reports ".$result['version']."</strong> first. Please keep the database tables for update.");
}

error_reporting(1); //E_ERROR 

//***************************//
//***Rename Reports Tables***//
//***************************//
renameReportsTables();
//***************************//
//***Rename Reports Tables***//
//***************************//


//***************************//
//***Add GMT Flag to Tasks***//
//***************************//
addGmtFlagToTasks();
//***************************//
//***Add GMT Flag to Tasks***//
//***************************//


//***************************//
//***Create Reports Tables***//
//***************************//
createReportTables();
//***************************//
//***Create Reports Tables***//
//***************************//

 
//***************************//
//***Update Missing Fields***//
//***************************//
updateMissingFields();
//***************************//
//***Update Missing Fields***//
//***************************//


//**************************//
//***Update Email Listing***//
//**************************//
updateEmailListing();
//**************************//
//***Update Email Listing***//
//**************************//


//***************************************//
//***Increase Reports Variables Length***//
//***************************************//
increaseReportVarsLength();
//***************************************//
//***Increase Reports Variables Length***//
//***************************************//


//***************************************//
//***Migarte Charts Definition To Json***//
//***************************************//
migrateChartsDefinitionToSerialized();
//***************************************//
//***Migarte Charts Definition To Json***//
//***************************************//


//**********************************************//
//***Migarte Reports Fields to Latest Version***//
//**********************************************//
migrateDbFieldsToLatestVersion();
//**********************************************//
//***Migarte Reports Fields to Latest Version***//
//**********************************************//


//***************************************//
//*********Migrate Reports Charts********//
//***************************************//
migrateReportsCharts();
//***************************************//
//*********Migrate Reports Charts********//
//***************************************//


//**********************************************//
//*********Migrate Reports ScheduledType********//
//**********************************************//
migrateReportScheduledTypeToJson();
//**********************************************//
//*********Migrate Reports ScheduledType********//
//**********************************************//


//***************************************//
//*********Migrate Reports Charts********//
//***************************************//
migrateReportScheduledTasksToJson();
//***************************************//
//*********Migrate Reports Charts********//
//***************************************//


//****************************************//
//***Migrate Reports Type To Serialized***//
//****************************************//
migrateReportTypeDataToSerialized();
//****************************************//
//***Migrate Reports Type To Serialized***//
//****************************************//


//*********************************************//
//*********Migrate Reports Enum Formats********//
//*********************************************//
migrateReportEnumFormats();
//*********************************************//
//*********Migrate Reports Enum Formats********//
//*********************************************//


//***********************************//
//***fix Users Module Emailing Bug***//
//***********************************//
fixUsersModuleEmailingBug();
//***********************************//
//***fix Users Module Emailing Bug***//
//***********************************//


//***********************************//
//********Migrate Report Type********//
//***********************************//
migrateReportTypeToJson();
//***************************************//
//*********Migrate Reports Charts********//
//***************************************//


//***************************************//
//********Migrate External Tables********//
//***************************************//
migrateReportExternalTables();
//***************************************//
//********Migrate External Tables********//
//***************************************//


//***********************************//
//********Migrate Data Source********//
//***********************************//
migrateReportDataSource();
//***********************************//
//********Migrate Data Source********//
//***********************************//


//************************************//
//***Migrate Reports Base64 Columns***//
//************************************//
migrateReportsBase64Columns();
//************************************//
//***Migrate Reports Base64 Columns***//
//************************************//


function renameReportsTables() {

	global $db;
	
	$reportsTableExistsQuery = $db->query("SHOW tables like 'reports'", false);
	$reportsDispatcherTableExistsQuery = $db->query("SHOW tables like 'reports_dispatcher'", false);

	if ($reportsTableExistsQuery->num_rows > 0) {
		$db->query("RENAME TABLE reports TO asol_reports");
		$db->query("RENAME TABLE reports_audit TO asol_reports_audit");
	}

	if ($reportsDispatcherTableExistsQuery->num_rows > 0) {
		$db->query("RENAME TABLE reports_dispatcher TO asol_reports_dispatcher");
	}

}


function addGmtFlagToTasks() {
	
	global $db;
	
	$queryResults = $db->query("SELECT * FROM asol_reports WHERE report_tasks IS NOT NULL");
		
	while($queryRow = $db->fetchByAssoc($queryResults)){
		$retArray[] = $queryRow;
	}
	
	if (count($retArray) > 0) {
	
		$GLOBALS['log']->debug("**********[ASOL][Reports]: Conversion a GMT");
	
		foreach ($retArray as $row){
		
			$theUser = new User();
			$theUser->retrieve($row["created_by"]);
			
			$userTZ = $theUser->getPreference("timezone");
			
			if (empty($userTZ))
				continue;
			
			$phpDateTime = new DateTime(null, new DateTimeZone($userTZ));
			$hourOffset = $phpDateTime->getOffset()*-1;
			
			if (strpos($row["report_tasks"], "\${GMT}") === false) {
				
				$GLOBALS['log']->debug("**********[ASOL][Reports]: Report sin GMT");
				
				//Adaptamos las fechas a formato GMT
				if (strlen($row["last_run"]) > 0) {
				
					$lr = explode(" ", $row["last_run"]);
					$lr_date = explode("-", $lr[0]);
					$lr_time = explode(":", $lr[1]);
					$last_run = '"'.date("Y-m-d H:i:s", mktime($lr_time[0],$lr_time[1],$lr_time[2],$lr_date[1],$lr_date[2],$lr_date[0])+$hourOffset).'"';
				
				} else {
				
					$last_run = 'NULL';
				
				}
				
				//Fechas de los Tasks
				$tasks = explode("|", $row["report_tasks"]);
				
				foreach($tasks as $key=>$task){
				
					$values = explode(":", $task);
					$time1 = explode(",", $values[3]);
					$values[3] = date("H,i", mktime($time1[0],$time1[1],0,date("m"),date("d"),date("Y"))+$hourOffset);
					
					$tasks[$key] = implode(":", $values);
				
				}
				
				$db->query('UPDATE asol_reports SET last_run='.$last_run.', report_tasks="'.implode("|", $tasks)."\${GMT}".'" WHERE id="'.$row["id"].'"');
				
			} else {
			
				$GLOBALS['log']->debug("**********[ASOL][Reports]: Report con GMT");
			
			}
		
		} 
		
	
	} 

}


function createReportTables() {

	global $db;
	
	$GLOBALS['log']->debug("**********[ASOL][Reports]: Creating DB tables");

	$db->query("CREATE TABLE IF NOT EXISTS `asol_reports` (
	  `id` char(36) NOT NULL,
	  `name` varchar(255) NULL,
	  `date_entered` datetime DEFAULT NULL,
	  `date_modified` datetime DEFAULT NULL,
	  `modified_user_id` char(36) DEFAULT NULL,
	  `created_by` char(36) DEFAULT NULL,
	  `description` text DEFAULT NULL,
	  `deleted` tinyint(1) DEFAULT '0',
	  `assigned_user_id` char(36) DEFAULT NULL,
	  `data_source` varchar(255) DEFAULT NULL,
	  `team_id` char(36) DEFAULT NULL,
	  `team_set_id` char(36) DEFAULT NULL,
	  `last_run` datetime DEFAULT NULL,
	  `parent_id` char(36) DEFAULT NULL,
	  `report_scope` text,
	  `report_fields` longtext,
	  `report_filters` longtext,
	  `report_charts_detail` longtext,
	  `report_type` text DEFAULT NULL,
	  `report_scheduled_type` text DEFAULT NULL,
	  `report_charts` varchar(4) DEFAULT NULL,
	  `report_charts_engine` varchar(8) DEFAULT NULL,
	  `report_tasks` varchar(255) DEFAULT NULL,
	  `email_list` text DEFAULT NULL,
	  `report_attachment_format` varchar(255) DEFAULT NULL,
	  `scheduled_images` tinyint(1) DEFAULT NULL,
	  `dynamic_tables` tinyint(1) DEFAULT '0',
	  `dynamic_sql` varchar(255) DEFAULT '',
	  `row_index_display` tinyint(1) DEFAULT '0',
	  `results_limit` varchar(255) DEFAULT 'all',
	  `is_meta` tinyint(1) DEFAULT '0',
	  `meta_html` mediumtext,
	  PRIMARY KEY (`id`)) ENGINE=INNODB DEFAULT CHARSET=utf8;");


	$db->query("CREATE TABLE IF NOT EXISTS `asol_reports_dispatcher` (
	  `id` char(36) NOT NULL,
	  `report_id` char(36) NULL,
	  `curl_requested_url` text,
	  `status` varchar(45) DEFAULT NULL,
	  `request_init_date` varchar(12) DEFAULT NULL,
	  `last_recall` varchar(12) DEFAULT NULL,
	  `request_type` varchar(45) DEFAULT NULL,
	  `owner_user_id` char(36) DEFAULT NULL,
	  `last_sql` text DEFAULT NULL,
			
	  PRIMARY KEY (`id`)) ENGINE=INNODB DEFAULT CHARSET=utf8;");

	
	$db->query("CREATE TABLE IF NOT EXISTS `asol_reports_relations` (
	  `id` char(36) NOT NULL,
	  `name` varchar(255) NULL,
	  `date_entered` datetime DEFAULT NULL,
	  `date_modified` datetime DEFAULT NULL,
	  `modified_user_id` char(36) DEFAULT NULL,
	  `created_by` char(36) DEFAULT NULL,
	  `description` text DEFAULT NULL,
	  `deleted` tinyint(1) DEFAULT '0',
	  `scope` text,
	  `module` varchar(255) NULL,
	  `field` varchar(255) NULL,
	  `relation_module` varchar(255) NULL,
	  `relation_field` varchar(255) NULL,
	  `alternative_database` varchar(255) DEFAULT '-1',
	  PRIMARY KEY (`id`)) ENGINE=INNODB DEFAULT CHARSET=utf8;");
	
	
	$GLOBALS['log']->debug("**********[ASOL][Reports]: Tablas creadas");
 
}

function updateMissingFields() {
  	
	global $db;
	
	/*******************************/
	/*****reports_chart_engine******/
	/*******************************/
	$checkReportsChartEngine_Query = $db->query("SHOW COLUMNS FROM asol_reports LIKE 'report_charts_engine'");
	if ($checkReportsChartEngine_Query->num_rows === 0)
		$db->query("ALTER TABLE asol_reports ADD report_charts_engine VARCHAR(8) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'nvd3' AFTER report_charts");

 	
	/*******************************/
	/****reports_scheduled_type*****/
	/*******************************/
	$checkReportsScheduledType_Query = $db->query("SHOW COLUMNS FROM asol_reports LIKE 'report_scheduled_type'");
	if ($checkReportsScheduledType_Query->num_rows === 0)
		$db->query("ALTER TABLE asol_reports ADD report_scheduled_type TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER report_type");
 	 	
 	
	/************************/
	/*****dynamic_tables*****/
	/************************/
	$checkDynamicTables_Query = $db->query("SHOW COLUMNS FROM asol_reports LIKE 'dynamic_tables'");
	if ($checkDynamicTables_Query->num_rows === 0)
		$db->query("ALTER TABLE asol_reports add COLUMN dynamic_tables tinyint(1) DEFAULT '0' NULL AFTER scheduled_images");
	
		
	/*********************/
	/*****dynamic_sql*****/
	/*********************/
	$checkDynamicSql_Query = $db->query("SHOW COLUMNS FROM asol_reports LIKE 'dynamic_sql'");
	if ($checkDynamicSql_Query->num_rows === 0)
		$db->query("ALTER TABLE asol_reports add COLUMN dynamic_sql varchar(255) DEFAULT '' NULL AFTER dynamic_tables");
				
	
	/**********************/
	/*****team_support*****/
	/**********************/
	$checkTeamIdSql_Query = $db->query("SHOW COLUMNS FROM asol_reports LIKE 'team_id'");
	if ($checkTeamIdSql_Query->num_rows === 0)
		$db->query("ALTER TABLE asol_reports add COLUMN team_id char(36) DEFAULT NULL AFTER assigned_user_id");
	
	$checkTeamSetIdSql_Query = $db->query("SHOW COLUMNS FROM asol_reports LIKE 'team_set_id'");
	if ($checkTeamSetIdSql_Query->num_rows === 0)
		$db->query("ALTER TABLE asol_reports add COLUMN team_set_id char(36) DEFAULT NULL AFTER team_id");
	
	
	/**********************/
	/******meta_report*****/
	/**********************/
	$checkIsMetaSql_Query = $db->query("SHOW COLUMNS FROM asol_reports LIKE 'is_meta'");
	if ($checkIsMetaSql_Query->num_rows === 0)
		$db->query("ALTER TABLE asol_reports add COLUMN is_meta tinyint(1) DEFAULT '0' NULL AFTER results_limit");
	
	$checkMetaHtmlSql_Query = $db->query("SHOW COLUMNS FROM asol_reports LIKE 'meta_html'");
	if ($checkMetaHtmlSql_Query->num_rows === 0)
		$db->query("ALTER TABLE asol_reports add COLUMN meta_html MEDIUMTEXT DEFAULT NULL AFTER is_meta");
	

	/*********************/
	/******parent_id******/
	/*********************/
	$checkParentIdSql_Query = $db->query("SHOW COLUMNS FROM asol_reports LIKE 'parent_id'");
	if ($checkParentIdSql_Query->num_rows === 0) {
		$db->query("ALTER TABLE asol_reports add COLUMN parent_id char(36) DEFAULT NULL AFTER description");
	} else {
		$checkInternalIdSql_Query = $db->query("SHOW COLUMNS FROM asol_reports LIKE 'internal_id'");
		if ($checkInternalIdSql_Query->num_rows !== 0)
			$db->query("ALTER TABLE asol_reports CHANGE COLUMN internal_id parent_id char(36) DEFAULT NULL");
	}
		
		
	/*********************/
	/*****last_sql********/
	/*********************/
	$checkInternalIdSql_Query = $db->query("SHOW COLUMNS FROM asol_reports_dispatcher LIKE 'last_sql'");
	if ($checkInternalIdSql_Query->num_rows === 0)
		$db->query("ALTER TABLE asol_reports_dispatcher  ADD last_sql TEXT AFTER owner_user_id");
	
	
	$db->query("ALTER TABLE asol_reports CHANGE report_type report_type TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL"); 

 
}

function updateEmailListing() {
	
	global $db;
	
	/************************/
	/*****email_listing******/
	/************************/
	
	$db->query("ALTER TABLE `asol_reports` CHANGE `email_list` `email_list` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL"); 
 
	$reportsWithEmails_Sql = "SELECT id, email_list FROM asol_reports WHERE email_list != '\${pipe}'"; 
	$reportsWithEmails_Rs = $db->query($reportsWithEmails_Sql);
	while ($reportsWithEmails_Row = $db->fetchByAssoc($reportsWithEmails_Rs)) {
		$reportEmails = explode('${pipe}', $reportsWithEmails_Row['email_list']);
		if (count($reportEmails) == 2) {
			$db->query("UPDATE asol_reports SET email_list = '\${pipe}\${pipe}\${pipe}\${pipe}\${pipe}\${pipe}\${pipe}".$reportEmails[0]."\${pipe}".$reportEmails[1]."\${pipe}' WHERE id = '".$reportsWithEmails_Row['id']."';");
		}
	}

	$reportsWithNoEmails_Sql = "SELECT id, email_list FROM asol_reports WHERE email_list = '\${pipe}'"; 
	$reportsWithNoEmails_Rs = $db->query($reportsWithNoEmails_Sql);
	while ($reportsWithNoEmails_Row = $db->fetchByAssoc($reportsWithNoEmails_Rs)) {
		$db->query("UPDATE asol_reports SET email_list = '\${pipe}\${pipe}\${pipe}\${pipe}\${pipe}\${pipe}\${pipe}\${pipe}\${pipe}' WHERE id = '".$reportsWithNoEmails_Row['id']."';");
	}
 
}

function increaseReportVarsLength() {
	
	global $db;
	
	$db->query("ALTER TABLE asol_reports CHANGE description description TEXT NULL DEFAULT NULL");
	$db->query("ALTER TABLE asol_reports CHANGE report_fields report_fields LONGTEXT NULL DEFAULT NULL");
	$db->query("ALTER TABLE asol_reports CHANGE report_filters report_filters LONGTEXT NULL DEFAULT NULL");
	$db->query("ALTER TABLE asol_reports CHANGE report_charts_detail report_charts_detail LONGTEXT NULL DEFAULT NULL");
	$db->query("ALTER TABLE asol_reports CHANGE report_attachment_format report_attachment_format VARCHAR(255) NULL DEFAULT NULL");
	$db->query("ALTER TABLE asol_reports CHANGE report_tasks report_tasks text DEFAULT NULL");
	
}


function migrateChartsDefinitionToSerialized() {

	global $db;

	$reportsRs = $db->query("SELECT id, is_meta, report_charts_detail FROM asol_reports WHERE deleted=0 ORDER BY date_entered DESC");
	
	while ($row = $db->fetchByAssoc($reportsRs)) {
	
		$isBase64 = (base64_encode(base64_decode($row['report_charts_detail'])) === $row['report_charts_detail']);
		$isJson = json_decode(rawurldecode($row['report_charts_detail']), true);
		
		if ($row['is_meta'] == '1' || $isBase64 || isset($isJson))
			continue;
		
		$chartVersion = substr($row['report_charts_detail'], -9);
		$reportCharts = explode('${pipe}', substr($row['report_charts_detail'], 0, -9));
		
		$reportChartsJson = '{"charts":[';
		foreach ($reportCharts as $reportChart) {
			$chartValues = explode('${dp}', $reportChart);
			$reportChartsJson .= '{"data":{"field":"'.$chartValues[0].'","label":"'.$chartValues[1].'","function":"'.$chartValues[2].'","display":"'.$chartValues[3].'","type":"'.$chartValues[4].'","index":"'.$chartValues[5].'","related":'.$chartValues[6].'}},';
		}
		$reportChartsJson = substr($reportChartsJson, 0, -1);
		$reportChartsJson .= '],"version":"'.substr($chartVersion, 3, 5).'"}';
		
		$reportChartsJson = base64_encode(serialize(json_decode($reportChartsJson, true)));
		
		$db->query("UPDATE asol_reports SET report_charts_detail = '".$reportChartsJson."' WHERE id='".$row['id']."'");
		
	}

}


function migrateReportTypeDataToSerialized() {
	
	global $current_user, $db;

	//**************************//
	//***Is Domains Installed***//
	//**************************//
	$domainsQuery = $db->query("SELECT * FROM upgrade_history WHERE id_name='AlineaSolDomains' AND status='installed'");
	$isDomainsInstalled = ($domainsQuery->num_rows > 0);
	//**************************//
	//***Is Domains Installed***//
	//**************************//
	
	if ($isDomainsInstalled)
		$reportsRs = $db->query("SELECT id, report_type, asol_domain_id FROM asol_reports WHERE deleted=0 AND report_type LIKE 'stored%' ORDER BY date_entered DESC");
	else
		$reportsRs = $db->query("SELECT id, report_type FROM asol_reports WHERE deleted=0 AND report_type LIKE 'stored%' ORDER BY date_entered DESC");
	
	while ($reportsRow = $db->fetchByAssoc($reportsRs)) {
	
		$storedReportType = explode('${dp}', $reportsRow['report_type']);
		
		if (count($storedReportType) == 1)
			continue;
		
		$storedReportKey = (!$isDomainsInstalled) ? 'base' : $reportsRow['asol_domain_id'];
		
		$txtFile = null;
		$xmlFiles = null;
		$subGroups = null;
		$types = null;
		
		$storedReportTypeUrl = explode('&', $storedReportType[1]);
		foreach ($storedReportTypeUrl as $storedReportTypeUrlParam) {
			$storedReportTypeUrlParamValues = explode('=', $storedReportTypeUrlParam);
			if ($storedReportTypeUrlParamValues[0] == 'txtFile')
				$txtFile = $storedReportTypeUrlParamValues[1];
			else if ($storedReportTypeUrlParamValues[0] == 'xmlFiles')
				$xmlFiles = explode('|', $storedReportTypeUrlParamValues[1]);
			else if ($storedReportTypeUrlParamValues[0] == 'subGroups')
				$subGroups = explode('|', $storedReportTypeUrlParamValues[1]);
			else if ($storedReportTypeUrlParamValues[0] == 'types')
				$types = explode('|', $storedReportTypeUrlParamValues[1]);
		}
		
		$chartFiles = array();
		
		foreach ($xmlFiles as $chartKey=>$xmlFile) {
			if (!empty($xmlFile)) {
				$chartFiles[] = array(
					'file' => $xmlFile,
			        'type' => $types[$chartKey],
			        'subGroups' => $subGroups[$chartKey],
				);
			}
		}
		
		$reportTypeArray[$storedReportKey] = array(
			'infoTxt' => $txtFile,
			'chartFiles' => $chartFiles
		);
		
		$storedReportTypeSerialized = base64_encode(serialize($reportTypeArray));
		
		echo "UPDATE asol_reports SET report_type = 'stored:".$storedReportTypeSerialized."' WHERE id='".$reportsRow['id']."';<br/>";
		$db->query("UPDATE asol_reports SET report_type = 'stored:".$storedReportTypeSerialized."' WHERE id='".$reportsRow['id']."'");
		
	}
	
}

function fixUsersModuleEmailingBug() {

	$gestor = fopen("modules/Users/User.php", "r");
  
	if ($gestor){
  
		$fileText = "";
	  
		while ((!feof($gestor)) && (!strstr($buffer, "\$fromddr = \$a['value'];"))) {
			$buffer = fgets($gestor);
			$fileText .= $buffer;
		}
		
		$fileText .= "\$fromaddr = \$a['value'];\n";
	  
		while (!feof($gestor)) {
			$buffer = fgets($gestor);
			$fileText .= $buffer; 
		}
		
		fclose($gestor);
		
		$gestor = fopen("modules/Users/User.php", "w");
		fwrite($gestor, $fileText);
		
		fclose($gestor);
  
	}

}


//**********************************************//
//***Migarte Reports Fields to Latest Version***//
//**********************************************//
function migrateDbFieldsToLatestVersion() {
	
	global $db;

	$checkReportsModule_Query = $db->query("SHOW COLUMNS FROM asol_reports LIKE 'report_module'");
	if ($checkReportsModule_Query->num_rows > 0) {
		
		$reportsRs = $db->query("SELECT R.id as id, R.description as description, R.name as name, R.report_filters as report_filters, R.report_module as report_module, R.report_fields as report_fields FROM asol_reports R WHERE R.deleted=0 ORDER BY R.date_entered DESC");
		
		while ($reportsRow = $db->fetchByAssoc($reportsRs)) {
	
			$reportDescription = migrateDescriptionToJson($reportsRow['description']);
			$reportFields = migrateFieldsDefinitionToJson($reportsRow['report_fields'], $reportsRow['report_module']);
			$reportFilters = migrateFiltersDefinitionToJson($reportsRow['report_filters'], $reportsRow['report_module']);
			
			if (($reportDescription === false) && ($reportFields === false) && ($reportFilters === false)) {
				continue;
			}
	
			$db->query("UPDATE asol_reports SET description = '".$reportDescription."', report_fields = '".$reportFields."', report_filters = '".$reportFilters."' WHERE id='".$reportsRow['id']."';");
		
		}
	
	}
	
}

function migrateDescriptionToJson($reportDescription) {
	
	if (!empty($reportDescription)) {
		$serialized = base64_decode($reportDescription); // decoding fail => return false
		if ($serialized != false) {
			$unserialized = unserialize($serialized); // unserializing fail => return null
			if ($unserialized != null) {
				return $reportDescription;
			}
		}
	}
	
	$publicDescription = trim($reportDescription);
	$descriptionArray = array(
		'internal' => null,
		'public' => (empty($publicDescription) ? null : $publicDescription),
	);
	
	return base64_encode(serialize($descriptionArray));
	
}

function migrateFieldsDefinitionToJson($reportFields, $reportModule) {

	if (base64_encode(base64_decode($reportFields)) === $reportFields) {

		return $reportFields;
	
	} else {
		
		$tableModuleArray = getTableModuleArray();
		
		$fieldsVersion = substr(substr($reportFields, -9), 3, 5);
		$fieldsValues = substr($reportFields, 0, -9);
		$escapeTokensStringFields = ($fieldsVersion < '1.3.1') ? false : true;
		$fieldsValues = unescapeSpecialCases($fieldsValues);
		
		$fields = ($escapeTokensStringFields ? explode('${pipe}', $fieldsValues) : explode('|', $fieldsValues));
		
		if (strlen($fieldsValues) == 0) {
			$fields = array();
		}
	
		$fieldObject['tables'][0] = array(
			'config' => array(
				'visible' => true,
				'subtotals' => array(
					'visible' => true, 
				),
				'totals' => array(
					'visible' => true, 
				),
			),
			'data' => array(),
			'version' => $fieldsVersion
		);
		
		foreach ($fields as $field) {
			$fieldValues = ($escapeTokensStringFields ? explode('${dp}', $field) : explode(":", $field));
			$functionValues = explode('${comma}', $fieldValues[5]);
			
			// Field module
			$splittedField = explode('.', $fieldValues[0]);
			if (count($splittedField) > 1) {
				if (substr($splittedField[0], -strlen('_cstm')) === '_cstm') {
					$enumTable = substr($splittedField[0], 0, -strlen('_cstm'));
				} else {
					$enumTable = $splittedField[0];
				}
				$currentFieldModule = $tableModuleArray[$enumTable];
				$enumField = $splittedField[1];
			} else {
				$currentFieldModule = $reportModule;
				$enumField = $fieldValues[0];
			}
			
			// Enum Operator & Reference
			$externalTable = explode(" ", $reportModule);
			if ($externalTable[1] == '(External_Table)') {
				$enumOperator = '';
				$enumReference = '';
			} else {
	
				if (in_array($fieldValues[13], array('asolFunction'))) {
					$enumOperator = $fieldValues[12];
					$enumReference = $fieldValues[13];
				} else if (in_array($fieldValues[8], array('enum', 'multienum', 'radioenum'))) {
					$enumArray = getEnumReferenceForEnumField($currentFieldModule, $enumField);
					$enumOperator = $enumArray['enumOperator'];
					$enumReference =  $enumArray['enumReference'];
				} else {
					$enumOperator = '';
					$enumReference = '';
				}
			
			}
			
			$fieldObject['tables'][0]['data'][] = array(
				'field' => $fieldValues[0],
				'alias' => $fieldValues[1],
				'visible' => $fieldValues[2],
				'sortDirection' => $fieldValues[3],
				'sortOrder' => $fieldValues[4],
				'function' => $functionValues[0],
				'sql' => (isset($functionValues[1])) ? $functionValues[1] : '',
				'grouping' => $fieldValues[6],
				'groupingOrder' => $fieldValues[7],
				'type' => $fieldValues[8],
				'key' => $fieldValues[9],
				'isRelated' => ($fieldValues[10] === 'true'),
				'index' => $fieldValues[11],
				'enumOperator' => $enumOperator,
				'enumReference' => $enumReference
			);
			
		}
		
		return base64_encode(serialize($fieldObject));
		
	}
	
}

function migrateFiltersDefinitionToJson($reportFilters, $reportModule) {
	
	if (base64_encode(base64_decode($reportFilters)) === $reportFilters) {

		return $reportFilters;
	
	} else {
		
		$tableModuleArray = getTableModuleArray();
		
		$filtersVersion = substr(substr($reportFilters, -9), 3, 5);
		$filtersValues = substr($reportFilters, 0, -9);
		$escapeTokensStringFilters = ($filtersVersion < '1.3.0') ? false : true;
		
		$filtersValues = unescapeSpecialCases($filtersValues);
		
		$filters = ($escapeTokensStringFilters ? explode('${pipe}', $filtersValues) : explode('|', $filtersValues));
		
		if (strlen($filtersValues) == 0) {
			$filters = array();
		}
		
		$filterObject = array(
			'config' => array(
				'initialExecution' => false,
			),
			'data' => array(),
			'version' => $filtersVersion,
		);
		
		foreach($filters as $filter) {
			$filterValues = ($escapeTokensStringFilters ? explode('${dp}', $filter) : explode(":", $filter));
			
			$firstParameter = ($escapeTokensStringFilters ? explode('${dollar}', $filterValues[2]) : explode('$', $filterValues[2]));
			
			
			//*Fix Parameters*//
			$firstParameter[0] = ((in_array($filterValues[4], array('date', 'datetime', 'timestamp'))) && ($filterValues[1] == 'between') && ($firstParameter[0] == 'day')) ? 'calendar' : $firstParameter[0];
		
			if ((in_array($filterValues[4], array("date", "datetime", "timestamp"))) && (in_array($filterValues[1], array("equals", "not equals", "before date", "after date"))) && ($firstParameter[0] != 'calendar')) {
				$filterValues[3] = $filterValues[2];
				$firstParameter[0] = 'calendar';
			} else if ((in_array($filterValues[4], array("date", "datetime", "timestamp"))) && (in_array($filterValues[1], array("between", "not between"))) && ($firstParameter[0] != 'calendar')) {
				$filterValues[3] = $filterValues[2].'${comma}'.$filterValues[3];
				$firstParameter[0] = 'calendar';
			}
			//*Fix Parameters*//
			
			
			// Parameters
			$adittionalParameters = explode('${comma}', $filterValues[3]);
			$secondParameter = (strlen($adittionalParameters[0]) > 0 ? array($adittionalParameters[0]) : array()); 
			$thirdParameter = (count($adittionalParameters) > 1 ? array($adittionalParameters[1]) : array());
			
			
			// Filter module
			$splittedFilter = explode('.', $filterValues[0]);
			if (count($splittedFilter) > 1) {
				if (substr($splittedFilter[0], -strlen('_cstm')) === '_cstm') {
					$enumTable = substr($splittedFilter[0], 0, -strlen('_cstm'));
				} else {
					$enumTable = $splittedFilter[0];
				}
				$currentFilterModule = $tableModuleArray[$enumTable];
				$enumField = $splittedFilter[1];
			} else {
				$currentFilterModule = $reportModule;
				$enumField = $filterValues[0];
			}
			
			// Enum Operator & Reference
			$externalTable = explode(" ", $reportModule);
			if ($externalTable[1] == '(External_Table)') {
				$enumOperator = '';
				$enumReference = '';
			} else {
				if (in_array($filterValues[7], array('asolFunction'))) {
					$enumOperator = $filterValues[7];
					$enumReference = $filterValues[8];
				} else if (in_array($filterValues[4], array('enum', 'multienum', 'radioenum'))) {
					$enumArray = getEnumReferenceForEnumField($currentFilterModule, $enumField);
					$enumOperator = $enumArray['enumOperator'];
					$enumReference =  $enumArray['enumReference'];
				} else {
					$enumOperator = '';
					$enumReference = '';
				}
			}
				
			// Related filter
			$isRelated = (($filterValues[5] != "") && ($filterValues[5] != "false"));
			
			// User options
			$userOptions = array();
			if (strlen($filterValues[12]) > 0) {
				foreach(explode(',', $filterValues[12]) as $userOptionString) {
					$tmp = explode('=', $userOptionString);
					$userOptions[] = array(
						'key' => $tmp[0],
						'value' => ((count($tmp) > 1) ? $tmp[1] : null),
					);
				}
			} 
			
			// Logical elements
			$logicalElements = explode(':', $filterValues[13]);
			$logicalParenthesis = $logicalElements[0];
			$logicalOperator = (isset($logicalElements[1]) ? $logicalElements[1] : '');
			
			
			
			
			$filterObject['data'][] = array(
				'field' => $filterValues[0],
				'operator' => $filterValues[1],
				'parameters' => array(
					'first' => $firstParameter,
					'second' => $secondParameter,
					'third' => $thirdParameter,
				),
				'type' => ($filterValues[4] == 'theese' ? 'these' : $filterValues[4]),
				'isRelated' => $isRelated,
				'relationKey' => ($isRelated ? $filterValues[5] : ""),
				'index' => $filterValues[6],
				'enumOperator' => $enumOperator,
				'enumReference' => $enumReference,
				'filterReference' => $filterValues[9],
				'alias' => $filterValues[10],
				'behavior' => $filterValues[11],
				'userOptions' => $userOptions,
				'logicalOperators' => array(
					'parenthesis' => $logicalParenthesis,
					'operator' => $logicalOperator,
				),
			);
			
		}
		
		return base64_encode(serialize($filterObject));
		
	}
	
}

function getEnumReferenceForEnumField($module, $field) {
	
	$field_defs = BeanFactory::newBean($module)->field_defs;
	
	if (!empty($field_defs[$field]['options'])) {

		$enumOperator = 'options';
		$enumReference = $field_defs[$field]['options'];

	} else if (!empty($values['function'])) {

		$enumOperator = 'function';
		$enumReference = $field_defs[$field]['function'];
		
	} else {

		$enumOperator = '';
		$enumReference = '';
		
	}
	
	return array(
		'enumOperator' => $enumOperator,
		'enumReference' => $enumReference,
	);
	
}

function getTableModuleArray() {
	
	global $current_user;
	
	$acl_modules = ACLAction::getUserActions($current_user->id);
	
	//Get an array of table names for admin accesible modules
	$modulesTables = Array();
	
	foreach($acl_modules as $key=>$mod){
		$tableName = BeanFactory::newBean(BeanFactory::getObjectName($key))->table_name;
		$tableName = ($tableName == false ? BeanFactory::newBean($key)->table_name : $tableName);
		$tableName = (empty($tableName) ? strtolower($key) : $tableName); 
		$modulesTables[$tableName] = $key;
	}
	
	return $modulesTables;
	
}

function unescapeSpecialCases($input) {
	$input = str_replace('\\_', '_', $input);
	return $input;
}
//**********************************************//
//***Migrate Reports Fields to Latest Version***//
//**********************************************//


//***************************************//
//*********Migrate Reports Charts********//
//***************************************//
function migrateReportsCharts() {

	global $db;

	$resultSet = $db->query('SELECT id, name, report_charts_detail FROM asol_reports WHERE deleted=0 AND report_charts_detail IS NOT NULL');

	while ($row = $db->fetchByAssoc($resultSet)) {

		if (base64_encode(base64_decode($row['report_charts_detail'])) === $row['report_charts_detail']) {
		
			$currentId = $row['id'];
			$currentName = $row['name'];
			$currentCharts = unserialize(base64_decode($row['report_charts_detail']));
	
			if (!empty($currentCharts['charts'])) {
				$update = false;
	
				foreach ($currentCharts['charts'] as & $currentChart) {
	
					if (isset($currentChart['data']['field']) && isset($currentChart['data']['index'])) {
	
						$currentChart['data']['yAxis'] = array($currentChart['data']['field']);
						unset($currentChart['data']['field']);
						$currentChart['data']['yIndex'] = $currentChart['data']['index'];
						unset($currentChart['data']['index']);
	
						if (!empty($currentChart['data']['subcharts'])) {
	
							foreach ($currentChart['data']['subcharts'] as & $currentSubChart) {
	
								if (isset($currentSubChart['data']['field']) && isset($currentSubChart['data']['index'])) {
	
									$currentSubChart['data']['yAxis'] = array($currentSubChart['data']['field']);
									unset($currentSubChart['data']['field']);
									$currentSubChart['data']['yIndex'] = $currentSubChart['data']['index'];
									unset($currentSubChart['data']['index']);
	
								}
	
							}
	
						}
	
						$update = true;
	
					}
					
					if (isset($currentChart['config']['colorPalette'])) {
						
						$currentChart['config'] = array(
							'colors' => $currentChart['config']['colorPalette']
						);
						
						if (!empty($currentChart['data']['subcharts'])) {
						
							foreach ($currentChart['data']['subcharts'] as & $currentSubChart) {
						
								if (isset($currentSubChart['config']['colorPalette'])) {
						
									$currentSubChart['config'] = array(
										'colors' => $currentSubChart['config']['colorPalette']
									);
						
								}
						
							}
						
						}
						
						$update = true;
						
					}
	
				}
	
				if ($update) {
					$currentCharts64 = base64_encode(serialize($currentCharts));
					$db->query('UPDATE asol_reports SET report_charts_detail="'.$currentCharts64.'" WHERE id="'.$currentId.'" LIMIT 1');
				}
	
			}
			
		}

	}

}

function migrateReportScheduledTypeToJson() {
	
	global $db;
	
	$notScheduledQueryUpdate = 'UPDATE asol_reports SET report_scheduled_type = NULL WHERE report_type != "scheduled"';
	$db->query($notScheduledQueryUpdate);
	$notScheduledQueryUpdate = 'UPDATE asol_reports SET report_scheduled_type = "email" WHERE report_scheduled_type LIKE "email%"';
	$db->query($notScheduledQueryUpdate);
	
	$resultSet = $db->query('SELECT id, name, report_scheduled_type FROM asol_reports WHERE deleted=0 AND report_scheduled_type IS NOT NULL AND report_scheduled_type != "email"');
	
	while($row = $db->fetchByAssoc($resultSet)) {
	
		$currentId = $row['id'];
		$currentName = $row['name'];
		$currentScheduledType = explode('${dollar}', $row['report_scheduled_type']);
		
		if ($row['report_scheduled_type'] !== 'email' && in_array($currentScheduledType[0], array('email', 'app'))) {
		
			if ($currentScheduledType[0] == 'email') {
				$currentScheduledType = 'email';
			} else if ($currentScheduledType[0] == 'app') {
				$reportScheduledApp = explode('${pipe}', $currentScheduledType[1]);
				$reportScheduledFixedParameters = explode('${dp}', $reportScheduledApp[2]);
				$fixedParamsArray = array();
				foreach ($reportScheduledFixedParameters as $currentFixedParameter) {
					$currentFixedParameterValues = explode('${comma}', $currentFixedParameter);
					$fixedParamsArray[] = array(
						'name' => $currentFixedParameterValues[0],
						'internal' => $currentFixedParameterValues[1],
						'value' => $currentFixedParameterValues[2],
					);
				}
				$appParameters = array(
					'application' => $reportScheduledApp[0],
					'url' => $reportScheduledApp[1],
					'parameters' => array(
						'fixed' => $fixedParamsArray,
						'external' => $reportScheduledApp[3],
					),
					'clean' => array(
						'headers' => ($reportScheduledApp[4] == '1'),
						'quotes' => ($reportScheduledApp[5] == '1'),
					)
				);
				$currentScheduledType = 'app:'.urlencode(json_encode($appParameters));
				
			} else {
				$currentScheduledType = 'email';
			}
			
			$db->query("UPDATE asol_reports SET report_scheduled_type = '".$currentScheduledType."' WHERE id='".$currentId."'");
			
		}
		
	}
	
}
//***************************************//
//*********Migrate Reports Charts********//
//***************************************//


//***************************************//
//*********Migrate Reports Charts********//
//***************************************//
function migrateReportScheduledTasksToJson() {

	global $db;
	
	$notScheduledUpdate = 'UPDATE asol_reports SET report_tasks = NULL WHERE report_tasks LIKE "${GMT}%"';
	$db->query($notScheduledUpdate);
	$resultSet = $db->query('SELECT id, name, report_tasks FROM asol_reports WHERE deleted=0 AND report_tasks IS NOT NULL AND report_tasks NOT LIKE "\%7B\%22data\%22\%3A%" ORDER BY date_entered DESC');
	
	while($row = $db->fetchByAssoc($resultSet)) {
	
		$currentId = $row['id'];
		$currentName = $row['name'];
		
		$currentTasksGmt = explode('${GMT}', $row['report_tasks']);
		$currentTasks = explode('|', $currentTasksGmt[0]);
		$currentTZ = (empty($currentTasksGmt[1]) ? date("Z")/3600 : null);
		
		$newFormatTasksData = array();
		
		foreach ($currentTasks as $singleTask) {
			
			$taskValues = explode(':', $singleTask);
			$currentTime = explode(',', $taskValues[3]);
			$calculatedHour = ($currentTime[0] - (isset($currentTZ) ? $currentTZ : 0));
			$unformattedHour = ($calculatedHour < 0 ? $calculatedHour+24 : $calculatedHour);
			$currentHour = (strlen($unformattedHour) == 1 ? '0'.$unformattedHour : $unformattedHour);
			$currentMinute = $currentTime[1];
			
			$newFormatTasksData[] = array(
				'name' => $taskValues[0],
				'range' => array(
					'type' => $taskValues[1],
					'value' => ($taskValues[1] == 'daily' ? null : $taskValues[2])
				),
				'time' => $currentHour.':'.$currentMinute,
				'end' => $taskValues[4],
				'status' => $taskValues[5] 
			);
			
		}
		
		$newFormatTasks = array(
			'data' => $newFormatTasksData,
			'offset' => (empty($currentTasksGmt[1]) ? date("Z") : $currentTasksGmt[1]*3600),
		);
		
		$newFormatTasks = rawurlencode(json_encode($newFormatTasks));
		
		$db->query("UPDATE asol_reports SET date_modified = '".gmdate("Y-m-d H:i:s")."', report_tasks = '".$newFormatTasks."' WHERE id='".$currentId."'");
			
	}

}
//***************************************//
//*********Migrate Reports Charts********//
//***************************************//


//*********************************************//
//*********Migrate Reports Enum Formats********//
//*********************************************//
function migrateReportEnumFormats() {

	global $db;

	$resultSet = $db->query('SELECT id, name, report_fields, report_filters FROM asol_reports WHERE deleted=0 AND report_fields IS NOT NULL AND is_meta=0');
	
	while($row = $db->fetchByAssoc($resultSet)) {
	
		$currentId = $row['id'];
		$currentName = $row['name'];
		$currentFields = unserialize(base64_decode($row['report_fields']));
		$currentFilters = unserialize(base64_decode($row['report_filters']));
	
		$modifiedReport = false;
		foreach ($currentFields['tables'][0]['data'] as & $singleField) {
	
			$currentFormatType = $singleField['format']['type'];
			$currentFormatExtra = $singleField['format']['extra'];
			$currentTemplates = $singleField['templates'];
			if (!isset($singleField['format']['extra']['data'])) {
				if (($currentFormatType == 'enum') && !empty($currentFormatExtra)) {
					$singleField['format']['extra'] = array(
						'mode' => '',
						'data' => (isset($currentTemplates['enum']) ? 'hasTemplate' : $singleField['format']['extra'])
					);
					$modifiedReport = true;
				}
			}
	
		}
	
		foreach ($currentFilters['data'] as & $singleFilter) {
	
			$currentOptions = $singleFilter['userOptions'];
			$currentTemplates = $singleFilter['templates'];
			if (!isset($singleFilter['userOptions']['data'])) {
				if (!empty($currentOptions) || (isset($currentTemplates['enum']))) {
					$singleFilter['userOptions'] = array(
						'mode' => '',
						'data' => (isset($currentTemplates['enum']) ? 'hasTemplate' : $singleFilter['userOptions'])
					);
					$modifiedReport = true;
				}
			}
	
		}
	
		if ($modifiedReport) {
	
			$currentFields = base64_encode(serialize($currentFields));
			$currentFilters = base64_encode(serialize($currentFilters));
			$db->query("UPDATE asol_reports SET report_fields = '".$currentFields."', report_filters = '".$currentFilters."' WHERE id='".$currentId."'");
	
		}
	
	}
	
}
//*********************************************//
//*********Migrate Reports Enum Formats********//
//*********************************************//


//*************************************//
//*********Migrate Reports Type********//
//*************************************//
function migrateReportTypeToJson() {
	
	global $db;
	
	$db->query("UPDATE asol_reports SET report_type=CONCAT('%7B%22type%22%3A%22', report_type, '%22%7D') WHERE (report_type LIKE 'manual%' OR report_type LIKE 'scheduled%' OR report_type LIKE 'internal%' OR report_type LIKE 'external%' OR report_type LIKE 'webservice_remote%' OR report_type LIKE 'webservice_source%' OR report_type = 'stored')");
	$db->query("UPDATE asol_reports SET report_type=CONCAT('%7B%22type%22%3A%22', REPLACE(report_type, ':', '%22,%22data%22%3A%22'), '%22%7D') WHERE report_type LIKE 'stored:%'");
	
}


//*************************************//
//*****Migrate External Tablesype******//
//*************************************//
function migrateReportExternalTables() {
	
	global $db;
	
	$checkReportsModule_Query = $db->query("SHOW COLUMNS FROM asol_reports LIKE 'report_module'");
	if ($checkReportsModule_Query->num_rows > 0) {
		$db->query("UPDATE asol_reports SET report_module=REPLACE(RIGHT(report_module, (LENGTH(report_module) - LOCATE('.', report_module))), ' (External_Table)', '') WHERE alternative_database != '-1' AND report_module LIKE '%(External_Table)'");
	}
	
}


//*************************************//
//*****Migrate External Tablesype******//
//*************************************//
function migrateReportDataSource() {
	
	global $db;
	
	$checkReportsDataSource_Query = $db->query("SHOW COLUMNS FROM asol_reports LIKE 'data_source'");
	if ($checkReportsDataSource_Query->num_rows === 0) {
		$db->query("ALTER TABLE asol_reports ADD data_source VARCHAR( 255 ) NULL AFTER assigned_user_id");
		$db->query("UPDATE asol_reports SET data_source = CONCAT('%7B%22type%22%3A%220%22%2C%22value%22%3A%7B%22database%22%3A%22', COALESCE(alternative_database, ''), '%22%2C%22module%22%3A%22', COALESCE(report_module, ''), '%22%2C%22audit%22%3A%22', COALESCE(audited_report, '0'), '%22%7D%7D') WHERE alternative_database = '-1'");
		$db->query("UPDATE asol_reports SET data_source = CONCAT('%7B%22type%22%3A%220%22%2C%22value%22%3A%7B%22database%22%3A%22', COALESCE(alternative_database, ''), '%22%2C%22module%22%3A%22', COALESCE(report_module, ''), '%22%7D%7D') WHERE alternative_database != '-1'");

		$db->query("ALTER TABLE asol_reports DROP alternative_database");
		$db->query("ALTER TABLE asol_reports DROP report_module");
		$db->query("ALTER TABLE asol_reports DROP audited_report");
	}
	
}


//************************************//
//***Migrate Reports Base64 Columns***//
//************************************//
function migrateReportsBase64Columns() {
	
	global $db;
	
	$resultSet = $db->query('SELECT id, name, report_fields, report_filters, report_charts_detail FROM asol_reports WHERE is_meta=0 AND deleted=0');
	
	while ($row = $db->fetchByAssoc($resultSet)) {
		
		$currentId = $row['id'];
		$currentName = $row['name'];
		
		if (base64_encode(base64_decode($row['report_fields'])) === $row['report_fields']) {
			
			$currentFields = unserialize(base64_decode($row['report_fields']));
			$currentFilters = unserialize(base64_decode($row['report_filters']));
			$currentCharts = unserialize(base64_decode($row['report_charts_detail']));
			
			$db->query("UPDATE asol_reports SET report_fields = '".rawurlencode(json_encode($currentFields))."', report_filters='".rawurlencode(json_encode($currentFilters))."', report_charts_detail='".rawurlencode(json_encode($currentCharts))."' WHERE id='".$currentId."'");
			
		}
		
	}
	
}
//************************************//
//***Migrate Reports Base64 Columns***//
//************************************//

?>