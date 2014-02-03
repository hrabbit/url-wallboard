<?php

// Configure default entries in database.
//QB::query('CREATE TABLE IF NOT EXISTS users( id INTEGER PRIMARY KEY AUTOINCREMENT, user VARCHAR(30) UNIQUE, role VARCHAR(30), password VARCHAR(255))');
QB::query('CREATE TABLE IF NOT EXISTS users( id INTEGER PRIMARY KEY AUTOINCREMENT, user VARCHAR(30) UNIQUE, role VARCHAR(30), password VARCHAR(255))');
QB::query('INSERT OR IGNORE INTO users (user,role,password) VALUES ("admin", "ROLE_ADMIN", "5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg==")');
QB::query('CREATE TABLE IF NOT EXISTS options( id INTEGER PRIMARY KEY AUTOINCREMENT, key VARCHAR(30) UNIQUE, value VARCHAR(255))');
QB::query('INSERT OR IGNORE INTO options (key,value) VALUES ("title", "My wallboard")');
QB::query('INSERT OR IGNORE INTO options (key,value) VALUES ("widgets_per_row", "3")');
QB::query('INSERT OR IGNORE INTO options (key,value) VALUES ("widget_font_size", "10")');
QB::query('INSERT OR IGNORE INTO options (key,value) VALUES ("refresh_period", "10")');
QB::query('CREATE TABLE IF NOT EXISTS widgets( id INTEGER PRIMARY KEY AUTOINCREMENT, title VARCHAR(30), url VARCHAR(255) UNIQUE)');

// Return JSON response from URL
/*
function getWidget($url = string)
{
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	try
	{
		$output = curl_exec($ch); 
	}
	// catch(Exception $e)
	catch
	{
		print_r $e;
	}
	curl_close($ch);
}
*/
