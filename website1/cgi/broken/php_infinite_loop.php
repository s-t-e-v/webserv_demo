#!/usr/bin/php-cgi
<?php
// filepath: /home/sbandaog/42/webserv/www/website1/cgi/broken/php_infinite_loop.php

// Start with a proper CGI header
header('Content-Type: text/html; charset=utf-8');

echo "<!DOCTYPE html>\n";
echo "<html><head><title>PHP Infinite Loop Test</title></head><body>\n";
echo "<h1>Testing PHP Infinite Loop</h1>\n";
echo "<p>This script will enter an infinite loop...</p>\n";

// Flush output to ensure headers are sent
ob_flush();
flush();

// Infinite loop - will consume CPU and never finish
$counter = 0;
while (true) {
    $counter++;
    // Optional: add some work to make it more realistic
    $dummy = $counter * 2;
    
    // Prevent any potential optimizations
    if ($counter < 0) {
        break; // This will never execute
    }
}

// This will never be reached
echo "<p>Loop finished!</p>\n";
echo "</body></html>\n";
?>