# Yohns\Core\Config

## [Config](docs/Config.md)
Base configuration class that stores the value from returning arrays in php files.
### Methods

| Name | Description |
|------|-------------|
|[__construct](docs/#config__construct)|Config constructor.|
|[get](docs/#configget)|Retrieves a configuration value.|
|[getAll](docs/#configgetall)|Retrieve all configuration values for file.|
|[getCustom](docs/#configgetcustom)|Retrieves a custom configuration value.|
|[reload](docs/#configreload)|Reloads configurations from a specified directory.|
|[set](docs/#configset)|Sets a configuration value.|

## [ConfigEditor](docs/ConfigEditor.md)
> [!TIP]
>  Add, Edit, and Create Configs
> * Create new config files (for new repos that may get added?),
> * Add new key => value pairs to a config file already found.
> * Edit values for predefined configs, you have
>   * You have to set the allow override option to true, default is false

### Methods

| Name | Description |
|------|-------------|
|[addToConfig](docs/#configeditoraddtoconfig)|Adds key-value pairs to a configuration array if they do not already exist in the specified configuration file. If the file does not exist, it creates a new configuration file with the provided data.|

---
---

Put all config files in 1 directory and then call that directory and it'll load all the config files to the variable

Check out the [Example File](Example.php)

Use composers autoload or include path to the Core/Config.php file

### Example using Config
```php
use Yohns\Core\Config;

include('vendor/autoload.php');

$dir = __DIR__.'/lib/Config';

// Initialize Config with a specific directory
new Config($dir);

// Get a configuration value
echo Config::get('users', 'db_tables').PHP_EOL;

// Set a custom configuration value
Config::set('api_key', '12345');

// Retrieve a custom configuration value
echo Config::getCustom('api_key').PHP_EOL;
```
### Example ConfigEditor
```php
use Yohns\Core\Config;
use Yohns\Core\ConfigEditor;

include('vendor/autoload.php');

$dir = __DIR__.'/lib/Config';

// Initialize Config with a specific directory
new Config($dir);

// Editor class allows us to append key=>values to the config files, or create a new config file if not found.
ConfigEditor::addToConfig(
	['add-new' => 'value'],
	'default',
	// only set to true if you want to "edit" the value if found in config file already.
	// default is false.
	true);
Config::reload($dir);

// get from the 'default' configs do not need to mention the file in get()
echo Config::get('add-new').PHP_EOL;
```

Example code uses the config/ directory found in this repo.

# config/default.php:

```php
<?php
return [
	'siteName' => 'Testing'
];
```
