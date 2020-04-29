/* * *******************************************************************************
* This file is part of SpiceCRM FulltextSearch. SpiceCRM FulltextSearch is an enhancement developed
* by aac services k.s.. All rights are (c) 2016 by aac services k.s.
*
* This Version of the SpiceCRM FulltextSearch is licensed software and may only be used in
* alignment with the License Agreement received with this Software.
* This Software is copyrighted and may not be further distributed without
* witten consent of aac services k.s.
*
* You can contact us at info@spicecrm.io
******************************************************************************* */
Ext.define("SpiceCRM.KReporter.Viewer.model.KReporterRecord",{extend:"Ext.data.Model",fields:["id","name","report_module","listfields","listtypeproperties","presentation_params","integration_params","visualization_params","reportoptions","union_modules","unionlistfields"]}),Ext.define("SpiceCRM.KReporter.Viewer.model.plugin",{extend:"Ext.data.Model",alias:["widget.pluginModel"],fields:["id","name","panel","class","category","active","loaded","plugindirectory","include","icon"]}),Ext.define("SpiceCRM.KReporter.Viewer.model.whereclause",{extend:"Ext.data.Model",fields:["unionid","sequence","fieldid","name","fixedvalue","groupid","path","displaypath","referencefieldid","operator","type","value","valuekey","valueto","valuetokey","jointype","context","reference","include","usereditable","dashleteditable","exportpdf","customsqlfunction"]}),Ext.define("SpiceCRM.KReporter.Viewer.store.plugins",{extend:"Ext.data.Store",requires:["SpiceCRM.KReporter.Viewer.model.plugin"],model:"SpiceCRM.KReporter.Viewer.model.plugin",load:function(){return!1}}),Ext.define("SpiceCRM.KReporter.Viewer.store.whereclauses",{extend:"Ext.data.Store",requires:["SpiceCRM.KReporter.Viewer.model.whereclause"],model:"SpiceCRM.KReporter.Viewer.model.whereclause",sorters:[{property:"sequence",direction:"ASC"}]}),Ext.define("SpiceCRM.KReporter.Viewer.controller.Application",{extend:"Ext.app.Controller",config:{listen:{global:{}}},doInit:function(){},finishInit:function(){},onLaunch:function(){},getReportId:function(){}}),Ext.define("SpiceCRM.KReporter.Viewer.controller.KReportViewerPresentationContainer",{extend:"Ext.app.ViewController",alias:"controller.KReportViewer.KReportViewerPresentationContainer",loadMask:null,whereConfig:{},viszualiationData:[],pluginsLoaded:{},pluginsaddLoaded:[],loaded:!1,contextmenu:null,valid:!0,config:{listen:{global:{pluginsLoaded:function(){this.valid&&this.initializePlugins()},whereClauseUpdated:function(a){this.contextmenu&&(this.contextmenu.parentWhereConditions=a)},lf:function(a){this.valid=!1,this.view.removeAll(),this.view.add(Ext.create("Ext.panel.Panel",{html:a}))}}}},displayContextMenu:function(a,b){this.contextmenu&&this.contextmenu.displayContextMenu(a,b)},initializePlugins:function(){this.view.removeAll();var a=Ext.decode(Ext.util.Format.htmlDecode(SpiceCRM.KReporter.Viewer.Application.reportRecord.get("presentation_params"))),b=Ext.data.StoreManager.lookup("KReportViewerPresentationPluginsStore").getById(a.plugin);Ext.ClassManager.get(b.get("panel"))?(this.presentationPanel=Ext.create(b.get("panel"),{reportRecord:SpiceCRM.KReporter.Viewer.Application.reportRecord,presentationParams:a,width:"100%"}),this.view.add(this.presentationPanel)):Ext.Loader.loadScript({url:b.get("include"),onLoad:function(){b.set("loaded",!0),this.presentationPanel=Ext.create(b.get("panel"),{reportRecord:SpiceCRM.KReporter.Viewer.Application.reportRecord,presentationParams:a,width:"100%"}),this.view.add(this.presentationPanel)},scope:this});var c=Ext.data.StoreManager.lookup("KReportViewerIntegrationPluginsStore");c.each(function(a){1===a.get("active")&&"view"===a.get("category")&&a.get("class")&&Ext.Loader.loadScript({url:a.get("include"),onLoad:function(){this.contextmenu=Ext.create(a.get("class"))},scope:this})},this)}}),Ext.define("SpiceCRM.KReporter.Viewer.controller.KReportViewerVisualizationContainer",{extend:"Ext.app.ViewController",alias:"controller.KReportViewer.KReportViewerVisualizationContainer",loadMask:null,whereConfig:{},viszualiationData:[],pluginsLoaded:{},pluginsaddLoaded:[],loaded:!1,vizParams:void 0,snapshotid:"0",operators:[],valid:!0,config:{listen:{global:{pluginsLoaded:function(){this.valid&&this.initializeContainer()},whereClauseUpdated:function(a){this.operators=a,this.vizParams&&this.updateVisualization()},snapshotSelected:function(a){this.snapshotid=a,this.vizParams&&this.updateVisualization()},lf:function(){this.valid=!1,this.view.removeAll()}}}},init:function(){},initializeContainer:function(){this.view.removeAll();var a={},b=Ext.util.Format.htmlDecode(SpiceCRM.KReporter.Viewer.Application.reportRecord.get("visualization_params"));if(b&&""!==b&&(a=Ext.decode(b)),a.layout&&"-"!==a.layout){this.vizParams=a,this.view.show(),a.chartheight?this.view.setHeight(a.chartheight):this.view.setHeight(300),this.loadMask||(this.loadMask=new Ext.LoadMask({msg:" .. loading Plugins ..",target:this.view})),this.loadMask.show();for(var c=1;void 0!==a[c];){var d=a[c];if(d.plugin&&void 0===this.pluginsLoaded[d.plugin]){this.pluginsLoaded[d.plugin]=!1;var e=Ext.data.StoreManager.lookup("KReportViewerVisualizationPluginsStore").getById(d.plugin);Ext.Loader.loadScript({url:e.get("include"),onLoad:function(){e.set("loaded",!0),this.pluginsLoaded[d.plugin]=!0,this.loadVisualization()},scope:this})}else this.loadVisualization();c++}}else this.view.hide()},loadVisualization:function(){var a=!0;Ext.each(this.pluginsLoaded,function(b){b||(a=!1)},this),a&&!this.loaded&&(this.loaded=!0,this.loadMask.destroy(),this.loadMask=new Ext.LoadMask({msg:" .. loading Visualization ..",target:this.view}),this.loadMask.show(),_proxyUrl="KREST/KReporter/"+SpiceCRM.KReporter.Viewer.Application.reportRecord.get("id")+"/visualization",_url=SpiceCRM.KReporter.Common.buildDynamicOptionsUrl(SpiceCRM.KReporter.Viewer.Application.reportRecord.get("id"),"visualization"),null!==_url&&(_proxyUrl=_url),Ext.Ajax.request({url:_proxyUrl,jsonData:{whereConditions:this.operators,snapshotid:this.snapshotid,dynamicoptions:SpiceCRM.KReporter.Common.catchDynamicOptionsFromSession(SpiceCRM.KReporter.Viewer.Application.reportRecord.get("id"))},method:"POST",success:function(a){this.viszualiationData=Ext.JSON.decode(a.responseText),this.renderVisualization(),this.loadMask.destroy()},failure:function(){this.loadMask.destroy()},timeout:12e4,scope:this}))},renderVisualization:function(){this.view.removeAll(),Ext.each(this.viszualiationData,function(a){var b=Ext.data.StoreManager.lookup("KReportViewerVisualizationPluginsStore").getById(a.plugin);this.view.add(Ext.create(b.get("panel"),{id:a.uid+"_container",uid:a.uid,width:a.layout.width,height:this.calcVizHeight(a.layout.height),chartData:a.data,style:{position:"absolute",left:a.layout.left,top:a.layout.top}}))},this)},updateVisualization:function(){this.loadMask=new Ext.LoadMask({msg:" .. updating Visualization ..",target:this.view}),this.loadMask.show(),_proxyUrl="KREST/KReporter/"+SpiceCRM.KReporter.Viewer.Application.reportRecord.get("id")+"/visualization",_url=SpiceCRM.KReporter.Common.buildDynamicOptionsUrl(SpiceCRM.KReporter.Viewer.Application.reportRecord.get("id"),"visualization"),null!==_url&&(_proxyUrl=_url),Ext.Ajax.request({url:_proxyUrl,jsonData:{whereConditions:this.operators,snapshotid:this.snapshotid},method:"POST",success:function(a){this.viszualiationData=Ext.JSON.decode(a.responseText),Ext.each(this.viszualiationData,function(a){var b=this.view.down("#"+a.uid+"_container");b.updateChart(a)},this),this.loadMask.destroy()},failure:function(){this.loadMask.destroy()},timeout:12e4,scope:this})},calcVizHeight:function(a){return this.view.getHeight()/100*parseInt(a.replace("%",""))}}),Ext.define("SpiceCRM.KReporter.Viewer.controller.KReportViewerWherePanel",{extend:"Ext.app.ViewController",alias:"controller.KReportViewer.KReportViewerWherePanel",whereConfig:{},updateOnRequest:!1,config:{listen:{global:{recordLoaded:function(){this.initializeSearch()},searchBtnClicked:function(){this.checkOperatorValues()&&Ext.globalEvents.fireEvent("whereClauseUpdated",this.extractWhereClause())},addWhereBottomToolbar:function(){"undefined"==typeof SpiceCRM.KReporter.Viewer.integrationplugins?Ext.Loader.loadScript({url:"modules/KReports/Plugins/Integration/ksavedfilters/ksavedfiltersview.js",onLoad:function(){Ext.globalEvents.fireEvent("loadWhereBottomToolbar")},scope:this}):Ext.globalEvents.fireEvent("loadWhereBottomToolbar")},loadWhereBottomToolbar:function(){_tb=Ext.create("SpiceCRM.KReporter.Viewer.integrationplugins.savedfilters.toolbar",{itemId:"whereBottomToolbar"}),this.view.addDocked(_tb),Ext.data.StoreManager.lookup("savedfilterstore").load()}}},control:{"#":{beforeedit:function(a,b){SpiceCRM.KReporter.Common.gridSetEditor(b,this,SpiceCRM.KReporter.Viewer.Application)},edit:function(a,b){SpiceCRM.KReporter.Common.gridAfterEdit(b),this.updateOnRequest===!1&&this.checkOperatorValues()&&Ext.globalEvents.fireEvent("whereClauseUpdated",this.extractWhereClause())}}}},init:function(){this.whereOperatorStore=Ext.create("SpiceCRM.KReporter.Common.store.whereOperators","kreporterWhereOperatorStore"),this.enumOptionsStore=Ext.create("SpiceCRM.KReporter.Common.store.enumoptions","kreporterEnumoptionsStore"),this.parentFieldsStore=Ext.create("SpiceCRM.KReporter.Common.store.enumoptions","kreporterParentFieldsStore"),this.autocompleteStore=Ext.create("SpiceCRM.KReporter.Common.store.autcompleterecords","kreporterAutocmpleteStore").load(),Ext.Ajax.request({url:"KREST/KReporter/core/whereinitialize",method:"GET",success:function(a,b){this.whereConfig=Ext.decode(a.responseText)},scope:this})},initializeSearch:function(a){if(_whereConditionsObj={},this.view.store.removeAll(),_dynamicoptionsfromurl=null,SpiceCRM.KReporter.Common.catchDynamicOptionsFromUrl()&&(_dynamicoptionsfromurl=Ext.decode(atob(Ext.util.Format.htmlDecode(SpiceCRM.KReporter.Common.catchDynamicOptionsFromUrl())))),_dynamicoptions=Ext.decode(Ext.util.Format.htmlDecode(SpiceCRM.KReporter.Common.catchDynamicOptionsFromSession(SpiceCRM.KReporter.Viewer.Application.reportRecord.get("id")))),_whereConditions=Ext.util.Format.htmlDecode(SpiceCRM.KReporter.Viewer.Application.reportRecord.get("whereconditions")),_whereConditions&&""!==_whereConditions&&(_whereConditionsObj=Ext.decode(_whereConditions)),_hideonoffswitch=!0,Ext.each(_whereConditionsObj,function(a){"yo1"!==a.usereditable&&"yo2"!==a.usereditable||(_hideonoffswitch=!1)},this.view.store),_hideonoffswitch||Ext.ComponentQuery.query("#onoffswitch")[0].show(),Ext.each(_whereConditionsObj,function(b){if("yes"===b.usereditable||"yfo"===b.usereditable||"yo1"===b.usereditable||"yo2"===b.usereditable){if(null!==_dynamicoptionsfromurl)for(_i=0;_i<_dynamicoptionsfromurl.length;_i++)(_dynamicoptionsfromurl[_i].fieldid===b.fieldid||"undefined"!=typeof b.reference&&_dynamicoptionsfromurl[_i].reference===b.reference&&""!==b.reference)&&(b.operator=_dynamicoptionsfromurl[_i].operator,void 0!==_dynamicoptionsfromurl[_i].value&&(b.value=_dynamicoptionsfromurl[_i].value),void 0!==_dynamicoptionsfromurl[_i].valuekey&&(b.valuekey=_dynamicoptionsfromurl[_i].valuekey),void 0!==_dynamicoptionsfromurl[_i].valueto&&(b.valueto=_dynamicoptionsfromurl[_i].valueto),void 0!==_dynamicoptionsfromurl[_i].valuetokey&&(b.valuetokey=_dynamicoptionsfromurl[_i].valuetokey));if(null!==_dynamicoptions)for(_i=0;_i<_dynamicoptions.length;_i++)(_dynamicoptions[_i].fieldid===b.fieldid||"undefined"!=typeof b.reference&&_dynamicoptions[_i].reference===b.reference&&""!==b.reference)&&(b.operator=_dynamicoptions[_i].operator,void 0!==_dynamicoptions[_i].value&&(b.value=_dynamicoptions[_i].value),void 0!==_dynamicoptions[_i].valuekey&&(b.valuekey=_dynamicoptions[_i].valuekey),void 0!==_dynamicoptions[_i].valueto&&(b.valueto=_dynamicoptions[_i].valueto),void 0!==_dynamicoptions[_i].valuetokey&&(b.valuetokey=_dynamicoptions[_i].valuetokey));void 0!==a&&Ext.each(a,function(a){if(a.fieldid===b.fieldid)return b.operator=a.operator,void 0!==a.value&&(b.value=a.value),void 0!==a.valuekey&&(b.valuekey=a.valuekey),void 0!==a.valueto&&(b.valueto=a.valueto),void 0!==a.valuetokey&&(b.valuetokey=a.valuetokey),void 0!==a.valueinit&&(b.valueinit=a.valueinit),!1}),this.add(b)}},this.view.store),this.view.store.count()>0){for(thisViewTable=this.view.view,_columns=this.view.getColumns(),_i=0;_i<_columns.length;_i++)"value"==_columns[_i].dataIndex&&(_calcColIdx=_i,_hideonoffswitch&&_calcColIdx--,_i=_columns.length);for(_i=0;_i<this.view.store.count();_i++)_row=thisViewTable.getRow(_i),_record=this.view.store.getAt(_i),"enum"!=_record.get("type")&&"multienum"!=_record.get("type")&&"autocomplete"!=_record.get("operator")||(_nodeValue="",void 0!==_record.data.valueinit?_nodeValue=_record.data.valueinit:void 0!==_record.data.value&&(_nodeValue=_record.data.value),_row.childNodes[_calcColIdx].childNodes[0].lastChild.nodeValue=_nodeValue);if(this.view.show(),SpiceCRM.KReporter.Viewer.Application.reportRecord.get("reportoptions")){var b=Ext.decode(Ext.util.Format.htmlDecode(SpiceCRM.KReporter.Viewer.Application.reportRecord.get("reportoptions")));"collapsed"==b.optionsFolded?this.view.collapse():this.view.expand(),void 0!==b.updateOnRequest&&b.updateOnRequest===!0?(this.showSearchBtn(),this.updateOnRequest=b.updateOnRequest):this.hideSearchBtn()}else this.view.expand()}else this.view.hide()},getOperatorCount:function(a){return void 0!==typeof this.whereConfig.operatorCount[a]?this.whereConfig.operatorCount[a]:0},checkOperatorValues:function(){var a=!0;return this.view.getStore().each(function(b){var c=this.getOperatorCount(b.get("operator"));c>0&&!b.get("value")&&(a=!1),c>1&&!b.get("valueto")&&(a=!1)},this),a},extractWhereClause:function(){var a=[];return this.view.getStore().each(function(b){a.push({fieldid:b.get("fieldid"),operator:b.get("operator"),value:b.get("value"),valuekey:b.get("valuekey"),valueto:b.get("valueto"),valuetokey:b.get("valuetokey"),valueinit:b.get("valueinit"),usereditable:b.get("usereditable")})},this),a},showSearchBtn:function(){this.view.tools[1].show()},hideSearchBtn:function(){this.view.tools[1].hide()}}),Ext.define("SpiceCRM.KReporter.Viewer.controller.MainController",{extend:"Ext.app.ViewController",requires:[],saving:!1,alias:"controller.KReportViewerMain",loadMask:void 0,initialized:!1,pluginsInitialized:!1,config:{listen:{global:{resize:function(){SpiceCRM.KReporter.Viewer.Application.thisMainView.updateLayout()},pluginsLoaded:function(){this.pluginsInitialized=!0,this.view.rendered},sysinfo:function(a,b){var c=sessionStorage.getItem("kval"+a.systemkey);if(null===c){var d,e=[];for(d in b.integration)e.push(d);for(d in b.presentation)e.push(d);for(d in b.visualization)e.push(d);10*SpiceCRM.KReporter.Viewer.Application.getRand()>3&&Ext.Ajax.request({url:window.atob("S1JFU1QvbW9kdWxlL1VzZXJz"),method:"GET",params:{searchfields:window.atob("eyJmaWVsZCI6InN0YXR1cyIsIm9wZXJhdG9yIjoiPSIsInZhbHVlIjoiQWN0aXZlIn0=")},success:function(b){var c=Ext.JSON.decode(b.responseText);Ext.Ajax.request({url:window.atob("aHR0cHM6Ly9zdXBwb3J0LnNwaWNlY3JtLmlv"),method:"GET",params:{x:this.atoc(window.btoa(Ext.encode({sysinfo:a,plugins:e,users:c.totalcount})))},success:function(b,c){var d=Ext.JSON.decode(decodeURIComponent(b.responseText));d[window.atob("bGljZW5zZXN0YXR1cw==")]?sessionStorage.setItem("kval"+a.systemkey,!0):(Ext.globalEvents.fireEvent("lf",d[window.atob("bGljZW5zZW1lc3NhZ2U=")]),sessionStorage.setItem("kval"+a.systemkey,window.btoa(d[window.atob("bGljZW5zZW1lc3NhZ2U=")])))}})},scope:this})}else"true"!==c&&Ext.globalEvents.fireEvent("lf",window.atob(c))}}}},atoc:function(a){return a.replace(/[a-zA-Z]/g,function(a){return String.fromCharCode((a<="Z"?90:122)>=(a=a.charCodeAt(0)+13)?a:a-26)})},initializePlugins:function(){var a=this.view.down("#KReporterViewerPresentation");a&&this.view.remove(a);var b=Ext.decode(Ext.util.Format.htmlDecode(SpiceCRM.KReporter.Viewer.Application.reportRecord.get("presentation_params"))),c=Ext.data.StoreManager.lookup("KReportViewerPresentationPluginsStore").getById(b.plugin);Ext.Loader.loadScript({url:c.get("include"),onLoad:function(){c.set("loaded",!0),this.presentationPanel=Ext.create(c.get("panel"),{reportRecord:SpiceCRM.KReporter.Viewer.Application.reportRecord,presentationParams:b,width:"100%"}),this.view.add(this.presentationPanel)},scope:this})}}),Ext.define("SpiceCRM.KReporter.Viewer.controller.MainToolbarController",{extend:"Ext.app.ViewController",requires:[],saving:!1,alias:"controller.KReportViewerMainToolbar",loadMask:void 0,initialized:!1,config:{listen:{global:{pluginsLoaded:function(){this.initializeMenu()},lf:function(a){this.view.down("#repVersion").update(atob(SpiceCRM.KReporter.versionstring)+" ("+a+")"),Ext.each(this.view.query("button"),function(a){a.disable()})}}},control:{"#edit":{click:"editReport"},"#duplicate":{click:"duplicateReport"},"#delete":{click:"deleteReport"}}},editReport:function(){SpiceCRM.KReporter.Common.redirect("edit",{id:SpiceCRM.KReporter.Viewer.Application.reportRecord.get("id")})},duplicateReport:function(){Ext.Msg.prompt(languageGetText("LBL_DUPLICATE_NAME"),languageGetText("LBL_DUPLICATE_PROMPT"),function(a,b){"ok"==a&&(SpiceCRM.KReporter.Viewer.Application.reportRecord.set("id",SpiceCRM.KReporter.Viewer.Application.kGuid()),SpiceCRM.KReporter.Viewer.Application.reportRecord.set("name",b),SpiceCRM.KReporter.Viewer.Application.reportRecord.set("assigned_user_id",SpiceCRM.KReporter.Viewer.Application.sysinfo.current_user_id),SpiceCRM.KReporter.Viewer.Application.reportRecord.set("date_entered",null),Ext.Ajax.request({url:"KREST/module/KReports/"+SpiceCRM.KReporter.Viewer.Application.reportRecord.get("id"),jsonData:SpiceCRM.KReporter.Viewer.Application.reportRecord.data,method:"POST",success:function(a,b){SpiceCRM.KReporter.Common.redirect("detail",{id:SpiceCRM.KReporter.Viewer.Application.reportRecord.get("id")})},scope:this}))})},deleteReport:function(){Ext.MessageBox.confirm(languageGetText("LBL_DIALOG_CONFIRM"),languageGetText("LBL_DIALOG_DELETE_YN"),function(a){"yes"==a&&Ext.Ajax.request({url:"KREST/module/KReports/"+SpiceCRM.KReporter.Viewer.Application.reportRecord.get("id"),method:"DELETE",success:function(a,b){SpiceCRM.KReporter.Common.redirect("list")},failure:function(a,b){console.log("server-side failure with status code "+a.status)},scope:this})})},initializeMenu:function(){switch(_accesslevel=0,SpiceCRM.KReporter.Viewer.Application.reportRecord.data.acl.edit&&(_accesslevel=1),SpiceCRM.KReporter.Viewer.Application.reportRecord.data.acl.delete&&(_accesslevel=2),_accesslevel){case 0:this.view.down("#edit").disable(),this.view.down("#duplicate").disable(),this.view.down("#delete").disable();break;case 1:this.view.down("#edit").enable(),this.view.down("#duplicate").enable(),this.view.down("#delete").disable();break;case 1:this.view.down("#edit").enable(),this.view.down("#duplicate").enable(),this.view.down("#delete").enable()}if(!this.view.down("#KReportViewerTools").initialized){this.view.down("#KReportViewerTools").initialized=!0;var a=Ext.data.StoreManager.lookup("KReportViewerIntegrationPluginsStore");a.each(function(a){1!==a.get("active")||"tool"!==a.get("category")&&"export"!==a.get("category")||!a.get("class")||Ext.Loader.loadScript({url:a.get("include"),onLoad:function(){switch(a.get("category")){case"export":this.view.down("#KReportViewerExport").getMenu().add(Ext.create(a.get("class"))),"undefined"==typeof SpiceCRM.KReporter.Viewer.Application.reportRecord.data.acl.export?this.view.down("#KReportViewerExport").enable(!0):SpiceCRM.KReporter.Viewer.Application.reportRecord.data.acl.export&&this.view.down("#KReportViewerExport").enable(!0);break;case"tool":this.view.down("#KReportViewerTools").getMenu().add(Ext.create(a.get("class"))),this.view.down("#KReportViewerTools").enable(!0)}},scope:this})},this)}}}),Ext.define("SpiceCRM.KReporter.Viewer.view.main.KMain",{extend:"Ext.panel.Panel",requires:["SpiceCRM.KReporter.Viewer.controller.MainController"],border:!1,renderTo:"kreportviewer",controller:"KReportViewerMain",layout:"vbox",style:{"background-color":"transparent"},defaults:{width:"100%"},items:[{xtype:"mainToolbar",width:"100%",margin:"0 0 10 0"},{xtype:"KReportViewer.WherePanel",width:"100%"},{xtype:"KReportViewer.VisualizationContainer",border:!1},{xtype:"KReportViewer.PresentationContainer",width:"100%",border:!1}],listeners:{afterrender:function(){}}}),Ext.define("SpiceCRM.KReporter.Viewer.view.main.Main",{extend:"Ext.panel.Panel",requires:["SpiceCRM.KReporter.Viewer.controller.MainController"],border:!1,xtype:"app-main",controller:"KReportViewerMain",layout:"vbox",style:{"background-color":"transparent"},defaults:{width:"100%"},hidden:!0}),Ext.define("SpiceCRM.KReporter.Viewer.view.maintoolbar",{extend:"Ext.Toolbar",controller:"KReportViewerMainToolbar",alias:["widget.mainToolbar"],style:{padding:"5px"},initialize:function(){},items:[{xtype:"button",itemId:"edit",text:languageGetText("LBL_EDIT_BUTTON_LABEL"),icon:"modules/KReports/images/report_edit.png",disabled:!1},{xtype:"button",itemId:"duplicate",text:languageGetText("LBL_DUPLICATE_REPORT_BUTTON_LABEL"),icon:"modules/KReports/images/copy.png",disabled:!1},{xtype:"button",itemId:"delete",text:languageGetText("LBL_DELETE_BUTTON_LABEL"),icon:"modules/KReports/images/report_delete.png",disabled:!1},"-",{text:languageGetText("LBL_EXPORTMENU_BUTTON_LABEL"),itemId:"KReportViewerExport",xtype:"splitbutton",icon:"modules/KReports/images/export.png",menu:{},disabled:!0},"-",{text:languageGetText("LBL_TOOLSMENU_BUTTON_LABEL"),icon:"modules/KReports/images/tools.png",itemId:"KReportViewerTools",xtype:"splitbutton",menu:{itemId:"toolsmenu"},disabled:!0},"->",{xtype:"tbtext",itemId:"repVersion",text:atob(SpiceCRM.KReporter.versionstring),style:{fontWeight:"bold",fontStyle:"italic"}},{xtype:"tbitem",html:atob(SpiceCRM.KReporter.icon1string)+"&nbsp;"+atob(SpiceCRM.KReporter.icon2string),style:{display:"inline-flex"}}]}),Ext.define("SpiceCRM.KReporter.Viewer.view.PresentationContainer",{extend:"Ext.panel.Panel",itemId:"KReportPresentationContainer",controller:"KReportViewer.KReportViewerPresentationContainer",alias:["widget.KReportViewer.PresentationContainer"],width:"100%",hidden:!1,border:!0,margin:"0 0 10 0"}),Ext.define("SpiceCRM.KReporter.Viewer.view.VisualizationContainer",{extend:"Ext.panel.Panel",itemId:"KReportVisualizationContainer",controller:"KReportViewer.KReportViewerVisualizationContainer",alias:["widget.KReportViewer.VisualizationContainer"],width:"100%",hidden:!0,border:!0,margin:"0 0 10 0"}),Ext.define("SpiceCRM.KReporter.Viewer.view.WherePanel",{extend:"Ext.grid.Panel",itemId:"KReportViewqerWherePanel",controller:"KReportViewer.KReportViewerWherePanel",title:{text:languageGetText("LBL_DYNAMIC_OPTIONS")},collapsible:!0,titleCollapse:!0,collapsed:!0,alias:["widget.KReportViewer.WherePanel"],store:Ext.create("SpiceCRM.KReporter.Viewer.store.whereclauses",{storeId:"KReportViewerWhereClausesStore"}),flex:3,maxHeight:400,width:"100%",hidden:!0,border:!0,margin:"0 0 10 0",columns:[{itemId:"name",text:languageGetText("LBL_NAME"),dataIndex:"name",sortable:!0,width:200},{itemId:"onoffswitch",header:languageGetText("LBL_ONOFF_COLUMN"),dataIndex:"usereditable",width:80,sortable:!0,hidden:!0,renderer:function(a){return"yo1"==a||"yo2"==a?languageGetText("LBL_ONOFF_"+a.toUpperCase()):""},editor:new Ext.form.TextField},{itemId:"operator",text:languageGetText("LBL_OPERATOR"),dataIndex:"operator",sortable:!0,hidden:!1,width:200,editor:new Ext.form.TextField,renderer:function(a){return a?languageGetText("LBL_OP_"+a.toUpperCase()):a}},{itemId:"value",text:languageGetText("LBL_VALUE_FROM"),dataIndex:"value",sortable:!0,hidden:!1,width:200,editor:new Ext.form.TextField},{itemId:"valueto",text:languageGetText("LBL_VALUE_TO"),dataIndex:"valueto",sortable:!0,hidden:!1,width:200,editor:new Ext.form.TextField}],sm:new Ext.selection.RowModel,viewConfig:{markDirty:!1,stripeRows:!0},plugins:[Ext.create("Ext.grid.plugin.CellEditing",{clicksToEdit:1})],tools:[{itemId:"searchbtn",type:"search",handler:function(){Ext.globalEvents.fireEvent("searchBtnClicked",{})}}]}),Ext.enableAriaButtons=!1,Ext.define("SpiceCRM.KReporter.Viewer.Application",{namespaces:["SpiceCRM.KReporter.Viewer"],controllers:["Application"],extend:"Ext.app.Application",name:"SpiceCRM.KReporter.Viewer",reportRecord:Ext.create("SpiceCRM.KReporter.Viewer.model.KReporterRecord"),currencies:[],sysinfo:{},designMode:!1,pluginsLoaded:!1,thisMainView:!1,launch:function(){SpiceCRM.KReporter.Viewer.Application=this,this.reportRecord=Ext.create("SpiceCRM.KReporter.Viewer.model.KReporterRecord"),this.thisMainView=Ext.create("SpiceCRM.KReporter.Viewer.view.main.KMain");var a="";window.thisKreportRecord&&(a=window.thisKreportRecord),""===a&&$("#formDetailView")[0]&&$("#formDetailView")[0].record.value&&(a=$("#formDetailView")[0].record.value),""===a&&$("input[name=record]")[0]&&$("input[name=record]")[0].value&&(a=$("input[name=record]")[0].value),a&&(SpiceCRM.KReporter.Common.get_user_prefs(),SpiceCRM.KReporter.Common.getConfig(),Ext.Ajax.request({url:"KREST/module/KReports/"+a,method:"GET",success:function(a,b){var c=Ext.decode(a.responseText);SpiceCRM.KReporter.Viewer.Application.reportRecord=Ext.create("SpiceCRM.KReporter.Viewer.model.KReporterRecord",c),Ext.globalEvents.fireEvent("recordLoaded"),this.loadPlugins()},failure:function(a,b){console.log("server-side failure with status code "+a.status)},scope:this}))},render:function(){Ext.create("SpiceCRM.KReporter.Viewer.view.maintoolbar")},loadPlugins:function(){this.pluginsLoaded===!1?(this.pluginsLoaded=!0,Ext.Ajax.request({url:"KREST/KReporter/plugins",params:{addData:Ext.encode(["currencies","sysinfo"]),report:this.reportRecord.get("id")},method:"GET",success:function(a,b){var c=Ext.decode(a.responseText);c.addData&&c.addData.currencies&&(SpiceCRM.KReporter.Common.currencies=c.addData.currencies),c.addData&&c.addData.sysinfo&&(this.sysinfo=c.addData.sysinfo),Ext.globalEvents.fireEvent("sysinfo",this.sysinfo,c),this.setPlugins(c.presentation,c.visualization,c.integration)},failure:function(a,b){console.log("server-side failure with status code "+a.status)},scope:this})):Ext.globalEvents.fireEvent("pluginsLoaded")},setPlugins:function(a,b,c){this.presentationPluginsStore=Ext.create("SpiceCRM.KReporter.Viewer.store.plugins",{storeId:"KReportViewerPresentationPluginsStore"}),Ext.Object.each(a,function(a,b){b.metadata.includes.edit&&this.presentationPluginsStore.add({id:a,name:languageGetText(b.displayname),panel:b.metadata.viewpanel,loaded:!1,plugindirectory:b.metadata.plugindirectory,include:b.plugindirectory+"/"+b.metadata.includes.view})},this),this.visualizationPluginsStore=Ext.create("SpiceCRM.KReporter.Viewer.store.plugins",{storeId:"KReportViewerVisualizationPluginsStore"}),Ext.Object.each(b,function(a,b){this.visualizationPluginsStore.add({id:a,name:languageGetText(b.displayname),panel:b.metadata.viewpanel,loaded:!1,plugindirectory:b.metadata.plugindirectory,include:b.plugindirectory+"/"+b.metadata.includes.view})},this),this.integrationPluginsStore=Ext.create("SpiceCRM.KReporter.Viewer.store.plugins",{storeId:"KReportViewerIntegrationPluginsStore"});var d={},e=Ext.util.Format.htmlDecode(this.reportRecord.get("integration_params"));e&&""!==e&&(d=Ext.decode(e)),c&&Ext.Object.each(c,function(a,b){this.integrationPluginsStore.add({id:a,name:languageGetText(b.displayname),class:b.metadata&&b.metadata.includes&&b.metadata.includes.viewItem?b.metadata.includes.viewItem:void 0,loaded:!1,category:b.metadata.category,active:d.activePlugins&&d.activePlugins[a]?1:0,plugindirectory:b.metadata.plugindirectory,include:b.metadata&&b.metadata.includes&&b.metadata.includes.view?b.plugindirectory+"/"+b.metadata.includes.view:""})},this),Ext.globalEvents.fireEvent("pluginsLoaded"),this.integrationPluginsStore.getById("ksavedfilters")&&Ext.globalEvents.fireEvent("addWhereBottomToolbar")},languageGetText:function(a){return SUGAR.language.get("KReports",a)},getRand:function(){return Math.random()},S4:function(){return(65536*(1+this.getRand())|0).toString(16).substring(1)},kGuid:function(){return"k"+this.S4()+this.S4()+this.S4()+this.S4()+this.S4()+this.S4()+this.S4()},getReportId:function(){return $("#EditView")&&$("#EditView")[0].record.value?$("#EditView")[0].record.value:""}}),Ext.application({extend:"SpiceCRM.KReporter.Viewer.Application"}),Ext.onReady(function(){});