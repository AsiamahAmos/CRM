"use strict";

var controllerReportList = (function($, api, router) {

	var listReports = function() {
		
		var listContainer = $("#listContainer");
		$.blockUI({ message: api.getBlockingMessage("load") });
		api.listReports().done(function(data) {
			listContainer.find('#reportRows').html(data);
			$.unblockUI();
		});
		
	};
	
	var editReport = function(record, duplicate, draft) {
		
		var hasLoadingMessage = ($(".loadingReportContainer:visible").length > 0);
		
		if (!hasLoadingMessage) {
			$.blockUI({ message: api.getBlockingMessage("load") });
		}
		api.getEditData(record).done(function(json) {
			reportsUtils.populateEditView(json, duplicate);
            router.moveTo('edit', record);
            if (!hasLoadingMessage && window.endPopulate) {
            	$.unblockUI();
            }
		});
		
	}
	
	var createReport = function(meta) {
		
		var hasLoadingMessage = ($(".loadingReportContainer:visible").length > 0);
		
		if (!hasLoadingMessage) {
			$.blockUI({ message: api.getBlockingMessage("load") });
		}
		
		reportsUtils.removeEditReportContent(meta);
		router.moveTo('edit');
		
		if (!hasLoadingMessage) {
        	$.unblockUI();
        }
		
	}
	
	var detailReport = function(record) {
		
		var hasLoadingMessage = ($(".loadingReportContainer:visible").length > 0);
		
		var detailContainer = $("#detailContainer");
		if (!hasLoadingMessage) {
			$.blockUI({ message: api.getBlockingMessage("load") });
		}
		api.detailReport(record, null, {}).done(function(data) {
			window["currentRecord"] = record;
        	detailContainer.html(data);
        	
			detailContainer.find(".asolChartScript[proccess='1']").each(function() {
				eval(decodeURIComponent($(this).val()));
			});
			detailContainer.find(".asolChartScript").attr("proccess", "0");
        	
        	router.moveTo('detail', record);
        	if (!hasLoadingMessage) {
        		$.unblockUI();
        	}
		});
		
	}
	
	var deleteReport = function(record, name) {

		var listContainer = $("#listContainer");
		
		var confirmMessage = (record == null ? SUGAR.language.get('asol_Reports', 'LBL_REPORT_MULTIDELETE_ALERT') : SUGAR.language.get('asol_Reports', 'MSG_REPORT_DELETE_ALERT')+' '+decodeURIComponent(name).replace("&#039;","'"));
		
		var undeletableReportFlag = false;
		var undeletableReportElements = [];
		
		if (record == null) {

			listContainer.find(".listViewCheck:checked").each(function() {
				var currentReportDeletableFlag = $(this).parent().children('.deletableReport');
				if (currentReportDeletableFlag.val() == 'false') {
					undeletableReportFlag = true;
					undeletableReportElements.push($(this));
				}  
			});
			
			if (undeletableReportFlag) {
				confirmMessage+= '\n' + SUGAR.language.get('asol_Reports', 'LBL_REPORT_UNDELETABLE_ALERT');
			}

		}
		
		if (confirm(confirmMessage)) {

			$.blockUI({ message: api.getBlockingMessage("load") });
			undeletableReportElements.forEach(function(currentReport) {
				View.prop('checked', false);
			});
			var actionValue = (record == null ? listContainer.find(".listViewCheck:checked").map(function() { return this.value; }).get() : record);
			api.deleteReport(actionValue).done(function(data) {
				api.listReports().done(function(data) {
					listContainer.find('#reportRows').html(data);
					$.unblockUI();
				});
			});
			
		}
		
	};
	
	var exportReport = function(record) {

		var listContainer = $("#listContainer");
		
		var actionValue = (record == null ? listContainer.find(".listViewCheck:checked").map(function() { return this.value; }).get() : [record]);
		
		$.blockUI({ message: api.getBlockingMessage("load") });
		api.exportReport(actionValue).done(function(data) {
			$.unblockUI();
        	window.location = api.url+'&actionTarget=export_report&actionValue='+window.JSON.stringify(actionValue)+'&getContent=true';
		});
		
	};
	
	var importReport = function() {
		
		var listContainer = $("#listContainer");
		
		$.blockUI({ message: api.getBlockingMessage("load") });
		listContainer.find("#massive_form").attr("action", api.url+"&actionTarget=import_report");
		listContainer.find("#massive_form").ajaxForm({
			success: function(data) {
				api.listReports().done(function(data) {
					listContainer.find('#reportRows').html(data);
					$.unblockUI();
				});
			}
		});
		
	};
	
	var searchOnKeyPressed = function(event) {
	
		var listContainer = $("#listContainer");
		
		if ((event.which && event.which == 13) || (event.keyCode && event.keyCode == 13)) {
			listContainer.find('#page_number').val("0"); 
			listReports();
		}
	
	};
	
	var massiveAction = function(isMassive, currentRef) {

		var listContainer = $("#listContainer");
		
		if (isMassive) {
			
			var checkAll = $(currentRef).is(':checked');
	
			listContainer.find('#reportRows .massiveCheck').prop('checked', checkAll);
			listContainer.find('#reportRows .massiveAction').prop('disabled', !checkAll);
			
		} else {
			
			var numElements = listContainer.find('#reportRows .massiveCheck').length;
			var numElementsChecked = listContainer.find('#reportRows .massiveCheck:checked').length;

			listContainer.find('#reportRows .massiveAction').prop('disabled', (numElementsChecked === 0));
			listContainer.find('#reportRows .massiveCheckAll').prop('checked', (numElementsChecked === numElements));
			
		}
			
	}
	
	var manageDataSourceType = function(dataSourceType) {
		
		var listContainer = $("#listContainer");
		
		switch (dataSourceType.value) {
		
			case "0": //DB
				listContainer.find('#data_source_value').css('visibility', 'visible'); 
				listContainer.find('#data_source_module').val('').css('visibility', 'hidden'); 
				break;
				
			default:
				listContainer.find('#data_source_value').css('visibility', 'hidden'); 
				listContainer.find('#data_source_module').css('visibility', 'hidden');
				break;
	
		}
		
	}


	var manageDataSourceValue = function(dataSourceValue) {
		
		var listContainer = $("#listContainer");
		
		if (dataSourceValue.value !== '')
			listContainer.find('#data_source_module').css('visibility', 'inherit'); 
		else 
			listContainer.find('#data_source_module').css('visibility', 'hidden');
		
		var currentTables = window.JSON.parse(unescape($(dataSourceValue).find('option:selected').attr('tables')));

		listContainer.find('#data_source_module option').remove();
		
		listContainer.find('#data_source_module').append($('<option>', { value: '', text: '' }));
		for (var key in currentTables) {
			listContainer.find('#data_source_module').append($('<option>', { value: key, text: currentTables[key] }));
		}
		
	}
	
	var getCurrentDataSource = function() {
		
		var listContainer = $("#listContainer");
		var dataSource = null;
		
		var sourceType = listContainer.find('#data_source_type').val();
		var sourceValue = listContainer.find('#data_source_value').val();
		var sourceModule = listContainer.find('#data_source_module').val();
		
		if (sourceType == '0') {
			
			dataSource = {
				type: sourceType,
				value: {
					database: sourceValue,
					module: sourceModule
				}
			};
			
		} else if (sourceType == '1') {
			
			dataSource = {
				type: sourceType,
				value: {
					api: sourceValue,
					module: sourceModule
				}
			};
			
		}
		
		return dataSource;
		
	}

	return {
		listReports : listReports,
		editReport : editReport,
		detailReport : detailReport,
		deleteReport : deleteReport,
		exportReport : exportReport,
		importReport : importReport,
		createReport : createReport,
		
		searchOnKeyPressed : searchOnKeyPressed,
		getCurrentDataSource : getCurrentDataSource,
		massiveAction : massiveAction,
		
		manageDataSourceType : manageDataSourceType,
		manageDataSourceValue : manageDataSourceValue,
	};

})($, reportsApi, reportsRouter);
