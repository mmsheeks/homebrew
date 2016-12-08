<?php

namespace Homebrew\Core;

use Symfony\Component\Yaml\Yaml;

class Router {

	protected $routes = null;
	protected $parameters = null;
	protected $request = null;
	
	public function __construct(
		$request
	) {
		$this->request = $request;
		$this->parameterize( $request->getPath() );
		$this->loadRoutes();
	}

	private function parameterize( $path )
	{
		$this->parameters = explode( '/', $path );
	}

	private function loadRoutes()
	{
		$filePath = __DIR__ . '/../../../../routes.yml';
		$routes = [];

		$routes = Yaml::parse( file_get_contents( $filePath ) );

		$this->routes = $routes;
	}

	public function handle()
	{
		$method = $this->request->getMethod();
		$use = '';

		$use = $this->matchNextRoute();

		if( $use === false ) {
			//handle route not found exception
		}

		//load the controller
		$parts = explode( '@', $use );
		$cName = 'App\\'.$parts[0];
		$fName = $parts[1];

		$controller = new $cName( $this->request );
		return $controller->$fName();
	}

	public function matchNextRoute()
	{
		$match = true;

		//grab the first route, then remove it
		$name = '';
		$route = null;
		foreach( $this->routes as $k => $v ) {
			$name = $k;
			$route = $v;
			unset( $this->routes[$k] );
			break;
		}
		
		$pattern = explode( '/', $route['path'] );

		if( count( $pattern ) == count( $this->parameters ) ) {
			foreach( $pattern as $i => $part ) {
				if( $this->parameters[ $i ] != $part ) {
					$match = false;
				}
			}
		} else {
			$match = false;
		}

		if( $match ) {
			return $route['use'];
		} else {
			return $this->matchNextRoute();
		}
	}

}