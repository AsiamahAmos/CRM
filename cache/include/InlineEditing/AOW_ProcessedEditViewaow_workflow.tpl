
<input type="text" name="{$fields.aow_workflow.name}" class="sqsEnabled" tabindex="1" id="{$fields.aow_workflow.name}" size="" value="{$fields.aow_workflow.value}" title='' autocomplete="off"  	 >
<input type="hidden" name="{$fields.aow_workflow.id_name}" 
	id="{$fields.aow_workflow.id_name}" 
	value="{$fields.aow_workflow_id.value}">
<span class="id-ff multiple">
<button type="button" name="btn_{$fields.aow_workflow.name}" id="btn_{$fields.aow_workflow.name}" tabindex="1" title="{sugar_translate label="LBL_SELECT_BUTTON_TITLE"}" class="button firstChild" value="{sugar_translate label="LBL_SELECT_BUTTON_LABEL"}"
onclick='open_popup(
    "{$fields.aow_workflow.module}", 
	600, 
	400, 
	"", 
	true, 
	false, 
	{literal}{"call_back_function":"set_return","form_name":"EditView","field_to_name_array":{"id":{/literal}"{$fields.aow_workflow.id_name}"{literal},"name":{/literal}"{$fields.aow_workflow.name}"{literal}}}{/literal}, 
	"single", 
	true
);' ><span class="suitepicon suitepicon-action-select"></span></button><button type="button" name="btn_clr_{$fields.aow_workflow.name}" id="btn_clr_{$fields.aow_workflow.name}" tabindex="1" title="{sugar_translate label="LBL_ACCESSKEY_CLEAR_RELATE_TITLE"}"  class="button lastChild"
onclick="SUGAR.clearRelateField(this.form, '{$fields.aow_workflow.name}', '{$fields.aow_workflow.id_name}');"  value="{sugar_translate label="LBL_ACCESSKEY_CLEAR_RELATE_LABEL"}" ><span class="suitepicon suitepicon-action-clear"></span></button>
</span>
<script type="text/javascript">
SUGAR.util.doWhen(
		"typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['{$form_name}_{$fields.aow_workflow.name}']) != 'undefined'",
		enableQS
);
</script>