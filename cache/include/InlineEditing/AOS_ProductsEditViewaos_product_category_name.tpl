
<input type="text" name="{$fields.aos_product_category_name.name}" class="sqsEnabled" tabindex="1" id="{$fields.aos_product_category_name.name}" size="" value="{$fields.aos_product_category_name.value}" title='' autocomplete="off"  	 >
<input type="hidden" name="{$fields.aos_product_category_name.id_name}" 
	id="{$fields.aos_product_category_name.id_name}" 
	value="{$fields.aos_product_category_id.value}">
<span class="id-ff multiple">
<button type="button" name="btn_{$fields.aos_product_category_name.name}" id="btn_{$fields.aos_product_category_name.name}" tabindex="1" title="{sugar_translate label="LBL_SELECT_BUTTON_TITLE"}" class="button firstChild" value="{sugar_translate label="LBL_SELECT_BUTTON_LABEL"}"
onclick='open_popup(
    "{$fields.aos_product_category_name.module}", 
	600, 
	400, 
	"", 
	true, 
	false, 
	{literal}{"call_back_function":"set_return","form_name":"EditView","field_to_name_array":{"id":{/literal}"{$fields.aos_product_category_name.id_name}"{literal},"name":{/literal}"{$fields.aos_product_category_name.name}"{literal}}}{/literal}, 
	"single", 
	true
);' ><span class="suitepicon suitepicon-action-select"></span></button><button type="button" name="btn_clr_{$fields.aos_product_category_name.name}" id="btn_clr_{$fields.aos_product_category_name.name}" tabindex="1" title="{sugar_translate label="LBL_ACCESSKEY_CLEAR_RELATE_TITLE"}"  class="button lastChild"
onclick="SUGAR.clearRelateField(this.form, '{$fields.aos_product_category_name.name}', '{$fields.aos_product_category_name.id_name}');"  value="{sugar_translate label="LBL_ACCESSKEY_CLEAR_RELATE_LABEL"}" ><span class="suitepicon suitepicon-action-clear"></span></button>
</span>
<script type="text/javascript">
SUGAR.util.doWhen(
		"typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['{$form_name}_{$fields.aos_product_category_name.name}']) != 'undefined'",
		enableQS
);
</script>