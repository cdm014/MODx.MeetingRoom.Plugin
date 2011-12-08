<?php
if(empty($scriptProperties['id'])) return $modx->error->failure($modx->lexicon('MeetingRooms.resource_err_ns'));
$resource = $modx->getObject('mrResources',$scriptProperties['id']);
if(empty($resource)) return $modx->error->failure($modx-lexicon('MeetingRooms.resource_err_nf'));

if ($resource->remove() == false) {
	return $modx->error->failure($modx->lexicon('MeetingRooms.resource_err_remove'));
}

return $modx->error->success('',$resource);