<?php

namespace MathisBurger\SurrealDb;

use WebSocket\BadOpcodeException;
use WebSocket\Client;
use WebSocket\Message\Message;

/**
 * The main file of the surreal db driver
 */
class SurrealDriver
{

    private Client $socket;

    public function __construct(
        string $url
    ) {
        $this->socket = new Client($url);
    }

    public function login(string $username, string $password): void {
        $this->send("signin", ['user' => $username, 'pass' => $password]);
    }

    public function useDatabase(string $namespace, string $database): array {
        return $this->send('use', ['ns' => $namespace, 'db' => $database]);
    }

    /**
     * @throws BadOpcodeException
     * @throws \Exception
     */
    private function send(string $method, array $params): array
    {
        $request = [
            'id' => strval(random_int(0, PHP_INT_MAX)),
            'async' => false,
            'method' =>  $method,
            'params' => [$params]
        ];
        $content = json_encode($request);
        $this->socket->send($content);
        while (true) {
            $response = $this->socket->receive();
            if ($response !== null) {
                echo $response;
                return json_decode($response, true);
            }
        }
    }

}