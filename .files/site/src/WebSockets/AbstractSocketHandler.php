<?php
namespace RetortRumble\WebSockets;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

abstract class AbstractSocketHandler implements MessageComponentInterface {

    public $clients;

    protected $error = false;

    public function __construct()
    {
        // Create a collection of clients
        $this->clients = new \SplObjectStorage;
    }

    /**
     * Open and setup a new WS connection
     * @param  ConnectionInterface  $conn  Client opening WS
     * @return void
     */
    abstract public function onOpen(ConnectionInterface $conn);

    /**
     * Handle the recipte and distribution of a WS message
     * @param  ConnectionInterface  $from  Client sending the message
     * @param  string (JSON)        $msg   [description]
     * @return void
     */
    abstract public function onMessage(ConnectionInterface $from, $msg);

    /**
     * Handle the closing of a WS connection
     * @param  ConnectionInterface  $conn  Client closing WS connection
     * @return void
     */
    abstract public function onClose(ConnectionInterface $conn);

    /**
     * If/When a WS client triggers an exception, handle it an appopriate manner
     * @param  ConnectionInterface  $conn  Client triggering an exception
     * @param  \Exception           $e     exception
     * @return void
     */
    abstract public function onError(ConnectionInterface $conn, \Exception $e);

    /**
     * preform the dedicated websocket action
     */
    abstract public function doAction();
}