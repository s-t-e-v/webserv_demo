#!/usr/bin/env python3
# filepath: /home/sbandaog/42/webserv/www/cgi/logout.py

import os

def get_session_from_cookie():
    """Extract session ID from cookies"""
    cookie_header = os.environ.get('HTTP_COOKIE', '')
    if 'session_id=' in cookie_header:
        for cookie in cookie_header.split(';'):
            if 'session_id=' in cookie:
                return cookie.split('=')[1].strip()
    return None

# Clear session
session_id = get_session_from_cookie()
if session_id:
    # In a real implementation, remove from session storage
    pass

# Clear cookie and redirect
print("Set-Cookie: session_id=; Path=/; Expires=Thu, 01 Jan 1970 00:00:00 GMT")
print("Location: login.py")
print("Content-Type: text/html")
print()