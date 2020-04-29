<?php

if (is_file("modules/asol_Common/include/commonUtils.php")) {
	require_once("modules/asol_Common/include/commonUtils.php");
	asol_CommonUtils::executeModuleMenu($_REQUEST["type"], $_REQUEST["id"], (isset($_REQUEST["url"]) ? $_REQUEST["url"] : null), (isset($_REQUEST["title"]) ? $_REQUEST["title"] : null), (isset($_REQUEST["javascript"]) ? $_REQUEST["javascript"] : null));
}

?>