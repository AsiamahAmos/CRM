
<div>&nbsp;</div>
<span class="color">{$ERROR}</span>
<div class="edit-view-row-item">
<input type="hidden" name="convert_create_Notes" id="convert_create_Notes"
{if ($def.required && empty($def.select)) || (!empty($def.default_action) && $def.default_action == "create")} value="true" {/if}/>
<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">
<input type="hidden" name="case_id" value="{$smarty.request.case_id}">
<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">
<input type="hidden" name="email_id" value="{$smarty.request.email_id}">
<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">
{if $def.required }
<script type="text/javascript">
                        mod_array.push('Notes');//Bug#50590 add all required modules to mod_array
                    </script>
{/if}
{if !$def.required || !empty($def.select)}
<input class="checkbox" type="checkbox" name="newNotes" id="newNotes"
onclick="toggleDisplay('createNotes');if (typeof(addRemoveDropdownElement) == 'function') addRemoveDropdownElement('Notes');{if !empty($def.select)}toggleNotesSelect();{/if}">
<script type="text/javascript">
                                        {if !empty($def.default_action) && $def.default_action == "create"}
                    {if $lead_conv_activity_opt == 'move' || $lead_conv_activity_opt == 'copy' || $lead_conv_activity_opt == ''}
                    YAHOO.util.Event.onContentReady('lead_conv_ac_op_sel', function () {ldelim}
                        {else}
                        YAHOO.util.Event.onContentReady('createNotes', function () {ldelim}
                            {/if}
                            toggleDisplay('createNotes');
                            document.getElementById('newNotes').checked = true;
                            if (typeof(addRemoveDropdownElement) == 'function')
                                addRemoveDropdownElement('Notes');
                                                        {rdelim});
                    {/if}
                    {/if}
                </script>
{sugar_translate label='LNK_NEW_NOTE' module='Leads'}
</span>
</div>
<div class=""
id="createNotes"
{if !$def.required || !empty($def.select)}style="display:none"{/if}>

<div class="col-xs-12 col-sm-12 edit-view-row-item">
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='name_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_NOTE_SUBJECT' module='Notes'}
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
<input type='text' name='Notesname' 
id='Notesname' size='90' 
maxlength='255' 
value='{$value}' title=''      >
</div>
</div>
</div>

<div class="col-xs-12 col-sm-12 edit-view-row-item">
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='description_label'
scope="row" class="col-xs-12 col-sm-12 label" >
{capture name="label" assign="label"}
{sugar_translate label='LBL_DESCRIPTION' module='Notes'}
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
<textarea  id='Notesdescription' name='Notesdescription'
rows="10"
cols="90"
title='' tabindex="0" 
 >{$value}</textarea>
{literal}{/literal}
</div>
</div>
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='_label'
scope="row" class="col-xs-12 col-sm-12 label" >
</div>
<div valign="top"
class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
</div>
</div>
</div>
</div>{literal}
<script type="text/javascript">
addForm('ConvertLead');addToValidateBinaryDependency('ConvertLead', 'assigned_user_name', 'alpha', false,'{/literal}{sugar_translate label='ERR_SQS_NO_MATCH_FIELD' module='Notes' for_js=true}{literal}: {/literal}{sugar_translate label='LBL_ASSIGNED_TO' module='Notes' for_js=true}{literal}', 'assigned_user_id' );
</script>{/literal}
