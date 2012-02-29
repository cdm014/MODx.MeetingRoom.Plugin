<?php
$meetingRooms = $modx->getService('mrManager','mrManager',$modx->getOption('MeetingRooms.core_path',null,$modx->getOption('core_path').'components/MeetingRooms/').'model/MeetingRooms/',$scriptProperties);
$rooms = $modx->getCollection('mrRooms');
$results = array();
foreach ($rooms as $room) {
	$output[] = $room->toArray();
	
}
//$output = json_encode($results);
return json_encode($output);

