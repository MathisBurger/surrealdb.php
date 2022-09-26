# SurrealDb.php

SurrealDb.php is a driver written in php for the surrealDb database. It supports some 
basic features that can be used to perform actions on the database.
It uses the websocket API of the database.

# Installation

Installation is quite easy with
```shell
composer require mathisburger/surrealdb
```

# Usage

Just require the package via composer and follow the following guide how to create
a new entry in the database:

```php

// Only needed for plain PHP scripts that do not use a framework like symfony
include './vendor/autoload.php';

use MathisBurger\SurrealDb\SurrealDriver;

$conn = new SurrealDriver('ws://127.0.0.1:8000/rpc');
$conn->login('root', 'root');
$conn->useDatabase('test', 'test');
$conn->create('user', ['username' => 'Mathis', 'password' => 'Test']);
```

# License 

This project is MIT licensed.
