<?php
//snippet to return data
$meetingRooms = $modx->getService('mrManager','mrManager',$modx->getOption('MeetingRooms.core_path',null,$modx->getOption('core_path').'components/MeetingRooms/').'model/MeetingRooms/',$scriptProperties);
//if we didn't ask what type of data
//assume we mean a request
$output[] = $scriptProperties;
//$output['type'] = $scriptProperties['type'];
//if we want requests
$type = '';
if (!empty($scriptProperties['type'])) {
	$type = $scriptProperties['type'];
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
	$end = new DateTime();
	$end->modify("+365 days");
	$endstring = $end->format ("Y-m-d 23:59:59");
	
	$output['startString']= $startString;
	$output['endstring'] = $endstring;
	//*/
	$requests = $modx->getCollection('mrRequests'," start >= '$startString' AND start <= '$endstring'");
	$response['total'] = count($requests);
	$response['results'] = array();
	foreach ($requests as $request) {
		$response['results'][] = $request->toArray();
	
	}
	$output = json_encode($response['results']);
	return $output;
	
} elseif (strpos($type,'room') !== false) {
	//looking for room data
	$output['room'] = true;
	
	
} else {
	//I dont' know what we're looking for
}
return "<pre>".print_r($output, true)."</pre>";
