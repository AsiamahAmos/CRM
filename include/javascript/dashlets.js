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
SUGAR.dashlets=function(){return{postForm:function(theForm,callback){var success=function(data){if(data){callback(data.responseText);}}
YAHOO.util.Connect.setForm(theForm);var cObj=YAHOO.util.Connect.asyncRequest('POST','index.php',{success:success,failure:success});return false;},callMethod:function(dashletId,methodName,postData,refreshAfter,callback){ajaxStatus.showStatus(SUGAR.language.get('app_strings','LBL_SAVING'));response=function(data){ajaxStatus.hideStatus();if(refreshAfter)SUGAR.mySugar.retrieveDashlet(dashletId);if(callback){callback(data.responseText);}}
post='to_pdf=1&module=Home&action=CallMethodDashlet&method='+methodName+'&id='+dashletId+'&'+postData;var cObj=YAHOO.util.Connect.asyncRequest('POST','index.php',{success:response,failure:response},post);}};}();if(SUGAR.util.isTouchScreen()&&typeof iScroll=='undefined'){with(document.getElementsByTagName("head")[0].appendChild(document.createElement("script")))
{setAttribute("id","newScript",0);setAttribute("type","text/javascript",0);setAttribute("src","include/javascript/iscroll.js",0);}}


// $('a[title="View More Info"][href*="Contacts"]').click(function(e){
      
//     e.preventDefault();
//     var customer_id = $(this).parent().parent().children().first().html();  
//     var name =  $(this).parent().parent().children().eq(1).children().children().html();  
//     //alert(name);
//     $("#customer_datails_tab").html("<iframe style='width:100%;height:100%;border:0px' src='"+document.location.protocol+"//"+window.location.host+"/gg/img/customer360/more-info-modal.php?cust_id="+customer_id+"&name="+name+"'></iframe>");
//        $("#customer_details").modal('show');
//        //alert("You clicked View");
//    });


$(document).ready(function(){
    //   var myFrame = $('#myframe').contents().find('body');

    //   var textareaValue = $('textarea').val();

    //   myFrame.html(textareaValue); 
    var userid = $('#userid').val();//Get data from input and pass to iframe url.
    ///overwrite the default src attribute of the iframe.
    $('iframe[title="Total Customers Per Segment"]').attr('src',document.location.protocol+'//'+window.location.host+'/gg/img/customer360/count-contacts.php?userid='+userid);

    $('iframe[title="Upcoming Birthdays"]').attr('src',window.location.protocol+'//'+window.location.host+'/gg/img/customer360/upcoming-birthdays.php?userid='+userid);
     


    setInterval(function(){
        $('a[title="Edit"][href*="Contacts"] span').attr('class','suitepicon suitepicon-action-resource-chart');
        $('a[title="Edit"][href*="Contacts"]').attr('title','View Transactions');
        $('a[title="View"][href*="Contacts"]').attr('title','View More Info');
        
    

    $('a[title="View Transactions"][href*="Contacts"]').click(function(e){
      //alert("hello");
        e.preventDefault();
        var customer_id = $(this).parent().parent().children().first().html();  
        var name =  $(this).parent().parent().children().eq(1).children().children().html();  
        //alert(name);
        $("#customer_trans_data").html("<iframe style='width:100%;height:100%;border:0px' src='"+document.location.protocol+"//"+window.location.host+"/gg/img/customer360/transactions.php?cust_id="+customer_id+"&name="+name+"'></iframe>");
           $("#customer_trans").modal('show');
           //alert("You clicked View");
       });
    

       $('a[title="View More Info"][href*="Contacts"]').click(function(e){
      
        e.preventDefault();
          $("#customer_datails_tab").hide();//actual data
          $("#customer_datail_tab").show();//the loader icon
        var customer_id = $(this).parent().parent().children().first().html();  
        var name =  $(this).parent().parent().children().eq(1).children().children().html();  
        //alert(name);
    
      
      //   $.ajax({
   
      //      type:"POST",
      //      url:"../gg/img/customer360/more-info-modal.php?cust_id="+customer_id+"&name="+name,
      //      beforeSend: function(){
      //      $('#customer_details').modal('show');      
      //      $('#customer_datails_tab').html('<center><div class="loader"><img src="../crm/themes/suiteP/images/loading.gif" style="height:80px"/></div></center>');
      //      },
      //      success : function(results) {
      //        console.log(results);
      //      //$('#load').modal('hide');
      //      $('#customer_datails_tab').html(results);
      //      customer_id = "";
      //      name = "";
      //     }
      //  }) ;
   
        $("#customer_datails_tab").html("<iframe style='width:100%;height:100%;border:0px' src='"+document.location.protocol+"//"+window.location.host+"/gg/img/customer360/more-info-modal.php?cust_id="+customer_id+"&name="+name+"'></iframe>");
        $("#customer_details").modal('show');

        setTimeout(function(){
          $("#customer_datails_tab").show();//actual data
          $("#customer_datail_tab").hide();//loader icon
        },6000);
           //alert("You clicked View");
       });

    
    },3000);//end of set interval
    
       
    
     // var count =  $('#count').val();
     //  $('#col_0_0').prepend(count);
     // // alert($('#col_0_0').html());
     //  console.log($('#col_0_0').html()); 
     

 });