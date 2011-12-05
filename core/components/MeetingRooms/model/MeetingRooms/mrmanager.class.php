<?php
class mrManager {
	public $modx; //to give us local access to $modx
	public $config = array(); //to give us a place to store configuration options
	function __construct( modX &$modx,array $config = array()) {
		$this->modx =& $modx;
		//paths for configuration
		$basePath = $this->modx->getOption('MeetingRooms.core_path',$config,$this->modx->getOption('core_path').'components/MeetingRooms/');
        $assetsUrl = $this->modx->getOption('MeetingRooms.assets_url',$config,$this->modx->getOption('assets_url').'components/MeetingRooms/');
        $this->config = array_merge(array(
            'basePath' => $basePath, 
            'corePath' => $basePath,
            'modelPath' => $basePath.'model/',
            'processorsPath' => $basePath.'processors/',
            'chunksPath' => $basePath.'elements/chunks/',
            'jsUrl' => $assetsUrl.'js/',
            'cssUrl' => $assetsUrl.'css/',
            'assetsUrl' => $assetsUrl,
            'connectorUrl' => $assetsUrl.'connector.php',
        ),$config); //merge default values with config values from the array passed into the constructor
        $this->modx->addPackage('MeetingRooms',$this->config['modelPath']); //add the package to $modx 
	}
	
	public function initialize($ctx = 'web') {
		switch ($ctx) {
			case 'mgr' :
				$this->modx->lexicon->load('MeetingRooms:default');
				if(!$this->modx->loadClass('MeetingRoomsControllerRequest',$this->config['modelPath'].'MeetingRooms/request/',true,true)) {
					return 'Could not load controller request handler.';
				}
				$this->request = new MeetingRoomsControllerRequest($this);
				return $this->request->handleRequest();
			break;
		}
		return true;
	}
}