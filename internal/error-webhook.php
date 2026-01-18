<?php
// internal/error-webhook.php

// Block direct access
if (php_sapi_name() !== 'cli' && empty($_SERVER['HTTP_X_INTERNAL_HOOK'])) {
    http_response_code(403);
    exit;
}

// Your REAL webhook URL (never exposed)
$webhookUrl = 'https://discord.com/api/webhooks/';

// Read payload
$payload = json_decode(file_get_contents('php://input'), true);

if (!$payload) {
    http_response_code(400);
    exit;
}

// Send webhook
$ch = curl_init($webhookUrl);
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
    CURLOPT_POSTFIELDS     => json_encode($payload),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 2,
]);

curl_exec($ch);
curl_close($ch);

http_response_code(204);
