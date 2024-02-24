<?php
require __DIR__ . '/../vendor/autoload.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/config.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['username'], $data['email'], $data['password'], $data['age'], $data['dob']) || empty($data['username']) || empty($data['email']) || empty($data['password']) || empty($data['age']) || empty($data['dob'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

if (!isset($data['password'])) {
    echo json_encode(['success' => false, 'message' => 'Password is not set']);
    exit;
}
$username = $data['username'];
$email = $data['email'];
$password = $data['password'];
$age = $data['age'];
$dob = $data['dob'];


$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$collection = $db->users;

$emailExists = $collection->countDocuments(['email' => $email]);

if ($emailExists > 0) {
    echo json_encode(['success' => false, 'message' => 'Email already exists']);
    exit;
}

try {
    $insertResult = $collection->insertOne([
        'username' => $username,
        'email' => $email,
        'password' => $hashedPassword,
        'age' => $age,
        'dob' => $dob
    ]);

    if ($insertResult->getInsertedCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to register user']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'An error occurred during registration']);
}

