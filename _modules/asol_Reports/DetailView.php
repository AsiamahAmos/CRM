<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

SugarApplication::redirect('index.php?module=asol_Reports&action=index&view=detail&record='.$_REQUEST['record']);

?>
