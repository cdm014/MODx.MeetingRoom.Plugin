//add a PastRequests object as a member to MeetingRooms.grid
MeetingRooms.grid.PastRequests = function(config) {
	//if we didn't pass in any settings we'll start with an empty set
	config = config || {};
	//use settings we define here or pull from config
	Ext.applyIf(config, {
		id: 'MeetingRooms-grid-PastRequests'
		,url: MeetingRooms.config.connectorUrl
		,baseParams: {
			action: 'mgr/mrRequests/getlist'
			,beforedate: new Date()
		}
		,fields: ['id','name','libraryCard','email','phone','group','meetingType','start','end','requestNumber','room','room_name','status','notes','adults','children','teens']
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
			header: 'adults'
			,dataIndex: 'adults'
			,sortable: false
			,width: 30
		},{
			header: 'teens'
			,dataIndex: 'teens'
			,sortable: false
			,width: 30
		},{
			header: 'children'
			,dataIndex: 'children'
			,sortable: false
			,width: 30
		}]
		,tbar: [{
			xtype: 'label'
			,text: 'Filter by Room: '
			,forId: 'pastroom'
		},{
			xtype: 'MeetingRooms-combo-mrRooms'
			,fieldLabel: _('MeetingRooms.name')
			,hideLabel: false
			,listeners: {
				'select': {fn: this.roomChange, scope:this}
			}
			,id: 'pastroom'
		},{
			xtype: 'label'
			,text: 'No Later Than: '
		},{
			xtype: 'datefield'
			,id: 'beforedate'
			,name: 'beforedate'
			,fieldLabel: _('MeetingRooms.requests_start')
			,hideLabel: false
			,value: new Date()
			,listeners: {
				'select': {fn: this.dateChange, scope:this}
			}
		},{
			text: 'Clear Search'
			,listeners: {
				'click': {fn: this.clearSearch, scope:this}
			}
		}]
	});
	MeetingRooms.grid.PastRequests.superclass.constructor.call(this,config);
};

//make the PastRequests object an extension of MODx.grid.Grid, and add the following functions too
Ext.extend(MeetingRooms.grid.PastRequests, MODx.grid.Grid,{
	
	dateChange: function (df,nv,ov) {
		var s = this.getStore();
		s.baseParams.beforedate = df.getValue().format('Y-m-d');
		this.getBottomToolbar().changePage(1);
		this.refresh();
	}
	,roomChange: function(cmb, nv, ov) {
		var s = this.getStore();
		s.baseParams.room = cmb.getValue();
		this.getBottomToolbar().changePage(1);
		this.refresh();
	}
	,clearSearch: function() {
		var s = this.getStore();
		delete s.baseParams.room;
		s.baseParams.beforedate = new Date();
		this.getBottomToolbar().changePage(1);
		Ext.getCmp('beforedate').setValue(new Date());
		this.refresh();
	}
	,getMenu: function() {
		var m = [{
			text: _('MeetingRooms.requests_update')
			,handler: this.updateRequest
		},'-',{
			text: _('MeetingRooms.requests_remove')
			,handler: this.removeRequest
		}]
		this.addContextMenuItem(m);
		return true;
	}
	
	
	//still need to add updateRequest and removeRequest handler
	,updateRequest: function (btn, e) {
		if (!this.updatePastRequestWindow) {
			this.updatePastRequestWindow = MODx.load({
				xtype: 'MeetingRooms-window-mrRequests-updatePast'
				,record: this.menu.record
				,listeners: {
					'success': {fn: this.refresh, scope:this}
				}
			});
		} else {
			this.updatePastRequestWindow.setValues(this.menu.record);
			this.updatePastRequestWindow.config.record = this.menu.record;
		}
		this.updatePastRequestWindow.show(e.target);
	}
});


//Actually Register the class
Ext.reg('MeetingRooms-grid-PastRequests', MeetingRooms.grid.PastRequests);
		