"use strict";

var controllerReportEdit = (function($, api, router) {

	var saveReport = function(record, finish) {
		
		var listContainer = $("#listContainer");
		var editContainer = $("#editContainer");
		
		record = (record != null ? record : window["currentRecord"]);
		
		if (checkSaveReport()) {
			if (window['inlineEdition']) {
				$("#editContainerInline").block({ message: api.getBlockingMessage("save") });
			} else {
				$.blockUI({ message: api.getBlockingMessage("save") });
			}
			api.saveReport(record, null).done(function(savedRecord) {
				if (finish) {
					api.listReports().done(function(data) {
						if (window['inlineEdition']) {
							window['savedElement'] = true;
							$("#editContainerInline").dialog("close");
						} else {
			    			listContainer.find('#reportRows').html(data);
			    			router.moveTo('list');
		    				reportsUtils.removeEditReportContent();
		    			}
						if (window['inlineEdition']) {
	    					$("#editContainerInline").unblock();
	    				} else {
	    					$.unblockUI();
	    				}
		    		});
				} else {
					window["currentRecord"] = savedRecord;
					var currentTitle = SUGAR.language.get('asol_Reports', 'LBL_REPORT_EDIT')+": "+editContainer.find("#name").val();
					editContainer.find(".moduleTitle h2").text(currentTitle);
					if (!window['inlineEdition']) {
						router.moveTo('edit', savedRecord);
					}
					if (window['inlineEdition']) {
    					$("#editContainerInline").unblock();
    				} else {
    					$.unblockUI();
    				}
				}
			});
		}
		
	}
	
	var manageEditionTabs = function(subContainer, divId, panelClass) {

		if (!$('a[id='+divId+'_Tab]').closest('li').is('.disabled, .semidisabled')) {
			$('div.'+panelClass).hide();
			$('div[id='+divId+']').show();
			$('ul[id='+subContainer+'] li.selected').removeClass('selected');
			$('a[id='+divId+'_Tab]').closest('li').addClass('selected');
		}
		
	}
	
	var manageDataSourceType = function() {
		
		var editContainer = $("#editContainer");
		editContainer.find("#data_source_value").find('option').remove();
		
		var dataSource = getCurrentDataSource();
		
		switch (dataSource.type) {
		    case "0":
		    	var availableDatabases = window.JSON.parse(decodeURIComponent(editContainer.find("#data_source_type").find("option:selected").attr("data")));
		    	editContainer.find("#data_source_value").append($('<option>', {
	    			value: '-1',
	    		    text: 'CRM'
	    		}));
		    	availableDatabases.forEach(function(currentDatabase, currentLoop) {
		    		editContainer.find("#data_source_value").append($('<option>', {
		    			value: currentLoop,
		    		    text: currentDatabase,
		    		    db: currentDatabase
		    		}));
		    	});
		    	for (var key in availableDatabases) {
		    		
		    	}
		        break;
		    case "1":
		    	var availableApis = window.JSON.parse(decodeURIComponent(editContainer.find("#data_source_type").find("option:selected").attr("data")));
		    	availableApis.forEach(function(currentApi, currentLoop) {
		    		editContainer.find("#data_source_value").append($('<option>', {
		    			value: currentLoop,
		    		    text: currentApi,
		    		    api: currentApi
		    		}));
		    	});
		        break;
		}
		
	}
	
	var manageDataSourceValue = function() {
		
		var hasLoadingMessage = ($(".loadingReportContainer:visible").length > 0);
		if (!hasLoadingMessage) {
			$.blockUI({ message: api.getBlockingMessage("load") });
		}
		
		var dataSource = getCurrentDataSource();
		
		if (cleanUpReport('reportTreeFieldsDiv')) {
			var result = $.ajax({ url: 'index.php?entryPoint=reportGenerateHtml&htmlTarget=reportModuleTables&data_source='+window.JSON.stringify(dataSource)+'&isSubQuery=false', 
				success: function(data) {
					if (dataSource.type == '0' && typeof window.hasPremiumReportsJsFeatures == 'function') {
						$('#reportDynamicTableDiv').closest('.ui-dialog').remove();
						window.manageReportPremiumDatabaseDone = manageReportPremiumDatabase(dataSource);
					}
					$('#reportModulesTablesSpan').html(data); 
				}
			});
			
			if (dataSource.value.database == '-1') {
				$("#tableConfigurationDialog table#fieldManagement").show();
			} else {
				$("#tableConfigurationDialog table#fieldManagement").hide();
			}
				
		} else {
			alternativeDatabaseOption = $('data_source_value option[selected]').val() == undefined ? $('#data_source_value').val(-1) : $('#data_source_value').val(alternativeDatabaseOption);
			var result = { "done" : function(f){ return f(); } };
		}
		if (!hasLoadingMessage) {
			$.unblockUI();
		}
		
		if (dataSource.type == '0' && typeof window.hasPremiumReportsJsFeatures == 'function') {
			return { 
				"done" : function(f) { 
					result.done(function() { window.manageReportPremiumDatabaseDone.done(f); delete window.manageReportPremiumDatabaseDone; }); 
				}
			};
		} else {
			return result;
		}
		
	}
	
	var manageDataSourceModule = function(treeMode, divId, cleanUp, swithMode, isEditView) {
		
		var hasLoadingMessage = ($(".loadingReportContainer:visible").length > 0);
		if (!hasLoadingMessage) {
			$.blockUI({ message: api.getBlockingMessage("load") });
		}
		
		cleanUp = ((typeof window['cleanUp'] !== 'undefined' && window['cleanUp'] !== null) ? window['cleanUp'] : cleanUp);
		
		var dataSource = getCurrentDataSource();
			
		var acceptConfirm = true; 
		
		if ((dataSource.type == '1') || (dataSource.value.database >= '0')) {
			
			var result = $.ajax({ 
				url: 'index.php?entryPoint=reportGenerateHtml&htmlTarget=reportTableFields'+treeMode+'&data_source='+window.JSON.stringify(dataSource)+'&isEditViewMode='+(isEditView ? 'true' : 'false')+'&subQueryMode='+(window["subQueryMode"] ? 'true' : 'false'), 
				success: function(data) {
					if (cleanUp) {
						if ($('#'+(window["subQueryMode"] ? 'autorefresh_sub_report' : 'autorefresh_report')).is(':checked')) { 
							acceptConfirm = cleanUpReport((window["subQueryMode"] ? 'subReportTreeFieldsDiv' : 'reportTreeFieldsDiv'), swithMode);
						} else { 
							$('#related_fields').empty(); 
						}
					}
					if (acceptConfirm) {
						$('#'+divId).html(data);
						$('#addFieldsButton').prop('disabled', true);
						
						if ($("#sub_report_module").val() !== $("#sub_report_module option[selected]").val()) {
							$("#sub_report_module option[selected]").removeAttr("selected");
							$("#sub_report_module option[value~='"+$("#sub_report_module").val()+"']").attr("selected", "");
						}
						if ($("#report_module").val() !== $("#report_module option[selected]").val()) {
							$("#report_module option[selected]").removeAttr("selected");
							$("#report_module option[value~='"+$("#report_module").val()+"']").attr("selected", "");
						}
					} else {
						$("#report_module").val($("#report_module option[selected]").val());
						$("#sub_report_module").val($("#sub_report_module option[selected]").val());
					}
					if (!hasLoadingMessage) {
						$.unblockUI();
					}
				},
				error: function(data){
					console.log(data);
				}
			});
			
		} else {
			
			var tableConfig = ($('#tableConfiguration').val() == '' ? false : $('#tableConfiguration').val());	
			var hasDeleted = $('#tableConfigurationDialog #deleted_usage').prop('checked') || (!cleanUp && window.JSON.parse(tableConfig) && window.JSON.parse(tableConfig).deletedUsage);
			
			var result = $.ajax({ 
				url: 'index.php?entryPoint=reportGenerateHtml&htmlTarget=reportTableFields'+treeMode+'&hasDeleted='+(hasDeleted ? 1 : 0)+'&data_source='+window.JSON.stringify(dataSource)+'&subQueryMode='+(window["subQueryMode"] ? 'true' : 'false'), 
				success: function(data) {
					if (cleanUp) {
						acceptConfirm = cleanUpReport(divId, swithMode);
					}
					if (acceptConfirm) {
						$('#'+divId).html(data); 
						$('#addFieldsButton').prop('disabled', true); 
						
						if ($("#sub_report_module").val() !== $("#sub_report_module option[selected]").val()) {
							$("#sub_report_module option[selected]").removeAttr("selected");
							$("#sub_report_module option[value~='"+$("#sub_report_module").val()+"']").attr("selected", "");
						}
						if ($("#report_module").val() !== $("#report_module option[selected]").val()) {
							$("#report_module option[selected]").removeAttr("selected");
							$("#report_module option[value~='"+$("#report_module").val()+"']").attr("selected", "");
						}
					} else {
						$("#report_module").val($("#report_module option[selected]").val());
						$("#sub_report_module").val($("#sub_report_module option[selected]").val());
					}
					if (!hasLoadingMessage) {
						$.unblockUI();
					}
				},
				error: function(data){
					console.log(data);
				}
			});
		
		}

		window['cleanUp'] = null;
		
		return result;
		
	}
	
	var getCurrentDataSource = function() {
		
		var editContainer = $("#editContainer");
		
		var sourceType = editContainer.find("#data_source_type").val();
		var sourceValue = editContainer.find("#data_source_value").val();
		var sourceModule = editContainer.find((window['subQueryMode'] ? '#sub_report_module' : '#report_module')).val();
		
		if (sourceType == '0') {
			
			var dataSource = {
				type: sourceType,
				value: {
					database: sourceValue,
					module: sourceModule
				}
			};
			
			if (sourceValue == '-1') {
				dataSource.value.audit = (editContainer.find((window['subQueryMode'] ? '#audited_sub_report' : '#audited_report')).is(':checked') ? '1' : '0');
			}
			
		} else if (sourceType == '1') {
			
			var dataSource = {
				type: sourceType,
				value: {
					api: sourceValue,
					module: sourceModule
				}
			};
			
		}
		
		return dataSource;
		
	}
	
	var checkSaveReport = function() {
		
		var detailCount = 0,
		filledFields = true;
	
		$.each($('.layout_group'), function() {
			if(in_array(this.value, ['Detail', 'Minute Detail', 'Quarter Hour Detail', 'Hour Detail', 'Day Detail', 'DoW Detail', 'WoY Detail', 'Month Detail', 'Natural Quarter Detail', 'Fiscal Quarter Detail', 'Natural Year Detail', 'Fiscal Year Detail']))	{
				detailCount++;
			}
		});
		
		$(".asolReportsChartsGroup").each(function(i) {
			$(this).find(".asolReportsChartRow").each(function(j) {
				if (($(this).find('.chart_display').val() === 'yes')) {
					if( $(this).hasClass('asolReportsMainChart') && ($(this).find('.chart_xaxis').val() === null || $(this).find('.chart_yaxis').val() === "" ))
						filledFields = false;
					else if( $(this).find('.chart_yaxis').val() === "" )
						filledFields = false;
				}
			});
		});
		
		if (typeof window.isBasicJavascriptLoaded == 'function' && detailCount <= 1 && filledFields) {
		
			return checkCreationForm(getCurrentDataSource(), $("#create_form").find("[name=is_meta]").val() == '1');
			
		} else {
			
			if (detailCount > 1)
				alert(SUGAR.language.get('asol_Reports', 'LBL_REPORT_TWO_OR_MORE_DETAIL'));
			else if (!filledFields)
				alert(SUGAR.language.get('asol_Reports', 'LBL_REPORT_GRAPH_FIELDS_ALERT'));
			
			return false;
			
		}
		
	}
	
	var executeReport = function() {
		
		var editContainer = $("#editContainer");
		
		var loadingMessageHtml = '<span id="loadingContainer" class="loadingContainer">';
		loadingMessageHtml += 		'<i class="loadingGIF icn-loading"></i>';
		loadingMessageHtml += 		'<span class="loadingTEXT"> '+SUGAR.language.get('asol_Reports', 'LBL_REPORT_LOADING_DATA')+'</span>';
		loadingMessageHtml += 	'</span>';
		
		var html = '<div id="previewContainer">'+loadingMessageHtml+'</div>';
		
		$(html).dialog({
			title: editContainer.find("#name").val(),
			closeOnEscape: true,
			overlay: {opacity: 0.8, background: 'black'},
			position: ['center', 'center'],
			width: $(window).width() - 25,
			height: $(window).height() - 25,
			close: function(event, ui) {
				$(this).remove();
			},
		});
		
		var record = window.currentRecord;
		var postParameters = new Object();
		
		postParameters['module'] = 'asol_Reports';
		postParameters['dashlet'] = 'true';
		postParameters['dashletId'] = 'Preview';
		postParameters['avoidAjaxRequest'] = 'true';
		postParameters['isPreview'] = 'true';
		
		var preview = {};
		preview.name = $("#mainInfo #name").val();
		preview.description = {};
		preview.description.public = $("#mainInfo #public_description").val();
		preview.data_source = getCurrentDataSource();
		
		var isMeta = ($("#create_form").find("[name=is_meta]").val() == '1');
		if ((typeof window.hasPremiumReportsJsFeatures == 'function') && (isMeta)) {
			preview.isMeta = '1';
			preview.metaHtml = getPreviewMetaReportsParameters();
		} else {
			preview.dynamicTables = ((typeof window.hasPremiumReportsJsFeatures == 'function') && (preview.database >= 0) ? getPreviewDynamicTables() : null);
			preview.dynamicSql = ((typeof window.hasPremiumReportsJsFeatures == 'function') && (preview.database >= 0) ? getPreviewDynamicSql() : null);
			preview.fields = encodeURIComponent(formatFields(true));
			preview.filters = encodeURIComponent(formatFilters(true, false));
			preview.charts = encodeURIComponent(formatCharts());
			preview.display = $("#create_form").find("[name=report_charts]").val();
			preview.chartsEngine = $("#report_charts_engine").val();
			preview.indexDisplay = $("#rowIndexDisplay").val();
			preview.resultsLimit = encodeURIComponent(formatResultsLimit());
		}
		
		postParameters['preview'] = encodeURIComponent(window.JSON.stringify(preview));
		
		api.detailReport(record, [], postParameters).done(function(data) {
			$('#previewContainer').html(data);
		}).error(function( jqXHR ){
			alert(jqXHR.statusText);
			$('#previewContainer').dialog("close");
		});
		
	}
	
	var cancelReport = function() {
		
		if (window['inlineEdition']) {
			
			$("#editContainerInline").dialog("close");
			
		} else {
		
			var listContainer = $("#listContainer");
			
			$.blockUI({ message: api.getBlockingMessage("load") });
			api.listReports().done(function(data) {
	    		listContainer.find('#reportRows').html(data);
	    		router.moveTo('list');
				reportsUtils.removeEditReportContent();
				$.unblockUI();
			});
		
		}
			
	}
	
	var resizeEvents = function() {
		
		var editContainer = $("#editContainer");
		editContainer.find('.fieldsPanel').resizable({
			handles: "e",
			minWidth: 180,
			resize: function (event, ui) {
				if (ui.size.width >= $('#fieldsFilters').width()/2) {
					ui.element.width($('#fieldsFilters').width()/2);
					$('#subQueryButtons>td.buttons').attr('width', $('#fieldsFilters').width()/2);
				} else {
					$('#subQueryButtons>td.buttons').attr('width', ui.size.width);
				}
				
			}
		});
		
	}

	return {
		manageDataSourceType : manageDataSourceType,
		manageDataSourceValue : manageDataSourceValue,
		manageDataSourceModule : manageDataSourceModule,
		manageEditionTabs : manageEditionTabs,
		resizeEvents : resizeEvents,
		getCurrentDataSource : getCurrentDataSource,
		
		executeReport : executeReport,
		cancelReport : cancelReport,
		saveReport : saveReport,
	};

})($, reportsApi, reportsRouter);
