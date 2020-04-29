<?php
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

//ini_set("display_errors",1);
//echo (file_exists('view.list.php'))? 'Yes' :'No';


require_once('include/MVC/View/views/view.list.php');


//die;
class HomeViewList extends ViewList{
 	function ActivitiesViewList(){
 		parent::__construct();
 		
     }
     
     public function contacts_count(){
     global $current_user;
     global $db;
  
     $stmt = $db->query("SELECT COUNT(*) FROM contacts WHERE assigned_user_id = '$current_user->id'");
     $res = $db->fetchByAssoc($stmt);
     $data =  $res["COUNT(*)"];
       // foreach ($stmt as $key => $value) {
       //   # code...
       //   echo "<pre><td>".$this->seed;echo "</td></pre>";
       //   };
     $sql = "SELECT * FROM accounts";
     $res = $db->query($sql);

     foreach ($res as $key => $value) {
     $account_id = $value['id'];
     $segment_name = $value['name'];
     if(stripos($account_id, "b") === FALSE){#if there is 'b' in the id, donot add it 
     $sql = "SELECT COUNT(*) FROM accounts_contacts WHERE account_id = '$account_id'";
     $stmt1 = $db->query($sql);
     $ress = $db->fetchByAssoc($stmt1);
     $total[]  = $ress["COUNT(*)"];
     $customer_count = $ress["COUNT(*)"];

     $arr .= "['".$segment_name."', 'http://".$_SERVER['SERVER_ADDR']."/crm/index.php?module=AOS_Products&action=DetailView&record=".$account_id."',    ".$customer_count."],";
       }
       # code...
     }

   $pie_chart = "<html>
   <head>
    <script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script> 
    <script type='text/javascript' src='charts_loader.js'></script>
    <script type='text/javascript'>
      google.charts.load('current', {packages:['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Link', 'Hours per Day'],
          ".$arr."
          
        ]);

//////////////Get the 3  data items in array to view /////////////////////
        var view = new google.visualization.DataView(data); 
            view.setColumns([0, 2]);
////////////// var view ////////////////////////////////////////////

        var options = {
          title: 'Number Of Customers Per Product', 
          is3D: true,
          chartArea: {width: 400, height: 400},
        };
 
        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(view, options);

///////Add your selection handler(For Links) (Clickable)//////////////////////////////////////////////////////////
        google.visualization.events.addListener(chart, 'select', selectHandler); 

        function selectHandler(e)     { 

        if (confirm('Do you want to open '+data.getValue(chart.getSelection()[0].row, 0))==true){ 
        
            window.open(data.getValue(chart.getSelection()[0].row, 1));

           }else{ 
            return false; 
            
            }

      }
//////////////End Of Links /////////////////////////////////////////////////////

      }
    </script>
  </head>
  <body>
    <div id='piechart_3d' style='width: px; height: px;'></div>
  </body>
</html>";

  
  $contacts_view_dashlet_modal ='<div class="modal fade" id="customer_details" data-backdrop="true" role="dialog">
  <div class="modal-dialog modal-lg" role="document"><div class="modal-content">
     <div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 id="head" class="modal-title">More Customer Details</h4>
        </div>
    <div style="overflow:auto;height:350px" id="customer_datail_tab" class="modal-body">

    <center><div class="loader"><img src="http://192.168.1.195:84/crm/themes/suiteP/images/loading.gif" style="height:80px"/></div></center>
        
      </div>

      <div style="overflow:auto;height:350px;" id="customer_datails_tab" class="modal-body">
      </div>

     <div class="modal-footer">
      </div>
     </div>
   </div>
 </div>';

 $contacts_view_dashlet_modal_for_transactions ='<div class="modal fade" id="customer_trans" data-backdrop="true" role="dialog">
  <div class="modal-dialog modal-lg" role="document"><div class="modal-content">
     <div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 id="head" class="modal-title">Customer Transactions</h4>
        </div>
    <div style="overflow:auto;height:350px" id="customer_trans_data" class="modal-body">

     
      </div>
     <div class="modal-footer">
      </div>
     </div>
   </div>
 </div>';


  $dashlet7 =  '<li class="noBullet" id="">
  <div id="" class="dashletPanel">
  <div onmouseover="this.style.cursor = \'move\';" id="" class="hd dashlet" style="cursor: move;">
  <div class="tl"></div>
  <div class="hd-center">
  <table class="formHeader h3Row" width="100%" cellspacing="0" cellpadding="0" border="0">
  <tbody><tr>
  <td class="dashlet-title" colspan="2">
  <h3>
  <span class="suitepicon suitepicon-module-"></span>
  <span>Total Customers Per Segment</span>
  </h3>
  </td>
  <td style="padding-right: 0px;" width="1%" nowrap="">
  <div class="dashletToolSet">
  <a href="javascript:void(0)" title="Edit SuiteCRM Dashlet" aria-label="Edit SuiteCRM Dashlet" onclick="SUGAR.mySugar.configureDashlet(\'6416050b-205e-09ca-ed38-5db9e86193f7\'); return false;">
  <span class="suitepicon suitepicon-action-edit"></span>
  </a>
  <a href="javascript:void(0)" title="Refresh SuiteCRM Dashlet" aria-label="Refresh SuiteCRM Dashlet" onclick="SUGAR.mySugar.retrieveCurrentPage(); return false;">
  <span class="suitepicon suitepicon-action-reload"></span>
  </a>
  <a href="javascript:void(0)" title="Delete SuiteCRM Dashlet" aria-label="Delete SuiteCRM Dashlet" onclick="SUGAR.mySugar.deleteDashlet(\'6416050b-205e-09ca-ed38-5db9e86193f7\'); return false;">
  <span class="suitepicon suitepicon-action-clear"></span>
  </a>
  </div>
  </td>
  </tr>
  </tbody></table>
  </div>
  </div>
  <div class="bd">
  <div class="bd-center">
  <table class="list view" width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr height="20"><td colspan="11"><h4>Total number of customers: '.$pie_chart.'</h4></td></tr></tbody></table>
  </div><div class="mr"></div></div><div class="ft"><div class="bl"></div><div class="ft-center"></div><div class="br"></div></div>
  </div>
  </li>
 ';

     echo "<input id='userid' type='text'  value='$current_user->id'/>
           <textarea style='display:none' id='count'>$dashlet7</textarea>
           $contacts_view_dashlet_modal $contacts_view_dashlet_modal_for_transactions";

  }

 	public function display(){

         global $mod_strings, $export_module, $current_language, $theme, $current_user, $dashletData, $sugar_flavor;

         $this->contacts_count();
         $this->processMaxPostErrors();
         include('modules/Home/index.php');

        
         //echo  $current_user->id;
  

        // echo $dashlet7;
       // echo (file_exists('../crm/include/MVC/View/views/view.list.php'))? 'Yes' :'No';
         
 	}

 public function processMaxPostErrors() {
        if($this->checkPostMaxSizeError()){
            $this->errors[] = $GLOBALS['app_strings']['UPLOAD_ERROR_HOME_TEXT'];
            $contentLength = $_SERVER['CONTENT_LENGTH'];

            $maxPostSize = ini_get('post_max_size');
            ini_set('post_max_size','1500MB');
            if (stripos($maxPostSize,"k"))
                $maxPostSize = (int) $maxPostSize * pow(2, 10);
            elseif (stripos($maxPostSize,"m"))
                $maxPostSize = (int) $maxPostSize * pow(2, 20);

            $maxUploadSize = ini_get('upload_max_filesize');
            if (stripos($maxUploadSize,"k"))
                $maxUploadSize = (int) $maxUploadSize * pow(2, 10);
            elseif (stripos($maxUploadSize,"m"))
                $maxUploadSize = (int) $maxUploadSize * pow(2, 20);

            $max_size = min($maxPostSize, $maxUploadSize);
            if ($contentLength > $max_size) {
                $errMessage = string_format($GLOBALS['app_strings']['UPLOAD_MAXIMUM_EXCEEDED'],array($contentLength,  $max_size));
            } else {
                $errMessage =$GLOBALS['app_strings']['UPLOAD_REQUEST_ERROR'];
            }

            $this->errors[] = '* '.$errMessage;
            $this->displayErrors();
        }
    }

}

