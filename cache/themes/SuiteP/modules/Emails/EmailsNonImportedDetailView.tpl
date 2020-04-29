

<script language="javascript">
    {literal}
    SUGAR.util.doWhen(function () {
        return $("#contentTable").length == 0;
    }, SUGAR.themes.actionMenu);
    {/literal}
</script>
<table cellpadding="0" cellspacing="0" border="0" width="100%" id="">
<tr>
<td class="buttons" align="left" NOWRAP width="80%">
<div class="actionsContainer">
<form action="index.php" method="post" name="DetailView" id="formDetailView">
<input type="hidden" name="module" value="{$module}">
<input type="hidden" name="record" value="{$fields.id.value}">
<input type="hidden" name="return_action">
<input type="hidden" name="return_module">
<input type="hidden" name="return_id">
<input type="hidden" name="module_tab">
<input type="hidden" name="isDuplicate" value="false">
<input type="hidden" name="offset" value="{$offset}">
<input type="hidden" name="action" value="EditView">
<input type="hidden" name="sugar_body_only">
{if !$config.enable_action_menu}
<div class="buttons">
<input type="button" data-action="emails-import-single" data-inbound-email-record="{$bean->inbound_email_record}" data-email-uid="{$bean->uid}" data-email-msgno="{$bean->msgNo}" value="{$MOD.LBL_IMPORT}"/>
<input type="button" onclick="window.location.href='index.php?module=Emails&action=ReplyTo&folder=INBOX.TestInbox&folder=inbound&inbound_email_record={$bean->inbound_email_record}&uid={$bean->uid}&msgno={$bean->msgNo}&record={$bean->id}';" value="{$MOD.LBL_BUTTON_REPLY_TITLE}"/>
<input type="button" onclick="window.location.href='index.php?module=Emails&action=ReplyToAll&folder=INBOX.TestInbox&folder=inbound&inbound_email_record={$bean->inbound_email_record}&uid={$bean->uid}&msgno={$bean->msgNo}&record={$bean->id}';" value="{$MOD.LBL_BUTTON_REPLY_ALL}"/>
<input type="button" onclick="window.location.href='index.php?module=Emails&action=Forward&folder=INBOX.TestInbox&folder=inbound&inbound_email_record={$bean->inbound_email_record}&uid={$bean->uid}&msgno={$bean->msgNo}&record={$bean->id}';" value="{$MOD.LBL_BUTTON_FORWARD}"/>
{if $bean->aclAccess("detail")}{if !empty($fields.id.value) && $isAuditEnabled}<input id="btn_view_change_log" title="{$APP.LNK_VIEW_CHANGE_LOG}" class="button" onclick='open_popup("Audit", "600", "400", "&record={$fields.id.value}&module_name=Emails", true, false,  {ldelim} "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] {rdelim} ); return false;' type="button" value="{$APP.LNK_VIEW_CHANGE_LOG}">{/if}{/if}
</div>                    {/if}
</form>
</div>
</td>
<td align="right" width="20%" class="buttons">{$ADMIN_EDIT}
</td>
</tr>
</table>
{sugar_include include=$includes}
<div class="detail-view">
<div class="mobile-pagination">{$PAGINATION}</div>

<ul class="nav nav-tabs">

{if $config.enable_action_menu and $config.enable_action_menu != false}
<li role="presentation" class="active">
<a id="tab0" data-toggle="tab" class="hidden-xs">
{sugar_translate label='LBL_EMAIL_INFORMATION' module='Emails'}
</a>
<a id="xstab0" href="#" class="visible-xs first-tab dropdown-toggle" data-toggle="dropdown">
{sugar_translate label='LBL_EMAIL_INFORMATION' module='Emails'}
</a>
</li>
{/if}
{if $config.enable_action_menu and $config.enable_action_menu != false}
<li id="tab-actions" class="dropdown">
<a class="dropdown-toggle" data-toggle="dropdown" href="#">ACTIONS<span class="suitepicon suitepicon-action-caret"></span></a>
<ul id="act" class="dropdown-menu">
<li><input type="button" data-action="emails-import-single" data-inbound-email-record="{$bean->inbound_email_record}" data-email-uid="{$bean->uid}" data-email-msgno="{$bean->msgNo}" value="{$MOD.LBL_IMPORT}"/></li>
<li><input type="button" onclick="window.location.href='index.php?module=Emails&action=ReplyTo&folder=INBOX.TestInbox&folder=inbound&inbound_email_record={$bean->inbound_email_record}&uid={$bean->uid}&msgno={$bean->msgNo}&record={$bean->id}';" value="{$MOD.LBL_BUTTON_REPLY_TITLE}"/></li>
<li><input type="button" onclick="window.location.href='index.php?module=Emails&action=ReplyToAll&folder=INBOX.TestInbox&folder=inbound&inbound_email_record={$bean->inbound_email_record}&uid={$bean->uid}&msgno={$bean->msgNo}&record={$bean->id}';" value="{$MOD.LBL_BUTTON_REPLY_ALL}"/></li>
<li><input type="button" onclick="window.location.href='index.php?module=Emails&action=Forward&folder=INBOX.TestInbox&folder=inbound&inbound_email_record={$bean->inbound_email_record}&uid={$bean->uid}&msgno={$bean->msgNo}&record={$bean->id}';" value="{$MOD.LBL_BUTTON_FORWARD}"/></li>
<li>{if $bean->aclAccess("detail")}{if !empty($fields.id.value) && $isAuditEnabled}<input id="btn_view_change_log" title="{$APP.LNK_VIEW_CHANGE_LOG}" class="button" onclick='open_popup("Audit", "600", "400", "&record={$fields.id.value}&module_name=Emails", true, false,  {ldelim} "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] {rdelim} ); return false;' type="button" value="{$APP.LNK_VIEW_CHANGE_LOG}">{/if}{/if}</li>
</ul>
<script>
    // $('#act').append('<li ><input id="sms" onclick="sms();" class="button" value="Send SMS" type="button"></li>');
//////:::::::Compose-email button on the action menu of contacts details::://///////Code also in contacts/contacts.js
// var email = $('.email-link').attr('onclick');
// var id = $('.email-link').attr('data-record-id');
// var name = $('.email-link').attr('data-module-name');
// var address = $('.email-link').attr('data-email-address');

// var currentTab = $('#moduleTab_Contacts').text();
// //alert(currentTab);
// if(currentTab=='Contacts')
// $('#act').append('<li><input id="bb" class="button" onclick="'+email+'" type="button" data-email-address="'+address+'" data-module="Contacts" data-module-name="'+name+'" data-record-id="'+id+'"  value="Compose Email"></li> <li><input id="sms" onclick="sms();" class="button" value="Send SMS" type="button"></li>');
  
// ///////////End of the button NB: Send SMS button is also part/////////////////////////

</script>        </li>
<li class="tab-inline-pagination">
{$PAGINATION}
</li>
{/if}
</ul>
<div class="clearfix"></div>

{if $config.enable_action_menu and $config.enable_action_menu != false}

<div class="tab-content">
{else}

<div class="tab-content" style="padding: 0; border: 0;">
{/if}


{if $config.enable_action_menu and $config.enable_action_menu != false}
<div class="tab-pane-NOBOOTSTRAPTOGGLER active fade in" id='tab-content-0'>





<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_OPT_IN' module='Emails'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="function" field="opt_in" colspan='3' >

{if !$fields.opt_in.hidden}
{counter name="panelFieldCount" print=false}
<span id='opt_in_span'>
{$fields.opt_in.value}
</span>
{/if}

</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_FROM' module='Emails'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="varchar" field="from_addr_name" colspan='3' >

{if !$fields.from_addr_name.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.from_addr_name.value) <= 0}
{assign var="value" value=$fields.from_addr_name.default_value }
{else}
{assign var="value" value=$fields.from_addr_name.value }
{/if} 
<span class="sugar_field" id="{$fields.from_addr_name.name}">{$fields.from_addr_name.value}</span>
{/if}

</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_TO' module='Emails'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="varchar" field="to_addrs_names" colspan='3' >

{if !$fields.to_addrs_names.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.to_addrs_names.value) <= 0}
{assign var="value" value=$fields.to_addrs_names.default_value }
{else}
{assign var="value" value=$fields.to_addrs_names.value }
{/if} 
<span class="sugar_field" id="{$fields.to_addrs_names.name}">{$fields.to_addrs_names.value}</span>
{/if}

</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_CC' module='Emails'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="varchar" field="cc_addrs_names" colspan='3' >

{if !$fields.cc_addrs_names.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.cc_addrs_names.value) <= 0}
{assign var="value" value=$fields.cc_addrs_names.default_value }
{else}
{assign var="value" value=$fields.cc_addrs_names.value }
{/if} 
<span class="sugar_field" id="{$fields.cc_addrs_names.name}">{$fields.cc_addrs_names.value}</span>
{/if}

</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_BCC' module='Emails'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="varchar" field="bcc_addrs_names" colspan='3' >

{if !$fields.bcc_addrs_names.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.bcc_addrs_names.value) <= 0}
{assign var="value" value=$fields.bcc_addrs_names.default_value }
{else}
{assign var="value" value=$fields.bcc_addrs_names.value }
{/if} 
<span class="sugar_field" id="{$fields.bcc_addrs_names.name}">{$fields.bcc_addrs_names.value}</span>
{/if}

</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_SUBJECT' module='Emails'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="name" field="name" colspan='3' >

{if !$fields.name.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.name.value) <= 0}
{assign var="value" value=$fields.name.default_value }
{else}
{assign var="value" value=$fields.name.value }
{/if} 
<span class="sugar_field" id="{$fields.name.name}">{$fields.name.value}</span>
{/if}

</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_BODY' module='Emails'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="emailbody" field="description_html" colspan='3' >

{if !$fields.description_html.hidden}
{counter name="panelFieldCount" print=false}

<span class="sugar_field" id="{$fields.description_html.name}">{$fields.description_html.value}</span>
{/if}

</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_DATE_ENTERED' module='Emails'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="datetime" field="date_entered" colspan='3' >

{if !$fields.date_entered.hidden}
{counter name="panelFieldCount" print=false}


{assign var="value" value=10/01/2019 }
<span class="sugar_field" id="{$fields.date_entered.name}">{$value}</span>
{/if}

</div>


</div>




<div class="col-xs-12 col-sm-6 detail-view-row-item">
</div>

<div class="clear"></div>
</div>
                        </div>
{else}

<div class="tab-pane-NOBOOTSTRAPTOGGLER panel-collapse"></div>
{/if}
</div>

<div class="panel-content">
<div>&nbsp;</div>





{if $config.enable_action_menu and $config.enable_action_menu != false}

{else}

<div class="panel panel-default">
<div class="panel-heading ">
<a class="" role="button" data-toggle="collapse" href="#top-panel--1" aria-expanded="false">
<div class="col-xs-10 col-sm-11 col-md-11">
{sugar_translate label='LBL_EMAIL_INFORMATION' module='Emails'}
</div>
</a>
</div>
<div class="panel-body panel-collapse collapse in panelContainer" id="top-panel--1" data-id="LBL_EMAIL_INFORMATION">
<div class="tab-content">
<!-- TAB CONTENT -->





<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_OPT_IN' module='Emails'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="function" field="opt_in" colspan='3' >

{if !$fields.opt_in.hidden}
{counter name="panelFieldCount" print=false}
<span id='opt_in_span'>
{$fields.opt_in.value}
</span>
{/if}

</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_FROM' module='Emails'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="varchar" field="from_addr_name" colspan='3' >

{if !$fields.from_addr_name.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.from_addr_name.value) <= 0}
{assign var="value" value=$fields.from_addr_name.default_value }
{else}
{assign var="value" value=$fields.from_addr_name.value }
{/if} 
<span class="sugar_field" id="{$fields.from_addr_name.name}">{$fields.from_addr_name.value}</span>
{/if}

</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_TO' module='Emails'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="varchar" field="to_addrs_names" colspan='3' >

{if !$fields.to_addrs_names.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.to_addrs_names.value) <= 0}
{assign var="value" value=$fields.to_addrs_names.default_value }
{else}
{assign var="value" value=$fields.to_addrs_names.value }
{/if} 
<span class="sugar_field" id="{$fields.to_addrs_names.name}">{$fields.to_addrs_names.value}</span>
{/if}

</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_CC' module='Emails'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="varchar" field="cc_addrs_names" colspan='3' >

{if !$fields.cc_addrs_names.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.cc_addrs_names.value) <= 0}
{assign var="value" value=$fields.cc_addrs_names.default_value }
{else}
{assign var="value" value=$fields.cc_addrs_names.value }
{/if} 
<span class="sugar_field" id="{$fields.cc_addrs_names.name}">{$fields.cc_addrs_names.value}</span>
{/if}

</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_BCC' module='Emails'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="varchar" field="bcc_addrs_names" colspan='3' >

{if !$fields.bcc_addrs_names.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.bcc_addrs_names.value) <= 0}
{assign var="value" value=$fields.bcc_addrs_names.default_value }
{else}
{assign var="value" value=$fields.bcc_addrs_names.value }
{/if} 
<span class="sugar_field" id="{$fields.bcc_addrs_names.name}">{$fields.bcc_addrs_names.value}</span>
{/if}

</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_SUBJECT' module='Emails'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="name" field="name" colspan='3' >

{if !$fields.name.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.name.value) <= 0}
{assign var="value" value=$fields.name.default_value }
{else}
{assign var="value" value=$fields.name.value }
{/if} 
<span class="sugar_field" id="{$fields.name.name}">{$fields.name.value}</span>
{/if}

</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_BODY' module='Emails'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="emailbody" field="description_html" colspan='3' >

{if !$fields.description_html.hidden}
{counter name="panelFieldCount" print=false}

<span class="sugar_field" id="{$fields.description_html.name}">{$fields.description_html.value}</span>
{/if}

</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_DATE_ENTERED' module='Emails'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="datetime" field="date_entered" colspan='3' >

{if !$fields.date_entered.hidden}
{counter name="panelFieldCount" print=false}


{assign var="value" value=10/01/2019 }
<span class="sugar_field" id="{$fields.date_entered.name}">{$value}</span>
{/if}

</div>


</div>




<div class="col-xs-12 col-sm-6 detail-view-row-item">
</div>

<div class="clear"></div>
</div>
                            </div>
</div>
</div>
{/if}
</div>
</div>

</form>
<script>SUGAR.util.doWhen("document.getElementById('form') != null",
        function(){ldelim}SUGAR.util.buildAccessKeyLabels();{rdelim});
</script>            <script type="text/javascript" src="include/InlineEditing/inlineEditing.js"></script>
<script type="text/javascript" src="modules/Favorites/favorites.js"></script>
{literal}
<script type="text/javascript">

/////////////////////////////////////////////////////////////////////
///////////Code also in contacts/contacts.js::::::///////////////////
var client_id_c = $('#client_id_c').html(); //fetch the client id from the contacts form.
var currentTab = $('#moduleTab_Contacts').text();
//alert(currentTab) get current tab thus contacts module/////;

if(currentTab=='Contacts'){ //execute if only in contacts module////
//$('#tab-content-3').html('client_id_c');
/////////Ajax code for services subscribed///////
$.ajax({

    type:"POST",
    url:"http://192.168.1.225/gg/img/customer360/services2.php",
    data:{client_id_c:client_id_c},
    success : function(results) {
    $('#tab-content-2').html(results);
   }
}) ;
///////End of services////////////

/////Ajax code for products subscribed/////
$.ajax({

    type:"POST",
    url:"http://192.168.1.225/gg/img/customer360/products.php",
    data:{client_id_c:client_id_c},
    success : function(results) {
    $('#tab-content-3').html(results);
   }
}) ;
//////End of products////////////////////

/////Ajax code for preferrence subscribed/////
$.ajax({

    type:"POST",
    url:"http://192.168.1.225/gg/img/customer360/client-pref.php",
    data:{client_id_c:client_id_c},
    success : function(results) {
    $('#tab-content-4').html(results);
   }
}) ;
//////End of preferrence////////////////////
}
// //////::::::::Compose-email button on the action menu of contacts details:::/// 
// var email = $('.email-link').attr('onclick');
// var id = $('.email-link').attr('data-record-id');
// var name = $('.email-link').attr('data-module-name');
// var address = $('.email-link').attr('data-email-address');

// $('.dropdown-menu').append('<li><input id="bb" class="button" onclick="'+email+'" type="button" data-email-address="'+address+'" data-module="Contacts" data-module-name="'+name+'" data-record-id="'+id+'"  value="Compose Email"></li><li ><input id="sms" onclick="sms();" class="button" value="Send SMS" type="button"></li>');
// ///////////End of the button NB: Send SMS button is also part/////////////////////////

// /////function to call the sms modal////
// function sms(){
//     $('#empModal').modal('show');
// };
// ///////end///////////////////////////



/////////////////////////////////////////////////////////////////////////
                    var selectTabDetailView = function(tab) {
                        $('#content div.tab-content div.tab-pane-NOBOOTSTRAPTOGGLER').hide();
                        $('#content div.tab-content div.tab-pane-NOBOOTSTRAPTOGGLER').eq(tab).show().addClass('active').addClass('in');
                    };

                    var selectTabOnError = function(tab) {
                        selectTabDetailView(tab);
                        $('#content ul.nav.nav-tabs > li').removeClass('active');
                        $('#content ul.nav.nav-tabs > li a').css('color', '');

                        $('#content ul.nav.nav-tabs > li').eq(tab).find('a').first().css('color', 'red');
                        $('#content ul.nav.nav-tabs > li').eq(tab).addClass('active');

                    };

                    var selectTabOnErrorInputHandle = function(inputHandle) {
                        var tab = $(inputHandle).closest('.tab-pane-NOBOOTSTRAPTOGGLER').attr('id').match(/^detailpanel_(.*)$/)[1];
                        selectTabOnError(tab);
                    };


                    $(function(){
                        $('#content ul.nav.nav-tabs > li > a[data-toggle="tab"]').click(function(e){
                            if(typeof $(this).parent().find('a').first().attr('id') != 'undefined') {
                                var tab = parseInt($(this).parent().find('a').first().attr('id').match(/^tab(.)*$/)[1]);
                                selectTabDetailView(tab);
                            }
                        });
                    });

                </script>
{/literal}