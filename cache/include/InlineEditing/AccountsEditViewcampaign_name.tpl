
<input type="text" name="{$fields.campaign_name.name}" class="sqsEnabled" tabindex="1" id="{$fields.campaign_name.name}" size="" value="{$fields.campaign_name.value}" title='' autocomplete="off"  	 >
<input type="hidden" name="{$fields.campaign_name.id_name}" 
	id="{$fields.campaign_name.id_name}" 
	value="{$fields.campaign_id.value}">
<span class="id-ff multiple">
<button type="button" name="btn_{$fields.campaign_name.name}" id="btn_{$fields.campaign_name.name}" tabindex="1" title="{sugar_translate label="LBL_ACCESSKEY_SELECT_CAMPAIGNS_TITLE"}" class="button firstChild" value="{sugar_translate label="LBL_ACCESSKEY_SELECT_CAMPAIGNS_LABEL"}"
onclick='open_popup(
    "{$fields.campaign_name.module}", 
	600, 
	400, 
	"", 
	true, 
	false, 
	{literal}{"call_back_function":"set_return","form_name":"EditView","field_to_name_array":{"id":{/literal}"{$fields.campaign_name.id_name}"{literal},"name":{/literal}"{$fields.campaign_name.name}"{literal}}}{/literal}, 
	"single", 
	true
);' ><span class="suitepicon suitepicon-action-select"></span></button><button type="button" name="btn_clr_{$fields.campaign_name.name}" id="btn_clr_{$fields.campaign_name.name}" tabindex="1" title="{sugar_translate label="LBL_ACCESSKEY_CLEAR_CAMPAIGNS_TITLE"}"  class="button lastChild"
onclick="SUGAR.clearRelateField(this.form, '{$fields.campaign_name.name}', '{$fields.campaign_name.id_name}');"  value="{sugar_translate label="LBL_ACCESSKEY_CLEAR_CAMPAIGNS_LABEL"}" ><span class="suitepicon suitepicon-action-clear"></span></button>
</span>
<script type="text/javascript">
SUGAR.util.doWhen(
		"typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['{$form_name}_{$fields.campaign_name.name}']) != 'undefined'",
		enableQS
);
</script>