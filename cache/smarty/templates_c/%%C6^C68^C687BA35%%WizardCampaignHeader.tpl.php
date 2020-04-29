<?php /* Smarty version 2.6.31, created on 2019-11-02 00:46:58
         compiled from modules/Campaigns/tpls/WizardCampaignHeader.tpl */ ?>

	<!-- Begin Campaign Diagnostic Link -->	
	<!-- <?php echo $this->_tpl_vars['CAMPAIGN_DIAGNOSTIC_LINK']; ?>
 -->
	<!-- End Campaign Diagnostic Link -->
	<div class="template-panel">
		<div class="template-panel-container panel">
			<div class="template-container-full">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<th  colspan="4"><h4 class="header-4"><?php echo $this->_tpl_vars['MOD']['LBL_WIZ_NEWSLETTER_TITLE_STEP1']; ?>
 </h4></th>
					</tr>
		<tr>
			<td  colspan="3"><label class="wizard-step-info"><?php echo $this->_tpl_vars['MOD']['LBL_STEP_INFO_CAMPAIGN_HEADER']; ?>
 </label></td>
			<td colspan="1" class="emptyField">&nbsp;</td>
		</tr>
		<tr>
			<td width="17%" scope="col"><span sugar='slot1'><?php echo $this->_tpl_vars['MOD']['LBL_NAME']; ?>
 <span class="required"><?php echo $this->_tpl_vars['APP']['LBL_REQUIRED_SYMBOL']; ?>
</span></span sugar='slot'></td>
			<td width="33%" ><span sugar='slot1b'><input id='name' name='wiz_step1_name' aria-required="true"  title='<?php echo $this->_tpl_vars['MOD']['LBL_NAME']; ?>
' <?php echo $this->_tpl_vars['DISABLED']; ?>
  size='50' maxlength='50' type="text" value="<?php echo $this->_tpl_vars['CAMP_NAME']; ?>
" ></span sugar='slot'></td>
			<td width="15%" scope="col"><span sugar='slot2'><?php echo $this->_tpl_vars['APP']['LBL_ASSIGNED_TO']; ?>
</span sugar='slot'></td>
			<td width="35%" ><span sugar='slot2b'><input class="sqsEnabled" autocomplete="off" id="assigned_user_name" name="wiz_step1_assigned_user_name"  title='<?php echo $this->_tpl_vars['APP']['LBL_ASSIGNED_TO']; ?>
' type="text" value="<?php echo $this->_tpl_vars['ASSIGNED_USER_NAME']; ?>
"><input id='assigned_user_id' name='wiz_step1_assigned_user_id' type="hidden" value="<?php echo $this->_tpl_vars['ASSIGNED_USER_ID']; ?>
" />
		<input title="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_TITLE']; ?>
" type="button" class="button" value='<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
' name=btn1
			   onclick='open_popup("Users", 600, 400, "", true, false, <?php echo $this->_tpl_vars['encoded_users_popup_request_data']; ?>
);' /></span sugar='slot'>
			</td>
		</tr>
		<tr>
			<td width="15%" scope="col"><span sugar='slot3'><?php echo $this->_tpl_vars['MOD']['LBL_CAMPAIGN_STATUS']; ?>
 <span class="required"><?php echo $this->_tpl_vars['APP']['LBL_REQUIRED_SYMBOL']; ?>
</span></span sugar='slot'></td>
			<td width="35%" ><span sugar='slot3b'><select id='status' name='wiz_step1_status'  aria-required="true" title='<?php echo $this->_tpl_vars['MOD']['LBL_CAMPAIGN_STATUS']; ?>
'><?php echo $this->_tpl_vars['STATUS_OPTIONS']; ?>
</select></span sugar='slot'></td>
		</tr>

					<?php if ($this->_tpl_vars['campaign_type'] == 'survey'): ?>
						<tr>
							<td width="15%" scope="col"><span sugar='slot3'><?php echo $this->_tpl_vars['MOD']['LBL_CAMPAIGN_SURVEY']; ?>
 <span class="required"><?php echo $this->_tpl_vars['APP']['LBL_REQUIRED_SYMBOL']; ?>
</span></span sugar='slot'></td>
							<td width="35%" >
								<span sugar='slot2b'>
									<input class="sqsEnabled" autocomplete="off" id="survey_name" name="wiz_step1_survey_name"  title='<?php echo $this->_tpl_vars['MOD']['LBL_CAMPAIGN_SURVEY']; ?>
' type="text" value="<?php echo $this->_tpl_vars['SURVEY_NAME']; ?>
">
									<input id='survey_id' name='wiz_step1_survey_id' type="hidden" value="<?php echo $this->_tpl_vars['SURVEY_ID']; ?>
"  title='<?php echo $this->_tpl_vars['MOD']['LBL_CAMPAIGN_SURVEY']; ?>
'/>
									<input title="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_TITLE']; ?>
" type="button" class="button" value='<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
' name=btn1 onclick='open_popup("Surveys", 600, 400, "", true, false, <?php echo $this->_tpl_vars['encoded_surveys_popup_request_data']; ?>
);' />
								</span sugar='slot'>
							</td>
					</tr>
					<?php endif; ?>

					<tr<?php if ($this->_tpl_vars['HIDE_CAMPAIGN_TYPE']): ?> style="display: none;"<?php endif; ?>>
						<td scope="col"><span sugar='slot6'><?php echo $this->_tpl_vars['MOD']['LBL_CAMPAIGN_TYPE']; ?>
 </td>
						<td><span sugar='slot6b'><<?php echo $this->_tpl_vars['SHOULD_TYPE_BE_DISABLED']; ?>
 id='campaign_type' title='<?php echo $this->_tpl_vars['MOD']['LBL_CAMPAIGN_TYPE']; ?>
' name='wiz_step1_campaign_type' ><?php echo $this->_tpl_vars['CAMPAIGN_TYPE_OPTIONS']; ?>
</select></span sugar='slot'></td>
					</tr>
					<tr class="emptyRow">
						<td width="15%"><span sugar='slot9'>&nbsp;</span></span sugar='slot'></td>
						<td width="35%" ><span sugeeear='slot9b'>&nbsp;</span sugar='slot'></td>
						<td ><span sugar='slot10'>&nbsp;</span sugar='slot'></td>
						<td><span sugar='slot10b'>&nbsp;</span sugar='slot'></td>
					</tr>
					<tr>
						<td valign="top" scope="row"><span sugar='slot10'><?php echo $this->_tpl_vars['MOD']['LBL_CAMPAIGN_CONTENT']; ?>
</span sugar='slot'></td>
						<td colspan="3"><span sugar='slot10a'><textarea id='wiz_content' name='wiz_step1_content' title='<?php echo $this->_tpl_vars['MOD']['LBL_CAMPAIGN_CONTENT']; ?>
'  cols="110" rows="5"><?php echo $this->_tpl_vars['CONTENT']; ?>
</textarea></span sugar='slot'></td>
					</tr>
					<tr>
						<td scope="row">&nbsp;</td>
						<td>&nbsp;</td>
						<td scope="row">&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					</table>
			</div>
		</div>


		<?php if ($this->_tpl_vars['campaign_type'] != 'general'): ?>
		<div class="template-panel-container panel">
				<div class="template-container-full">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<th colspan="4" align="left" ><h4 class="header-4"><?php echo $this->_tpl_vars['MOD']['LBL_WIZ_NEWSLETTER_TITLE_STEP2']; ?>
</h4></th>
							</tr>
							<tr class="emptyRow"><td class="wizard-step-info" colspan="3"><label><?php echo $this->_tpl_vars['MOD']['LBL_WIZARD_BUDGET_MESSAGE']; ?>
</label></td><td>&nbsp;</td></tr>
							<tr class="emptyRow"><td class="datalabel" colspan="4">&nbsp;</td></tr>
							<tr>
								<td scope="col"><span sugar='slot14'><?php echo $this->_tpl_vars['MOD']['LBL_CAMPAIGN_BUDGET']; ?>
</span sugar='slot'></td>
								<td ><span sugar='slot14b'><input type="text" size="10" maxlength="15" id="budget" name="wiz_step2_budget" title="<?php echo $this->_tpl_vars['MOD']['LBL_CAMPAIGN_BUDGET']; ?>
" value="<?php echo $this->_tpl_vars['CAMP_BUDGET']; ?>
"></span sugar='slot'></td>
								<td scope="col"><span sugar='slot15'><?php echo $this->_tpl_vars['MOD']['LBL_CAMPAIGN_ACTUAL_COST']; ?>
</span sugar='slot'></td>
								<td ><span sugar='slot15b'><input type="text" size="10" maxlength="15" id="actual_cost" name="wiz_step2_actual_cost" title="<?php echo $this->_tpl_vars['MOD']['LBL_CAMPAIGN_ACTUAL_COST']; ?>
" value="<?php echo $this->_tpl_vars['CAMP_ACTUAL_COST']; ?>
"></span sugar='slot'></td>
							</tr>
							<tr>
								<td scope="col"><span sugar='slot16'><?php echo $this->_tpl_vars['MOD']['LBL_CAMPAIGN_EXPECTED_REVENUE']; ?>
</span sugar='slot'></td>
								<td ><span sugar='slot16b'><input type="text" size="10" maxlength="15" id="expected_revenue" name="wiz_step2_expected_revenue" title="<?php echo $this->_tpl_vars['MOD']['LBL_CAMPAIGN_EXPECTED_REVENUE']; ?>
" value="<?php echo $this->_tpl_vars['CAMP_EXPECTED_REVENUE']; ?>
"></span sugar='slot'></td>
								<td scope="col"><span sugar='slot17'><?php echo $this->_tpl_vars['MOD']['LBL_CAMPAIGN_EXPECTED_COST']; ?>
</span sugar='slot'></td>
								<td ><span sugar='slot17b'><input type="text" size="10" maxlength="15" id="expected_cost" name="wiz_step2_expected_cost" title="<?php echo $this->_tpl_vars['MOD']['LBL_CAMPAIGN_EXPECTED_COST']; ?>
" value="<?php echo $this->_tpl_vars['CAMP_EXPECTED_COST']; ?>
"></span sugar='slot'></td>
							</tr>
							<tr>
								<td scope="col"><span sugar='slot18'><?php echo $this->_tpl_vars['MOD']['LBL_CURRENCY']; ?>
</span sugar='slot'></td>
								<td><span sugar='slot18b'><select title='<?php echo $this->_tpl_vars['MOD']['LBL_CURRENCY']; ?>
' name='wiz_step2_currency_id' id='currency_id'   onchange='ConvertItems(this.options[selectedIndex].value);'><?php echo $this->_tpl_vars['CURRENCY']; ?>
</select></span sugar='slot'></td>
								<td scope="col"><span sugar='slot17'><?php echo $this->_tpl_vars['MOD']['LBL_CAMPAIGN_IMPRESSIONS']; ?>
</span sugar='slot'></td>
								<td ><span sugar='slot17b'><input type="text" size="10" maxlength="15" id="impressions" name="wiz_step2_impressions" title="<?php echo $this->_tpl_vars['MOD']['LBL_CAMPAIGN_IMPRESSIONS']; ?>
" value="<?php echo $this->_tpl_vars['CAMP_IMPRESSIONS']; ?>
"></span sugar='slot'></td></tr>
							<tr class="emptyRow">
								<td scope="col"><span sugar='slot18'>&nbsp;</span sugar='slot'></td>
								<td><span sugar='slot18b'>&nbsp;</td>
								<td scope="col"><span sugar='slot19'>&nbsp;</span sugar='slot'></td>
								<td><span sugar='slot19b'>&nbsp;</span sugar='slot'></td>
							</tr>
							<tr>
								<td valign="top" scope="row"><span sugar='slot20'><?php echo $this->_tpl_vars['MOD']['LBL_CAMPAIGN_OBJECTIVE']; ?>
</span sugar='slot'></td>
								<td colspan="4"><span sugar='slot20b'><textarea id="objective" name="wiz_step2_objective" title='<?php echo $this->_tpl_vars['MOD']['LBL_CAMPAIGN_OBJECTIVE']; ?>
' cols="110" rows="5"><?php echo $this->_tpl_vars['OBJECTIVE']; ?>
</textarea></span sugar='slot'></td>
							</tr>
							<tr>
								<td >&nbsp;</td>
								<td>&nbsp;</td>
								<td >&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
						</table>
					</div>
		</div>
		<?php endif; ?>

	</div>


	<?php echo '
	<script type="text/javascript">
		Calendar.setup ({'; ?>

			inputField : "start_date", ifFormat : "<?php echo $this->_tpl_vars['CALENDAR_DATEFORMAT']; ?>
", showsTime : false, button : "start_date_trigger", singleClick : true, step : 1, weekNumbers:false
			<?php echo '
		});
		
		Calendar.setup ({'; ?>

			inputField : "end_date", ifFormat : "<?php echo $this->_tpl_vars['CALENDAR_DATEFORMAT']; ?>
", showsTime : false, button : "end_date_trigger", singleClick : true, step : 2, weekNumbers:false
		<?php echo '
		});
	

    /*
     * this is the custom validation script that will validate the fields on step1 of wizard
     */
    
    function validate_step1(){
        //loop through and check for empty strings (\'  \')
        requiredTxt = SUGAR.language.get(\'app_strings\', \'ERR_MISSING_REQUIRED_FIELDS\');
        var stepname = \'wiz_step_1_\';
        var has_error = 0;
        var fields = new Array();
        fields[0] = \'name\'; 
        fields[1] = \'status\';
        fields[2] = \'end_date\';
        '; ?>

        <?php if ($this->_tpl_vars['campaign_type'] == 'survey'): ?>
        fields[3] = 'survey_id';
        <?php endif; ?>
        <?php echo '
        var field_value = \'\'; 
        for (i=0; i < fields.length; i++){
            if(document.getElementById(fields[i]) !=null){
                field_value = trim(document.getElementById(fields[i]).value);
                if(field_value.length<1){
                //throw error if string is empty            
                add_error_style(\'wizform\', fields[i], requiredTxt +\' \' +document.getElementById(fields[i]).title );
                has_error = 1;
                }
            }
        }
        if(has_error == 1){
            //error has been thrown, return false
            return false;
        }
        //add fields to validation and call generic validation script 
        if(validate[\'wizform\']!=\'undefined\'){delete validate[\'wizform\']};
        addToValidate(\'wizform\', \'name\', \'alphanumeric\', true,  document.getElementById(\'name\').title);
        addToValidate(\'wizform\', \'status\', \'alphanumeric\', true,  document.getElementById(\'status\').title);

        return check_form(\'wizform\');
    }    





	</script>
	'; ?>

	<link rel="stylesheet" type="text/css" href="modules/EmailTemplates/EmailTemplate.css">
