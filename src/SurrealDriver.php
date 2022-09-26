<?php

namespace MathisBurger\SurrealDb;

use Exception;
use WebSocket\BadOpcodeException;
use WebSocket\Client;

/**
 * The main file of the surreal db driver.
 */
class SurrealDriver
{
    /**
     * @var Client The websocket client that is used for communication
     */
    private Client $socket;

    /**
     * @param string $url The url of the database
     */
    public function __construct(string $url)
    {
        $this->socket = new Client($url);
    }

    /**
     * Logs in a specific user into the database server.
     *
     * @param string $username The username of the user
     * @param string $password The password of the user
     *
     * @throws BadOpcodeException If the websocket connection failed
     */
    public function login(string $username, string $password): void
    {
        $this->send('signin', [['user' => $username, 'pass' => $password]]);
    }

    /**
     * Selects a specific namespace and database for the next requests.
     *
     * @param string $namespace The namespace
     * @param string $database  The database name
     *
     * @throws BadOpcodeException If the websocket connection failed
     */
    public function useDatabase(string $namespace, string $database): void
    {
        $this->send('use', [$namespace, $database]);
    }

    /**
     * Creates a specific thing in the database with the given data.
     *
     * @param string $thing The name of the thing in the database
     * @param array  $data  The data of the entity
     *
     * @return null The created entity as result
     *
     * @throws BadOpcodeException If the websocket connection failed
     */
    public function create(string $thing, array $data): array
    {
        return $this->send('create', [$thing, $data])['result'];
    }

    /**
     * Selects everything from a table.
     *
     * @param string $what What should be selected
     *
     * @return mixed The select results
     *
     * @throws BadOpcodeException If the websocket connection failed
     */
    public function select(string $what): array
    {
        return $this->send('select', [$what])['result'];
    }

    /**
     * Gets detailed information about the server.
     *
     * @return mixed The info of the server
     *
     * @throws BadOpcodeException If the websocket connection failed
     */
    public function info(): mixed
    {
        return $this->send('info', [])['result'];
    }

    /**
     * Invalidates something?
     *
     * @return mixed The response
     *
     * @throws BadOpcodeException If the websocket connection failed
     */
    public function invalidate(): mixed
    {
        return $this->send('invalidate', [])['result'];
    }

    /**
     * Sends live content of the database table.
     *
     * @param string $table The name of the table
     *
     * @return array The streamed content
     *
     * @throws BadOpcodeException If the websocket connection failed
     */
    public function live(string $table): array
    {
        return $this->send('live', [$table]);
    }

    /**
     * Kills a specific query.
     *
     * @param string $query The query that should be killed
     *
     * @return mixed The result
     *
     * @throws BadOpcodeException If the websocket connection failed
     */
    public function kill(string $query): mixed
    {
        return $this->send('kill', [$query])['result'];
    }

    /**
     * I do not know what this is doing.
     *
     * @param string $key The key of the let
     * @param array  $val The values
     *
     * @return mixed The result
     *
     * @throws BadOpcodeException If the websocket connection failed
     */
    public function let(string $key, array $val): mixed
    {
        return $this->send('let', [$key, $val])['result'];
    }

    /**
     * Sends a query to the database.
     *
     * @param string $sql  The query
     * @param array  $vars The variables of the query
     *
     * @return mixed The result of the query
     *
     * @throws BadOpcodeException If the websocket connection failed
     */
    public function query(string $sql, array $vars): mixed
    {
        return $this->send('query', [$sql, $vars])['result'];
    }

    /**
     * Updates a specific entry in the database.
     *
     * @param string $what What should be updated
     * @param array  $data The data that should be updated
     *
     * @return mixed The updated entity
     *
     * @throws BadOpcodeException If the websocket connection failed
     */
    public function update(string $what, array $data): mixed
    {
        return $this->send('update', [$what, $data])['result'];
    }

    /**
     * Changes a specific entry in the database.
     *
     * @param string $what What should be changed
     * @param mixed  $data The data that should be changed
     *
     * @return mixed The response of the change event
     *
     * @throws BadOpcodeException If the websocket connection failed
     */
    public function change(string $what, mixed $data): mixed
    {
        return $this->send('change', [$what, $data])['result'];
    }

    /**
     * Deletes everything of a specific type.
     *
     * @param string $what Specific type
     *
     * @return mixed The result of the request
     *
     * @throws BadOpcodeException If the websocket connection failed
     */
    public function delete(string $what): mixed
    {
        return $this->send('delete', [$what])['result'];
    }

    /**
     * @param string $method The method that should be performed
     * @param array  $params The parameters of the method
     *
     * @return array The response
     *
     * @throws BadOpcodeException Deletes everything of a specific type
     * @throws Exception          If a random integer cannot be found
     */
    private function send(string $method, array $params): array
    {
        $request = [
            'id' => strval(random_int(0, PHP_INT_MAX)),
            'async' => false,
            'method' => $method,
            'params' => $params,
        ];
        $content = json_encode($request);
        $this->socket->send($content);
        while (true) {
            $response = $this->socket->receive();
            if (null !== $response) {
                return json_decode($response, true);
            }
        }
    }
}
