<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/

/*********************************************************************************

 * Description: This file is used to override the default Meta-data DetailView behavior
 * to provide customization specific to the Campaigns module.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/


require_once('include/MVC/View/views/view.detail.php');

class OpportunitiesViewDetail extends ViewDetail {
    
	private $sql = "SELECT opportunities_cstm.aos_products_id_c AS product_id, opportunities.id,opportunities.sales_stage AS opp_status, opportunities_contacts.contact_id FROM opportunities_cstm,opportunities,opportunities_contacts  WHERE  opportunities_cstm.id_c = opportunities.id AND opportunities.id = opportunities_contacts.opportunity_id";
	//public $sql = "SELECT * FROM opportunities";
	private $query = "INSERT INTO contacts_aos_products_2_c(id,deleted,date_modified,contacts_aos_products_2contacts_ida,contacts_aos_products_2aos_products_idb) ";
	
	private $stmt = "SELECT * FROM contacts_aos_products_2_c WHERE ";
	
 	function __construct(){
 		parent::__construct();
 	}

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function OpportunitiesViewDetail(){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }


    function closed_won(){
	global $db;
	global $current_user;
   // echo ($db) ? "connected" : "Not connected";
	$results = $db->query($this->sql);
	while($row = $db->fetchByAssoc($results)){
		$contact_id = $row["contact_id"];
		$product_id = $row["product_id"];
	    if($row["opp_status"]=="Closed Won" AND !empty($product_id) AND !empty($contact_id) ){
	        
	        $id = "prod-cont-".rand(0,1000000000)."-".rand(0,1000000000);
	        $date = date("Y-m-d H:i:s");
			$rows[]= $row; 
			   
	     $res =  $db->query($this->stmt."contacts_aos_products_2contacts_ida = '$contact_id' AND contacts_aos_products_2aos_products_idb = '$product_id'");
		 $record = $db->fetchByAssoc($res);///check if the data already exist in table.

			   if($record < 1){///check if the data already exist in table.
	     $db->query($this->query."VALUES('$id','0','$date','$contact_id','$product_id')");
			           }
		      }
	  }
	  //var_dump($record);
	  //var_dump($rows);

	}
	
	
 	function display() {

	    $currency = new Currency();
	    if(isset($this->bean->currency_id) && !empty($this->bean->currency_id))
	    {
	    	$currency->retrieve($this->bean->currency_id);
	    	if( $currency->deleted != 1){
	    		$this->ss->assign('CURRENCY', $currency->iso4217 .' '.$currency->symbol);
	    	}else {
	    	    $this->ss->assign('CURRENCY', $currency->getDefaultISO4217() .' '.$currency->getDefaultCurrencySymbol());
	    	}
	    }else{
	    	$this->ss->assign('CURRENCY', $currency->getDefaultISO4217() .' '.$currency->getDefaultCurrencySymbol());
	    }
        $this->closed_won();
 		parent::display();
 	}
}
