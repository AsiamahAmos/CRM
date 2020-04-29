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
function open_contact_popup(module_name,width,height,initial_filter,close_popup,hide_clear_button,popup_request_data,popup_mode,create,metadata)
{window.document.popup_request_data=popup_request_data;window.document.close_popup=close_popup;URL='index.php?mode=MultiSelect&'
+'module='+module_name
+'&action=ContactAddressPopup';if(initial_filter!='')
{URL+='&query=true'+initial_filter;}
if(hide_clear_button)
{URL+='&hide_clear_button=true';}
windowName='popup_window';windowFeatures='width='+width
+',height='+height
+',resizable=1,scrollbars=1';if(popup_mode==''&&popup_mode=='undefined'){popup_mode='single';}
URL+='&mode='+popup_mode;if(create==''&&create=='undefined'){create='false';}
URL+='&create='+create;if(metadata!=''&&metadata!='undefined'){URL+='&metadata='+metadata;}
win=window.open(URL,windowName,windowFeatures);if(window.focus)
{win.focus();}
return win;}
function set_focus(){document.getElementById('name').focus();}



$(document).ready(function(){
var current_user = $("button[id='with-label']").attr('title');

// $("table tbody tr td a:contains('ayorkor')").parent().parent().remove();
  
// //var click = $("button[name='listViewNextButton']").attr('onclick');
// var clickk = "showSubPanel('contacts', '/crm/index.php?module=Accounts&action=SubPanelViewer&record=70&to_pdf=true&subpanel=contacts&layout_def_key=Accounts&inline=1&ajaxSubpanel=true&_=1572967297228&Accounts_contacts_CELL_offset=10&Accounts_contacts_CELL_ORDER_BY=&sort_order=asc&to_pdf=true&action=SubPanelViewer&subpanel=contacts&layout_def_key=Accounts', true)";
setInterval(function(){
	//:::::::::::Show Only Current User Data::::::::::://
      //   var current_user = $("#with-label").text(); 
      //   current_user = current_user.trim(); 
      //   //var cc = 'Dan';
      // // if($('td[field="product_owner_c"]').text()!==;
      // if(current_user!=='Administrator'){
      // $('.list.view.table-responsive').find('tr:has(td[field="assigned_user_name"]:has(a:not(:contains("'+current_user+'"))))').hide();
      //                  }
      
//      $("table tbody tr td a:not(:contains('"+current_user+"'))").parent().parent().hide();
//      $("table tbody tr td a:contains('"+current_user+"')").parent().parent().show();
// //:::::::::::End Of Show Only Current User Data::::::::::://
	//alert($("div[id='list_subpanel_contacts'] table tbody tr td a").html());
	//if($("div[id='subpanel_contacts'] table tbody tr td a").html()!='ayorkor york'){
// $("table tbody").find("tr:has(td[style='display: table-cell;']:has(a:not(:contains('JOSEPH'))))").hide();
//$("table tbody tr td a:not(:contains('ayorkor'))").parent().parent().hide();
//$("button[name='listViewNextButton']").attr('onclick','run();'+clickk);
  //     }
},1000);
// setTimeout(function(){
// $("table tbody tr td a:contains('ayorkor')").parent().parent().remove();
// $("button[name='listViewNextButton']").attr('onclick','run();'+clickk);
// },100);
//alert(clickk);
//$("button[name='listViewNextButton']").click(function(){
//$("table tbody tr td a:contains('ayorkor')").parent().parent().remove();
//});
});
// $("table tbody").find("tr:has(td[style='display: table-cell;']:has(a:not(:contains('JOSEPH'))))").hide();

// $("button[name='listViewNextButton']").click(function(){
// 	alert("hi");
// //$("table tbody tr td a:contains('ayorkor')").parent().parent().remove();
// });

// function run(){
// 	$("table tbody tr td a:contains('ayorkor')").parent().parent().remove();
// 	alert('click');
// 	//$("button[name='listViewNextButton']").attr('onclick','run();'+clickk);
// }



// $("button[name='listViewNextButton']").ajaxSend(function(){
// $("table tbody tr td a:contains('ayorkor')").parent().parent().remove();
// $("button[name='listViewNextButton']").attr('onclick','run();'+clickk);
// }).ajaxComplete(function(){
// $("table tbody tr td a:contains('ayorkor')").parent().parent().remove();
// $("button[name='listViewNextButton']").attr('onclick','run();'+clickk);
// });
	
