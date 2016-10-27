# Class gateway from the laravel config

You can provide overriding of your classes via config file (a list of classes defined by config key - like custom Eloquent model). With this you can work with expected model but add a posibility to allow extending of your base classes.

In default tries to load classes from the `classes.php` config file.

## Example

Example config (`classes.php` in config folder):

```php
<?php

return [
	"user" => App\\Models\\User::class
];
``` 

### Call static method on class

```php
$userGate = ClassGate::gate("user");
$users = $userGate->all() // will call User::all()
```

or shortcut

```php
// will call User::all()
$users = ClassGate::gate("user")->all();
```

### Create instance

```php
$userGate = ClassGate::gate("user");
$user = $userGate->newInstance();
```

or shortcut

```php
$user = ClassGate::instance("user");
$user = $userGate->theClass();
```

### Class string:

```php
$userGate = ClassGate::gate("user");
```

or shortcut

```php
$userClass = ClassGate::objectClass("user");
```

## Settings

### Own config path

You can provide your own file or "array" path to the config via `ClassGate::setConfigPath("models.list")` which will find classes in `models` file and `list` array entry.

Example config (`models.php` in config folder):

```php
<?php

return [	
	"othersKeys" : "...",
	"list" => [
		"user" => App\\Models\\User::class
	]
];
``` 

## Todo

* Own provider with default config file (optional)
* Gate that will convert method call to config key and will create the correct `ClassGate` instance

### Gate proposal

* `Gate::user`
