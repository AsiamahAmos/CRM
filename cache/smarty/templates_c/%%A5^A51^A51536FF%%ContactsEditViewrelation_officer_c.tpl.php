<?php /* Smarty version 2.6.31, created on 2019-11-27 12:58:17
         compiled from cache/include/InlineEditing/ContactsEditViewrelation_officer_c.tpl */ ?>

<?php if (strlen ( $this->_tpl_vars['fields']['relation_officer_c']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['relation_officer_c']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['relation_officer_c']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['relation_officer_c']['name']; ?>
' 
    id='<?php echo $this->_tpl_vars['fields']['relation_officer_c']['name']; ?>
' size='30' 
    maxlength='255' 
    value='<?php echo $this->_tpl_vars['value']; ?>
' title=''  tabindex='1'      >