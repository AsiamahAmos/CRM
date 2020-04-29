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


require_once('include/MVC/View/views/view.detail.php');
//ini_set("display_errors",1);
class ContactsViewDetail extends ViewDetail
{
 	/**
 	 * @see SugarView::display()
	 *
 	 * We are overridding the display method to manipulate the portal information.
 	 * If portal is not enabled then don't show the portal fields.
 	 */

  

  public function hidden_data(){
  global $sugar_config; 
  global $current_user;
  global $mod_strings;
  global $app_strings;
   //its was used for the customer 360 view
  $id = $_REQUEST["id"];
  $name = $_REQUEST["nm"];
  $userid = $current_user->id;

  $hidden_data = <<<EOT

        <input id="id2" type="hidden" readonly="readonly" value="$id"/>
        <input id="name" type="hidden" readonly="readonly" value="$name"/>
        <input id="current_user" type="hidden" readonly="readonly" value="$userid"/>
EOT;

   print($hidden_data);
  }


  public function customer360_form_view(){

  if($_REQUEST["customer360"]=="true"){//if its customer 360 mode before u echo this.

  $customer360_form_view = <<<EOT

  <script>
  $(".detail-view").hide();//hide the original detail view when you are in customer360 mode.:::
  </script>

 <div id="customer_img" style="height:200px;width:150px;background:#ddd;margin-left:0px"></div>

  <ul class="noBullet" id="subpanel_list">
    <li class="noBullet useFooTable" id="whole_subpanel_hr_ma_help_contacts_1">        
  <div class="panel panel-default sub-panel">
     <div class="panel-heading panel-heading-collapse">
         <a id="subpanel_title_hr_ma_help_contacts_0" class="collapsed" role="button" data-toggle="collapse" href="#subpanel_hr_ma_help_contacts_0" aria-expanded="false" onclick="showSubPanel("hr_ma_help_contacts_0"); toggleSubpanelCookie("hr_ma_help_contacts_0");">
                    <div class="col-xs-10 col-sm-11 col-md-11">
                     <div>
        <span class="suitepicon suitepicon-module-hr-ma-help subpanel-icon"></span>
                         BASIC INFORMATION.
                   </div>
                 </div>
                </a>
            </div>
       <div class="panel-body panel-collapse collapse" id="subpanel_hr_ma_help_contacts_0">
             <div style="background:#ccc" class="tab-content">
                 <div id="list_subpanel_hr_ma_help_contacts_0">
                            
                    </div>
                  </div>
            </div>
        </div>
    </li>





<li class="noBullet useFooTable" id="whole_subpanel_hr_ma_help_contacts_1">        
    <div class="panel panel-default sub-panel">
         <div class="panel-heading panel-heading-collapse">
         <a id="subpanel_title_hr_ma_help_contacts_2" class="collapsed" role="button" data-toggle="collapse" href="#subpanel_hr_ma_help_contacts_2" aria-expanded="false" onclick="showSubPanel("hr_ma_help_contacts_2"); toggleSubpanelCookie("hr_ma_help_contacts_2");">
                    <div class="col-xs-10 col-sm-11 col-md-11">
                     <div>
        <span class="suitepicon suitepicon-module-hr-ma-help subpanel-icon"></span>
                         BALANCE SUMMARY
                   </div>
                 </div>
                </a>
            </div>
       <div class="panel-body panel-collapse collapse" id="subpanel_hr_ma_help_contacts_2">
             <div style="background:#ccc" class="tab-content">
                 <div id="list_subpanel_hr_ma_help_contacts_2">
                           
                    </div>
                  </div>
            </div>
        </div>
    </li>

<li class="noBullet useFooTable" id="whole_subpanel_hr_ma_help_contacts_1">        
    <div class="panel panel-default sub-panel">
         <div class="panel-heading panel-heading-collapse">
         <a id="subpanel_title_hr_ma_help_contacts_5" class="collapsed" role="button" data-toggle="collapse" href="#subpanel_hr_ma_help_contacts_5" aria-expanded="false" onclick="showSubPanel("hr_ma_help_contacts_5"); toggleSubpanelCookie("hr_ma_help_contacts_5");">
                    <div class="col-xs-10 col-sm-11 col-md-11">
                     <div>
        <span class="suitepicon suitepicon-module-hr-ma-help subpanel-icon"></span>
                         ACCOUNTS
                   </div>
                 </div>
                </a>
            </div>
       <div style="background:#ccc" class="panel-body panel-collapse collapse" id="subpanel_hr_ma_help_contacts_5">
             <div style="background:#ccc" class="tab-content">
                 <div id="list_subpanel_hr_ma_help_contacts_5">
                           
                    </div>
                  </div>
            </div>
        </div>
    </li>

<li class="noBullet useFooTable" id="whole_subpanel_hr_ma_help_contacts_1">        
    <div class="panel panel-default sub-panel">
         <div class="panel-heading panel-heading-collapse">
         <a id="subpanel_title_hr_ma_help_contacts_5" class="collapsed" role="button" data-toggle="collapse" href="#subpanel_hr_ma_help_contacts_6" aria-expanded="false" onclick="showSubPanel("hr_ma_help_contacts_6"); toggleSubpanelCookie("hr_ma_help_contacts_6");">
                    <div class="col-xs-10 col-sm-11 col-md-11">
                     <div>
        <span class="suitepicon suitepicon-module-hr-ma-help subpanel-icon"></span>
                         RECENT CONTACTS
                   </div>
                 </div>
                </a>
            </div>
       <div style="background:#ccc" class="panel-body panel-collapse collapse" id="subpanel_hr_ma_help_contacts_6">
             <div style="background:#ccc" class="tab-content">
                 <div id="list_subpanel_hr_ma_help_contacts_6">
                           
                    </div>
                  </div>
            </div>
        </div>
    </li>

 <li class="noBullet useFooTable" id="whole_subpanel_hr_ma_help_contacts_1">        
  <div class="panel panel-default sub-panel">
     <div class="panel-heading panel-heading-collapse">
         <a id="subpanel_title_hr_ma_help_contacts_3" class="collapsed" role="button" data-toggle="collapse" href="#subpanel_hr_ma_help_contacts_3" aria-expanded="false" onclick="showSubPanel("hr_ma_help_contacts_3"); toggleSubpanelCookie("hr_ma_help_contacts_3");">
                    <div class="col-xs-10 col-sm-11 col-md-11">
                     <div>
        <span class="suitepicon suitepicon-module-hr-ma-help subpanel-icon"></span>
                         SERVICES
                   </div>
                 </div>
                </a>
            </div>
       <div class="panel-body panel-collapse collapse" id="subpanel_hr_ma_help_contacts_3">
             <div style="background:#ccc" class="tab-content">
                 <div id="list_subpanel_hr_ma_help_contacts_3">
                           
                    </div>
                  </div>
            </div>
        </div>
    </li>

<li class="noBullet useFooTable" id="whole_subpanel_hr_ma_help_contacts_1">        
  <div class="panel panel-default sub-panel">
     <div class="panel-heading panel-heading-collapse">
         <a id="subpanel_title_hr_ma_help_contacts_7" class="collapsed" role="button" data-toggle="collapse" href="#subpanel_hr_ma_help_contacts_7" aria-expanded="false" onclick="showSubPanel("hr_ma_help_contacts_7"); toggleSubpanelCookie("hr_ma_help_contacts_7");">
                    <div class="col-xs-10 col-sm-11 col-md-11">
                     <div>
        <span class="suitepicon suitepicon-module-hr-ma-help subpanel-icon"></span>
                        PRODUCT SERVICES
                   </div>
                 </div>
                </a>
            </div>
       <div class="panel-body panel-collapse collapse" id="subpanel_hr_ma_help_contacts_7">
             <div style="background:#ccc" class="tab-content">
                 <div id="list_subpanel_hr_ma_help_contacts_7">
                           
                    </div>
                  </div>
            </div>
        </div>
    </li>


    <li class="noBullet useFooTable" id="whole_subpanel_hr_ma_help_contacts_1">        
  <div class="panel panel-default sub-panel">
     <div class="panel-heading panel-heading-collapse">
         <a id="subpanel_title_hr_ma_help_contacts_4" class="collapsed" role="button" data-toggle="collapse" href="#subpanel_hr_ma_help_contacts_4" aria-expanded="false" onclick="showSubPanel("hr_ma_help_contacts_4"); toggleSubpanelCookie("hr_ma_help_contacts_4");">
                    <div class="col-xs-10 col-sm-11 col-md-11">
                     <div>
        <span class="suitepicon suitepicon-module-hr-ma-help subpanel-icon"></span>
                         CLIENT PREFERENCES
                   </div>
                 </div>
                </a>
            </div>
       <div class="panel-body panel-collapse collapse" id="subpanel_hr_ma_help_contacts_4">
             <div style="background:#ccc" class="tab-content">
                 <div id="list_subpanel_hr_ma_help_contacts_4">
                           
                    </div>
                  </div>
               </div>
           </div>
       </li>

  </ul>
  
EOT;

print($customer360_form_view);
      }//End////if its customer 360 mode before u echo this.

  }




 public function customer360_modals(){

 $customer360_modals = <<<EOT

<div class="modal fade" id="customer360" role="dialog">
      <div class="modal-dialog modal-md"><div class="modal-content">
         <div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 id="head" class="modal-title">Enter  Customer Details To Search</h4>
            </div>
        <div id="customer_tab" class="modal-body">
         
         <div id="move_for_load">
          <input name="customerID" id="customerID" type="text" style="width:400px" />&nbsp;&nbsp;<button id="fetch_360_data" type="button" class="btn btn-success">Search</button>
            
           </div>
           </div>
         <div class="modal-footer">
          </div>
         </div>
       </div>
     </div>


 <div class="modal fade" id="ajaz_load" role="dialog">
      <div class="modal-dialog modal-md"><div class="modal-content">
          
         <div id="ajaz_load_body" class="modal-body">
          
             </div>
          
         </div>
       </div>
     </div>


<div class="modal fade" id="customer360_fetch" role="dialog">
      <div class="modal-dialog modal-lg"><div class="modal-content">
         <div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 id="head" class="modal-title">Customer 360 List View</h4>
            </div>
        <div style="overflow:auto;height:500px" id="customer_fetch_tab" class="modal-body">

         
          </div>
         <div class="modal-footer">
          </div>
         </div>
       </div>
     </div>
EOT;

echo ($customer360_modals);
  }


  public function sms_modals(){
/////This code below is for sms modal popup/////
 $sms_modals = <<<EOT

 <div class="modal fade" id="load" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
           
     <div class="modal-body"><b>&nbsp;&nbsp;&nbsp;Please Wait . . . <img src="../crm/themes/suiteP/images/loading.gif" style="width:80px"/></b>

       </div>

    </div>
  </div>
</div>


<div class="modal fade" id="success" role="dialog">
           <div class="modal-dialog modal-sm" role="document">
             <div class="modal-content">
                 <div class="modal-header" style="display: block;">
                      <button type="button" class="close btn-cancel" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                     <h4 class="modal-title"></h4></div>
                <div class="modal-body">SMS Sent Successfully</div>
           <div class="modal-footer" style="display: block;"><button class="button btn-ok" type="button" data-dismiss="modal">Ok</button> 
             </div>
          </div>
     </div> 
</div>


  <div class="modal fade" id="empModal" role="dialog">
     <div class="modal-dialog modal-lg"><div class="modal-content">
         <div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Send SMS Form</h4>
         </div>
         <div class="modal-body">
            <label for="receipient">Receipient:&nbsp;&nbsp;</label>
             <input readonly="readonly" id="receipt" type="text"><br><br/>
             <label for="message">Message:&nbsp;&nbsp;</label>
             <textarea id="msg" style="height:200px"></textarea>
            </div>
         <div class="modal-footer"><button type="button" onclick="send_sms();" class="btn btn-success" data-dismiss="modal">Send SMS <span class="glyphicon glyphicon-send"></span></button>
         </div>
        </div>
      </div>
    </div>;;;
EOT;


   echo ($sms_modals); 
    ////End of sms popups///////////////////////////
  }



	public function display(){
	
	//global $bean; //$bean refers to the table and it fields      
	global $app_list_strings;

		$aop_portal_enabled = !empty($sugar_config['aop']['enable_portal']) && !empty($sugar_config['aop']['enable_aop']);

		$this->ss->assign("AOP_PORTAL_ENABLED", $aop_portal_enabled);
        
		require_once('modules/AOS_PDF_Templates/formLetter.php');
		formLetter::DVPopupHtml('Contacts');

		$admin = new Administration();
		$admin->retrieveSettings();
		if(isset($admin->settings['portal_on']) && $admin->settings['portal_on']) {
			$this->ss->assign("PORTAL_ENABLED", true);
		}
		
		parent::display();

         // foreach ($this->bean->fetched_row  as $key => $value) {
         // 	# code...
                      
         //  echo '<pre>'. $key .'         =>             ' .$value. '</pre>';//"<pre>"; var_dump(get_object_vars($contact)); //"<pre>";var_dump($app_list_strings['moduleList']);

         // }
		//self::hidden_data();
    $this->hidden_data();
    $this->customer360_form_view();
    $this->customer360_modals();
    $this->sms_modals();

	}
}

