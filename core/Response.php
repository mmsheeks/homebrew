<?php

namespace Homebrew\Core;

use Homebrew\Renderer\TemplateEngine;

class Response {

	public static function view( $name, $data = [] )
	{
		$engine = new TemplateEngine();
		$engine->view( $name, $data );
	}
}