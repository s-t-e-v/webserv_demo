<?php
// filepath: /home/sbandaog/42/webserv/www/cgi/secret.php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Secret Area - Webserv</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .secret-theme {
            background: linear-gradient(135deg, #663399 0%, #8e44ad 100%);
        }
        .secret-card {
            background: white;
            border-radius: 16px;
            padding: 40px;
            margin: 20px 0;
            box-shadow: 0 20px 40px rgba(102, 51, 153, 0.2);
            border-left: 6px solid #663399;
        }
        .user-badge {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            padding: 12px 20px;
            border-radius: 25px;
            font-weight: bold;
            display: inline-block;
            margin: 15px 0;
            font-size: 1.1em;
        }
        .status-indicator {
            position: absolute;
            top: 20px;
            right: 20px;
            background: #28a745;
            color: white;
            padding: 8px 15px;
            border-radius: 15px;
            font-size: 0.9em;
            font-weight: bold;
        }
        .secret-content {
            background: #f8f9fa;
            border-left: 4px solid #663399;
            padding: 25px;
            margin: 30px 0;
            border-radius: 0 12px 12px 0;
        }
        .session-info {
            background: #f8f0ff;
            border: 1px solid #d1c4e9;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
            color: #4a148c;
        }
        .action-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 30px;
        }
        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-primary {
            background: #007bff;
            color: white;
        }
        .btn-primary:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
        }
        .php-highlight {
            color: #663399;
            font-weight: bold;
        }
    </style>
</head>
<body class="secret-theme">
    <div class="background-pattern"></div>
    
    <header>
        <div class="header-content">
            <div class="logo">
                <div class="logo-icon">🌐</div>
                <h1>PHP Secret Area</h1>
            </div>
            <p class="subtitle">Protected area accessed via PHP session management</p>
        </div>
    </header>

    <main class="container">
        <div class="secret-card">
            <div class="status-indicator">🔒 Authenticated</div>
            
            <h2>🎉 Welcome to the PHP Secret Area!</h2>
            
            <div class="user-badge">
                👤 <?php echo htmlspecialchars($_SESSION['user']); ?>
            </div>
            
            <p style="font-size: 1.1em; color: #666; line-height: 1.6;">
                Congratulations! You have successfully accessed this protected area using 
                <span class="php-highlight">PHP CGI</span> session management. 
                This demonstrates cookie-based authentication implemented in PHP.
            </p>
            
            <div class="secret-content">
                <h3 style="color: #663399; margin-top: 0;">🔐 PHP Session Information</h3>
                <p>You now have access to:</p>
                <ul style="margin: 0; padding-left: 25px;">
                    <li>PHP-based session management</li>
                    <li>Cookie handling via PHP sessions</li>
                    <li>Server-side authentication logic</li>
                    <li>Protected resource access</li>
                </ul>
            </div>
            
            <div class="session-info">
                <strong>🌐 Session Details:</strong><br>
                <strong>User:</strong> <?php echo htmlspecialchars($_SESSION['user']); ?><br>
                <strong>Authentication:</strong> PHP CGI Session<br>
                <strong>Access Time:</strong> <?php echo date('Y-m-d H:i:s'); ?><br>
                <strong>Session Type:</strong> Cookie-based
            </div>
            
            <div class="action-buttons">
                <a href="/form/" class="btn btn-primary">
                    📝 Go to Forms
                </a>
                <a href="/uploads/" class="btn btn-secondary">
                    📁 View Uploads
                </a>
                <a href="/demo/cookies.html" class="btn btn-secondary">
                    🍪 Cookie Demo
                </a>
                <a href="logout.php" class="btn btn-danger">
                    🚪 Logout
                </a>
            </div>
        </div>

        <section class="back-navigation" style="text-align: center; margin-top: 40px;">
            <a href="/" class="back-button" style="background: rgba(255, 255, 255, 0.9);">
                <span class="back-button-icon">⬅️</span>
                <span>Back to Main Demo</span>
            </a>
        </section>
    </main>

    <footer style="background: rgba(0, 0, 0, 0.2);">
        <div class="footer-content">
            <p>&copy; 2025 Webserv Project. PHP session management demo.</p>
            <div class="footer-links">
                <a href="/">Main Demo</a>
                <a href="/demo/cookies.html">Cookie Tests</a>
            </div>
        </div>
    </footer>
</body>
</html>