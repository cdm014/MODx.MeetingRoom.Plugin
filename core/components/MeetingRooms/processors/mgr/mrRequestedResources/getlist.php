<?php
/*
	mrRequestedResources getlist processor
	this processor will return values for any resources for the room even if they have not been requested
*/

$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'name');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$query = $modx->getOption('query',$scriptProperties,'');

//get all available resources for that room
if (empty($scriptProperties['room'])) {
	return $modx->error->failure("Room not specified");
}
if (empty($scriptProperties['id'])) {
	return $modx->error->failure("Request not specified");
}
$room = $scriptProperties['room'];
$id = $scriptProperties['id'];

$resquery = $modx->newQuery('mrResources');
$resquery->where(array('room' => $room));

$resources = $modx->getIterator('mrResources',$resquery);
$count = $modx->getCount('mrResources',$resquery);
$list = array();
//iterate through, if we have a value use that, otherwise use nothing
foreach ($resources as $resource) {
	$rresource = $modx->getObject('mrRequestedResource',array('request'=>$id,'resource'=>$resource->get('id')));
	$resArray = $resource->toArray();
	if(!empty($rresource)) {
		$resArray['amount'] = $rresource->get('amount');
	}
	$list[] = $resArray;
	

}
return $this->outputArray($list,$count);