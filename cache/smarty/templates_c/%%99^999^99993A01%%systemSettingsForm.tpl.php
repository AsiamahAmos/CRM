<?php /* Smarty version 2.6.31, created on 2019-10-10 21:39:36
         compiled from modules/InboundEmail/tpls/systemSettingsForm.tpl */ ?>
<form action="index.php" method="post" name="Macro" id="form">
    <input type="hidden" name="module" value="InboundEmail">
    <input type="hidden" name="action" value="ListView">
    <input type="hidden" name="save" value="true">

    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td>
                <input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
"
                          accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
"
                          class="button"
                          onclick="this.form.return_module.value='InboundEmail'; this.form.return_action.value='ListView';"
                          type="submit" name="Edit" value="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
">
            </td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail view">
        <tr>
            <td valign="top" width='10%' NOWRAP scope="row">
                <span>
                    <b><?php echo $this->_tpl_vars['MOD']['LBL_CASE_MACRO']; ?>
:</b>
                </span>
            </td>
            <td valign="top" width='20%'>
                <span>
                    <input name="inbound_email_case_macro" type="text" value="<?php echo $this->_tpl_vars['MACRO']; ?>
">
                </span>
            </td>
            <td valign="top" width='70%'>
                <span>
                    <?php echo $this->_tpl_vars['MOD']['LBL_CASE_MACRO_DESC']; ?>

                    <br />
                    <i><?php echo $this->_tpl_vars['MOD']['LBL_CASE_MACRO_DESC2']; ?>
</i>
                </span>
            </td>
        </tr>
    </table>
</form>