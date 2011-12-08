<?php
//checkName
if(empty($scriptProperties['name'])){
	$modx->error->addField('name',$modx->lexicon('MeetingRooms.resource_err_ns_name'));
} else {
	$alreadyExists = $modx->getObject('mrResources',array('name'=> $scriptProperties['name'], 'room' => $scriptProperties['room']));
	if ($alreadyExists) {
		$modx->error->addField('name',$modx->lexicon('MeetingRooms.resource_err_ae'));
	}
}

//check max_amount
//if they didn't specify a max amount just set it to 1
if(empty($scriptProperties['max_amount'])) {
	$scriptProperties['max_amount'] = 1;
}
//check room
$room = $modx->getObject('mrRooms',$scriptProperties['room']);
if (empty($room)) {
	return $modx->error->failure($modx->lexicon('MeetingRooms.room_err_nf'));
}
$resource = $modx->newObject('mrResources');
$resource->fromArray($scriptProperties);
if ($resource->save() == false) {
	return $modx->error->failure($modx->lexicon('MeetingRooms.resource_err_save'));
}
return $modx->error->success('',$resource);



