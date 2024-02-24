<?php
require __DIR__ . '/../vendor/autoload.php';
require 'config.php'; 

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$input = json_decode(file_get_contents("php://input"), true);

$email = $input['email'] ?? '';
$password = $input['password'] ?? '';

// Rate Limiting Logic
$rateLimitKey = "login_attempts:$email";
$attempts = $redisClient->get($rateLimitKey) ?: 0;

if ($attempts >= 5) {
    http_response_code(429);
    echo json_encode(['success' => false, 'message' => 'Too many login attempts. Please try again later.']);
    exit;
}

$collection = $db->users;
$user = $collection->findOne(['email' => $email]);

if ($user) {
    if (password_verify($password, $user['password'])) {
        $redisClient->del($rateLimitKey);

        unset($user['password']); 
        echo json_encode(['success' => true, 'user' => $user]);
    } else {
        $redisClient->setex($rateLimitKey, 300, $attempts + 1);
        echo json_encode(['success' => false, 'message' => 'The password is incorrect.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'User not found.']);
}
