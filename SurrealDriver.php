<?php

namespace MathisBurger\SurrealDb;

use Exception;
use WebSocket\BadOpcodeException;
use WebSocket\Client;

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

    public function login(string $username, string $password): void
    {
        $this->send('signin', [['user' => $username, 'pass' => $password]]);
    }

    public function useDatabase(string $namespace, string $database): void
    {
        $this->send('use', [$namespace, $database]);
    }

    public function create(string $thing, array $data): mixed
    {
        return $this->send('create', [$thing, $data])['result'];
    }

    public function select(string $what): mixed
    {
        return $this->send('select', [$what])['result'];
    }

    public function info(): mixed
    {
        return $this->send('info', [])['result'];
    }

    public function invalidate(): mixed
    {
        return $this->send('invalidate', [])['result'];
    }

    public function live(string $table): mixed
    {
        return $this->send('live', [$table])['result'];
    }

    public function kill(string $query): mixed
    {
        return $this->send('kill', [$query])['result'];
    }

    public function let(string $key, array $val): mixed
    {
        return $this->send('let', [$key, $val])['result'];
    }

    public function query(string $sql, array $vars): mixed
    {
        return $this->send('query', [$sql, $vars])['result'];
    }

    public function update(string $what, array $data): mixed
    {
        return $this->send('update', [$what, $data])['result'];
    }

    public function change(string $what, mixed $data): mixed
    {
        return $this->send('change', [$what, $data]);
    }

    public function delete(string $what): mixed
    {
        return $this->send('delete', [$what])['result'];
    }

    /**
     *
     * @param string $method
     * @param array $params
     * @return array
     * @throws BadOpcodeException
     * @throws Exception
     */
    private function send(string $method, array $params): array
    {
        $request = [
            'id' => strval(random_int(0, PHP_INT_MAX)),
            'async' => false,
            'method' =>  $method,
            'params' => $params
        ];
        $content = json_encode($request);
        $this->socket->send($content);
        while (true) {
            $response = $this->socket->receive();
            if ($response !== null) {
                return json_decode($response, true);
            }
        }
    }

}