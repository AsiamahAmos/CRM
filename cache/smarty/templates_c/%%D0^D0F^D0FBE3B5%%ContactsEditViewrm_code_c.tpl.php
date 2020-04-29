<?php /* Smarty version 2.6.31, created on 2019-11-26 17:06:11
         compiled from cache/include/InlineEditing/ContactsEditViewrm_code_c.tpl */ ?>

<?php if (strlen ( $this->_tpl_vars['fields']['rm_code_c']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['rm_code_c']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['rm_code_c']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['rm_code_c']['name']; ?>
' 
    id='<?php echo $this->_tpl_vars['fields']['rm_code_c']['name']; ?>
' size='30' 
    maxlength='255' 
    value='<?php echo $this->_tpl_vars['value']; ?>
' title=''  tabindex='1'      >