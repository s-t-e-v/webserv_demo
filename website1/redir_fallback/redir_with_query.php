#!/usr/bin/php-cgi
<?php
// filepath: /home/sbandaog/42/webserv/www/website1/redir_fallback/redir_with_query.php
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Local Redirection with Query - Webserv</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .redirect-theme {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .redirect-card {
            background: white;
            border-left: 6px solid #f093fb;
            border-radius: 12px;
            padding: 40px;
            margin: 20px;
            box-shadow: 0 8px 25px rgba(240, 147, 251, 0.15);
            max-width: 700px;
            width: 100%;
        }
        .redirect-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
            text-align: center;
        }
        .redirect-title {
            color: #f093fb;
            margin-bottom: 15px;
            font-size: 2rem;
            font-weight: 600;
            text-align: center;
        }
        .redirect-message {
            color: #666;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 30px;
            text-align: center;
        }
        .redirect-badge {
            background: linear-gradient(45deg, #f093fb, #f5576c);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            display: inline-block;
            margin: 10px auto 20px auto;
            display: block;
            text-align: center;
            width: fit-content;
        }
        .query-section {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-left: 4px solid #f093fb;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .query-title {
            color: #f093fb;
            margin-bottom: 15px;
            font-size: 1.3rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .query-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .query-item {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 12px 15px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s ease;
        }
        .query-item:hover {
            transform: translateX(5px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .query-key {
            font-weight: 600;
            color: #333;
            font-family: monospace;
            background: #f8f9fa;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 14px;
        }
        .query-value {
            color: #666;
            font-family: monospace;
            background: #fff3cd;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 14px;
            word-break: break-all;
        }
        .no-params {
            text-align: center;
            color: #999;
            font-style: italic;
            padding: 20px;
        }
        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        .action-btn {
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8, #6a4190);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }
        .btn-secondary {
            background: linear-gradient(135deg, #f093fb, #f5576c);
            color: white;
        }
        .btn-secondary:hover {
            background: linear-gradient(135deg, #e081e9, #e3455a);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(240, 147, 251, 0.3);
        }
        .info-box {
            background: #e7f3ff;
            border: 1px solid #b8daff;
            border-left: 4px solid #007bff;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .info-box h3 {
            color: #007bff;
            margin-bottom: 10px;
            font-size: 1.2rem;
        }
        .info-box p {
            color: #666;
            margin: 5px 0;
            font-size: 14px;
            line-height: 1.5;
        }
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }
        @media (max-width: 600px) {
            .redirect-card {
                margin: 10px;
                padding: 30px 20px;
            }
            .action-buttons {
                flex-direction: column;
                align-items: center;
            }
            .action-btn {
                width: 100%;
                max-width: 280px;
                justify-content: center;
            }
        }
    </style>
</head>
<body class="redirect-theme">
    <div class="redirect-card">
        <div class="redirect-icon">🔄</div>
        <h1 class="redirect-title">Local Redirection Completed</h1>
        <div class="redirect-badge">🏠 CGI Local Redirect with Query</div>
        
        <p class="redirect-message">
            You have been redirected by a CGI script using local redirection. 
            The server processed the redirect internally and preserved your query parameters.
        </p>

        <div class="info-box">
            <h3>🔍 Redirection Details</h3>
            <p><strong>Type:</strong> Local CGI Redirection</p>
            <p><strong>Method:</strong> Server-side internal redirect</p>
            <p><strong>Query Preservation:</strong> <?= empty($_GET) ? 'No parameters' : 'Parameters preserved' ?></p>
            <p><strong>Script:</strong> <?= $_SERVER['SCRIPT_NAME'] ?? 'Unknown' ?></p>
        </div>

        <div class="query-section">
            <h3 class="query-title">
                🔗 Query Parameters
                <span style="background: #007bff; color: white; padding: 4px 8px; border-radius: 12px; font-size: 12px;">
                    <?= count($_GET) ?>
                </span>
            </h3>
            
            <ul class="query-list">
                <?php if (empty($_GET)): ?>
                    <li class="no-params">
                        📭 No query parameters were provided with this request.
                    </li>
                <?php else: ?>
                    <?php foreach ($_GET as $key => $value): ?>
                        <li class="query-item">
                            <span class="query-key"><?= htmlspecialchars($key) ?></span>
                            <span>=</span>
                            <span class="query-value"><?= htmlspecialchars($value) ?></span>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>

        <div class="action-buttons">
            <a href="/demo/cgi.html" class="action-btn btn-secondary">
                🔄 Try More Redirects
            </a>
            <a href="/" class="action-btn btn-primary">
                🏠 Home Page
            </a>
        </div>

        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e9ecef; text-align: center;">
            <p style="color: #999; font-size: 14px;">
                &copy; 2025 Webserv Project. Local redirection with query parameter demonstration.
            </p>
        </div>
    </div>
</body>
</html>