<?php
/*
	mrRequests getlist processor
*/
$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'start');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$query = $modx->getOption('query',$scriptProperties,'');
$room = $modx->getOption('room',$scriptProperties,'');
$date = $modx->getOption('date',$scriptProperties, '');
$end = $modx->getOption('end', $scriptProperties,null);
function debug_msg($array) {
	return '<pre>'.print_r($array,true).'</pre>';
}

$debug[] = $scriptProperties;

$c = $modx->newQuery('mrRequests');
//return $modx->error->failure(debug_msg($debug));
/*
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
//*/
if (!empty($query)) {
	$qstring = '%'.$query.'%';
	$c->where(array(
		'name:LIKE' => $qstring,
		'OR:group:LIKE' => $qstring,
		'OR:email:LIKE' => $qstring,
		'OR:requestNumber:LIKE' => $qstring,
		
	));
}


if (!empty($room)) {
	if ($room != '3' && $room != '4') {
		$c->where(array(
			'room:=' => $room
		), xPDOQuery::SQL_AND);
	} else {
		$c->where(array(
			'room:=' => 3,
			'OR:room:=' => 4,
		), xPDOQuery::SQL_AND);
	}
}
if (!empty($date)) {
	$c->where(array(
		'start:>=' => $date
	), xPDOQuery::SQL_AND);
}
//*
if (!empty($end) && $end != null) {
	$c->where(array(
		'end:>=' => $end
	), xPDOQuery::SQL_AND);
}

//*/
$count = $modx->getCount('mrRequests',$c);
$c->sortby($sort,$dir);

if ($isLimit) $c->limit($limit,$start);
$requests = $modx->getIterator('mrRequests',$c);

//iterate
$list = array();
foreach ($requests as $request) {
	$requestArray = $request->toArray();
	$room = $modx->getObject('mrRooms',$requestArray['room']);
	$id = $requestArray[id];
	$mrRequest = $modx->getObject('mrRequests',$id);
	$status = $mrRequest->get('status');
	$requestArray['status'] = 3;
	$requestArray['room_name'] = $room->get('name');
	$list[] = $requestArray;
}
return $this->outputArray($list,$count);

		