#!/usr/bin/env python3
# filepath: /home/sbandaog/42/webserv/www/cgi/cookies/login.py

import os
import sys
import urllib.parse
import uuid
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

def save_sessions(sessions):
    """Save sessions to file"""
    try:
        with open(SESSION_FILE, 'w') as f:
            json.dump(sessions, f)
    except:
        pass

def get_session_from_cookie():
    """Extract session ID from cookies"""
    cookie_header = os.environ.get('HTTP_COOKIE', '')
    if 'session_id=' in cookie_header:
        for cookie in cookie_header.split(';'):
            if 'session_id=' in cookie:
                return cookie.split('=')[1].strip()
    return None

def handle_post():
    """Handle POST request for login"""
    content_length = int(os.environ.get('CONTENT_LENGTH', 0))
    if content_length > 0:
        post_data = sys.stdin.read(content_length)
        parsed_data = urllib.parse.parse_qs(post_data)
        
        username = parsed_data.get('username', [''])[0]
        if username:
            # Load existing sessions
            sessions = load_sessions()
            
            # Create session
            session_id = str(uuid.uuid4())
            sessions[session_id] = {
                'user': username,
                'created': datetime.datetime.now().isoformat()
            }
            
            # Save sessions
            save_sessions(sessions)
            
            # Set cookie and redirect
            print(f"Set-Cookie: session_id={session_id}; Path=/; HttpOnly")
            print("Location: secret.py")
            print("Content-Type: text/html")
            print()
            return True
    return False

def show_login_form():
    """Display login form"""
    print("Content-Type: text/html")
    print()
    
    html = f"""<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Python Login - Webserv</title>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .login-theme {{
            background: linear-gradient(135deg, #3776ab 0%, #ffd43b 100%);
        }}
        .login-card {{
            background: white;
            border-radius: 16px;
            padding: 40px;
            max-width: 500px;
            margin: 0 auto;
            box-shadow: 0 20px 40px rgba(55, 118, 171, 0.2);
            border-top: 6px solid #3776ab;
        }}
        .form-group {{
            margin-bottom: 25px;
        }}
        .form-label {{
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }}
        .form-input {{
            width: 100%;
            padding: 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            font-family: inherit;
        }}
        .form-input:focus {{
            outline: none;
            border-color: #3776ab;
            box-shadow: 0 0 0 3px rgba(55, 118, 171, 0.1);
        }}
        .login-btn {{
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #3776ab, #ffd43b);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease;
        }}
        .login-btn:hover {{
            transform: translateY(-2px);
        }}
        .python-badge {{
            background: linear-gradient(45deg, #3776ab, #ffd43b);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 20px;
        }}
        .demo-info {{
            background: #e7f3ff;
            border: 1px solid #b8daff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            color: #004085;
        }}
    </style>
</head>
<body class="login-theme">
    <div class="background-pattern"></div>
    
    <header>
        <div class="header-content">
            <div class="logo">
                <div class="logo-icon">🐍</div>
                <h1>Python Login System</h1>
            </div>
            <p class="subtitle">Cookie-based authentication with Python CGI</p>
        </div>
    </header>

    <main class="container">
        <section class="intro">
            <h2>Login to Access Protected Area</h2>
            <p>Test cookie-based session management implemented in Python</p>
        </section>

        <div class="login-card">
            <div class="python-badge">🐍 Powered by Python</div>
            
            <div class="demo-info">
                <h4 style="margin-top: 0;">Demo Instructions:</h4>
                <p style="margin-bottom: 0;">Enter any username to log in. This demonstrates cookie-based session management using Python CGI scripts.</p>
            </div>
            
            <form method="POST" action="login.py">
                <div class="form-group">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" id="username" name="username" class="form-input" 
                           placeholder="Enter any username" required>
                </div>
                
                <button type="submit" class="login-btn">
                    🔐 Login with Python
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
            <p>&copy; 2025 Webserv Project. Python login system.</p>
            <div class="footer-links">
                <a href="/">Main Demo</a>
                <a href="/demo/cookies.html">Cookie Tests</a>
            </div>
        </div>
    </footer>
</body>
</html>"""
    print(html)

# Main execution
request_method = os.environ.get('REQUEST_METHOD', 'GET')

if request_method == 'POST':
    if handle_post():
        sys.exit(0)

# Check if already logged in
sessions = load_sessions()
session_id = get_session_from_cookie()
if session_id and session_id in sessions:
    print("Location: secret.py")
    print("Content-Type: text/html")
    print()
else:
    show_login_form()