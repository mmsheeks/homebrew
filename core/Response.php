<?php

namespace Homebrew\Core;

use Homebrew\Renderer\TemplateEngine;

/**
 * Response Class - A utility class for response logic for the HTTP response to the server
 *
 * @author Martin Sheeks <martin.sheeks@gmail.com>
 * @version 1.0.4
 *
 */
class Response {

	/*
	 * view - a static function to return a template view
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.4
	 */
	public static function view( $name, $data = [] )
	{
		// load the template engine and output a view
		$engine = new TemplateEngine();
		$engine->view( $name, $data );
	}
}