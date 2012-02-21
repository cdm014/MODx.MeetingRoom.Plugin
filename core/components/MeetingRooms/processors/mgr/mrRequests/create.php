<?php
/*
	mrRequests
	create processor
*/


/*
passed in array
Array
(
    [action] => mgr/mrRequests/create
    [HTTP_MODAUTH] => modx4ec2d5be8f9134.90501924_14f3c0dc7e0ed66.66962006
    [name] => Chester Request3
    [libraryCard] => 23330000345979
    [email] => chester@rpl.org
    [phone] => 318-290-3109
    [group] => Rapides Parish Library
    [meetingType] => test meeting
    [startDate] => 2012-02-22
    [startTime] => 11:15 AM
    [endTime] => 5:00 PM
    [requestNumber] => Rapides4f4407b77cae93.87510248
    [room] => 1
    [rresource_1] => 200
    [rresource_3] => 1
)
*/
//check for necessary fields
if (empty($scriptProperties['name'])) {
	$modx->error->addField('name',$modx->lexicon('MeetingRooms.request_err_ns_name'));
}
if (empty($scriptProperties['libraryCard'])) {
	$modx->error->addField('libraryCard',$modx->lexicon('MeetingRooms.request_err_ns_libraryCard'));
}
if (empty($scriptProperties['email'])) {
	$modx->error->addField('email',$modx->lexicon('MeetingRooms.request_err_ns_email'));
}
if (empty($scriptProperties['phone'])) {
	$modx->error->addField('phone',$modx->lexicon('MeetingRooms.request_err_ns_phone'));
}
if (empty($scriptProperties['group'])) {
	$modx->error->addField('group',$modx->lexicon('MeetingRooms.request_err_ns_group'));
}
if (empty($scriptProperties['meetingType'])) {
	$modx->error->addField('meetingType',$modx->lexicon('MeetingRooms.request_err_ns_meetingType'));
}
if (empty($scriptProperties['startDate'])) {
	$modx->error->addField('startDate',$modx->lexicon('MeetingRooms.request_err_ns_startDate'));
}
if (empty($scriptProperties['startTime'])) {
	$modx->error->addField('startTime',$modx->lexicon('MeetingRooms.request_err_ns_startTime'));
}
if (empty($scriptProperties['endTime'])) {
	$modx->error->addField('endTime',$modx->lexicon('MeetingRooms.request_err_ns_endTime'));
}
if (empty($scriptProperties['requestNumber'])) {
	$modx->error->addField('requestNumber',$modx->lexicon('MeetingRooms.request_err_ns_requestNumber'));
}
if (empty($scriptProperties['room'])) {
	$modx->error->addField('room',$modx->lexicon('MeetingRooms.request_err_ns_room'));
}

if ($modx->error->hasError()) { return $modx->error->failure();}

//date processing
$startString = $scriptProperties['startDate']." ".$scriptProperties['startTime'];
$endString = $scriptProperties['startDate']." ".$scriptProperties['endTime'];
$start = DateTime::createFromFormat('Y-m-d h:i A', $startString);
$end = DateTime::createFromFormat('Y-m-d h:i A', $endString);

$scriptProperties['start'] = $start->format('Y-m-d H:i:s');
$scriptProperties['end'] = $end->format('Y-m-d H:i:s');

//check for double book

//save request
$request = $modx->newObject('mrRequests');
$request->fromArray($scriptProperties);
if ($request->save() == false) {
	return $modx->error->failure($modx->lexicon('MeetingRooms.request_err_save'));
}
$scriptProperties['id'] = $request->get('id');
$id = $request->get('id');
//save resources
$keys = array_keys($scriptProperties);

function resource_field($var) {
		if (strpos($var,'rresource_') !== false) {
			return $var;
		} else { 
			return false;
		}
}
//figure out which resources we have
$resource_keys = array_filter($keys, "resource_field");

$myresources = array();


foreach ($resource_keys as $key) {
	//myResources[$key] builds array of requested resources for this request.
	$myresources[$key] = $scriptProperties[$key];
	//*
	$pos = strpos($key,'_');
	$resId = substr($key, $pos + 1);
	$temp = array();
	$temp['request'] = $id;
	$temp['resource'] = $resId;
	$temp['amount'] = $scriptProperties[$key];
	if ($scriptProperties[$key] == "on") {
		$temp['amount'] = 1;
	}
	//*
	//if we have previously put in a value for this, then replace that value
	$rresource = $modx->getObject('mrRequestedResource', array('request'=>$id,'resource'=>$resId) );
	if (empty($rresource)) {
		$rresource = $modx->newObject('mrRequestedResource');
	}
	//*
	$rresource->fromArray($temp);
	//*
	if($rresource->save() == false) {
		$modx->error->addField('$key','Error Saving Field');
	}
	//*/
	if ($modx->error->hasError()) { return $modx->error->failure();}
	
}
return $modx->error->success('',$request);
//default return statement to see what was passed in
return $modx->error->failure('<pre>'.print_r($scriptProperties,true).'</pre>');