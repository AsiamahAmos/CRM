

<table border="0" cellpadding="0" cellspacing="0" class="dateTime">
<tr valign="middle">
<td nowrap class="dateTimeComboColumn">
<input autocomplete="off" type="text" id="{$fields.last_run.name}_date" class="datetimecombo_date" value="{$fields[$fields.last_run.name].value}" size="11" maxlength="10" title='' tabindex="1" onblur="combo_{$fields.last_run.name}.update();" onchange="combo_{$fields.last_run.name}.update(); "    >
	<button type="button" id="{$fields.last_run.name}_trigger" class="btn btn-danger" onclick="return false;"><span class="suitepicon suitepicon-module-calendar"  alt="{$APP.LBL_ENTER_DATE}"></span></button>
</td>
<td nowrap class="dateTimeComboColumn">
<div id="{$fields.last_run.name}_time_section" class="datetimecombo_time_section"></div>
</td>
</tr>
</table>
<input type="hidden" class="DateTimeCombo" id="{$fields.last_run.name}" name="{$fields.last_run.name}" value="{$fields[$fields.last_run.name].value}">
<script type="text/javascript" src="{sugar_getjspath file="include/SugarFields/Fields/Datetimecombo/Datetimecombo.js"}"></script>
<script type="text/javascript">
var combo_{$fields.last_run.name} = new Datetimecombo("{$fields[$fields.last_run.name].value}", "{$fields.last_run.name}", "{$TIME_FORMAT}", "1", '', false, true);
//Render the remaining widget fields
text = combo_{$fields.last_run.name}.html('');
document.getElementById('{$fields.last_run.name}_time_section').innerHTML = text;

//Call eval on the update function to handle updates to calendar picker object
eval(combo_{$fields.last_run.name}.jsscript(''));

addToValidateBinaryDependency('{$form_name}',"{$fields.last_run.name}_hours", 'alpha', false, "{$APP.ERR_MISSING_REQUIRED_FIELDS} {$APP.LBL_HOURS}" ,"{$fields.last_run.name}_date");
addToValidateBinaryDependency('{$form_name}', "{$fields.last_run.name}_minutes", 'alpha', false, "{$APP.ERR_MISSING_REQUIRED_FIELDS} {$APP.LBL_MINUTES}" ,"{$fields.last_run.name}_date");
addToValidateBinaryDependency('{$form_name}', "{$fields.last_run.name}_meridiem", 'alpha', false, "{$APP.ERR_MISSING_REQUIRED_FIELDS} {$APP.LBL_MERIDIEM}","{$fields.last_run.name}_date");

YAHOO.util.Event.onDOMReady(function()
{ldelim}

	Calendar.setup ({ldelim}
	onClose : update_{$fields.last_run.name},
	inputField : "{$fields.last_run.name}_date",
    form : "",
	ifFormat : "{$CALENDAR_FORMAT}",
	daFormat : "{$CALENDAR_FORMAT}",
	button : "{$fields.last_run.name}_trigger",
	singleClick : true,
	step : 1,
	weekNumbers: false,
        startWeekday: {$CALENDAR_FDOW|default:'0'},
	comboObject: combo_{$fields.last_run.name}
	{rdelim});

	//Call update for first time to round hours and minute values
	combo_{$fields.last_run.name}.update(false);

{rdelim}); 
</script>