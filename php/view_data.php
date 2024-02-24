<?php
require __DIR__ . '/config.php';

try {
    $cursor = $db->users->find();

    foreach ($cursor as $document) {
        echo 'Username: ' . $document['username'] . '<br>';
        echo 'Email: ' . $document['email'] . '<br>';
        echo 'Age: ' . $document['age'] . '<br>';
        echo 'DOB: ' . $document['dob'] . '<br>';
        echo '<br>';
    }
} catch (Exception $e) {
    echo 'Failed to fetch data: ' . $e->getMessage();
}

