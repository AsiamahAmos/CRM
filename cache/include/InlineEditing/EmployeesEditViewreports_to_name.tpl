
<input type="text" name="{$fields.reports_to_name.name}" class="sqsEnabled" tabindex="1" id="{$fields.reports_to_name.name}" size="" value="{$fields.reports_to_name.value}" title='' autocomplete="off"  	 >
<input type="hidden" name="{$fields.reports_to_name.id_name}" 
	id="{$fields.reports_to_name.id_name}" 
	value="{$fields.reports_to_id.value}">
<span class="id-ff multiple">
<button type="button" name="btn_{$fields.reports_to_name.name}" id="btn_{$fields.reports_to_name.name}" tabindex="1" title="{sugar_translate label="LBL_ACCESSKEY_SELECT_USERS_TITLE"}" class="button firstChild" value="{sugar_translate label="LBL_ACCESSKEY_SELECT_USERS_LABEL"}"
onclick='open_popup(
    "{$fields.reports_to_name.module}", 
	600, 
	400, 
	"", 
	true, 
	false, 
	{literal}{"call_back_function":"set_return","form_name":"EditView","field_to_name_array":{"id":{/literal}"{$fields.reports_to_name.id_name}"{literal},"last_name":{/literal}"{$fields.reports_to_name.name}"{literal}}}{/literal}, 
	"single", 
	true
);' ><span class="suitepicon suitepicon-action-select"></span></button><button type="button" name="btn_clr_{$fields.reports_to_name.name}" id="btn_clr_{$fields.reports_to_name.name}" tabindex="1" title="{sugar_translate label="LBL_ACCESSKEY_CLEAR_USERS_TITLE"}"  class="button lastChild"
onclick="SUGAR.clearRelateField(this.form, '{$fields.reports_to_name.name}', '{$fields.reports_to_name.id_name}');"  value="{sugar_translate label="LBL_ACCESSKEY_CLEAR_USERS_LABEL"}" ><span class="suitepicon suitepicon-action-clear"></span></button>
</span>
<script type="text/javascript">
SUGAR.util.doWhen(
		"typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['{$form_name}_{$fields.reports_to_name.name}']) != 'undefined'",
		enableQS
);
</script>