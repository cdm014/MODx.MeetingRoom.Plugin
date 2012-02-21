<?php
/*
	mrRequests remove processor
*/
if (empty($scriptProperties['id'])) { 
	return $modx->error->failure($modx->lexicon('MeetingRooms.request_err_ns')); 
}

$request = $modx->getObject('mrRequests',$scriptProperties['id']);
if (empty($request)) {
	return $modx->error->failure($modx->lexicon('MeetingRooms.request_err_nf'));
}

if ($request->remove() == false) {
	return $modx->error->failure($modx->lexicon('MeetingRooms.request_err_remove'));
}

$c = $modx->newQuery('mrRequestedResource');
$c->where(array('request' => $scriptProperties['id']));
$requestedresources = $modx->getIterator('mrRequestedResource',$c);

foreach ($requestedresources as $resource) {
	$resource->remove();
}
return $modx->error->success('',$request);