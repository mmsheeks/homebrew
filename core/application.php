<?php

use Homebrew\Core\Request;
use Homebrew\Core\Router;

class Application {

	protected $request 	= null;
	protected $response	= null;
	
	public function __construct() {
		$this->request = new Request;
	}

	public function load() {
		$router = new Router();
		var_dump( $this->request );
	}
}