<?php

namespace Homebrew\Core;

class Request {
	
	protected $addr 		= null;
	protected $protocol 	= null;
	protected $method 		= null;
	protected $time 		= null;
	protected $secure 		= null;
	protected $remote_addr 	= null;
	protected $remote_host 	= null;
	protected $path 		= null;
	protected $data 		= null;
	protected $cookies 		= null;

	public function __construct()
	{
		$this->loadServer();
		$this->loadData();
		$this->loadCookies();
	}

	private function loadServer()
	{
		$this->addr 		= $_SERVER['SERVER_ADDR'];
		$this->protocol 	= $_SERVER['SERVER_PROTOCOL'];
		$this->method 		= $_SERVER['REQUEST_METHOD'];
		$this->time 		= $_SERVER['REQUEST_TIME'];
		$this->secure 		= !empty( $_SERVER['HTTPS'] );
		$this->remote_addr 	= $_SERVER['REMOTE_ADDR'];
		$this->remote_host 	= ( !empty( $_SERVER['REMOTE_HOST'] ) ? $_SERVER['REMOTE_HOST'] : '' );
		$this->path 		= ( !empty( $_SERVER['PATH_INFO'] ) ? $_SERVER['PATH_INFO'] : $_SERVER['REQUEST_URI'] );

		if( $qPos = strpos( $this->path, '?' ) ) {
			$this->path = substr( $this->path, 0, $qPos );
		}
	}

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

	private function loadCookies()
	{
		$this->cookies = [];
		foreach( $_COOKIE as $k => $v ) {
			$this->cookies[ $k ] = $v;
		}
	}

	public function getPath()
	{
		return $this->path;
	}

	public function getMethod()
	{
		return $this->method;
	}

	public function get( $var )
	{
		foreach( $this->data as $k => $v ) {
			if( $k == $var ) return $v;
		}

		return null;
	}

	public function all()
	{
		return $this->data;
	}
}