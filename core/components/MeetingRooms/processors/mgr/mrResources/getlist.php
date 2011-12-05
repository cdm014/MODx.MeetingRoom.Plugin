<?php
//config data
$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'name');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$query = $modx->getOption('query',$scriptProperties,'');
 
 $c = $modx->newQuery('mrResources');
 
/*

$c = $modx->newQuery('mrResources');
if (!empty($query)){
	$c->where(array(
		'name:LIKE' => '%'.$query.'%'
		
	));
}
$count = $modx->getCount('mrResources',$c);
$c->sortby($sort,$dir);
if ($isLimit) $c->limit($limit,$start);
$doodles = $modx->getIterator('mrResources', $c);



$list = array();
foreach ($doodles as $doodle) {
	$doodleArray = $doodle->toArray();
	$room = $modx->getObject('mrRooms',$doodleArray['room']);
	$roomArray = $room->toArray();
	$doodleArray['room'] = $roomArray['name'];
    $list[]= $doodleArray;
}
return $this->outputArray($list,$count); 

//*/
//*


if (!empty($query)){
	$qstring = '%'.$query.'%';
	$output .= "<p>qstring: $qstring</p>";
	$c->innerJoin('mrRooms','Room');
	$c->where(array(
		'name:LIKE' => $qstring
		,'OR:Room.name:LIKE' => $qstring
	));
}
$count = $modx->getCount('mrResources',$c);
$c->sortby($sort,$dir);
if ($isLimit) $c->limit($limit,$start);

$doodles = $modx->getIterator('mrResources', $c);

$list = array();
foreach ($doodles as $doodle) {
	$doodleArray = $doodle->toArray();
	$room = $modx->getObject('mrRooms',$doodleArray['room']);
	$roomArray = $room->toArray();
	//$doodleArray['room'] = $roomArray['name'];
	$doodleArray['room_name'] = $roomArray['name'];
    $list[]= $doodleArray;
}
return $this->outputArray($list,$count);
//*/