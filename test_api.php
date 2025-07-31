<?php

// Simple API test script
$baseUrl = 'http://localhost:8000/api';

echo "=== Laravel Posts API Test ===\n\n";

// Test 1: Register a new user
echo "1. Testing user registration...\n";
$registerData = [
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => 'password123',
    'password_confirmation' => 'password123'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/register');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($registerData));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Status Code: $httpCode\n";
echo "Response: " . $response . "\n\n";

$registerResult = json_decode($response, true);
$token = $registerResult['token'] ?? null;

if (!$token) {
    echo "Failed to get token. Exiting.\n";
    exit(1);
}

// Test 2: Create a post
echo "2. Testing post creation...\n";
$postData = [
    'title' => 'Test Post',
    'content' => 'This is a test post created via API.'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/posts');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Status Code: $httpCode\n";
echo "Response: " . $response . "\n\n";

$postResult = json_decode($response, true);
$postId = $postResult['data']['id'] ?? null;

// Test 3: Get all posts
echo "3. Testing get all posts...\n";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/posts');
curl_setopt($ch, CURLOPT_HTTPGET, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Status Code: $httpCode\n";
echo "Response: " . $response . "\n\n";

// Test 4: Get specific post
if ($postId) {
    echo "4. Testing get specific post...\n";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $baseUrl . '/posts/' . $postId);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    echo "Status Code: $httpCode\n";
    echo "Response: " . $response . "\n\n";
}

// Test 5: Update post
if ($postId) {
    echo "5. Testing post update...\n";
    $updateData = [
        'title' => 'Updated Test Post',
        'content' => 'This post has been updated via API.'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $baseUrl . '/posts/' . $postId);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $updateData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    echo "Status Code: $httpCode\n";
    echo "Response: " . $response . "\n\n";
}

// Test 5.5: Update post with image removal
if ($postId) {
    echo "5.5. Testing post update with image removal...\n";
    $updateData = [
        'title' => 'Updated Test Post No Image',
        'content' => 'This post has been updated and image removed via API.',
        'remove_image' => 'true'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $baseUrl . '/posts/' . $postId);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $updateData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    echo "Status Code: $httpCode\n";
    echo "Response: " . $response . "\n\n";
}

// Test 6: Delete post
if ($postId) {
    echo "6. Testing post deletion...\n";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $baseUrl . '/posts/' . $postId);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    echo "Status Code: $httpCode\n";
    echo "Response: " . $response . "\n\n";
}

// Test 7: Logout
echo "7. Testing logout...\n";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/logout');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Status Code: $httpCode\n";
echo "Response: " . $response . "\n\n";

echo "=== API Test Complete ===\n"; 