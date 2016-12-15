<?php

namespace Homebrew\Core;

use Homebrew\Core\Response;

/**
 * Controller Class - The controller class is what all controllers should be extended from
 *
 * @author Martin Sheeks <martin.sheeks@gmail.com>
 * @version 1.0.4
 *
 */
class Controller {

	/*
	 * @var Request $request
	 */
	protected $request;
	
	/*
	 * @var array $input
	 */
	protected $input;

	/*
	 * __construct - establish the controller class, expose the request
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.4
	 * @param Request $request the request object
	 */
	public function __construct( $request )
	{
		$this->request = $request;
		$this->input = $request->all();
	}
	
	/*
	 * view - return a rendered view to the browser
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.4
	 * @param string $name the name of the template
	 * @param array $data the data to be passed to the view - optional
	 */
	protected function view( $name, $data = [] )
	{
		return Response::view( $name, $data );		
	}
	
}