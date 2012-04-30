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
		,width: 900
		,id: 'CalendarWrapper'
		,tbar: [{
			text: _('MeetingRooms.requests_create')
			,listeners: {
				'click': {fn: this.addRequest, scope: this}
			}
			
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
			,id: 'Calendar-Room-Select'
			,listeners: {
				'select': {fn: this.getRequests, scope: this}
				
			}
		},{
			xtype: 'textfield'
			,id: 'Calendar-search-filter'
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
		
		
	});
	MeetingRooms.panel.Calendar.superclass.constructor.call(this,config);
	this.on("render",function () {
		this.getRequests();
		return true;
	});
}
Ext.extend(MeetingRooms.panel.Calendar, MODx.Panel, {	
	addRequest: function() {
		if (!this.createRequestWindow) {
			this.createRequestWindow = MODx.load({
				xtype: 'MeetingRooms-window-request-create' 
				,blankValues: false
				,listeners: {
					'success': {fn: MeetingRooms.panel.Calendar.getRequests, scope:this}
				}
			});
		}
		this.createRequestWindow.show(event.target);
		return true;
	}
	,clearSearch: function() {
		Ext.getCmp('calendar-date').setValue(new Date().format('m/01/Y'));
		Ext.getCmp('Calendar-Room-Select').setValue('');
		Ext.getCmp('Calendar-search-filter').setValue('');
		this.getRequests();
		return true;
	}
	,getRequests: function () {
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
			,width: 900
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
				ctCls: 'calendar-day'
				
				
			}));
			daycount++;
		
		}
		
		
		
		Ext.getCmp('CalendarWrapper').add(cpanel);
		Ext.getCmp('CalendarWrapper').doLayout();
		//finish getting search criteria
		var room = Ext.getCmp('Calendar-Room-Select').getValue();
		var search = Ext.getCmp('Calendar-search-filter').getValue();
		setTimeout(
		function() {
		
		
			Ext.Ajax.request({
				url: MeetingRooms.config.connectorUrl
				,params: {
					action: 'mgr/mrRequests/getlist'
					,room: room
					,search: search
					,date: startOfMonth.format('Y-m-d')
					,HTTP_MODAUTH: MODx.siteId
				}
				,headers: {
					'modAuth': MODx.siteId
				}
				,success: function (result, request) {
					//alert("Ajax Succeeded");
					eval ("requests2 = "+result.responseText.replace("(",'').replace(")",''));
					requests = requests2;
					if (requests.total == "0") {
						alert("No Requests for this room this month");
					}
					delete MeetingRooms.calendarRecords;
					MeetingRooms.calendarRecords = new Array();
					var i = 0;
					while (i < requests.total) {
					
						requestData = requests.results[i];
						//requestStartDate = new Date(requestData.start.split(" ")[0]);
						requestStartDateString = requestData.start.split(" ")[0];
						requestStartDateYear = requestStartDateString.split("-")[0];
						requestStartDateMonth = requestStartDateString.split("-")[1];
						requestStartDateDate = requestStartDateString.split("-")[2];
						requestStartDate = new Date();
						requestStartDate.setMonth(requestStartDateMonth - 1);
						requestStartDate.setFullYear(requestStartDateYear);
						requestStartDate.setDate(requestStartDateDate);
						requestStartTimeString = requestData.start.split(" ")[1];
						
						requestEnd = new Date(requestData.end);
						id = requestStartDate.format('Y-m-d');
						$day = Ext.getCmp(id);
						mystring = requestData.start.split(" ")[1]+" - "+requestData.room_name;
						var tempPanel = {
							xtype: 'button',
							text: mystring,
							id: "request-"+requestData.id,
							scale: 'large',
							height: 32,
							handler: function(btn, event) {
								var myId = this.getId();
								var requestId = myId.split("-")[1];
								var record = MeetingRooms.calendarRecords[requestId];
								if(!MeetingRooms.panel.Calendar.updateRequestWindow) {
									MeetingRooms.panel.Calendar.updateRequestWindow = MODx.load({
										xtype: 'MeetingRooms-window-mrRequests-update'
										
										,record: record
										,listeners: {
											'success': {fn: MeetingRooms.panel.Calendar.getRequests, scope:this}
										}
									});
								} else {
									MeetingRooms.panel.Calendar.updateRequestWindow.setValues(record);
									MeetingRooms.panel.Calendar.updateRequestWindow.config.record = record;
								}
								MeetingRooms.panel.Calendar.updateRequestWindow.show(event.target);
							}
							
							
						};
						
						
						$day.add(tempPanel);
						$day.doLayout();
						MeetingRooms.calendarRecords[requestData.id] = requestData;
						i++;
						
					}
					
				}
				,failure: function (result, request) {
					alert("Cannot access request data. Please contact Webmaster.");
				}
			});
		},0000);
		
	}
});

Ext.reg('MeetingRooms-panel-calendar', MeetingRooms.panel.Calendar);
