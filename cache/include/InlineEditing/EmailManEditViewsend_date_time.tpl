

<table border="0" cellpadding="0" cellspacing="0" class="dateTime">
<tr valign="middle">
<td nowrap class="dateTimeComboColumn">
<input autocomplete="off" type="text" id="{$fields.send_date_time.name}_date" class="datetimecombo_date" value="{$fields[$fields.send_date_time.name].value}" size="11" maxlength="10" title='' tabindex="1" onblur="combo_{$fields.send_date_time.name}.update();" onchange="combo_{$fields.send_date_time.name}.update(); "    >
	<button type="button" id="{$fields.send_date_time.name}_trigger" class="btn btn-danger" onclick="return false;"><span class="suitepicon suitepicon-module-calendar"  alt="{$APP.LBL_ENTER_DATE}"></span></button>
</td>
<td nowrap class="dateTimeComboColumn">
<div id="{$fields.send_date_time.name}_time_section" class="datetimecombo_time_section"></div>
</td>
</tr>
</table>
<input type="hidden" class="DateTimeCombo" id="{$fields.send_date_time.name}" name="{$fields.send_date_time.name}" value="{$fields[$fields.send_date_time.name].value}">
<script type="text/javascript" src="{sugar_getjspath file="include/SugarFields/Fields/Datetimecombo/Datetimecombo.js"}"></script>
<script type="text/javascript">
var combo_{$fields.send_date_time.name} = new Datetimecombo("{$fields[$fields.send_date_time.name].value}", "{$fields.send_date_time.name}", "{$TIME_FORMAT}", "1", '', false, true);
//Render the remaining widget fields
text = combo_{$fields.send_date_time.name}.html('');
document.getElementById('{$fields.send_date_time.name}_time_section').innerHTML = text;

//Call eval on the update function to handle updates to calendar picker object
eval(combo_{$fields.send_date_time.name}.jsscript(''));

addToValidateBinaryDependency('{$form_name}',"{$fields.send_date_time.name}_hours", 'alpha', false, "{$APP.ERR_MISSING_REQUIRED_FIELDS} {$APP.LBL_HOURS}" ,"{$fields.send_date_time.name}_date");
addToValidateBinaryDependency('{$form_name}', "{$fields.send_date_time.name}_minutes", 'alpha', false, "{$APP.ERR_MISSING_REQUIRED_FIELDS} {$APP.LBL_MINUTES}" ,"{$fields.send_date_time.name}_date");
addToValidateBinaryDependency('{$form_name}', "{$fields.send_date_time.name}_meridiem", 'alpha', false, "{$APP.ERR_MISSING_REQUIRED_FIELDS} {$APP.LBL_MERIDIEM}","{$fields.send_date_time.name}_date");

YAHOO.util.Event.onDOMReady(function()
{ldelim}

	Calendar.setup ({ldelim}
	onClose : update_{$fields.send_date_time.name},
	inputField : "{$fields.send_date_time.name}_date",
    form : "",
	ifFormat : "{$CALENDAR_FORMAT}",
	daFormat : "{$CALENDAR_FORMAT}",
	button : "{$fields.send_date_time.name}_trigger",
	singleClick : true,
	step : 1,
	weekNumbers: false,
        startWeekday: {$CALENDAR_FDOW|default:'0'},
	comboObject: combo_{$fields.send_date_time.name}
	{rdelim});

	//Call update for first time to round hours and minute values
	combo_{$fields.send_date_time.name}.update(false);

{rdelim}); 
</script>