MeetingRooms.panel.Home = function(config) {
	//load our config data or an empty set
	config = config || {};
	//declare the components of the panel
	/*
	 * Items
	 * html h2 element that loads MeetingRooms.management from the lexicon
	 * tab panel
	 * 	tab panel items
	 *	tab that loads MeetingRooms.management_desc from the lexicon
	 */
	Ext.apply(config,{
		border: false
		,baseCls: 'modx-formpanel'
		,items: [{
			html: '<h2>'+_('MeetingRooms.management')+'</h2>'
			,border: false
			,cls: 'modx-page-header'
		},{
			xtype: 'modx-tabs'
			,bodyStyle: 'padding: 10px'
			,defaults: {border: false ,autoHeight: true }
			,border: true
			,items: [{
				title: 'Calendar View'
				,items: [{
					xtype: 'MeetingRooms-panel-calendar'
				},{
					html: '<p>Calendar View</p>'
				}]
				
			},{
				title: _('MeetingRooms')
				,defaults: { autoHeight: true }
				,items: [{
					html: '<p>'+_('MeetingRooms.management_desc')+'</p><br />'
					,border: false
				},{
					xtype: 'Meetingrooms-grid-MeetingRooms'
					,preventRender: true
				}]
			},{
				title: _('MeetingRooms.resources')
				,defaults: {autoHeight: true}
				,items: [{
					html: '<p> This is the text on my second tab</p>'
					,border: false
				},{
					xtype: 'MeetingRooms-grid-Resources'
					,preventRender: true
				}]
			},{
				title: _('MeetingRooms.requests')
				,defaults: {autoHeight: true}
				,items: [{
					html: '<p><strong>Instructions:</strong></p>'
					,border: false
				},{
					html: '<p>The clear search button will reset the date field to the current date.</p>'
					,border: false
				},{
					html: '<p>To see past requests, you will need to change the date field.<p>'
					,border: false
				
				},{
					xtype: 'MeetingRooms-grid-Requests'
					,preventRender: true
				}]
			}]
		}]
	});
	MeetingRooms.panel.Home.superclass.constructor.call(this,config);
};
//extend MODx.Panel
Ext.extend(MeetingRooms.panel.Home, MODx.Panel);
//register as xtype MeetingRooms-panel-home
//see assetsUrl/js/mgr/sections/index.js
Ext.reg('MeetingRooms-panel-home', MeetingRooms.panel.Home);