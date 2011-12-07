MeetingRooms.grid.Resources = function(config) {
	config = config || {};
	Ext.applyIf(config, {
		id: 'MeetingRooms-grid-Resources'
		,url: MeetingRooms.config.connectorUrl
		,baseParams: { action: 'mgr/mrResources/getList'}
		,fields: ['id', 'name', 'max_amount','room_name', 'menu']
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
			header: _('MeetingRooms.resouce_name')
			,dataIndex: 'name'
			,sortable: true
			,width: 100
		},{
			header: _('MeetingRooms.resource_maxAmount')
			,dataIndex: 'max_amount'
			,sortable: true
			,width: 60
		},{
			header: _('MeetingRooms.name')
			,dataIndex: 'room_name'
			,sortable: true
			,width: 60
		}]
		,tbar: [{
			text: _('MeetingRooms.resource_create')
			,handler: {xtype: 'MeetingRooms-window-resource-create',blankValues: true}
		},{
			xtype: 'textfield'
			,id: 'Resources-search-filter'
			,emptyText: _('MeetingRooms.search...')
			,listeners: {
				'change': {fn: this.search,scope:this}
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
		}]
	});
	MeetingRooms.grid.Resources.superclass.constructor.call(this,config);
};
Ext.extend(MeetingRooms.grid.Resources, MODx.grid.Grid,{
	search: function (tf,nv,ov) {
		var s = this.getStore();
		s.baseParams.query = tf.getValue();
		this.getBottomToolbar().changePage(1);
		this.refresh()
	}
	,getMenu: function() {
		var m = [{
			text: _('MeetingRooms.resource_update')
			,handler: this.updateResource
		},'-',{
			text: _('MeetingRooms.resource_remove')
			,handler: this.removeResource
		}]
		this.addContextMenuItem(m);
		return true;
	}
	,updateResource: function(btn,e) {
		if(!this.updateResourceWindow) {
			this.updateResourceWindow = MODx.load({
				xtype: 'MeetingRooms-window-mrResource-update'
				,record: this.menu.record
				,listeners: {
					'success': {fn:this.refresh,scope:this}
				}
			});
		} else {
			this.updateResourceWindow.setValues(this.menu.record);
		}
		this.updateResourceWindow.show(e.target);
	}
	,removeResource: function() {
		MODx.msg.config({
			title: _('MeetingRooms.resource_remove')
			,text: _('MeetingRooms.resource_remove_confirm')
			,url: this.config.url
			,params: {
				action: 'mgr/mrResources/remove'
				,id: this.menu.record.id
			}
			,listeners: {
				'success': {fn: this.refresh, scope: this}
			}
		});
	}
});
Ext.reg('MeetingRooms-grid-Resources',MeetingRooms.grid.Resources);

MeetingRooms.window.UpdateResource = function(config) {
    config = config || {};
	this.config = config;
    Ext.applyIf(config,{
        title: _('MeetingRooms.resource_update')
        ,url: MeetingRooms.config.connectorUrl
        ,baseParams: {
            action: 'mgr/mrResources/update'
        }
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('MeetingRooms.resource_name')
            ,name: 'name'
            ,width: 300
        },{
            xtype: 'textfield'
            ,fieldLabel: _('MeetingRooms.resource_maxAmount')
            ,name: 'max_amount'
            ,width: 100
        },{
			xtype: 'modx-combo'
			,url: MeetingRooms.config.connectorUrl
			,baseParams: { action: 'mgr/mrRooms/getlist' }
			,resizable: false
			,fieldLabel: _('MeetingRooms.name')
			,name: 'roomName'
			,forceSelection: true
			,hiddenName: 'room'
			,hiddenValue: 1
			,hiddenId: 'room'
			,value: 1
			
		}]
		
    });
    MeetingRooms.window.UpdateResource.superclass.constructor.call(this,config);
};
Ext.extend(MeetingRooms.window.UpdateResource,MODx.Window);
Ext.reg('MeetingRooms-window-mrResource-update',MeetingRooms.window.UpdateResource);
