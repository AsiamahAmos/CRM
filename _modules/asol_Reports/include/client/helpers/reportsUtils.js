"use strict;"
var reportsUtils = (function($) {
		
	var populateEditView = function(json, duplicate, isMeta) {
		
		window.endPopulate = false;
		
		if (json === null) {
			json = decodeURIComponent($("#asolReportsStoredContent").val());
		}
		
		var editContainer = $("#editContainer");
		
		var data = window.JSON.parse(json);
		if (!data.hasOwnProperty('notExists')) {
		
			data.name = (duplicate ? "Copy of "+data.name : data.name);
		
			if (data.report_charts === 'Tabl') {
				editContainer.find('#charts_Tab').closest('li').addClass('disabled');
			} else {
				editContainer.find('#charts_Tab').closest('li').removeClass('disabled');
			}
		
			window["currentRecord"] = (duplicate ? "" : data.id);
			window["parentRecord"] = data.parent_id;
			
			var currentTitle = SUGAR.language.get('asol_Reports', 'LBL_REPORT_EDIT')+": "+data.name;
			editContainer.find(".moduleTitle h2").text(currentTitle);
			editContainer.find(".name").val(data.name);
			editContainer.find("[name=\"assigned_user_id\"]").val(data.assigned_user_id);
			editContainer.find("#assigned_user_name").val(data.assigned_user_name);
			
			editContainer.find(".reportScope").val(data.report_scope.type);
			editContainer.find(".scopeRole option").each(function() {
				if ($.inArray($(this).val(), data.report_scope.roles) >= 0) {
					$(this).prop("selected", true); 
				} 
			});
			asolFancyMultiEnum.update(".scopeRole");
			
			editContainer.find("#report_type").val(data.report_type['type']);
			editContainer.find('#report_type').attr("draft", typeof data.report_type['draft'] !== 'undefined' ? data.report_type['draft'] : '');
			editContainer.find('#report_type').attr("data", typeof data.report_type['data'] !== 'undefined' ? data.report_type['data'] : '');
			if ($.inArray(data.report_type['type'], ['scheduled', 'stored']) >= 0) {
				editContainer.find('#scheduledDiv_Tab').closest('li').removeClass('disabled');
			} else {
				editContainer.find('#scheduledDiv_Tab').closest('li').addClass('disabled');
			}
			
			editContainer.find("#report_scheduled_type").hide();
			if (data.scheduled_images == 1) {
				editContainer.find("#scheduled_images").attr("checked","checked");
			} else {
				editContainer.find("#scheduled_images").removeAttr("checked");
			}
			editContainer.find("#internal_description").val(data.description.internal);
			editContainer.find("#public_description").val(data.description.public);
			
			editContainer.find("#report_charts").val(data.report_charts);
			
			var generatedFileFormat = data.report_attachment_format.split(':');
			editContainer.find("#report_attachment_format").val(generatedFileFormat[0]);
			
			//***AlineaSol Premium***//
	    	if (typeof window.hasPremiumReportsJsFeatures == 'function') {
	    		editContainer.find("#asolReportsFileFormatConfig").val(typeof generatedFileFormat[1] !== 'undefined' ? generatedFileFormat[1] : '');
	    		reDrawFileFormatImg();
	    	}
	    	//***AlineaSol Premium***//
			
			editContainer.find("#report_scope").val(data.report_scope);
		    editContainer.find("#report_charts").val(data.report_charts);
		    asolFancyMultiEnum.update(".scopeRole");
		    
		    var css = (data.content.fields !== null ? data.content.fields.tables[0].css : '');
			var templates = (data.content.fields !== null ? data.content.fields.tables[0].templates : '');
		    
		    //***AlineaSol Premium***//
	    	if (typeof window.hasPremiumReportsJsFeatures == 'function') {
				$(".configureCssButton").attr("value", escape(css));
				$("#commonTemplates").val(escape(window.JSON.stringify(templates)));
				commonCssManagement.reprintImage();
	    	}
	    	
	    	$(".configureCssButton").attr("value", data.css);
	   		$("#commonTemplates").val(escape(window.JSON.stringify(data.commonTemplates)));
	    	
	    	if (data.css.length > 1) {
		    	$(".configureCssButton").each(function() {
	    			$(this).css('color', '#008efa');
	    		});
	    	}
	    	
	    	//***AlineaSol Premium***//
	    	if (typeof window.hasPremiumReportsJsFeatures == 'function') {
		    	if (data.report_type['draft'] == '1') {
		    		editContainer.find(".button.pushButton").show();
			    } else {
			    	editContainer.find(".button.pushButton").hide();
			    }
		    }
		    //***AlineaSol Premium***//
	    	
	    	//***AlineaSol Premium***//
		    if ((typeof window.hasPremiumReportsJsFeatures == 'function') && (data.is_meta == '1')) {
		    	editContainer.find("#data_source_value").closest("tr").hide();
		    	editContainer.find("#metaHtml_Tab").closest("li").removeClass("disabled");
		    	editContainer.find("#fieldsFilters_Tab").closest("li").addClass("disabled");
		    	editContainer.find("#charts_Tab").closest("li").addClass("disabled");
		    	editContainer.find(".button.showSqlButton").hide();
		    	editContainer.find("[name=is_meta]").val('1');
		    	CKEDITOR['instances']['meta_html'].setData(data.meta_html);
		    //***AlineaSol Premium***//
		    } else {
		    	editContainer.find("#data_source_value").closest("tr").show();
		    	editContainer.find("#metaHtml_Tab").closest("li").addClass("disabled");
		    	editContainer.find("#fieldsFilters_Tab").closest("li").removeClass("disabled");
		    	//***AlineaSol Premium***//
		    	if (typeof window.hasPremiumReportsJsFeatures == 'function') {
		    		CKEDITOR['instances']['meta_html'].setData();
		    	}
		    	//***AlineaSol Premium***//
		    	if (data['data_source'].type == '0') {
		    		editContainer.find(".button.showSqlButton").show();
		    		editContainer.find("i.icn-magnet").show();
		    	} else {
		    		editContainer.find(".button.showSqlButton").hide();
		    		editContainer.find("i.icn-magnet").hide();
		    	}
		    }
		
		    $.each(data.email_list, function(i, val) {
		    	if (i == "from") {
		    		editContainer.find("#email_from").val(val);
		    	} else {
			    	editContainer.find("#email_users_for_"+i).val(val.users);
			        editContainer.find("#email_roles_for_"+i).val(val.roles);
			        editContainer.find("#email_list_for_"+i).val(val.list);
		    	}
		    }); 
		    
		    initEmailFrame();
		
			data.content.domains.forEach(function(domain) {
				editContainer.find(".asolCommonUsedDomains").append($('<option>', { 
			        value: domain.key,
			        text: domain.label
			    }));
			});
			
		    editContainer.find("#asol_domain_id").val(data.domains.id);
		    editContainer.find("#asol_domain_name").val(data.domains.name);
		    editContainer.find("#asol_domain_published_mode").val(data.domains.mode);
		    $("#selectedMode").val(data.domains.mode);
		    editContainer.find("#asol_domain_child_share_depth").val(data.domains.level);
		    $("#selectedLevels").val(data.domains.level);
		    editContainer.find("#asol_multi_create_domain").val(data.domains.publish);
		    $("#selectedPublish").val(data.domains.publish);
		    editContainer.find("#asol_published_domain").prop("checked", (data.domains.enable == '1'));
		
		    controllerReportEdit.manageEditionTabs('reportTabs', 'mainInfo', 'reportPanel');
		    manageReportScope(editContainer.find("#formScope"));
		    
		    var scheduledType = data.report_scheduled_type.split(":");
		    editContainer.find('#report_scheduled_type_info').val(scheduledType[1]);
		    //***AlineaSol Premium***//
		    if (typeof window.hasPremiumReportsJsFeatures == 'function') {
		    	initScheduledTypeInfo(data.report_type['type'], scheduledType[0]);
		    	reDrawScheduledTypeInfoImg();
		    }
		    //***AlineaSol Premium***//
			
		    
		    var currentSourceType = (data.is_meta != '1' ? data['data_source'].type : null);
		    var currentSourceValue = (data.is_meta != '1' ? (data['data_source'].type == 0 ? data['data_source'].value.database : data['data_source'].value.api) : null);
		    var currentSourceModule = (data.is_meta != '1' ? data['data_source'].value.module : null);
		    
		    editContainer.find("#data_source_type").val(currentSourceType);
		    controllerReportEdit.manageDataSourceType();
		    editContainer.find("#data_source_value").val(currentSourceValue);
		    controllerReportEdit.manageDataSourceValue().done(function() {
				
				editContainer.find("#report_module").val(currentSourceModule);
				RememberTasks("tasks_Table", data.content.tasks);
				editContainer.find("#tasks_Table").sortable({ items: ".asolReportsTaskRow", axis: "y" });
					
				if (data.is_meta != "1") {
				
					//***AlineaSol Premium***//
				    if ((typeof window.hasPremiumReportsJsFeatures == 'function') && (data.dynamic_sql)) {
						data.dynamic_sql = data.dynamic_sql.replace(/&quot;/g, '"');
						editContainer.find("#create_form").find("[name=dynamic_sql]").val(data.dynamic_sql);
						editContainer.find("#reportDynamicTableAddImg").attr('src', 'modules/asol_Reports/include/images/asol_reports_dynamic_table_filled.png');
						editContainer.find("#report_module").attr('disabled', '').prepend('<option>'+SUGAR.language.get('asol_Reports', 'LBL_REPORT_DYNAMIC_TABLES')+'</option>');
						getDynamicTables(currentSourceValue, data.dynamic_sql).done(function(matchedTables){
							matchedTables = window.JSON.parse(matchedTables);
							if (matchedTables instanceof Array) {
								editContainer.find("#report_module").val(matchedTables[matchedTables.length-1]);
								var ajax_response = controllerReportEdit.manageDataSourceModule((typeof window.hasPremiumReportsJsFeatures == 'function' ? '&treeMode=true' : ''), (typeof window.hasPremiumReportsJsFeatures == 'function' ? 'reportTreeFieldsDiv' : 'reportTableFieldsDiv'), false, false, false);
							}
						});	
					//***AlineaSol Premium***//
					} else if (data.data_source.value.audit == 1) {
						editContainer.find('#audited_report').attr("checked","checked");
						var ajax_response = manageReportAudit(editContainer.find('#audited_report')[0], '&treeMode=true', 'reportTreeFieldsDiv', false);				
					} else {
						var ajax_response = controllerReportEdit.manageDataSourceModule((typeof window.hasPremiumReportsJsFeatures == 'function' ? '&treeMode=true' : ''), (typeof window.hasPremiumReportsJsFeatures == 'function' ? 'reportTreeFieldsDiv' : 'reportTableFieldsDiv'), false, false, true);
					}
				    
				    ajax_response.done(function() {
				    	
				    	var currentFields = (data.content.fields !== null ? window.JSON.stringify(data.content.fields) : '');
						RememberFields("fields_Table", currentFields, (data['data_source'].value.audit == 1 ? "1" : "0"));
						editContainer.find("#fields_Table").sortable({ items: ".asolReportsFieldRow", axis: "y" });
						
						var currentFilters = (data.content.filters !== null ? window.JSON.stringify(data.content.filters) : '');
						RememberFilters("filters_Table", currentFilters, (data['data_source'].value.audit == 1 ? "1" : "0"));	
						editContainer.find("#filters_Table .asolReportsFilterWhere").sortable({ items: ".asolReportsFilterRow", axis: "y" });
						editContainer.find("#filters_Table .asolReportsFilterHaving").sortable({ items: ".asolReportsFilterRow", axis: "y" });
						
						editContainer.find("#report_charts_engine").val(data.content.charts_engine);
						RememberCharts("charts_Table", data.content.charts_detail, data.content.charts_engine);
						editContainer.find("#charts_Table").sortable({ items: ".asolReportsChartsGroup", axis: "y" });
						
						if(data.content.charts_detail.layout)
							$('.chartLayout').attr('config', data.content.charts_detail.layout).css('color', '#2196f3');
						else $('.chartLayout').attr('config', '').css('color', '');

						//***AlineaSol Premium***//
						if (typeof window.hasPremiumReportsJsFeatures == 'function') {
							applyChartsRestrictions();
						}	
						//***AlineaSol Premium***//
						window.endPopulate = true;
				    	
				    });
				    
				}
				
				if (data.content.fields !== null && data.content.fields.tables[0].hasOwnProperty('title')) { 
					editContainer.find("#asolReportTitle").val(data.content.fields.tables[0].title.text);
					editContainer.find("#asolReportTitle_lang").attr('lang', window.JSON.stringify(data.content.fields.tables[0].title.language));
				}
	
				var resultsLimit = data.content.results_limit.split('${dp}');
				editContainer.find("#results_limit_op").val(resultsLimit[0]);
				if (resultsLimit[0] === 'limit') {
					editContainer.find("#results_limit_param").css('visibility', 'visible').val(resultsLimit[1]);
					editContainer.find("#results_limit_amount").css('visibility', 'visible').val(resultsLimit[2]);
				} else {
					editContainer.find("#results_limit_param").css('visibility', 'hidden').val('');
					editContainer.find("#results_limit_amount").css('visibility', 'hidden').val('');
				}
				
				initVisibilityToggle('fields_Table', 'index_visible', 'index_hidden', 'asolReportsFieldsIndexRow', true, 'index_display', false, false, null, null, null);	
				initVisibilityToggle('fields_Table', 'field_visible', 'field_hidden', 'asolReportsFieldRow', true, 'field_display', true, false, 'html', 'field_html', true);
				initVisibilityToggle('filters_Table', 'filter_execute', 'filter_noexecute', 'asolReportsFilterRow', true, 'filter_apply', false, false, null, null, null);		
				initVisibilityToggle('charts_Table', 'chart_visible', 'chart_hidden', 'asolReportsChartsGroup', true, 'chart_display', true, false, null, null, null);
				initVisibilityToggle('charts_Table', 'subchart_visible', 'subchart_hidden', 'asolReportsSubChart', true, 'chart_display', true, false, null, null, null);
						
				['fields_Table', 'filters_Table', 'charts_Table', 'tasks_Table'].forEach(function(element) {
					initMassiveAction(element, 'massiveCheck', 'massiveCheck_all', 'massiveBtn_all')
				});
				
				if (typeof window.hasPremiumReportsJsFeatures == "function") {
					initVisibilityToggle('charts_Table', 'half_chart', 'full_chart', 'asolReportsChartsGroup', false, 'half_chart_display', true, false, null, null, null);
					initAxisSideSwitcher('charts_Table', 'y_axis_left_side', 'y_axis_right_side', 'y_axis_side');
				}
				
				if ($(".reportScope").val() !== "public") {
					asolFancyMultiEnum.generate($(".scopeRole"));
				}
				
				//***AlineaSol Premium***//
				if (typeof window.hasPremiumReportsJsFeatures == 'function') {
					floatTreeFieldsContainer();
				}
				//***AlineaSol Premium***//
				
				window.endPopulate = true;
				$.unblockUI();
				
			});
			
		} else {
			
			editContainer.find("#moduleTitle h2").text(SUGAR.language.get('asol_Reports', 'LBL_REPORT_CREATE'));
			window["currentRecord"] = data.notExists;
			
			editContainer.find("#data_source_type").val('0');
			controllerReportEdit.manageDataSourceType();
			editContainer.find("#data_source_value").val('-1');
			controllerReportEdit.manageDataSourceValue().done(function() {
				editContainer.find("#data_source_module").val('');
				var ajax_response = controllerReportEdit.manageDataSourceModule((typeof window.hasPremiumReportsJsFeatures == 'function' ? '&treeMode=true' : ''), (typeof window.hasPremiumReportsJsFeatures == 'function' ? 'reportTreeFieldsDiv' : 'reportTableFieldsDiv'), true, false, true);
				window.endPopulate = true;
				
				editContainer.find("#tasks_Table").sortable({ items: ".asolReportsTaskRow", axis: "y" });
				
				//***AlineaSol Premium***//
			    if (typeof window.hasPremiumReportsJsFeatures == 'function') {
			    	editContainer.find(".button.pushButton").hide();
			    }
			    //***AlineaSol Premium***//
				
				if (!isMeta) {
					editContainer.find("#fields_Table").sortable({ items: ".asolReportsFieldRow", axis: "y" });
					editContainer.find("#filters_Table .asolReportsFilterWhere").sortable({ items: ".asolReportsFilterRow", axis: "y" });
					editContainer.find("#filters_Table .asolReportsFilterHaving").sortable({ items: ".asolReportsFilterRow", axis: "y" });
					editContainer.find("#charts_Table").sortable({ items: ".asolReportsChartsGroup", axis: "y" });
				} else {
					editContainer.find("#data_source_value").closest("tr").hide();
			    	editContainer.find("#metaHtml_Tab").closest("li").removeClass("disabled");
			    	editContainer.find("#fieldsFilters_Tab").closest("li").addClass("disabled");
			    	editContainer.find("#charts_Tab").closest("li").addClass("disabled");
			    	editContainer.find(".button.showSqlButton").hide();
			    	editContainer.find("[name=is_meta]").val('1');
			    	CKEDITOR['instances']['meta_html'].setData(data.meta_html);
				}
				
				//***AlineaSol Premium***//
			    if (typeof window.hasPremiumReportsJsFeatures == 'function') {
			    	initScheduledTypeInfo('manual', '');
			    }
				
				initVisibilityToggle('fields_Table', 'index_visible', 'index_hidden', 'asolReportsFieldsIndexRow', true, 'index_display', false, false, null, null, null);	
				initVisibilityToggle('fields_Table', 'field_visible', 'field_hidden', 'asolReportsFieldRow', true, 'field_display', true, false, 'html', 'field_html', true);
				initVisibilityToggle('filters_Table', 'filter_execute', 'filter_noexecute', 'asolReportsFilterRow', true, 'filter_apply', false, false, null, null, null);		
				initVisibilityToggle('charts_Table', 'chart_visible', 'chart_hidden', 'asolReportsChartsGroup', true, 'chart_display', true, false, null, null, null);
				initVisibilityToggle('charts_Table', 'subchart_visible', 'subchart_hidden', 'asolReportsSubChart', true, 'chart_display', true, false, null, null, null);
				
				['fields_Table', 'filters_Table', 'charts_Table', 'tasks_Table'].forEach(function(element) {
					initMassiveAction(element, 'massiveCheck', 'massiveCheck_all', 'massiveBtn_all')
				});
				
				if (typeof window.hasPremiumReportsJsFeatures == "function") {
					initVisibilityToggle('charts_Table', 'half_chart', 'full_chart', 'asolReportsChartsGroup', false, 'half_chart_display', true, false, null, null, null);
					initAxisSideSwitcher('charts_Table', 'y_axis_left_side', 'y_axis_right_side', 'y_axis_side');
				}
				
				$.unblockUI();
			});
			
		}

		controllerReportEdit.resizeEvents();
		
	}
	
	var removeEditReportContent = function(isMeta) {
	
		var editContainer = $("#editContainer");
	    
		window["currentRecord"] = '';
		window["parentRecord"] = '';
		
		editContainer.find('#report_title').text(SUGAR.language.get('asol_Reports', 'LBL_REPORT_CREATE'));	
		editContainer.find('ul#reportTabs li').removeClass('selected');
		editContainer.find('#charts_Tab').closest('li').addClass('disabled');
		editContainer.find("#fieldsFilters_Tab").closest("li").removeClass("disabled");
		editContainer.find("#metaHtml_Tab").closest("li").addClass("disabled");
		editContainer.find("#mainInfo_Tab").closest("li").addClass("selected");
		
		editContainer.find(".moduleTitle h2").text(SUGAR.language.get('asol_Reports', 'LBL_REPORT_CREATE'));
		editContainer.find("#name").val('');
		editContainer.find("#assigned_user_id").val(window.currentUser.id);
		editContainer.find("#assigned_user_name").val(window.currentUser.name);
		editContainer.find("[name='is_meta']").val('');
		editContainer.find("#report_type").val('');
		editContainer.find("#scheduled_images").removeAttr("checked");
		editContainer.find("#internal_description").val('');
		editContainer.find("#public_description").val('');
		editContainer.find("#reportScope").val('');
		editContainer.find("#report_charts").val('');
		editContainer.find("#report_attachment_format").val('');
		editContainer.find("#report_scope").val('');
		editContainer.find("#report_charts").val('');
		editContainer.find("#report_module").val('');
	  	editContainer.find("[name='dynamic_sql']").val('');
	  	editContainer.find("[id^='email_']").val('');
	  	
	  	editContainer.find('#tableConfiguration').val('');
	  	editContainer.find('#filtersConfiguration').val('');
	  	editContainer.find('#layoutConfig').val('')
	  	
	  	editContainer.find('.reportPanel').hide();
	  	editContainer.find('.reportPanel#mainInfo').show();
	  	editContainer.find('i.targetsConfig').css('color', '').attr('config', '{}');

	  	
	  	//***AlineaSol Premium***//
	    if (typeof window.hasPremiumReportsJsFeatures == 'function') {
		  	CKEDITOR['instances']['meta_html'].setData();
		  	CKEDITOR['instances']['meta_html'].resetUndo();
	  	}
	    //***AlineaSol Premium***//
	  	editContainer.find('.asolReportsFieldRow').remove();
	  	editContainer.find('.asolReportsFilterRow').remove();
	  	editContainer.find('.asolReportsChartsGroup').remove();
	  	editContainer.find('.asolReportsTaskRow').remove();
	  	
	  	cleanUpReport('', true);
	  	editContainer.find("#data_source_type").val('0');
	  	controllerReportEdit.manageDataSourceType();
	  	editContainer.find("#data_source_value").val('-1');
	  	controllerReportEdit.manageDataSourceValue();
	  	editContainer.find("#data_source_module").val();
	  	controllerReportEdit.manageDataSourceModule((typeof window.hasPremiumReportsJsFeatures == 'function' ? '&treeMode=true' : ''), (typeof window.hasPremiumReportsJsFeatures == 'function' ? 'reportTreeFieldsDiv' : 'reportTableFieldsDiv'), true, false, true);
	  	
	  	//***AlineaSol Premium***//
	    if (typeof window.hasPremiumReportsJsFeatures == 'function') {
	    	editContainer.find(".button.pushButton").hide();
	    }
	    //***AlineaSol Premium***//
	    
	  	//***AlineaSol Premium***//
	    if ((typeof window.hasPremiumReportsJsFeatures == 'function') && isMeta) {
	  		editContainer.find("#data_source_value").closest("tr").hide();
	    	editContainer.find("#metaHtml_Tab").closest("li").removeClass("disabled");
	    	editContainer.find("#fieldsFilters_Tab").closest("li").addClass("disabled");
	    	editContainer.find("#charts_Tab").closest("li").addClass("disabled");
	    	editContainer.find(".button.showSqlButton").hide();
	    	editContainer.find("[name=is_meta]").val('1');
	    	CKEDITOR['instances']['meta_html'].setData('');
	    	editContainer.find('#report_type').find('option[value="scheduled"], option[value="stored"], option[value="webservice_source"]').hide();
	    //***AlineaSol Premium***//
	    } else {
	    	editContainer.find("#data_source_value").closest("tr").show();
	    	if (editContainer.find("#data_source_type").val() == '0') {
	    		editContainer.find(".button.showSqlButton").show();
	    		editContainer.find("i.icn-magnet").show();
	    	} else {
	    		editContainer.find(".button.showSqlButton").hide();
	    		editContainer.find("i.icn-magnet").hide();
	    	}
	    	editContainer.find("[name=is_meta]").val('0');
	    	editContainer.find('#report_type').find('option[value="scheduled"], option[value="stored"], option[value="webservice_source"]').show();
	    }
	  	
	}
		
	var forceDialogVisibility = function() {
	
		var currentOverlayZ = $(".ui-widget-overlay").css("z-index");
		$(".ui-widget-content:visible").get(0).style.setProperty('z-index', parseInt(currentOverlayZ)+1, 'important');
	
	}
	
	return {
		populateEditView : populateEditView,
		removeEditReportContent : removeEditReportContent,
		
		forceDialogVisibility : forceDialogVisibility,
	}
	
})($);
