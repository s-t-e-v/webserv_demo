<?php
// filepath: /home/sbandaog/42/webserv/www/cgi/cookies/login.php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read raw POST data
    $rawData = file_get_contents('php://input');
    
    // Parse form data manually
    $postData = array();
    if (!empty($rawData)) {
        parse_str($rawData, $postData);
    }
    
    // Debug: log what we received
    error_log("Raw data: " . $rawData);
    error_log("Parsed data: " . print_r($postData, true));
    
    if (isset($postData['username']) && !empty($postData['username'])) {
        $_SESSION['user'] = $postData['username'];
        header("Location: secret.php");
        exit();
    }
}

// Check if already logged in
if (isset($_SESSION['user'])) {
    header("Location: secret.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Login - Webserv</title>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .login-theme {
            background: linear-gradient(135deg, #663399 0%, #8e44ad 100%);
        }
        .login-card {
            background: white;
            border-radius: 16px;
            padding: 40px;
            max-width: 500px;
            margin: 0 auto;
            box-shadow: 0 20px 40px rgba(102, 51, 153, 0.2);
            border-top: 6px solid #663399;
        }
        .form-group {
            margin-bottom: 25px;
        }
        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }
        .form-input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            font-family: inherit;
        }
        .form-input:focus {
            outline: none;
            border-color: #663399;
            box-shadow: 0 0 0 3px rgba(102, 51, 153, 0.1);
        }
        .login-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #663399, #8e44ad);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        .login-btn:hover {
            transform: translateY(-2px);
        }
        .php-badge {
            background: linear-gradient(45deg, #663399, #8e44ad);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 20px;
        }
        .demo-info {
            background: #f8f0ff;
            border: 1px solid #d1c4e9;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            color: #4a148c;
        }
    </style>
</head>
<body class="login-theme">
    <div class="background-pattern"></div>
    
    <header>
        <div class="header-content">
            <div class="logo">
                <div class="logo-icon">🌐</div>
                <h1>PHP Login System</h1>
            </div>
            <p class="subtitle">Cookie-based authentication with PHP CGI</p>
        </div>
    </header>

    <main class="container">
        <section class="intro">
            <h2>Login to Access Protected Area</h2>
            <p>Test cookie-based session management implemented in PHP</p>
        </section>

        <div class="login-card">
            <div class="php-badge">🌐 Powered by PHP</div>
            
            <div class="demo-info">
                <h4 style="margin-top: 0;">Demo Instructions:</h4>
                <p style="margin-bottom: 0;">Enter any username to log in. This demonstrates cookie-based session management using PHP CGI scripts.</p>
            </div>
            
            <form method="POST" action="login.php">
                <div class="form-group">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" id="username" name="username" class="form-input" 
                           placeholder="Enter any username" required>
                </div>
                
                <button type="submit" class="login-btn">
                    🔐 Login with PHP
                </button>
            </form>
        </div>

        <section class="back-navigation" style="text-align: center; margin-top: 40px;">
            <a href="/demo/cookies.html" class="back-button" style="background: rgba(255, 255, 255, 0.9);">
                <span class="back-button-icon">⬅️</span>
                <span>Back to Cookie Demo</span>
            </a>
        </section>
    </main>

    <footer style="background: rgba(0, 0, 0, 0.2);">
        <div class="footer-content">
            <p>&copy; 2025 Webserv Project. PHP login system.</p>
            <div class="footer-links">
                <a href="/">Main Demo</a>
                <a href="/demo/cookies.html">Cookie Tests</a>
            </div>
        </div>
    </footer>
</body>
</html>