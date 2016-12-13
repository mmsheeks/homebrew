<?php

namespace Homebrew\Renderer;

use Twig_Loader_Filesystem;
use Twig_Environment;
use Twig_SimpleFunction;

use Homebrew\Core\Request;
use Symfony\Component\Yaml\Yaml;

class TemplateEngine {

	private $twig;

	public function __construct()
	{
		$filesystem = new Twig_Loader_Filesystem( __DIR__ . '/../../../../views');
		$this->twig = new Twig_Environment( $filesystem );
		$this->loadHelpers();
		$this->request = new Request;
	}

	public function view( $name, $data )
	{
		$name = $name.'.html.twig';
		echo $this->twig->render( $name, $data );
	}

	private function loadHelpers()
	{
		//asset helper function
		$assets = new Twig_SimpleFunction('asset', function( $name ) {
			$path = $this->request->getHost() . '/assets/' . $name;
			if( $this->request->secure() ) {
				return 'https://' . $path;
			} else {
				return 'http://' . $path;
			}
		});

		$this->twig->addFunction( $assets );
		
		//route helper function
		$routes = new Twig_SimpleFunction('route', function( $name ) {
			$filePath = __DIR__ . '/../../../../routes.yml';
			$arr = [];

			$arr = Yaml::parse( file_get_contents( $filePath ) );

			if( isset( $arr[ $name ] ) ) {
				$path = $arr[ $name ][ 'path' ];
			} else {
				//throw an error
			}

			$path = $this->request->getHost() . $path;
			if( $this->request->secure() ) {
				return 'https://' . $path;
			} else {
				return 'http://' . $path;
			}
		});

		$this->twig->addFunction( $routes );
	}
}