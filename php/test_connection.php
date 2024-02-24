<?php
require __DIR__ . '/config.php';

$userData = [
    'username' => 'john_doe',
    'email' => 'john@example.com',
    'password' => 'hashed_password',
    'age' => 30,
    'dob' => '1992-01-01',
    'contact' => '+1234567890'
];

try {
    $insertResult = $db->users->insertOne($userData);
    echo 'Test data inserted successfully!';
} catch (Exception $e) {
    echo 'Failed to insert test data: ' . $e->getMessage();
}
