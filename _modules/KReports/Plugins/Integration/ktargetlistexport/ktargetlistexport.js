var C=new Ext.LoadMask(Ext.getBody(),{msg:"creating TargetList ... "});var ktargetlistexport=function(){Ext.Msg.prompt(bi('LBL_TARGETLIST_NAME'),bi('LBL_TARGETLIST_PROMPT'),function(btn,text){if(btn=='ok'){C.show();Ext.Ajax.request({url:'index.php?module=KReports&to_pdf=true&action=pluginaction&plugin=ktargetlistexport&pluginaction=export_to_targetlist',success:function(){C.hide();},failure:function(){C.hide();},params:{targetlist_name:text,record:document.getElementById('recordid').value,whereConditions:K.kreports.DetailView.ae()}});}})}; 