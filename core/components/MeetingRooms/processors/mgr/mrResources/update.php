<?php
//get resource
if (empty($scriptProperties['id'])) return $modx->error->failure($modx->lexicon('MeetingRooms.resource_err_ns'));
$mrResource = $modx->getObject('mrResources',$scriptProperties['id']);
if (empty($mrResource)) return $modx->error->failure($modx->lexicon('MeetingRooms.resource_err_nf'));
$mrRoom = $modx->getObject('mrRooms',$scriptProperties['room']);
if (empty($mrRoom)) return $modx->error->failure($modx->lexicon('MeetingRooms.room_err_nf'));
//set resource Fields
$mrResource->fromArray($scriptProperties);

//save data
if ($mrResource->save() == false) {
	return $modx->error->failure($modx->lexicon('MeetingRooms.resource_err_save'));
}
$mrResourceArray = $mrResource->toArray();
//return $modx->error->failure('<pre>'.print_r($scriptProperties,true).print_r($mrResourceArray,true).'</pre>');
return $modx->error->success('',$mrResource);