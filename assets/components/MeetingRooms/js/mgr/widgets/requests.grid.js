//possibly a good place to put some cookie reading code to prepopulate values
//then I could add the values to the baseparams in the datasource

MeetingRooms.grid.Requests = function(config) {
	config = config ||{};
	Ext.applyIf(config, {
		id: 'MeetingRooms-grid-Requests'
		,url: MeetingRooms.config.connectorUrl
		,baseParams: { 
			action: 'mgr/mrRequests/getlist' 
			,date: new Date()
		}
		,fields: ['id','name','libraryCard','email','phone','group','meetingType','start','end','requestNumber','room','room_name','status']
		,paging: true
		,remoteSort: true
		,anchor: '97%'
		,autoExpandColumn: 'name'
		,columns: [{
			header: _('id')
			,dataIndex: 'id'
			,sortable: true
			,width: 20
		},{
			header: 'status'
			,dataIndex: 'status'
			,sortable: true
			,width: 50
		},{
			header: _('MeetingRooms.requests_requestNumber')
			,data_index: 'requestNumber'
			,sortable: true
			,width: 60
			,renderer: function (value, metaData, record, rowIndex,colIndex, store) {
				return record.data.requestNumber;
			}
		},{
			header: _('MeetingRooms.name')
			,dataIndex: 'room_name'
			,sortable: true
			,width: 100
		},{
			header: _('MeetingRooms.request_start')
			,dataIndex: 'start'
			,sortable: true
			,width: 100
		},{
			header: _('MeetingRooms.request_name')
			,dataIndex: 'name'
			,sortable: false
			,width: 100
		},{
			header: _('MeetingRooms.request_phone')
			,dataIndex: 'phone'
			,sortable: false
			,width: 100
		},{
			header: _('MeetingRooms.request_email')
			,dataIndex: 'email'
			,sortable: false
			,width: 100
		}]
		,tbar: [{
			text: _('MeetingRooms.requests_create')
			//blankValues is false so that previous data is recomended
			//since I can't work out how to let them select multiple dates this
			//is the best compromise
			,handler: { xtype: 'MeetingRooms-window-request-create',blankValues: false}
		},'->',{
			xtype: 'label'
			,text: 'Filter by Room: '
			,forId: 'room'
		},{
			xtype: 'MeetingRooms-combo-mrRooms'
			,fieldLabel: _('MeetingRooms.name')
			,hideLabel: false
			,listeners: {
				'select': {fn: this.roomChange,scope:this}
			}
		},{
			xtype: 'label'
			,text: 'Filter by Date: '
			
		},{
			xtype: 'datefield'
			,id: 'date'
			,name: 'date'
			,fieldLabel: 'MeetingRooms.requests_start'
			,hideLabel: false
			,value: new Date()
			,listeners: {
				'select': {fn: this.dateChange,scope:this}
			}
			
		},{
			xtype: 'textfield'
			,id: 'Requests-search-filter'
			,emptyText: _('MeetingRooms.search...')
			,listeners: {
				'change': {fn: this.search, scope:this}
				,'render': {fn: function(cmp) {
					new Ext.KeyMap(cmp.getEl(), {
						key: Ext.EventObject.ENTER
						,fn: function() {
							this.fireEvent('change',this);
							this.blur();
							return true;
						}
						,scope: cmp
					});
				}, scope:this}
			}			
		},{
			text: 'Clear Search'
			,listeners: {
				'click': {fn: this.clearSearch, scope:this}
			}
		
		}]
	});
	MeetingRooms.grid.Requests.superclass.constructor.call(this,config);
};
Ext.extend(MeetingRooms.grid.Requests, MODx.grid.Grid,{
	dateChange: function (df,nv,ov) {
		var s = this.getStore();
		s.baseParams.date = df.getValue().format('Y-m-d');
		this.getBottomToolbar().changePage(1);
		this.refresh();
	}
	,roomChange: function (cmb, nv, ov) {
		var s = this.getStore();
		s.baseParams.room = cmb.getValue();
		this.getBottomToolbar().changePage(1);
		this.refresh();
	}
	,search: function (tf,nv,ov) {
		var s = this.getStore();
		s.baseParams.query = tf.getValue();
		this.getBottomToolbar().changePage(1);
		this.refresh();
	}
	,clearSearch: function () {
		var s = this.getStore();
		delete s.baseParams.query;
		delete s.baseParams.room;
		s.baseParams.date = new Date();
		this.getBottomToolbar().changePage(1);
		Ext.getCmp('date').setValue(new Date());
		Ext.getCmp('Requests-search-filter').setValue('');
		this.refresh();
	}
	,getMenu: function() {
		var m = [{
			text: _('MeetingRooms.requests_update')
			,handler: this.updateRequest
		}
		,'-',{
			text: _('MeetingRooms.requests_remove')
			,handler: this.removeRequest
		}
		]
		this.addContextMenuItem(m);
		return true;
	}
	,updateRequest: function(btn,e) {
		
		if(!this.updateRequestWindow) {
			this.updateRequestWindow = MODx.load({
				xtype: 'MeetingRooms-window-mrRequests-update'

				,record: this.menu.record
				,listeners: {
					'success': {fn:this.refresh,scope:this}
				}
			});
		} else {
			this.updateRequestWindow.setValues(this.menu.record);
			this.updateRequestWindow.config.record = this.menu.record;
		}
		this.updateRequestWindow.show(e.target);
	}
	,removeRequest: function() {
		MODx.msg.confirm({
			title: _('MeetingRooms.request_remove')
			,text: _('MeetingRooms.request_remove_confirm')
			,url: this.config.url
			,params: {
				action: 'mgr/mrRequests/remove'
				,id: this.menu.record.id
			}
			,listeners: {
				'success': {fn: this.refresh, scope: this}
			}
		});
	}
	
});
Ext.reg('MeetingRooms-grid-Requests', MeetingRooms.grid.Requests);

MeetingRooms.window.UpdateRequest = function(config) {
	config = config || {};
	this.config = config;
	textvar = '<pre>'+this.config+'</pre>';
	Ext.applyIf(config,{
		title: _('MeetingRooms.request_update')
		,id: 'UpdateRequestWindow'
		,text: textvar
		,url: MeetingRooms.config.connectorUrl
		,baseParams: {
			action: 'mgr/mrRequests/update'
		}
		,fields: [{
			xtype: 'hidden'
			,id: 'requestId'
			,name: 'id'
		},{
			xtype: 'textfield'
			,name: 'name'
			,fieldLabel: _('MeetingRooms.request_name')
			,width: 300
		},{
			xtype: 'textfield'
			,name: 'libraryCard'
			,fieldLabel: _('MeetingRooms.requester_id')
			,width: 300
		},{
			xtype: 'textfield'
			,name: 'email'
			,fieldLabel: _('MeetingRooms.request_email')
			,width: 100
		},{
			xtype: 'textfield'
			,name: 'phone'
			,fieldLabel: _('MeetingRooms.request_phone')
			,width: 100
		},{
			xtype: 'textfield'
			,name: 'group'
			,fieldLabel: _('MeetingRooms.request_group')
			,width: 300
		},{
			xtype: 'textfield'
			,name: 'meetingType'
			,fieldLabel: _('MeetingRooms.request_meeting_type')
			,width: 300
		},{
			xtype: 'datefield'
			,name: 'startDate'
			,fieldLabel: _('MeetingRooms.request_start_date')
			,value: this.config.record.start.split(" ",1)[0]
			,format: 'Y-m-d'
		},{
			xtype: 'timefield'
			,name: 'startTime'
			,fieldLabel: _('MeetingRooms.request_start_time')
			,value: this.config.record.start.split(" ")[1].split(":")[0]+":"+this.config.record.start.split(" ")[1].split(":")[1]
		},{
			xtype: 'timefield'
			,name: 'endTime'
			,fieldLabel: _('MeetingRooms.request_end_time')
			,value:this.config.record.end.split(" ")[1].split(":")[0]+":"+this.config.record.end.split(" ")[1].split(":")[1]
		},{
			xtype: 'hidden'
			,name: 'requestNumber'
		},{
			xtype: 'MeetingRooms-combo-mrRooms'
			,id: this.getId()+'-combo-mrRooms'
			,listeners: {
				'select': {fn: this.roomChange,scope:this}
			}
			
		},{
			xtype: 'meetingrooms-combo-requeststatus'
			,value: this.config.record.status
		},{
			xtype: 'fieldset'
			,id: 'update-requestedresources'
			,items: [{
				text: 'Show Resources'
				,xtype: 'button'
				,listeners: {
					'click': {fn: this.pullResources, scope: this}
				}
			}]
		}]
	});
	MeetingRooms.window.UpdateRequest.superclass.constructor.call(this,config);
	this.on("beforeshow", function () { 
		//*
		//update time, date, and room fields
		
		var starttime = this.config.record.start.split(" ")[1].split(":")[0]+":"+this.config.record.start.split(" ")[1].split(":")[1];
		var endtime = this.config.record.end.split(" ")[1].split(":")[0]+":"+this.config.record.end.split(" ")[1].split(":")[1];
		this.findByType('timefield')[0].setValue(starttime).update();
		this.findByType('timefield')[1].setValue(endtime);
		//*/
		var startdateString = this.config.record.start.split(" ")[0];
		this.findByType('datefield')[0].setValue(startdateString);
		return true; 
	});
	
};
Ext.extend(MeetingRooms.window.UpdateRequest, MODx.Window,{
	pullResources: function () {
	// get rid of old resources
	//*
		if(Ext.getCmp('requestedresources2')) {
			Ext.getCmp('requestedresources2').destroy();
		}
	//*/
	// add new container for resources
		//*
		var fset = new Ext.form.FieldSet({
			id: 'requestedresources2'
			,renderTo: 'update-requestedresources'
		});
	
		//*/
		//alert('before ajax');
	// add fields to new container
		var room = Ext.getCmp('update-request-room-combo').getValue();
		Ext.Ajax.request({
			url: MeetingRooms.config.connectorUrl
			,params: {
				action: 'mgr/mrRequestedResources/getlist'
				,room: room
				,HTTP_MODAUTH: MODx.siteId
				,id: Ext.getCmp('requestId').getValue()
			}
			,headers: {
				'modAuth': MODx.siteId
			}
			,success: function( result, request) {
				eval("resources2 = "+result.responseText.replace("(",'').replace(")",''));
				resources = resources2;
				fields = new Array();
				for (resource in resources.results) {
					if (resources.results[resource].max_amount != undefined) {
						field = new Object();
						field.fieldLabel = resources.results[resource].name;
						field.name = 'rresource_'+resources.results[resource].id;
						field.id = 'rresource_'+resources.results[resource].id;
						if (resources.results[resource].max_amount < 2) {
							
							field.xtype= 'checkbox';
							field.inputValue = 1;
							if (resources.results[resource].amount > 0) {
								field.checked = true;
							}
						} else {
							field.fieldLabel = resources.results[resource].name + ' (Maximum: '+resources.results[resource].max_amount +')';
							field.xtype = 'textfield';
						}
						field.value = resources.results[resource].amount;
						//field.renderTo = 'requestedresources2';
						/*
						Ext.getCmp('requestedresources2').add({
							xtype: 'label'
							,text: resources.results[resource].name
							,forId: 'rresource_'+resources.results[resource].id
						});
						//*/
						Ext.getCmp('requestedresources2').add(field);
						Ext.getCmp('requestedresources2').doLayout();
					}
				}
			}
			,failure: function( result, request) {
				alert('ajax failed');
			}
			
		});
		//alert('after ajax');
		
		
		
	}
	,roomChange: function() {
		this.pullResources();
	}
});
Ext.reg('MeetingRooms-window-mrRequests-update', MeetingRooms.window.UpdateRequest);
/* 
	window to put in a new request
	many of the fields call this.clearGroup because if this field is changing
	then the requester is a new person and a new groupID should be generated
*/
MeetingRooms.window.CreateRequest = function (config) {
	config = config || {};
	this.config = config;
	Ext.applyIf(config,{
		title: _('MeetingRooms.request_create')
		,url: MeetingRooms.config.connectorUrl
		,baseParams: {
			action: 'mgr/mrRequests/create'
		}
		,fields: [{
			xtype: 'textfield'
			,name: 'name'
			,id: 'requesterName'
			,fieldLabel: _('MeetingRooms.request_name')
			,width: 300
			,listeners: { 
				'change': {fn: this.clearGroup, scope: this}
			}
		},{
			xtype: 'textfield'
			,name: 'libraryCard'
			,fieldLabel: _('MeetingRooms.requester_id')
			,width: 300
			,listeners: { 
				'change': {fn: this.clearGroup, scope: this}
			}
		},{
			xtype: 'textfield'
			,name: 'email'
			,fieldLabel: _('MeetingRooms.request_email')
			,width: 100
			,listeners: { 
				'change': {fn: this.clearGroup, scope: this}
			}
		},{
			xtype: 'textfield'
			,name: 'phone'
			,fieldLabel: _('MeetingRooms.request_phone')
			,width: 100
			,listeners: { 
				'change': {fn: this.clearGroup, scope: this}
			}
		},{
			xtype: 'textfield'
			,name: 'group'
			,id: 'requesterGroup'
			,fieldLabel: _('MeetingRooms.request_group')
			,width: 300
			,listeners: { 
				'change': {fn: this.clearGroup, scope: this}
			}
		},{
			xtype: 'textfield'
			,name: 'meetingType'
			,fieldLabel: _('MeetingRooms.request_meeting_type')
			,width: 300
			,listeners: { 
				'change': {fn: this.clearGroup, scope: this}
			}
		},{
			xtype: 'datefield'
			,name: 'startDate'
			,fieldLabel: _('MeetingRooms.request_start_date')
			
			,format: 'Y-m-d'
		},{
			xtype: 'timefield'
			,name: 'startTime'
			,fieldLabel: _('MeetingRooms.request_start_time')
			
		},{
			xtype: 'timefield'
			,name: 'endTime'
			,fieldLabel: _('MeetingRooms.request_end_time')
			
		},{
			xtype: 'textfield'
			,name: 'requestNumber'
			,id: 'requestNumber'
			,width: 250
			,fieldLabel: _('MeetingRooms.request_requestNumber')
		},{
			xtype: 'button'
			,text: 'Generate new Request Number'
			,listeners: {
				'click': {fn: this.newRequestNumber, scope: this}
			}
		},{
			xtype: 'MeetingRooms-combo-mrRooms'
			,id: 'Create-request-room-combo'
			,width: 300
			,listeners: {
				'select': {fn: this.roomChange,scope:this}
			}
			
		},{
			xtype: 'fieldset'
			,id: 'create-requestedresources'
			,items: [{
				text: 'Show Resources'
				,xtype: 'button'
				,listeners: {
					'click': {fn: this.pullResources, scope: this}
				}
			}]
		}]
			
	});
	MeetingRooms.window.CreateRequest.superclass.constructor.call(this,config);
	
}

Ext.extend(MeetingRooms.window.CreateRequest, MODx.Window,{
	clearGroup: function () {
		var groupfield = Ext.getCmp('requestNumber').setValue('');
	}
	,newRequestNumber: function () {
		var newIdRequest = Ext.Ajax.request({
			url: MeetingRooms.config.connectorUrl
			,params: {
				action: 'mgr/mrRequests/uniqid'
				,name: Ext.getCmp('requesterName').getValue()
				,group: Ext.getCmp('requesterGroup').getValue()
			}
			,headers: {
				'modAuth': MODx.siteId
			}
			,success: function (result, request) {
				Ext.getCmp('requestNumber').setValue(result.responseText)
			}
			
		});
	}
	,pullResources: function () {
	// get rid of old resources
	//*
		if(Ext.getCmp('requestedresources2')) {
			Ext.getCmp('requestedresources2').destroy();
		}
	//*/
	// add new container for resources
		//*
		var fset = new Ext.form.FieldSet({
			id: 'requestedresources2'
			,renderTo: 'create-requestedresources'
		});
	
		//*/
		//alert('before ajax');
	// add fields to new container
		var room = Ext.getCmp('Create-request-room-combo').getValue();
		Ext.Ajax.request({
			url: MeetingRooms.config.connectorUrl
			,params: {
				action: 'mgr/mrResources/getList'
				,room: room
				,HTTP_MODAUTH: MODx.siteId
			}
			,headers: {
				'modAuth': MODx.siteId
			}
			,success: function( result, request) {
				eval("resources2 = "+result.responseText.replace("(",'').replace(")",''));
				resources = resources2;
				fields = new Array();
				for (resource in resources.results) {
					if (resources.results[resource].max_amount != undefined) {
						field = new Object();
						field.fieldLabel = resources.results[resource].name;
						field.name = 'rresource_'+resources.results[resource].id;
						field.id = 'rresource_'+resources.results[resource].id;
						if (resources.results[resource].max_amount < 2) {
							
							field.xtype= 'checkbox';
							field.inputValue = 1;
						} else {
							field.fieldLabel = resources.results[resource].name + ' (Maximum: '+resources.results[resource].max_amount +')';
							field.xtype = 'textfield';
						}
						//field.renderTo = 'requestedresources2';
						/*
						Ext.getCmp('requestedresources2').add({
							xtype: 'label'
							,text: resources.results[resource].name
							,forId: 'rresource_'+resources.results[resource].id
						});
						//*/
						Ext.getCmp('requestedresources2').add(field);
						Ext.getCmp('requestedresources2').doLayout();
					}
				}
			}
			,failure: function( result, request) {
				alert('ajax failed');
			}
			
		});
		//alert('after ajax');
		
		
		
	}
	,roomChange: function() {
		this.pullResources();
	}
});
Ext.reg('MeetingRooms-window-request-create', MeetingRooms.window.CreateRequest);