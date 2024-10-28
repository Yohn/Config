# Yohns\Core\ConfigEditor  

Class ConfigEditor
Extends Yohns\Core\Config and allows editing of configuration arrays.

Currently, we cannot update values already found in the config file.
My intensions of this was when I add new features or repos, that repo could create the config files
it needed so the user could edit and change them easily.  



## Extend:

Yohns\Core\Config

## Methods

| Name | Description |
|------|-------------|
|[addToConfig](#configeditoraddtoconfig)|Adds key-value pairs to a configuration array if they do not already exist in the specified configuration file. If the file does not exist, it creates a new configuration file with the provided data.|

## Inherited methods

| Name | Description |
|------|-------------|
|__construct|Config constructor.|
|get|Retrieves a configuration value.|
|getAll|Retrieve all configuration values for file.|
|getCustom|Retrieves a custom configuration value.|
|reload|Reloads configurations from a specified directory.|
|set|Sets a configuration value.|



### ConfigEditor::addToConfig  

**Description**

```php
public static addToConfig (array $newData, string $configFile)
```

Adds key-value pairs to a configuration array if they do not already exist in the specified configuration file. If the file does not exist, it creates a new configuration file with the provided data. 

 

**Parameters**

* `(array) $newData`
: The associative array of key-value pairs to add to the config.  
* `(string) $configFile`
: The name of the config file (without the '.php' extension) to modify.  

**Return Values**

`mixed`




<hr />

