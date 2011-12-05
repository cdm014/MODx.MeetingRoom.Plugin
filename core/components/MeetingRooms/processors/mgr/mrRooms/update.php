<?php
//get room
if (empty($scriptProperties['id'])) return $modx->error->failure($modx->lexicon('MeetingRooms.room_err_ns'));
$mrRoom = $modx->getObject('mrRooms',$scriptProperties['id']);
if (empty($mrRoom)) return $modx->error->failure($modx->lexicon('MeetingRooms.room_err_nf'));

//set Room Fields
$mrRoom->fromArray($scriptProperties);

//save room
if ($mrRoom->save() == false) {
	return $modx->error->failure($modx->lexicon('MeetingRooms.room_err_save'));
}

return $modx->error->success('',$mrRoom);