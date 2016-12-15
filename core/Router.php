<?php

namespace Homebrew\Core;

use Symfony\Component\Yaml\Yaml;

/**
 * Router Class - Manages directing the request path to the appropriate controller and function
 *
 * @author Martin Sheeks <martin.sheeks@gmail.com>
 * @version 1.0.4
 *
 */
class Router {

	/*
	 * @var array $routes
	 */
	protected $routes = null;
	
	/*
	 * @var array $parameters
	 */
	protected $parameters = null;
	
	/*
	 * @var Request $request
	 */
	protected $request = null;
	
	/*
	 * __construct - establish the routing request object
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.4
	 * @param Request $request
	 */
	public function __construct(
		$request
	) {
		$this->request = $request;
		$this->parameterize( $request->getPath() );
		$this->loadRoutes();
	}

	/*
	 * parameterize - split the request path into a parameter array
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.4
	 * @param string $path
	 */
	private function parameterize( $path )
	{
		$this->parameters = explode( '/', $path );
	}

	/*
	 * loadRoutes - load up the routes config file
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.4
	 */
	private function loadRoutes()
	{
		// load the file
		$filePath = __DIR__ . '/../../../../routes.yml';
		$fileContent = file_get_contents( $filePath );
		
		// load the routes
		$routes = [];
		$routes = Yaml::parse( $fileContent );

		// set the routes to the object variable
		$this->routes = $routes;
	}

	/*
	 * handle - handle the request based on the provided path and the routing configuration
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.4
	 * @return mixed a call to the specified controller function
	 */
	public function handle()
	{
		// get the request method
		$method = $this->request->getMethod();
		
		// get a match for the path in the routing file, if one exists
		$use = '';
		$use = $this->matchNextRoute();

		if( $use === false ) {
			// no route was found, so let's throw an error
			die('route not found');
		}

		// load the controller
		$parts = explode( '@', $use );
		$cName = 'App\\'.$parts[0];
		$fName = $parts[1];
		$controller = new $cName( $this->request );
		
		// return a call to the appropriate function
		return $controller->$fName();
	}

	/*
	 * matchNextRoute - recursive function for searching the routes array
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.4
	 * @return mixed false if it's not found, 'use' value if found
	 */
	public function matchNextRoute()
	{
		$match = true;
		
		// nothing left in the routes array, so return false
		if( count( $this->routes ) == 0 ) return false;

		// grab the first route, then remove it
		$name = '';
		$route = null;
		foreach( $this->routes as $k => $v ) {
			$name = $k;
			$route = $v;
			unset( $this->routes[$k] );
			break;
		}
		
		// explode the route into a path parameter array
		$pattern = explode( '/', $route['path'] );

		// if the count matches, the look for a more specific match
		if( count( $pattern ) == count( $this->parameters ) ) {
			foreach( $pattern as $i => $part ) {
				if( $this->parameters[ $i ] != $part ) {
					// something didn't match, so set match to false
					$match = false;
				}
			}
		} else {
			// count didn't match, so set match to false
			$match = false;
		}

		if( $match ) {
			// a match was found! return its use value
			return $route['use'];
		} else {
			// nothing found, and there's still routes left. call it again.
			return $this->matchNextRoute();
		}
	}

}