<?php /* Smarty version 2.6.31, created on 2019-11-28 17:44:24
         compiled from include/Dashlets/DashletGenericChartConfigure.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'include/Dashlets/DashletGenericChartConfigure.tpl', 73, false),)), $this); ?>


<div>
<form name='configure_<?php echo $this->_tpl_vars['id']; ?>
' action="index.php" method="post" onSubmit='return SUGAR.dashlets.postForm("configure_<?php echo $this->_tpl_vars['id']; ?>
", SUGAR.mySugar.uncoverPage);'>
<input type='hidden' name='id' value='<?php echo $this->_tpl_vars['id']; ?>
'>
<input type='hidden' name='module' value='<?php echo $this->_tpl_vars['module']; ?>
'>
<input type='hidden' name='action' value='DynamicAction'>
<input type='hidden' name='DynamicAction' value='configureDashlet'>
<input type='hidden' name='to_pdf' value='true'>
<input type='hidden' name='configure' value='true'>
<input type='hidden' id='dashletType' name='dashletType' value='<?php echo $this->_tpl_vars['dashletType']; ?>
' />

<table cellpadding="0" cellspacing="0" border="0" width="100%" class="edit view">
	<tr>
	    <td scope='row'>
		    <?php echo $this->_tpl_vars['title']; ?>

        </td>
        <td colspan='3'>
            <input type='text' name='dashletTitle' value='<?php echo $this->_tpl_vars['dashletTitle']; ?>
'>
        </td>
	</tr>
	<?php if ($this->_tpl_vars['isRefreshable']): ?>
    <tr>
	    <td scope='row'>
		    <?php echo $this->_tpl_vars['autoRefresh']; ?>

        </td>
        <td colspan='3'>
            <select name='autoRefresh'>
				<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['autoRefreshOptions'],'selected' => $this->_tpl_vars['autoRefreshSelect']), $this);?>

           	</select>
        </td>
	</tr>
    <?php endif; ?>
    <tr>
    <?php $_from = $this->_tpl_vars['searchFields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['searchIteration'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['searchIteration']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['params']):
        $this->_foreach['searchIteration']['iteration']++;
?>
        <td scope='row' valign='top'>
            <?php echo $this->_tpl_vars['params']['label']; ?>

        </td>
        <td valign='top' style='padding-bottom: 5px'>
            <?php echo $this->_tpl_vars['params']['input']; ?>

        </td>
        <?php if (( !(1 & $this->_foreach['searchIteration']['iteration']) ) && $this->_foreach['searchIteration']['iteration'] != ($this->_foreach['searchIteration']['iteration'] == $this->_foreach['searchIteration']['total'])): ?>
        </tr><tr>
        <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
    </tr>
    <tr>
	    <td colspan='4' align='right'>
	        <input type='submit' class='button' value='<?php echo $this->_tpl_vars['save']; ?>
'>
	        <?php if ($this->_tpl_vars['showClearButton']): ?>
	        <input type='submit' class='button' value='<?php echo $this->_tpl_vars['clear']; ?>
' onclick='SUGAR.searchForm.clear_form(this.form,["dashletTitle","autoRefresh"]);return false;'>
	        <?php endif; ?>
        </td>    
	</tr>
</table>
</form>
</div>