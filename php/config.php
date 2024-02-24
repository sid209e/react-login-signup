<?php
require __DIR__ . '/../vendor/autoload.php';

$mongoHost = 'localhost'; 
$mongoPort = 27017;
$mongoDBName = 'user_management'; 
$mongoConnectionString = "mongodb://127.0.0.1:27017/?directConnection=true&serverSelectionTimeoutMS=2000&appName=mongosh+2.1.5";
$mongoClient = new MongoDB\Client($mongoConnectionString);
$db = $mongoClient->selectDatabase($mongoDBName);

/* if ($mongoClient) {
    echo "MongoDB connection successful!";
} else {
    echo "Failed to connect to MongoDB!";
}   */

// Redis configuration
$redisHost = '127.0.0.1';
$redisPort = 6379;
$redisScheme = 'tcp';

$redisClient = new Predis\Client([
    'scheme' => $redisScheme,
    'host'   => $redisHost,
    'port'   => $redisPort,
]);

/* try {
    $redisClient->ping();
    echo "Redis connection successful!";
} catch (Exception $e) {
    echo "Failed to connect to Redis: " . $e->getMessage();
} */

