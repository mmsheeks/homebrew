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
		$this->remote_host 	= $_SERVER['REMOTE_HOST'];
		$this->path 		= $_SERVER['PATH_INFO'];
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
}