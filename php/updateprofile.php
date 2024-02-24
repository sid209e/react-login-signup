<?php
require __DIR__ . '/../vendor/autoload.php'; 
require 'config.php'; 

header('Access-Control-Allow-Origin: http://localhost:3000'); 
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS'); 
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true'); 


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['email'])) {
    http_response_code(400); 
    echo json_encode(['success' => false, 'message' => 'Email is required.']);
    exit;
}

$updateFields = [];
if (isset($data['username'])) $updateFields['username'] = $data['username'];
if (isset($data['age'])) $updateFields['age'] = $data['age'];
if (isset($data['dob'])) $updateFields['dob'] = $data['dob'];

if (empty($updateFields)) {
    http_response_code(400); 
    echo json_encode(['success' => false, 'message' => 'No updateable fields provided.']);
    exit;
}

$collection = $db->users; 

$result = $collection->updateOne(
    ['email' => $data['email']],
    ['$set' => $updateFields]
);

if ($result->getModifiedCount() == 0) {
    echo json_encode(['success' => false, 'message' => 'User not found or data unchanged.']);
} else {
    echo json_encode(['success' => true, 'message' => 'Profile updated successfully.']);
}
