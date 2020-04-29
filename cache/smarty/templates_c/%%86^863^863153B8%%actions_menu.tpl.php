<?php /* Smarty version 2.6.31, created on 2019-10-11 20:53:48
         compiled from themes/SuiteP/include/DetailView/actions_menu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sugar_button', 'themes/SuiteP/include/DetailView/actions_menu.tpl', 3, false),array('function', 'counter', 'themes/SuiteP/include/DetailView/actions_menu.tpl', 7, false),)), $this); ?>
<ul id="act" class="dropdown-menu">
    <?php if (! isset ( $this->_tpl_vars['form']['buttons'] )): ?>
    <li><?php echo smarty_function_sugar_button(array('module' => ($this->_tpl_vars['module']),'id' => 'EDIT','view' => ($this->_tpl_vars['view']),'form_id' => 'formDetailView'), $this);?>
</li>
    <li><?php echo smarty_function_sugar_button(array('module' => ($this->_tpl_vars['module']),'id' => 'DUPLICATE','view' => 'EditView','form_id' => 'formDetailView'), $this);?>
</li>
    <li><?php echo smarty_function_sugar_button(array('module' => ($this->_tpl_vars['module']),'id' => 'DELETE','view' => ($this->_tpl_vars['view']),'form_id' => 'formDetailView'), $this);?>
</li>
    <?php else: ?>
    <?php echo smarty_function_counter(array('assign' => 'num_buttons','start' => 0,'print' => false), $this);?>

    <?php $_from = $this->_tpl_vars['form']['buttons']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val'] => $this->_tpl_vars['button']):
?>
    <?php if (! is_array ( $this->_tpl_vars['button'] ) && in_array ( $this->_tpl_vars['button'] , $this->_tpl_vars['built_in_buttons'] )): ?>
    <?php echo smarty_function_counter(array('print' => false), $this);?>

    <li><?php echo smarty_function_sugar_button(array('module' => ($this->_tpl_vars['module']),'id' => ($this->_tpl_vars['button']),'view' => 'EditView','form_id' => 'formDetailView'), $this);?>
</li>
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
    <?php if (count ( $this->_tpl_vars['form']['buttons'] ) > $this->_tpl_vars['num_buttons']): ?>
    <?php $_from = $this->_tpl_vars['form']['buttons']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val'] => $this->_tpl_vars['button']):
?>
    <?php if (is_array ( $this->_tpl_vars['button'] ) && $this->_tpl_vars['button']['customCode']): ?>
    <li><?php echo smarty_function_sugar_button(array('module' => ($this->_tpl_vars['module']),'id' => ($this->_tpl_vars['button']),'view' => 'EditView','form_id' => 'formDetailView'), $this);?>
</li>
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
    <?php endif; ?>
    <?php if (empty ( $this->_tpl_vars['form']['hideAudit'] ) || ! $this->_tpl_vars['form']['hideAudit']): ?>
    <li><?php echo smarty_function_sugar_button(array('module' => ($this->_tpl_vars['module']),'id' => 'Audit','view' => 'EditView','form_id' => 'formDetailView'), $this);?>
</li>
    <?php endif; ?>
    <?php endif; ?>
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

</script>