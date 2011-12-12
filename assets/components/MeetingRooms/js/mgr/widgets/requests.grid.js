MeetingRooms.grid.Requests = function(config) {
	config = config ||{};
	Ext.applyIf(config, {
		id: 'MeetingRooms-grid-Requests'
		,url: MeetingRooms.config.connectorUrl
		,baseParams: { action: 'mgr/mrRequests/getlist'}
		,fields: ['id','name','libraryCard','email','phone','group','meetingType','start','end','requestNumber','room','room_name']
		,paging: true
		,remoteSort: true
		,anchor: '97%'
		,autoExpandColumn: 'name'
		,columns: [{
			header: _('id')
			,dataIndex: 'id'
			,sortable: true
			,width: 60
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
			header: _('MeetingRooms.request_end')
			,dataIndex: 'end'
			,sortable: false
			,width: 100
		},{
			header: _('MeetingRooms.request_name')
			,dataIndex: 'name'
			,sortable: false
			width: 100
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
	});
	MeetingRooms.grid.Requests.superclass.constructor.class(this,config);
};
Ext.extend(MeetingRooms.grid.Requests, MODx.grid.Grid);
Ext.reg('MeetingRooms-grid-Requests', MeetingRooms.grid.Requests);