<?php /* Smarty version 2.6.31, created on 2019-10-10 21:32:24
         compiled from include/ListView/ListViewBulkActionSendOptInLink.tpl */ ?>
<a
    href="javascript:void(0)"
    class="parent-dropdown-action-handler"
    id="targetlist_listview"
    onclick="
        sListView.send_form(
            true,
            '<?php echo $this->_tpl_vars['module_name']; ?>
',
            'index.php?entryPoint=sendConfirmOptInEmail&method=confirmOptInSelected',
            '<?php echo $this->_tpl_vars['APP']['LBL_LISTVIEW_NO_SELECTED']; ?>
',
            null,
            '',
            true,
            <?php echo '
            function (resp) {
                alert(resp);
            }
            '; ?>

        );"><?php echo $this->_tpl_vars['APP']['LBL_SEND_CONFIRM_OPT_IN_EMAIL']; ?>
</a>