<?php 
require_once("class_ozekisend.inc.php");
require_once ("oz_SimpleSMS.php");
$bean = new oz_SimpleSMS();
print(get_module_title($mod_strings['LBL_MODULE_TITLE'],$mod_strings['LBL_MODULE_TITLE'],true));

if (array_key_exists("param",$_GET)) {
	if ($_GET["param"]=="config"){
		if (is_admin($current_user)){
			$parameters=$bean->oz_get_configure();
			$bean->oz_configure_panel($parameters["nghost"],$parameters["ngport"],$parameters["nguser"],$parameters["ngpass"]);
		}
	}
	elseif ($_GET["param"]=="conf_save") {
		if (is_admin($current_user)){
			$bean->oz_set_configure($_GET["ozhost"],$_GET["ozport"],$_GET["ozuser"],$_GET["ozpass"]);
			$parameters=$bean->oz_get_configure();
			$bean->oz_configure_panel($parameters["nghost"],$parameters["ngport"],$parameters["nguser"],$parameters["ngpass"]);
		}
	}
	elseif ($_GET["param"]=="send") {
		$error_code=0;
		$result=$bean->oz_get_configure();
		$os = new ozekisend($result["nghost"],$result["ngport"],$result["nguser"],$result["ngpass"]);
		$response=$os->ozekisend($_GET["ozphone"],$_GET["ozmessage"],FALSE);
		$error_code=$os->oz_response_parser($response);
		if ($error_code!=0) {
			$bean->oz_error_display($mod_strings["LBL_SEND_FAILED"]." ".$error_code,"error");
		}
		else {
			$bean->oz_error_display($mod_strings["LBL_SEND_SUCCESS"],"");
		}
		$bean->oz_sms_send_panel("simple");
	}
	elseif ($_GET["param"]=="contact") {
		$bean->oz_sms_send_panel("contact");
	}
	elseif ($_GET["param"]=="con_send"){
		$result=$bean->oz_get_configure();
		$os = new ozekisend($result["nghost"],$result["ngport"],$result["nguser"],$result["ngpass"]);
		$error_code=0;
		foreach ($_GET["oz_recipient"] as $phone) {
			$response=$os->ozekisend($phone,$_GET["ozmessage"],FALSE);
			if ($error_code==0) {
				$error_code=$os->oz_response_parser($response);
			}
		}
		if ($error_code!=0) {
			$bean->oz_error_display($mod_strings["LBL_SEND_FAILED"]." ".$error_code,"error");
		}
		else {
			$bean->oz_error_display($mod_strings["LBL_SEND_SUCCESS"],"");
		}
		$bean->oz_sms_send_panel("contact");
	}
}
else {
	$bean->oz_sms_send_panel("simple");
}





?>