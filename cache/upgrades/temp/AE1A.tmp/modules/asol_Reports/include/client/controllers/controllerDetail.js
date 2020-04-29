"use strict";

var controllerReportDetail = (function($, api, router) {

	var language = {
		"searchMode" : {
			"basic" : "Basic Search",
			"advanced" : "Advanced Search",
		},
	}
	
	var setLanguage = function(currentLanguage) {
		language = currentLanguage;
	}
	
	var getLanguage = function() {
		return language;
	}
		
	var editReport = function() {
		
		var record = window["currentRecord"];
		$.blockUI({ message: api.getBlockingMessage("load") });
		api.getEditData(record).done(function(json) {
			reportsUtils.populateEditView(json, false);
            router.moveTo('edit', record);
            $.unblockUI();
		});
		
	}
	
	var cancelReport = function(dashletId) {
		
		var listContainer = $("#listContainer");
		var detailContainer = $("#detailContainer"+dashletId);
		
		$.blockUI({ message: api.getBlockingMessage("load") });
		window["currentRecord"] = "";
		window["parentRecord"] = "";
		
		detailContainer.html("");
        
		api.listReports().done(function(data) {
    		listContainer.find('#reportRows').html(data);
    		router.moveTo('list');
			$.unblockUI();
		});
		
	}
	
	var reloadReport = function(buttonRef, record, refresh, context) {
		
		var metaContainer = $(buttonRef).closest("#metaReportExecution");
		var isMetaReportReload = (((typeof window.hasPremiumReportsJsFeatures == "function") && (metaContainer.length > 0)) && !refresh);
		
		var containerSelector = (isMetaReportReload ? (context.dashlet ? "[id='detailContainer"+metaContainer.attr('class')+"']" : "[id='detailContainer']") : (context.dashlet ? "[id='detailContainer"+context.dashletId+"']" : "[id='detailContainer']"))
		var mainReportSelector = (isMetaReportReload ? (context.dashlet ? "[id='detailMetaContainer']."+context.dashletId : "[id='detailMetaContainer']") : (context.dashlet ? "[id='detailContainer"+context.dashletId+"']" : "[id='detailContainer']"));
		var pushedReportsSelector = (isMetaReportReload ? "[id='detailMetaContainer'][pushed='"+context.dashletId+"']" : null);
		
		var hasLoadingMessage = ($("div"+mainReportSelector).prev(".loadingReportContainer:visible").length > 0);
		hasLoadingMessage = (!hasLoadingMessage ? $("div"+mainReportSelector).find(".loadingReportContainer:visible, .loadingContainer:visible").length > 0 : hasLoadingMessage);
		
		if (!hasLoadingMessage) {
			try {
				$("div"+mainReportSelector+' .asolReportExecution').block({ message: api.getBlockingMessage("loadReport") });
				if (pushedReportsSelector != null) {
					$("div"+pushedReportsSelector).block({ message: api.getBlockingMessage("loadReport") });
				}
			} catch(error) {}
		}
		
		if ((typeof window.hasPremiumReportsJsFeatures == "function") && isMetaReportReload) {
			context.overrideInfo = getMetaReportInfo(context.dashletId);
			context.overrideFilters = getMetaReportFilters(context.dashletId);
			context.multiExecution = "true";
				
			var hasPushedReports = $("div"+pushedReportsSelector).length > 0;
			if (hasPushedReports) {
				var multiExecutionData = getMultiExecutionData(pushedReportsSelector, context.dashletId);
				context.pushedRecords = multiExecutionData["pushedRecords"];
				context.pushedInfos = multiExecutionData["pushedInfos"];
				context.pushedFilters = multiExecutionData["pushedFilters"];
			}
		}
		
		context.avoidAjaxRequest = 'true';
		context.getLibraries = false;
		context.onlyExecuted = true;
		if (!refresh) {
			context.search_criteria = '1';
			context.external_filters = encodeURIComponent(formatExternalFilters(context.dashletId));
			//***AlineaSol Premium***//
		    if (typeof window.hasPremiumReportsJsFeatures == 'function') {
		    	context = getSearchMode(context.dashletId, context);
		    }
			//***AlineaSol Premium***//
		}

	    var previewAttribute = $("div"+containerSelector+":visible").attr("preview");
		var previewContext = (typeof previewAttribute !== 'undefined' ? window.JSON.parse(unescape(previewAttribute)) : {});
		if (previewContext.hasOwnProperty('isPreview')) {
			context['isPreview'] = previewContext['isPreview'];
			context['preview'] = encodeURIComponent(window.JSON.stringify(previewContext['preview']));
	    }
		
		var hasWrongOrder = ((context.sort_field == '') || (context.sort_direction == '') || (context.sort_index == ''));
		context.sort_field = (hasWrongOrder ? '' : context.sort_field);
		context.sort_direction = (hasWrongOrder ? '' : context.sort_direction);
		context.sort_index = (hasWrongOrder ? '' : context.sort_index);
		
		try {
			api.detailReport(record, null, context).done(function(data) {
				try {
					data = window.JSON.parse(data);
				} catch (error) {
					isMetaReportReload = false;
				}
				
				if (isMetaReportReload) {
					reloadMetaReport(hasPushedReports, data, mainReportSelector, pushedReportsSelector);
					containerSelector = mainReportSelector+',div'+pushedReportsSelector;
		        } else {
		        	var detailContainer = $("div"+mainReportSelector+' .asolReportExecution');
			    	detailContainer.replaceWith(data);
				}
				
				$("div"+containerSelector).find(".asolChartScript[proccess='1']").each(function() {
		    		eval(decodeURIComponent($(this).val()));
				});
				$("div"+containerSelector).find(".asolChartScript").attr("proccess", "0");
				
	        	if (typeof alineaSolReportsCallback == "function") {
	    			alineaSolReportsCallback();
	    		}
	        	
	        	if (!hasLoadingMessage) {
	        		$.unblockUI();
	        		try {
	    				$("div"+mainReportSelector+' .asolReportExecution').unblock();
	    				if (pushedReportsSelector != null) {
	    					$("div"+pushedReportsSelector).unblock();
	    				}
	    			} catch(error) {}
	        	}
	        	
			});
		} catch (error) {
			context.dashletId = context.dashletId.replace(/-/g, '');
			window["reloadCurrentDashletReport"+context.dashletId](buttonRef, refresh, context.page_number, context.sort_field, context.sort_direction, context.sort_index, context.external_filters, context.staticFilters);
		}
			
	}
	
	var massiveAction = function(dashletId, isMassive, currentRef) {

		var detailContainer = $("#detailContainer"+dashletId);
		
		if (isMassive) {
			
			var checkAll = $(currentRef).is(':checked');
	
			detailContainer.find('.massiveCheck').prop('checked', checkAll);
			detailContainer.find('.massiveAction').prop('disabled', !checkAll);
			
		} else {
			
			var numElements = detailContainer.find('.massiveCheck').length;
			var numElementsChecked = detailContainer.find('.massiveCheck:checked').length;

			detailContainer.find('.massiveAction').prop('disabled', (numElementsChecked === 0));
			detailContainer.find('.massiveCheckAll').prop('checked', (numElementsChecked === numElements));
			
		}
			
	}
	
	return {
		setLanguage : setLanguage,
		getLanguage : getLanguage,
		
		editReport : editReport,
		cancelReport : cancelReport,
		reloadReport: reloadReport,
		
		massiveAction : massiveAction,
	};

})($, reportsApi, reportsRouter);
