<?php
// Send HTTP status and Location for redirection
header("Status: 302 Found");
header("Location: https://openai.com");

// Include Content-Type and an HTML document
header("Content-Type: text/html");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Redirecting to OpenAI</title>
</head>
<body>
    <p>You are being redirected to <a href="https://openai.com">https://openai.com</a>.</p>
</body>
</html>
