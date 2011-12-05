<?php
require_once dirname(dirname(__FILE__)).'/model/MeetingRooms/mrmanager.class.php';
$mrManager = new mrManager($modx);
$modx->setLogLevel(modX::LOG_LEVEL_DEBUG);
$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');
//config data
/*
$scriptProperties = array();
$isLimit = !empty($scriptProperties['limit']);

$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'name');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$query = $modx->getOption('query',$scriptProperties,'');
*/
$sort = 'name';
$dir = 'ASC';
$isLimit = false;

$query = 'test1';
$output = "<p>query: $query</p>";
//create the query
$c = $modx->newQuery('mrResources');

//if we have a search string search our room names too
if (!empty($query)){
	$qstring = '%'.$query.'%';
	$output .= "<p>qstring: $qstring</p>";
	$c->innerJoin('mrRooms','Room');
	$c->where(array(
		'name:LIKE' => $qstring
		,'OR:Room.name:LIKE' => $qstring
	));
}
/*
$c->sortby($sort,$dir);
if ($isLimit) $c->limit($limit,$start);
*/
$count = $modx->getCount('mrResources',$c);
$output .= "<p>count: $count</p>";
//get our iterator
$resources = $modx->getIterator('mrResources', $c);
//$list = array();
$output .= $c->toSQL()."Test.<pre>";
foreach ($resources as $resource) {
	$resourceArray = $resource->toArray();
	$room = $modx->getObject('mrRooms',$resourceArray['room']);
	$resourceArray['room_name'] = $room->get('name');
	$output .= print_r($resourceArray, true);
	//$list[] = $resourceArray;

}
//$output .= print_r($list,true);
$output .= "</pre>";
return $output;