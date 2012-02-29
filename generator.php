
<?php
/*
$basepath = realpath(dirname(__FILE__));

//outputs: c:\inpetpub\wwwroot\test_site
//*/
$base_path = realpath(dirname(__FILE__));
$xpdo_path = strtr( $base_path . '/core/xpdo/xpdo.class.php', '\\', '/');
include('/core/config/config.inc.php');

include_once ( $xpdo_path );

//xpdo constructor
$xpdo = new xPDO("mysql:host=$database_server;dbname=$dbase",$database_user,$database_password,array("table_prefix"=>$table_prefix));

//get detailed log information
$xpdo->setLogLevel(xPDO::LOG_LEVEL_INFO);
$xpdo->setLogTarget(XPDO_CLI_MODE? 'ECHO' : 'HTML' );

//manager and Generator classes
$manager = $xpdo->getManager();
$generator = $manager->getGenerator();

//setup templates
$generator->classTemplate= <<<EOD
<?php
/**
 * [+phpdoc-package+]
 */
 class [+class+] extends [+extends+] {}
 ?>
EOD;
 
 $generator->platformTemplate= <<<EOD
 <?php
 /**
  * [+phpdoc-package+]
  */
  require_once(strtr(realpath(dirname(dirname(__FILE__))), '\\\\', '/').'/[+class-lowercase+].class.php');
  class [+class+]_[+platform+] extends [+class+] {}
  ?>
EOD;
$generator->mapHeader= <<<EOD
<?php
/**
 * [+phpdoc-package+]
 */
EOD;

//file information
$schema = strtr($base_path.'/core/components/MeetingRooms/model/schema/MeetingRooms.mysql.schema.xml','\\', '/');
$target = strtr($base_path.'/core/components/MeetingRooms/model/','\\', '/');
print $schema;
$generator->parseSchema($schema,$target);
//$xpdo2 = new xPDO("mysql:host=$database_server;dbname=$dbase",'root','chester',array("table_prefix"=>"meetingrooms_"));
$xpdo2 = new xPDO("mysql:host=$database_server;dbname=$dbase",'root','chester',array("table_prefix"=>$table_prefix));
if ($xpdo2->connect()) {
	print "<p>Connected</p>";
} else {
	print "<p>Could not connect</p>";
}
print "<p>test</p>";
$xpdo2->setDebug(false);
$xpdo2->setLogLevel(xPDO::LOG_LEVEL_INFO);
$xpdo2->setLogTarget(XPDO_CLI_MODE? 'ECHO' : 'HTML' );
print $xpdo2->addPackage('MeetingRooms',$target)?"<p>Package Added</p>": "<p>Package Not Added</p>";
$test = array();
$test['mrRoms'] = $xpdo2->getPackage('mrRooms');
$test['mrResources'] = $xpdo2->getPackage('mrResources');
$test['mrRequests'] = $xpdo2->getPackage('mrRequests');
$test['mrRequestedResource'] = $xpdo2->getPackage('mrRequestedResource');
print "<p>Package testing</p>";
print "<pre>";
print_r($test);
print "</pre>";
$manager2 = $xpdo2->getManager();
if (is_null($manager2)) {
	print "<p>No Manager</p>";
} else {
	print "<p>Manager obtained</p>";
}

print "<p>".$xpdo2->getTableName('mrRooms',true)."</p>";
/*
if ($manager2->createObjectContainer('mrRooms')) {
	print "<p>Rooms Container Created</p>";
} else {
	print "<p>Rooms Container not Created</p>";
}

if ($manager2->createObjectContainer('mrResources')) {
	print "<p>Resources Container Created</p>";
} else {
	print "<p>Resources Container not Created</p>";
}

if ($manager2->createObjectContainer('mrRequests')) {
	print "<p>Requests Container Created</p>";
} else {
	print "<p>Requests Container not Created</p>";
}

if ($manager2->createObjectContainer('mrRequestedResource')) {
	print "<p>RequestedResource Container Created</p>";
} else {
	print "<p>RequestedResource Container not Created</p>";
}
//*/
$rooms = $xpdo2->getCollection('mrRooms');
print "<p>Rooms:".count($rooms)."</p>";
