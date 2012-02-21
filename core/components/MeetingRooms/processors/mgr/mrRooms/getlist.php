<?php
/*
	mrRooms getlist processor
*/

$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'name');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$query = $modx->getOption('query',$scriptProperties,'');
 //*
//build query
$c = $modx->newQuery('mrRooms');

if (!empty($query)){
	$c->where(array(
		'name:LIKE' => '%'.$query.'%',
		'OR:address:LIKE' => '%'.$query.'%'
	));
}
$count = $modx->getCount('mrRooms',$c);
$c->sortby($sort,$dir);
if ($isLimit) $c->limit($limit,$start);
$doodles = $modx->getIterator('mrRooms', $c);
 
// iterate 
$list = array();
foreach ($doodles as $doodle) {
    $doodleArray = $doodle->toArray();
    $list[]= $doodleArray;
}
return $this->outputArray($list,$count);

//*/

