<?php

namespace Homebrew/Core;

class Router {
	
	public function __construct(
		$request
	) {
		$this->url = $request->getPath();
	}

}