<?php
	require_once MODX_CORE_PATH . 'model/modx/modrequest.class.php';
	class MeetingRoomsControllerRequest extends modRequest {
		public $mrManager = null;
		public $actionVar = 'action';
		public $defaultAction = 'index';
		
		function __construct( mrManager &$mrManager) {
			parent :: __construct($mrManager->modx);
			$this->mrManager =& $mrManager;
		}
		
		public function handleRequest() {
			$this->loadErrorHandler(); //function inherited from modRequest
			
			/* save page to manager object. allow custom actionVar choice for extending classes . */
			$this->action = isset($_REQUEST[$this->actionVar])? $_REQUEST[$this->actionVar] : $this->defaultAction;
			$modx =& $this->modx;
			$mrManager =& $this->mrManager;
			$viewHeader = include $this->mrManager->config['corePath'].'controllers/mgr/header.php';
			$f = $this->mrManager->config['corePath'].'controllers/mgr/'.$this->action.'.php';
			if (file_exists($f)) {
				$viewOutput = include $f;
			} else {
				$viewOutput = 'Controller not found: '.$f;
			}
			return $viewHeader.$viewOutput;
		}
	}