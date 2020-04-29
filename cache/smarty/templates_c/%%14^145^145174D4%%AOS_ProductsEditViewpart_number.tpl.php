<?php /* Smarty version 2.6.31, created on 2019-10-22 19:31:14
         compiled from cache/include/InlineEditing/AOS_ProductsEditViewpart_number.tpl */ ?>

<?php if (strlen ( $this->_tpl_vars['fields']['part_number']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['part_number']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['part_number']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['part_number']['name']; ?>
' 
    id='<?php echo $this->_tpl_vars['fields']['part_number']['name']; ?>
' size='30' 
    maxlength='25' 
    value='<?php echo $this->_tpl_vars['value']; ?>
' title=''  tabindex='1'      >