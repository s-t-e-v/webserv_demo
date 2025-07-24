#!/usr/bin/env python3
# filepath: /home/sbandaog/42/webserv/www/cgi/secret.py

import os
import datetime
import json

SESSION_FILE = '/tmp/webserv_sessions.json'

def load_sessions():
    """Load sessions from file"""
    try:
        if os.path.exists(SESSION_FILE):
            with open(SESSION_FILE, 'r') as f:
                return json.load(f)
    except:
        pass
    return {}

def get_session_from_cookie():
    """Extract session ID from cookies"""
    cookie_header = os.environ.get('HTTP_COOKIE', '')
    if 'session_id=' in cookie_header:
        for cookie in cookie_header.split(';'):
            if 'session_id=' in cookie:
                return cookie.split('=')[1].strip()
    return None

def get_user_from_session():
    """Get username from session"""
    sessions = load_sessions()
    session_id = get_session_from_cookie()
    if session_id and session_id in sessions:
        return sessions[session_id]['user']
    return None

# Check authentication
username = get_user_from_session()
if not username:
    print("Location: login.py")
    print("Content-Type: text/html")
    print()
    exit()

# Generate response
print("Content-Type: text/html")
print()

html = f"""<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Python Secret Area - Webserv</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .secret-theme {{
            background: linear-gradient(135deg, #3776ab 0%, #ffd43b 100%);
        }}
        .secret-card {{
            background: white;
            border-radius: 16px;
            padding: 40px;
            margin: 20px 0;
            box-shadow: 0 20px 40px rgba(55, 118, 171, 0.2);
            border-left: 6px solid #3776ab;
        }}
        .user-badge {{
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            padding: 12px 20px;
            border-radius: 25px;
            font-weight: bold;
            display: inline-block;
            margin: 15px 0;
            font-size: 1.1em;
        }}
        .status-indicator {{
            position: absolute;
            top: 20px;
            right: 20px;
            background: #28a745;
            color: white;
            padding: 8px 15px;
            border-radius: 15px;
            font-size: 0.9em;
            font-weight: bold;
        }}
        .secret-content {{
            background: #f8f9fa;
            border-left: 4px solid #3776ab;
            padding: 25px;
            margin: 30px 0;
            border-radius: 0 12px 12px 0;
        }}
        .session-info {{
            background: #e7f3ff;
            border: 1px solid #b8daff;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
            color: #004085;
        }}
        .action-buttons {{
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 30px;
        }}
        .btn {{
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }}
        .btn-primary {{
            background: #007bff;
            color: white;
        }}
        .btn-primary:hover {{
            background: #0056b3;
            transform: translateY(-2px);
        }}
        .btn-secondary {{
            background: #6c757d;
            color: white;
        }}
        .btn-secondary:hover {{
            background: #5a6268;
            transform: translateY(-2px);
        }}
        .btn-danger {{
            background: #dc3545;
            color: white;
        }}
        .btn-danger:hover {{
            background: #c82333;
            transform: translateY(-2px);
        }}
        .python-highlight {{
            color: #3776ab;
            font-weight: bold;
        }}
    </style>
</head>
<body class="secret-theme">
    <div class="background-pattern"></div>
    
    <header>
        <div class="header-content">
            <div class="logo">
                <div class="logo-icon">🐍</div>
                <h1>Python Secret Area</h1>
            </div>
            <p class="subtitle">Protected area accessed via Python session management</p>
        </div>
    </header>

    <main class="container">
        <div class="secret-card">
            <div class="status-indicator">🔒 Authenticated</div>
            
            <h2>🎉 Welcome to the Python Secret Area!</h2>
            
            <div class="user-badge">
                👤 {username}
            </div>
            
            <p style="font-size: 1.1em; color: #666; line-height: 1.6;">
                Congratulations! You have successfully accessed this protected area using 
                <span class="python-highlight">Python CGI</span> session management. 
                This demonstrates cookie-based authentication implemented in Python.
            </p>
            
            <div class="secret-content">
                <h3 style="color: #3776ab; margin-top: 0;">🔐 Python Session Information</h3>
                <p>You now have access to:</p>
                <ul style="margin: 0; padding-left: 25px;">
                    <li>Python-based session management</li>
                    <li>Cookie handling via CGI environment</li>
                    <li>Server-side authentication logic</li>
                    <li>Protected resource access</li>
                </ul>
            </div>
            
            <div class="session-info">
                <strong>🐍 Session Details:</strong><br>
                <strong>User:</strong> {username}<br>
                <strong>Authentication:</strong> Python CGI Session<br>
                <strong>Access Time:</strong> {datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S')}<br>
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
                <a href="logout.py" class="btn btn-danger">
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
            <p>&copy; 2025 Webserv Project. Python session management demo.</p>
            <div class="footer-links">
                <a href="/">Main Demo</a>
                <a href="/demo/cookies.html">Cookie Tests</a>
            </div>
        </div>
    </footer>
</body>
</html>"""

print(html)