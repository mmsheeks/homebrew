<?php

namespace Homebrew\Renderer;

use Twig_Loader_Filesystem;
use Twig_Environment;
use Twig_SimpleFunction;

use Homebrew\Core\Request;
use Symfony\Component\Yaml\Yaml;

/**
 * TemplateEngine Class - Establishes a Twig environment and related functionality
 *
 * @author Martin Sheeks <martin.sheeks@gmail.com>
 * @version 1.0.4
 *
 */
class TemplateEngine {

	/*
	 * @var Twig_Environment $twig
	 */
	private $twig;

	/*
	 * __construct - establish the twig environment
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.4
	 */
	public function __construct()
	{
		// create a view filesystem at the "views" folder
		$filesystem = new Twig_Loader_Filesystem( __DIR__ . '/../../../../views');
		
		// establish the environment
		$this->twig = new Twig_Environment( $filesystem );
		$this->loadHelpers();
		
		// cement the Request
		$this->request = new Request;
	}

	/*
	 * view - echo out a rendered view
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.4
	 * @param string $name - the name of the template
	 * @param array $data - data to be passed to the view
	 */
	public function view( $name, $data )
	{
		$name = $name.'.html.twig';
		echo $this->twig->render( $name, $data );
	}

	/*
	 * loadHelpers - establishes the view helpers
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.4
	 */
	private function loadHelpers()
	{
		// asset helper function
		$assets = new Twig_SimpleFunction('asset', function( $name ) {
			
			// get the asset path
			$path = $this->request->getHost();
			if( $base_path = config('app.base_path') ) $path .= $base_path;
			$path .= '/assets/' . $name;
			
			// use HTTPS if it's available
			if( $this->request->secure() ) {
				return 'https://' . $path;
			} else {
				return 'http://' . $path;
			}
		});

		// add the asset helper function
		$this->twig->addFunction( $assets );
		
		// route helper function
		$routes = new Twig_SimpleFunction('route', function( $name ) {
			$filePath = __DIR__ . '/../../../../routes.yml';
			$arr = [];

			$arr = Yaml::parse( file_get_contents( $filePath ) );

			if( isset( $arr[ $name ] ) ) {
				$path = $arr[ $name ][ 'path' ];
			} else {
				die('route not found:' . $name );
			}
			
			// build the path with host
			$basePath = ( config( 'app.base_path' ) ? config( 'app.base_path') : '' );
			$path = $this->request->getHost() . $basePath . $path;
			
			if( $this->request->secure() ) {
				return 'https://' . $path;
			} else {
				return 'http://' . $path;
			}
		});

		// add the routes helper function
		$this->twig->addFunction( $routes );
	}
}