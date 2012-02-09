<?php
$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'name');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$query = $modx->getOption('query',$scriptProperties,'');
$debug = array();
//query the db
$resTable = $modx->getTableName('mrResources');
$roomsTable = $modx->getTableName('mrRooms');

$debug['query'] = $qstring;
$sql = "Select ".$resTable.".id, ".$resTable.".name, max_amount, room, Rooms.name as `room_name` from $resTable join $roomsTable as Rooms on room = Rooms.id where ";

if(!empty($scriptProperties['room'])) {
	$sql .= "  room = ".$scriptProperties['room']." and ";
}

	$qstring = '%'.$query.'%';
	$whereclause = "($resTable.name like '$qstring' or Rooms.name like '$qstring')";
	$sql .= $whereclause;
	


$debug['sql'] = $sql;
//return $modx->error->failure($sql);
$stmt = $modx->prepare($sql);
$stmtArray = array();
if ($stmt && $stmt->execute()){
	$stmtArray[] = $stmt->fetchAll(PDO::FETCH_ASSOC);
	//$tests['stmtArray'] = $stmtArray;
}
$list = array();
foreach ($stmtArray[0] as $stmtRes)
{
	$room = $modx->getObject('mrRooms',$stmtRes['room']);
	$stmtRes['room_name'] = $room->get('name');
	$list[] = $stmtRes;
}
$count = count($list);

return $this->outputArray($list,$count);
