<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

//Buscamos todos los ficheros de la carpeta temporal de informes y los eliminamos
$dir = "modules/asol_Reports/tmpReportFiles/";
$directorio=opendir($dir); 

while ($archivo = readdir($directorio))
	@unlink ($dir.$archivo); 

closedir($directorio); 

?>