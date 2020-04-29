

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
{if $bean->aclAccess("edit")}<input title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" class="button primary" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='Contacts'; _form.return_action.value='DetailView'; _form.return_id.value='{$id}'; _form.action.value='EditView';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Edit" id="edit_button" value="{$APP.LBL_EDIT_BUTTON_LABEL}">{/if} 
{if $bean->aclAccess("edit")}<input title="{$APP.LBL_DUPLICATE_BUTTON_TITLE}" accessKey="{$APP.LBL_DUPLICATE_BUTTON_KEY}" class="button" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='Contacts'; _form.return_action.value='DetailView'; _form.isDuplicate.value=true; _form.action.value='EditView'; _form.return_id.value='{$id}';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Duplicate" value="{$APP.LBL_DUPLICATE_BUTTON_LABEL}" id="duplicate_button">{/if} 
{if $bean->aclAccess("delete")}<input title="{$APP.LBL_DELETE_BUTTON_TITLE}" accessKey="{$APP.LBL_DELETE_BUTTON_KEY}" class="button" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='Contacts'; _form.return_action.value='ListView'; _form.action.value='Delete'; if(confirm('{$APP.NTC_DELETE_CONFIRMATION}')) SUGAR.ajaxUI.submitForm(_form); return false;" type="submit" name="Delete" value="{$APP.LBL_DELETE_BUTTON_LABEL}" id="delete_button">{/if} 
{if $bean->aclAccess("edit") && $bean->aclAccess("delete")}<input title="{$APP.LBL_DUP_MERGE}" class="button" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='Contacts'; _form.return_action.value='DetailView'; _form.return_id.value='{$id}'; _form.action.value='Step1'; _form.module.value='MergeRecords';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Merge" value="{$APP.LBL_DUP_MERGE}" id="merge_duplicate_button">{/if} 
<input class="button " id="send_confirm_opt_in_email" title="{$APP.LBL_SEND_CONFIRM_OPT_IN_EMAIL}" onclick="var _form = document.getElementById('formDetailView');_form.return_module.value='Contacts'; _form.return_action.value='DetailView'; _form.return_id.value='{$fields.id.value}'; _form.action.value='sendConfirmOptInEmail'; _form.module.value='Contacts'; _form.module_tab.value='Contacts';_form.submit();" name="send_confirm_opt_in_email" type="button" value="{$APP.LBL_SEND_CONFIRM_OPT_IN_EMAIL}"/>
<input class="button" id="manage_subscriptions_button" title="{$APP.LBL_MANAGE_SUBSCRIPTIONS}" onclick="var _form = document.getElementById('formDetailView');_form.return_module.value='Contacts'; _form.return_action.value='DetailView'; _form.return_id.value='{$fields.id.value}'; _form.action.value='Subscriptions'; _form.module.value='Campaigns'; _form.module_tab.value='Contacts';_form.submit();" name="Manage Subscriptions" type="button" value="{$APP.LBL_MANAGE_SUBSCRIPTIONS}"/>
<input type="button" class="button" onClick="showPopup();" value="{$APP.LBL_PRINT_AS_PDF}"/>
{if !$fields.joomla_account_id.value && $AOP_PORTAL_ENABLED}<input title="{$MOD.LBL_CREATE_PORTAL_USER}" class="button" onclick="var _form = document.getElementById('formDetailView');_form.action.value='createPortalUser';_form.submit();" name="buttonCreatePortalUser" id="createPortalUser_button" type="button" value="{$MOD.LBL_CREATE_PORTAL_USER}"/>{/if}
{if $fields.joomla_account_id.value && !$fields.portal_account_disabled.value && $AOP_PORTAL_ENABLED}<input title="{$MOD.LBL_DISABLE_PORTAL_USER}" class="button" onclick="var _form = document.getElementById('formDetailView');_form.action.value='disablePortalUser';_form.submit();" name="buttonDisablePortalUser" id="disablePortalUser_button" type="button" value="{$MOD.LBL_DISABLE_PORTAL_USER}"/>{/if}
{if $fields.joomla_account_id.value && $fields.portal_account_disabled.value && $AOP_PORTAL_ENABLED}<input title="{$MOD.LBL_ENABLE_PORTAL_USER}" class="button" onclick="var _form = document.getElementById('formDetailView');_form.action.value='enablePortalUser';_form.submit();" name="buttonENablePortalUser" id="enablePortalUser_button" type="button" value="{$MOD.LBL_ENABLE_PORTAL_USER}"/>{/if}
{if $bean->aclAccess("detail")}{if !empty($fields.id.value) && $isAuditEnabled}<input id="btn_view_change_log" title="{$APP.LNK_VIEW_CHANGE_LOG}" class="button" onclick='open_popup("Audit", "600", "400", "&record={$fields.id.value}&module_name=Contacts", true, false,  {ldelim} "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] {rdelim} ); return false;' type="button" value="{$APP.LNK_VIEW_CHANGE_LOG}">{/if}{/if}
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
{sugar_translate label='LBL_CONTACT_INFORMATION' module='Contacts'}
</a>


<a id="xstab0" href="#" class="visible-xs first-tab-xs dropdown-toggle" data-toggle="dropdown">
{sugar_translate label='LBL_CONTACT_INFORMATION' module='Contacts'}
</a>
<ul id="first-tab-menu-xs" class="dropdown-menu">
<li role="presentation">
<a id="tab1" data-toggle="tab" onclick="changeFirstTab(this, 'tab-content-1');">
{sugar_translate label='LBL_CONTACT_INFORMATION' module='Contacts'}
</a>
</li>
<li role="presentation">
<a id="tab2" data-toggle="tab" onclick="changeFirstTab(this, 'tab-content-2');">
{sugar_translate label='LBL_PANEL_ADVANCED' module='Contacts'}
</a>
</li>
</ul>
</li>


<li role="presentation" class="hidden-xs">
<a id="tab1" data-toggle="tab">
{sugar_translate label='LBL_PANEL_ADVANCED' module='Contacts'}
</a>
</li>
{if $config.enable_action_menu and $config.enable_action_menu != false}
<li id="tab-actions" class="dropdown">
<a class="dropdown-toggle" data-toggle="dropdown" href="#">ACTIONS<span class="suitepicon suitepicon-action-caret"></span></a>
<ul id="act" class="dropdown-menu">
<li>{if $bean->aclAccess("edit")}<input title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" class="button primary" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='Contacts'; _form.return_action.value='DetailView'; _form.return_id.value='{$id}'; _form.action.value='EditView';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Edit" id="edit_button" value="{$APP.LBL_EDIT_BUTTON_LABEL}">{/if} </li>
<li>{if $bean->aclAccess("edit")}<input title="{$APP.LBL_DUPLICATE_BUTTON_TITLE}" accessKey="{$APP.LBL_DUPLICATE_BUTTON_KEY}" class="button" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='Contacts'; _form.return_action.value='DetailView'; _form.isDuplicate.value=true; _form.action.value='EditView'; _form.return_id.value='{$id}';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Duplicate" value="{$APP.LBL_DUPLICATE_BUTTON_LABEL}" id="duplicate_button">{/if} </li>
<li>{if $bean->aclAccess("delete")}<input title="{$APP.LBL_DELETE_BUTTON_TITLE}" accessKey="{$APP.LBL_DELETE_BUTTON_KEY}" class="button" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='Contacts'; _form.return_action.value='ListView'; _form.action.value='Delete'; if(confirm('{$APP.NTC_DELETE_CONFIRMATION}')) SUGAR.ajaxUI.submitForm(_form); return false;" type="submit" name="Delete" value="{$APP.LBL_DELETE_BUTTON_LABEL}" id="delete_button">{/if} </li>
<li>{if $bean->aclAccess("edit") && $bean->aclAccess("delete")}<input title="{$APP.LBL_DUP_MERGE}" class="button" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='Contacts'; _form.return_action.value='DetailView'; _form.return_id.value='{$id}'; _form.action.value='Step1'; _form.module.value='MergeRecords';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Merge" value="{$APP.LBL_DUP_MERGE}" id="merge_duplicate_button">{/if} </li>
<li><input class="button " id="send_confirm_opt_in_email" title="{$APP.LBL_SEND_CONFIRM_OPT_IN_EMAIL}" onclick="var _form = document.getElementById('formDetailView');_form.return_module.value='Contacts'; _form.return_action.value='DetailView'; _form.return_id.value='{$fields.id.value}'; _form.action.value='sendConfirmOptInEmail'; _form.module.value='Contacts'; _form.module_tab.value='Contacts';_form.submit();" name="send_confirm_opt_in_email" type="button" value="{$APP.LBL_SEND_CONFIRM_OPT_IN_EMAIL}"/></li>
<li><input class="button" id="manage_subscriptions_button" title="{$APP.LBL_MANAGE_SUBSCRIPTIONS}" onclick="var _form = document.getElementById('formDetailView');_form.return_module.value='Contacts'; _form.return_action.value='DetailView'; _form.return_id.value='{$fields.id.value}'; _form.action.value='Subscriptions'; _form.module.value='Campaigns'; _form.module_tab.value='Contacts';_form.submit();" name="Manage Subscriptions" type="button" value="{$APP.LBL_MANAGE_SUBSCRIPTIONS}"/></li>
<li><input type="button" class="button" onClick="showPopup();" value="{$APP.LBL_PRINT_AS_PDF}"/></li>
<li>{if !$fields.joomla_account_id.value && $AOP_PORTAL_ENABLED}<input title="{$MOD.LBL_CREATE_PORTAL_USER}" class="button" onclick="var _form = document.getElementById('formDetailView');_form.action.value='createPortalUser';_form.submit();" name="buttonCreatePortalUser" id="createPortalUser_button" type="button" value="{$MOD.LBL_CREATE_PORTAL_USER}"/>{/if}</li>
<li>{if $fields.joomla_account_id.value && !$fields.portal_account_disabled.value && $AOP_PORTAL_ENABLED}<input title="{$MOD.LBL_DISABLE_PORTAL_USER}" class="button" onclick="var _form = document.getElementById('formDetailView');_form.action.value='disablePortalUser';_form.submit();" name="buttonDisablePortalUser" id="disablePortalUser_button" type="button" value="{$MOD.LBL_DISABLE_PORTAL_USER}"/>{/if}</li>
<li>{if $fields.joomla_account_id.value && $fields.portal_account_disabled.value && $AOP_PORTAL_ENABLED}<input title="{$MOD.LBL_ENABLE_PORTAL_USER}" class="button" onclick="var _form = document.getElementById('formDetailView');_form.action.value='enablePortalUser';_form.submit();" name="buttonENablePortalUser" id="enablePortalUser_button" type="button" value="{$MOD.LBL_ENABLE_PORTAL_USER}"/>{/if}</li>
<li>{if $bean->aclAccess("detail")}{if !empty($fields.id.value) && $isAuditEnabled}<input id="btn_view_change_log" title="{$APP.LNK_VIEW_CHANGE_LOG}" class="button" onclick='open_popup("Audit", "600", "400", "&record={$fields.id.value}&module_name=Contacts", true, false,  {ldelim} "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] {rdelim} ); return false;' type="button" value="{$APP.LNK_VIEW_CHANGE_LOG}">{/if}{/if}</li>
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



<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_FIRST_NAME' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="varchar" field="first_name"  >

{if !$fields.first_name.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.first_name.value) <= 0}
{assign var="value" value=$fields.first_name.default_value }
{else}
{assign var="value" value=$fields.first_name.value }
{/if} 
<span class="sugar_field" id="{$fields.first_name.name}">{$fields.first_name.value}</span>
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>




<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-2-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_LAST_NAME' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="varchar" field="last_name"  >

{if !$fields.last_name.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.last_name.value) <= 0}
{assign var="value" value=$fields.last_name.default_value }
{else}
{assign var="value" value=$fields.last_name.value }
{/if} 
<span class="sugar_field" id="{$fields.last_name.name}">{$fields.last_name.value}</span>
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


{capture name="label" assign="label"}{sugar_translate label='LBL_OTHER_NAMES' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="varchar" field="other_names_c"  >

{if !$fields.other_names_c.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.other_names_c.value) <= 0}
{assign var="value" value=$fields.other_names_c.default_value }
{else}
{assign var="value" value=$fields.other_names_c.value }
{/if} 
<span class="sugar_field" id="{$fields.other_names_c.name}">{$fields.other_names_c.value}</span>
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>




<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-2-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_TAX_ID' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="varchar" field="tax_id_c"  >

{if !$fields.tax_id_c.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.tax_id_c.value) <= 0}
{assign var="value" value=$fields.tax_id_c.default_value }
{else}
{assign var="value" value=$fields.tax_id_c.value }
{/if} 
<span class="sugar_field" id="{$fields.tax_id_c.name}">{$fields.tax_id_c.value}</span>
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


{capture name="label" assign="label"}{sugar_translate label='LBL_CLIENT_ID' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="varchar" field="client_id_c"  >

{if !$fields.client_id_c.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.client_id_c.value) <= 0}
{assign var="value" value=$fields.client_id_c.default_value }
{else}
{assign var="value" value=$fields.client_id_c.value }
{/if} 
<span class="sugar_field" id="{$fields.client_id_c.name}">{$fields.client_id_c.value}</span>
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>




<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-2-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_CLIENT_SINCE' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="date" field="client_since_c"  >

{if !$fields.client_since_c.hidden}
{counter name="panelFieldCount" print=false}


{if strlen($fields.client_since_c.value) <= 0}
{assign var="value" value=$fields.client_since_c.default_value }
{else}
{assign var="value" value=$fields.client_since_c.value }
{/if}
<span class="sugar_field" id="{$fields.client_since_c.name}">{$value}</span>
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


{capture name="label" assign="label"}{sugar_translate label='LBL_GENDER' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="enum" field="gender_c"  >

{if !$fields.gender_c.hidden}
{counter name="panelFieldCount" print=false}


{if is_string($fields.gender_c.options)}
<input type="hidden" class="sugar_field" id="{$fields.gender_c.name}" value="{ $fields.gender_c.options }">
{ $fields.gender_c.options }
{else}
<input type="hidden" class="sugar_field" id="{$fields.gender_c.name}" value="{ $fields.gender_c.value }">
{ $fields.gender_c.options[$fields.gender_c.value]}
{/if}
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>




<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-2-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_BRANCH' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="relate" field="branch_c"  >

{if !$fields.branch_c.hidden}
{counter name="panelFieldCount" print=false}

{if !empty($fields.bran_branches_id_c.value)}
{capture assign="detail_url"}index.php?module=bran_Branches&action=DetailView&record={$fields.bran_branches_id_c.value}{/capture}
<a href="{sugar_ajax_url url=$detail_url}">{/if}
<span id="bran_branches_id_c" class="sugar_field" data-id-value="{$fields.bran_branches_id_c.value}">{$fields.branch_c.value}</span>
{if !empty($fields.bran_branches_id_c.value)}</a>{/if}
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


{capture name="label" assign="label"}{sugar_translate label='LBL_OFFICE_PHONE' module='Contacts'}{/capture}
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




<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-2-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_MOBILE_PHONE' module='Contacts'}{/capture}
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


{capture name="label" assign="label"}{sugar_translate label='LBL_HOME_PHONE' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="phone" field="phone_home"  class="phone">

{if !$fields.phone_home.hidden}
{counter name="panelFieldCount" print=false}

{if !empty($fields.phone_home.value)}
{assign var="phone_value" value=$fields.phone_home.value }
{sugar_phone value=$phone_value usa_format="0"}
{/if}
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>




<div class="col-xs-12 col-sm-6 detail-view-row-item">
</div>

<div class="clear"></div>
</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_BIRTHDATE' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="date" field="birthdate"  >

{if !$fields.birthdate.hidden}
{counter name="panelFieldCount" print=false}


{if strlen($fields.birthdate.value) <= 0}
{assign var="value" value=$fields.birthdate.default_value }
{else}
{assign var="value" value=$fields.birthdate.value }
{/if}
<span class="sugar_field" id="{$fields.birthdate.name}">{$value}</span>
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>




<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-2-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_RELATION_OFFICER' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="varchar" field="relation_officer_c"  >

{if !$fields.relation_officer_c.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.relation_officer_c.value) <= 0}
{assign var="value" value=$fields.relation_officer_c.default_value }
{else}
{assign var="value" value=$fields.relation_officer_c.value }
{/if} 
<span class="sugar_field" id="{$fields.relation_officer_c.name}">{$fields.relation_officer_c.value}</span>
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


{capture name="label" assign="label"}{sugar_translate label='LBL_EMPLOYER' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="varchar" field="employer_c"  >

{if !$fields.employer_c.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.employer_c.value) <= 0}
{assign var="value" value=$fields.employer_c.default_value }
{else}
{assign var="value" value=$fields.employer_c.value }
{/if} 
<span class="sugar_field" id="{$fields.employer_c.name}">{$fields.employer_c.value}</span>
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>




<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-2-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_RM_CODE' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="varchar" field="rm_code_c"  >

{if !$fields.rm_code_c.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.rm_code_c.value) <= 0}
{assign var="value" value=$fields.rm_code_c.default_value }
{else}
{assign var="value" value=$fields.rm_code_c.value }
{/if} 
<span class="sugar_field" id="{$fields.rm_code_c.name}">{$fields.rm_code_c.value}</span>
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


{capture name="label" assign="label"}{sugar_translate label='LBL_TITLE' module='Contacts'}{/capture}
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


{capture name="label" assign="label"}{sugar_translate label='LBL_DEPARTMENT' module='Contacts'}{/capture}
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

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_ACCOUNT_NAME' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="relate" field="account_name"  >

{if !$fields.account_name.hidden}
{counter name="panelFieldCount" print=false}

{if !empty($fields.account_id.value)}
{capture assign="detail_url"}index.php?module=Accounts&action=DetailView&record={$fields.account_id.value}{/capture}
<a href="{sugar_ajax_url url=$detail_url}">{/if}
<span id="account_id" class="sugar_field" data-id-value="{$fields.account_id.value}">{$fields.account_name.value}</span>
{if !empty($fields.account_id.value)}</a>{/if}
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>




<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-2-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_FAX_PHONE' module='Contacts'}{/capture}
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


{capture name="label" assign="label"}{sugar_translate label='LBL_EMAIL_ADDRESS' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="varchar" field="email1"  >

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




<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-2-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_SEGMENT' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="varchar" field="segment_c"  >

{if !$fields.segment_c.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.segment_c.value) <= 0}
{assign var="value" value=$fields.segment_c.default_value }
{else}
{assign var="value" value=$fields.segment_c.value }
{/if} 
<span class="sugar_field" id="{$fields.segment_c.name}">{$fields.segment_c.value}</span>
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


{capture name="label" assign="label"}{sugar_translate label='LBL_PRIMARY_ADDRESS' module='Contacts'}{/capture}
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


{capture name="label" assign="label"}{sugar_translate label='LBL_ALTERNATE_ADDRESS' module='Contacts'}{/capture}
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


{capture name="label" assign="label"}{sugar_translate label='LBL_DESCRIPTION' module='Contacts'}{/capture}
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



<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_PHOTO' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="image" field="photo"  >

{if !$fields.photo.hidden}
{counter name="panelFieldCount" print=false}

<span class="sugar_field" id="{$fields.photo.name}">
<img src="index.php?entryPoint=download&id={$fields.id.value}_{$fields.photo.name}{$fields.width.value}&type={$module}" style="max-width: {if !$vardef.width}160{else}200{/if}px;" height="{if !$vardef.height}160{else}50{/if}">
</span>
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>




<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-2-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_ASSIGNED_TO_NAME' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="relate" field="assigned_user_name"  >

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


{capture name="label" assign="label"}{sugar_translate label='LBL_PRIMARY_ID_NUMBER' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="varchar" field="primary_id_number_c"  >

{if !$fields.primary_id_number_c.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.primary_id_number_c.value) <= 0}
{assign var="value" value=$fields.primary_id_number_c.default_value }
{else}
{assign var="value" value=$fields.primary_id_number_c.value }
{/if} 
<span class="sugar_field" id="{$fields.primary_id_number_c.name}">{$fields.primary_id_number_c.value}</span>
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>




<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-2-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_PRIMARY_ID_TYPE' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="varchar" field="primary_id_type_c"  >

{if !$fields.primary_id_type_c.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.primary_id_type_c.value) <= 0}
{assign var="value" value=$fields.primary_id_type_c.default_value }
{else}
{assign var="value" value=$fields.primary_id_type_c.value }
{/if} 
<span class="sugar_field" id="{$fields.primary_id_type_c.name}">{$fields.primary_id_type_c.value}</span>
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


{capture name="label" assign="label"}{sugar_translate label='LBL_MOTHER_MAIDEN_NAME' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="varchar" field="mother_maiden_name_c"  >

{if !$fields.mother_maiden_name_c.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.mother_maiden_name_c.value) <= 0}
{assign var="value" value=$fields.mother_maiden_name_c.default_value }
{else}
{assign var="value" value=$fields.mother_maiden_name_c.value }
{/if} 
<span class="sugar_field" id="{$fields.mother_maiden_name_c.name}">{$fields.mother_maiden_name_c.value}</span>
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>




<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-2-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_OCCUPATION' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="varchar" field="occupation_c"  >

{if !$fields.occupation_c.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.occupation_c.value) <= 0}
{assign var="value" value=$fields.occupation_c.default_value }
{else}
{assign var="value" value=$fields.occupation_c.value }
{/if} 
<span class="sugar_field" id="{$fields.occupation_c.name}">{$fields.occupation_c.value}</span>
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


{capture name="label" assign="label"}{sugar_translate label='LBL_LINE_OF_BUSINESS' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="varchar" field="line_of_business_c"  >

{if !$fields.line_of_business_c.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.line_of_business_c.value) <= 0}
{assign var="value" value=$fields.line_of_business_c.default_value }
{else}
{assign var="value" value=$fields.line_of_business_c.value }
{/if} 
<span class="sugar_field" id="{$fields.line_of_business_c.name}">{$fields.line_of_business_c.value}</span>
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>




<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-2-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_LEAD_SOURCE' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="enum" field="lead_source"  >

{if !$fields.lead_source.hidden}
{counter name="panelFieldCount" print=false}


{if is_string($fields.lead_source.options)}
<input type="hidden" class="sugar_field" id="{$fields.lead_source.name}" value="{ $fields.lead_source.options }">
{ $fields.lead_source.options }
{else}
<input type="hidden" class="sugar_field" id="{$fields.lead_source.name}" value="{ $fields.lead_source.value }">
{ $fields.lead_source.options[$fields.lead_source.value]}
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


{capture name="label" assign="label"}{sugar_translate label='LBL_SPOUSE' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="varchar" field="spouse_c"  >

{if !$fields.spouse_c.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.spouse_c.value) <= 0}
{assign var="value" value=$fields.spouse_c.default_value }
{else}
{assign var="value" value=$fields.spouse_c.value }
{/if} 
<span class="sugar_field" id="{$fields.spouse_c.name}">{$fields.spouse_c.value}</span>
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>




<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-2-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_HOBBY' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="varchar" field="hobby_c"  >

{if !$fields.hobby_c.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.hobby_c.value) <= 0}
{assign var="value" value=$fields.hobby_c.default_value }
{else}
{assign var="value" value=$fields.hobby_c.value }
{/if} 
<span class="sugar_field" id="{$fields.hobby_c.name}">{$fields.hobby_c.value}</span>
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


{capture name="label" assign="label"}{sugar_translate label='LBL_INTEREST_AREA' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="varchar" field="interest_area_c"  >

{if !$fields.interest_area_c.hidden}
{counter name="panelFieldCount" print=false}

{if strlen($fields.interest_area_c.value) <= 0}
{assign var="value" value=$fields.interest_area_c.default_value }
{else}
{assign var="value" value=$fields.interest_area_c.value }
{/if} 
<span class="sugar_field" id="{$fields.interest_area_c.name}">{$fields.interest_area_c.value}</span>
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>




<div class="col-xs-12 col-sm-6 detail-view-row-item">
</div>

<div class="clear"></div>
</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-1-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_REPORTS_TO' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="relate" field="report_to_name"  >

{if !$fields.report_to_name.hidden}
{counter name="panelFieldCount" print=false}

{if !empty($fields.reports_to_id.value)}
{capture assign="detail_url"}index.php?module=Contacts&action=DetailView&record={$fields.reports_to_id.value}{/capture}
<a href="{sugar_ajax_url url=$detail_url}">{/if}
<span id="reports_to_id" class="sugar_field" data-id-value="{$fields.reports_to_id.value}">{$fields.report_to_name.value}</span>
{if !empty($fields.reports_to_id.value)}</a>{/if}
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
</div>


</div>




<div class="col-xs-12 col-sm-6 detail-view-row-item">


<div class="col-xs-12 col-sm-4 label col-2-label">


{capture name="label" assign="label"}{sugar_translate label='LBL_CAMPAIGN' module='Contacts'}{/capture}
{$label|strip_semicolon}:
</div>


<div class="col-xs-12 col-sm-8 detail-view-field inlineEdit" type="relate" field="campaign_name"  >

{if !$fields.campaign_name.hidden}
{counter name="panelFieldCount" print=false}

{if !empty($fields.campaign_id.value)}
{capture assign="detail_url"}index.php?module=Campaigns&action=DetailView&record={$fields.campaign_id.value}{/capture}
<a href="{sugar_ajax_url url=$detail_url}">{/if}
<span id="campaign_id" class="sugar_field" data-id-value="{$fields.campaign_id.value}">{$fields.campaign_name.value}</span>
{if !empty($fields.campaign_id.value)}</a>{/if}
{/if}

<div class="inlineEditIcon col-xs-hidden">
<span class="suitepicon suitepicon-action-edit"></span>
</div>
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