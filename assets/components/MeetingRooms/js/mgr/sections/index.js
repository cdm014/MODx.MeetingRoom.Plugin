Ext.onReady(function() {
	//actually load items with xtype MeetingRooms-page-home
	MODx.load({ xtype: 'MeetingRooms-page-home'});
});

MeetingRooms.page.Home = function(config) {
	//config is either the array we passed in or an empty array
	config = config || {};
	//the component with xtype MeetingRooms-panel-home is a component of this
	Ext.applyIf(config,{
		components: [{
			xtype: 'MeetingRooms-panel-home'
			,renderTo: 'MeetingRooms-panel-home-div'
		}]
	});
	MeetingRooms.page.Home.superclass.constructor.call(this,config);
};
//MeetingRooms.page.Home extends MODx.Component
Ext.extend(MeetingRooms.page.Home,MODx.Component);
//register MeetingRooms.page.Home as xtype MeetingRooms-page-home
//this means the function at the top should actually try to load this
Ext.reg('MeetingRooms-page-home',MeetingRooms.page.Home);