<?php /* Smarty version 2.6.31, created on 2020-02-29 18:26:25
         compiled from cache/themes/SuiteP/modules/Notes/ConvertLead.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sugar_translate', 'cache/themes/SuiteP/modules/Notes/ConvertLead.tpl', 35, false),array('function', 'counter', 'cache/themes/SuiteP/modules/Notes/ConvertLead.tpl', 54, false),array('modifier', 'strip_semicolon', 'cache/themes/SuiteP/modules/Notes/ConvertLead.tpl', 49, false),)), $this); ?>

<div>&nbsp;</div>
<span class="color"><?php echo $this->_tpl_vars['ERROR']; ?>
</span>
<div class="edit-view-row-item">
<input type="hidden" name="convert_create_Notes" id="convert_create_Notes"
<?php if (( $this->_tpl_vars['def']['required'] && empty ( $this->_tpl_vars['def']['select'] ) ) || ( ! empty ( $this->_tpl_vars['def']['default_action'] ) && $this->_tpl_vars['def']['default_action'] == 'create' )): ?> value="true" <?php endif; ?>/>
<input type="hidden" name="opportunity_id" value="<?php echo $_REQUEST['opportunity_id']; ?>
">
<input type="hidden" name="case_id" value="<?php echo $_REQUEST['case_id']; ?>
">
<input type="hidden" name="bug_id" value="<?php echo $_REQUEST['bug_id']; ?>
">
<input type="hidden" name="email_id" value="<?php echo $_REQUEST['email_id']; ?>
">
<input type="hidden" name="inbound_email_id" value="<?php echo $_REQUEST['inbound_email_id']; ?>
">
<?php if ($this->_tpl_vars['def']['required']): ?>
<script type="text/javascript">
                        mod_array.push('Notes');//Bug#50590 add all required modules to mod_array
                    </script>
<?php endif; ?>
<?php if (! $this->_tpl_vars['def']['required'] || ! empty ( $this->_tpl_vars['def']['select'] )): ?>
<input class="checkbox" type="checkbox" name="newNotes" id="newNotes"
onclick="toggleDisplay('createNotes');if (typeof(addRemoveDropdownElement) == 'function') addRemoveDropdownElement('Notes');<?php if (! empty ( $this->_tpl_vars['def']['select'] )): ?>toggleNotesSelect();<?php endif; ?>">
<script type="text/javascript">
                                        <?php if (! empty ( $this->_tpl_vars['def']['default_action'] ) && $this->_tpl_vars['def']['default_action'] == 'create'): ?>
                    <?php if ($this->_tpl_vars['lead_conv_activity_opt'] == 'move' || $this->_tpl_vars['lead_conv_activity_opt'] == 'copy' || $this->_tpl_vars['lead_conv_activity_opt'] == ''): ?>
                    YAHOO.util.Event.onContentReady('lead_conv_ac_op_sel', function () {
                        <?php else: ?>
                        YAHOO.util.Event.onContentReady('createNotes', function () {
                            <?php endif; ?>
                            toggleDisplay('createNotes');
                            document.getElementById('newNotes').checked = true;
                            if (typeof(addRemoveDropdownElement) == 'function')
                                addRemoveDropdownElement('Notes');
                                                        });
                    <?php endif; ?>
                    <?php endif; ?>
                </script>
<?php echo smarty_function_sugar_translate(array('label' => 'LNK_NEW_NOTE','module' => 'Leads'), $this);?>

</span>
</div>
<div class=""
id="createNotes"
<?php if (! $this->_tpl_vars['def']['required'] || ! empty ( $this->_tpl_vars['def']['select'] )): ?>style="display:none"<?php endif; ?>>

<div class="col-xs-12 col-sm-12 edit-view-row-item">
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='name_label'
scope="row" class="col-xs-12 col-sm-12 label" >
<?php ob_start(); ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_NOTE_SUBJECT','module' => 'Notes'), $this);?>

<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
<span class="required">*</span>
</div>
<div valign="top"
colspan='3' class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
<?php echo smarty_function_counter(array('name' => 'panelFieldCount','print' => false), $this);?>


<?php if (strlen ( $this->_tpl_vars['fields']['name']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['name']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['name']['value']); ?>
<?php endif; ?>  
<input type='text' name='Notesname' 
id='Notesname' size='90' 
maxlength='255' 
value='<?php echo $this->_tpl_vars['value']; ?>
' title=''      >
</div>
</div>
</div>

<div class="col-xs-12 col-sm-12 edit-view-row-item">
<div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div valign="top" id='description_label'
scope="row" class="col-xs-12 col-sm-12 label" >
<?php ob_start(); ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_DESCRIPTION','module' => 'Notes'), $this);?>

<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
</div>
<div valign="top"
colspan='3' class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
<?php echo smarty_function_counter(array('name' => 'panelFieldCount','print' => false), $this);?>


<?php if (empty ( $this->_tpl_vars['fields']['description']['value'] )): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['description']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['description']['value']); ?>
<?php endif; ?>
<textarea  id='Notesdescription' name='Notesdescription'
rows="10"
cols="90"
title='' tabindex="0" 
 ><?php echo $this->_tpl_vars['value']; ?>
</textarea>
<?php echo ''; ?>

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
</div><?php echo '
<script type="text/javascript">
addForm(\'ConvertLead\');addToValidateBinaryDependency(\'ConvertLead\', \'assigned_user_name\', \'alpha\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'ERR_SQS_NO_MATCH_FIELD','module' => 'Notes','for_js' => true), $this);?>
<?php echo ': '; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_ASSIGNED_TO','module' => 'Notes','for_js' => true), $this);?>
<?php echo '\', \'assigned_user_id\' );
</script>'; ?>
