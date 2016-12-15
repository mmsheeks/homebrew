<?php

namespace Homebrew\Database;

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Driver Class - establishes a database connection and starts the Eloquent ORM
 *
 * @author Martin Sheeks <martin.sheeks@gmail.com>
 * @version 1.0.4
 *
 */
class Driver {

	/*
	 * @var Capsule $capsule
	 */
	public $capsule = null;

	/*
	 * __construct - establish the database connection and boot the ORM
	 *
	 */
	public function __construct()
	{
		// create a new Eloquent capsule and load the database config
		$capsule = new Capsule;
		$config = config('database');

		// establish the connection
		$capsule->addConnection([
			'driver' 	=> 'mysql',
			'host'		=> $config['host'],
			'database'	=> $config['schema'],
			'username'	=> $config['user'],
			'password'	=> $config['pass'],
			'prefix' 	=> $config['prefix'],
			'charset'	=> 'utf8',
			'collation'	=> 'utf8_unicode_ci',
		]);

		// globalize the ORM
		$capsule->setAsGlobal();
		$capsule->bootEloquent();

		$this->capsule = $capsule;
	}
}