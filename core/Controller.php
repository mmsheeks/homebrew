<?php

namespace Homebrew\Core;

class Controller {

	protected $request;
	protected $input;

	public function __construct( $request )
	{
		$this->request = $request;
		$this->input = $request->all();
	}
	
}