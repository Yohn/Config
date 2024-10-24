<?php

use Yohns\Core\Config;

include('vendor/autoload.php');

// Initialize Config with a specific directory
$config = new Yohns\Core\Config(__DIR__.'/config');

// Get a configuration value
echo Yohns\Core\Config::get('users', 'db_tables').PHP_EOL;

// Set a custom configuration value
Yohns\Core\Config::set('api_key', '12345');

// Retrieve a custom configuration value
echo Yohns\Core\Config::getCustom('api_key').PHP_EOL;

// Reload configurations from a different directory
//Yohns\Core\Config::reload('/new/path/to/config');