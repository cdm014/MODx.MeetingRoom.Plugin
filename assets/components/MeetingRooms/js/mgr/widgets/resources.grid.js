MeetingRooms.grid.Resources = function(config) {
	config = config || {};
	Ext.applyIf(config, {
		id: 'MeetingRooms-grid-Resources'
		,url: MeetingRooms.config.connectorUrl
		,baseParams: { action: 'mgr/mrResources/getList'}
		,fields: ['id', 'name', 'address', 'menu']
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
			xtype: 'textfield'
			,id: 'MeetingRooms-search-filter'
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
		},{
			text: _('MeetingRooms.resource_create')
			,handler: {xtype: 'MeetingRooms-window-resource-create',blankValues: true}
		}]
	});
	MeetingRooms.grid.Resources.superclass.constructor.call(this,config);
};
Ext.extend(MeetingRooms.grid.Resources, MODx.grid.Grid);
Ext.reg('MeetingRooms-grid-Resources',MeetingRooms.grid.Resources);
			