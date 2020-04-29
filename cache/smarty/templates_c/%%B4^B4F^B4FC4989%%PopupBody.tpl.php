<?php /* Smarty version 2.6.31, created on 2019-10-29 17:32:13
         compiled from modules/Activities/tpls/PopupBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sugar_include', 'modules/Activities/tpls/PopupBody.tpl', 41, false),array('modifier', 'lower', 'modules/Activities/tpls/PopupBody.tpl', 81, false),array('modifier', 'replace', 'modules/Activities/tpls/PopupBody.tpl', 81, false),)), $this); ?>
<?php echo smarty_function_sugar_include(array('type' => 'smarty','file' => "modules/Activities/tpls/PopupHeader.tpl"), $this);?>


<div class="content">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab"
                                                  data-toggle="tab"><?php echo $this->_tpl_vars['mod']['LBL_OVERVIEW']; ?>
</a>
        </li>
        <li role="presentation"><a href="#tasks" aria-controls="tasks" role="tab"
                                   data-toggle="tab"><?php echo $this->_tpl_vars['mod']['LBL_TASKS']; ?>
</a></li>
        <li role="presentation"><a href="#meetings" aria-controls="meetings" role="tab"
                                   data-toggle="tab"><?php echo $this->_tpl_vars['mod']['LBL_MEETINGS']; ?>
</a></li>
        <li role="presentation"><a href="#calls" aria-controls="calls" role="tab" data-toggle="tab"><?php echo $this->_tpl_vars['mod']['LBL_CALLS']; ?>
</a>
        </li>
        <li role="presentation"><a href="#emails" aria-controls="emails" role="tab"
                                   data-toggle="tab"><?php echo $this->_tpl_vars['mod']['LBL_EMAILS']; ?>
</a>
        </li>
        <li role="presentation"><a href="#notes" aria-controls="notes" role="tab" data-toggle="tab"><?php echo $this->_tpl_vars['mod']['LBL_NOTES']; ?>
</a>
        </li>
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="home">
            <table class="list view table-responsive subpanel-table">
                <thead>
                <tr class="footable-header">
                    <th>
                        <img class="blank-space" src="include/images/blank.gif">
                    </th>
                    <th><?php echo $this->_tpl_vars['mod']['LBL_LIST_SUBJECT']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['mod']['LBL_LIST_STATUS']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['mod']['LBL_LIST_CONTACT']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['mod']['LBL_LIST_DATE']; ?>
</th>
                </tr>
                </thead>

                <tbody>
                <?php $_from = $this->_tpl_vars['summaryList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['activity']):
?>

                    <!-- BEGIN: row -->
                    <td>
                        <span class="suitepicon suitepicon-module-<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['activity']['module'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)))) ? $this->_run_mod_handler('replace', true, $_tmp, '_', '-') : smarty_modifier_replace($_tmp, '_', '-')); ?>
"></span>
                    </td>
                    <td><?php echo $this->_tpl_vars['activity']['name']; ?>
 <?php echo $this->_tpl_vars['activity']['attachment']; ?>
</td>
                    <td><?php echo $this->_tpl_vars['activity']['type']; ?>
 <?php echo $this->_tpl_vars['activity']['status']; ?>
</td>
                    <td><?php echo $this->_tpl_vars['activity']['contact_name']; ?>
</td>
                    <td><?php echo $this->_tpl_vars['activity']['date_type']; ?>
 <?php echo $this->_tpl_vars['activity']['date_modified']; ?>
</td>
                    <!--  BEGIN: description -->
                    <tr>
                        <td colspan="1"></td>
                        <td colspan="4">
                            <table>
                                <tr>
                                    <td><?php echo $this->_tpl_vars['activity']['description']; ?>
</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!--  END: description -->


                <?php endforeach; endif; unset($_from); ?>

                </tbody>
                <!-- END: row -->
            </table>
        </div>

        <div role="tabpanel" class="tab-pane" id="tasks">
            <table class="list view table-responsive subpanel-table">
                <thead>
                <tr class="footable-header">
                    <th>
                        <img class="blank-space" src="include/images/blank.gif">
                    </th>
                    <th><?php echo $this->_tpl_vars['mod']['LBL_LIST_SUBJECT']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['mod']['LBL_LIST_STATUS']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['mod']['LBL_LIST_CONTACT']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['mod']['LBL_LIST_DATE']; ?>
</th>
                </tr>
                </thead>
                <tbody>
                <?php $_from = $this->_tpl_vars['taskslist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['activity']):
?>

                    <!-- BEGIN: row -->
                    <tr>
                        <td>
                            <span class="suitepicon suitepicon-module-<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['activity']['module'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)))) ? $this->_run_mod_handler('replace', true, $_tmp, '_', '-') : smarty_modifier_replace($_tmp, '_', '-')); ?>
"></span>
                        </td>
                        <td><?php echo $this->_tpl_vars['activity']['name']; ?>
 <?php echo $this->_tpl_vars['activity']['attachment']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['activity']['type']; ?>
 <?php echo $this->_tpl_vars['activity']['status']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['activity']['contact_name']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['activity']['date_type']; ?>
 <?php echo $this->_tpl_vars['activity']['date_modified']; ?>
</td>
                    </tr>
                    <!--  BEGIN: description -->
                    <tr>
                        <td colspan="1"></td>
                        <td colspan="4">
                            <table>
                                <tr>
                                    <td><?php echo $this->_tpl_vars['activity']['description']; ?>
</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!--  END: description -->


                <?php endforeach; endif; unset($_from); ?>

                </tbody>
                <!-- END: row -->
            </table>

        </div>

        <div role="tabpanel" class="tab-pane" id="meetings">
            <table class="list view table-responsive subpanel-table">
                <thead>
                <tr class="footable-header">
                    <th>
                        <img class="blank-space" src="include/images/blank.gif">
                    </th>
                    <th><?php echo $this->_tpl_vars['mod']['LBL_LIST_SUBJECT']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['mod']['LBL_LIST_STATUS']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['mod']['LBL_LIST_CONTACT']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['mod']['LBL_LIST_DATE']; ?>
</th>
                </tr>
                </thead>
                <tbody>
                <?php $_from = $this->_tpl_vars['meetingList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['activity']):
?>

                    <!-- BEGIN: row -->
                    <tr>
                        <td>
                            <span class="suitepicon suitepicon-module-<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['activity']['module'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)))) ? $this->_run_mod_handler('replace', true, $_tmp, '_', '-') : smarty_modifier_replace($_tmp, '_', '-')); ?>
"></span>
                        </td>
                        <td><?php echo $this->_tpl_vars['activity']['name']; ?>
 <?php echo $this->_tpl_vars['activity']['attachment']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['activity']['type']; ?>
 <?php echo $this->_tpl_vars['activity']['status']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['activity']['contact_name']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['activity']['date_type']; ?>
 <?php echo $this->_tpl_vars['activity']['date_modified']; ?>
</td>
                    </tr>
                    <!--  BEGIN: description -->
                    <tr>
                        <td colspan="1"></td>
                        <td colspan="4">
                            <table>
                                <tr>
                                    <td><?php echo $this->_tpl_vars['activity']['description']; ?>
</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!--  END: description -->


                <?php endforeach; endif; unset($_from); ?>

                </tbody>
                <!-- END: row -->
            </table>

        </div>

        <div role="tabpanel" class="tab-pane" id="calls">
            <table class="list view table-responsive subpanel-table">
                <thead>
                <tr class="footable-header">
                    <th>
                        <img class="blank-space" src="include/images/blank.gif">
                    </th>
                    <th><?php echo $this->_tpl_vars['mod']['LBL_LIST_SUBJECT']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['mod']['LBL_LIST_STATUS']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['mod']['LBL_LIST_CONTACT']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['mod']['LBL_LIST_DATE']; ?>
</th>
                </tr>
                </thead>
                <tbody>
                <?php $_from = $this->_tpl_vars['callsList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['activity']):
?>

                    <!-- BEGIN: row -->
                    <tr>
                        <td>
                            <span class="suitepicon suitepicon-module-<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['activity']['module'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)))) ? $this->_run_mod_handler('replace', true, $_tmp, '_', '-') : smarty_modifier_replace($_tmp, '_', '-')); ?>
"></span>
                        </td>
                        <td><?php echo $this->_tpl_vars['activity']['name']; ?>
 <?php echo $this->_tpl_vars['activity']['attachment']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['activity']['type']; ?>
 <?php echo $this->_tpl_vars['activity']['status']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['activity']['contact_name']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['activity']['date_type']; ?>
 <?php echo $this->_tpl_vars['activity']['date_modified']; ?>
</td>
                    </tr>
                    <!--  BEGIN: description -->
                    <tr>
                        <td colspan="1"></td>
                        <td colspan="4">
                            <table>
                                <tr>
                                    <td><?php echo $this->_tpl_vars['activity']['description']; ?>
</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!--  END: description -->


                <?php endforeach; endif; unset($_from); ?>

                </tbody>
                <!-- END: row -->
            </table>

        </div>

        <div role="tabpanel" class="tab-pane" id="emails">
            <table class="list view table-responsive subpanel-table">
                <thead>
                <tr class="footable-header">
                    <th>
                        <img class="blank-space" src="include/images/blank.gif">
                    </th>
                    <th><?php echo $this->_tpl_vars['mod']['LBL_LIST_SUBJECT']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['mod']['LBL_LIST_STATUS']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['mod']['LBL_LIST_CONTACT']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['mod']['LBL_LIST_DATE']; ?>
</th>
                </tr>
                </thead>
                <tbody>
                <?php $_from = $this->_tpl_vars['emailsList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['activity']):
?>

                    <!-- BEGIN: row -->
                    <tr>
                        <td>
                            <span class="suitepicon suitepicon-module-<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['activity']['module'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)))) ? $this->_run_mod_handler('replace', true, $_tmp, '_', '-') : smarty_modifier_replace($_tmp, '_', '-')); ?>
"></span>
                        </td>
                        <td><?php echo $this->_tpl_vars['activity']['name']; ?>
 <?php echo $this->_tpl_vars['activity']['attachment']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['activity']['type']; ?>
 <?php echo $this->_tpl_vars['activity']['status']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['activity']['contact_name']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['activity']['date_type']; ?>
 <?php echo $this->_tpl_vars['activity']['date_modified']; ?>
</td>
                    </tr>
                    <!--  BEGIN: description -->
                    <tr>
                        <td colspan="1"></td>
                        <td colspan="4">
                            <table>
                                <tr>
                                    <td><?php echo $this->_tpl_vars['activity']['description']; ?>
</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!--  END: description -->


                <?php endforeach; endif; unset($_from); ?>

                </tbody>
                <!-- END: row -->
            </table>

        </div>

        <div role="tabpanel" class="tab-pane" id="notes">
            <table class="list view table-responsive subpanel-table">
                <thead>
                <tr class="footable-header">
                    <th>
                        <img class="blank-space" src="include/images/blank.gif">
                    </th>
                    <th><?php echo $this->_tpl_vars['mod']['LBL_LIST_SUBJECT']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['mod']['LBL_LIST_STATUS']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['mod']['LBL_LIST_CONTACT']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['mod']['LBL_LIST_DATE']; ?>
</th>
                </tr>
                </thead>
                <tbody>
                <?php $_from = $this->_tpl_vars['notesList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['activity']):
?>

                    <!-- BEGIN: row -->
                    <tr>
                        <td>
                            <span class="suitepicon suitepicon-module-<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['activity']['module'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)))) ? $this->_run_mod_handler('replace', true, $_tmp, '_', '-') : smarty_modifier_replace($_tmp, '_', '-')); ?>
"></span>
                        </td>
                        <td><?php echo $this->_tpl_vars['activity']['name']; ?>
 <?php echo $this->_tpl_vars['activity']['attachment']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['activity']['type']; ?>
 <?php echo $this->_tpl_vars['activity']['status']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['activity']['contact_name']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['activity']['date_type']; ?>
 <?php echo $this->_tpl_vars['activity']['date_modified']; ?>
</td>
                    </tr>
                    <!--  BEGIN: description -->
                    <tr>
                        <td colspan="1"></td>
                        <td colspan="4">
                            <table>
                                <tr>
                                    <td><?php echo $this->_tpl_vars['activity']['description']; ?>
</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!--  END: description -->


                <?php endforeach; endif; unset($_from); ?>

                </tbody>
                <!-- END: row -->
            </table>

        </div>
    </div>
</div>

<?php echo smarty_function_sugar_include(array('type' => 'smarty','file' => "modules/Activities/tpls/PopupFooter.tpl"), $this);?>