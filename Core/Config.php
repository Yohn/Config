<?php

namespace Yohns\Core;

/**
 * Config class for managing application configurations.
 *
 * Examples:
 *
 * // Initialize Config with a specific directory
 * $config = new Yohns\Core\Config(__DIR__.'/../config');
 * // Get a configuration value
 * $dbHost = Yohns\Core\Config::get('db_host', 'database');
 * // Set a custom configuration value
 * Yohns\Core\Config::set('api_key', '12345');
 * // Retrieve a custom configuration value
 * $apiKey = Yohns\Core\Config::getCustom('api_key');
 * // Reload configurations from a different directory
 * Yohns\Core\Config::reload('/new/path/to/config');
 */
class Config {

	/**
	 * @var array Stores loaded configurations
	 */
	private static array $configs = [];

	/**
	 * Config constructor.
	 *
	 * @param string $directory Path to the directory containing configuration files.
	 * @throws \InvalidArgumentException if the directory does not exist or is not readable.
	 */
	public function __construct(string $directory = __DIR__ . '/../../../../lib/config') {
		if (!is_dir($directory) || !is_readable($directory)) {
			throw new \InvalidArgumentException("Directory does not exist or is not readable: $directory");
		}

		$this->loadConfigurations($directory);
	}

	/**
	 * Loads configuration files from a specified directory.
	 *
	 * @param string $directory Directory path where configuration files are stored.
	 */
	private function loadConfigurations(string $directory): void {
		foreach (glob($directory . "/*.php") as $filename) {
			$key = $this->makeKey($filename);
			self::$configs[$key] = include $filename;
		}
	}

	/**
	 * Generates a configuration key based on filename.
	 *
	 * @param string $filename Name of the file.
	 * @return string Key generated from the filename.
	 */
	private function makeKey(string $filename): string {
		return strtolower(pathinfo($filename, PATHINFO_FILENAME));
	}

	/**
	 * Retrieves a configuration value.
	 *
	 * @param string $key The key of the configuration to retrieve.
	 * @param string $configFile The configuration file identifier.
	 * @return mixed The value of the configuration, or null if not found.
	 */
	public static function get(string $key, string $configFile = 'default'): mixed {
		$configFile = strtolower($configFile);
		return self::$configs[$configFile][$key] ?? null;
	}

	/**
	 * Sets a configuration value.
	 *
	 * @param string $key The key of the configuration to set.
	 * @param mixed $value The value to assign to the configuration.
	 * @param string $configFile The configuration file identifier.
	 */
	public static function set(string $key, mixed $value, string $configFile = 'inline'): void {
		self::$configs[$configFile][$key] = $value;
	}

	/**
	 * Retrieves a custom configuration value.
	 *
	 * @param string $key The key of the custom configuration to retrieve.
	 * @return mixed The value of the custom configuration, or null if not found.
	 */
	public static function getCustom(string $key): mixed {
		return self::$configs['inline'][$key] ?? null;
	}

	/**
	 * Reloads configurations from a specified directory.
	 *
	 * @param string $directory Directory path to reload configuration files from.
	 */
	public static function reload(string $directory): void {
		self::$configs = [];
		(new self($directory));
	}
}