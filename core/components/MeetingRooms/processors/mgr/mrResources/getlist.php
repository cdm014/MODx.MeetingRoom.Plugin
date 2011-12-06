<?php

//config data
$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'name');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$query = $modx->getOption('query',$scriptProperties,'');

$c = $modx->newQuery('mrResources');
if (!empty($query)){
	$qstring = '%'.$query.'%';
	$output .= "<p>qstring: $qstring</p>";
	$c->innerJoin('mrRooms','Room');
	$c->where(array(
		'name:LIKE' => $qstring
		,'OR:Room.name:LIKE' => $qstring
	));
}

$count = $modx->getCount('mrResources', $c);
$c->sortby($sort,$dir);
$resources = $modx->getIterator('mrResources',$c);

//iterate
$list = array();
foreach ($resources as $resource) {
	$resourceArray = $resource->toArray();
	$resourceArray['room_name'] = $modx->getObject('mrRooms',$resourceArray['room'])->get('name');
	$list[] = $resourceArray;
}

return $this->outputArray($list,$count);