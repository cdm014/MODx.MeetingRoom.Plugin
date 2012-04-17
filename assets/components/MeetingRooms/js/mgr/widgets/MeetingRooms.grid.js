MeetingRooms.grid.MeetingRooms = function(config) {
	config = config || {};
	Ext.applyIf(config, {
		id: 'MeetingRooms-grid-MeetingRooms'
		,url: MeetingRooms.config.connectorUrl
		,baseParams: { action: 'mgr/mrRooms/getList'}
		,fields: ['id', 'name','address','menu']
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
			,dataIndex: 'name'
			,sortable: true
			,width: 100
			,editor: { xtype: 'textfield' }
		},{
			header: _('MeetingRooms.address')
			,dataIndex: 'address'
			,sortable: false
			,width: 350
			,editor: { xtype: 'textarea' }
		}]
		,tbar:[{
			xtype: 'textfield'
			,id: 'MeetingRooms-search-filter'
			,emptyText: _('MeetingRooms.search...')
			,listeners: {
				'change': {fn:this.search,scope:this}
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
				},scope:this}
			}	
		}
		,{
			text: _('MeetingRooms.room_create')
			,handler: {xtype: 'MeetingRooms-window-room-create' ,blankValues: true}
		}]
	});
	MeetingRooms.grid.MeetingRooms.superclass.constructor.call(this,config);
};
Ext.extend(MeetingRooms.grid.MeetingRooms, MODx.grid.Grid,{
	search: function(tf,nv,ov) {
		var s = this.getStore();
		s.baseParams.query = tf.getValue();
		this.getBottomToolbar().changePage(1);
		this.refresh();
	}
	,getMenu: function() {
		var m = [{
			text: _('MeetingRooms.room_update')
			,handler: this.updateRoom
		},'-',{
			text: _('MeetingRooms.room_remove')
			,handler: this.removeRoom
		}]
		this.addContextMenuItem(m);
		return true;
	}
	,updateRoom: function(btn,e) {
		if (!this.updateRoomWindow) {
			this.updateRoomWindow = MODx.load({
				xtype: 'MeetingRooms-window-mrRoom-update'
				,record: this.menu.record
				,listeners: {
					'success': {fn:this.refresh,scope:this}
				}
			});
		} else {
			this.updateRoomWindow.setValues(this.menu.record);
		}
		this.updateRoomWindow.show(e.target);
	}
	,removeRoom: function() {
		MODx.msg.confirm({
			title: _('MeetingRooms.room_remove')
			,text: _('MeetingRooms.room_remove_confirm')
			,url: this.config.url
			,params: {
				action: 'mgr/mrRooms/remove'
				,id: this.menu.record.id
			}
			,listeners: {
				'success': {fn:this.refresh,scope:this}
			}
		});
	}
});
Ext.reg('Meetingrooms-grid-MeetingRooms',MeetingRooms.grid.MeetingRooms);
//*
MeetingRooms.window.UpdateRoom = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('MeetingRooms.room_update')
        ,url: MeetingRooms.config.connectorUrl
        ,baseParams: {
            action: 'mgr/mrRooms/update'
        }
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('MeetingRooms.name')
            ,name: 'name'
            ,width: 300
        },{
            xtype: 'htmleditor'
			,enableFont: false
			,enableColors: false
			,enableAlignments: false
			,enableFontSize: false
			,enableLinks: false
			
            ,fieldLabel: _('MeetingRooms.address')
            ,name: 'address'
            ,width: 300
        },{

			xtype: 'htmleditor'
			,fieldLabel: _('MeetingRooms.room_description')
			,name: 'description'
			,width: 300
			,enableFont: false
			,enableColors: false
			,enableAlignments: false
			,enableFontSize: false
			,enableLinks: false
		}]
		

    });
    MeetingRooms.window.UpdateRoom.superclass.constructor.call(this,config);
};
Ext.extend(MeetingRooms.window.UpdateRoom,MODx.Window);
Ext.reg('MeetingRooms-window-mrRoom-update',MeetingRooms.window.UpdateRoom);
//*/
MeetingRooms.window.CreateRoom = function(config) {
	config = config || {};
	Ext.applyIf(config,{
		title: _('MeetingRooms.room_create')
		,url: MeetingRooms.config.connectorUrl
		,baseParams: {
			action: 'mgr/mrRooms/create'
		}
		,fields: [{
			xtype: 'textfield'
			,fieldLabel: _('MeetingRooms.name')
			,name: 'name'
			,width: 300
		},{
			xtype: 'textarea'
			,fieldLabel: _('MeetingRooms.address')
			,name: 'address'
			,width: 300
		},{
			xtype: 'textarea'
			,fieldLabel: _('MeetingRooms.room_description')
			,name: 'description'
			,width: 300
		}]
	});
	MeetingRooms.window.CreateRoom.superclass.constructor.call(this,config);
};
Ext.extend(MeetingRooms.window.CreateRoom,MODx.Window);
Ext.reg('MeetingRooms-window-room-create',MeetingRooms.window.CreateRoom);