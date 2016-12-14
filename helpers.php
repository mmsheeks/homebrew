<?php

// Helper functions

function config( $variable ) {
	$keys = explode( '.', $variable );
	
	global $app_config;
	$workingArr = $app_config;
	foreach( $keys as $key ) {
		if( array_key_exists( $key, $workingArr ) ) {
			$workingArr = $workingArr[ $key ];
		} else {
			return false;
		}
	}

	return $workingArr;
}