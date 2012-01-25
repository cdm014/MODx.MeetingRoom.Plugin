MeetingRooms.combo.RequestStatus = function (config) {
	config = config ||{};
	Ext.applyIf(config,{
		//no url
		//baseParams
		store: new Ext.data.ArrayStore({
			id: 0
			,fields: ['status', 'display']
			,data: [
				[-1, 'Denied']
				,[0, 'Pending']
				,[1, 'Approved']
			]
		})
		,mode: 'local'
		,displayField: 'display'
		,valueField: 'status'
			
		,resizeable: false
		,fieldLabel: _('MeetingRooms.requests_status')
		,name: 'status'
		,forceSelection: true
	});
	MeetingRooms.combo.RequestStatus.superclass.constructor.call(this,config);
};
Ext.extend(MeetingRooms.combo.RequestStatus, MODx.combo.ComboBox);
Ext.reg('meetingrooms-combo-requeststatus',MeetingRooms.combo.RequestStatus);