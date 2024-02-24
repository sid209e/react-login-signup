<?php
require __DIR__ . '/../vendor/autoload.php'; 
require 'config.php'; 

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Only POST requests are allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['currentPassword']) || !isset($data['newPassword'])) {
    echo json_encode(['success' => false, 'message' => 'Current and new password are required.']);
    exit;
}

$userEmail = 'user@example.com';

$collection = $db->users; 
$user = $collection->findOne(['email' => $userEmail]);

if (!$user) {
    echo json_encode(['success' => false, 'message' => 'User not found.']);
    exit;
}

if (!password_verify($data['currentPassword'], $user['password'])) {
    echo json_encode(['success' => false, 'message' => 'Current password is incorrect.']);
    exit;
}

$newPasswordHash = password_hash($data['newPassword'], PASSWORD_DEFAULT);
$updateResult = $collection->updateOne(
    ['email' => $userEmail],
    ['$set' => ['password' => $newPasswordHash]]
);

if ($updateResult->getModifiedCount() == 0) {
    echo json_encode(['success' => false, 'message' => 'Failed to update password.']);
} else {
    echo json_encode(['success' => true, 'message' => 'Password updated successfully.']);
}

