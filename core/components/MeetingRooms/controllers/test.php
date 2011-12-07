<?php
require_once dirname(dirname(__FILE__)).'/model/MeetingRooms/mrmanager.class.php';
$mrManager = new mrManager($modx);
$modx->setLogLevel(modX::LOG_LEVEL_DEBUG);
$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');
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
//$scriptProperties['query'] = 'test1';


$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'resourceByRoom');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$query = $modx->getOption('query',$scriptProperties,'');


$tests['query'] = $query;
$qstring = '%'.$query.'%';
$tests['qstring'] = $qstring;
$c = $modx->newQuery('mrResources');

if (!empty($query)){
	$qstring = '%'.$query.'%';
	$c->innerJoin('mrRooms','Rooms','room = Rooms.id');
	$c->where(array(
		'name:LIKE' => $qstring
		,'OR:Rooms.name:LIKE' => $qstring
		
	));
}

$tests['count'] = $count = $modx->getCount('mrResources', $c);
$tests[] = $resTable =  $modx->getTableName('mrResources');
$tests[] = $roomsTable = $modx->getTableName('mrRooms');
$tests['sql'] = $sql = "Select * from $resTable join $roomsTable as Rooms on room = Rooms.id where $resTable.name like '$qstring' or Rooms.name like '$qstring'";
$stmt = $modx->prepare($sql);
$stmtArray = array();
if ($stmt && $stmt->execute()){
	$stmtArray[] = $stmt->fetchAll(PDO::FETCH_ASSOC);
	//$tests['stmtArray'] = $stmtArray;
}
$list = array();
foreach ($stmtArray[0] as $stmtRes) {
	$stmtRes['room_name'] = 'stmt_'.$modx->getObject('mrRooms',$stmtRes['room'])->get('name');
	$list[] = $stmtRes;
}
$jsonresult = json_encode($list);
$tests['json'] = '{"total":'.count($list).',"results":'.$jsonresult.'}';

//*
$resources = $modx->getIterator('mrResources',$c);
foreach ($resources as $resource) {
	$resourceArray = $resource->toArray();
	$resourceArray['room_name'] = $modx->getObject('mrRooms',$resourceArray['room'])->get('name');
	$tests[] = $resourceArray;
}
//*/
$output .= "<pre>".print_r($tests,true)."</pre>";
return $output;