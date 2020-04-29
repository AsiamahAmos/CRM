<?php /* Smarty version 2.6.31, created on 2019-12-03 14:26:12
         compiled from themes%5CSuiteP%5Cmodules/Leads/tpls/ConvertLead.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'themes\\SuiteP\\modules/Leads/tpls/ConvertLead.tpl', 47, false),array('function', 'sugar_field', 'themes\\SuiteP\\modules/Leads/tpls/ConvertLead.tpl', 108, false),array('function', 'sugar_evalcolumn', 'themes\\SuiteP\\modules/Leads/tpls/ConvertLead.tpl', 197, false),array('modifier', 'strtoupper', 'themes\\SuiteP\\modules/Leads/tpls/ConvertLead.tpl', 102, false),array('modifier', 'count', 'themes\\SuiteP\\modules/Leads/tpls/ConvertLead.tpl', 133, false),)), $this); ?>
{*
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2016 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */
*}


<div>&nbsp;</div>
<?php $this->assign('selectRelation', $this->_tpl_vars['selectFields'][$this->_tpl_vars['module']]); ?>
<span class="color">{$ERROR}</span>
<?php $_from = $this->_tpl_vars['sectionPanels']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['section'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['section']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['label'] => $this->_tpl_vars['panel']):
        $this->_foreach['section']['iteration']++;
?>
<?php echo smarty_function_counter(array('name' => 'panelCount','print' => false), $this);?>

<div class="edit-view-row-item">
                <input type="hidden" name="convert_create_<?php echo $this->_tpl_vars['module']; ?>
" id="convert_create_<?php echo $this->_tpl_vars['module']; ?>
"
                        {if ($def.required && empty($def.select)) || (!empty($def.default_action) && $def.default_action == "create")} value="true" {/if}/>

                <?php if (isset ( $this->_tpl_vars['def']['templateMeta']['form']['hidden'] )): ?>
                <?php $_from = $this->_tpl_vars['def']['templateMeta']['form']['hidden']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['field']):
?>
                <?php echo $this->_tpl_vars['field']; ?>

                <?php endforeach; endif; unset($_from); ?>
                <?php endif; ?>
                {if $def.required }
                    <script type="text/javascript">
                        mod_array.push('<?php echo $this->_tpl_vars['module']; ?>
');//Bug#50590 add all required modules to mod_array
                    </script>
                {/if}
                {if !$def.required || !empty($def.select)}
                <input class="checkbox" type="checkbox" name="new<?php echo $this->_tpl_vars['module']; ?>
" id="new<?php echo $this->_tpl_vars['module']; ?>
"
                       onclick="toggleDisplay('create<?php echo $this->_tpl_vars['module']; ?>
');if (typeof(addRemoveDropdownElement) == 'function') addRemoveDropdownElement('<?php echo $this->_tpl_vars['module']; ?>
');{if !empty($def.select)}toggle<?php echo $this->_tpl_vars['module']; ?>
Select();{/if}">
                <script type="text/javascript">
                    <?php if (! empty ( $this->_tpl_vars['selectRelation'] )): ?>
                    {if !empty($def.select)}
                    toggle<?php echo $this->_tpl_vars['module']; ?>
Select = function () {ldelim}
                        var inputs = document.getElementById('select<?php echo $this->_tpl_vars['module']; ?>
').getElementsByTagName('input');
                        for (var i in inputs) {
                            ldelim}inputs[i].disabled = !inputs[i].disabled;{rdelim}
                    var buttons = document.getElementById('select<?php echo $this->_tpl_vars['module']; ?>
').getElementsByTagName('button');
                    for (var i in buttons) {
                        ldelim}buttons[i].disabled = !buttons[i].disabled;{rdelim}
                    {rdelim}
                    {/if}
                    <?php endif; ?>
                    {if !empty($def.default_action) && $def.default_action == "create"}
                    {if $lead_conv_activity_opt == 'move' || $lead_conv_activity_opt == 'copy' || $lead_conv_activity_opt == ''}
                    YAHOO.util.Event.onContentReady('lead_conv_ac_op_sel', function () {ldelim}
                        {else}
                        YAHOO.util.Event.onContentReady('create<?php echo $this->_tpl_vars['module']; ?>
', function () {ldelim}
                            {/if}
                            toggleDisplay('create<?php echo $this->_tpl_vars['module']; ?>
');
                            document.getElementById('new<?php echo $this->_tpl_vars['module']; ?>
').checked = true;
                            if (typeof(addRemoveDropdownElement) == 'function')
                                addRemoveDropdownElement('<?php echo $this->_tpl_vars['module']; ?>
');
                            <?php if (! empty ( $this->_tpl_vars['selectRelation'] )): ?>
                            {if !empty($def.select)}
                            toggle<?php echo $this->_tpl_vars['module']; ?>
Select();
                            {/if}
                            <?php endif; ?>
                            {rdelim});
                    {/if}
                    {/if}
                </script>

                {sugar_translate label='<?php echo $this->_tpl_vars['label']; ?>
' module='Leads'}

                <?php if (! empty ( $this->_tpl_vars['selectRelation'] )): ?>
                {if !empty($def.select)}
                {sugar_translate label='LNK_SELECT_<?php echo ((is_array($_tmp=$this->_tpl_vars['module'])) ? $this->_run_mod_handler('strtoupper', true, $_tmp) : strtoupper($_tmp)); ?>
' module='Leads'}
                {if $def.required }
                    <span class="required"><?php echo $this->_tpl_vars['APP']['LBL_REQUIRED_SYMBOL']; ?>
</span>
                {/if}

            <span id="select<?php echo $this->_tpl_vars['module']; ?>
">
                <?php echo smarty_function_sugar_field(array('parentFieldArray' => 'contact_def','vardef' => $this->_tpl_vars['contact_def'][$this->_tpl_vars['selectRelation']],'displayType' => 'EditView','displayParams' => $this->_tpl_vars['displayParams'],'formName' => $this->_tpl_vars['form_name'],'call_back_function' => 'set_return_lead_conv'), $this);?>

                <script>
                    if (typeof(sqs_objects) == "undefined") sqs_objects = [];
                    sqs_objects['<?php echo $this->_tpl_vars['form_name']; ?>
_{$selectFields.<?php echo $this->_tpl_vars['module']; ?>
}'] = {ldelim}
                        form: '<?php echo $this->_tpl_vars['form_name']; ?>
',
                        method: 'query',
                        modules: ['<?php echo $this->_tpl_vars['module']; ?>
'],
                        group: 'or',
                        field_list: ['name', 'id'],
                        populate_list: ['{$selectFields.<?php echo $this->_tpl_vars['module']; ?>
}', '{$contact_def[$selectFields.<?php echo $this->_tpl_vars['module']; ?>
].id_name}'],
                        conditions: [{ldelim}'name': 'name', 'op': 'like_custom', 'end': '%', 'value': ''{rdelim}],
                        required_list: ['{$contact_def[$selectFields.<?php echo $this->_tpl_vars['module']; ?>
].id_name}'],
                        order: 'name',
                        limit: '10'
                        {rdelim}
                </script>
                {/if}
                <?php endif; ?>
            </span>
</div>
<div class=""
      id="create<?php echo $this->_tpl_vars['module']; ?>
"
       {if !$def.required || !empty($def.select)}style="display:none"{/if}>
    <?php $this->assign('rowCount', 0); ?>
    <?php $_from = $this->_tpl_vars['panel']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['rowIteration'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['rowIteration']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['row'] => $this->_tpl_vars['rowData']):
        $this->_foreach['rowIteration']['iteration']++;
?>
    <?php $this->assign('columnsInRow', count($this->_tpl_vars['rowData'])); ?>
    <?php $this->assign('columnsUsed', 0); ?>



                <?php echo smarty_function_counter(array('name' => 'colCount','start' => 0,'print' => false,'assign' => 'colCount'), $this);?>

    {*column*}
    <?php if ($this->_foreach['colCount']['total'] > 1): ?>
        <div class="col-xs-12 col-sm-6 edit-view-row-item">
      <?php else: ?>
        <div class="col-xs-12 col-sm-12 edit-view-row-item">
    <?php endif; ?>


        <?php $_from = $this->_tpl_vars['rowData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['colIteration'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['colIteration']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['col'] => $this->_tpl_vars['colData']):
        $this->_foreach['colIteration']['iteration']++;
?>

        <?php if ($this->_foreach['colCount']['total'] > 1): ?>
        <div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <?php else: ?>
        <div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <?php endif; ?>

            <?php echo smarty_function_counter(array('name' => 'colCount','print' => false), $this);?>

            <?php if (count ( $this->_tpl_vars['rowData'] ) == $this->_tpl_vars['colCount']): ?>
            <?php $this->assign('colCount', 0); ?>
            <?php endif; ?>
            <?php if (empty ( $this->_tpl_vars['def']['templateMeta']['labelsOnTop'] ) && empty ( $this->_tpl_vars['colData']['field']['hideLabel'] )): ?>
            <div valign="top" id='<?php echo $this->_tpl_vars['colData']['field']['name']; ?>
_label'
                scope="row" class="col-xs-12 col-sm-12 label" >
                <?php if (isset ( $this->_tpl_vars['colData']['field']['customLabel'] )): ?>
                <?php echo $this->_tpl_vars['colData']['field']['customLabel']; ?>

                <?php elseif (isset ( $this->_tpl_vars['colData']['field']['label'] )): ?>
                {capture name="label" assign="label"}
                    {sugar_translate label='<?php echo $this->_tpl_vars['colData']['field']['label']; ?>
' module='<?php echo $this->_tpl_vars['module']; ?>
'}
                {/capture}
                {$label|strip_semicolon}:
                <?php elseif (isset ( $this->_tpl_vars['fields'][$this->_tpl_vars['colData']['field']['name']] )): ?>
                {capture name="label" assign="label"}
                    {sugar_translate label='<?php echo $this->_tpl_vars['fields'][$this->_tpl_vars['colData']['field']['name']]['vname']; ?>
' module='<?php echo $this->_tpl_vars['module']; ?>
'}
                {/capture}
                {$label|strip_semicolon}:
                <?php endif; ?>
                                <?php if (( $this->_tpl_vars['fields'][$this->_tpl_vars['colData']['field']['name']]['required'] && ! isset ( $this->_tpl_vars['colData']['field']['displayParams']['required'] ) ) || ( isset ( $this->_tpl_vars['colData']['field']['displayParams']['required'] ) && $this->_tpl_vars['colData']['field']['displayParams']['required'] )): ?>
                <span class="required"><?php echo $this->_tpl_vars['APP']['LBL_REQUIRED_SYMBOL']; ?>
</span>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <div valign="top"
                <?php if ($this->_tpl_vars['colData']['colspan']): ?>colspan='<?php echo $this->_tpl_vars['colData']['colspan']; ?>
'<?php endif; ?> class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
                <?php if ($this->_tpl_vars['fields'][$this->_tpl_vars['colData']['field']['name']] && ! empty ( $this->_tpl_vars['colData']['field']['fields'] )): ?>
                <?php $_from = $this->_tpl_vars['colData']['field']['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['subField']):
?>
                <?php if ($this->_tpl_vars['fields'][$this->_tpl_vars['subField']['name']]): ?>
                {counter name="panelFieldCount" print=false}
                <?php echo smarty_function_sugar_field(array('parentFieldArray' => 'fields','tabindex' => $this->_tpl_vars['colData']['field']['tabindex'],'vardef' => $this->_tpl_vars['fields'][$this->_tpl_vars['subField']['name']],'displayType' => 'EditView','displayParams' => $this->_tpl_vars['subField']['displayParams'],'formName' => $this->_tpl_vars['form_name']), $this);?>

                &nbsp;
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
                <?php elseif (! empty ( $this->_tpl_vars['colData']['field']['customCode'] )): ?>
                {counter name="panelFieldCount" print=false}
                <?php $this->_tpl_vars['colData']['field']['displayParams']['idName'] = $this->_tpl_vars['module'] .
                $this->_tpl_vars['colData']['field']['name']; ?>
                <?php echo smarty_function_sugar_evalcolumn(array('var' => $this->_tpl_vars['colData']['field']['customCode'],'colData' => $this->_tpl_vars['colData'],'tabindex' => $this->_tpl_vars['colData']['field']['tabindex']), $this);?>

                <?php elseif ($this->_tpl_vars['fields'][$this->_tpl_vars['colData']['field']['name']]): ?>
                {counter name="panelFieldCount" print=false}
                <?php echo $this->_tpl_vars['colData']['displayParams']; ?>

                <?php $this->_tpl_vars['colData']['field']['displayParams']['idName'] = $this->_tpl_vars['module'] .
                $this->_tpl_vars['colData']['field']['name']; ?>
                <?php echo smarty_function_sugar_field(array('parentFieldArray' => 'fields','tabindex' => $this->_tpl_vars['colData']['field']['tabindex'],'vardef' => $this->_tpl_vars['fields'][$this->_tpl_vars['colData']['field']['name']],'displayType' => 'EditView','displayParams' => $this->_tpl_vars['colData']['field']['displayParams'],'typeOverride' => $this->_tpl_vars['colData']['field']['type'],'formName' => $this->_tpl_vars['form_name']), $this);?>

                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; endif; unset($_from); ?>
    </div>

    <?php endforeach; endif; unset($_from); ?>
</div>
<?php endforeach; endif; unset($_from); ?>