<?php
namespace Yohns\Core;

/**
 * Class Config
 *
 * This class manages site configurations. It loads configuration files from a specified directory
 * and provides static methods to get and set configuration values.
 */
class Config {
	/**
	 * @var array $c Stores the site configurations.
	 */
	private static $c = []; // sites configs

	/**
	 * Config constructor.
	 *
	 * This constructor loads configuration files from the specified directory.
	 * The configuration files are expected to be PHP files. The filenames are processed
	 * to generate a unique key used to store the configuration in the `$c` array.
	 *
	 * @param string $directory Path to the directory containing configuration files.
	 */
	public function __construct(string $directory = __DIR__ . '/../../../../lib/config') {
		if (!is_dir($directory) || !is_readable($directory)) {
			throw new InvalidArgumentException("Directory does not exist or is not readable: $directory");
		}
		foreach (glob($directory."/*.php") as $filename){
			$key = $this->makeKey($filename);
			self::$c[$key] = include $filename;
		}
	}

	/**
   * Generate a configuration key based on the filename.
   *
   * @param string $filename The full path to the configuration file.
   * @return string The generated configuration key.
   */
	private function makeKey(string $filename): string {
		$file = basename($filename);
		$parts = explode('_', $file);
		//$config_str = implode('', array_map(fn($part) => substr($part, 0, 1), $parts));
		$config_str = '';
		foreach ($parts as $v) {
			$config_str .= substr($v, 0, 1);
		}
		return strtolower($config_str);
	}

	/**
	 * Retrieves a configuration value.
	 *
	 * This method fetches a value from the configuration array based on the provided key.
	 *
	 * @param string $key The key of the configuration item to retrieve.
	 * @param string $file The configuration group to retrieve the item from. Default is 'c'.
	 * @return mixed The configuration value, or `false` if the key does not exist.
	 */
	public static function get(string $key, string $file = 'c'): mixed {
		return self::$c[strtolower($file)][$key] ?? false;
	}

		/**
	 * Retrieves a configuration value.
	 *
	 * This method fetches a value from the configuration array based on the provided key.
	 *
	 * @param string $key The key of the configuration item to retrieve.
	 * @return mixed The configuration value, or `false` if the key does not exist.
	 */
	public static function getCustom(string $key): mixed {
		return self::$c['inline'][$key] ?? false;
	}

	/**
	 * Sets a configuration value.
	 *
	 * This method sets a value in the configuration array for the specified key.
	 *
	 * @param string $key The key of the configuration item to set.
	 * @param mixed $value The value to set for the specified key.
	 * @param string $file The configuration group to set the item in. Default is 'inline'.
	 * @return bool Returns `true` after the value is set.
	 */
	public static function set(string $key, mixed $value, string $file = 'inline'): void {
		self::$c[$file][$key] = $value;
	}
}
