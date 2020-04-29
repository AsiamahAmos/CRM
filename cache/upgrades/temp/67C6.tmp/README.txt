After install, uninstall or repair Alineasol for this module, make a "Repair JS Files".

//**************************************//
//******Config Override Features********//
//**************************************//

Activation of Features just configuring it at "config_override.php" file of your SugarCRM instance (just add the defined lines to this file):


	//********************************//
	//*******Community Features*******//
	//********************************//
	
	- Currency symbol position and cents display:
	
		$sugar_config['asolCommonCurrencyConfig'] = array(
			'EUR' => array(
				'symbol' => '€',
				'name' => 'Euro',
				'position' => 'right',
				'hasCents' => true,
			),
			'GBP' => array(
				'symbol' => '£',
				'name' => 'Pounds',
				'position' => 'left',
				'hasCents' => true,
			),
			'USD' => array(
				'symbol' => '$',
				'name' => 'US Dollars',
				'position' => 'left',
				'hasCents' => true,
			),
		);
		
		$sugar_config['asolCommonCurrencyUsage'] = array(
			'instance' => 'EUR',
			'domains' => array(
				'1' => 'GBP', //DomainA
				'2' => 'USD', //DomainB
			)
		);

	- Disable web service button editing. There are four restriction levels (by default 'only_admin' is used)
		$sugar_config["asolCommonWebServiceButtonEdit"] = 2; // 0: Nobody can use.
															 // 1: Only admin users.
															 // 2: Anyone. 
															 // 3: Set by Roles.

		$sugar_config["asolCommonWebServiceButtonEditRoles"] = array("marketing", "sales"); // array with set of roles names to define scope for '3' of asolBlueThemeBackButtonRoles.
							