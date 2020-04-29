<?php 
function pre_install() {
	$sql_query="CREATE TABLE IF NOT EXISTS oz_simplesms_param (
id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
nghost varchar(255) NOT NULL,
ngport varchar(255) NOT NULL,
nguser varchar(255) NOT NULL,
ngpass varchar(255) NOT NULL
)";
$GLOBALS['db']->query($sql_query,true);

$sql_query="TRUNCATE TABLE oz_simplesms_param";
$GLOBALS['db']->query($sql_query,true);

$sql_query="INSERT INTO oz_simplesms_param (id, nghost, ngport, nguser, ngpass) VALUES ('1', '127.0.0.1', '9501', 'admin', 'abc123');";
$GLOBALS['db']->query($sql_query,true);

}
?>