
<div>&nbsp;</div>
<span class="color">{$ERROR}</span>
<div class="edit-view-row-item">
<input type="hidden" name="convert_create_Calls" id="convert_create_Calls"
{if ($def.required && empty($def.select)) || (!empty($def.default_action) && $def.default_action == "create")} value="true" {/if}/>
<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">
<input type="hidden" name="case_id" value="{$smarty.request.case_id}">
<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">
<input type="hidden" name="email_id" value="{$smarty.request.email_id}">
<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">
<input type="hidden" name="Callsstatus" value="{sugar_translate label='call_status_default'}">
{if $def.required }
<script type="text/javascript">
                        mod_array.push('Calls');//Bug#50590 add all required modules to mod_array
                    </script>
{/if}
{if !$def.required || !empty($def.select)}
<input class="checkbox" type="checkbox" name="newCalls" id="newCalls"
onclick="toggleDisplay('createCalls');if (typeof(addRemoveDropdownElement) == 'function') addRemoveDropdownElement('Calls');{if !empty($def.select)}toggleCallsSelect();{/if}">
<script type="text/javascript">
                                        {if !empty($def.default_action) && $def.default_action == "create"}
                    {if $lead_conv_activity_opt == 'move' || $lead_conv_activity_opt == 'copy' || $lead_conv_activity_opt == ''}
                    YAHOO.util.Event.onContentReady('lead_conv_ac_op_sel', function () {ldelim}
                        {else}
                        YAHOO.util.Event.onContentReady('createCalls', function () {ldelim}
                            {/if}
                            toggleDisplay('createCalls');
                            document.getElementById('newCalls').checked = true;
                            if (typeof(addRemoveDropdownElement) == 'function')
                                addRemoveDropdownElement('Calls');
                                                        {rdelim});
                    {/if}
                    {/if}
                </script>
{sugar_translate label='LNK_NEW_CALL' module='Leads'}
</span>
</div>
<div class=""
id="createCalls"
{if !$def.required || !empty($def.select)}style="display:none"{/if}>

<div class="col-xs-12 col-sm-12 edit-view-row-item">
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='name_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_SUBJECT' module='Calls'}
{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</div>
<div valign="top"
colspan='3' class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}

{if strlen($fields.name.value) <= 0}
{assign var="value" value=$fields.name.default_value }
{else}
{assign var="value" value=$fields.name.value }
{/if}  
<input type='text' name='Callsname' 
id='Callsname' size='90' 
maxlength='50' 
value='{$value}' title=''      >
</div>
</div>
</div>

<div class="col-xs-12 col-sm-12 edit-view-row-item">
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='date_start_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_DATE' module='Calls'}
{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</div>
<div valign="top"
class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}

<table border="0" cellpadding="0" cellspacing="0" class="dateTime">
<tr valign="middle">
<td nowrap class="dateTimeComboColumn">
<input autocomplete="off" type="text" id="Callsdate_start_date" class="datetimecombo_date" value="{$fields[$fields.date_start.name].value}" size="11" maxlength="10" title='' tabindex="0" onblur="combo_Callsdate_start.update();" onchange="combo_Callsdate_start.update(); "    >
<button type="button" id="Callsdate_start_trigger" class="btn btn-danger" onclick="return false;"><span class="suitepicon suitepicon-module-calendar"  alt="{$APP.LBL_ENTER_DATE}"></span></button>
</td>
<td nowrap class="dateTimeComboColumn">
<div id="Callsdate_start_time_section" class="datetimecombo_time_section"></div>
</td>
</tr>
</table>
<input type="hidden" class="DateTimeCombo" id="Callsdate_start" name="Callsdate_start" value="{$fields[$fields.date_start.name].value}">
<script type="text/javascript" src="{sugar_getjspath file="include/SugarFields/Fields/Datetimecombo/Datetimecombo.js"}"></script>
<script type="text/javascript">
var combo_Callsdate_start = new Datetimecombo("{$fields[$fields.date_start.name].value}", "Callsdate_start", "{$TIME_FORMAT}", "0", '', false, true);
//Render the remaining widget fields
text = combo_Callsdate_start.html('');
document.getElementById('Callsdate_start_time_section').innerHTML = text;

//Call eval on the update function to handle updates to calendar picker object
eval(combo_Callsdate_start.jsscript(''));

addToValidateBinaryDependency('{$form_name}',"Callsdate_start_hours", 'alpha', false, "{$APP.ERR_MISSING_REQUIRED_FIELDS} {$APP.LBL_HOURS}" ,"Callsdate_start_date");
addToValidateBinaryDependency('{$form_name}', "Callsdate_start_minutes", 'alpha', false, "{$APP.ERR_MISSING_REQUIRED_FIELDS} {$APP.LBL_MINUTES}" ,"Callsdate_start_date");
addToValidateBinaryDependency('{$form_name}', "Callsdate_start_meridiem", 'alpha', false, "{$APP.ERR_MISSING_REQUIRED_FIELDS} {$APP.LBL_MERIDIEM}","Callsdate_start_date");

YAHOO.util.Event.onDOMReady(function()
{ldelim}

	Calendar.setup ({ldelim}
	onClose : update_Callsdate_start,
	inputField : "Callsdate_start_date",
    form : "ConvertLead",
	ifFormat : "{$CALENDAR_FORMAT}",
	daFormat : "{$CALENDAR_FORMAT}",
	button : "Callsdate_start_trigger",
	singleClick : true,
	step : 1,
	weekNumbers: false,
        startWeekday: {$CALENDAR_FDOW|default:'0'},
	comboObject: combo_Callsdate_start
	{rdelim});

	//Call update for first time to round hours and minute values
	combo_Callsdate_start.update(false);

{rdelim}); 
</script>
</div>
</div>
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='duration_hours_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_DURATION' module='Calls'}
{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</div>
<div valign="top"
class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}
{literal}
<script type="text/javascript">
    function isValidCallsDuration() { 
        form = document.getElementById('ConvertLead');
        if ( form.duration_hours.value + form.duration_minutes.value <= 0 ) {
            alert('{/literal}{sugar_translate label="NOTICE_DURATION_TIME" module="Calls"}{literal}'); 
            return false;
        }
        return true; 
    }
</script>{/literal}
<input tabindex="0"  name="Callsduration_hours" tabindex="1" size="2" maxlength="2" type="text" value="{$fields.duration_hours.value}"/>
{php}$this->_tpl_vars["minutes_values"] = $this->_tpl_vars["bean"]->minutes_values;{/php}
{html_options name="Callsduration_minutes" options=$minutes_values selected=$fields.duration_minutes.value} &nbsp;
<span class="dateFormat">{sugar_translate label="LBL_HOURS_MINUTES" module="Calls"}
</div>
</div>
</div>

<div class="col-xs-12 col-sm-12 edit-view-row-item">
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='description_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_DESCRIPTION' module='Calls'}
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
<textarea  id='Callsdescription' name='Callsdescription'
rows="10"
cols="90"
title='' tabindex="0" 
 >{$value}</textarea>
{literal}{/literal}
</div>
</div>
</div>
</div>{literal}
<script type="text/javascript">
addForm('ConvertLead');addToValidateBinaryDependency('ConvertLead', 'assigned_user_name', 'alpha', false,'{/literal}{sugar_translate label='ERR_SQS_NO_MATCH_FIELD' module='Calls' for_js=true}{literal}: {/literal}{sugar_translate label='LBL_ASSIGNED_TO' module='Calls' for_js=true}{literal}', 'assigned_user_id' );
</script>{/literal}
