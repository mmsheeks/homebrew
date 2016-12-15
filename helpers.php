<?php

// Helper functions

/*
 * config - function for easy access to config.yml values
 *
 * @author Martin Sheeks <martin.sheeks@gmail.com>
 * @version 1.0.4
 * @param string $variable - the variable to find, dot seperated
 */
function config( $variable ) {
	// explode the variable into an array fo keys
	$keys = explode( '.', $variable );
	
	// get the config array that was loaded in the Application construction
	global $app_config;
	$workingArr = $app_config;
	
	// loop the requested keys, proceeding down the chain untless we don't find a match
	foreach( $keys as $key ) {
		if( array_key_exists( $key, $workingArr ) ) {
			// match found, assign it and move on
			$workingArr = $workingArr[ $key ];
		} else {
			// no match found, return false
			return false;
		}
	}

	// return the value at the bottom level requested
	return $workingArr;
}