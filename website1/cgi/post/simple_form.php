<?php
// filepath: /home/sbandaog/42/webserv/www/website1/cgi/form_demo.php

header('Content-Type: text/html; charset=utf-8');

// Check if this is a POST request
$isPost = $_SERVER["REQUEST_METHOD"] == "POST";
$name = "";
$email = "";
$message = "";
$rawBody = "";
$currentTime = date('Y-m-d H:i:s');

if ($isPost) {
    // Read and parse POST data
    $rawBody = file_get_contents("php://input");
    parse_str($rawBody, $postData);
    
    $name = htmlspecialchars($postData["name"] ?? "");
    $email = htmlspecialchars($postData["email"] ?? "");
    $message = htmlspecialchars($postData["message"] ?? "");
    $contentLength = strlen($rawBody);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $isPost ? 'Form Submitted Successfully' : 'Form POST Demo'; ?> - Webserv</title>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .form-theme {
            background: linear-gradient(135deg, <?php echo $isPost ? '#27ae60 0%, #2ecc71 100%' : '#2980b9 0%, #3498db 100%'; ?>);
        }
        .form-card {
            background: white;
            border-left: 6px solid <?php echo $isPost ? '#27ae60' : '#2980b9'; ?>;
            border-radius: 12px;
            padding: 30px;
            margin: 20px 0;
            box-shadow: 0 8px 25px rgba(<?php echo $isPost ? '39, 174, 96' : '41, 128, 185'; ?>, 0.15);
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
        .form-input, .form-textarea {
            width: 100%;
            padding: 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 16px;
            font-family: inherit;
            transition: border-color 0.3s ease;
        }
        .form-input:focus, .form-textarea:focus {
            outline: none;
            border-color: <?php echo $isPost ? '#27ae60' : '#2980b9'; ?>;
            box-shadow: 0 0 0 3px rgba(<?php echo $isPost ? '39, 174, 96' : '41, 128, 185'; ?>, 0.1);
        }
        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }
        .submit-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, <?php echo $isPost ? '#27ae60, #2ecc71' : '#2980b9, #3498db'; ?>);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(<?php echo $isPost ? '39, 174, 96' : '41, 128, 185'; ?>, 0.3);
        }
        .form-badge {
            background: linear-gradient(45deg, <?php echo $isPost ? '#27ae60, #2ecc71' : '#2980b9, #3498db'; ?>);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            display: inline-block;
            margin: 10px 0;
        }
        .code-block {
            background: #2d3748;
            color: #e2e8f0;
            padding: 20px;
            border-radius: 8px;
            font-family: monospace;
            margin: 15px 0;
            border-left: 4px solid <?php echo $isPost ? '#27ae60' : '#2980b9'; ?>;
            font-size: 14px;
        }
        .highlight {
            color: <?php echo $isPost ? '#27ae60' : '#3498db'; ?>;
            font-weight: bold;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .data-table th, .data-table td {
            text-align: left;
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }
        .data-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
        }
        .data-table tr:hover {
            background: <?php echo $isPost ? '#f0fff4' : '#f0f4ff'; ?>;
        }
        .message-box {
            background: <?php echo $isPost ? '#f0fff4' : '#f0f4ff'; ?>;
            border: 1px solid <?php echo $isPost ? '#d4edda' : '#b8daff'; ?>;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            white-space: pre-wrap;
            font-family: monospace;
            font-size: 14px;
            line-height: 1.6;
        }
    </style>
</head>
<body class="form-theme">
    <div class="background-pattern"></div>
    
    <header>
        <div class="header-content">
            <div class="logo">
                <div class="logo-icon"><?php echo $isPost ? '✅' : '📝'; ?></div>
                <h1><?php echo $isPost ? 'Form Submitted Successfully' : 'Form POST Demo'; ?></h1>
            </div>
            <p class="subtitle"><?php echo $isPost ? 'Your message has been processed by PHP CGI' : 'Test application/x-www-form-urlencoded POST requests'; ?></p>
        </div>
    </header>

    <main class="container">
        <section class="intro">
            <?php if ($isPost): ?>
                <h2>🎉 Thank you, <?php echo $name; ?>!</h2>
                <p>Your form submission was successfully processed by the server</p>
                <div class="form-badge">📝 Processed at <?php echo $currentTime; ?></div>
            <?php else: ?>
                <h2>📋 Contact Form with POST Handling</h2>
                <p>Fill out the form below and submit to see your data processed by the server</p>
                <div class="form-badge">🌐 POST → PHP CGI Processing</div>
            <?php endif; ?>
        </section>

        <?php if ($isPost): ?>
            <!-- SUCCESS PAGE CONTENT -->
            <div class="form-card">
                <h3 style="color: #27ae60; margin-bottom: 20px;">📋 Submitted Data</h3>
                <table class="data-table">
                    <tr>
                        <th>Field</th>
                        <th>Value</th>
                    </tr>
                    <tr>
                        <td><strong>Name</strong></td>
                        <td class="highlight"><?php echo $name; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong></td>
                        <td><?php echo $email; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Message Length</strong></td>
                        <td><?php echo strlen($message); ?> characters</td>
                    </tr>
                    <tr>
                        <td><strong>Submitted At</strong></td>
                        <td class="highlight"><?php echo $currentTime; ?></td>
                    </tr>
                </table>
            </div>

            <div class="form-card">
                <h3 style="color: #27ae60; margin-bottom: 15px;">💬 Your Message</h3>
                <div class="message-box"><?php echo $message; ?></div>
            </div>

            <div class="form-card">
                <h3 style="color: #27ae60; margin-bottom: 15px;">🔍 Request Details</h3>
                <table class="data-table">
                    <tr>
                        <th>Parameter</th>
                        <th>Value</th>
                    </tr>
                    <tr>
                        <td>Request Method</td>
                        <td class="highlight"><?php echo $_SERVER["REQUEST_METHOD"]; ?></td>
                    </tr>
                    <tr>
                        <td>Content Type</td>
                        <td><?php echo $_SERVER["CONTENT_TYPE"] ?? "application/x-www-form-urlencoded"; ?></td>
                    </tr>
                    <tr>
                        <td>Content Length</td>
                        <td><?php echo $contentLength; ?> bytes</td>
                    </tr>
                    <tr>
                        <td>Script Name</td>
                        <td><?php echo $_SERVER["SCRIPT_NAME"]; ?></td>
                    </tr>
                    <tr>
                        <td>Remote Address</td>
                        <td><?php echo $_SERVER["REMOTE_ADDR"] ?? "Unknown"; ?></td>
                    </tr>
                </table>
            </div>

            <div class="form-card">
                <h3 style="color: #27ae60; margin-bottom: 15px;">📡 Raw POST Data</h3>
                <p>This is the raw data your browser sent:</p>
                <div class="code-block">
<span style="color: #4ecdc4;">POST</span> <span style="color: #ffe66d;"><?php echo $_SERVER["SCRIPT_NAME"]; ?></span> <span style="color: #95e1d3;">HTTP/1.1</span><br>
<span style="color: #ff6b6b;">Content-Type:</span> application/x-www-form-urlencoded<br>
<span style="color: #ff6b6b;">Content-Length:</span> <?php echo $contentLength; ?><br><br>
<span style="color: #95e1d3;"><?php echo htmlspecialchars($rawBody); ?></span>
                </div>
            </div>

            <section class="back-navigation" style="text-align: center;">
                <a href="<?php echo $_SERVER["SCRIPT_NAME"]; ?>" class="back-button" style="background: rgba(255, 255, 255, 0.9);">
                    <span class="back-button-icon">⬅️</span>
                    <span>Submit Another Form</span>
                </a>
            </section>

        <?php else: ?>
            <!-- FORM PAGE CONTENT -->
            <div class="form-card">
                <h3 style="color: #2980b9; margin-bottom: 20px;">💌 Contact Form</h3>
                <form action="<?php echo $_SERVER["SCRIPT_NAME"]; ?>" method="POST">
                    <div class="form-group">
                        <label for="name" class="form-label">Full Name:</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            class="form-input"
                            placeholder="Enter your full name"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email Address:</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-input"
                            placeholder="Enter your email address"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="message" class="form-label">Message:</label>
                        <textarea 
                            id="message" 
                            name="message" 
                            class="form-textarea"
                            placeholder="Enter your message here..."
                            required
                        ></textarea>
                    </div>

                    <button type="submit" class="submit-btn">
                        📤 Send Message via POST
                    </button>
                </form>
            </div>

            <div class="form-card">
                <h3 style="color: #2980b9; margin-bottom: 15px;">🔍 How It Works</h3>
                <p>When you submit this form, the following happens:</p>
                <ol style="margin: 15px 0 15px 20px; line-height: 1.8;">
                    <li>Browser sends <span class="highlight">POST</span> request to this same script</li>
                    <li>Content-Type: <span class="highlight">application/x-www-form-urlencoded</span></li>
                    <li>PHP CGI script detects POST method and processes the data</li>
                    <li>Server returns a formatted response page with the submitted data</li>
                </ol>

                <div class="code-block">
<span style="color: #ff6b6b;">POST</span> <span style="color: #4ecdc4;"><?php echo $_SERVER["SCRIPT_NAME"]; ?></span> <span style="color: #95e1d3;">HTTP/1.1</span><br>
<span style="color: #ffe66d;">Content-Type:</span> application/x-www-form-urlencoded<br>
<span style="color: #ffe66d;">Content-Length:</span> 65<br><br>
<span style="color: #95e1d3;">name=John+Doe&email=john%40example.com&message=Hello+World</span>
                </div>
            </div>

            <div class="form-card">
                <h3 style="color: #2980b9; margin-bottom: 15px;">⚙️ Technical Details</h3>
                <ul style="margin: 15px 0 15px 20px; line-height: 1.8;">
                    <li><strong>Method:</strong> POST (not GET for sensitive data)</li>
                    <li><strong>Encoding:</strong> application/x-www-form-urlencoded</li>
                    <li><strong>Data Processing:</strong> PHP <code>parse_str()</code> function</li>
                    <li><strong>Security:</strong> <code>htmlspecialchars()</code> for XSS protection</li>
                    <li><strong>Self-Processing:</strong> Same script handles both form display and submission</li>
                </ul>
            </div>

            <section class="back-navigation" style="text-align: center;">
                <a href="/demo/cgi.html" class="back-button" style="background: rgba(255, 255, 255, 0.9);">
                    <span class="back-button-icon">⬅️</span>
                    <span>Back to POST Demo</span>
                </a>
            </section>
        <?php endif; ?>
    </main>

    <footer style="background: rgba(0, 0, 0, 0.2);">
        <div class="footer-content">
            <p>&copy; 2025 Webserv Project. <?php echo $isPost ? 'Form processed by PHP CGI.' : 'Form POST demonstration.'; ?></p>
            <div class="footer-links">
                <a href="/">Main Demo</a>
                <a href="/demo/cgi.html">POST Tests</a>
            </div>
        </div>
    </footer>
</body>
</html>