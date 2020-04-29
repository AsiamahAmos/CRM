"use strict";
if( !commonRouter ){
var commonRouter = (function($, window) {

	var views = {
		list : 'listContainer',
		edit : 'editContainer',
		detail : 'detailContainer',
	};
	
	var urlAction = '&action=index';
	
	var history = {};
	
	var init = function() {
					
		var readyInterval = setInterval(function() {
				 
			if(/loaded|complete/.test(document.readyState)) {
		          	clearInterval(readyInterval);	          
		          
		          	var newState = {
		  				url : window.location.href,
		  				container : '#content',
		  				trigger : 'window.location.href="'+window.location.href+'"',
		  				html : $('#content').html(),
		  			};
		     
		  			setNewState(newState, true);
			}
			
		}, 80);

		window.onpopstate = onStateChange ;
	};
	
	var onStateChange = function(event) {
		
		var state = history[event.state.url];
		
		if( state && state.html ) 
			loadBaseContent( state );
		else
			eval('(function(){'+state.trigger+'})()');
		
		$('html, body').scrollTop(0);
		
		asolNavLinks.removeTempMenuElement();
		
		window.currentLocationState = event.state;
		
		asolNavLinks.autoSetMenuElement(event.state.url);

	};
	
	var loadBaseContent = function( state ) {
		
		var newNode = document.createElement("div");
		
		var LabWait = $LAB;
		
		$.each($(state.html),function(){
			  if ( this.nodeType != Node.TEXT_NODE && this.nodeName == "SCRIPT" && this.hasAttribute("src") )  
				  LabWait = LabWait.script( this.getAttribute("src") ).wait();
			  else 
				  newNode.appendChild( this );
		});
		
		LabWait.wait(function() {
			var scripts = $(newNode).find('script'); //Remove inline Scripts
			$(newNode).find('script').remove();
			$(state.container).html( $(newNode).children() );
			setTimeout(function(){ $(state.container).append( scripts ); },20); //Run inline after node ready
		});
		
		return { 
			done : LabWait.wait
		};
		
	}
	
	var moveTo = function(state, record, unique, back) {

		var dest = typeof state !== 'undefined' ? state : 'list';
		dest = (typeof dest === 'object'? dest.view : dest);
		record = typeof record !== 'undefined' ? record : '';
		unique = typeof unique !== 'undefined' ? unique : '';
		
		if (views[dest] !== undefined) {
									
			var urlView = '&view=' + dest;
			var	urlRecord = (record !== '') ? '&record=' + record : '';
			var urlUnique = (unique !== '') ? '&unique=' + unique : '';
			
			var url = window.location.origin + window.location.pathname +'?module='+getUrlParams('module')+ urlAction + urlView + urlRecord + urlUnique;
						
			hideAll();
			$("#" + views[dest]).show();
						
			if (!back) {
				var newState = {
					url : url,
					container : '#content',
					trigger :  'window.location.href="'+url+'"',
					html : $('#content').html(),
					view : dest,
				};
				setNewState(newState);
			}
		}
		
	};
	
	var hideAll = function() {
		
		$.each(views, function(key, value) {
			$("#" + value).hide();
		});
		
	};
	
	var getUrlParams = function(param, url) {
		
		param = (typeof param == "string" ?  param : false);
		url = (typeof url == "string" ? url : window.location.search);
		
		var params = {}
		if (url != '') {
			url.split('?')[1].split('&').forEach(function(param){ param = param.split('='); params[param[0]] = param[1] });
		}
		
		if (!param) {
			return params;
		} else {
			return params[param];
		}
		
	}

	var getNewUrl = function(idView, record) {
		
		var newUrl;
		
		if (getUrlParams('module') == 'asol_Views') {
			
			newUrl = window.location.href.replace(/(record=).*?(&|$)/,'$1' + idView + '$2').replace(/(id=).*?(&|$)/,'$1' + record + '$2');
		
		} else {
			
			newUrl = window.location.href.replace(/(id=).*?(&|$)/,'$1' + idView + '$2');

			if (typeof record == 'string') {
				if (getUrlParams('record') == undefined) {
					newUrl = newUrl+'&record='+record; 
				} else {
					newUrl = newUrl.replace(/(record=).*?(&|$)/,'$1' + record + '$2');
				}
			} else { 
				newUrl = newUrl.replace(/(record=).*?(&|$)/,'').replace(/&$/,'');;
			}
			
		}
		
		return newUrl;
		
	}
	
	var setNewState = function(newState, update) {
		
		if (typeof window.history.pushState !== 'undefined') {
			history[newState.url] = {
				container : '#content',
				html : $('#content').html(),
				trigger : newState.trigger,
				url : newState.url,
			};
			
			delete newState.html;
			if (update) {
				window.history.replaceState(newState, document.title, newState.url);
			} else {
				window.history.pushState(newState, document.title, newState.url);
				if( window.asolNavLinks ) asolNavLinks.updateRecentlyViewed();
			}
			window.currentLocationState = window.history.state;
		}
	}
	
	//********************//
	//***Initialization***//
	//********************//

	init();
		
	//********************//
	//***Initialization***//
	//********************//

	return {
		hideAll : hideAll,
		moveTo : moveTo,
		getNewUrl : getNewUrl,
		setNewState : setNewState,
		history : history,
		getUrlParams : getUrlParams
	};

})($, window);

var viewsRouter = commonRouter,
formsRouter  = commonRouter,
reportsRouter = commonRouter; 

}else console.error('New load of commonRouter');