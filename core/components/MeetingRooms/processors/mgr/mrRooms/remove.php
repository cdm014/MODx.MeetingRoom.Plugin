<?php
if (empty($scriptProperties['id'])) return $modx->error-failure($modx->lexicon('MeetingRooms.room_err_ns'));
$room = $modx->getObject('mrRooms', $scriptProperties['id']);
if (empty($room)) return $modx->error->failure($modx->lexicon('MeetingRooms.room_err_nf'));

if ($room->remove() == false) {
	return $modx->error->failure($modx->lexicon('MeetingRooms.room_err_remove'));
}

return $modx->error->success('',$room);