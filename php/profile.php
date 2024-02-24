<?php
require __DIR__ . '/../vendor/autoload.php'; 
require 'config.php'; 

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: GET, POST'); 
header('Access-Control-Allow-Headers: Content-Type, Authorization');

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['email']) || empty($input['email'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Email is required.']);
    exit;
}

$email = $input['email'];
$collection = $db->users;
$user = $collection->findOne(['email' => $email]);

if ($user) {
    unset($user['password']);

    $userArray = json_decode(json_encode($user), true);

    echo json_encode(['success' => true, 'user' => $userArray]);
} else {
    http_response_code(404); 
    echo json_encode(['success' => false, 'message' => 'User not found.']);
}

