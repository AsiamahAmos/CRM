<?php
	
if (is_file("modules/asol_Common/include/commonUtils.php")) {
				
	require_once("modules/asol_Common/include/commonUtils.php");
	asol_CommonUtils::executeModuleMenu($_REQUEST["type"], $_REQUEST["id"], $_REQUEST["url"], $_REQUEST["title"], $_REQUEST["javascript"]);
	
}
				
?>