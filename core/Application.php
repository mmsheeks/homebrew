<?php

namespace Homebrew\Core;

use Homebrew\Core\Request;
use Homebrew\Core\Router;

class Application {

	protected $request 	= null;
	protected $router 	= null;
	protected $response	= null;
	
	public function __construct() {
		$this->request = new Request;
	}

	public function load() {
		$this->router = new Router( $this->request );
		return $this->router->handle();
	}
}