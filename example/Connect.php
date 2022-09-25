<?php
include "./vendor/autoload.php";

use MathisBurger\SurrealDb\SurrealDriver;

$conn = new SurrealDriver("ws://127.0.0.1:8000/rpc");
$conn->login("root", "root");
$conn->useDatabase("test", "test");
