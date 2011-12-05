<?php
//get resource
if (empty($scriptProperties['id'])) return $modx->error->failure($modx->lexicon('MeetingRooms.resource_err_ns'));
$mrResource = $modx->getObject('mrResources',$scriptProperties['id']);
if (empty($mrResource)) return $modx->error->failure($modx->lexicon('MeetingRooms.resource_err_nf'));

//set resource Fields
$mrResource->fromArray($scriptProperties);
//save data
if ($mrResource->save() == false) {
	return $modx->error->failure($modx->lexicon('MeetingRooms.resource_err_save'));
}
return $modx->error->failure('<pre>'.print_r($scriptProperties,true).'</pre>');
return $modx->error->success('',$mrResource);