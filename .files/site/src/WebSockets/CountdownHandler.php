<?php
namespace RetortRumble\WebSockets;
use Ratchet\ConnectionInterface;

class CountdownHandler extends AbstractSocketHandler {

    public $clients = null;

    protected $error = false;

    // in seconds
    protected $time = null;

    protected $timeLeft = null;

    protected $endTime = null;

    protected $debug = false;

    public function __construct(Int $time=120, Bool $debug=false)
    {
        $this->endTime = strtotime("now +{$time} seconds");
        $this->timeLeft = gmdate('i:s', $time);
        $this->debug = $debug;
        // Create a collection of clients
        $this->clients = new \SplObjectStorage;
    }

    /**
     * @see AbstractSocketHandler
     * Opens a new connection and then sends the client the current countdown time
     * @param  ConnectionInterface  $conn  Client opening WS
     * @return void
     */
    public function onOpen(ConnectionInterface $conn) {
        // New connection, send it the current set of matches
        $conn->send($this->timeLeft);
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        if ($this->debug) {
            echo $this->clients->count() . ' active clients: ' . PHP_EOL;
        }
    }

    /**
     * @see AbstractSocketHandler
     * Currently unused, may later be implamented to allow clients manipulate the countdown
     * @param  ConnectionInterface  $from  Client sending the message
     * @param  string (JSON)        $msg   [description]
     * @return void
     */
    public function onMessage(ConnectionInterface $from, $msg) {
        // parse message and go from there
    }

    /**
     * @see AbstractSocketHandler
     * @param  ConnectionInterface  $conn  Client closing WS connection
     * @return void
     */
    public function onClose(ConnectionInterface $conn)
    {
        if ($this->debug) {
            echo 'Closing connection: ' . $conn->resourceId . PHP_EOL;
            echo $this->clients->count() . ' remaining connection.' . PHP_EOL;
        }
        $this->clients->detach($conn);
    }

    /**
     * @see AbstractSocketHandler
     * @param  ConnectionInterface  $conn  Client triggering an exception
     * @param  \Exception           $e     exception
     * @return void                        prints the exception message
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->close();
        if ($this->debug) {
            echo 'ERROR:' . PHP_EOL;
            print_r($e->getMessage);
        }
    }

    /**
     * @see AbstractSocketHandler
     * decrament the timeLeft, by the diffrence between it and the current time
     * send's a JSON encoded array of data to be used client side
     * @return void
     */
    public function doAction()
    {
        if (time() >= $this->endTime) {
            $this->timeLeft = '00:00';
        } else {
            $this->timeLeft = gmdate('i:s', $this->endTime - time());
        }

        $message = json_encode([
            'id' => 'time',
            'data' => $this->timeLeft,
            'error' => $this->error,
        ]);

        // Loop through all subscribed clients and send them the message.
        foreach ($this->clients as $client) {
            $client->send($message);
        }
    }

    /**
     * resets the countdown based upon the initial input
     * @return void
     */
    public function reset()
    {
        $this->endTime = strtotime("now +{$time} minutes");
        $this->timeLeft = gmdate('i:s', $this->endTime - time());
    }
}