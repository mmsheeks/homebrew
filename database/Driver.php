<?php

namespace Homebrew\Database;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

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
	
	/**
	 * migrate - run new migrations from the migrate folder
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.5
	 * @param array $args the input args
	 */
	public function migrate( $args )
	{
		//load files in the migration directory
		$folder = __DIR__ . '/../../../../schema/';
		$pattern = $folder .'*.php';
		$migrations = glob( $pattern );
		
		//load migration classes
		$run = [];
		foreach( $migrations as $i => $migration ) {
			$start = strrpos( $migration, '/' ) + 1;
			$stop  = strrpos( $migration, '.' ) - $start;
			$name = "Schema\\" . substr( $migration, $start, $stop );
			
			$load = new $name;
			$run[ $name ] = $load;
		}
		
		//find or create migration table
		if( $this->capsule->schema()->hasTable('migrations') ) {
			$ran = $this->capsule->table('migrations')->get();
		} else {
			$this->capsule->schema()->create('migrations', function( Blueprint $t ) {
				$t->increments('id');
				$t->integer('batch');
				$t->string('migration');
			});
			
			$ran = $this->capsule->table('migrations')->get();
		}
		
		//get the new batch number
		$lastBatch = $this->capsule->table('migrations')->max('batch');
		$batch = $lastBatch+1;
		
		// remove migrations that have already run
		if( !empty( $ran ) ) {
			foreach( $ran as $previous ) {
				$name = $previous['migration'];
				if( key_exists( $name, $run ) ) {
					unset( $run[ $name ] );
				}
			}
		}
		
		if( !empty( $run ) ) {
			//run new migrations
			foreach( $run as $name => $migration ) {
				
				$migration->up();
				$this->capsule->table('migrations')->insert([
					'batch' => $batch,
					'migration' => $name
				]);
				print( 'Migrated ' . $name . '...' . "\n");
			}
		} else {
			print( "Nothing to update! \n" );
		}
	}
	
	
}