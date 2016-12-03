<?php

namespace Homebrew\Renderer;

use Twig_Loader_Filesystem;
use Twig_Environment;

class TemplateEngine {

	private $twig;

	public function __construct()
	{
		$filesystem = new Twig_Loader_Filesystem( __DIR__ . '/../../../../views');
		$this->twig = new Twig_Environment( $filesystem );
	}

	public function view( $name, $data )
	{
		$name = $name.'.html.twig';
		echo $this->twig->render( $name, $data );
	}
}