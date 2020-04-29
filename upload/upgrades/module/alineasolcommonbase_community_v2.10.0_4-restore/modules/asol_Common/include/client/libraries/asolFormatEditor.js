var asolFormatEditor = (function($) {

	var singleFormats = ["varchar", "date", "int", "decimal", "currency", "percent", "bool"];
	
	var module = null;
	var language = {
		"type" : {
			"varchar" : "String",
			"date" : "Date",
			"int" : "Integer",
			"decimal" : "Decimal",
			"currency" : "Currency",
			"percent" : "Percent",
			"bool" : "Boolean",
			"enum" : "Enum",
			"multienum" : "Multi Enum",
			"tree" : "MultiLevel Enum",
			"relate" : "Relate",
			"button" : "Button",
			"password" : "Password",
			"multimedia" : "Multimedia",
			"color" : "Color",
			"text" : "Text",
			"file" : "File",
		},
		"icon": {
			"set" : "Set Icon",
			"search" : "Search",
			"rotate" : "Rotate",
			"other" : "Other Image",
			"save" : "Save",
			"clear": "Clear",
			"cancel": "Cancel",
		}
	};
	
	var setModule = function(currentModule) {
		module = currentModule;
	}
	
	var getModule = function() {
		return module;
	}
	
	var setLanguage = function(currentLanguage) {
		language = currentLanguage;
	}
	
	var getLanguage = function() {
		return language;
	}
	
	var generate = function(formatIcon, index, containerClass, extendedClass, currentValue, currentTemplates, currentField, currentType, commonScreen, disabledInputs) {
		
		var selectedType = ((typeof currentValue === 'undefined') || (typeof currentValue.type === 'undefined') ? '' : currentValue.type);
		
		var cell_Format_Type_Ext_HTML = "";
		
		//***********************//
		//***AlineaSol Premium***//
		//***********************//
		if ((module == 'asol_Forms' && typeof window.hasPremiumFormsJsFeatures == 'function') || (module == 'asol_Views' && typeof window.hasPremiumViewsJsFeatures == 'function') || (module == 'asol_Reports' && typeof window.hasPremiumReportsJsFeatures == 'function')) {
			var selectedExtra = ((typeof currentValue.extra === 'undefined') ? {} : currentValue.extra);
			cell_Format_Type_Ext_HTML += asolFormatEditorPremium.getFormatConfiguration(formatIcon, containerClass, extendedClass, commonScreen, selectedType, false, selectedExtra, currentTemplates, '', null);
		}
		//***********************//
		//***AlineaSol Premium***//
		//***********************//
	
		if (commonScreen) {
			return cell_Format_Type_Ext_HTML;
		} else {
			var cell_Format_Type_HTML = getAvailableTypes(selectedType, commonScreen, containerClass, currentField, index, disabledInputs);
			return cell_Format_Type_HTML + cell_Format_Type_Ext_HTML;
		}
		
	}
	
	var getSingleFormats = function() {
		
		return singleFormats;
		
	}
	
	var getAvailableTypes = function(selectedType, commonScreen, containerClass, currentField, index, disabledInputs) {
		
		var formatValues = [""];
		singleFormats.forEach(function(currentFormat) {
			formatValues.push(currentFormat);
		})
		
		//***********************//
		//***AlineaSol Premium***//
		//***********************//
		if ((module == 'asol_Forms' && typeof window.hasPremiumFormsJsFeatures == 'function') || (module == 'asol_Views' && typeof window.hasPremiumViewsJsFeatures == 'function') || (module == 'asol_Reports' && typeof window.hasPremiumReportsJsFeatures == 'function')) {
			formatValues = asolFormatEditorPremium.addPremiumFormatOptions(formatValues, containerClass, index);
		}
		//***********************//
		//***AlineaSol Premium***//
		//***********************//
		
		var cell_Format_Type_HTML = "<select class='format_type' "+disabledInputs+" onChange='if ((asolFormatEditor.getModule() == \"asol_Forms\" && typeof window.hasPremiumFormsJsFeatures == \"function\") || (asolFormatEditor.getModule() == \"asol_Views\" && typeof window.hasPremiumViewsJsFeatures == \"function\") || (asolFormatEditor.getModule() == \"asol_Reports\" && typeof window.hasPremiumReportsJsFeatures == \"function\")) { asolFormatEditorPremium.manageFormat("+(commonScreen ? 'true' : 'false')+", \""+currentField+"\", this.value, \""+index+"\", \""+containerClass+"\"); }'>";
		formatValues.forEach(function(currentFormat) {
			cell_Format_Type_HTML += "<option value='"+currentFormat+"' "+(currentFormat == selectedType ? 'selected' : '')+">"+(currentFormat !== '' ? language['type'][currentFormat] : '')+"</option>";
		});
		cell_Format_Type_HTML += "</select>";
		
		return cell_Format_Type_HTML;
		
	}
	
	var openIconSelector = function(button) {
		
		button = $(button);
		  
		var html = "",
		icons = [];
		 
		 html += '<div><div class="preview"></div><button class="rotate"><i class="icn-cw" title="cw"></i>'+language['icon'].rotate+'</button><div class="actions"><button class="use">'+language['icon'].save+'</button> <button class="clear">'+language['icon'].clear+'</button> <button class="cancel">'+language['icon'].cancel+'</button></div></div><div>'+
		 '<div class="search"><input type="search" placeholder="'+language['icon'].search+'"></div></hr><div class="allIcons">';
		 	 
		 $(document.styleSheets).each(function() {
		
		   if (typeof this.href == 'string' && this.href.includes("asolicons.css")){
		      
		       icons = $(this.cssRules).map(function(){
		         var result = /\.icn-(.*)\:\:before/g.exec(this.cssText)
		         return  result ? result[1].split('.').join(' ') : undefined;
		       }).get();
		   }
		 });
		  
		 icons.forEach(function(icoClass){
		  html += '<i class="icn-'+icoClass+'" title="'+icoClass+'"></i>';
		 });
		 
		 html += '</div>'+
		 
		 '<div>'+language['icon'].other+
		 ' <input type="text" placeholder="URL" id="otherIcon">'+
		 '</div>';
		 
		$('<div id="iconSelector">'+html+		
			'<style>'+
				'.allIcons{font-size: 17px;padding:5px;text-align:center;}'+
				'.allIcons i[class^="icn-"]{padding:5px;cursor:pointer}'+
				'.allIcons i[class^="icn-"]:hover{color:#2196f3;}'+
				'.allIcons .icn-alineasol{display:none}'+
				'.preview {display:inline-block;min-height: 50px;}'+
				'.rotate{display:none;float:right;margin:13px;}'+
				'.actions{position:absolute;bottom:0;left:5px;}'+
				'#otherIcon{margin-bottom:10px;}'+
				'#iconSelector{padding-bottom:25px;color:#3f3f3f;}'+
				'.search input{border:none;border-bottom: 1px solid #ced4da;width: 100%;}'+
				'.search input:focus{box-shadow:inherit!important;border-bottom-color:#2196F3 !important;}'+
				'.preview i[class^="icn-"]{font-size:40px;padding:5px;}'+
			'</style></div>').dialog({
				modal:true,
				title: language['icon'].set,
				width : 500,
				close: function() {
		            $(this).remove();
		        }
			});
		
		$('#iconSelector .allIcons i[class^="icn-"]').click(function(){
			if($._data(this, "events" ).hasOwnProperty('mouseout')){
				$('#iconSelector .allIcons i[class^="icn-"]').unbind("hover");
				$('#iconSelector .rotate').css('display', 'inline-block');
			}
			$('.preview').html($(this).clone());
		});
		

		$('#iconSelector .allIcons i[class^="icn-"]').hover(function(){
			$('.preview').html($(this).clone());
		});
		
		$('.search input').keyup(function(){
			$('.allIcons i:not([class*="'+this.value+'"])').hide();
			$('.allIcons i[class*="'+this.value+'"]').show();
			if(this.value == '') $('.allIcons i[class^="icn-"]:not(.icn-alineasol)').show();
		});
		
		$('.rotate').click(function(){
			var icon = $('.preview i[class^="icn-"]');
					
			if(icon.hasClass('right')) icon.removeClass('right').addClass('down');
			else if(icon.hasClass('down')) icon.removeClass('down').addClass('left');
			else if(icon.hasClass('left')) icon.removeClass('left');
			else icon.addClass('right');
		});
		
		$('#iconSelector .actions .use').click(function(){
			var newIcon = $('.preview :first-child').clone();
			if(newIcon[0].tagName == 'IMG') newIcon.css({ height: '18px', verticalAlign: 'middle'});
			button.html(newIcon);
			$(this).closest('.ui-dialog-content').dialog('close');
		});
		$('#iconSelector .actions .cancel').click(function(){
			$(this).closest('.ui-dialog-content').dialog('close');
		});
		$('#iconSelector .actions .clear').click(function(){
			button.html(language['icon'].set);
			$(this).closest('.ui-dialog-content').dialog('close');
		});
		
		$('#otherIcon').keyup(function(){
			$('#iconSelector .preview').html( '<img src="'+this.value+'" height="40">' );
		});
		
	}
	
	return {
		generate : generate,
		
		setModule : setModule,
		getModule : getModule,
		setLanguage : setLanguage,
		getLanguage : getLanguage,
				
		getSingleFormats : getSingleFormats,
		getAvailableTypes : getAvailableTypes,
		
		openIconSelector : openIconSelector,
	};
	
})($);