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
function set_campaignlog_and_save_background(popup_reply_data)
{var form_name=popup_reply_data.form_name;var name_to_value_array=popup_reply_data.name_to_value_array;var passthru_data=popup_reply_data.passthru_data;var query_array=new Array();if(name_to_value_array!='undefined'){for(var the_key in name_to_value_array)
{if(the_key=='toJSON')
{}
else
{query_array.push(the_key+'='+name_to_value_array[the_key]);}}}
var selection_list;if(popup_reply_data.selection_list)
{selection_list=popup_reply_data.selection_list;}
else
{selection_list=popup_reply_data.name_to_value_array;}
if(selection_list!='undefined'){for(var the_key in selection_list)
{query_array.push('subpanel_id[]='+selection_list[the_key])}}
var module=get_module_name();var id=get_record_id();query_array.push('value=DetailView');query_array.push('module='+module);query_array.push('http_method=get');query_array.push('return_module='+module);query_array.push('return_id='+id);query_array.push('record='+id);query_array.push('isDuplicate=false');query_array.push('return_type=addcampaignlog');query_array.push('action=Save2');query_array.push('inline=1');var refresh_page=escape(passthru_data['refresh_page']);for(prop in passthru_data){if(prop=='link_field_name'){query_array.push('subpanel_field_name='+escape(passthru_data[prop]));}else{if(prop=='module_name'){query_array.push('subpanel_module_name='+escape(passthru_data[prop]));}else{query_array.push(prop+'='+escape(passthru_data[prop]));}}}
var query_string=query_array.join('&');request_map[request_id]=passthru_data['child_field'];var returnstuff=http_fetch_sync('index.php',query_string);request_id++;got_data(returnstuff,true);if(refresh_page==1){document.location.reload(true);}}

function validatePortalName(e){var portalName=document.getElementById('portal_name');var portalNameExisting=document.getElementById("portal_name_existing");var portalNameVerified=document.getElementById('portal_name_verified');if(typeof(portalName.parentNode.lastChild)!='undefined'&&portalName.parentNode.lastChild.tagName=='SPAN'){portalName.parentNode.lastChild.innerHTML='';}
if(portalName.value==portalNameExisting.value){return;}
var callbackFunction=function success(data){count=data.responseText;if(count!=0){add_error_style('EditView','portal_name',SUGAR.language.get('app_strings','ERR_EXISTING_PORTAL_USERNAME'));for(wp=1;wp<=10;wp++){window.setTimeout('fade_error_style(style, '+wp*10+')',1000+(wp*50));}
portalName.focus();}
if(portalNameVerified.parentNode.childNodes.length>1){portalNameVerified.parentNode.removeChild(portalNameVerified.parentNode.lastChild);}
verifiedTextNode=document.createElement('span');verifiedTextNode.innerHTML='';portalNameVerified.parentNode.appendChild(verifiedTextNode);portalNameVerified.value=count==0?"true":"false";verifyingPortalName=false;}
if(portalNameVerified.parentNode.childNodes.length>1){portalNameVerified.parentNode.removeChild(portalNameVerified.parentNode.lastChild);}
if(portalName.value!=''&&!verifyingPortalName){document.getElementById('portal_name_verified').value="false";verifiedTextNode=document.createElement('span');portalNameVerified.parentNode.appendChild(verifiedTextNode);verifiedTextNode.innerHTML=SUGAR.language.get('app_strings','LBL_VERIFY_PORTAL_NAME');verifyingPortalName=true;var cObj=YAHOO.util.Connect.asyncRequest('POST','index.php?module=Contacts&action=ValidPortalUsername&portal_name='+portalName.value,{success:callbackFunction,failure:callbackFunction});}}

function handleKeyDown(e){if((kc=e["keyCode"])){enterKeyPressed=(kc==13)?true:false;if(enterKeyPressed){validatePortalName(e);freezeEvent(e);setTimeout(forceSubmit,2100);}}}

function freezeEvent(e){if(e.preventDefault)e.preventDefault();e.returnValue=false;e.cancelBubble=true;if(e.stopPropagation)e.stopPropagation();return false;}

function forceSubmit(){theForm=YAHOO.util.Dom.get('EditView');if(theForm){theForm.action.value='Save';if(!check_form('EditView')){return false;}
theForm.submit();}}

verifyingPortalName=false;enterKeyPressed=false;

//alert('geyef');
//alert('hjfjf');
$("#hr_ma_help_contacts_1_select_button").remove();///hide sms subpanel action button
$("#hr_ma_help_contacts_1_create_button").remove();///hide sms subpanel action button

$(document).ready(function(){
$("#hr_ma_help_contacts_1_select_button").remove();///hide sms subpanel action button
$("#hr_ma_help_contacts_1_create_button").remove();///hide sms subpanel action button
//alert('hjfjf');
var id = $("#id2").val();
var name = $("#name").val();

if(id){

$(".detail-view").hide();//hide the original detail view when you are in customer360 mode.:::
$("#customer_img").html("<center><img style='border:5px solid #455059;border-radius:100px;height:150px;width:150px' src='http://192.168.1.240:8181/ords/xapi/c360/callimg/"+id+"' alt='customer_img'/></center>");///customer image

$('#turnover').attr('src',window.location.protocol+'//'+window.location.host+'/gg/img/customer360/client-turnover.php?cust_id='+id);

$('#account-stats').attr('src',window.location.protocol+'//'+window.location.host+'/gg/img/customer360/account-stats.php?cust_id='+id);
// $.ajax({
//     type:"GET",
//     url:"http://192.168.1.116:8080/ords/xapi/c360/call/"+id,
//     data:{client_id_c:client_id_c},
//     success : function(results) {
//     //$('#tab-content-2').html(results);
//     if(name == results.items[0].client_name){ // check if the name matches.
//     $(".module-title-text").html(results.items[0].client_name);
//               }
//     console.log(results.items[0].client_name);
//    }
// }) ;

// this ajax is for the customer photo/image.::::::::::::::::::::::::::::::::::::..:: //
// $.ajax({
//     type:"GET",
//     url:"http://192.168.1.116:8080/ords/xapi/c360/callimg/"+id,
//     data:{client_id_c:client_id_c},
    //dataType: '',
    //async: true,
    //success : function(results) {
      //alert("Hi");
    //$('#tab-content-2').html(results);"+results.items[0].photo+"
    //if(name == results.items[0].client_name){ // check if the name matches.
    //  //alert(results);
    // $("#customer_img").html("<img style='height:200px;width:200px' src='http://192.168.1.116:8080/ords/xapi/c360/callimg/"+id+"' alt='customer_img'/>");
    //   //        }
   // console.log(results.items[0].client_name);
  // }
//}) ;
///End of Customer Image :::::::::::::::::::::::::::::::::::::::::::::::::::::::::   ::::::::???????




var client_id_c = $('#id2').val(); //fetch the client id from the contacts form.

//$('#tab-content-3').html('client_id_c');
/////////Ajax code for services subscribed///////Code also in themes\SuiteP\include\DetailView\DetailView.tpl
// $.ajax({

//     type:"POST",
//     url:"../gg/img/customer360/customer_demography.php",
//     data:{client_id_c:client_id_c,name:name},
//     success : function(results) {
//     $('#list_subpanel_hr_ma_help_contacts_0').html(results);
//    }
// }) ;
///////End of services////////////
/////Ajax code for services subscribed/////
$.ajax({

    type:"POST",
    url:"../gg/img/customer360/customer_services.php",
    data:{client_id_c:client_id_c,name:name},
    beforeSend: function(){
    $('#load').modal('show');      
    $('#ajaz_load_body').html('<center><div class="loader"><img src="../crm/themes/suiteP/images/loading.gif" style="height:80px"/></div></center>');
    },
    success : function(results) {
      console.log(results);
    $('#load').modal('hide');
     var splitString = results.split('&&');
     var services = splitString[0];
     var client_account_services = splitString[1];
     var client_basic_info = splitString[2];
     var client_balances = splitString[3];
     var client_preference = splitString[4];
     var c_name = splitString[5];
    $('#list_subpanel_hr_ma_help_contacts_3').html(services);
    $('#list_subpanel_hr_ma_help_contacts_7').html(client_account_services);
    $('#list_subpanel_hr_ma_help_contacts_0').html(client_basic_info);
    $('#list_subpanel_hr_ma_help_contacts_2').html(client_balances);
    $('#list_subpanel_hr_ma_help_contacts_4').html(client_preference);
    $(".module-title-text").html(c_name);
   }
}) ;
//////End of services////////////////////
/////Ajax code for Accounts subscribed/////
$.ajax({

    type:"POST",
    url:"../gg/img/customer360/customer_accounts.php",
    data:{client_id_c:client_id_c,name:name},
    success : function(results) {
    $('#list_subpanel_hr_ma_help_contacts_5').html(results);
   }
}) ;
//////End of Accounts////////////////////
/////Ajax code for Recent Contacts///////////
$.ajax({

    type:"POST",
    url:"../gg/img/customer360/customer-recent-contacts.php",
    data:{client_id_c:client_id_c,name:name},
    success : function(results) {
    $('#list_subpanel_hr_ma_help_contacts_6').html(results);
   }
}) ;
//////End of Recent contacts////////////////////
}///end of if (id)::://////
/////Ajax code for balances subscribed/////
// $.ajax({

//     type:"POST",
//     url:"../gg/img/customer360/customer_balances.php",
//     data:{client_id_c:client_id_c,name:name},
//     success : function(results) {
//     $('#list_subpanel_hr_ma_help_contacts_2').html(results);
//    }
// }) ;
//////End of balances////////////////////

////Ajax code for preferrence subscribed/////
// $.ajax({

//     type:"POST",
//     url:"../gg/img/customer360/customer_preferences.php",
//     data:{client_id_c:client_id_c,name:name},
//     success : function(results) {
//     $('#list_subpanel_hr_ma_help_contacts_4').html(results);
//    }
// }) ;
//////////////////End of preferrence////////////////////
////////////Fetch All customer 360 list View Data/////////////code also in themes/suitep/tpl/_headerModuleList.tpl
    $("#fetch_360_data").click(function(){///click on the search button
 // var client_id_c = $("#customerID").val();
//$('#customer360_fetch').modal('show');
    $('#customer360').modal('hide');        
    $('#ajaz_load').modal('show');      
//$('#move_for_load').hide();
$('#ajaz_load_body').html('<center><div class="loader"><img src="../crm/themes/suiteP/images/loading.gif" style="height:80px"/></div></center>');
var client_id_c = trim($("#customerID").val());

$.ajax({
             type:"POST",
             url:"../gg/img/customer360/fetch_360_data.php",
             data:{client_id_c:client_id_c},
            success : function(results) {
            //$('#head').html('Contacts With Birthdate In This Month');
            $('#ajaz_load').modal('hide');
            setTimeout(function(){
            //$('#move_for_load').show();
            
            $('#customer360_fetch').modal('show');
            $('#customer_fetch_tab').html(results);//put result in modal body
            },100);
                   }
        }) ;
//$('#customer360').modal('hide');

});

$('#customerID').keypress(function(e){ ///Also when you click on enter button it should search
  if(e.which === 13){
//var client_id_c = $("#customerID").val();
//$('#customer360_fetch').modal('show');
//$('#load').html('<center><div class="loader"><img src="https://github.githubassets.com/images/spinners/octocat-spinner-128.gif"/></div></center>');
$('#customer360').modal('hide');        
$('#ajaz_load').modal('show');      
//$('#move_for_load').hide();
$('#ajaz_load_body').html('<center><div class="loader"><img src="../crm/themes/suiteP/images/loading.gif" style="height:80px"/></div></center>');
 var client_id_c = $("#customerID").val();

$.ajax({
             type:"POST",
             url:"../gg/img/customer360/fetch_360_data.php",
             data:{client_id_c:client_id_c},
            success : function(results) {
              $('#ajaz_load').modal('hide');
            //$('#head').html('Contacts With Birthdate In This Month'); 
           setTimeout(function(){
            $('#customer360_fetch').modal('show');
            $('#customer_fetch_tab').html(results);//put result in modal
              },100);

                }
        }) ;  
         }///end if     
   });

// $('.email-link').clone(true).append('ul.dropdown-menu li:first');
// send_email = $(".email-link").replaceWith(send_email);

///THIS CODE IS ALSO FOUND IN themes/suiteP/include/DetailView/action_menu.tpl/////////
//////:::::::Compose-email button on the action menu of contacts details:::/// 
var email = $('.email-link').attr('onclick');
var id = $('.email-link').attr('data-record-id');
var name = $('.email-link').attr('data-module-name');
var address = $('.email-link').attr('data-email-address');

$('#act').append('<li><input id="bb" class="button" onclick="'+email+'" type="button" data-email-address="'+address+'" data-module="Contacts" data-module-name="'+name+'" data-record-id="'+id+'"  value="Compose Email"></li> <li><input id="sms" onclick="sms();" class="button" value="Send SMS" type="button"></li>');
// ///////////End of the button NB: Send SMS button is also part/////////////////////////
 // $("input[name='mass[]']").click(function(){

 //  if(localStorage.getItem("checkedbox") == 'true') {
 //    $(this).prop(checked, 'false');
 //    localStorage.setItem("checkedbox", 'false');

 //  }
 //  else {
 //    $(this).prop(checked, 'true');
 //     localStorage.setItem("checkedbox", 'true');
 //  }
// $(function(){
//     var test = localStorage.input === 'true'? true: false;
//     $('input').prop('checked', test || false);
// });

// $('input').on('change', function() {
//     localStorage.input = $(this).is(':checked');
//     console.log($(this).is(':checked'));
//   });
// });
 //$("#actionLinkTop").show();
//////Below code is for contacts list view page inside the document ready function==========:::::::////////
//alert($(".module-title-text").html());
if(trim($(".module-title-text").html())=="&nbsp;Contacts"){

$(".sugar_action_button").find("ul").prepend("<li><a href='javascript:send_bulk_sms_modal()' class='parent-dropdown-action-handler'>Send Bulk SMS</a></li>");

   }

///==========End of contacts list view page=====////////////
});////::::::::::::document ready function ends


var view_trans = function(){
  var customer_id = ($("#client_id_c").html().trim()!='') ? $("#client_id_c").html().trim():$("#id2").val().trim();  
  var name =  ($(".module-title-text").html().trim()!='') ? $(".module-title-text").html().trim():$("#name").val().trim();  
       // alert(customer_id);
  $("#customer_trans_data").html("<iframe style='width:100%;height:100%;border:0px' src='"+document.location.protocol+"//"+window.location.host+"/gg/img/customer360/transactions.php?cust_id="+customer_id+"&name="+name+"'></iframe>");
  $("#customer_trans").modal('show');
}


var view_trans_individual = function(trans,month){
  var customer_id = $("#id2").val().trim();  
  var name =  $("#name").val().trim();  
       // alert(customer_id);
  $("#customer_trans_data").html("<iframe style='width:100%;height:100%;border:0px' src='"+document.location.protocol+"//"+window.location.host+"/gg/img/customer360/trans-individual.php?cust_id="+customer_id+"&name="+name+"&trans="+trans+"&month="+month+"'></iframe>");
  $("#customer_trans").modal('show');
}


var send_bulk_sms_modal = function(){ //to call sms modal
//alert('kikikiki');

var values = new Array();

$.each($("input[name='mass[]']:checked").closest("td").siblings("td[field=phone_work]"),
       function () {
            values.push(trim($(this).text()));
       });
$("input[id=receipt]").attr("value",values);
$('#bulk_sms').modal('show');
   //alert(values);
}//;;;

var send_bulk_sms = function(){//API to send the bulk sms

alert("MSG SENT");
}//End of API

//============================================================================
/////function to call the single sms modal//////////////////////
function sms(){
 var rec = ($("div[field=phone_home]").text()!="") ? $("div[field=phone_home]").text() : $("div[field=phone_mobile]").text();//get phone number...
    //alert(rec);
    $("input[id=receipt]").attr("value",rec);///display phone number on send sms form////////
    $('#empModal').modal('show');       
};

///////end////////////////////////////////////////////////////////////////////////////////////

//;;;;This ajax code removes sms create/select buttons when sorting ;;;;;//////
    $(document).ajaxStart(function () {         
     // $('#load').modal('show');
      $("#hr_ma_help_contacts_1_select_button").remove();///hide sms subpanel action button
      $("#hr_ma_help_contacts_1_create_button").remove();///hide sms subpanel action button

    }).ajaxStop(function () {       
     // $('#load').modal('hide');
      $("#hr_ma_help_contacts_1_select_button").remove();///hide sms subpanel action button
      $("#hr_ma_help_contacts_1_create_button").remove();///hide sms subpanel action button
    });
// ///::::::::::::::::::::::::::End::::::::::::::::::://///////

/////////////function to send the sms data//////////////////////////////////////////////////
function send_sms(){
  
    var recc = $("input[id=receipt]").attr("value"); //get receipient no: from sms form/////  
    var msg = $("textarea[id=msg]").val();///get taxt msg from sms form.....//////////
    var current_user = $("#current_user").val();
    var fname = $('#first_name').html();
    var lname = $('#last_name').html();
    var customer_id = $('span[id="client_id_c"]').text().trim();
   // alert(recc);
    //alert(customer_id);
// ///;;;;The loading icon animation time;;;;;//////
		// $(document).ajaxStart(function () {
         
  //     $('#load').modal('show');

		// }).ajaxStop(function () { 
      
  //     $('#load').modal('hide');
    //  $("#hr_ma_help_contacts_1_select_button").remove();///hide sms subpanel action button
     // $("#hr_ma_help_contacts_1_create_button").remove();///hide sms subpanel action button
//alert((recc != " ") ? "value":"empty");

		// });
// ///::::::::::::::::::::::::::End::::::::::::::::::://///////
//alert('hii');
//alert(fname+' '+lname);
//if(Boolean(recc)){
  $('#load').modal('show');
 var settings = {
        "async": true,
        "crossDomain": true,
        "url": "https://api.infobip.com/sms/1/text/single",
        "method": "POST",
        "headers": {
          "Content-Type": "application/json",
          "Authorization": "Basic VW5pb25TeXN0ZW1zOlVuaVMxOTQ1",
          //"cache-control": "no-cache",
         // "Postman-Token": "19e4f4d0-1892-4415-85c2-17d5c4760bd0"
        },
        "processData": false,
        "data": "{  \r\n   \"from\":\"UNION\",\r\n   \"to\":\""+recc+"\",\r\n   \"text\":\""+msg+"\"\r\n}\r\n\t"
      }
      
      $.ajax(settings).done(function (response) {
        //document.write(response);
       // $("#loading").html('<center>Loading...Please Wait.<img src="load.gif" alt="loading" style="height:50px;width:50px"></center>');
        $('#load').modal('hide');
        $('#success').modal('show');
        console.log(response);
        $("textarea[id=msg]").val('');
        
        $.ajax({
          url:'../gg/img/customer360/save_sms.php?customer_id='+customer_id,
          method: 'POST',
          data :{fname:fname,lname:lname,recc:recc,msg:msg,current_user:current_user}
        }).done(function(res){

        //$(document).ready(function () { //wanted to refresh the sms subpanel
       // $('.listViewThLinkS1')[0].click();  //$('#about').get(0).click();
            // });
             console.log(res);

        }).fail(function(res){

             console.log(res);
        });

      }).fail(function(data1){  
       $('#load').modal('hide');     
        alert("Sorry!!, Message was not sent");
        console.log(data1);
      });

   // }else{

     // alert("Receipient's number is empty");
   // }
}
///////////.......End of SMS  function......../////////////////////////////////////////////////////////////	
