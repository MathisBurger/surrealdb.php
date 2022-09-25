<?php

use MathisBurger\SurrealDb\SurrealDriver;
use PHPUnit\Framework\TestCase;

class ActionTests extends TestCase
{
    public function testConnect(): void
    {
        $conn = new SurrealDriver('ws://surrealdb:8000/rpc');
        $conn->login('root', 'root');
        $this->assertTrue(true);
    }

}