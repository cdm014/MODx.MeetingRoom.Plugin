MeetingRooms.combo.mrRooms = function(config) {
	config = config || {}
	Ext.applyIf(config,{
		url: MeetingRooms.config.connectorUrl
		,baseParams: { action: 'mgr/mrRooms/getlist' }
		,resizable: false
		,fieldLabel: _('MeetingRooms.name')
		,name: 'roomName'
		,forceSelection: true
		,hiddenName: 'room'
		,hiddenValue: 1
		,hiddenId: 'room'
		,value: 1
	});
	 MeetingRooms.combo.mrRooms.superclass.constructor.call(this,config);
};
Ext.extend(MeetingRooms.combo.mrRooms,MODx.combo.ComboBox);
Ext.reg('MeetingRooms-combo-mrRooms',MeetingRooms.combo.mrRooms);