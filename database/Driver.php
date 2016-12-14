<?php

namespace Homebrew\Database;

use Illuminate\Database\Capsule\Manager as Capsule;

class Driver {

	public $capsule = null;

	public function __construct()
	{
		$capsule = new Capsule;
		$config = config('database');

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

		$capsule->setAsGlobal();
		$capsule->bootEloquent();

		$this->capsule = $capsule;
	}
}