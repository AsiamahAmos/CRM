"use strict";

var reportsApi = (function($) {

	var url = 'index.php?entryPoint=asolReportsApi&module=asol_Reports';

	var language = {
		"blocking" : {
			"load" : "Loading",
			"save" : "Saving",
			"loadReport" : "Loading Report",
		}
	}
	
	var setLanguage = function(currentLanguage) {
		language = currentLanguage;
	}
	
	var getBlockingMessage = function(mode) {
		
		return '<span class="loadingReportContainer">'+
					'<i class="loadingGIF icn-loading" '+(mode != null ? '' : 'style="font-size: 3em;"')+'></i>'+
					(mode != null ? '&nbsp;'+language.blocking[mode] : '')+
			   '</span>';
		
	}
	
	var listReports = function() {
		
		var listContainer = $("#listContainer");
		
		return $.ajax({
			url: url,
	        type: 'POST',
	        dataType: 'text',
	        data: {
	        	actionTarget: 'list_reports',
	        	actionValue: {
	        		filters: {
	        			name: listContainer.find('#name').val(),
	        			data_source: controllerReportList.getCurrentDataSource(),
	        			scope: listContainer.find('#scope').val(),
	        			type: listContainer.find('#type').val(),
	        			meta: listContainer.find('#meta_basic').val(),
			            assigned_user_id: listContainer.find('#assigned_user_id').val(),
			            assigned_user_name: listContainer.find('#assigned_user_name').val(),
	        		},
	        		position: {
	        			field: listContainer.find('#sort_field').val(),
			            direction: listContainer.find('#sort_direction').val(),
						page : listContainer.find('#page_number').val(),
	        		}
	        	}
	        }
		});
		
	}
	
	var getEditData = function(record) {
		
		return $.ajax({
			url: url,
	        type: 'POST',
	        dataType: 'text',
	        data: {
	        	actionTarget: 'get_edit_report',
	        	actionValue : record,
	        }
		});
		
	}
	
	var editReport = function(record, context) {
	
		return $.ajax({
			url: url,
	        type: 'POST',
	        dataType: 'text',
	        data: {
	        	actionTarget: 'edit_report',
	        	actionValue : record,
	        	actionContext : context,
	        }
		});
	
	}
	
	var deleteReport = function(record) {
		
		return $.ajax({
			url: url,
	        type: 'POST',
	        dataType: 'text',
	        data: {
	        	actionTarget : 'delete_report',
	        	actionValue : record,
	        }
		});
		
	}

	var saveReport = function(record, data) {
		
		var editContainer = $("#editContainer");
		
		if (data !== null) {
			
			data.id = null;
			
		} else {
			
			var isMeta = (editContainer.find("[name=is_meta]").val() == '1');

			data = {
				"record" : record,
				"is_meta" : isMeta,
				"name" :  encodeURIComponent(editContainer.find("#name").val()),
				"scheduled_images" :  (editContainer.find('#scheduled_images').is(":checked") ? 1 : 0),
				"assigned_user_id" : editContainer.find('[name="assigned_user_id"]').val(),
				"description" : {
					"public" : editContainer.find("#internal_description").val(),
					"internal" : editContainer.find("#public_description").val(),
				},
				"email_list" : formatEmailList(),
				"report_type" : {
					"type" : editContainer.find("#report_type").val(),
					"draft" : (editContainer.find("#report_type").attr("draft") == '1' ? '1' : '0'),
					"data" : editContainer.find("#report_type").attr("data"),
				},
				"report_scheduled_type" : (editContainer.find("#report_type").val() == 'scheduled' ? (editContainer.find("#report_scheduled_type_info").val() !== '' ? editContainer.find("#report_scheduled_type").val()+':'+editContainer.find("#report_scheduled_type_info").val() : editContainer.find("#report_scheduled_type").val()) : null), 
				"report_scope" : editContainer.find('.reportScope').val() == "public" ? editContainer.find('.reportScope').val() : editContainer.find('.reportScope').val()+'${dp}'+( editContainer.find('.scopeRole').val() ? editContainer.find('.scopeRole').val().join('${comma}') : '' ),
				"report_attachment_format" : editContainer.find("#report_attachment_format").val(),
				"report_format_file_config" : editContainer.find("#asolReportsFileFormatConfig").val(),
			}
			
			if ((typeof window.hasPremiumReportsJsFeatures == 'function') && (isMeta)) {
				
				data['meta_html'] = escape(CKEDITOR['instances']['meta_html'].getData());
				data['report_fields'] = {'tables':[{'css': editContainer.find(".configureCssButton").attr("value")}]};
				
			} else {
				
				$.extend(data, {
					data_source : controllerReportEdit.getCurrentDataSource(),
					dynamic_tables : ((typeof window.hasPremiumReportsJsFeatures == 'function') && (editContainer.find("#data_source_value").val() >= 0) ? getPreviewDynamicTables() : null),
					dynamic_sql : ((typeof window.hasPremiumReportsJsFeatures == 'function') && (editContainer.find("#data_source_value").val() >= 0) ? getPreviewDynamicSql() : null),
					content : {
						fields : window.JSON.parse(formatFields(true)),
						filters : window.JSON.parse(formatFilters(true, false)),
						charts_detail : window.JSON.parse(formatCharts()),
						charts_engine : editContainer.find("#report_charts_engine").val(),
						tasks : window.JSON.parse(formatTasks()),
						results_limit : formatResultsLimit(),
					},					
					report_charts : editContainer.find("#report_charts").val(),
					row_index_display : editContainer.find("#rowIndexDisplay").val(),
					dynamic_sql : editContainer.find("[name=dynamic_sql]").val(),
					domains : {
						id : editContainer.find("#asol_domain_id").val(),
						mode : editContainer.find("#asol_domain_published_mode").val(),
						level : editContainer.find("#asol_domain_child_share_depth").val(),
						publish : editContainer.find("#asol_multi_create_domain").val(),
						enable : editContainer.find("#asol_published_domain").val(),
					}
				});
				
			}
		
		}
			
		var response = $.ajax({
			url: url,
	        type: 'POST',
	        dataType: 'text',
	        data: {
	        	actionTarget: 'save_report',
	        	actionValue : window.JSON.stringify(data),
	        }
		});
		
		return response;
		
	}
		
	var exportReport = function(record) {

		return $.ajax({
			url: url,
	        type: 'POST',
	        dataType: 'text',
	        data: {
	        	actionTarget: 'export_report',
	        	actionValue : record,
	        	getContent : false,
	        }
		});
		
	}
	
	var detailReport = function(record, mapping, context) {

		context = (context ? context : {});

		var overrideFilters = {};
		if (mapping != null && Object.keys(mapping).length > 0) {
			for (var mappingReference in mapping) {
				var mappingValue = mapping[mappingReference]; 
				overrideFilters[mappingReference] = {
					'parameters' : {
						'first' : [mappingValue]
					},
				};
		    }
		}
	    context.staticFilters = (Object.keys(overrideFilters).length > 0 ? window.JSON.stringify(overrideFilters) : context.staticFilters);
	    
		for (var prop in context) { 
			if (context[prop] === null || context[prop] === undefined) {
				delete context[prop];
			}
		}
		
		//***AlineaSol Premium***//
	    if (typeof window.hasPremiumViewsJsFeatures == 'function') {
	    	updateElementStoredContext(context.dashletId, context);
	    }
		//***AlineaSol Premium***//
		
		return $.ajax({
			url: url,
	        type: 'POST',
	        dataType: 'text',
	        data: {
	        	actionTarget: 'display_report',
	        	actionValue : record,
	        	actionMapping : mapping,
	        	actionContext : context
	        }
		});
		
	}
	
	return {
		url : url,
		
		setLanguage : setLanguage,
		getBlockingMessage : getBlockingMessage,
		
		listReports : listReports,
		getEditData : getEditData,
		editReport : editReport,
		saveReport : saveReport,
		deleteReport : deleteReport,
		exportReport : exportReport,
		detailReport : detailReport
	};

})($);
