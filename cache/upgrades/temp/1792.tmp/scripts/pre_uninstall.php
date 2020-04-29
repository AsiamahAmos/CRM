<?php
function pre_uninstall() {
$sql_query="DROP TABLE oz_simplesms_param";
$GLOBALS['db']->query($sql_query,true);

}
?>
