<?php

use MathisBurger\SurrealDb\SurrealDriver;
use PHPUnit\Framework\TestCase;

class ActionTest extends TestCase
{
    /**
     * @test Tests connection to database server
     */
    public function testConnect(): void
    {
        $conn = new SurrealDriver('ws://127.0.0.1:8000/rpc');
        $conn->login('root', 'root');
        $this->assertTrue(true);
    }

}