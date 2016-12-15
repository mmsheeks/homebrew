<?php

namespace Homebrew\Core;

/**
 * Request Class - A utility class for making the HTTP request more accessible inside our framework
 *
 * @author Martin Sheeks <martin.sheeks@gmail.com>
 * @version 1.0.4
 *
 */
class Request {
	
	/*
	 * @var string $addr
	 */
	protected $addr 		= null;
	
	/*
	 * @var string $protocol
	 */
	protected $protocol 	= null;
	
	/*
	 * @var string $method
	 */
	protected $method 		= null;
	
	/*
	 * @var string $time
	 */
	protected $time 		= null;
	
	/*
	 * @var boolean $secure
	 */
	protected $secure 		= null;
	
	/*
	 * @var string $remote_addr
	 */
	protected $remote_addr 	= null;
	
	/*
	 * @var string $host
	 */
	protected $host 		= null;
	
	/*
	 * @var string $remote_host
	 */
	protected $remote_host 	= null;
	
	/*
	 * @var string $path
	 */
	protected $path 		= null;
	
	/*
	 * @var array $data
	 */
	protected $data 		= null;
	
	/*
	 * @var array $cookies
	 */
	protected $cookies 		= null;

	/*
	 * __construct - establish the request object
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.4
	 */
	public function __construct()
	{
		$this->loadServer();
		$this->loadData();
		$this->loadCookies();
	}

	/*
	 * loadServer - loads values from the $_SERVER context
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.4
	 */
	private function loadServer()
	{
		// load all the general $_SERVER data
		$this->addr 		= $_SERVER['SERVER_ADDR'];
		$this->protocol 	= $_SERVER['SERVER_PROTOCOL'];
		$this->method 		= $_SERVER['REQUEST_METHOD'];
		$this->time 		= $_SERVER['REQUEST_TIME'];
		$this->secure 		= !empty( $_SERVER['HTTPS'] );
		$this->remote_addr 	= $_SERVER['REMOTE_ADDR'];
		$this->host 		= $_SERVER['HTTP_HOST'];
		$this->remote_host 	= ( !empty( $_SERVER['REMOTE_HOST'] ) ? $_SERVER['REMOTE_HOST'] : '' );
		
		// determine the path
		$path = ( !empty( $_SERVER['PATH_INFO'] ) ? $_SERVER['PATH_INFO'] : $_SERVER['REQUEST_URI'] );
		if( $base_url = config('app.base_path') ) {
			$this->path = str_replace( $base_url, '', $path );
		} else {
			$this->path = $path;
		}
		
		// remove any GET values from the path string
		if( $qPos = strpos( $this->path, '?' ) ) {
			$this->path = substr( $this->path, 0, $qPos );
		}
	}

	/*
	 * loadData - load the $_GET and $_POST data into the data array
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.4
	 */
	private function loadData()
	{
		$this->data = [];
		foreach( $_GET as $k => $v ) {
			$this->data[ $k ] = $v;
		}
		foreach( $_POST as $k => $v ) {
			$this->data[ $k ] = $v;
		}
	}

	/*
	 * loadCookies - load $_COOKIE values into the cookies array
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.4
	 */
	private function loadCookies()
	{
		$this->cookies = [];
		foreach( $_COOKIE as $k => $v ) {
			$this->cookies[ $k ] = $v;
		}
	}

	/*
	 * getPath - return the path
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.4
	 * @return string $path
	 */
	public function getPath()
	{
		return $this->path;
	}

	/*
	 * getMethod - return request method
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.4
	 * @return string $method
	 */
	public function getMethod()
	{
		return $this->method;
	}

	/*
	 * getHost - return the host string
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.4
	 * @return string $host
	 */
	public function getHost()
	{
		return $this->host;
	}

	/*
	 * secure - return true / false for secure connection
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.4
	 * @return boolean $secure;
	 */
	public function secure()
	{
		return $this->secure;
	}

	/*
	 * get - return a specific request input value
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.4
	 * @param string $var the name of the variable to search for
	 * @return mixed the variable, if available, or null
	 */
	public function get( $var )
	{
		foreach( $this->data as $k => $v ) {
			if( $k == $var ) return $v;
		}

		return null;
	}

	/*
	 * all - get all input data
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.4
	 * @return array the input data
	 */
	public function all()
	{
		return $this->data;
	}
}