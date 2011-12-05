<?php
if(empty($scriptProperties['name'])){
	$modx->error->addField('name',$modx->lexicon('MeetingRooms.room_err_ns_name'));
} else {
	$alreadyExists = $modx->getObject('mrRooms',array('name' => $scriptProperties['name']));
	if ($alreadyExists) {
		$modx->error->addField('name',$modx->lexicon('MeetingRooms.room_err_ae'));
	}
}

if ($modx->error->hasError()) { return $modx->error->failure(); }

$room = $modx->newObject('mrRooms');
$room->fromArray($scriptProperties);

if ($room->save() == false) {
	return $modx->error->failure($modx->lexicon('MeetingRooms.room_err_save'));
}

return $modx->error->success('',$room);