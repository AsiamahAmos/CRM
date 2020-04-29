

{assign var=preForm value="<table width='100%' border='1' cellspacing='0' cellpadding='0'><tr><td><table width='100%'><tr><td>"}
{assign var=displayPreform value=false}
{if isset($bean->lead_id) && !empty($bean->lead_id)}
{assign var=displayPreform value=true}
{assign var=preForm value=$preForm|cat:$MOD.LBL_CONVERTED_LEAD}
{assign var=preForm value=$preForm|cat:"&nbsp;<a href='index.php?module=Leads&action=DetailView&record="}
{assign var=preForm value=$preForm|cat:$bean->lead_id}
{assign var=preForm value=$preForm|cat:"'>"}
{assign var=preForm value=$preForm|cat:$lead->name}
{assign var=preForm value=$preForm|cat:"</a>"}
{/if}
{assign var=preForm value=$preForm|cat:"</td><td>"}
{assign var=preForm value=$preForm|cat:"</td></tr></table></td></tr></table>"}
{if $displayPreform}
{$preForm}
<br>
{/if}

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
<input type="hidden" name="prospect_id" value="{$fields.id.value}">
{if !$config.enable_action_menu}
<div class="buttons">
{if $bean->aclAccess("edit")}<input title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" class="button primary" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='Prospects'; _form.return_action.value='DetailView'; _form.return_id.value='{$id}'; _form.action.value='EditView';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Edit" id="edit_button" value="{$APP.LBL_EDIT_BUTTON_LABEL}">{/if} 
{if $bean->aclAccess("edit")}<input title="{$APP.LBL_DUPLICATE_BUTTON_TITLE}" accessKey="{$APP.LBL_DUPLICATE_BUTTON_KEY}" class="button" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='Prospects'; _form.return_action.value='DetailView'; _form.isDuplicate.value=true; _form.action.value='EditView'; _form.return_id.value='{$id}';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Duplicate" value="{$APP.LBL_DUPLICATE_BUTTON_LABEL}" id="duplicate_button">{/if} 
{if $bean->aclAccess("delete")}<input title="{$APP.LBL_DELETE_BUTTON_TITLE}" accessKey="{$APP.LBL_DELETE_BUTTON_KEY}" class="button" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='Prospects'; _form.return_action.value='ListView'; _form.action.value='Delete'; if(confirm('{$APP.NTC_DELETE_CONFIRMATION}')) SUGAR.ajaxUI.submitForm(_form); return false;" type="submit" name="Delete" value="{$APP.LBL_DELETE_BUTTON_LABEL}" id="delete_button">{/if} 
<input class="button " id="send_confirm_opt_in_email" title="{$APP.LBL_SEND_CONFIRM_OPT_IN_EMAIL}" onclick="var _form = document.getElementById('formDetailView');_form.return_module.value='Prospects'; _form.return_action.value='DetailView'; _form.return_id.value='{$fields.id.value}'; _form.action.value='sendConfirmOptInEmail'; _form.module.value='Prospects'; _form.module_tab.value='Prospects';_form.submit();" name="send_confirm_opt_in_email" type="button" value="{$APP.LBL_SEND_CONFIRM_OPT_IN_EMAIL}"/>
<input class="button" name="CONVERT_LEAD_BTN" id="convert_target_button" title="{$MOD.LBL_CONVERT_BUTTON_TITLE}" onclick="var _form = document.getElementById('formDetailView');_form.return_module.value='Prospects'; _form.return_action.value='DetailView'; _form.return_id.value='{$fields.id.value}';_form.module.value='Leads';_form.action.value='EditView';_form.submit();" type="button" value="{$MOD.LBL_CONVERT_BUTTON_LABEL}"/>
<input class="button" id="manage_subscriptions_button" name="Manage Subscriptions" title="{$APP.LBL_MANAGE_SUBSCRIPTIONS}" onclick="var _form = document.getElementById('formDetailView');_form.return_module.value='Prospects'; _form.return_action.value='DetailView'; _form.return_id.value='{$fields.id.value}'; _form.action.value='Subscriptions'; _form.module.value='Campaigns';_form.submit();" type="button" value="{$APP.LBL_MANAGE_SUBSCRIPTIONS}"/>
{if $bean->aclAccess("detail")}{if !empty($fields.id.value) && $isAuditEnabled}<input id="btn_view_change_log" title="{$APP.LNK_VIEW_CHANGE_LOG}" class="button" onclick='open_popup("Audit", "600", "400", "&record={$fields.id.value}&module_name=Prospects", true, false,  {ldelim} "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] {rdelim} ); return false;' type="button" value="{$APP.LNK_VIEW_CHANGE_LOG}">{/if}{/if}
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


<li role="presentation" class="active">
<a id="tab0" data-toggle="tab" class="hidden-xs">
{sugar_translate label='LBL_PROSPECT_INFORMATION' module='Prospects'}
</a>


<a id="xstab0" href="#" class="visible-xs first-tab-xs dropdown-toggle" data-toggle="dropdown">
{sugar_translate label='LBL_PROSPECT_INFORMATION' module='Prospects'}
</a>
<ul id="first-tab-menu-xs" class="dropdown-menu">
<li role="presentation">
<a id="tab1" data-toggle="tab" onclick="changeFirstTab(this, 'tab-content-1');">
{sugar_translate label='LBL_PROSPECT_INFORMATION' module='Prospects'}
</a>
</li>
<li role="presentation">
<a id="tab2" data-toggle="tab" onclick="changeFirstTab(this, 'tab-content-2');">
{sugar_translate label='LBL_MORE_INFORMATION' module='Prospects'}
</a>
</li>
<li role="presentation">
<a id="tab3" data-toggle="tab" onclick="changeFirstTab(this, 'tab-content-3');">
{sugar_translate label='LBL_PANEL_ASSIGNMENT' module='Prospects'}
</a>
</li>
</ul>
</li>


<li role="presentation" class="hidden-xs">
<a id="tab1" data-toggle="tab">
{sugar_translate label='LBL_MORE_INFORMATION' module='Prospects'}
</a>
</li>


<li role="presentation" class="hidden-xs">
<a id="tab2" data-toggle="tab">
{sugar_translate label='LBL_PANEL_ASSIGNMENT' module='Prospects'}
</a>
</li>
{if $config.enable_action_menu and $config.enable_action_menu != false}
<li id="tab-actions" class="dropdown">
<a class="dropdown-toggle" data-toggle="dropdown" href="#">ACTIONS<span class="suitepicon suitepicon-action-caret"></span></a>
<ul id="act" class="dropdown-menu">
<li>{if $bean->aclAccess("edit")}<input title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" class="button primary" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='Prospects'; _form.return_action.value='DetailView'; _form.return_id.value='{$id}'; _form.action.value='EditView';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Edit" id="edit_button" value="{$APP.LBL_EDIT_BUTTON_LABEL}">{/if} </li>
<li>{if $bean->aclAccess("edit")}<input title="{$APP.LBL_DUPLICATE_BUTTON_TITLE}" accessKey="{$APP.LBL_DUPLICATE_BUTTON_KEY}" class="button" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='Prospects'; _form.return_action.value='DetailView'; _form.isDuplicate.value=true; _form.action.value='EditView'; _form.return_id.value='{$id}';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Duplicate" value="{$APP.LBL_DUPLICATE_BUTTON_LABEL}" id="duplicate_button">{/if} </li>
<li>{if $bean->aclAccess("delete")}<input title="{$APP.LBL_DELETE_BUTTON_TITLE}" accessKey="{$APP.LBL_DELETE_BUTTON_KEY}" class="button" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='Prospects'; _form.return_action.value='ListView'; _form.action.value='Delete'; if(confirm('{$APP.NTC_DELETE_CONFIRMATION}')) SUGAR.ajaxUI.submitForm(_form); return false;" type="submit" name="Delete" value="{$APP.LBL_DELETE_BUTTON_LABEL}" id="delete_button">{/if} </li>
<li><input class="button " id="send_confirm_opt_in_email" title="{$APP.LBL_SEND_CONFIRM_OPT_IN_EMAIL}" onclick="var _form = document.getElementById('formDetailView');_form.return_module.value='Prospects'; _form.return_action.value='DetailView'; _form.return_id.value='{$fields.id.value}'; _form.action.value='sendConfirmOptInEmail'; _form.module.value='Prospects'; _form.module_tab.value='Prospects';_form.submit();" name="send_confirm_opt_in_email" type="button" value="{$APP.LBL_SEND_CONFIRM_OPT_IN_EMAIL}"/></li>
<li><input class="button" name="CONVERT_LEAD_BTN" id="convert_target_button" title="{$MOD.LBL_CONVERT_BUTTON_TITLE}" onclick="var _form = document.getElementById('formDetailView');_form.return_module.value='Prospects'; _form.return_action.value='DetailView'; _form.return_id.value='{$fields.id.value}';_form.module.value='Leads';_form.action.value='EditView';_form.submit();" type="button" value="{$MOD.LBL_CONVERT_BUTTON_LABEL}"/></li>
<li><input class="button" id="manage_subscriptions_button" name="Manage Subscriptions" title="{$APP.LBL_MANAGE_SUBSCRIPTIONS}" onclick="var _form = document.getElementById('formDetailView');_form.return_module.value='Prospects'; _form.return_action.value='DetailView'; _form.return_id.value='{$fields.id.value}'; _form.action.value='Subscriptions'; _form.module.value='Campaigns';_form.submit();" type="button" value="{$APP.LBL_MANAGE_SUBSCRIPTIONS}"/></li>
<li>{if $bean->aclAccess("detail")}{if !empty($fields.id.value) && $isAuditEnabled}<input id="btn_view_change_log" title="{$APP.LNK_VIEW_CHANGE_LOG}" class="button" onclick='open_popup("Audit", "600", "400", "&record={$fields.id.value}&module_name=Prospects", true, false,  {ldelim} "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] {rdelim} ); return false;' type="button" value="{$APP.LNK_VIEW_CHANGE_LOG}">{/if}{/if}</li>
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

<div class="tab-content">

<div class="tab-pane-NOBOOTSTRAPTOGGLER active fade in" id='tab-content-0'>





<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_NAME' module='Prospects'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field inlineEdit" type="fullname" field="full_name" colspan='3' >

{if !$fields.full_name.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.full_name.value) <= 0}
{assign var="value" value=$fields.full_name.default_value }
{else}
{assign var="value" value=$fields.full_name.value }
{/if}
<form name="vcard" action="index.php" style="display: inline;">
<span id='{$fields.full_name.name}'>{$fields.full_name.value}</span>
&nbsp;&nbsp;
<input type="hidden" name="action" value="vCard" />
<input type="hidden" name="record" value="{$fields.id.value}" />
<input type="hidden" name="module" value="{$module}" />
<input type="hidden" name="to_pdf" value="true" />
<span class="id-ff">
<button type="submit" name="vCardButton" id="btn_vCardButton" class="vcard" value="{$APP.LBL_VCARD}" title="{$APP.LBL_VCARD}" class="button"><span class="suitepicon suitepicon-action-vcard"></span></button>
</span>
</form>
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_TITLE' module='Prospects'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="varchar" field="title"  >

{if !$fields.title.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.title.value) <= 0}
{assign var="value" value=$fields.title.default_value }
{else}
{assign var="value" value=$fields.title.value }
{/if} 
<span class="sugar_field" id="{$fields.title.name}">{$fields.title.value}</span>
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>




<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-2-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_OFFICE_PHONE' module='Prospects'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="phone" field="phone_work"  class="phone">

{if !$fields.phone_work.hidden}
{counter name="panelFieldCount" print=false}

{if !empty($fields.phone_work.value)}
{assign var="phone_value" value=$fields.phone_work.value }
{sugar_phone value=$phone_value usa_format="0"}
{/if}
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_DEPARTMENT' module='Prospects'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="varchar" field="department"  >

{if !$fields.department.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.department.value) <= 0}
{assign var="value" value=$fields.department.default_value }
{else}
{assign var="value" value=$fields.department.value }
{/if} 
<span class="sugar_field" id="{$fields.department.name}">{$fields.department.value}</span>
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>




<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-2-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_MOBILE_PHONE' module='Prospects'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="phone" field="phone_mobile"  class="phone">

{if !$fields.phone_mobile.hidden}
{counter name="panelFieldCount" print=false}

{if !empty($fields.phone_mobile.value)}
{assign var="phone_value" value=$fields.phone_mobile.value }
{sugar_phone value=$phone_value usa_format="0"}
{/if}
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_ACCOUNT_NAME' module='Prospects'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="varchar" field="account_name"  >

{if !$fields.account_name.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.account_name.value) <= 0}
{assign var="value" value=$fields.account_name.default_value }
{else}
{assign var="value" value=$fields.account_name.value }
{/if} 
<span class="sugar_field" id="{$fields.account_name.name}">{$fields.account_name.value}</span>
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>




<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-2-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_FAX_PHONE' module='Prospects'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="phone" field="phone_fax"  class="phone">

{if !$fields.phone_fax.hidden}
{counter name="panelFieldCount" print=false}

{if !empty($fields.phone_fax.value)}
{assign var="phone_value" value=$fields.phone_fax.value }
{sugar_phone value=$phone_value usa_format="0"}
{/if}
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_PRIMARY_ADDRESS' module='Prospects'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="varchar" field="primary_address_street"  >

{if !$fields.primary_address_street.hidden}
{counter name="panelFieldCount" print=false}

<table border='0' cellpadding='0' cellspacing='0' width='100%'>
<tr>
<td width='99%'>
<input type="hidden" class="sugar_field" id="primary_address_street"
value="{$fields.primary_address_street.value|escape:'html_entity_decode'|escape:'html'|url2html|nl2br}">
<input type="hidden" class="sugar_field" id="primary_address_city"
value="{$fields.primary_address_city.value|escape:'html_entity_decode'|escape:'html'|url2html|nl2br}">
<input type="hidden" class="sugar_field" id="primary_address_state"
value="{$fields.primary_address_state.value|escape:'html_entity_decode'|escape:'html'|url2html|nl2br}">
<input type="hidden" class="sugar_field" id="primary_address_country"
value="{$fields.primary_address_country.value|escape:'html_entity_decode'|escape:'html'|url2html|nl2br}">
<input type="hidden" class="sugar_field" id="primary_address_postalcode"
value="{$fields.primary_address_postalcode.value|escape:'html_entity_decode'|escape:'html'|url2html|nl2br}">
{$fields.primary_address_street.value|escape:'html_entity_decode'|escape:'html'|url2html|nl2br}
<br>
{$fields.primary_address_city.value|escape:'html_entity_decode'|escape:'html'|url2html|nl2br} {$fields.primary_address_state.value|escape:'html_entity_decode'|strip_tags|url2html|nl2br}
&nbsp;&nbsp;{$fields.primary_address_postalcode.value|escape:'html_entity_decode'|strip_tags|url2html|nl2br}
<br>
{$fields.primary_address_country.value|escape:'html_entity_decode'|escape:'html'|url2html|nl2br}
</td>
<td class='dataField' width='1%'>
{$custom_code_primary}
</td>
</tr>
</table>
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>




<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-2-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_ALTERNATE_ADDRESS' module='Prospects'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="varchar" field="alt_address_street"  >

{if !$fields.alt_address_street.hidden}
{counter name="panelFieldCount" print=false}

<table border='0' cellpadding='0' cellspacing='0' width='100%'>
<tr>
<td width='99%'>
<input type="hidden" class="sugar_field" id="alt_address_street"
value="{$fields.alt_address_street.value|escape:'html_entity_decode'|escape:'html'|url2html|nl2br}">
<input type="hidden" class="sugar_field" id="alt_address_city"
value="{$fields.alt_address_city.value|escape:'html_entity_decode'|escape:'html'|url2html|nl2br}">
<input type="hidden" class="sugar_field" id="alt_address_state"
value="{$fields.alt_address_state.value|escape:'html_entity_decode'|escape:'html'|url2html|nl2br}">
<input type="hidden" class="sugar_field" id="alt_address_country"
value="{$fields.alt_address_country.value|escape:'html_entity_decode'|escape:'html'|url2html|nl2br}">
<input type="hidden" class="sugar_field" id="alt_address_postalcode"
value="{$fields.alt_address_postalcode.value|escape:'html_entity_decode'|escape:'html'|url2html|nl2br}">
{$fields.alt_address_street.value|escape:'html_entity_decode'|escape:'html'|url2html|nl2br}
<br>
{$fields.alt_address_city.value|escape:'html_entity_decode'|escape:'html'|url2html|nl2br} {$fields.alt_address_state.value|escape:'html_entity_decode'|strip_tags|url2html|nl2br}
&nbsp;&nbsp;{$fields.alt_address_postalcode.value|escape:'html_entity_decode'|strip_tags|url2html|nl2br}
<br>
{$fields.alt_address_country.value|escape:'html_entity_decode'|escape:'html'|url2html|nl2br}
</td>
<td class='dataField' width='1%'>
{$custom_code_alt}
</td>
</tr>
</table>
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_EMAIL_ADDRESS' module='Prospects'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field inlineEdit" type="varchar" field="email1" colspan='3' >

{if !$fields.email1.hidden}
{counter name="panelFieldCount" print=false}
<span id='email1_span'>
{$fields.email1.value}
</span>
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_DESCRIPTION' module='Prospects'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field inlineEdit" type="text" field="description" colspan='3' >

{if !$fields.description.hidden}
{counter name="panelFieldCount" print=false}

<span class="sugar_field" id="{$fields.description.name|escape:'html'|url2html|nl2br}">{$fields.description.value|escape:'html'|escape:'html_entity_decode'|url2html|nl2br}</span>
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_ASSIGNED_TO_NAME' module='Prospects'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field inlineEdit" type="relate" field="assigned_user_name" colspan='3' >

{if !$fields.assigned_user_name.hidden}
{counter name="panelFieldCount" print=false}

<span id="assigned_user_id" class="sugar_field" data-id-value="{$fields.assigned_user_id.value}">{$fields.assigned_user_name.value}</span>
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>

</div>
                    </div>
<div class="tab-pane-NOBOOTSTRAPTOGGLER fade" id='tab-content-1'>





<div class="row detail-view-row">



<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_EMAIL_OPT_OUT' module='Prospects'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="bool" field="email_opt_out"  >

{if !$fields.email_opt_out.hidden}
{counter name="panelFieldCount" print=false}

{if strval($fields.email_opt_out.value) == "1" || strval($fields.email_opt_out.value) == "yes" || strval($fields.email_opt_out.value) == "on"} 
{assign var="checked" value='checked="checked"'}
{else}
{assign var="checked" value=""}
{/if}
<input type="checkbox" class="checkbox" name="{$fields.email_opt_out.name}" id="{$fields.email_opt_out.name}" value="$fields.email_opt_out.value" disabled="true" {$checked}>
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>




<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-2-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_DO_NOT_CALL' module='Prospects'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="bool" field="do_not_call"  >

{if !$fields.do_not_call.hidden}
{counter name="panelFieldCount" print=false}

{if strval($fields.do_not_call.value) == "1" || strval($fields.do_not_call.value) == "yes" || strval($fields.do_not_call.value) == "on"} 
{assign var="checked" value='checked="checked"'}
{else}
{assign var="checked" value=""}
{/if}
<input type="checkbox" class="checkbox" name="{$fields.do_not_call.name}" id="{$fields.do_not_call.name}" value="$fields.do_not_call.value" disabled="true" {$checked}>
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>

</div>
                    </div>
<div class="tab-pane-NOBOOTSTRAPTOGGLER fade" id='tab-content-2'>





<div class="row detail-view-row">



<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_DATE_MODIFIED' module='Prospects'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field " type="relate" field="modified_by_name"  >

{if !$fields.modified_by_name.hidden}
{counter name="panelFieldCount" print=false}
<span id="modified_by_name" class="sugar_field">{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}&nbsp;</span>
{/if}

</div>


</div>




<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-2-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_DATE_ENTERED' module='Prospects'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field " type="relate" field="created_by_name"  >

{if !$fields.created_by_name.hidden}
{counter name="panelFieldCount" print=false}
<span id="created_by_name" class="sugar_field">{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}&nbsp;</span>
{/if}

</div>


</div>

</div>
                    </div>
</div>

<div class="panel-content">
<div>&nbsp;</div>






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