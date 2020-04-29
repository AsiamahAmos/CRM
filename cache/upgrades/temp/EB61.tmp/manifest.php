<?php

global $theme;

$manifest = array (
 	'built_in_version' => '7.5.0.0',
    'acceptable_sugar_versions' => 
     array (
     	0 => '',
     ),
	 'acceptable_sugar_flavors' =>
     array(
        'CE', 'PRO', 'ENT', 'CORP', 'ULT'
	 ),
	 'readme'=>'',
	 'key'=>'asol',
	 'author' => 'AlineaSol',
	 'description' => '',
	 'icon' => '',
	 'is_uninstallable' => true,
	 'name' => 'AlineaSol Common Base - Community Edition',
	 'published_date' => '2018-06-11',
	 'type' => 'module',
	 'version' => '2.10.0',
	 'remove_tables' => 'prompt',
);

$installdefs = array (
  'id' => 'AlineaSolCommonBase', 
  'layoutdefs' => array (),
  'relationships' => array (),
  'image_dir' => '<basepath>/icons',
  'copy' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/modules',
      'to' => 'modules',
    ),
	1 => 
    array (
      'from' => '<basepath>/custom',
      'to' => 'custom',
    ),
  ),
  'entrypoints' => array (
	0 => array (
	  'from' => '<basepath>/custom/entrypoints/asolCommon_registry.php',
	  'to_module' => 'application',
	),
  ),
  
  'pre_execute' => array (
	0 => '<basepath>/actions/pre_install.php',
  ),
  'post_execute' => array (
	0 => '<basepath>/actions/post_install.php',
  ),
  'pre_uninstall' => array (
	0 => '<basepath>/actions/pre_uninstall.php',
  ),
  'post_uninstall' => array (
	0 => '<basepath>/actions/post_uninstall.php',
  ),
  
);