<?php
use Yohns\Core\Config;

include('Core/Config.php');
// load directory
new Config(__DIR__.'/config');
//later when need variable
echo Config::get('siteName', 'c').PHP_EOL
	.Config::get('users', 'dt').PHP_EOL
	.Config::get('language', 'l');