
<div>&nbsp;</div>
<span class="color">{$ERROR}</span>
<div class="edit-view-row-item">
<input type="hidden" name="convert_create_Contacts" id="convert_create_Contacts"
{if ($def.required && empty($def.select)) || (!empty($def.default_action) && $def.default_action == "create")} value="true" {/if}/>
<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">
<input type="hidden" name="case_id" value="{$smarty.request.case_id}">
<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">
<input type="hidden" name="email_id" value="{$smarty.request.email_id}">
<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">
{if $def.required }
<script type="text/javascript">
                        mod_array.push('Contacts');//Bug#50590 add all required modules to mod_array
                    </script>
{/if}
{if !$def.required || !empty($def.select)}
<input class="checkbox" type="checkbox" name="newContacts" id="newContacts"
onclick="toggleDisplay('createContacts');if (typeof(addRemoveDropdownElement) == 'function') addRemoveDropdownElement('Contacts');{if !empty($def.select)}toggleContactsSelect();{/if}">
<script type="text/javascript">
                                        {if !empty($def.select)}
                    toggleContactsSelect = function () {ldelim}
                        var inputs = document.getElementById('selectContacts').getElementsByTagName('input');
                        for (var i in inputs) {
                            ldelim}inputs[i].disabled = !inputs[i].disabled;{rdelim}
                    var buttons = document.getElementById('selectContacts').getElementsByTagName('button');
                    for (var i in buttons) {
                        ldelim}buttons[i].disabled = !buttons[i].disabled;{rdelim}
                    {rdelim}
                    {/if}
                                        {if !empty($def.default_action) && $def.default_action == "create"}
                    {if $lead_conv_activity_opt == 'move' || $lead_conv_activity_opt == 'copy' || $lead_conv_activity_opt == ''}
                    YAHOO.util.Event.onContentReady('lead_conv_ac_op_sel', function () {ldelim}
                        {else}
                        YAHOO.util.Event.onContentReady('createContacts', function () {ldelim}
                            {/if}
                            toggleDisplay('createContacts');
                            document.getElementById('newContacts').checked = true;
                            if (typeof(addRemoveDropdownElement) == 'function')
                                addRemoveDropdownElement('Contacts');
                                                        {if !empty($def.select)}
                            toggleContactsSelect();
                            {/if}
                                                        {rdelim});
                    {/if}
                    {/if}
                </script>
{sugar_translate label='LNK_NEW_CONTACT' module='Leads'}
{if !empty($def.select)}
{sugar_translate label='LNK_SELECT_CONTACTS' module='Leads'}
{if $def.required }
<span class="required">*</span>
{/if}
<span id="selectContacts">

<input type="text" name="{$contact_def.report_to_name.name}" class="sqsEnabled" tabindex="" id="{$contact_def.report_to_name.name}" size="" value="{$contact_def.report_to_name.value}" title='' autocomplete="off"  	 >
<input type="hidden" name="{$contact_def.report_to_name.id_name}" 
id="{$contact_def.report_to_name.id_name}" 
value="{$contact_def.reports_to_id.value}">
<span class="id-ff multiple">
<button type="button" name="btn_{$contact_def.report_to_name.name}" id="btn_{$contact_def.report_to_name.name}" tabindex="" title="{sugar_translate label="LBL_ACCESSKEY_SELECT_CONTACTS_TITLE"}" class="button firstChild" value="{sugar_translate label="LBL_ACCESSKEY_SELECT_CONTACTS_LABEL"}"
onclick='open_popup(
"{$contact_def.report_to_name.module}", 
600, 
400, 
"{$initialFilter}", 
true, 
false, 
{literal}{"call_back_function":"set_return_lead_conv","form_name":"ConvertLead","field_to_name_array":{"id":"reports_to_id","last_name":"report_to_name"}}{/literal}, 
"single", 
true
);' ><span class="suitepicon suitepicon-action-select"></span></button><button type="button" name="btn_clr_{$contact_def.report_to_name.name}" id="btn_clr_{$contact_def.report_to_name.name}" tabindex="" title="{sugar_translate label="LBL_ACCESSKEY_CLEAR_CONTACTS_TITLE"}"  class="button lastChild"
onclick="SUGAR.clearRelateField(this.form, '{$contact_def.report_to_name.name}', '{$contact_def.report_to_name.id_name}');"  value="{sugar_translate label="LBL_ACCESSKEY_CLEAR_CONTACTS_LABEL"}" ><span class="suitepicon suitepicon-action-clear"></span></button>
</span>
<script type="text/javascript">
SUGAR.util.doWhen(
		"typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['{$form_name}_{$contact_def.report_to_name.name}']) != 'undefined'",
		enableQS
);
</script>
<script>
                    if (typeof(sqs_objects) == "undefined") sqs_objects = [];
                    sqs_objects['ConvertLead_{$selectFields.Contacts}'] = {ldelim}
                        form: 'ConvertLead',
                        method: 'query',
                        modules: ['Contacts'],
                        group: 'or',
                        field_list: ['name', 'id'],
                        populate_list: ['{$selectFields.Contacts}', '{$contact_def[$selectFields.Contacts].id_name}'],
                        conditions: [{ldelim}'name': 'name', 'op': 'like_custom', 'end': '%', 'value': ''{rdelim}],
                        required_list: ['{$contact_def[$selectFields.Contacts].id_name}'],
                        order: 'name',
                        limit: '10'
                        {rdelim}
                </script>
{/if}
</span>
</div>
<div class=""
id="createContacts"
{if !$def.required || !empty($def.select)}style="display:none"{/if}>

<div class="col-xs-12 col-sm-12 edit-view-row-item">
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='first_name_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_FIRST_NAME' module='Contacts'}
{/capture}
{$label|strip_semicolon}:
</div>
<div valign="top"
class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}
{html_options name="Contactssalutation" options=$fields.salutation.options selected=$fields.salutation.value}&nbsp;<input tabindex="0"  name="Contactsfirst_name" id="Contactsfirst_name" size="25" maxlength="25" type="text" value="{$fields.first_name.value}">
</div>
</div>
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='title_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_TITLE' module='Contacts'}
{/capture}
{$label|strip_semicolon}:
</div>
<div valign="top"
class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}

{if strlen($fields.title.value) <= 0}
{assign var="value" value=$fields.title.default_value }
{else}
{assign var="value" value=$fields.title.value }
{/if}  
<input type='text' name='Contactstitle' 
id='Contactstitle' size='30' 
maxlength='100' 
value='{$value}' title=''      >
</div>
</div>
</div>

<div class="col-xs-12 col-sm-12 edit-view-row-item">
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='last_name_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_LAST_NAME' module='Contacts'}
{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</div>
<div valign="top"
class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}

{if strlen($fields.last_name.value) <= 0}
{assign var="value" value=$fields.last_name.default_value }
{else}
{assign var="value" value=$fields.last_name.value }
{/if}  
<input type='text' name='Contactslast_name' 
id='Contactslast_name' size='30' 
maxlength='100' 
value='{$value}' title=''      >
</div>
</div>
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='department_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_DEPARTMENT' module='Contacts'}
{/capture}
{$label|strip_semicolon}:
</div>
<div valign="top"
class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}

{if strlen($fields.department.value) <= 0}
{assign var="value" value=$fields.department.default_value }
{else}
{assign var="value" value=$fields.department.value }
{/if}  
<input type='text' name='Contactsdepartment' 
id='Contactsdepartment' size='30' 
maxlength='255' 
value='{$value}' title=''      >
</div>
</div>
</div>

<div class="col-xs-12 col-sm-12 edit-view-row-item">
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='client_id_c_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_CLIENT_ID' module='Contacts'}
{/capture}
{$label|strip_semicolon}:
</div>
<div valign="top"
class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}
<input tabindex="0"  id="Contactsclient_id_c" name="Contactsclient_id_c" size="25" maxlength="25" type="text" value="{$fields.client_id_c.value}">
<script>var today = new Date();
                    var dd = String(today.getDate()).padStart(2, '0');
                    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                    var yyyy = today.getFullYear();
                    today = mm + '/' + dd + '/' + yyyy;
                    $("#Contactsclient_since_c").val(today)</script>
</div>
</div>
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='client_since_c_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_CLIENT_SINCE' module='Contacts'}
{/capture}
{$label|strip_semicolon}:
</div>
<div valign="top"
class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}

<span class="dateTime">
{assign var=date_value value=$fields.client_since_c.value }
<input class="date_input" autocomplete="off" type="text" name="Contactsclient_since_c" id="Contactsclient_since_c" value="{$date_value}" title=''  tabindex='0'    size="11" maxlength="10" >
<button type="button" id="Contactsclient_since_c_trigger" class="btn btn-danger" onclick="return false;"><span class="suitepicon suitepicon-module-calendar" alt="{$APP.LBL_ENTER_DATE}"></span></button>
</span>
<script type="text/javascript">
Calendar.setup ({ldelim}
inputField : "Contactsclient_since_c",
form : "ConvertLead",
ifFormat : "{$CALENDAR_FORMAT}",
daFormat : "{$CALENDAR_FORMAT}",
button : "Contactsclient_since_c_trigger",
singleClick : true,
dateStr : "{$date_value}",
startWeekday: {$CALENDAR_FDOW|default:'0'},
step : 1,
weekNumbers:false
{rdelim}
);
</script>
</div>
</div>
</div>

<div class="col-xs-12 col-sm-12 edit-view-row-item">
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='birthdate_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_BIRTHDATE' module='Contacts'}
{/capture}
{$label|strip_semicolon}:
</div>
<div valign="top"
class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}

<span class="dateTime">
{assign var=date_value value=$fields.birthdate.value }
<input class="date_input" autocomplete="off" type="text" name="Contactsbirthdate" id="Contactsbirthdate" value="{$date_value}" title=''  tabindex='0'    size="11" maxlength="10" >
<button type="button" id="Contactsbirthdate_trigger" class="btn btn-danger" onclick="return false;"><span class="suitepicon suitepicon-module-calendar" alt="{$APP.LBL_ENTER_DATE}"></span></button>
</span>
<script type="text/javascript">
Calendar.setup ({ldelim}
inputField : "Contactsbirthdate",
form : "ConvertLead",
ifFormat : "{$CALENDAR_FORMAT}",
daFormat : "{$CALENDAR_FORMAT}",
button : "Contactsbirthdate_trigger",
singleClick : true,
dateStr : "{$date_value}",
startWeekday: {$CALENDAR_FDOW|default:'0'},
step : 1,
weekNumbers:false
{rdelim}
);
</script>
</div>
</div>
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='gender_c_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_GENDER' module='Contacts'}
{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</div>
<div valign="top"
class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}

{if !isset($config.enable_autocomplete) || $config.enable_autocomplete==false}
<select name="Contactsgender_c" 
id="Contactsgender_c" 
title=''       
>
{if isset($fields.gender_c.value) && $fields.gender_c.value != ''}
{html_options options=$fields.gender_c.options selected=$fields.gender_c.value}
{else}
{html_options options=$fields.gender_c.options selected=$fields.gender_c.default}
{/if}
</select>
{else}
{assign var="field_options" value=$fields.gender_c.options }
{capture name="field_val"}{$fields.gender_c.value}{/capture}
{assign var="field_val" value=$smarty.capture.field_val}
{capture name="ac_key"}{$fields.gender_c.name}{/capture}
{assign var="ac_key" value=$smarty.capture.ac_key}
<select style='display:none' name="Contactsgender_c" 
id="Contactsgender_c" 
title=''          
>
{if isset($fields.gender_c.value) && $fields.gender_c.value != ''}
{html_options options=$fields.gender_c.options selected=$fields.gender_c.value}
{else}
{html_options options=$fields.gender_c.options selected=$fields.gender_c.default}
{/if}
</select>
<input
id="Contactsgender_c-input"
name="Contactsgender_c-input"
size="30"
value="{$field_val|lookup:$field_options}"
type="text" style="vertical-align: top;">
<span class="id-ff multiple">
<button type="button"><img src="{sugar_getimagepath file="id-ff-down.png"}" id="Contactsgender_c-image"></button><button type="button"
id="btn-clear-Contactsgender_c-input"
title="Clear"
onclick="SUGAR.clearRelateField(this.form, 'Contactsgender_c-input', 'Contactsgender_c');sync_Contactsgender_c()"><span class="suitepicon suitepicon-action-clear"></span></button>
</span>
{literal}
<script>
	SUGAR.AutoComplete.{/literal}{$ac_key}{literal} = [];
	{/literal}

			{literal}
		(function (){
			var selectElem = document.getElementById("{/literal}Contactsgender_c{literal}");
			
			if (typeof select_defaults =="undefined")
				select_defaults = [];
			
			select_defaults[selectElem.id] = {key:selectElem.value,text:''};

			//get default
			for (i=0;i<selectElem.options.length;i++){
				if (selectElem.options[i].value==selectElem.value)
					select_defaults[selectElem.id].text = selectElem.options[i].innerHTML;
			}

			//SUGAR.AutoComplete.{$ac_key}.ds = 
			//get options array from vardefs
			var options = SUGAR.AutoComplete.getOptionsArray("");

			YUI().use('datasource', 'datasource-jsonschema',function (Y) {
				SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.ds = new Y.DataSource.Function({
				    source: function (request) {
				    	var ret = [];
				    	for (i=0;i<selectElem.options.length;i++)
				    		if (!(selectElem.options[i].value=='' && selectElem.options[i].innerHTML==''))
				    			ret.push({'key':selectElem.options[i].value,'text':selectElem.options[i].innerHTML});
				    	return ret;
				    }
				});
			});
		})();
		{/literal}
	
	{literal}
		YUI().use("autocomplete", "autocomplete-filters", "autocomplete-highlighters", "node","node-event-simulate", function (Y) {
	{/literal}
			
	SUGAR.AutoComplete.{$ac_key}.inputNode = Y.one('#Contactsgender_c-input');
	SUGAR.AutoComplete.{$ac_key}.inputImage = Y.one('#Contactsgender_c-image');
	SUGAR.AutoComplete.{$ac_key}.inputHidden = Y.one('#Contactsgender_c');
	
			{literal}
			function SyncToHidden(selectme){
				var selectElem = document.getElementById("{/literal}Contactsgender_c{literal}");
				var doSimulateChange = false;
				
				if (selectElem.value!=selectme)
					doSimulateChange=true;
				
				selectElem.value=selectme;

				for (i=0;i<selectElem.options.length;i++){
					selectElem.options[i].selected=false;
					if (selectElem.options[i].value==selectme)
						selectElem.options[i].selected=true;
				}

				if (doSimulateChange)
					SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('change');
			}

			//global variable 
			sync_{/literal}Contactsgender_c{literal} = function(){
				SyncToHidden();
			}
			function syncFromHiddenToWidget(){

				var selectElem = document.getElementById("{/literal}Contactsgender_c{literal}");

				//if select no longer on page, kill timer
				if (selectElem==null || selectElem.options == null)
					return;

				var currentvalue = SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.get('value');

				SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.simulate('keyup');

				for (i=0;i<selectElem.options.length;i++){

					if (selectElem.options[i].value==selectElem.value && document.activeElement != document.getElementById('{/literal}Contactsgender_c-input{literal}'))
						SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.set('value',selectElem.options[i].innerHTML);
				}
			}

            YAHOO.util.Event.onAvailable("{/literal}Contactsgender_c{literal}", syncFromHiddenToWidget);
		{/literal}

		SUGAR.AutoComplete.{$ac_key}.minQLen = 0;
		SUGAR.AutoComplete.{$ac_key}.queryDelay = 0;
		SUGAR.AutoComplete.{$ac_key}.numOptions = {$field_options|@count};
		if(SUGAR.AutoComplete.{$ac_key}.numOptions >= 300) {literal}{
			{/literal}
			SUGAR.AutoComplete.{$ac_key}.minQLen = 1;
			SUGAR.AutoComplete.{$ac_key}.queryDelay = 200;
			{literal}
		}
		{/literal}
		if(SUGAR.AutoComplete.{$ac_key}.numOptions >= 3000) {literal}{
			{/literal}
			SUGAR.AutoComplete.{$ac_key}.minQLen = 1;
			SUGAR.AutoComplete.{$ac_key}.queryDelay = 500;
			{literal}
		}
		{/literal}
		
	SUGAR.AutoComplete.{$ac_key}.optionsVisible = false;
	
	{literal}
	SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.plug(Y.Plugin.AutoComplete, {
		activateFirstItem: true,
		{/literal}
		minQueryLength: SUGAR.AutoComplete.{$ac_key}.minQLen,
		queryDelay: SUGAR.AutoComplete.{$ac_key}.queryDelay,
		zIndex: 99999,

				
		{literal}
		source: SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.ds,
		
		resultTextLocator: 'text',
		resultHighlighter: 'phraseMatch',
		resultFilters: 'phraseMatch',
	});

	SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.expandHover = function(ex){
		var hover = YAHOO.util.Dom.getElementsByClassName('dccontent');
		if(hover[0] != null){
			if (ex) {
				var h = '1000px';
				hover[0].style.height = h;
			}
			else{
				hover[0].style.height = '';
			}
		}
	}
		
	if({/literal}SUGAR.AutoComplete.{$ac_key}.minQLen{literal} == 0){
		// expand the dropdown options upon focus
		SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('focus', function () {
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.ac.sendRequest('');
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.optionsVisible = true;
		});
	}

			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('click', function(e) {
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('click');
		});
		
		SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('dblclick', function(e) {
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('dblclick');
		});

		SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('focus', function(e) {
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('focus');
		});

		SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('mouseup', function(e) {
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('mouseup');
		});

		SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('mousedown', function(e) {
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('mousedown');
		});

		SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('blur', function(e) {
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('blur');
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.optionsVisible = false;
			var selectElem = document.getElementById("{/literal}Contactsgender_c{literal}");
			//if typed value is a valid option, do nothing
			for (i=0;i<selectElem.options.length;i++)
				if (selectElem.options[i].innerHTML==SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.get('value'))
					return;
			
			//typed value is invalid, so set the text and the hidden to blank
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.set('value', select_defaults[selectElem.id].text);
			SyncToHidden(select_defaults[selectElem.id].key);
		});
	
	// when they click on the arrow image, toggle the visibility of the options
	SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputImage.ancestor().on('click', function () {
		if (SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.optionsVisible) {
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.blur();
		} else {
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.focus();
		}
	});

	SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.ac.on('query', function () {
		SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.set('value', '');
	});

	SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.ac.on('visibleChange', function (e) {
		SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.expandHover(e.newVal); // expand
	});

	// when they select an option, set the hidden input with the KEY, to be saved
	SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.ac.on('select', function(e) {
		SyncToHidden(e.result.raw.key);
	});
 
});
</script> 
{/literal}
{/if}
</div>
</div>
</div>

<div class="col-xs-12 col-sm-12 edit-view-row-item">
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='occupation_c_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_OCCUPATION' module='Contacts'}
{/capture}
{$label|strip_semicolon}:
</div>
<div valign="top"
class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}

{if strlen($fields.occupation_c.value) <= 0}
{assign var="value" value=$fields.occupation_c.default_value }
{else}
{assign var="value" value=$fields.occupation_c.value }
{/if}  
<input type='text' name='Contactsoccupation_c' 
id='Contactsoccupation_c' size='30' 
maxlength='255' 
value='{$value}' title=''      >
</div>
</div>
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='branch_c_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_BRANCH' module='Contacts'}
{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</div>
<div valign="top"
class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}

<input type="text" name="Contactsbranch_c" class="sqsEnabled" tabindex="0" id="Contactsbranch_c" size="" value="{$fields.branch_c.value}" title='' autocomplete="off"  	 >
<input type="hidden" name="Contacts{$fields.branch_c.id_name}" 
id="Contacts{$fields.branch_c.id_name}" 
value="{$fields.bran_branches_id_c.value}">
<span class="id-ff multiple">
<button type="button" name="btn_Contactsbranch_c" id="btn_Contactsbranch_c" tabindex="0" title="{sugar_translate label="LBL_SELECT_BUTTON_TITLE"}" class="button firstChild" value="{sugar_translate label="LBL_SELECT_BUTTON_LABEL"}"
onclick='open_popup(
"{$fields.branch_c.module}", 
600, 
400, 
"", 
true, 
false, 
{literal}{"call_back_function":"set_return","form_name":"ConvertLead","field_to_name_array":{"id":"Contactsbran_branches_id_c","name":"Contactsbranch_c"}}{/literal}, 
"single", 
true
);' ><span class="suitepicon suitepicon-action-select"></span></button><button type="button" name="btn_clr_Contactsbranch_c" id="btn_clr_Contactsbranch_c" tabindex="0" title="{sugar_translate label="LBL_ACCESSKEY_CLEAR_RELATE_TITLE"}"  class="button lastChild"
onclick="SUGAR.clearRelateField(this.form, 'Contactsbranch_c', 'Contactsbranch_c_{$fields.branch_c.id_name}');"  value="{sugar_translate label="LBL_ACCESSKEY_CLEAR_RELATE_LABEL"}" ><span class="suitepicon suitepicon-action-clear"></span></button>
</span>
<script type="text/javascript">
SUGAR.util.doWhen(
		"typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['{$form_name}_Contactsbranch_c']) != 'undefined'",
		enableQS
);
</script>
</div>
</div>
</div>

<div class="col-xs-12 col-sm-12 edit-view-row-item">
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='primary_address_street_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_PRIMARY_ADDRESS' module='Contacts'}
{/capture}
{$label|strip_semicolon}:
</div>
<div valign="top"
class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}

{if strlen($fields.primary_address_street.value) <= 0}
{assign var="value" value=$fields.primary_address_street.default_value }
{else}
{assign var="value" value=$fields.primary_address_street.value }
{/if}  
<input type='text' name='Contactsprimary_address_street' 
id='Contactsprimary_address_street' size='30' 
maxlength='150' 
value='{$value}' title=''      >
</div>
</div>
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='phone_work_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_OFFICE_PHONE' module='Contacts'}
{/capture}
{$label|strip_semicolon}:
</div>
<div valign="top"
class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}

{if strlen($fields.phone_work.value) <= 0}
{assign var="value" value=$fields.phone_work.default_value }
{else}
{assign var="value" value=$fields.phone_work.value }
{/if}  
<input type='text' name='Contactsphone_work' id='Contactsphone_work' size='30' maxlength='100' value='{$value}' title='' tabindex='0'	  class="phone" >
</div>
</div>
</div>

<div class="col-xs-12 col-sm-12 edit-view-row-item">
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='primary_address_city_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_CITY' module='Contacts'}
{/capture}
{$label|strip_semicolon}:
</div>
<div valign="top"
class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}

{if strlen($fields.primary_address_city.value) <= 0}
{assign var="value" value=$fields.primary_address_city.default_value }
{else}
{assign var="value" value=$fields.primary_address_city.value }
{/if}  
<input type='text' name='Contactsprimary_address_city' 
id='Contactsprimary_address_city' size='30' 
maxlength='100' 
value='{$value}' title=''      >
</div>
</div>
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='phone_mobile_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_MOBILE_PHONE' module='Contacts'}
{/capture}
{$label|strip_semicolon}:
</div>
<div valign="top"
class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}

{if strlen($fields.phone_mobile.value) <= 0}
{assign var="value" value=$fields.phone_mobile.default_value }
{else}
{assign var="value" value=$fields.phone_mobile.value }
{/if}  
<input type='text' name='Contactsphone_mobile' id='Contactsphone_mobile' size='30' maxlength='100' value='{$value}' title='' tabindex='0'	  class="phone" >
</div>
</div>
</div>

<div class="col-xs-12 col-sm-12 edit-view-row-item">
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='primary_address_state_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_STATE' module='Contacts'}
{/capture}
{$label|strip_semicolon}:
</div>
<div valign="top"
class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}

{if strlen($fields.primary_address_state.value) <= 0}
{assign var="value" value=$fields.primary_address_state.default_value }
{else}
{assign var="value" value=$fields.primary_address_state.value }
{/if}  
<input type='text' name='Contactsprimary_address_state' 
id='Contactsprimary_address_state' size='30' 
maxlength='100' 
value='{$value}' title=''      >
</div>
</div>
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='phone_other_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_OTHER_PHONE' module='Contacts'}
{/capture}
{$label|strip_semicolon}:
</div>
<div valign="top"
class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}

{if strlen($fields.phone_other.value) <= 0}
{assign var="value" value=$fields.phone_other.default_value }
{else}
{assign var="value" value=$fields.phone_other.value }
{/if}  
<input type='text' name='Contactsphone_other' id='Contactsphone_other' size='30' maxlength='100' value='{$value}' title='' tabindex='0'	  class="phone" >
</div>
</div>
</div>

<div class="col-xs-12 col-sm-12 edit-view-row-item">
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='primary_address_postalcode_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_POSTAL_CODE' module='Contacts'}
{/capture}
{$label|strip_semicolon}:
</div>
<div valign="top"
class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}

{if strlen($fields.primary_address_postalcode.value) <= 0}
{assign var="value" value=$fields.primary_address_postalcode.default_value }
{else}
{assign var="value" value=$fields.primary_address_postalcode.value }
{/if}  
<input type='text' name='Contactsprimary_address_postalcode' 
id='Contactsprimary_address_postalcode' size='30' 
maxlength='20' 
value='{$value}' title=''      >
</div>
</div>
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='phone_fax_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_FAX_PHONE' module='Contacts'}
{/capture}
{$label|strip_semicolon}:
</div>
<div valign="top"
class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}

{if strlen($fields.phone_fax.value) <= 0}
{assign var="value" value=$fields.phone_fax.default_value }
{else}
{assign var="value" value=$fields.phone_fax.value }
{/if}  
<input type='text' name='Contactsphone_fax' id='Contactsphone_fax' size='30' maxlength='100' value='{$value}' title='' tabindex='0'	  class="phone" >
</div>
</div>
</div>

<div class="col-xs-12 col-sm-12 edit-view-row-item">
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='primary_address_country_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_COUNTRY' module='Contacts'}
{/capture}
{$label|strip_semicolon}:
</div>
<div valign="top"
class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}

{if strlen($fields.primary_address_country.value) <= 0}
{assign var="value" value=$fields.primary_address_country.default_value }
{else}
{assign var="value" value=$fields.primary_address_country.value }
{/if}  
<input type='text' name='Contactsprimary_address_country' 
id='Contactsprimary_address_country' size='30' 
value='{$value}' title=''      >
</div>
</div>
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='lead_source_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_LEAD_SOURCE' module='Contacts'}
{/capture}
{$label|strip_semicolon}:
</div>
<div valign="top"
class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}

{if !isset($config.enable_autocomplete) || $config.enable_autocomplete==false}
<select name="Contactslead_source" 
id="Contactslead_source" 
title=''       
>
{if isset($fields.lead_source.value) && $fields.lead_source.value != ''}
{html_options options=$fields.lead_source.options selected=$fields.lead_source.value}
{else}
{html_options options=$fields.lead_source.options selected=$fields.lead_source.default}
{/if}
</select>
{else}
{assign var="field_options" value=$fields.lead_source.options }
{capture name="field_val"}{$fields.lead_source.value}{/capture}
{assign var="field_val" value=$smarty.capture.field_val}
{capture name="ac_key"}{$fields.lead_source.name}{/capture}
{assign var="ac_key" value=$smarty.capture.ac_key}
<select style='display:none' name="Contactslead_source" 
id="Contactslead_source" 
title=''          
>
{if isset($fields.lead_source.value) && $fields.lead_source.value != ''}
{html_options options=$fields.lead_source.options selected=$fields.lead_source.value}
{else}
{html_options options=$fields.lead_source.options selected=$fields.lead_source.default}
{/if}
</select>
<input
id="Contactslead_source-input"
name="Contactslead_source-input"
size="30"
value="{$field_val|lookup:$field_options}"
type="text" style="vertical-align: top;">
<span class="id-ff multiple">
<button type="button"><img src="{sugar_getimagepath file="id-ff-down.png"}" id="Contactslead_source-image"></button><button type="button"
id="btn-clear-Contactslead_source-input"
title="Clear"
onclick="SUGAR.clearRelateField(this.form, 'Contactslead_source-input', 'Contactslead_source');sync_Contactslead_source()"><span class="suitepicon suitepicon-action-clear"></span></button>
</span>
{literal}
<script>
	SUGAR.AutoComplete.{/literal}{$ac_key}{literal} = [];
	{/literal}

			{literal}
		(function (){
			var selectElem = document.getElementById("{/literal}Contactslead_source{literal}");
			
			if (typeof select_defaults =="undefined")
				select_defaults = [];
			
			select_defaults[selectElem.id] = {key:selectElem.value,text:''};

			//get default
			for (i=0;i<selectElem.options.length;i++){
				if (selectElem.options[i].value==selectElem.value)
					select_defaults[selectElem.id].text = selectElem.options[i].innerHTML;
			}

			//SUGAR.AutoComplete.{$ac_key}.ds = 
			//get options array from vardefs
			var options = SUGAR.AutoComplete.getOptionsArray("");

			YUI().use('datasource', 'datasource-jsonschema',function (Y) {
				SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.ds = new Y.DataSource.Function({
				    source: function (request) {
				    	var ret = [];
				    	for (i=0;i<selectElem.options.length;i++)
				    		if (!(selectElem.options[i].value=='' && selectElem.options[i].innerHTML==''))
				    			ret.push({'key':selectElem.options[i].value,'text':selectElem.options[i].innerHTML});
				    	return ret;
				    }
				});
			});
		})();
		{/literal}
	
	{literal}
		YUI().use("autocomplete", "autocomplete-filters", "autocomplete-highlighters", "node","node-event-simulate", function (Y) {
	{/literal}
			
	SUGAR.AutoComplete.{$ac_key}.inputNode = Y.one('#Contactslead_source-input');
	SUGAR.AutoComplete.{$ac_key}.inputImage = Y.one('#Contactslead_source-image');
	SUGAR.AutoComplete.{$ac_key}.inputHidden = Y.one('#Contactslead_source');
	
			{literal}
			function SyncToHidden(selectme){
				var selectElem = document.getElementById("{/literal}Contactslead_source{literal}");
				var doSimulateChange = false;
				
				if (selectElem.value!=selectme)
					doSimulateChange=true;
				
				selectElem.value=selectme;

				for (i=0;i<selectElem.options.length;i++){
					selectElem.options[i].selected=false;
					if (selectElem.options[i].value==selectme)
						selectElem.options[i].selected=true;
				}

				if (doSimulateChange)
					SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('change');
			}

			//global variable 
			sync_{/literal}Contactslead_source{literal} = function(){
				SyncToHidden();
			}
			function syncFromHiddenToWidget(){

				var selectElem = document.getElementById("{/literal}Contactslead_source{literal}");

				//if select no longer on page, kill timer
				if (selectElem==null || selectElem.options == null)
					return;

				var currentvalue = SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.get('value');

				SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.simulate('keyup');

				for (i=0;i<selectElem.options.length;i++){

					if (selectElem.options[i].value==selectElem.value && document.activeElement != document.getElementById('{/literal}Contactslead_source-input{literal}'))
						SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.set('value',selectElem.options[i].innerHTML);
				}
			}

            YAHOO.util.Event.onAvailable("{/literal}Contactslead_source{literal}", syncFromHiddenToWidget);
		{/literal}

		SUGAR.AutoComplete.{$ac_key}.minQLen = 0;
		SUGAR.AutoComplete.{$ac_key}.queryDelay = 0;
		SUGAR.AutoComplete.{$ac_key}.numOptions = {$field_options|@count};
		if(SUGAR.AutoComplete.{$ac_key}.numOptions >= 300) {literal}{
			{/literal}
			SUGAR.AutoComplete.{$ac_key}.minQLen = 1;
			SUGAR.AutoComplete.{$ac_key}.queryDelay = 200;
			{literal}
		}
		{/literal}
		if(SUGAR.AutoComplete.{$ac_key}.numOptions >= 3000) {literal}{
			{/literal}
			SUGAR.AutoComplete.{$ac_key}.minQLen = 1;
			SUGAR.AutoComplete.{$ac_key}.queryDelay = 500;
			{literal}
		}
		{/literal}
		
	SUGAR.AutoComplete.{$ac_key}.optionsVisible = false;
	
	{literal}
	SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.plug(Y.Plugin.AutoComplete, {
		activateFirstItem: true,
		{/literal}
		minQueryLength: SUGAR.AutoComplete.{$ac_key}.minQLen,
		queryDelay: SUGAR.AutoComplete.{$ac_key}.queryDelay,
		zIndex: 99999,

				
		{literal}
		source: SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.ds,
		
		resultTextLocator: 'text',
		resultHighlighter: 'phraseMatch',
		resultFilters: 'phraseMatch',
	});

	SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.expandHover = function(ex){
		var hover = YAHOO.util.Dom.getElementsByClassName('dccontent');
		if(hover[0] != null){
			if (ex) {
				var h = '1000px';
				hover[0].style.height = h;
			}
			else{
				hover[0].style.height = '';
			}
		}
	}
		
	if({/literal}SUGAR.AutoComplete.{$ac_key}.minQLen{literal} == 0){
		// expand the dropdown options upon focus
		SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('focus', function () {
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.ac.sendRequest('');
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.optionsVisible = true;
		});
	}

			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('click', function(e) {
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('click');
		});
		
		SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('dblclick', function(e) {
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('dblclick');
		});

		SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('focus', function(e) {
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('focus');
		});

		SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('mouseup', function(e) {
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('mouseup');
		});

		SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('mousedown', function(e) {
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('mousedown');
		});

		SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('blur', function(e) {
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('blur');
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.optionsVisible = false;
			var selectElem = document.getElementById("{/literal}Contactslead_source{literal}");
			//if typed value is a valid option, do nothing
			for (i=0;i<selectElem.options.length;i++)
				if (selectElem.options[i].innerHTML==SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.get('value'))
					return;
			
			//typed value is invalid, so set the text and the hidden to blank
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.set('value', select_defaults[selectElem.id].text);
			SyncToHidden(select_defaults[selectElem.id].key);
		});
	
	// when they click on the arrow image, toggle the visibility of the options
	SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputImage.ancestor().on('click', function () {
		if (SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.optionsVisible) {
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.blur();
		} else {
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.focus();
		}
	});

	SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.ac.on('query', function () {
		SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.set('value', '');
	});

	SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.ac.on('visibleChange', function (e) {
		SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.expandHover(e.newVal); // expand
	});

	// when they select an option, set the hidden input with the KEY, to be saved
	SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.ac.on('select', function(e) {
		SyncToHidden(e.result.raw.key);
	});
 
});
</script> 
{/literal}
{/if}
</div>
</div>
</div>

<div class="col-xs-12 col-sm-12 edit-view-row-item">
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='email1_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_EMAIL_ADDRESS' module='Contacts'}
{/capture}
{$label|strip_semicolon}:
</div>
<div valign="top"
class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}
<span id='email1_span'>
{$fields.email1.value}</span>
</div>
</div>
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='assigned_user_name_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_ASSIGNED_TO_NAME' module='Contacts'}
{/capture}
{$label|strip_semicolon}:
</div>
<div valign="top"
class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
{counter name="panelFieldCount" print=false}

<input type="text" name="Contactsassigned_user_name" class="sqsEnabled" tabindex="0" id="Contactsassigned_user_name" size="" value="{$fields.assigned_user_name.value}" title='' autocomplete="off"  	 >
<input type="hidden" name="Contacts{$fields.assigned_user_name.id_name}" 
id="Contacts{$fields.assigned_user_name.id_name}" 
value="{$fields.assigned_user_id.value}">
<span class="id-ff multiple">
<button type="button" name="btn_Contactsassigned_user_name" id="btn_Contactsassigned_user_name" tabindex="0" title="{sugar_translate label="LBL_ACCESSKEY_SELECT_USERS_TITLE"}" class="button firstChild" value="{sugar_translate label="LBL_ACCESSKEY_SELECT_USERS_LABEL"}"
onclick='open_popup(
"{$fields.assigned_user_name.module}", 
600, 
400, 
"", 
true, 
false, 
{literal}{"call_back_function":"set_return","form_name":"ConvertLead","field_to_name_array":{"id":"Contactsassigned_user_id","user_name":"Contactsassigned_user_name"}}{/literal}, 
"single", 
true
);' ><span class="suitepicon suitepicon-action-select"></span></button><button type="button" name="btn_clr_Contactsassigned_user_name" id="btn_clr_Contactsassigned_user_name" tabindex="0" title="{sugar_translate label="LBL_ACCESSKEY_CLEAR_USERS_TITLE"}"  class="button lastChild"
onclick="SUGAR.clearRelateField(this.form, 'Contactsassigned_user_name', 'Contactsassigned_user_name_{$fields.assigned_user_name.id_name}');"  value="{sugar_translate label="LBL_ACCESSKEY_CLEAR_USERS_LABEL"}" ><span class="suitepicon suitepicon-action-clear"></span></button>
</span>
<script type="text/javascript">
SUGAR.util.doWhen(
		"typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['{$form_name}_Contactsassigned_user_name']) != 'undefined'",
		enableQS
);
</script>
</div>
</div>
</div>

<div class="col-xs-12 col-sm-12 edit-view-row-item">
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='description_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_DESCRIPTION' module='Contacts'}
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
<textarea  id='Contactsdescription' name='Contactsdescription'
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
addForm('ConvertLead');addToValidateBinaryDependency('ConvertLead', 'assigned_user_name', 'alpha', false,'{/literal}{sugar_translate label='ERR_SQS_NO_MATCH_FIELD' module='Contacts' for_js=true}{literal}: {/literal}{sugar_translate label='LBL_ASSIGNED_TO' module='Contacts' for_js=true}{literal}', 'assigned_user_id' );
addToValidateBinaryDependency('ConvertLead', 'branch_c', 'alpha', true,'{/literal}{sugar_translate label='ERR_SQS_NO_MATCH_FIELD' module='Contacts' for_js=true}{literal}: {/literal}{sugar_translate label='LBL_BRANCH' module='Contacts' for_js=true}{literal}', 'bran_branches_id_c' );
</script><script language="javascript">if(typeof sqs_objects == 'undefined'){var sqs_objects = new Array;}sqs_objects['ConvertLead_Contactsbranch_c']={"form":"ConvertLead","method":"query","modules":["bran_Branches"],"group":"or","field_list":["name","id"],"populate_list":["Contactsbranch_c","Contactsbran_branches_id_c"],"required_list":["parent_id"],"conditions":[{"name":"name","op":"like_custom","end":"%","value":""}],"order":"name","limit":"30","no_match_text":"No Match"};sqs_objects['ConvertLead_Contactsassigned_user_name']={"form":"ConvertLead","method":"get_user_array","field_list":["user_name","id"],"populate_list":["Contactsassigned_user_name","Contactsassigned_user_id"],"required_list":["Contactsassigned_user_id"],"conditions":[{"name":"user_name","op":"like_custom","end":"%","value":""}],"limit":"30","no_match_text":"No Match"};</script>{/literal}
