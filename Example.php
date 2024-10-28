<?php

use Yohns\Core\Config;
use Yohns\Core\ConfigEditor;

include('vendor/autoload.php');

$dir = __DIR__.'/lib/Config';

// Initialize Config with a specific directory
$config = new Config($dir);

// Get a configuration value
echo Config::get('users', 'db_tables').PHP_EOL;

// Set a custom configuration value
Config::set('api_key', '12345');

// Retrieve a custom configuration value
echo Config::getCustom('api_key').PHP_EOL;

// Reload configurations from a different directory
//Yohns\Core\Config::reload('/new/path/to/config');

ConfigEditor::addToConfig(['add-new' => 'value'], 'default', true);
Config::reload($dir);

// get from the 'default' configs do not need to mention the file in get()
echo Config::get('add-new').PHP_EOL;