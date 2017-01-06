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
/*
 * session - helper function for getting or setting session values
 *
 * @author Martin Sheeks <martin.sheeks@gmail.com>
 * @version 1.0.5
 * @param string $key - The session variable we're trying to get or set
 * @param string $val - (optional) The value to set to the provided key
 */
function session( $key, $val = '' )
{
	// if we passed in a value, set that value to the session. easy peesy.
	if( $val != '' ) {
		$_SESSION[ $key ] = $val;
		return $val;
	}
	// see if the session has what they're looking for
	if( isset( $_SESSION[ $key ] ) ) {
		// if so, return it
		return $_SESSION[ $key ];
	} else {
		// nope, false.
		return false;
	}
}