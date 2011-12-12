<?php
$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'start');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$query = $modx->getOption('query',$scriptProperties,'');
$room = $modx->getOption('room',$scriptProperties,'');
$date = $modx->getOption('date',$scriptProperties, date('Y-m-d 00:00:00'));


/*
//branch for when I add code to allow filtering appointments by room
if (!empty $room) {


} else {



}

//*/

$c = $modx->newQuery('mrRequests');


if (!empty($query)) {
	$qstring = '%'.$query.'%';
	$c->where(array(
		'name:LIKE' => $qstring,
		'OR:group:LIKE' => $qstring,
		'OR:email:LIKE' => $qstring,
		'OR:libraryCard:LIKE' => $qstring,
		'OR:start:LIKE' => $qstring,
		'OR:requestNumber:LIKE' => $qstring,
		
	));
}
$c->where(array(
	'start:>=' => $date
), xPDOQuery::SQL_AND);
$count = $modx->getCount('mrRequess',$c);
$c->sortby($sort,$dir);

if ($isLimit) $c->limit($limit,$start);
$requests = $modx->getIterator('mrRequests',$c);

//iterate
$list = array();
foreach ($requests as $request) {
	$requestArray = $request->toArray();
	$room = $modx->getObject('mrRooms',$requestArray['room']);
	$requestArray['room_name'] = $room->get('name');
	$list[] = $requestArray;
}
return $this->outputArray($list,$count);

		