<?php
require_once dirname(dirname(__FILE__)).'/model/MeetingRooms/mrmanager.class.php';
$mrManager = new mrManager($modx);
//$modx->setLogLevel(modX::LOG_LEVEL_INFO);
//$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');
return $mrManager->initialize('mgr');