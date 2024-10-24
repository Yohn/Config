# Yohns\Core\Config

Put all config files in 1 directory and then call that directory and it'll load all the config files to the variable

Use composers autoload or include path to the Core/Config.php file

```php
use Yohns\Core\Config;

// Initialize Config with a specific directory
$config = new Config(__DIR__.'/config');

// Get a configuration value
echo Config::get('users', 'db_tables').PHP_EOL;

// Set a custom configuration value
Config::set('api_key', '12345');
// Retrieve a custom configuration value
echo Config::getCustom('api_key').PHP_EOL;

// Reload configurations from a different directory
Config::reload('/new/path/to/config');
```

Example code uses the config/ directory found in this repo.

# config/config.php:

```php
<?php
return [
	'siteName' => 'Testing'
];
```