<?php
//get request
if (empty($scriptProperties['id'])) return $modx->err->failure($modx->lexicon('MeetingRooms.request_err_ns'));
$mrRequest = $modx->getObject('mrRequests',$scriptProperties['id']);
//if we couldn't find the request return a not found message
/*
try {
	$date = new DateTime::createFromFormat( "m/d/Y H:i: A", $scriptProperties['startDate']." ".$scriptProperties['startTime']);
} catch (Exception $e) {
	return $modx->error->failure($e->getMessage();
	
}

//return $modx->error->failure($scriptProperties['date'] = $date->format("Y-m-d h:i:s"));
//*/
$startString = $scriptProperties['startDate']." ".$scriptProperties['startTime'];
$endString = $scriptProperties['startDate']." ".$scriptProperties['endTime'];
$start = DateTime::createFromFormat('Y-m-d h:i A', $startString);
$end = DateTime::createFromFormat('Y-m-d h:i A', $endString);

$scriptProperties['start'] = $start->format('Y-m-d H:i:s');
$scriptProperties['end'] = $end->format('Y-m-d H:i:s');
if (empty($mrRequest)) return $modx->error->failure($modx->lexicon('MeetingRooms.request_err_nf'));

return $modx->error->failure('<pre>'.print_r($scriptProperties,true).'</pre>');