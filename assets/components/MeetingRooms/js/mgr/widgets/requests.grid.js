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
		,fields: ['id','name','libraryCard','email','phone','group','meetingType','start','end','requestNumber','room','room_name']
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
			,handler: { xtype: 'MeetingRooms-window-request-create',blankValues: true}
		},'->',{
			xtype: 'MeetingRooms-combo-mrRooms'
			,fieldLabel: _('MeetingRooms.name')
			,hideLabel: false
			,listeners: {
				'select': {fn: this.roomChange,scope:this}
			}
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
		,{
			text: _('MeetingRooms.requests_updateGroup')
			,handler: this.updateRequestGroup
		},'-',{
			text: _('MeetingRooms.requests_remove')
			,handler: this.removeRequest
		}
		,{
			text: _('MeetingRooms.requests_removeGroup')
			,handler: this.removeRequestGroup
		}]
		this.addContextMenuItem(m);
		return true;
	}
	
});
Ext.reg('MeetingRooms-grid-Requests', MeetingRooms.grid.Requests);