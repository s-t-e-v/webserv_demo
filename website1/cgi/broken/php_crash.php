#!/usr/bin/php-cgi
<?php
// filepath: /home/sbandaog/42/webserv/www/website1/cgi/broken/php_crash.php

// Intentionally cause a fatal error before sending proper headers

// Try to access a non-existent file that will cause a fatal error
include '/nonexistent/path/that/does/not/exist.php';

// Try to call an undefined function
undefined_function_that_does_not_exist();

// Try to access undefined constant
echo UNDEFINED_CONSTANT;

// Cause a memory error by trying to allocate too much memory
$huge_array = array();
for ($i = 0; $i < 999999999; $i++) {
    $huge_array[] = str_repeat('x', 1000000);
}

// This should never be reached due to fatal errors above
header('Content-Type: text/html; charset=utf-8');
echo "<!DOCTYPE html>\n";
echo "<html><head><title>PHP Should Have Crashed</title></head><body>\n";
echo "<h1>If you see this, the crash test failed!</h1>\n";
echo "</body></html>\n";
?>