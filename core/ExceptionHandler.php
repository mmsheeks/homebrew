<?php

namespace Homebrew\Core;

use Homebrew\Core\Response;

/**
 * ExceptionHandler Class - Implements a custom error handler for Homebrew
 *
 * @author Martin Sheeks <martin.sheeks@gmail.com>
 * @version 1.0.4
 *
 */
class ExceptionHandler {

	/*
	 * __construct - Establish the custom handler
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.4
	 */
	public function __construct()
	{
        // set the error handler
		set_error_handler( [ $this, 'inform' ] );
	}
	
	/*
	 * inform - outputs a page with error info and a stack trace
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.4
	 * @param string $number - the error number
	 * @param string $string - the error string
	 * @param string $file - the file the error occurred in
	 * @param string $line - the line the error occurred on
	 * @param array $context - the context for the error
	 */
	public static function inform( $number, $string, $file, $line, $context ) {
        //output the error
        echo "<h1>Uncaught Exception</h1>";
        echo "<h2> [" . $number . "] " . $string . "</h2>";
        
        // dump a stack trace
        $trace = debug_backtrace();
        echo "<ul>";
        foreach( $trace as $call ) {
            echo "<li> [" . $call['class'] . "@" . $call['function'] ." ]: " . $call['file'] . " (" . $call['line'] . ")</li>";
        }
        echo "</ul>";
        
        die();
    }
	
}