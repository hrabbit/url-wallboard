<?php

namespace Hpbx;

class Helper
{
	public function __construct()
	{
		if(!self::db_exists())
			self::init_database();
	}

	public function db_exists()
	{
		return file_exists(__DIR__.'/../hpbx.sqlite');
	}

	public function init_database()
	{
		\QB::query('CREATE TABLE IF NOT EXISTS users( id INTEGER PRIMARY KEY AUTOINCREMENT, user VARCHAR(30) UNIQUE, password VARCHAR(255))');
		\QB::query('INSERT OR IGNORE INTO users (user,password) VALUES ("admin", "5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg==")');
		\QB::query('CREATE TABLE IF NOT EXISTS options( id INTEGER PRIMARY KEY AUTOINCREMENT, key VARCHAR(30) UNIQUE, value VARCHAR(255), required BOLEAN default 0)');
		\QB::query('INSERT OR IGNORE INTO options (key,value,required) VALUES ("title", "My wallboard", 1)');
		\QB::query('INSERT OR IGNORE INTO options (key,value,required) VALUES ("widgets_per_row", "3", 1)');
		\QB::query('INSERT OR IGNORE INTO options (key,value,required) VALUES ("widget_font_size", "40", 1)');
		\QB::query('INSERT OR IGNORE INTO options (key,value,required) VALUES ("refresh_interval", "10", 1)');
		\QB::query('INSERT OR IGNORE INTO options (key,value,required) VALUES ("show_ip", "1", 1)');
		\QB::query('INSERT OR IGNORE INTO options (key,value,required) VALUES ("show_ip_timeout", "60", 1)');
		\QB::query('INSERT OR IGNORE INTO options (key,value,required) VALUES ("widget_background_color", "#000000", 1)');
		\QB::query('INSERT OR IGNORE INTO options (key,value,required) VALUES ("widget_forground_color", "#FFFFFF", 1)');
		\QB::query('INSERT OR IGNORE INTO options (key,value,required) VALUES ("threshold_wait_time", "60", 1)');
		\QB::query('INSERT OR IGNORE INTO options (key,value,required) VALUES ("threshold_calls_waiting", "3", 1)');
		\QB::query('CREATE TABLE IF NOT EXISTS widgets( id INTEGER PRIMARY KEY AUTOINCREMENT, url VARCHAR(255) UNIQUE)');
		\QB::query('CREATE TABLE IF NOT EXISTS pages( id INTEGER PRIMARY KEY AUTOINCREMENT, url VARCHAR(255) UNIQUE)');
	}

	// Return JSON response from URL
	function getWidget($url = string)
	{
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		try
		{
			$output = curl_exec($ch); 
		}
		catch(Exception $e)
		{
			print_r($e);
		}
		curl_close($ch);
		if(!self::isJson($output))
			return false;
		return json_decode($output, true);
	}

	private static function isJson($string) {
 		json_decode($string);
 		return (json_last_error() == JSON_ERROR_NONE);
	}
}