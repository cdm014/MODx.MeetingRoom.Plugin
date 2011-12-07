<?php

//config data
$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'name');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$query = $modx->getOption('query',$scriptProperties,'');

$c = $modx->newQuery('mrResources');
$c->setClassAlias('mrResources');
//$c->innerJoin('mrRooms','Rooms','mrResources.room = Rooms.id');
if (!empty($query)){
	$qstring = '%'.$query.'%';
	
	
	$c->where(array(
		'mrResources.name:LIKE' => $qstring
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