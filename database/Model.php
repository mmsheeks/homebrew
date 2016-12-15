<?php

namespace Homebrew\Database;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Model Class - A basic model to extend for Homebrew models, implements the Eloquent ORM
 *
 * @author Martin Sheeks <martin.sheeks@gmail.com>
 * @version 1.0.4
 *
 */
class Model extends Eloquent {

	/*
	 * __construct - call the parent construct when the model is instantiated, for safety
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.4
	 */
	public function __construct() {
		parent::__construct();
	}
	
	/*
	 * original - return the original array of values stored in the Database
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.4
	 * @return array The original database values
	 */
	public function original() {
		return $this->original;
	}

}