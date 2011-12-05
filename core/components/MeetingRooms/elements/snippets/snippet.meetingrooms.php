<?php
/*
//debug messages
$modx->setDebug(true);
$modx->setLogLevel(modX::LOG_LEVEL_DEBUG);
$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');
*/
$output = "<pre>";
$output .= "test 1\n";
$output .= "expected path: ".$modx->getOption('MeetingRooms.core_path',null,$modx->getOption('core_path').'components/MeetingRooms/').'model/MeetingRooms/';
$meetingRooms = $modx->getService('mrManager','mrManager',$modx->getOption('MeetingRooms.core_path',null,$modx->getOption('core_path').'components/MeetingRooms/').'model/MeetingRooms/',$scriptProperties);
if (!($meetingRooms instanceof mrManager)) {
	$output .= "\nService Started: NO";
} else {
	$output .= "\nService Started: YES";
}
$output .= "\nFile Check: ".file_exists($modx->getOption('MeetingRooms.core_path',null,$modx->getOption('core_path').'components/MeetingRooms/').'model/MeetingRooms/mrmanager.class.php');
$output .= "\nLooked for in: ".$meetingRooms->config["modelPath"];
/*
//generate tables
$m = $modx->getManager();
$created = array();
$created['mrRooms'] = $m->createObjectContainer('mrRooms');
$created['mrResources'] = $m->createObjectContainer('mrResources');
$created['mrRequests'] = $m->createObjectContainer('mrRequests');
$created['mrRequestedResource'] = $m->createObjectContainer('mrRequestedResource');
$output .= print_r($created,true);
*/
/*
//view loaded packages
$output .= print_r($modx->packages,true);
*/
$rooms = $modx->getCollection('mrRooms');
$output .= "\ncount: ".count($rooms);
$output .= "</pre>";
return $output;
