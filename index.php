<?php

// Display all error, for easy troubleshooting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Capture the URI and return OK
$uri = parse_url($_SERVER['REQUEST_URI']);
if ($uri['path'] == '/') {
    echo "Tracking domain is ready";
    exit();
}

// Decode URL
function base64UrlDecode($string)
{
    if (is_null($string)) {
        return null;
    }

    return base64_decode(str_replace(['-','_'], ['+','/'], $string));
}

// Get the actual url
$trackingUrl = trim($uri['path'], '/');

// Test endpoint
if ($trackingUrl == 'ok') {
    echo "ok";
    exit();
}

// Redirect

if ($_GET['debug']) {
    echo "Before decoded: {$trackingUrl}";
}

$trackingUrl = base64UrlDecode($trackingUrl);

if ($_GET['debug']) {
    echo "<br>After decoded: {$trackingUrl}";
    exit();
}

header("Location: {$trackingUrl}");
