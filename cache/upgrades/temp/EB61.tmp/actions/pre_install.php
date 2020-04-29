<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $db;

$result = $db->query("SELECT id_name, name, version FROM upgrade_history WHERE id_name = 'AlineaSolCommonBase' AND status = 'installed'");
if ($result->num_rows == 1) {
	$result = $db->fetchByAssoc($result);
	die ("<span style='color: orange;'>Warning:</span> Please uninstall the module <strong>AlineaSol CommonBase ".$result['version']."</strong> first. Please keep the database tables for update.");
}

//**************************//
//***Rename Common Tables***// 
//**************************//
renameCommonTables();
//**************************//
//***Rename Common Tables***//
//**************************//


//**************************//
//***Create Common Tables***//
//**************************//
createCommonTables();
//**************************//
//***Create Common Tables***//
//**************************//

//***************************//
//***Update Missing Fields***//
//***************************//
updateMissingFields();
//***************************//
//***Update Missing Fields***//
//***************************//


//***************************************//
//***Increase Common Variables Length***//
//***************************************//
increaseCommonVarsLength();
//***************************************//
//***Increase Common Variables Length***//
//***************************************//


//***************************//
//***Migrate Config Format***//
//***************************//
migrateConfigFormat();
//***************************//
//***Migrate Config Format***//
//***************************//


//******************************//
//***Migrate Templates Format***//
//******************************//
migrateTemplatesFormat();
//******************************//
//***Migrate Templates Format***//
//******************************//


function renameCommonTables() {

	global $db;

	$configTableExistsQuery = $db->query("SHOW tables like 'asol_config'", false);
	$templatesTableExistsQuery = $db->query("SHOW tables like 'asol_reports_templates'", false);
	
	if ($configTableExistsQuery->num_rows > 0) {
		$db->query("RENAME TABLE asol_config TO asol_common_config");
	}
	
	if ($templatesTableExistsQuery->num_rows > 0) {
		$db->query("RENAME TABLE asol_reports_templates TO asol_common_templates");
	}

}


function createCommonTables() {

	global $db;

	$GLOBALS['log']->debug("**********[ASOL][CommonBase]: Creating DB tables");

	$db->query("CREATE TABLE IF NOT EXISTS ".$db_name.".`asol_common_config` (
		  `id` CHAR(36) NOT NULL, 
		  `name` VARCHAR(255) NOT NULL, 
		  `date_entered` DATETIME NULL DEFAULT NULL, 
		  `date_modified` DATETIME NULL DEFAULT NULL, 
		  `modified_user_id` CHAR(36) NULL DEFAULT NULL, 
		  `created_by` CHAR(36) NULL DEFAULT NULL, 
		  `deleted` TINYINT(1) NULL DEFAULT '0', 
		  `category` VARCHAR(12) NULL DEFAULT NULL, 
		  `config` TEXT DEFAULT NULL, 
		  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
	
	$db->query("CREATE TABLE IF NOT EXISTS `asol_common_templates` (
	  `id` char(36) NOT NULL,
	  `name` varchar(255) NULL,
	  `date_entered` datetime DEFAULT NULL,
	  `date_modified` datetime DEFAULT NULL,
	  `modified_user_id` char(36) DEFAULT NULL,
	  `created_by` char(36) DEFAULT NULL,
	  `description` text DEFAULT NULL,
	  `deleted` tinyint(1) DEFAULT '0',
	  `module` varchar(255) NULL,
	  `field` varchar(255) NULL,
	  `category` varchar(12) NULL,
	  `content` longtext,
	  PRIMARY KEY (`id`)) ENGINE=INNODB DEFAULT CHARSET=utf8;");
	
	$db->query("CREATE TABLE IF NOT EXISTS `asol_common_properties` (
	  `id` char(36) NOT NULL,
	  `name` varchar(255) NULL,
	  `date_entered` datetime DEFAULT NULL,
	  `date_modified` datetime DEFAULT NULL,
	  `modified_user_id` char(36) DEFAULT NULL,
	  `created_by` char(36) DEFAULT NULL,
	  `description` text DEFAULT NULL,
	  `deleted` tinyint(1) DEFAULT '0',
	  `category` varchar(12) NULL,
	  `content` text,
	  `asol_domain_id` char(36) DEFAULT NULL,
	  PRIMARY KEY (`id`)) ENGINE=INNODB DEFAULT CHARSET=utf8;");
	
	$db->query("CREATE TABLE IF NOT EXISTS `asol_common_licensing` (
			`module` VARCHAR(75) NOT NULL,
			`linfo` VARCHAR(255) NOT NULL,
			PRIMARY KEY (`module`)
		)
		COMMENT='This table manages information about licensing.'
		ENGINE=InnoDB DEFAULT CHARSET=utf8;");
}

function updateMissingFields() {
	 
	global $db;

	/*******************/
	/*****category******/
	/*******************/
	$checkCommonCategory_Query = $db->query("SHOW COLUMNS FROM asol_common_config LIKE 'category'");
	if ($checkCommonCategory_Query->num_rows === 0)
		$db->query("ALTER TABLE asol_common_config ADD category VARCHAR(12) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER deleted");
	
}

function increaseCommonVarsLength() {

	global $db;
	
	$db->query("ALTER TABLE asol_common_config CHANGE config config TEXT NULL DEFAULT NULL");
	$db->query("ALTER TABLE asol_common_templates CHANGE content content LONGTEXT NULL DEFAULT NULL");

}

function migrateConfigFormat() {
	
	global $db;
	
	$configRs = $db->query("SELECT id, config FROM asol_common_config WHERE deleted=0 ORDER BY date_entered DESC");
	
	while ($configRow = $db->fetchByAssoc($configRs)) {
	
		if (base64_encode(base64_decode($configRow['config'])) === $configRow['config'])
			continue;
	
		$currentConfig = explode("|", $configRow['config']);
		
		$userConfig = array(
			'fiscalMonthInit' => $currentConfig[0],
			'entriesPerPage' => $currentConfig[1],
			'pdfOrientation' => $currentConfig[2],
			'pdfImgScalingFactor' => $currentConfig[4]/100,
			'weekStartsOn' => $currentConfig[3],
		);
		
		$globalConfig = array(
			'storedFilesTtl' => $currentConfig[5],
			'hostName' => $currentConfig[6]
		);
		
		$userConfig64 = base64_encode(serialize($userConfig));
		$db->query('UPDATE asol_common_config SET category="user", config="'.$userConfig64.'" WHERE id="'.$configRow['id'].'" LIMIT 1');
		
	}
	
	if (isset($globalConfig)) {
		
		$globalConfig64 = base64_encode(serialize($globalConfig));
		$db->query("INSERT IGNORE INTO asol_common_config (id, name, date_entered, date_modified, modified_user_id, created_by, deleted, category, config) VALUES ('".create_guid()."', '', '".gmdate("Y-m-d H:i:s")."', '".gmdate("Y-m-d H:i:s")."', '1', '1', 0, 'global', '".$globalConfig64."')");
		
	}
	
}

function migrateTemplatesFormat() {
	
	global $db;
	
	$templateRs = $db->query("SELECT id, content FROM asol_common_templates WHERE deleted=0 ORDER BY date_entered DESC");
	
	while ($templateRow = $db->fetchByAssoc($templateRs)) {
		
		if (base64_encode(base64_decode($templateRow['content'])) === $templateRow['content']) {
			$db->query('UPDATE asol_common_templates SET content="'.rawurlencode(json_encode(unserialize(base64_decode($templateRow['content'])))).'" WHERE id="'.$templateRow['id'].'" LIMIT 1');
		} else {
			continue;
		}
		
	}
		
}

?>