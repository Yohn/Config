# Yohns\Core\Config

Put all config files in 1 directory and then call that directory and it'll load all the config files to the variable

Use composers autoload or include path to the Core/Config.php file

```php
use Yohns\Core\Config;

// load directory
new Config(__DIR__.'/config');
//later when need variable
echo Config::get('siteName', 'c').PHP_EOL
	.Config::get('users', 'dt').PHP_EOL
	.Config::get('language', 'l');
```
Example code uses the config/ directory found in this repo.

The c parameter is the first letter of the config files found in the `config` dircetory.
You can see I have `db_tables.php`, because of the _ it will add the first letter of the second word to the key making the second parameter be `'dt'` for data_tables.


# config/config.php:

```php
<?php
return [
	'siteName' => 'Testing'
];
```