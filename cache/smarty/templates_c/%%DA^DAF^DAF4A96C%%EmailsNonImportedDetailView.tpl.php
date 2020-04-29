<?php /* Smarty version 2.6.31, created on 2019-10-15 01:11:28
         compiled from cache/themes/SuiteP/modules/Emails/EmailsNonImportedDetailView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sugar_include', 'cache/themes/SuiteP/modules/Emails/EmailsNonImportedDetailView.tpl', 40, false),array('function', 'sugar_translate', 'cache/themes/SuiteP/modules/Emails/EmailsNonImportedDetailView.tpl', 49, false),array('function', 'counter', 'cache/themes/SuiteP/modules/Emails/EmailsNonImportedDetailView.tpl', 123, false),array('modifier', 'strip_semicolon', 'cache/themes/SuiteP/modules/Emails/EmailsNonImportedDetailView.tpl', 116, false),)), $this); ?>


<script language="javascript">
    <?php echo '
    SUGAR.util.doWhen(function () {
        return $("#contentTable").length == 0;
    }, SUGAR.themes.actionMenu);
    '; ?>

</script>
<table cellpadding="0" cellspacing="0" border="0" width="100%" id="">
<tr>
<td class="buttons" align="left" NOWRAP width="80%">
<div class="actionsContainer">
<form action="index.php" method="post" name="DetailView" id="formDetailView">
<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['module']; ?>
">
<input type="hidden" name="record" value="<?php echo $this->_tpl_vars['fields']['id']['value']; ?>
">
<input type="hidden" name="return_action">
<input type="hidden" name="return_module">
<input type="hidden" name="return_id">
<input type="hidden" name="module_tab">
<input type="hidden" name="isDuplicate" value="false">
<input type="hidden" name="offset" value="<?php echo $this->_tpl_vars['offset']; ?>
">
<input type="hidden" name="action" value="EditView">
<input type="hidden" name="sugar_body_only">
<?php if (! $this->_tpl_vars['config']['enable_action_menu']): ?>
<div class="buttons">
<input type="button" data-action="emails-import-single" data-inbound-email-record="<?php echo $this->_tpl_vars['bean']->inbound_email_record; ?>
" data-email-uid="<?php echo $this->_tpl_vars['bean']->uid; ?>
" data-email-msgno="<?php echo $this->_tpl_vars['bean']->msgNo; ?>
" value="<?php echo $this->_tpl_vars['MOD']['LBL_IMPORT']; ?>
"/>
<input type="button" onclick="window.location.href='index.php?module=Emails&action=ReplyTo&folder=INBOX.TestInbox&folder=inbound&inbound_email_record=<?php echo $this->_tpl_vars['bean']->inbound_email_record; ?>
&uid=<?php echo $this->_tpl_vars['bean']->uid; ?>
&msgno=<?php echo $this->_tpl_vars['bean']->msgNo; ?>
&record=<?php echo $this->_tpl_vars['bean']->id; ?>
';" value="<?php echo $this->_tpl_vars['MOD']['LBL_BUTTON_REPLY_TITLE']; ?>
"/>
<input type="button" onclick="window.location.href='index.php?module=Emails&action=ReplyToAll&folder=INBOX.TestInbox&folder=inbound&inbound_email_record=<?php echo $this->_tpl_vars['bean']->inbound_email_record; ?>
&uid=<?php echo $this->_tpl_vars['bean']->uid; ?>
&msgno=<?php echo $this->_tpl_vars['bean']->msgNo; ?>
&record=<?php echo $this->_tpl_vars['bean']->id; ?>
';" value="<?php echo $this->_tpl_vars['MOD']['LBL_BUTTON_REPLY_ALL']; ?>
"/>
<input type="button" onclick="window.location.href='index.php?module=Emails&action=Forward&folder=INBOX.TestInbox&folder=inbound&inbound_email_record=<?php echo $this->_tpl_vars['bean']->inbound_email_record; ?>
&uid=<?php echo $this->_tpl_vars['bean']->uid; ?>
&msgno=<?php echo $this->_tpl_vars['bean']->msgNo; ?>
&record=<?php echo $this->_tpl_vars['bean']->id; ?>
';" value="<?php echo $this->_tpl_vars['MOD']['LBL_BUTTON_FORWARD']; ?>
"/>
<?php if ($this->_tpl_vars['bean']->aclAccess('detail')): ?><?php if (! empty ( $this->_tpl_vars['fields']['id']['value'] ) && $this->_tpl_vars['isAuditEnabled']): ?><input id="btn_view_change_log" title="<?php echo $this->_tpl_vars['APP']['LNK_VIEW_CHANGE_LOG']; ?>
" class="button" onclick='open_popup("Audit", "600", "400", "&record=<?php echo $this->_tpl_vars['fields']['id']['value']; ?>
&module_name=Emails", true, false,  { "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] } ); return false;' type="button" value="<?php echo $this->_tpl_vars['APP']['LNK_VIEW_CHANGE_LOG']; ?>
"><?php endif; ?><?php endif; ?>
</div>                    <?php endif; ?>
</form>
</div>
</td>
<td align="right" width="20%" class="buttons"><?php echo $this->_tpl_vars['ADMIN_EDIT']; ?>

</td>
</tr>
</table>
<?php echo smarty_function_sugar_include(array('include' => $this->_tpl_vars['includes']), $this);?>

<div class="detail-view">
<div class="mobile-pagination"><?php echo $this->_tpl_vars['PAGINATION']; ?>
</div>

<ul class="nav nav-tabs">

<?php if ($this->_tpl_vars['config']['enable_action_menu'] && $this->_tpl_vars['config']['enable_action_menu'] != false): ?>
<li role="presentation" class="active">
<a id="tab0" data-toggle="tab" class="hidden-xs">
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_EMAIL_INFORMATION','module' => 'Emails'), $this);?>

</a>
<a id="xstab0" href="#" class="visible-xs first-tab dropdown-toggle" data-toggle="dropdown">
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_EMAIL_INFORMATION','module' => 'Emails'), $this);?>

</a>
</li>
<?php endif; ?>
<?php if ($this->_tpl_vars['config']['enable_action_menu'] && $this->_tpl_vars['config']['enable_action_menu'] != false): ?>
<li id="tab-actions" class="dropdown">
<a class="dropdown-toggle" data-toggle="dropdown" href="#">ACTIONS<span class="suitepicon suitepicon-action-caret"></span></a>
<ul id="act" class="dropdown-menu">
<li><input type="button" data-action="emails-import-single" data-inbound-email-record="<?php echo $this->_tpl_vars['bean']->inbound_email_record; ?>
" data-email-uid="<?php echo $this->_tpl_vars['bean']->uid; ?>
" data-email-msgno="<?php echo $this->_tpl_vars['bean']->msgNo; ?>
" value="<?php echo $this->_tpl_vars['MOD']['LBL_IMPORT']; ?>
"/></li>
<li><input type="button" onclick="window.location.href='index.php?module=Emails&action=ReplyTo&folder=INBOX.TestInbox&folder=inbound&inbound_email_record=<?php echo $this->_tpl_vars['bean']->inbound_email_record; ?>
&uid=<?php echo $this->_tpl_vars['bean']->uid; ?>
&msgno=<?php echo $this->_tpl_vars['bean']->msgNo; ?>
&record=<?php echo $this->_tpl_vars['bean']->id; ?>
';" value="<?php echo $this->_tpl_vars['MOD']['LBL_BUTTON_REPLY_TITLE']; ?>
"/></li>
<li><input type="button" onclick="window.location.href='index.php?module=Emails&action=ReplyToAll&folder=INBOX.TestInbox&folder=inbound&inbound_email_record=<?php echo $this->_tpl_vars['bean']->inbound_email_record; ?>
&uid=<?php echo $this->_tpl_vars['bean']->uid; ?>
&msgno=<?php echo $this->_tpl_vars['bean']->msgNo; ?>
&record=<?php echo $this->_tpl_vars['bean']->id; ?>
';" value="<?php echo $this->_tpl_vars['MOD']['LBL_BUTTON_REPLY_ALL']; ?>
"/></li>
<li><input type="button" onclick="window.location.href='index.php?module=Emails&action=Forward&folder=INBOX.TestInbox&folder=inbound&inbound_email_record=<?php echo $this->_tpl_vars['bean']->inbound_email_record; ?>
&uid=<?php echo $this->_tpl_vars['bean']->uid; ?>
&msgno=<?php echo $this->_tpl_vars['bean']->msgNo; ?>
&record=<?php echo $this->_tpl_vars['bean']->id; ?>
';" value="<?php echo $this->_tpl_vars['MOD']['LBL_BUTTON_FORWARD']; ?>
"/></li>
<li><?php if ($this->_tpl_vars['bean']->aclAccess('detail')): ?><?php if (! empty ( $this->_tpl_vars['fields']['id']['value'] ) && $this->_tpl_vars['isAuditEnabled']): ?><input id="btn_view_change_log" title="<?php echo $this->_tpl_vars['APP']['LNK_VIEW_CHANGE_LOG']; ?>
" class="button" onclick='open_popup("Audit", "600", "400", "&record=<?php echo $this->_tpl_vars['fields']['id']['value']; ?>
&module_name=Emails", true, false,  { "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] } ); return false;' type="button" value="<?php echo $this->_tpl_vars['APP']['LNK_VIEW_CHANGE_LOG']; ?>
"><?php endif; ?><?php endif; ?></li>
</ul>
<script>
    // $('#act').append('<li ><input id="sms" onclick="sms();" class="button" value="Send SMS" type="button"></li>');
//////:::::::Compose-email button on the action menu of contacts details::://///////Code also in contacts/contacts.js
// var email = $('.email-link').attr('onclick');
// var id = $('.email-link').attr('data-record-id');
// var name = $('.email-link').attr('data-module-name');
// var address = $('.email-link').attr('data-email-address');

// var currentTab = $('#moduleTab_Contacts').text();
// //alert(currentTab);
// if(currentTab=='Contacts')
// $('#act').append('<li><input id="bb" class="button" onclick="'+email+'" type="button" data-email-address="'+address+'" data-module="Contacts" data-module-name="'+name+'" data-record-id="'+id+'"  value="Compose Email"></li> <li><input id="sms" onclick="sms();" class="button" value="Send SMS" type="button"></li>');
  
// ///////////End of the button NB: Send SMS button is also part/////////////////////////

</script>        </li>
<li class="tab-inline-pagination">
<?php echo $this->_tpl_vars['PAGINATION']; ?>

</li>
<?php endif; ?>
</ul>
<div class="clearfix"></div>

<?php if ($this->_tpl_vars['config']['enable_action_menu'] && $this->_tpl_vars['config']['enable_action_menu'] != false): ?>

<div class="tab-content">
<?php else: ?>

<div class="tab-content" style="padding: 0; border: 0;">
<?php endif; ?>


<?php if ($this->_tpl_vars['config']['enable_action_menu'] && $this->_tpl_vars['config']['enable_action_menu'] != false): ?>
<div class="tab-pane-NOBOOTSTRAPTOGGLER active fade in" id='tab-content-0'>





<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_OPT_IN','module' => 'Emails'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="function" field="opt_in" colspan='3' >

<?php if (! $this->_tpl_vars['fields']['opt_in']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount','print' => false), $this);?>

<span id='opt_in_span'>
<?php echo $this->_tpl_vars['fields']['opt_in']['value']; ?>

</span>
<?php endif; ?>

</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_FROM','module' => 'Emails'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="varchar" field="from_addr_name" colspan='3' >

<?php if (! $this->_tpl_vars['fields']['from_addr_name']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount','print' => false), $this);?>


<?php if (strlen ( $this->_tpl_vars['fields']['from_addr_name']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['from_addr_name']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['from_addr_name']['value']); ?>
<?php endif; ?> 
<span class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['from_addr_name']['name']; ?>
"><?php echo $this->_tpl_vars['fields']['from_addr_name']['value']; ?>
</span>
<?php endif; ?>

</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_TO','module' => 'Emails'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="varchar" field="to_addrs_names" colspan='3' >

<?php if (! $this->_tpl_vars['fields']['to_addrs_names']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount','print' => false), $this);?>


<?php if (strlen ( $this->_tpl_vars['fields']['to_addrs_names']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['to_addrs_names']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['to_addrs_names']['value']); ?>
<?php endif; ?> 
<span class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['to_addrs_names']['name']; ?>
"><?php echo $this->_tpl_vars['fields']['to_addrs_names']['value']; ?>
</span>
<?php endif; ?>

</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_CC','module' => 'Emails'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="varchar" field="cc_addrs_names" colspan='3' >

<?php if (! $this->_tpl_vars['fields']['cc_addrs_names']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount','print' => false), $this);?>


<?php if (strlen ( $this->_tpl_vars['fields']['cc_addrs_names']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['cc_addrs_names']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['cc_addrs_names']['value']); ?>
<?php endif; ?> 
<span class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['cc_addrs_names']['name']; ?>
"><?php echo $this->_tpl_vars['fields']['cc_addrs_names']['value']; ?>
</span>
<?php endif; ?>

</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_BCC','module' => 'Emails'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="varchar" field="bcc_addrs_names" colspan='3' >

<?php if (! $this->_tpl_vars['fields']['bcc_addrs_names']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount','print' => false), $this);?>


<?php if (strlen ( $this->_tpl_vars['fields']['bcc_addrs_names']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['bcc_addrs_names']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['bcc_addrs_names']['value']); ?>
<?php endif; ?> 
<span class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['bcc_addrs_names']['name']; ?>
"><?php echo $this->_tpl_vars['fields']['bcc_addrs_names']['value']; ?>
</span>
<?php endif; ?>

</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_SUBJECT','module' => 'Emails'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="name" field="name" colspan='3' >

<?php if (! $this->_tpl_vars['fields']['name']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount','print' => false), $this);?>


<?php if (strlen ( $this->_tpl_vars['fields']['name']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['name']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['name']['value']); ?>
<?php endif; ?> 
<span class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['name']['name']; ?>
"><?php echo $this->_tpl_vars['fields']['name']['value']; ?>
</span>
<?php endif; ?>

</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_BODY','module' => 'Emails'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="emailbody" field="description_html" colspan='3' >

<?php if (! $this->_tpl_vars['fields']['description_html']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount','print' => false), $this);?>


<span class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['description_html']['name']; ?>
"><?php echo $this->_tpl_vars['fields']['description_html']['value']; ?>
</span>
<?php endif; ?>

</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_DATE_ENTERED','module' => 'Emails'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="datetime" field="date_entered" colspan='3' >

<?php if (! $this->_tpl_vars['fields']['date_entered']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount','print' => false), $this);?>



<?php $this->assign('value', "10/01/2019"); ?>
<span class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['date_entered']['name']; ?>
"><?php echo $this->_tpl_vars['value']; ?>
</span>
<?php endif; ?>

</div>


</div>




<div class="col-xs-12 col-sm-6 detail-view-row-item">
</div>

<div class="clear"></div>
</div>
                        </div>
<?php else: ?>

<div class="tab-pane-NOBOOTSTRAPTOGGLER panel-collapse"></div>
<?php endif; ?>
</div>

<div class="panel-content">
<div>&nbsp;</div>





<?php if ($this->_tpl_vars['config']['enable_action_menu'] && $this->_tpl_vars['config']['enable_action_menu'] != false): ?>

<?php else: ?>

<div class="panel panel-default">
<div class="panel-heading ">
<a class="" role="button" data-toggle="collapse" href="#top-panel--1" aria-expanded="false">
<div class="col-xs-10 col-sm-11 col-md-11">
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_EMAIL_INFORMATION','module' => 'Emails'), $this);?>

</div>
</a>
</div>
<div class="panel-body panel-collapse collapse in panelContainer" id="top-panel--1" data-id="LBL_EMAIL_INFORMATION">
<div class="tab-content">
<!-- TAB CONTENT -->





<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_OPT_IN','module' => 'Emails'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="function" field="opt_in" colspan='3' >

<?php if (! $this->_tpl_vars['fields']['opt_in']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount','print' => false), $this);?>

<span id='opt_in_span'>
<?php echo $this->_tpl_vars['fields']['opt_in']['value']; ?>

</span>
<?php endif; ?>

</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_FROM','module' => 'Emails'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="varchar" field="from_addr_name" colspan='3' >

<?php if (! $this->_tpl_vars['fields']['from_addr_name']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount','print' => false), $this);?>


<?php if (strlen ( $this->_tpl_vars['fields']['from_addr_name']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['from_addr_name']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['from_addr_name']['value']); ?>
<?php endif; ?> 
<span class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['from_addr_name']['name']; ?>
"><?php echo $this->_tpl_vars['fields']['from_addr_name']['value']; ?>
</span>
<?php endif; ?>

</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_TO','module' => 'Emails'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="varchar" field="to_addrs_names" colspan='3' >

<?php if (! $this->_tpl_vars['fields']['to_addrs_names']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount','print' => false), $this);?>


<?php if (strlen ( $this->_tpl_vars['fields']['to_addrs_names']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['to_addrs_names']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['to_addrs_names']['value']); ?>
<?php endif; ?> 
<span class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['to_addrs_names']['name']; ?>
"><?php echo $this->_tpl_vars['fields']['to_addrs_names']['value']; ?>
</span>
<?php endif; ?>

</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_CC','module' => 'Emails'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="varchar" field="cc_addrs_names" colspan='3' >

<?php if (! $this->_tpl_vars['fields']['cc_addrs_names']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount','print' => false), $this);?>


<?php if (strlen ( $this->_tpl_vars['fields']['cc_addrs_names']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['cc_addrs_names']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['cc_addrs_names']['value']); ?>
<?php endif; ?> 
<span class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['cc_addrs_names']['name']; ?>
"><?php echo $this->_tpl_vars['fields']['cc_addrs_names']['value']; ?>
</span>
<?php endif; ?>

</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_BCC','module' => 'Emails'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="varchar" field="bcc_addrs_names" colspan='3' >

<?php if (! $this->_tpl_vars['fields']['bcc_addrs_names']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount','print' => false), $this);?>


<?php if (strlen ( $this->_tpl_vars['fields']['bcc_addrs_names']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['bcc_addrs_names']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['bcc_addrs_names']['value']); ?>
<?php endif; ?> 
<span class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['bcc_addrs_names']['name']; ?>
"><?php echo $this->_tpl_vars['fields']['bcc_addrs_names']['value']; ?>
</span>
<?php endif; ?>

</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_SUBJECT','module' => 'Emails'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="name" field="name" colspan='3' >

<?php if (! $this->_tpl_vars['fields']['name']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount','print' => false), $this);?>


<?php if (strlen ( $this->_tpl_vars['fields']['name']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['name']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['name']['value']); ?>
<?php endif; ?> 
<span class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['name']['name']; ?>
"><?php echo $this->_tpl_vars['fields']['name']['value']; ?>
</span>
<?php endif; ?>

</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_BODY','module' => 'Emails'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="emailbody" field="description_html" colspan='3' >

<?php if (! $this->_tpl_vars['fields']['description_html']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount','print' => false), $this);?>


<span class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['description_html']['name']; ?>
"><?php echo $this->_tpl_vars['fields']['description_html']['value']; ?>
</span>
<?php endif; ?>

</div>


</div>

</div>


<div class="row detail-view-row">



<div class="col-xs-12 col-sm-12 detail-view-row-item">


<div class="col-xs-12 col-sm-2 label col-1-label">


<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_DATE_ENTERED','module' => 'Emails'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
</div>


<div class="col-xs-12 col-sm-10 detail-view-field " type="datetime" field="date_entered" colspan='3' >

<?php if (! $this->_tpl_vars['fields']['date_entered']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount','print' => false), $this);?>



<?php $this->assign('value', "10/01/2019"); ?>
<span class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['date_entered']['name']; ?>
"><?php echo $this->_tpl_vars['value']; ?>
</span>
<?php endif; ?>

</div>


</div>




<div class="col-xs-12 col-sm-6 detail-view-row-item">
</div>

<div class="clear"></div>
</div>
                            </div>
</div>
</div>
<?php endif; ?>
</div>
</div>

</form>
<script>SUGAR.util.doWhen("document.getElementById('form') != null",
        function(){SUGAR.util.buildAccessKeyLabels();});
</script>            <script type="text/javascript" src="include/InlineEditing/inlineEditing.js"></script>
<script type="text/javascript" src="modules/Favorites/favorites.js"></script>
<?php echo '
<script type="text/javascript">

/////////////////////////////////////////////////////////////////////
///////////Code also in contacts/contacts.js::::::///////////////////
var client_id_c = $(\'#client_id_c\').html(); //fetch the client id from the contacts form.
var currentTab = $(\'#moduleTab_Contacts\').text();
//alert(currentTab) get current tab thus contacts module/////;

if(currentTab==\'Contacts\'){ //execute if only in contacts module////
//$(\'#tab-content-3\').html(\'client_id_c\');
/////////Ajax code for services subscribed///////
$.ajax({

    type:"POST",
    url:"http://192.168.1.225/gg/img/customer360/services2.php",
    data:{client_id_c:client_id_c},
    success : function(results) {
    $(\'#tab-content-2\').html(results);
   }
}) ;
///////End of services////////////

/////Ajax code for products subscribed/////
$.ajax({

    type:"POST",
    url:"http://192.168.1.225/gg/img/customer360/products.php",
    data:{client_id_c:client_id_c},
    success : function(results) {
    $(\'#tab-content-3\').html(results);
   }
}) ;
//////End of products////////////////////

/////Ajax code for preferrence subscribed/////
$.ajax({

    type:"POST",
    url:"http://192.168.1.225/gg/img/customer360/client-pref.php",
    data:{client_id_c:client_id_c},
    success : function(results) {
    $(\'#tab-content-4\').html(results);
   }
}) ;
//////End of preferrence////////////////////
}
// //////::::::::Compose-email button on the action menu of contacts details:::/// 
// var email = $(\'.email-link\').attr(\'onclick\');
// var id = $(\'.email-link\').attr(\'data-record-id\');
// var name = $(\'.email-link\').attr(\'data-module-name\');
// var address = $(\'.email-link\').attr(\'data-email-address\');

// $(\'.dropdown-menu\').append(\'<li><input id="bb" class="button" onclick="\'+email+\'" type="button" data-email-address="\'+address+\'" data-module="Contacts" data-module-name="\'+name+\'" data-record-id="\'+id+\'"  value="Compose Email"></li><li ><input id="sms" onclick="sms();" class="button" value="Send SMS" type="button"></li>\');
// ///////////End of the button NB: Send SMS button is also part/////////////////////////

// /////function to call the sms modal////
// function sms(){
//     $(\'#empModal\').modal(\'show\');
// };
// ///////end///////////////////////////



/////////////////////////////////////////////////////////////////////////
                    var selectTabDetailView = function(tab) {
                        $(\'#content div.tab-content div.tab-pane-NOBOOTSTRAPTOGGLER\').hide();
                        $(\'#content div.tab-content div.tab-pane-NOBOOTSTRAPTOGGLER\').eq(tab).show().addClass(\'active\').addClass(\'in\');
                    };

                    var selectTabOnError = function(tab) {
                        selectTabDetailView(tab);
                        $(\'#content ul.nav.nav-tabs > li\').removeClass(\'active\');
                        $(\'#content ul.nav.nav-tabs > li a\').css(\'color\', \'\');

                        $(\'#content ul.nav.nav-tabs > li\').eq(tab).find(\'a\').first().css(\'color\', \'red\');
                        $(\'#content ul.nav.nav-tabs > li\').eq(tab).addClass(\'active\');

                    };

                    var selectTabOnErrorInputHandle = function(inputHandle) {
                        var tab = $(inputHandle).closest(\'.tab-pane-NOBOOTSTRAPTOGGLER\').attr(\'id\').match(/^detailpanel_(.*)$/)[1];
                        selectTabOnError(tab);
                    };


                    $(function(){
                        $(\'#content ul.nav.nav-tabs > li > a[data-toggle="tab"]\').click(function(e){
                            if(typeof $(this).parent().find(\'a\').first().attr(\'id\') != \'undefined\') {
                                var tab = parseInt($(this).parent().find(\'a\').first().attr(\'id\').match(/^tab(.)*$/)[1]);
                                selectTabDetailView(tab);
                            }
                        });
                    });

                </script>
'; ?>