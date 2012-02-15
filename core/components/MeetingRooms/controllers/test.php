<?php
require_once dirname(dirname(__FILE__)).'/model/MeetingRooms/mrmanager.class.php';

$mrManager = new mrManager($modx);
$modx->setLogLevel(modX::LOG_LEVEL_DEBUG);
$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');
$modx->regClientStartupScript($mrManager->config['jsUrl'].'mgr/MeetingRooms.js');
$script1 = "<script type='text/javascript'>
	MeetingRooms.config.connectorUrl = '/MeetingRooms/assets/components/MeetingRooms/connector.php';
</script>";
$modx->regClientStartupScript($script1);
$bottomscripts = array();
//*
$script2 = <<<EOS
<script type='text/javascript'>
function makeRequest() {	
	Ext.Ajax.request({
		url: MeetingRooms.config.connectorUrl
		,params: {
			action: 'mgr/mrResources/getList'
			,room: 1
			,HTTP_MODAUTH: MODx.siteId
		},headers: {
			'modAuth': MODx.siteId
		}
		,method: 'GET'
		,success: function (result, request) {
			var test1;
			//Ext.MessageBox.alert('Success','test1: '+MODx+' Data Returned From Server: '+result.responseText);
			//this allows us to convert the response to an object
			eval("resources2 = "+result.responseText.replace("(",'').replace(")",''));
			resources = resources2;
			//alert(resources);
			fields = new Array();
			for (resource in resources.results) {
				if (resources.results[resource].max_amount != undefined) {
					field = new Object();
					if (resources.results[resource].max_amount < 2) {
						field.fieldLabel = resources.results[resource].name;
						field.name = resources.results[resource].id;
						field.xtype = 'checkbox';
					//	alert("pause here");
					} else {
						field.name = resources.results[resource].name;
						field.xtype = 'textfield';
						
					}
					myform.add(field);
				}
			};
			//alert(JSON.stringify(fields));
			myform.doLayout();
		}
		,failure: function (result, request) {
			Ext.MessageBox.alert('Failed', result.responseText);
		}
	
	});
}
</script>
EOS;
//*/
/*
$script2 = <<<EOS
<script type='text/javascript'>
	alert("Message Box");
</script>
EOS;
//*/
//$modx->regClientStartupScript($script2);
$bottomscripts [] = $script2;
$bottomscripts[] = <<<EOS3
<script type='text/javascript'>
alert(resources);
fields = new Array();
for (resource in resources.results) {
	if (resources.results[resource].max_amount != undefined) {
		var field;
		if (resources.results[resource].max_amount < 2) {
			field.name = resources.results[resource].name;
			field.type = 'checkbox';
			
		} else {
			field.name = resources.results[resource].name;
			field.type = 'text';
			
		}
		fields.push(field);
	}
};
alert(JSON.stringify(fields));
</script>
EOS3;

$bottomscripts[] = <<<EOS4
<script type="text/javascript">
function loadform() {
	if (MODx != undefined) {
		//alert(MODx.siteId);
		 myform = new Ext.form.FormPanel({
			frame: false
			,title: 'Resources Requested'
			,width: 350
			,defaults: {width: 230}
			,defaultType: 'checkbox'
			,items: []

			
		});
		myform.on("beforerender", makeRequest);
		myform.render('forext');
	} else {
		setTimeout("loadform()",1000);
	}
}
window.onload = function(e) {
	setTimeout("loadform()",1000);
}
</script>

EOS4;
$output = "Test";
$mybasePath = 'c:/inetpub/wwwroot/test_site/';
$myPath = 'MeetingRooms/core/components/MeetingRooms/';
$processorPath = $myPath.'processors/';
$mgrPath = $processorPath.'mgr/';
$mrRoomsPath = $mgrPath.'mrRooms/';
$mrResourcesPath = $mgrPath.'mrResources/';
$mrRoomsGetListPath = $mrRoomsPath.'getlist';
$mrResourceGetListPath = $mrResourcesPath.'getlist';
$tests = array();
$tests['mrRoomsGetListPath'] = $mybasePath.$mrRoomsGetListPath;
$tests['rooms getlist'] = file_exists($mybasePath.$mrRoomsGetListPath.'.php');
$tests['mrResourceGetListPath'] = $mybasePath.$mrResourceGetListPath.'.php';
$tests['resources getlist'] = file_exists($mybasePath.$mrResourceGetListPath.'.php');

$scriptProperties = array();

$c = $modx->newQuery('mrRequests');



$tests['count'] = $count = $modx->getCount('mrRequests', $c);
$tests[] = $resTable =  $modx->getTableName('mrRequests');
$tests[] = $roomsTable = $modx->getTableName('mrRooms');
$tests['sql'] = $sql = "Select * from $resTable join $roomsTable as Rooms on room = Rooms.id ";
$stmt = $modx->prepare($sql);
$stmtArray = array();
if ($stmt && $stmt->execute()){
	$stmtArray[] = $stmt->fetchAll(PDO::FETCH_ASSOC);
	//$tests['stmtArray'] = $stmtArray;
}
$list = array();
foreach ($stmtArray[0] as $stmtRes) {
	$tests[] = $stmtRes;
	$stmtRes['room_name'] = 'stmt_'.$modx->getObject('mrRooms',$stmtRes['room'])->get('name');
	$id = $stmtRes['id'];
	$object = $modx->getObject('mrRequests',$id);
	$tests[] = $object->get('id');
	$list[] = $stmtRes;
}
$jsonresult = json_encode($list);
$tests['json'] = '{"total":'.count($list).',"results":'.$jsonresult.'}';

$output .= "<pre>".print_r($tests,true)."</pre>";
$output .= "<div id='forext'></div>";
reset($bottomscripts);
foreach ($bottomscripts as $script) {
	$output .= $script;
}
return $output;