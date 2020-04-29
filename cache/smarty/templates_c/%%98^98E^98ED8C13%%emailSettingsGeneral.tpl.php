<?php /* Smarty version 2.6.31, created on 2019-10-26 01:37:59
         compiled from modules/Emails/templates/emailSettingsGeneral.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'modules/Emails/templates/emailSettingsGeneral.tpl', 54, false),array('function', 'sugar_getimage', 'modules/Emails/templates/emailSettingsGeneral.tpl', 105, false),)), $this); ?>

<form name="formEmailSettingsGeneral" id="formEmailSettingsGeneral">
    <table cellpadding="4" class="view emailSettings">
        <tr>
            <th colspan="4" colspan="4" scope="row">
                <h4><?php echo $this->_tpl_vars['app_strings']['LBL_EMAIL_SETTINGS_TITLE_PREFERENCES']; ?>
</h4>
            </th>
        </tr>
        <tr>
            <td scope="row">
                <?php echo $this->_tpl_vars['app_strings']['LBL_EMAIL_SETTINGS_CHECK_INTERVAL']; ?>
:
            </td>
            <td>
                <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['emailCheckInterval']['options'],'selected' => $this->_tpl_vars['emailCheckInterval']['selected'],'name' => 'emailCheckInterval','id' => 'emailCheckInterval'), $this);?>

            </td>
            <td scope="row">
                <?php echo $this->_tpl_vars['app_strings']['LBL_DEFAULT_EMAIL_SIGNATURES']; ?>
:
            </td>
            <td>
                <?php echo $this->_tpl_vars['signaturesSettings']; ?>
 <?php echo $this->_tpl_vars['signatureButtons']; ?>

                <input type="hidden" name="signatureDefault" id="signatureDefault" value="<?php echo $this->_tpl_vars['signatureDefaultId']; ?>
">
            </td>
        </tr>
        <tr>
            <td scope="row">
                <?php echo $this->_tpl_vars['app_strings']['LBL_EMAIL_SETTINGS_SEND_EMAIL_AS']; ?>
:
            </td>
            <td>
                <input class="checkbox" type="checkbox" id="sendPlainText" name="sendPlainText"
                       value="1" <?php echo $this->_tpl_vars['sendPlainTextChecked']; ?>
 />
            </td>
            <td scope="row">
                <?php echo $this->_tpl_vars['mod_strings']['LBL_SIGNATURE_PREPEND']; ?>
:
            </td>
            <td>
                <input type="checkbox" name="signature_prepend" <?php echo $this->_tpl_vars['signaturePrepend']; ?>
>
            </td>
        </tr>
        <tr>
            <td scope="row">
                <?php echo $this->_tpl_vars['app_strings']['LBL_EMAIL_CHARSET']; ?>
:
            </td>
            <td>
                <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['charset']['options'],'selected' => $this->_tpl_vars['charset']['selected'],'name' => 'default_charset','id' => 'default_charset'), $this);?>

            </td>
            <td scope="row">
                &nbsp;
            </td>
            <td>
                &nbsp;
            </td>
        </tr>
    </table>
    <table cellpadding="4" cellspacing="0" border="0" class="view">
        <tr>
            <th colspan="4">
                <h4><?php echo $this->_tpl_vars['app_strings']['LBL_EMAIL_SETTINGS_TITLE_LAYOUT']; ?>
</h4>
            </th>
        </tr>
        <tr>
            <td scope="row" width="20%">
                <?php echo $this->_tpl_vars['app_strings']['LBL_EMAIL_SETTINGS_SHOW_NUM_IN_LIST']; ?>
:
                <div id="rollover">
                    <a href="#"
                       class="rollover"><?php echo smarty_function_sugar_getimage(array('alt' => $this->_tpl_vars['mod_strings']['LBL_HELP'],'name' => 'helpInline','ext' => ".gif",'other_attributes' => 'border="0" '), $this);?>

                        <span><?php echo $this->_tpl_vars['app_strings']['LBL_EMAIL_SETTINGS_REQUIRE_REFRESH']; ?>
</span></a>
                </div>
            </td>
            <td>
                <select name="showNumInList" id="showNumInList">
                    <?php echo $this->_tpl_vars['showNumInList']; ?>

                </select>
            </td>
            <td scope="row">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Emails/templates/emailSettingsFolders.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


</form>
