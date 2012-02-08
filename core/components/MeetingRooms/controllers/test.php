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
return $output;