<?php
//snippet to return data
$meetingRooms = $modx->getService('mrManager','mrManager',$modx->getOption('MeetingRooms.core_path',null,$modx->getOption('core_path').'components/MeetingRooms/').'model/MeetingRooms/',$scriptProperties);
//if we didn't ask what type of data
//assume we mean a request
$output[] = $scriptProperties;
$output['start'] = $start;
$output['post'] = $_POST;
//$output['type'] = $scriptProperties['type'];
//if we want requests
$type = '';
if (!empty($_POST['type'])) {
	$type = $_POST['type'];
} else {
	$type = 'request';
}
$output['type'] = $type;
if (strpos($type,'request') !== false) {
	//looking for request data
	$output['request'] = true;
	//setup start and end dates
	//*
	$start = new DateTime();
	$startString = $start->format("Y-m-d 0:00:00");
	if (!empty($_POST['start'])) {
		$startString = $_POST['start'].' 0:00:00';
	
	}
	
	$end = new DateTime();
	$end->modify("+365 days");
	$endstring = $end->format ("Y-m-d 23:59:59");
	if (!empty($_POST['end'])) {
		$endstring = $_POST['end'].' 23:59:59';
	}
	$output['startString']= $startString;
	$output['endstring'] = $endstring;
	//*/
	$whereString = " start >= '$startString' AND start <= '$endstring'";
	if (!empty($_POST['room'])) {
		$room = $_POST['room'];
		$whereString .= " and room = $room";
	}
	$requests = $modx->getCollection('mrRequests',$whereString);
	$response['total'] = count($requests);
	$response['results'] = array();
	foreach ($requests as $request) {
		$response['results'][] = $request->toArray();
	
	}
	//*
	$output = json_encode($response['results']);
	return $output;
	//*/
	/*
	return print_r($output, true);
	//*/
} elseif (strpos($type,'room') !== false) {
	//looking for room data
	$output['room'] = true;
	
	
} else {
	//I dont' know what we're looking for
}
return "<pre>".print_r($output, true)."</pre>";
