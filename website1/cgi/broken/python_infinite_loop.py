#!/usr/bin/env python3
# filepath: /home/sbandaog/42/webserv/www/website1/cgi/broken/python_infinite_loop.py

import sys
import time

# CGI Header
print("Content-Type: text/html\r")
print("\r")

# Start HTML output
print("<!DOCTYPE html>")
print("<html><head><title>Python Infinite Loop Test</title></head><body>")
print("<h1>Testing Python Infinite Loop</h1>")
print("<p>This script will enter an infinite loop...</p>")

# Flush output to ensure headers are sent
sys.stdout.flush()

# Infinite loop - will consume CPU and never finish
counter = 0
while True:
    counter += 1
    # Optional: add some work to make it more realistic
    dummy = counter * 2
    
    # Prevent any potential optimizations
    if counter < 0:
        break  # This will never execute

# This will never be reached
print("<p>Loop finished!</p>")
print("</body></html>")