<?php

use MathisBurger\SurrealDb\SurrealDriver;
use PHPUnit\Framework\TestCase;

/**
 * Performs tests on multiple action methods
 */
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

    /**
     * @test Tests use of database and namespaces
     */
    public function testUseDatabase(): void
    {
        $conn = new SurrealDriver('ws://127.0.0.1:8000/rpc');
        $conn->login('root', 'root');
        $conn->useDatabase('test', 'test');
        $this->assertTrue(true);
    }

    /**
     * @test Tests creation of entities
     */
    public function testCreate(): void
    {
        $conn = new SurrealDriver('ws://127.0.0.1:8000/rpc');
        $conn->login('root', 'root');
        $conn->useDatabase('test', 'test');
        $conn->create('user', ['username' => 'user', 'password' => 'pw']);
        $this->assertTrue(true);
    }

    /**
     * @test Tests selection of entities
     */
    public function testSelect(): void
    {
        $conn = new SurrealDriver('ws://127.0.0.1:8000/rpc');
        $conn->login('root', 'root');
        $conn->useDatabase('test', 'test');
        $conn->create('user', ['username' => 'Mathis', 'password' => 'Test']);
        $conn->select('user');
        $this->assertTrue(true);
    }

}