{*
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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
 */
*}

<!-- the search modal popup ---> 

<div class="modal fade" id="bulk_sms" role="dialog">
		 <div class="modal-dialog modal-lg"><div class="modal-content">
		     <div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Send Bulk SMS Form</h4>
		     </div>
			   <div class="modal-body">
			      <label for="receipient">Receipients:&nbsp;&nbsp;</label>
			       <input readonly="readonly" style="width:500px" id="receipt" type="text"><br><br/>
			       <label for="message">Message:&nbsp;&nbsp;&nbsp;</label>
			       <textarea id="msg" style="height:200px"></textarea>
		        </div>
		     <div class="modal-footer"><button type="button" onclick="send_bulk_sms();" class="btn btn-success" data-dismiss="modal">Send SMS <span class="glyphicon glyphicon-send"></span></button>
		     </div>
		    </div>
		  </div>
		</div>



<div class="modal fade" id="sea" role="dialog">
		  <div class="modal-dialog modal-lg"><div class="modal-content">
		      <div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Search Questions Form</h4>
		        </div>
		 	   <div class="modal-body">
		 	   <a href="index.php?action=index&module=Contacts&searchFormTab=advanced_search&query=true&favorites_only_advanced=checked">My favorite contacts</a>
		 	   <br><br/>
		 	   <a href="javascript:birthday();">Contacts with birthday in this month</a>
		 	   <br><br/>
                <a href="javascript:no_sms();">Contacts with no SMS service</a>
		 	   <br><br/>
                <a href="index.php?action=index&module=Contacts&searchFormTab=advanced_search&query=true&segment_c_advanced=personal">Contacts with segment personal banking</a>
		 	   <br><br/>
                <a href="#">Contacts with high investment</a>
		 	   <br><br/>
		         </div>
		      <div class="modal-footer"><button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
		      </div>
		     </div>
		   </div>
     </div>




<div class="modal fade" id="sear" role="dialog">
		  <div class="modal-dialog modal-md"><div class="modal-content">
		      <div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 id="head" class="modal-title"></h4>
		        </div>
		 	   <div id="tabb" class="modal-body">
		 	
		         </div>
		      <div class="modal-footer"><button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
		      </div>
		     </div>
		   </div>
		 </div>

<div class="modal fade" id="customer360" role="dialog">
		  <div  class="modal-dialog modal-md"><div class="modal-content">
		     <div style="backgroun: #a5e8d6" class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 id="head" class="modal-title">Enter  Customer Details To Search</h4>
		        </div>
		 	  <div style="backgroun: #a5e8d6" id="customer_tab" class="modal-body">
               
               
		 	   <div id="move_for_load">
		 	   	<input name="customerID" id="customerID" type="text" style="width:400px" />&nbsp;&nbsp;<button id="fetch_360_data" type="button" class="btn btn-success">Search</button>
		 	   	  
		 	     </div>
		       </div>
		     <div style="backgroun: #a5e8d6" class="modal-footer">
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



<div class="modal fade"  id="customer360_fetch" role="dialog">
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




<div id="searchDialog" class="modal fade modal-search" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{$APP.LBL_FILTER_HEADER_TITLE}</h4>
                <!-- Nav tabs -->
                <h5 class="searchTabHeader mobileOnly basic active">{$APP.LBL_QUICK_FILTER}</h5>
                <h5 class="searchTabHeader mobileOnly advanced">{$APP.LBL_ADVANCED_SEARCH}</h5>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="searchTabHandler basic active"><a href="javascript:void(0)"
                                                                 onclick="listViewSearchIcon.toggleSearchDialog('basic'); return false;"
                                                                 aria-controls="searchList" role="tab"
                                                                 data-toggle="tab">{$APP.LBL_QUICK_FILTER}</a></li>
                    <li class="searchTabHandler advanced"><a href="javascript:void(0)"
                                                             onclick="listViewSearchIcon.toggleSearchDialog('advanced'); return false;"
                                                             aria-controls="searchList" role="tab"
                                                             data-toggle="tab">{$APP.LBL_ADVANCED_SEARCH}</a></li>
                </ul>
            </div>
            <div class="modal-body" id="searchList">