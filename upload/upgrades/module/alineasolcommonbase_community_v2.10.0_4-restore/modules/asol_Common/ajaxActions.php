<?php

error_reporting(1); //E_ERROR

require_once('modules/asol_Common/include/commonUtils.php');

$actionTarget = $_REQUEST['actionTarget'];
$actionValue = json_decode(html_entity_decode($_REQUEST['actionValue'], ENT_QUOTES), true);

if ($actionTarget == 'downloadCommonAttachment') {

	$mimeType = (!empty($_REQUEST['mimeType']) ? $_REQUEST['mimeType'] : 'application/octet-stream');
	$fileName = $_REQUEST['fileName'];
	$fileContent = str_replace(" ", "+", $_REQUEST['fileContent']);
	$isBase64Content = ($_REQUEST['isBase64Content'] === 'true' ? true : false);
	$getContent = ($_REQUEST['getContent'] === 'true' ? true : false);

	if ($getContent) {

		//***********************//
		//***AlineaSol Premium***//
		//***********************//
		if (!$isBase64Content) {

			$returnedPhpFunction = asol_CommonUtils::managePremiumFeature("commonPhpFunctions", "commonFunctions.php", "getCommonPhpFunctionResultWithReplacedVariables", unserialize(base64_decode($fileContent)));
			$fileContent = ($returnedPhpFunction !== false) ? $returnedPhpFunction : $fileContent;

		}
		//***********************//
		//***AlineaSol Premium***//
		//***********************//
			

		header("Content-Type: ".$mimeType);
		header("Content-Disposition: attachment; filename=\"".$fileName."\"");
		header("Content-Description: File Transfer");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".mb_strlen(base64_decode($fileContent), "8bit")."\"");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Pragma: public");
			
		ob_clean();
		flush();

		$returnedHtml = base64_decode($fileContent);

	}

} else if ($actionTarget == 'saveCommonEntry') {
	
	global $db, $current_user;
	
	$commonTable = $_REQUEST['commonTable'];
	$entryId = (isset($_REQUEST['entryId']) ? $_REQUEST['entryId'] : null);
	
	if ($current_user->is_admin && in_array($commonTable, array('asol_common_templates', 'asol_common_properties'))) {
		
		if ($commonTable == 'asol_common_templates') {
			
			$name = urldecode($_REQUEST['template_name']);
			$module = urldecode($_REQUEST['template_module']);
			$field = urldecode($_REQUEST['template_field']);
			$category = urldecode($_REQUEST['template_category']);
			$content = json_decode(html_entity_decode(urldecode($_REQUEST['template_content'])), true);
			
			if ($entryId == null) {
				$entryId = create_guid();
				$db->query("INSERT INTO ".$commonTable." (id, name, date_entered, date_modified, modified_user_id, created_by, description, deleted, module, field, category, content) VALUES ('".$entryId."', '".$name."', '".gmdate("Y-m-d H:i:s")."', '".gmdate("Y-m-d H:i:s")."', '".$current_user->id."', '".$current_user->id."', NULL, 0, '".$module."', '".$field."', '".$category."', '".rawurlencode(json_encode($content))."')");
			} else {
				$db->query("UPDATE ".$commonTable." SET name='".$name."', date_modified='".gmdate("Y-m-d H:i:s")."', modified_user_id='".$current_user->id."', module='".$module."', field='".$field."', content='".rawurlencode(json_encode($content))."' WHERE id='".$entryId."'");
			}
				
			$returnedHtml = json_encode(array('id' => $entryId, 'name' => $name, 'category' => $category, 'module' => $module, 'field' => $field, 'content' => $content));
			
		} else if ($commonTable == 'asol_common_properties') {
			
			$name = urldecode($_REQUEST['property_name']);
			$category = urldecode($_REQUEST['property_category']);
			$content = $_REQUEST['property_content'];

			if ($entryId == null) {
				$entryId = create_guid();
				$db->query("INSERT INTO ".$commonTable." (id, name, date_entered, date_modified, modified_user_id, created_by, description, deleted, category, content, asol_domain_id) VALUES ('".$entryId."', '".$name."', '".gmdate("Y-m-d H:i:s")."', '".gmdate("Y-m-d H:i:s")."', '".$current_user->id."', '".$current_user->id."', NULL, 0, '".$category."', '".$content."', '".$current_user->asol_default_domain."')");
			} else {
				$db->query("UPDATE ".$commonTable." SET name='".$name."', date_modified='".gmdate("Y-m-d H:i:s")."', modified_user_id='".$current_user->id."', content='".$content."', category='".$category."' WHERE id='".$entryId."'");
			}
				
			$returnedHtml = json_encode(array('id' => $entryId, 'name' => $name, 'category' => $category, 'content' => json_decode(rawurldecode($content), true)));
			
		}
		
	}
	
	if ($commonTable == 'asol_bookmark') {
		$title = $_REQUEST['bookmark_title'];
		$comment = $_REQUEST['bookmark_comment'];
		$bookmark_position = $_REQUEST['bookmark_position'];
		$record = $_REQUEST['record'];
		$context = rawurlencode($_REQUEST['context']);
		$tree_id = $_REQUEST['tree_id'];
		$tree_content = $_REQUEST['tree_content'];
		
		if ($entryId == null) {
			$entryId = create_guid();
			// '".$current_user->asol_default_domain."'
			$db->query("INSERT INTO ".$commonTable." (id, user_id, tree_id, position, record, context, title, description, deleted, date_entered, date_modified) VALUES ('".$entryId."', '".$current_user->id."', '".$tree_id."', '".$bookmark_position."', '".$record."', '".$context."', '".$title."', '".$comment."', '0', '".gmdate("Y-m-d H:i:s")."', '".gmdate("Y-m-d H:i:s")."')");
		} else {
			$db->query("UPDATE ".$commonTable." SET position='".$bookmark_position."', record = '".$record."', context='".$context."', title='".$title."', description='".$comment."', date_modified='".gmdate("Y-m-d H:i:s")."' WHERE id='".$entryId."'");
		}
		
		$db->query("UPDATE ".$commonTable."_tree SET content='".$tree_content."', date_modified='".gmdate("Y-m-d H:i:s")."' WHERE id='".$tree_id."'");
		
		//$returnedHtml = json_encode(array('id' => $entryId, 'user_id' => $current_user->id, 'context' => $context, 'description' => $comment, 'deleted' => '0',  'date_entered' => $date_entered,  'date_modified' => $date_modified));
	}
	
} else if ($actionTarget == 'getCommonContent') {
	
	global $db, $current_user;
	
	$commonTable = $_REQUEST['commonTable'];
	$entryId = $_REQUEST['entryId'];
	$field = $_REQUEST['field'];
	$context = $_REQUEST['context'];
	
	if ($commonTable == 'asol_bookmark') {
		if (!isset($field)){
			// Check if is format bookmark
			if (isset($context))
				$query = "SELECT id, position, record ,context, title, description FROM ".$commonTable." WHERE record = '" . $entryId . "' AND context LIKE '". $context ."' AND user_id = '" . $current_user->id . "' AND deleted=0 LIMIT 1";
			else
				$query = "SELECT id, position, record ,context, title, description FROM ".$commonTable." WHERE record = '" . $entryId . "' AND user_id = '" . $current_user->id . "' AND deleted=0 LIMIT 1";
					
			$query = $db->query($query);
			$query = $db->fetchByAssoc($query);
			$returnedHtml = json_encode($query);
		} else {
			$query = "SELECT * FROM ".$commonTable." WHERE " . $field . " = '" . $entryId . "' AND user_id = '" . $current_user->id . "' AND deleted=0";
			$result = $db->query($query);
			while($row = $db->fetchByAssoc($result))
				$object[] = $row;
			
			$returnedHtml = json_encode($object);
		}
		
	} else if ($commonTable == 'asol_bookmark_tree') {
		$query = "SELECT * FROM ".$commonTable." WHERE user_id = '" . $current_user->id . "' LIMIT 1";
		$query = $db->query($query);
		$query = $db->fetchByAssoc($query);
		$returnedHtml = json_encode($query);
	}
	
} else if ($actionTarget == 'deleteCommonEntry') {

	
	global $current_user, $db;
	
	$commonTable = $_REQUEST['commonTable'];
	$entryId = $_REQUEST['entryId'];
	
	if ($current_user->is_admin && in_array($commonTable, array('asol_reports_relations', 'asol_common_templates', 'asol_common_properties'))) {
		$db->query("UPDATE ".$commonTable." SET deleted=1 WHERE id='".$entryId."'");
	}
	
	if ($commonTable == 'asol_bookmark') {
		$db->query("UPDATE ".$commonTable." SET deleted=1 WHERE id='".$entryId."'");
	}
	
} else if ($actionTarget == 'getAvailableItems') {
	
	$currentModule = $_REQUEST['commonModule'];
	$returnedHtml = json_encode(asol_CommonUtils::getAvailableItems($currentModule));
	
} else if ($actionTarget == 'getAvailableReferences') {
	
	$currentModule = $_REQUEST['commonModule'];
	$currentRecord = $_REQUEST['commonItem'];
	$returnedHtml = json_encode(asol_CommonUtils::getAvailableReferences($currentModule, $currentRecord));
	
} else if ($actionTarget == 'getAvailableModuleFields') {
	
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	$extraParams = array(
		'sourceModule' => $_REQUEST['sourceModule'],
		'commonDB' => $_REQUEST['commonDB'],
		'commonModule' => $_REQUEST['commonModule'],
		'commonField' => $_REQUEST['commonField'],
	);
	$returnedModuleRelate = asol_CommonUtils::managePremiumFeature("commonRelateFormat", "commonFunctions.php", "getCommonRelateModuleInfo", $extraParams);
	$returnedHtml = ($returnedModuleRelate !== false ? json_encode($returnedModuleRelate) : '');
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	
} else if ($actionTarget == 'getBasicModuleSearch') {
	
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	$extraParams = array(
		'sourceModule' => $_REQUEST['sourceModule'],
		'commonDB' => $_REQUEST['commonDB'],
		'commonModule' => $_REQUEST['commonModule'],
		'commonFields' => json_decode(rawurldecode(html_entity_decode($_REQUEST['commonFields'], ENT_QUOTES)), true),
		'commonFilters' => json_decode(rawurldecode(html_entity_decode($_REQUEST['commonFilters'], ENT_QUOTES)), true),
		'commonPage' => $_REQUEST['commonPage']
	);
	$returnedModuleSearch = asol_CommonUtils::managePremiumFeature("commonRelateFormat", "commonFunctions.php", "getCommonBasicModuleSearch", $extraParams);
	$returnedHtml = ($returnedModuleSearch !== false ? json_encode($returnedModuleSearch) : '');
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	
} else if ($actionTarget == 'saveCommonMenuItems') {
	
	$returnedHtml = asol_CommonUtils::saveMenuFile($actionValue);
	
} else if ($actionTarget == 'saveCommonFieldVariables') {
	
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	$extraParams = array('fieldsConfig' => $actionValue);
	$saveCommonFieldsAlert = asol_CommonUtils::managePremiumFeature("commonFieldsManagement", "commonFunctions.php", "saveFieldVariables", $extraParams);
	$returnedHtml = ($saveCommonFieldsAlert !== false) ? translate('LBL_COMMON_FIELD_CREATION_OK', 'asol_Common') : translate('LBL_COMMON_FIELD_CREATION_NOK', 'asol_Common');
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	
} else if ($actionTarget == 'buttonPhpCode'){
	
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	$extraParams = array(
		'module' => $_REQUEST['module'],
		'record' => $_REQUEST['record'],
		'button' => $_REQUEST['button'],
		'currentValue' => $_REQUEST['currentValue'],
		'references' => $_REQUEST['references'],
	);
	$result = asol_CommonUtils::managePremiumFeature("getPhpButtonResponse", "commonFunctions.php", "getPhpButtonResponse", $extraParams);
	$returnedHtml = ($result !== false ? $result : translate('LBL_COMMON_PHP_BUTTON_ERROR', 'asol_Common'));
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	
} else if ($actionTarget == 'getSoapFunctions'){
	
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	$extraParams = array(
		'url' => $_REQUEST['url'],
	);
	$result = asol_CommonUtils::managePremiumFeature("getSoapFunctions", "commonFunctions.php", "getSoapFunctions", $extraParams);
	$returnedHtml = ($result !== false ? $result : '');
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	
} else if ($actionTarget == 'webServiceRequest') {
		
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	$extraParams = array(
		'options' => $_REQUEST['options'],
	);
	$result = asol_CommonUtils::managePremiumFeature("webServiceRequest", "commonFunctions.php", "webServiceRequest", $extraParams);
	$returnedHtml = ($result !== false ? $result : '');
	//***********************//
	//***AlineaSol Premium***//
	//***********************//
	
}

echo $returnedHtml;

