var MeetingRooms = function(config) {
	config = config || {};
	MeetingRooms.superclass.constructor.call(this,config);
};
Ext.extend(MeetingRooms,Ext.Component,{
	page:{},window:{},grid:{},tree:{},panel:{},combo:{},config:{}
});
//register the MeetingRooms class as xtype MeetingRooms;
Ext.reg('MeetingRooms',MeetingRooms);
//declare an instance of the new class;
MeetingRooms = new MeetingRooms();