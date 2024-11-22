<?php

namespace Yohns\Core;

use Yohns\Core\Config;
use RuntimeException;

/**
 * Class ConfigEditor
 * Extends Yohns\Core\Config and allows editing of configuration arrays.
 *
 * Currently, we cannot update values already found in the config file.
 * My intensions of this was when I add new features or repos, that repo could create the config files
 * it needed so the user could edit and change them easily.
 */
class ConfigEditor extends Config {

	private static array|null $config;
	private static bool $overwrite = false;

	/**
	 * Adds key-value pairs to a configuration array if they do not already exist
	 * in the specified configuration file. If the file does not exist, it creates
	 * a new configuration file with the provided data.
	 *
	 * @param array $newData The associative array of key-value pairs to add to the config.
	 * @param string $configFile The name of the config file (without the '.php' extension) to modify.
	 * @return void
	 */
	public static function addToConfig(array $newData, string $configFile, $overwrite = false): void {
		// Check if the specified configuration key exists in the parent config
		self::$config = parent::getAll($configFile);
		// removed ability to overwrite config because we get the same key multiple times.
		self::$overwrite = false; //$overwrite;
		if(self::$config === null){
			// so we can check for the existence of the key when we add $newData
			self::$config = [];
			return self::createNewConfig($configFile, $newData);
		} else {
			return self::appendData($newData, $configFile);
		}
	}

	/**
	 * Appends new key-value pairs to an existing configuration file.
	 * This function reads the current configuration from the file, ensures the
	 * correct formatting, and appends the new data.
	 *
	 * @param array $newData The key-value pairs to append.
	 * @param string $configFile The name of the config file (without the '.php' extension) to modify.
	 * @return void
	 * @throws RuntimeException If the file format is invalid.
	 */
	private static function appendData(array $newData, string $configFile): void {
		// Open the specified config file for reading
		$fileContent = trim(file_get_contents(parent::$configFilePaths[$configFile]));

		// Ensure the last line is ];
		if(!str_ends_with(trim($fileContent), '];')){
			throw new RuntimeException("File format invalid, does not end with ];");
		}
		// removed the ending ]; from  he file so we can add the new info
		// after [; gets removed, we trim the whitespace
		$trimmedContents = trim(trim($fileContent, '];'));
		if(!str_ends_with($trimmedContents, ',')){
			$trimmedContents .= ',';
		}
		$trimmedContents .= self::loopNewData($newData);
		$trimmedContents .= "\n];";
		// Write back to the file
		file_put_contents(parent::$configDirPath.'/'.$configFile.'.php', $trimmedContents);
	}

	/**
	 * Creates a new configuration file with the provided key-value pairs.
	 * If the file does not exist, it initializes the file with the new data
	 * in the correct array format.
	 *
	 * @param string $configFile The name of the config file (without the '.php' extension) to create.
	 * @param array $ary The key-value pairs to initialize in the new config file.
	 * @return void
	 */
	private static function createNewConfig(string $configFile, array $ary): void {
		$contents = "<?php\nreturn [";
		$contents .= self::loopNewData($ary);
		$contents .= "\n];";
		file_put_contents(parent::$configDirPath.'/'.$configFile.'.php', $contents);
	}

	/**
	 * Loops through an array of key-value pairs and formats them as string
	 * entries for a PHP array. Each key-value pair is transformed into a
	 * string representing a line in the PHP array format.
	 *
	 * @param array $ary The associative array of key-value pairs to format.
	 * @return string The formatted string of key-value pairs ready for inclusion in a PHP array.
	 */
	private static function loopNewData(array $ary): string {
		$contents = '';
		foreach($ary as $key => $value){
			if(!array_key_exists($key, self::$config) || self::$overwrite === true){
				$contents .= "\n\t'{$key}' => '{$value}',";
			}
		}
		return $contents;
	}
}
