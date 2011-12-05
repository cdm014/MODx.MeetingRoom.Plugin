<?php
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';
 
$corePath = $modx->getOption('MeetingRooms.core_path',null,$modx->getOption('core_path').'components/MeetingRooms/');
require_once $corePath.'model/MeetingRooms/mrManager.class.php';
$modx->mrmanager = new mrManager($modx);
 
$modx->lexicon->load('MeetingRooms:default');
 
/* handle request */
$path = $modx->getOption('processorsPath',$modx->mrmanager->config,$corePath.'processors/');
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));