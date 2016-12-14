<?php

namespace Homebrew\Database;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent {

	public function __construct() {
		parent::__construct();
	}
	
	public function original() {
		return $this->original;
	}

}