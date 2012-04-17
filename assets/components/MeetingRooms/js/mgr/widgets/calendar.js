MeetingRooms.panel.Calendar = function(config) {
	//load config data or empty set
	config = config ||{};
	//add config options if they're not present
	Ext.apply(config,{
		border: false
		,baseCls: 'modx-formpanel'
		
		,defaults: {
			bodyStyle: 'padding:20px'
		}
		,width: 700
		,id: 'CalendarWrapper'
		,tbar: [{
			text: _('MeetingRooms.requests_create')
			//blankValues is false so that previous data is recomended
			//since I can't work out how to let them select multiple dates this
			//is the best compromise
			,handler: { xtype: 'MeetingRooms-window-request-create',blankValues: false}
		},'-',{
			xtype: 'datefield'
			,id: 'calendar-date'
			,name: 'date'
			,fieldLabel: _('MeetingRooms.requests_start')
			,hideLabel: false
			,value: new Date()
			,listeners: {
				'select': {fn: this.getRequests, scope: this}
			}
		},{
			xtype: 'MeetingRooms-combo-mrRooms'
			,fieldLabel: _('MeetingRooms.name')
			,hideLabel: false
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
		
		}
		]
		,items: {}
		
	});
	MeetingRooms.panel.Calendar.superclass.constructor.call(this,config);
	this.on("render",function () {
		this.getRequests();
		return true;
	});
}
Ext.extend(MeetingRooms.panel.Calendar, MODx.Panel, {
	getRequests: function () {
		//destroy the old calendar
		if (Ext.getCmp('RequestCalendar')) {
			Ext.getCmp('RequestCalendar').destroy();
		}
		
		var cpanel = new MODx.FormPanel({
			id: 'RequestCalendar'
			,layout: 'table'
			,layoutConfig: {
				columns: 7
			}
			,defaults: {
				bodyStyle: 'padding: 20px; '
			}
			,width: 700
			,items: [
			{
				html: '<h1>Sunday</h1>'
			},{
				html: '<h1>Monday</h1>'
			},{
				html: '<h1>Tuesday</h1>'
			},{
				html: '<h1>Wednesday</h1>'
			},{
				html: '<h1>Thursday</h1>'
			},{
				html: '<h1>Friday</h1>'
			},{
				html: '<h1>Saturday</h1>'
			}]
			
		
		});
		var dayspermonth =  [31,28,31,30,31,30,31,31,30,31,30,31];
		var df = Ext.getCmp('calendar-date');
		var month = df.getValue().format('m') - 1;
		var year = df.getValue().format('Y');
		rule1 = year % 4 == 0 ? true : false;
		rule2 = year % 100 == 0 ? true : false;
		rule3 = year % 400 == 0 ? true : false;
		if ((rule1 && !rule2) || rule3) {
			dayspermonth[1] = 29;
		}
		var days = dayspermonth[month];
		var startOfMonth = new Date (year, month, 1);
		if (startOfMonth.getDay() > 0) {
			cpanel.add({ html: '<p>Previous Month</p>', colspan: startOfMonth.getDay(), border: false});
		}
		var daycount = 1;
		while (daycount <= days) {
			tempday = 0;
			if (daycount < 10) {
				tempday = '0'+daycount;
			} else {
				tempday = daycount;
			}
			cpanel.add(new Ext.Container({
				//must get daycount to show both digits
				id: year+'-'+df.getValue().format('m')+'-'+tempday,
				autoEl: 'div',
				
				items: [
					{
						html: '<p>'+daycount+'</p>'
						,border: false
					}],
				ctCls: 'calendar-day',
				
				
			}));
			daycount++;
		
		}
		
		
		
		Ext.getCmp('CalendarWrapper').add(cpanel);
		Ext.getCmp('CalendarWrapper').doLayout();
		
	}
});

Ext.reg('MeetingRooms-panel-calendar', MeetingRooms.panel.Calendar);