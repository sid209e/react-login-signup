<?php
require __DIR__ . '/../vendor/autoload.php'; // Adjust the path to your autoload.php file if necessary

// Connecting to Redis
$client = new Predis\Client([
    'scheme' => 'tcp',
    'host'   => '127.0.0.1',
    'port'   => 6379,
]);

try {
    // Testing the connection
    echo "Successfully connected to Redis: " . $client->ping() . "\n";

    // Setting a value
    $client->set('testKey', 'Hello, Redis!');

    // Getting the value back
    echo "Value of testKey: " . $client->get('testKey') . "\n";

} catch (Exception $e) {
    echo "Could not connect to Redis: " . $e->getMessage();
}
