<?php /* Smarty version 2.6.31, created on 2019-11-02 00:46:58
         compiled from modules/Campaigns/tpls/WizardCampaignTargetListForNonNewsLetter.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sugar_translate', 'modules/Campaigns/tpls/WizardCampaignTargetListForNonNewsLetter.tpl', 257, false),array('function', 'sugar_getimage', 'modules/Campaigns/tpls/WizardCampaignTargetListForNonNewsLetter.tpl', 274, false),)), $this); ?>
<style>
    <?php echo '
    .form-control {
        border-radius: 0;
    }

    .target-list {
        background: #FFFFFF;
    }

    .target-list-create {
        background: #FFFFFF;
    }

    .target-list-table {
        background: #FFFFFF;
    }

    .row {
        padding: 5px;
    }

    '; ?>

</style>

<input type="hidden" id="existing_target_count" name="existing_target_count" value=<?php echo $this->_tpl_vars['TARGET_COUNT']; ?>
>
<input type="hidden" id="added_target_count" name="added_target_count" value=''>
<input type="hidden" id="wiz_list_of_existing_targets" name="wiz_list_of_existing_targets" value="">
<input type="hidden" id="wiz_list_of_targets" name="wiz_list_of_targets" value="">
<input type="hidden" id="wiz_remove_target_list" name="wiz_remove_target_list" value="">


<input id="popup_target_list_type" name="popup_target_list_type" type='hidden'>
<input id="popup_target_list_name" name="popup_target_list_name" type="hidden" value="">
<input id='popup_target_list_id' name='popup_target_list_id' title='List ID' type="hidden" value=''>
<input id='popup_target_list_count' name='popup_target_list_count' title='Number of targets' type="hidden" value=''>

<div class="template-panel">
    <div class="template-panel-container panel">
        <div class="template-container-full">
            <div class="row">
                <div class="col-xs-12"><h4 class="header-4"><?php echo $this->_tpl_vars['MOD']['LBL_TARGET_LISTS']; ?>
</h4></div>
            </div>
            <div class="row">
                <div class="col-xs-12"><label><?php echo $this->_tpl_vars['MOD']['LBL_STEP_INFO_TARGET_LIST_NON_NEWSLETTER']; ?>
</label></div>
            </div>
            <div class="row">
                <div class="col-xs-12  col-sm-4">

                    <?php echo '
                    <script type="text/javascript">
                      var targetListDataJSON = '; ?>
<?php echo $this->_tpl_vars['targetListDataJSON']; ?>
<?php echo ';
                    </script>
                    '; ?>



                    <ul class="target-list">
                        <li><?php echo $this->_tpl_vars['MOD']['LBL_WIZARD_ADD_TARGET']; ?>
</li>
                        <li><input type="text" name="targetListSearch" value=""
                                   placeholder="<?php echo $this->_tpl_vars['MOD']['LBL_SEARCH_TARGET_LIST']; ?>
" style="width: 100%;"></li>
                        <?php $_from = $this->_tpl_vars['targetListData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['targetList']):
?>
                            <li class="target-list-item" data-id="<?php echo $this->_tpl_vars['targetList']['id']; ?>
"><a href="javascript:;"
                                                                                       onclick="addTargetListData('<?php echo $this->_tpl_vars['targetList']['id']; ?>
');"
                                                                                       title="<?php echo $this->_tpl_vars['targetList']['description']; ?>
"><span
                                            class="targetListName"><?php echo $this->_tpl_vars['targetList']['name']; ?>
</span>&nbsp;-&nbsp;<span
                                            class="targetListType"><?php echo $this->_tpl_vars['targetList']['type']; ?>
</span>&nbsp;<span
                                            class="targetListCount">(<?php echo $this->_tpl_vars['targetList']['count']; ?>
)</span></a></li>
                        <?php endforeach; endif; unset($_from); ?>
                    </ul>
                    <?php echo '
                        <script type="text/javascript">
                          $(function () {
                            $(\'input[name="targetListSearch"]\').keyup(function (event) {
                              var keywords = $(this).val();
                              $(\'li.target-list-item\').each(function (i, e) {
                                targetListName = $(e).find(\'a\').html();
                                if (targetListName.toLowerCase().indexOf(keywords.toLowerCase()) > -1) {
                                  $(e).show();
                                }
                                else {
                                  $(e).hide();
                                }
                              });
                            });
                          });
                        </script>
                    '; ?>


                    <div class="target-list-create">

                        <?php echo $this->_tpl_vars['MOD']['LBL_WIZARD_TARGET_MESSAGE2']; ?>
<br>
                        <input id="target_list_name" name="target_list_name" type='text' size='35'
                               placeholder="<?php echo $this->_tpl_vars['MOD']['LBL_TARGET_NAME']; ?>
" style="width: 100%;"><br>

                        <br>

                        <?php echo $this->_tpl_vars['MOD']['LBL_TARGET_TYPE']; ?>
<br>
                        <select id="target_list_type" name="target_list_type"
                                class="form-control input-sm"><?php echo $this->_tpl_vars['TARGET_OPTIONS']; ?>
</select>
                        <input id='target_list_id' name='target_list_id' title='List ID' type="hidden" value=''>
                        <br>

                        <br>

                        <input id="target_list_count" name="target_list_count" type='hidden' size='35' value="0">
                        <input type='button' value='<?php echo $this->_tpl_vars['MOD']['LBL_CREATE_TARGET']; ?>
' class='button'
                               onclick="add_target('false');">

                    </div>
                </div>

                <div class="target-list-table col-xs-12 col-sm-7">

                    <table width='100%' class='detail view'>
                        <tr>
                            <td><?php echo $this->_tpl_vars['MOD']['LBL_TRACKERS_ADDED']; ?>
</td>
                        </tr>
                        <tr>
                            <td>

                                <table border=1 width='100%'>
                                    <tr class='detail view'>
                                        <th scope='col' width='100' style="width:25%; text-align: left;">
                                            <b><?php echo $this->_tpl_vars['MOD']['LBL_TARGET_NAME']; ?>
</b></th>
                                        <th scope='col' width='100' style="width:25%; text-align: left;">
                                            <b><?php echo $this->_tpl_vars['MOD']['LBL_NUMBER_OF_TARGET']; ?>
</b></th>
                                        <th scope='col' width='100' style="width:25%; text-align: left;">
                                            <b><?php echo $this->_tpl_vars['MOD']['LBL_TARGET_TYPE']; ?>
</b></th>
                                        <td>&nbsp;</td>
                                        <td width='100' style="width:25%; text-align: left;"><b>&nbsp;</b></td>
                                    </tr>
                                </table>
                                <div id='added_targets'>
                                    <?php echo $this->_tpl_vars['EXISTING_TARGETS']; ?>

                                </div>
                                <?php echo '
                                    <script type="text/javascript">
                                      $(function () {
                                        setInterval(function () {
                                          if (!$(\'input[name="targetListSearch"]\').val()) {
                                            $(\'li.target-list-item\').show();
                                            $(\'#added_targets input[type="hidden"]\').each(function (i, e) {
                                              if ($(e).attr(\'id\').match(/^added_target_id[0-9]+$/)) {
                                                var targetListId = $(e).val();
                                                $(\'li.target-list-item[data-id="\' + targetListId + \'"]\').hide().attr(\'\');
                                              }
                                            });
                                          }
                                        }, 300);
                                      });
                                    </script>
                                '; ?>



                            </td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
    </div>


    <p>


        <script>
          var image_path = '<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
';
          <?php echo '

          //create variables that will be used to monitor the number of target url
          var targets_added = 0;
          //variable that will be passed back to server to specify list of targets
          var wiz_list_of_targets_array = new Array();

          //this function adds selected target to list
          function add_target(from_popup) {
            //perform validation
            if (validate_step4(from_popup)) {
              TRGTNAME = \'target_list_name\';
              TRGTID = \'target_list_id\';
              TRGTYPE = \'target_list_type\';
              TRGCOUNT = \'target_list_count\';

              if (from_popup == \'true\') {
                TRGTNAME = \'popup_target_list_name\';
                TRGTID = \'popup_target_list_id\';
                TRGTYPE = \'popup_target_list_type\';
                TRGCOUNT = \'popup_target_list_count\';
              }

              //increment target count value
              targets_added++;
              document.getElementById(\'added_target_count\').value = targets_added;
              //get the appropriate values from target form
              var trgt_name = document.getElementById(TRGTNAME);
              var trgt_id = document.getElementById(TRGTID);
              var trgt_type = document.getElementById(TRGTYPE);
              var trgt_count = document.getElementById(TRGCOUNT);
              var trgt_type_text = trgt_type.value;
                '; ?>

              //display the selected display text, not the value
                <?php echo $this->_tpl_vars['PL_DOM_STMT']; ?>

                <?php echo '
              //construct html to display chosen tracker
              var trgt_name_html = "<input id=\'target_name" + targets_added + "\' type=\'hidden\' size=\'20\' maxlength=\'255\' name=\'added_target_name" + targets_added + "\' value=\'" + trgt_name.value + "\' >" + trgt_name.value;
              var trgt_id_html = "<input type=\'hidden\' name=\'added_target_id" + targets_added + "\' id=\'added_target_id" + targets_added + "\' value=\'" + trgt_id.value + "\' >";
              var trgt_type_html = "<input name=\'added_target_type" + targets_added + "\' id=\'added_target_type" + targets_added + "\' type=\'hidden\' value=\'" + trgt_type.value + "\'/>" + trgt_type_text;
              var trgt_count_html = trgt_count.value;

                '; ?>

              //display the html
                <?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_DELETE','module' => 'CAMPAIGNS'), $this);?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('alt_remove', ob_get_contents());ob_end_clean(); ?>
                <?php echo '
              if (trgt_id.value) {
                var targetListName = "<a href=\\"index.php?module=ProspectLists&action=DetailView&record=" + trgt_id.value + "\\" target=\\"_blank\\" title=\\"{$MOD.LBL_OPEN_IN_NEW_WINDOW}\\">" + trgt_name_html + "</a>"
              }
              else {
                var targetListName = trgt_name_html;
              }
                '; ?>

              var trgt_html =
                "<div id='trgt_added_" + targets_added + "'> " +
                "	<table width='100%' class='tabDetailViewDL2'>" +
                "		<tr class='tabDetailViewDL2' >" +
                "			<td width='100' style=\"width:25%\">" + targetListName + "</td>" +
                "			<td width='100' style=\"width:25%\">" + trgt_count_html + "</td>" +
                "			<td width='100' style=\"width:25%\">" + trgt_type_html + "</td>" +
                "			<td width='100' style=\"width:25%\">" + trgt_id_html +
                "				<a href='#' onclick=\"remove_target('trgt_added_" + targets_added + "','" + targets_added + "'); \" >  " + '<?php echo smarty_function_sugar_getimage(array('name' => 'delete_inline','ext' => ".gif",'width' => '12','height' => '12','alt' => $this->_tpl_vars['alt_remove'],'other_attributes' => 'align="absmiddle" border="0" '), $this);?>
' + "<?php echo $this->_tpl_vars['MOD']['LBL_REMOVE']; ?>
</a>" +
                "			</td>" +
                "		</tr>" +
                "	</table>" +
                "</div>";
              document.getElementById('added_targets').innerHTML = document.getElementById('added_targets').innerHTML + trgt_html;

              //add values to array in string, separated by "@@" characters
              wiz_list_of_targets_array[targets_added] = trgt_id.value + "@@" + trgt_name.value + "@@" + trgt_type.value;
              //assign array to hidden input, which will be used by server to process array of targets
              document.getElementById('wiz_list_of_targets').value = wiz_list_of_targets_array.toString();

              //now lets clear the form to allow input of new target
              trgt_name.value = '';
              trgt_id.value = '';
              trgt_type.value = 'default';

                <?php echo '
              if (targets_added == 1) {
                document.getElementById(\'no_targets\').style.display = \'none\';
              }
            }
          }

          //this function will remove the selected target from the ui, and from the target array
          function remove_target(div, num) {
            //clear UI
            var trgt_div = document.getElementById(div);
            trgt_div.style.display = \'none\';
            parentNE = trgt_div.parentNode;
            parentNE.removeChild(trgt_div);
            //clear target array from this entry and assign to form input
            wiz_list_of_targets_array[num] = \'\';
            document.getElementById(\'wiz_list_of_targets\').value = wiz_list_of_targets_array.toString();
          }

          //this function will remove the existing target from the ui, and add it\'s value to an array for removal upon save
          function remove_existing_target(div, id) {
            //clear UI
            var trgt_div = document.getElementById(div);
            trgt_div.style.display = \'none\';
            parentNE = trgt_div.parentNode;
            parentNE.removeChild(trgt_div);
            //assign this id to form input for removal
            document.getElementById(\'wiz_remove_target_list\').value += \',\' + id;
          }


          /*
           * this is the custom validation script that will validate the fields on step3 of wizard
           * this is called directly from the add target button
           */

          function validate_step4(from_popup) {
            if (from_popup == \'true\') {
              return true;
            }
            requiredTxt = SUGAR.language.get(\'app_strings\', \'ERR_MISSING_REQUIRED_FIELDS\');
            var stepname = \'wiz_step3_\';
            var has_error = 0;
            var fields = new Array();
            fields[0] = \'target_list_name\';
            fields[1] = \'target_list_type\';
            //loop through and check for empty strings (\'  \')
            var field_value = \'\';
            if ((trim(document.getElementById(fields[0]).value) != \'\') || (trim(document.getElementById(fields[1]).value) != \'\')) {
              for (i = 0; i < fields.length; i++) {
                field_value = trim(document.getElementById(fields[i]).value);
                if (field_value.length < 1) {
                  add_error_style(\'wizform\', fields[i], requiredTxt + \' \' + document.getElementById(fields[i]).title);
                  has_error = 1;
                }
              }
            } else {
              //no values have been entered, return false without error
              return false;
            }
            //error has been thrown, return false
            if (has_error == 1) {
              return false;
            }
            return true;

          }


          /**
           *This function will iterate through list of targets and gather all the values.  It will
           *populate these values, separated by delimiters into hidden inputs for processing
           */
          function gathertargets() {
            //start with the newly added targets, get count of total added
            count = parseInt(targets_added);
            final_list_of_targets_array = new Array();
            //iterate through list of added targets
            for (i = 1; i <= count; i++) {
              //make sure all values exist
              if (document.getElementById(\'target_name\' + i) && document.getElementById(\'is_optout\' + i) && document.getElementById(\'target_url\' + i)) {
                //make sure the check box value is int (0/1)
                var opt_val = \'0\';
                if (document.getElementById(\'is_optout\' + i).checked) {
                  opt_val = 1;
                }
                //add values for this target entry into array of target entries
                final_list_of_targets_array[i] = document.getElementById(\'target_name\' + i).value + "@@" + opt_val + "@@" + document.getElementById(\'target_url\' + i).value;
              }
            }
            //assign array of target entries to hidden input, which will be used by server to process array of targets
            document.getElementById(\'wiz_list_of_targets\').value = final_list_of_targets_array.toString();

            //Now lets process existing targets, get count of existing targets
            count = parseInt(document.getElementById(\'existing_target_count\').value);
            final_list_of_existing_targets_array = new Array();
            //iterate through list of existing targets
            for (i = 0; i < count; i++) {
              //make sure all values exist
              if (document.getElementById(\'existing_target_name\' + i) && document.getElementById(\'existing_is_optout\' + i) && document.getElementById(\'existing_target_url\' + i)) {
                //make sure the check box value is int (0/1)
                var opt_val = \'0\';
                if (document.getElementById(\'existing_is_optout\' + i).checked) {
                  opt_val = 1;
                }
                //add values for this target entry into array of target entries
                final_list_of_existing_targets_array[i] = document.getElementById(\'existing_target_id\' + i).value + "@@" + document.getElementById(\'existing_target_name\' + i).value + "@@" + opt_val + "@@" + document.getElementById(\'existing_target_url\' + i).value;
              }
            }
            //assign array of target entries to hidden input, which will be used by server to process array of targets
            document.getElementById(\'wiz_list_of_existing_targets\').value = final_list_of_existing_targets_array.toString();


          }

          /*
           *This function will populate values based on popup selection, and then call the
           *function to add the entry to the list of targets
           */
          function set_return_prospect_list(popup_reply_data) {
            var form_name = popup_reply_data.form_name;
            var name_to_value_array = popup_reply_data.name_to_value_array;


            for (var the_key in name_to_value_array) {
              if (the_key == \'toJSON\') {
                  /* just ignore */
              }
              else {
                window.document.forms[form_name].elements[the_key].value = name_to_value_array[the_key];
              }
            }
            add_target(\'true\');
          }


        </script>
        '; ?>
