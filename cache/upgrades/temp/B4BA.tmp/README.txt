//**************************************//
//****************Notes*****************//
//**************************************//

- The PHP memory limit in php.ini (memory_limit = 256M ) should be set to a minimum of 256MB to allow PDF rendering. 

- To test possible issues with memory limit or similar situations, exists some additional traces in the PDF report generation process (including PHP memory usage traces). 

- This module will modify the "User.php" file to fix a bug in Users module (this module does not obtain the email of the logged user to send emails).

- Also, "entry_point_registry.php" file will be modified to supporting report scheduled tasks and exported reports. 
To configure this functionality, you must configure the admin schedulers module of sugarCRM and create a new Scheduler that executes the url "http://localhost/sugarCRM_dir_in_htdocs/index.php?entryPoint=scheduledTask&module=asol_Reports" every 15 minutes and every day.

- To add a custom logo to your exported PDF reports, the logo image you add to sugarCRM must be in "PNG" image format.

- If you don't want to share your exported report's email list, just find the following line: s:10:"email_list";s:36:"example1@mail.com, example2@mail.com";
Then, replace it by: s:10:"email_list";s:0:"";

- When programing scheduled reports with a link to the report with charts, you must configure the "host name" option of your AlineaSolReports module to generate that link correctly: 
e.g. 'www.your_domain_name.com/yourSugarCrmInstanceName'

- To import reports from Alineasol Reports module version 1.0, you must copy and save the emails list, the attachment format and the scheduled tasks before you delete the old module (while deleting the module, don't forget to remove database tables). 
When installing the new version and then importing the old reports, edit each report and update them with the emails, the attachment format and scheduled tasks saved previously.

- To upgrade from older versions than 1.2.2 to the current version, you must make a database repair and add the missing row, and then modify the Alineasol Reports Scheduler, appending the next string to the current: "&module=Reports".

- Also, for upgrade from older versions than 1.3.0 to the current version, you don't have to remove tables from reports module, but you should update the reports just modifying and saving them without any change. 
Anyway you can run any reports although you dont do this update.

- To upgrade from older versions than 2.0.0 to the current version, you must make a database repair and add the missing rows.

- To send external filters through url, you must add a "Filter Reference" value to filters when configuring a report. 
This is the structure for your external filters url query: "&external_filters=Filter1_ReferenceName${dp}Filter1_Operator${dp}Filter1_FirstParameter${dp}Filter1_SecondParameter${pipe}Filter2_ReferenceName${dp}Filter2_Operator${dp}Filter2_FirstParameter${dp}Filter2_SecondParameter{pipe}....".

- To configure an interactive Report, you can set the "Behaviour" value of a filter to "user input". Then this filter will appear at the execution of the report to perform a dynamic search (a filter reference must be defined for this filter to make it run).
If "visible" value is set, the filter configured value will be displayed but will not be modifiable when running report. Also when "user input" is selected, you can define user custom options (separated by commas) that will be displayed on a select input when running the report.

- In order to enable Reports for SugarCRM roles functionallity, you must execute a "Repair Roles" at the Administration Panel section.

- To upgrade from older versions than 2.3.1 to the current version, you must make a database repair and add the missing rows.

- To upgrade from older versions than 3.0.0 to the current version, you must make a database repair and add the missing row, and then modify the Alineasol Reports Scheduler url, replacing the string "&module=Reports" by "&module=asol_Reports".

- To upgrade from older versions than 3.1.1 to the current version, you must make a database repair and add the missing rows.

- To upgrade from older versions than 3.8.4 to the current version, it's Needed to modify the AlineaSol Report Scheduler Interval (to each 5 minutes) to reach Tasks new values.

//**************************************//
//****************Notes*****************//
//**************************************//



//**************************************//
//********Schedulers Definition*********//
//**************************************//

- Scheduler for automatically emailed reports:

	Create a new Scheduler that executes the url "http://localhost/sugarCRM_dir_in_htdocs/index.php?entryPoint=scheduledTask&module=asol_Reports". 
	Set the time interval to every 5 minutes.

- Scheduler to clean up report obsolete files & long time queries:

	Create a new Scheduler that executes the url "http://localhost/sugarCRM_dir_in_htdocs/index.php?entryPoint=reportCleanUp&module=asol_Reports".
	Set the time interval that fits your needs.


*  Be sure to uncheck the "Execute If Missed" option at advanced options.
** For shared environments, you must specify your public access url instead of "http://localhost/sugarCRM_dir_in_htdocs/".

//**************************************//
//********Schedulers Definition*********//
//**************************************//


//**************************************//
//******Config Override Features********//
//**************************************//

Activation of Features just configuring it at "config_override.php" file of your SugarCRM instance (just add the defined lines to this file):


	//********************************//
	//*******Community Features*******//
	//********************************//


	- External Database Connection:
		$sugar_config["asolReportsDbAddress"] = "192.168.0.X";
		$sugar_config["asolReportsDbUser"] = "root";
		$sugar_config["asolReportsDbPassword"] = "";
		$sugar_config["asolReportsDbName"] = "sugarcrm";
		$sugar_config["asolReportsDbPort"] = "3306";

		
	- Exporting Delimiter for CSV Reports:
		$sugar_config["asolReportsCsvDelimiter"] = ",";

		
	- Empty Exported Characters:
		$sugar_config["asolReportsExportReplaceByEmptyString"] = array ("€", "$");

	
	- Reports HTTP Request (the Url must be the same of your running sugarCRM instance):
		$sugar_config["asolReportsCurlRequestUrl"] = "http://127.0.0.1/sugarcrm"; // normally will be the localhost ip
		$sugar_config["asolReportsCurlRequestTimeout"] = 500; //timeout for curl executions in miliseconds.
		$sugar_config["asolReportsSystemCurlUsage"] = true; // Only for UNIX systems: system curl method will be used instead of PHP native one (improved performances).
		$sugar_config["asolReportsCheckHttpFileTimeout"] = "10000"; // interval to asking for executed report (in miliseconds)
		
		
	- Reporting Queue (this feature needs the "Report HTTP Request" feature enabled to work!!):
		$sugar_config['asolReportsDispatcherMaxRequests'] = 3; // Maximum number of reports executed simultaneously.
		$sugar_config['asolReportsMaxExecutionTime'] = 60; // Timeout for executed Reports.


	- Enable/Disable reports pagination:
		$sugar_config["asolReportsAvoidReportsPagination"] = false; // true -> [disable] / false -> [enable]


	- Override default entries per page form Reports when user options default is not setted.
		$sugar_config["asolOverrideDefaultEntriesPerPage"] = 30;
	
	
	- Permissions to Allow or Deny access to concrete modules (role denies permissions for modules already removes the modules from user module report list).
		
		$sugar_config["asolModulesPermissions"] = array(
			"asolAllowedTables" => array(
	            "instance" => array("Accounts", "Opportunities"),
	            "domain" => array(),
            ),
			"asolForbiddenTables" => array(
               	"instance" => array(),
               	"domain" => array(),
            ),
		);

		
	- Max allowed number of results to be managed by query by the SQL database used for reporting.
		$sugar_config["asolReportsMaxAllowedDisplayed"] = 5000; // max allowed number of results to be processed by PHP & displayed
		$sugar_config["asolReportsMaxAllowedGroupByEntries"] = 10000; // max allowed number of results to be grouped by SQL
		$sugar_config["asolReportsMaxAllowedParseMultiTable"] = 1000; //max allowed number of results to be managed by PHP at multitable feature 
		$sugar_config["asolReportsMaxAllowedResults"] = 1000000; // max allowed number of results to be managed by SQL 
		$sugar_config["asolReportsMaxAllowedNotIndexedOrderBy"] = 100000; // max allowed numbers of results to order report by not indexed fields.
		$sugar_config["asolReportsMaxAllowedResultsEmailAddressNotification"] = "mail_login_username@mail_server.com"; //Email to notify about the alert. An email will be sent to the report creator too.


	- Enable/Disable reports EditView labels Translation (Feature Enabled by Default):
		$sugar_config["asolReportsTranslateLabels"] = true; // true -> [enabled] / false -> [disabled]


	- Usage of predefined From and FromName for Report Emailing instead of report user owner.
		$sugar_config["asolReportsEmailsFrom"] = "do_not_reply@example.com";
		$sugar_config["asolReportsEmailsFromName"] = "Person Name";


	- Exported Reports default language.
		$sugar_config["asolReportsDefaultExportedLanguage"] = "en_us";


	- Exported CSV Reports codification.
		$sugar_config["asolReportsCsvCodification"] = "Windows-1252";
		

	- Report's phantomJS path (relative to and within the CRM folder) for SVG rendering and headless javascript execution.
		$sugar_config['asolReportsPhantomJsFilePath'] = "phantomjs.exe"; //include filename at path as it will be executed "./phantomjs" to execute it at Linux
	
	
	- Use te native library to generate PDF Reports, if exist phantomJS this is the default method to generate the documents but you can force tu use TCPDF.
		$sugar_config["asolReportsTCPDFUsage"] = false; // false(phantomJS) | true (tcpdf) 
		

	- Set of non-visible fields when configuring Report. Defined at module level. Defined fields must be written as is displayed on database field column.
		$sugar_config['asolReportsNonVisibleFields'] = array(
			"Accounts" => array("date_entered"),
			"Opportunities" => array("created_by", "assigned_user_id")
		);
		
	- Set role published reports modifiable by users.
		$sugar_config['asolAllowRoleModifiableReports'] = true; // true -> [enabled] / false -> [disabled]

	- Set NVD3 Graphs resizable
		$sugar_config['asolReportsResizableNVD3Charts'] = true; // true -> [enabled] / false -> [disabled]
		
	- Avoid users to define mySQL subQueries as mySQL functions. There are four restriction levels (by default 'only_admin' is used)
		$sugar_config["asolReportsMySQLinsecuritySubSelectScope"] = 1; 	// 0: Nobody can define subQueries.
																		// 1: Only admin users can define subQueries.
																		// 2: Anyone can define subQueries. 
																		// 3: A set of Roles can define subQueries.

		$sugar_config["asolReportsMySQLinsecuritySubSelectRoles"] = array ("Marketing", "Sales"); // array with set of rolenames to define scope for '3' of SubSelectScope configuration 
		
	- Customizable Font Type for exported PDF Reports. The configured value must contain the name of the TTF File without the Extension and without blank spaces (Helvetica.ttf -> Helvetica) 
		$sugar_config['asolReportsExportPdfFontTTF'] = 'ComicSansMS'; //You must also copy the .ttf file to "modules/asol_Reports/include/server/libraries/tcpdf/fonts/" folder without blank spaces in it's name.
	
	
	- Disable export buttons on Reports Dashlets. If not set, buttons will be enabled.
		$sugar_config['asolReportsDashletExportButtons'] = true; // true -> [enabled] / false -> [disabled]


	- Avoid users to execute unsaved Reports (preview) at edition page. There are four restriction levels (by default 'anyone' is used)
		$sugar_config["asolReportsPreviewExecutionScope"] = 1; 	// 0: Nobody can preview Reports.
																// 1: Only admin users can preview Reports.
																// 2: Anyone can preview Reports. 
																// 3: A set of Roles can preview Reports.

		$sugar_config["asolReportsPreviewExecutionRoles"] = array ("Marketing", "Sales"); // array with set of rolenames to define scope for '3' of PreviewExecutionScope configuration 
		
		
	- Disable Security Groups functionality. If not set, Security Groups will be enabled by default.
		$sugar_config['asolReportsSecurityGroupsDisabled'] = true; // true -> [disabled] / false -> [enabled]


	//********************************//
	//******Enterprise Features*******//
	//********************************//

	- External API reports (the api access must be configured in an array like the following):
		$sugar_config['asolReportsExternalApiConnections'] = array(
			0 => array(
				"asolReportsApiAddress" => 'http://192.168.0.X',
				"asolReportsApiUser" => null,
				"asolReportsApiPassword" => null,
				"asolReportsApiName" => "elasticSearch",
				"asolReportsApiClass" => "modules/asol_Reports/include_premium/server/api/elasticSearch.php",
				"asolReportsApiPort" => "8080",
				"asolGmtDatesUsage" => true,
				"asolDefaultApiDomainIdField" => "",
						
				"asolAllowedRoles" => array("Sales"),
				"asolForbiddenRoles" => array(),
			),
			1 => array(
				"asolReportsApiAddress" => 'https://test.zendesk.com/api/v2/',
				"asolReportsApiUser" => 'jdoe@example.com/token',
				"asolReportsApiPassword" => '6wiIBWbGkBMo1mRDMuVwkw1EPsNkeUj95PIz2akv',
				"asolReportsApiName" => "zendesk",
				"asolReportsApiClass" => "modules/asol_Reports/include_premium/server/api/zendesk.php",
				"asolReportsApiPort" => null,
				"asolGmtDatesUsage" => true,
				"asolDefaultApiDomainIdField" => "",
				
				"asolAllowedRoles" => array("Marketing"),
				"asolForbiddenRoles" => array(),
			),
		);

	- External non CRM databases reports (the databases access must be configured in an array like the following):
		$sugar_config['asolReportsAlternativeDbConnections'] = array(
	        0 => array(
                "asolReportsDbAddress" => '192.168.0.X', //Ip address
                "asolReportsDbUser" => "root", //Database access username
                "asolReportsDbPassword" => "", //Database access password
                "asolReportsDbName" => "ExternalDb_A", //Database name
                "asolReportsDbPort" => "3306", //Port
                "asolDefaultDbDomainIdField" => array ( //this array is not mandatory, may not be defined. It's used for Domains filtering
                	"fieldName" => "IdDomain",
                	"isNumeric" => true, //true [Numeric] false [String]
                	"domainRelation" => array(
                		"linkField" => "FK_Field",
                		"relatedTable" => "tableF",
                		"relatedKey" => "id",
                	),
                	"externalIdUsage" => true
                ),
                "asolSpecificTableDomainIdField" => array ( //this array is not mandatory, may not be defined. It's used for Domains filtering
                	"tableA_1" => array("fieldName" => "idDomain1", "isNumeric" => true),
                	"tableA_2" => array("fieldName" => "idDomain2", "isNumeric" => true, "showUpperLevels" => true),
                ),
                "asolAllowedTables" => array(
                	"instance" => array("tableA", "tableC"),
                	"domain" => array(),
                ),
                "asolForbiddenTables" => array(
                	"instance" => array(),
                	"domain" => array(
                		"idDomain1" => array("tableB"),
					),
                ),
	        ),
	        1 => array(
                "asolReportsDbAddress" => '192.168.0.Y',
                "asolReportsDbUser" => "root",
                "asolReportsDbPassword" => "",
                "asolReportsDbName" => "ExternalDb_B",
                "asolReportsDbPort" => "3307",
                "asolGmtDatesUsage" => true,
                "asolDefaultDbDomainIdField" => array (
                	"fieldName" => "IdDomain",
                	"isNumeric" => true,
                	"isRelated" => null
                ),
                "asolSpecificTableDomainIdField" => array(
                	"tableB_1" => array("fieldName" => "idDomain3", "isNumeric" => true),
                	"tableB_2" => array("fieldName" => "idDomain4", "isNumeric" => true),
                ),
                "asolDynamicTableDomainIdField" => array(
                	0 => array(
                		"regex" => "^HistoryData_", //HistoryData_201601, HistoryData_201602, ...
						"fieldName" => "idDomain5",
						"isNumeric" => false,
                	),
                ),
                "asolAllowedTables" => array(
                	"instance" => array(),
                	"domain" => array(),
                ),
                "asolAllowedRoles" => array("Sales", "Marketing"),
                "asolForbiddenRoles" => array(),
                "asolAvoidRelationCheck" => true,
	        ),
		);
		
	- Send Reports Data to External Applications (the applications can be configured in an array like the following):
	
		$sugar_config['asolReportsExternalApplications'] = array( //You can use the following variables: ${this} -> Returns the Report Data on CSV Format, ${bean->name} -> Returns the name of the curent Report, ${time} -> Returns a timestamp 
			0 => array(
				"label" => "App1 Name",
				"data" => array(
					"url" => "http://192.168.0.2/app1/exec",
					"parameters" => array(
						"external" => 'param1=value1&param2=${this}',
					),
					"clean" => array(
						"headers" => true,
						"quotes" => false,
					)
				)
			),
			1 => array(
				"label" => "App2 Name",
				"data" => array(
					"url" => "http://10.0.0.2/app1/exec",
					"parameters" => array(
						"external" => 'param3=value3&param4=value4&param5=${time}',
					),
					"clean" => array(
						"headers" => true,
						"quotes" => true,
					)
				)
			)
		);
		
		$sugar_config['asolReportsExternalApplicationFixedParams'] = array( //Fixed set of paramaters for your custom applications.
			"reportData" => array(
				'value' => '${this}',
				'description' => 'LBL_REPORT_APP_FIXED_DATA_DESCRIPTION',
			),
			"reportName" => array(
				'value' => '${bean->name}',
				'description' => 'LBL_REPORT_APP_FIXED_NAME_DESCRIPTION',
			),
			"reportTime" => array(
				'value' => '${time}',
				'description' => 'LBL_REPORT_APP_FIXED_TIME_DESCRIPTION',
			)
		);
		
	- AlineasolReport Fields Pagination Entries per Page. If not is set, user report's configuration value will be used.
	
		$sugar_config['asolReportsFieldsPaginationEntries'] = 10;
		
		
	- Set of non-visible external database fields when configuring Report. Defined at table level. Defined fields must be written as is displayed on database field column.
		
		$sugar_config['asolReportsExernalDbNonVisibleFields'] = array(
			"DBName" => array(
				"User" => array("password")
			)
		);
		
		
	- Allowed PHP Funcions you can use on: ExternalApp Parameters, Button Url Parameters & PHP PostProcess Functions. Admin Users has no restrictions to use any PHP function.
		
		$sugar_config['asolReportsPhpAllowedFunctions'] = array('time', 'date', 'mktime', 'implode', 'explode', 'md5', 'strlen', 'strpos', 'substr', 'str_replace'); //You must set your PHP code between "[php] [/php]" tags with a simple return statement). Example: [php] return date("d-m-Y 23:59:59", time()+7*24*3600); [/php]
		
		
	- Set of PHP files with custom functions to be used at Reports. Take into account that if you want to restricted users to manage these functions, add it to the allowed PHP Functions array.
		
		$sugar_config['asolReportsPhpLibraryFiles'] = array(
			"modules/asol_Reports/include/myReportsFunctions1.php",
			"modules/asol_Reports/include/myReportsFunctions2.php",
		);
		
	
	- AlineasolReport Max number of links allowed at Report edition. If not is set, 4 will be the default value
	
		$sugar_config['asolReportsMaxLinksAllowed'] = 3; // Range available [1-5]
		
	- Avoid users to jump through relations for more than one link. There are three restriction levels (by default 'anyone' is used)
		$sugar_config["asolReportsMultiLinksScope"] = 1; 	// 0: Nobody can get multiple links.
															// 1: Only admin can get multiple links.
															// 2: Anyone can get multiple links. 
		
	- Force usage of breadCrumb navigation for EditView related fields. Tree selector by default on Enterprise Edition.
		$sugar_config["asolReportsBreadCrumbNavigation"] = true; // true -> [breadcrumb] / false -> [tree]
		
		
	- Read-only mode got any user on SugarCRM instance (including administrators). This feature is disabled by default.
		$sugar_config["asolReportsReadOnlyMode"] = true; // true -> [enabled] / false -> [disabled]
		
		
	- Support for report's remote execution through web services. You can synchronize with configured CRM instance through "Cloud Synchronization" link at Administration Panel
		
		$sugar_config['asolReportsWebServiceExecution'] = array(
			"wsUrl" => "http://www.example.com/crm",
			"authentication" => array(
				"user_name" => "admin",
				"password" => "admin"
			),
			"siteLogin" => "username:password",
			"domainAsExternalId" => true
		);
		
	- Support for autokill long queries. You must provide max execution time in seconds. It's recomemded to configure a specific reports connnections with a specific user for Reporting. This task will be executed as part of "Clean Up Scheduler".
	
		$sugar_config['asolReportsKillActiveLongQueriesTTL'] = 900; //15 minutes
		
		
	- Support for auto-compress with zip the scheduled report's attachments for those files that exceed the specified limit in MB.
	
		$sugar_config['asolReportsScheduledAttachmentZipLimit'] = 3; //3MB
		
		
	- Support for predefined FTP configurations for scheduled Reports.
	
		$sugar_config['asolReportsFtpDirectories'] = array(
			0 => array(
				'label' => 'Some FTP 1',
				'data' => array(
					'host' => '192.168.0.8',
					'port' => '22',
					'secure' => false,
					'username' => 'ftpuser',
					'password' => 'ftppass',
					'path' => '/home/ftpuser/tmp/'
				),
			),
			1 => array(
				'label' => 'Some SFTP 2',
				'data' => array(
					'host' => '192.168.0.10',
					'port' => '2222',
					'secure' => true,
					'username' => 'sftpuser',
					'password' => 'sftppass',
					'path' => '/home/sftp_exchange/'
				),
			),
		);
		
		
	- Support for predefined TargetList configurations for scheduled Reports (only for native Db). You must add the "id" field to the report in order to add relations for udated/created target list. Supported modules: Prospects, Contacts, Users, Accounts
	
		$sugar_config['asolReportsTlConfigurations'] = array(
			0 => array(
				'label' => 'Some TL 1',
				'data' => array(
					'mode' => 'create',
					'id' => null',
					'name' => 'TL Name 1', //name parameters supports PHP for dynamic TL name.
				),
			),
			1 => array(
				'label' => 'Some TL 2',
				'data' => array(
					'mode' => 'update',
					'id' => '1',
					'name' => null,
				),
			),
		);
		
	- Support for use "relationships" table to manage report relationships instead of CRM native methods.
	
		$sugar_config['asolReportsRelationshipsTableUsage'] = true; //if false, CRM native methods are used instead
		
	
		
		
//**************************************//
//******Config Override Features********//
//**************************************//



//********************************//
//*****SQL Function Support*******//
//********************************//

On the right of the list of functions of each field, there is a button that launches a modal popup 
where you can edit the value to be displayed on the current field using SQL functions.


//***Fields Referencing***//

You can use report variables for fields and related fields added to the current report:

${this} //References the value of the current field with or without funcion

${ModuleName->DbLinkField->RelatedDbField} //References a related field value. e.g ${Accounts->account_id_c->name} 
${ModuleName_Cstm->DbLinkField->RelatedDbField_c} //References a related cuatom field value. e.g ${Accounts_Cstm->account_id_c->account_type_c} 
${bean->DbField} //References a field of the current report module. e.g ${bean->name} 
${bean_cstm->DbField} //References a custom field of the current report module. e.g ${bean_cstm->account_type_c} 

%{fieldRef} //Gets the sql value associated to the named reference (you can use # instead of % symbol). If the reference is to hersefl return te corret value like ${this}  


*If you want to get html link to relate field you can get this code as example (at module Accounts):
	CONCAT("<a target=_blank href=index.php?module=Users&action=DetailView&record=", ${this}, ">", ${Users->assigned_user_id->user_name}, "</a>") //for link assigned_user_id field
	CONCAT("<a target=_blank href=index.php?module=", ${bean->parent_type} , "&action=DetailView&record=", ${this}, ">", ${bean->parent_type}, "</a>")  //for flexRelate parent_id field

**Example of getting the third link in a report. Add this code in the field MySQL ID of a related module being 'OPP1' the related module and 'USER1' the third linked module.
	SELECT USER1.user_name FROM opportunities OPP1 LEFT JOIN users USER1 ON (OPP1.assigned_user_id=USER1.id) WHERE OPP1.id=${this}



//***Filters Referencing***//

You can reference existing Report Filters to get more consistent data on your SQL queries:

%[filterRef(queryField)] //Gets the filter query associated to the named reference (you can use # instead of % symbol).


//********************************//
//*****SQL Function Support*******//
//********************************//



//********************************//
//*****PHP Function Support*******//
//********************************//

On the right of the list of functions of each field, there is a button that launches a modal popup 
where you can edit the value to be displayed on the current field using PHP functions.

You can use report variables for fields added to the current report:

${this} //References the value of the current field
%{fieldRef} //Gets the cell value associated to the named reference (you can use # instead of % symbol).


* Be sure to put your PHP function between these tags: [php] [/php]
** The displayed value on the current cell will be the returned value on your code (a return statement is required).


//********************************//
//*****PHP Function Support*******//
//********************************//


//********************************//
//*****Map Charts Management******//
//********************************//

Create and add new maps to Reports:

First of all, we need a topoJSON file of the desired country/region(s).
    
- Creating a topoJSON file:
	
	1.- At webpage https://gadm.org/download_country_v3.html, we can find all the geographical/administrative maps of the world. At that point we must select a country and download the Shapefile.
    2.- Within the downloaded zip file, we just need to use of the files with .shp & .dbf extensions. Take into account that may be several files with those extensions (the ending number of these files corresponds to different administrative levels).
    3.- You should select the desired administrative areas that you want to represent, drop and import them into this webpage: http://mapshaper.org (at this webpage, we are allowed to modify and export the uploaded data to a topoJSON file).
		3.1- At this point, it's really important to compress the map to generate a lighter topoJSON files by pressing on "simplify" button: click on apply button to set the level of detail of the map by modifying "settings" slider.
		3.2- Attention! we need to do the previous step for all of the levels of the uploaded map: we can change between them at the top selection.
		3.3- Finally, we should click at export button and select topoJSON as file format.
	4.- Congratulations! now we have a fully functional topJSON file for use on AlineaSol Reports! 
		4.1- You should be interesting to change the name of this file, in order that this filename will be presented as the country at the chart type selection.
		4.2- In addition to the previous step, you should be also interested to change the administrative levels displayed labels by modifying them within topoJSON file (p.e. at USA topoJSON file, replace "gadm36_USA_1" by "State").
	5.- The final step to include this new topoJSON file into AlineaSol Reports module, is to copy that file within "modules/asol_Reports/include_premium/client/resources/topoJsonMaps/" folder.
		
- Adding a customized projection (only for experienced developers):

	1.- We must find an specific projection (a javascript sourcecode) for our maps by searching on the web, using the existing ones at D3 library or creating it by yourself (more about projections https://github.com/d3/d3-geo-projection )
		1.1- By default, reports generates a projection based on Mercator, but we could use other functions to represent other projections or group far regions within the same country (islands, colonies...).
	2.- At this example, we are adding the "AlbersUsa" projection for USA country:
		2.1- We need to add a property on the JSON called 'projection'. The value of this property should be a JSON "stringified" function that returns the projection object: 
			"projection":"d3.geo.albersUsa();",
		2.2- Example with the declaration of conicConformalSpain function:
			"projection":"(function(){!function(){d3.geo.conicConformalSpain=function(){function n(n){var o=n[0],i=n[1];return t=null,e(o,i),t||r(o,i),t}var t,e,r,o=d3.geo.conicConformal().center([2,37.5]),i=d3.geo.conicConformal().center([-9.6,26.4]),a={poin...lSpain();})()",
    
//********************************//
//*****Map Charts Management******//
//********************************//


//***********************************//
//*****User Input User Options*******//
//***********************************//

You can choose between two dropdown models:

· Simple Model: This model has the posible values separated by commas (internal and display values will be exactly the same).
	
	optionA,optionB,optionC

· Advanced Model: This model has the posible values separated by commas and each of this values contains internal and display values separated by the equals character (=). 

	optionA=OptA,optionB=OptB,optionC=OptC
	

//***********************************//
//*****User Input User Options*******//
//***********************************//


//*****************************************************//
//***** Module language labels for traslations ********//
//*************** Enterprise Features *****************//
//*****************************************************//

	-	Support for use "module language labels" on Fields and filters for alias/names and translations of the multilingual management. 
		Could be an alternative to "Multilingual Management" for define the translations or a help to reuse multiples labels of a module. 

//*****************************************************//
//***** Module language labels for traslations ********//
//*************** Enterprise Features *****************//
//*****************************************************//


//***********************************//
//***Generated Report CSS Classes****//
//***********************************//

You can customize report results in DetailView with following classes:

	a) Data Tables classes:
	
	Headers:	data_header data_header_<dataType>
	Values:		data_value data_value_<dataType>
	Both:		data_cell data_cell_<dataType>
	
	
	b) Subtotals classes:
	
	Headers:	subtotal_header subtotal_header_<dataType>
	Values:		subtotal_value subtotal_value_<dataType>
	Both:		subtotal_cell subtotal_cell_<dataType>
	
	
	c) Totals classes:
	
	Headers:	total_header total_header_<dataType>
	Values:		total_value total_value_<dataType>
	Both:		total_cell total_cell_<dataType>
	
	
	d) Common classes (Data Tables, Subtotals and Totals):
	
	Headers:	report_header report_header_<dataType>
	Values:		report_value report_value_<dataType>
	Both:		report_cell report_cell_<dataType>


//***********************************//
//***Generated Report CSS Classes****//
//***********************************//



//***************************************//
//***Send Report to Popup Application****//
//***************************************//

This is an example application where you can read parameters sent by some report & close the application popup within the own application:


<?php

echo '
<script type="text/javascript">
		
	var appData = parent.getReportDataPopUpDialog();
		
	document.open();
	document.write("Received "+appData.length+" elements from Reports!<br/>");
	document.write("<input type=\'button\' value=\'Close Me\' onClick=\'parent.closeReportPopUpDialog();\'>");
	document.close();
		
</script>';

?>


//***************************************//
//***Send Report to Popup Application****//
//***************************************//



//**************************************//
//*************Known Issues*************//
//**************************************//

- All versions: Exporting to PDF may take a long time to be generated for big reports (more than 100 entries).

- All versions: HTML 5 Charts do not work for PHP version > 5.4.40 due to SugarCRM has a bug in the "include/SugarCharts/JsChart.js" file. You need to comment out the return statement of "processXML" function and replace it by "return $content;".

- All versions: Strange behaviours when you try to hide an area chart.

- In version 2.0.0 and up: when searching a report in report dashlets and then saving a selected one, does not refresh automatically the dashlet. You must refresh it manually.

- In version 7.5.0: you must make a "repair & rebuild" after installing Reports in order to get the correct button links at ListView.  

- In version 7.5.0: when creating a new report, you must repair & rebuild your instance to update your dashlets report list.

- In version 7.5.0: HTML5 & Flash charts are not supported.

- In version 7.5.0: Dashlets issue on Mozilla Firefox browser: when refreshing Sugar Report Dashlet, this one is no longer editable until you refresh the entire webpage.

//**************************************//
//*************Known Issues*************//
//**************************************//