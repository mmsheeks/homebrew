<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class Driver {

	public function __construct()
	{
		$capsule = new Capsule;

		$capsule->addConnection([
			'driver' 	=> 'sqlite',
			'database' 	=> __DIR__ .'database.sqlite',
			'prefix' 	=> ''
		]);

		$capsule->bootEloquent();
	}
}