
<div>&nbsp;</div>
<span class="color">{$ERROR}</span>
<div class="edit-view-row-item">
<input type="hidden" name="convert_create_Accounts" id="convert_create_Accounts"
{if ($def.required && empty($def.select)) || (!empty($def.default_action) && $def.default_action == "create")} value="true" {/if}/>
<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">
<input type="hidden" name="case_id" value="{$smarty.request.case_id}">
<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">
<input type="hidden" name="email_id" value="{$smarty.request.email_id}">
<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">
{if $def.required }
<script type="text/javascript">
                        mod_array.push('Accounts');//Bug#50590 add all required modules to mod_array
                    </script>
{/if}
{if !$def.required || !empty($def.select)}
<input class="checkbox" type="checkbox" name="newAccounts" id="newAccounts"
onclick="toggleDisplay('createAccounts');if (typeof(addRemoveDropdownElement) == 'function') addRemoveDropdownElement('Accounts');{if !empty($def.select)}toggleAccountsSelect();{/if}">
<script type="text/javascript">
                                        {if !empty($def.select)}
                    toggleAccountsSelect = function () {ldelim}
                        var inputs = document.getElementById('selectAccounts').getElementsByTagName('input');
                        for (var i in inputs) {
                            ldelim}inputs[i].disabled = !inputs[i].disabled;{rdelim}
                    var buttons = document.getElementById('selectAccounts').getElementsByTagName('button');
                    for (var i in buttons) {
                        ldelim}buttons[i].disabled = !buttons[i].disabled;{rdelim}
                    {rdelim}
                    {/if}
                                        {if !empty($def.default_action) && $def.default_action == "create"}
                    {if $lead_conv_activity_opt == 'move' || $lead_conv_activity_opt == 'copy' || $lead_conv_activity_opt == ''}
                    YAHOO.util.Event.onContentReady('lead_conv_ac_op_sel', function () {ldelim}
                        {else}
                        YAHOO.util.Event.onContentReady('createAccounts', function () {ldelim}
                            {/if}
                            toggleDisplay('createAccounts');
                            document.getElementById('newAccounts').checked = true;
                            if (typeof(addRemoveDropdownElement) == 'function')
                                addRemoveDropdownElement('Accounts');
                                                        {if !empty($def.select)}
                            toggleAccountsSelect();
                            {/if}
                                                        {rdelim});
                    {/if}
                    {/if}
                </script>
{sugar_translate label='LNK_NEW_ACCOUNT' module='Leads'}
{if !empty($def.select)}
{sugar_translate label='LNK_SELECT_ACCOUNTS' module='Leads'}
{if $def.required }
<span class="required">*</span>
{/if}
<span id="selectAccounts">

<input type="text" name="{$contact_def.account_name.name}" class="sqsEnabled" tabindex="" id="{$contact_def.account_name.name}" size="" value="{$contact_def.account_name.value}" title='' autocomplete="off"  	 >
<input type="hidden" name="{$contact_def.account_name.id_name}" 
id="{$contact_def.account_name.id_name}" 
value="{$contact_def.account_id.value}">
<span class="id-ff multiple">
<button type="button" name="btn_{$contact_def.account_name.name}" id="btn_{$contact_def.account_name.name}" tabindex="" title="{sugar_translate label="LBL_ACCESSKEY_SELECT_ACCOUNTS_TITLE"}" class="button firstChild" value="{sugar_translate label="LBL_ACCESSKEY_SELECT_ACCOUNTS_LABEL"}"
onclick='open_popup(
"{$contact_def.account_name.module}", 
600, 
400, 
"{$initialFilter}", 
true, 
false, 
{literal}{"call_back_function":"set_return_lead_conv","form_name":"ConvertLead","field_to_name_array":{"id":"account_id","name":"account_name"}}{/literal}, 
"single", 
true
);' ><span class="suitepicon suitepicon-action-select"></span></button><button type="button" name="btn_clr_{$contact_def.account_name.name}" id="btn_clr_{$contact_def.account_name.name}" tabindex="" title="{sugar_translate label="LBL_ACCESSKEY_CLEAR_ACCOUNTS_TITLE"}"  class="button lastChild"
onclick="SUGAR.clearRelateField(this.form, '{$contact_def.account_name.name}', '{$contact_def.account_name.id_name}');"  value="{sugar_translate label="LBL_ACCESSKEY_CLEAR_ACCOUNTS_LABEL"}" ><span class="suitepicon suitepicon-action-clear"></span></button>
</span>
<script type="text/javascript">
SUGAR.util.doWhen(
		"typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['{$form_name}_{$contact_def.account_name.name}']) != 'undefined'",
		enableQS
);
</script>
<script>
                    if (typeof(sqs_objects) == "undefined") sqs_objects = [];
                    sqs_objects['ConvertLead_{$selectFields.Accounts}'] = {ldelim}
                        form: 'ConvertLead',
                        method: 'query',
                        modules: ['Accounts'],
                        group: 'or',
                        field_list: ['name', 'id'],
                        populate_list: ['{$selectFields.Accounts}', '{$contact_def[$selectFields.Accounts].id_name}'],
                        conditions: [{ldelim}'name': 'name', 'op': 'like_custom', 'end': '%', 'value': ''{rdelim}],
                        required_list: ['{$contact_def[$selectFields.Accounts].id_name}'],
                        order: 'name',
                        limit: '10'
                        {rdelim}
                </script>
{/if}
</span>
</div>
<div class=""
id="createAccounts"
{if !$def.required || !empty($def.select)}style="display:none"{/if}>

<div class="col-xs-12 col-sm-12 edit-view-row-item">
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='name_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_NAME' module='Accounts'}
{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</div>
<div valign="top"
class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}

{if strlen($fields.name.value) <= 0}
{assign var="value" value=$fields.name.default_value }
{else}
{assign var="value" value=$fields.name.value }
{/if}  
<input type='text' name='Accountsname' 
id='Accountsname' size='30' 
maxlength='150' 
value='{$value}' title=''      >
</div>
</div>
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='phone_office_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_PHONE_OFFICE' module='Accounts'}
{/capture}
{$label|strip_semicolon}:
</div>
<div valign="top"
class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}

{if strlen($fields.phone_office.value) <= 0}
{assign var="value" value=$fields.phone_office.default_value }
{else}
{assign var="value" value=$fields.phone_office.value }
{/if}  
<input type='text' name='Accountsphone_office' id='Accountsphone_office' size='30' maxlength='100' value='{$value}' title='' tabindex='0'	  class="phone" >
</div>
</div>
</div>

<div class="col-xs-12 col-sm-12 edit-view-row-item">
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='website_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_WEBSITE' module='Accounts'}
{/capture}
{$label|strip_semicolon}:
</div>
<div valign="top"
colspan='3' class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}

{if !empty($fields.website.value)}
<input type='text' name='Accountswebsite' id='Accountswebsite' size='30' 
maxlength='255' value='{$fields.website.value}' title='' tabindex='0'  >
{else}
<input type='text' name='Accountswebsite' id='Accountswebsite' size='30' 
maxlength='255'	   	   {if $displayView=='advanced_search'||$displayView=='basic_search'}value=''{else}value='http://'{/if} 
title='' tabindex='0'  >
{/if}
</div>
</div>
</div>

<div class="col-xs-12 col-sm-12 edit-view-row-item">
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='description_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_DESCRIPTION' module='Accounts'}
{/capture}
{$label|strip_semicolon}:
</div>
<div valign="top"
colspan='3' class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}

{if empty($fields.description.value)}
{assign var="value" value=$fields.description.default_value }
{else}
{assign var="value" value=$fields.description.value }
{/if}
<textarea  id='Accountsdescription' name='Accountsdescription'
rows="6"
cols="80"
title='' tabindex="0" 
 >{$value}</textarea>
{literal}{/literal}
</div>
</div>
</div>
</div>{literal}
<script type="text/javascript">
addForm('ConvertLead');addToValidateBinaryDependency('ConvertLead', 'assigned_user_name', 'alpha', false,'{/literal}{sugar_translate label='ERR_SQS_NO_MATCH_FIELD' module='Accounts' for_js=true}{literal}: {/literal}{sugar_translate label='LBL_ASSIGNED_TO' module='Accounts' for_js=true}{literal}', 'assigned_user_id' );
</script>{/literal}
