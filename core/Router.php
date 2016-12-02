<?php

namespace Homebrew\Core;

class Router {

	protected $url;
	protected $request;
	protected $parameters;
	protected $routes;
	
	public function __construct(
		$request
	) {
		$this->request = $request;

		$this->loadRoutes();
		$this->parameterize();
		$this->handle();
	}

	private function loadRoutes()
	{
		//load routes from a routes file
		$file = __DIR__ . '/../../../../routes.yml';
		$fh = fopen( $file, 'r' );
		
	}

	private function parameterize()
	{
		//split the path into parameters
		$path = $this->request->getPath();
		$parts = explode( '/', $path );
		foreach($parts as $part ) {
			$this->parameters[] = $part;
		}
	}

	private function handle()
	{
		var_dump($this->parameters);
		//find a matching path and return
	}

}