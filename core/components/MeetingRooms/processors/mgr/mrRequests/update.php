<?php
/*
mrRequests update processor

Processor saves request Information
processor saves resource information
Processor deletes old resource information
*/

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

//save request data
$mrRequest->fromArray($scriptProperties);

if ($mrRequest->save() == false) {
	return $modx->error->failure($modx->lexicon('Meetingrooms.request_err_save'));
}
$mrRequestArray = $mrRequest->toArray();
//deal with requested resources
$keys = array_keys($scriptProperties);

function resource_field($var) {
		if (strpos($var,'rresource_') !== false) {
			return $var;
		} else { 
			return false;
		}
}
//figure out which resources we have
$resource_keys = array_filter($keys, "resource_field");

$myresources = array();
$id = $scriptProperties['id'];

foreach ($resource_keys as $key) {
	//myResources[$key] builds array of requested resources for this request.
	$myresources[$key] = $scriptProperties[$key];
	//*
	$pos = strpos($key,'_');
	$resId = substr($key, $pos + 1);
	$temp = array();
	$temp['request'] = $id;
	$temp['resource'] = $resId;
	$temp['amount'] = $scriptProperties[$key];
	if ($scriptProperties[$key] == "on") {
		$temp['amount'] = 1;
	}
	//*
	//if we have previously put in a value for this, then replace that value
	$rresource = $modx->getObject('mrRequestedResource', array('request'=>$id,'resource'=>$resId) );
	if (empty($rresource)) {
		$rresource = $modx->newObject('mrRequestedResource');
	}
	//*
	$rresource->fromArray($temp);
	//*
	if($rresource->save() == false) {
		$modx->error->addField('$key','Error Saving Field');
	}
	//*/
	if ($modx->error->hasError()) { return $modx->error->failure();}
	
}
//pull resources to see which ones need to be deleted

$c = $modx->newQuery('mrRequestedResource');
//set criteria that they match the current meeting request

$c->where(array('request'=>$id));

$requestedresources = $modx->getIterator('mrRequestedResource',$c);
//loop through to check if we have a value for that field
foreach ($requestedresources as $resource) {
//
	$resourceId = $resource->get('resource');
	$fieldname = 'rresource_'.$resourceId;
	if ((!(array_key_exists($fieldname, $scriptProperties)))||$scriptProperties[$fieldname] == 0) {
		$resource->remove();
	}
}



return $modx->error->success('',$mrRequest);




return $modx->error->failure('<pre>'.print_r($scriptProperties,true).'</pre>');