#!/usr/bin/env python3
# filepath: /home/sbandaog/42/webserv/www/website1/cgi/broken/python_crash.py

import sys
import os

# Intentionally cause errors before sending proper headers

# Try to import a non-existent module
import nonexistent_module_that_does_not_exist

# Try to access a non-existent file
with open('/nonexistent/path/that/does/not/exist.txt', 'r') as f:
    content = f.read()

# Try to call an undefined function
undefined_function_that_does_not_exist()

# Cause a division by zero error
result = 1 / 0

# Try to access undefined variable
print(undefined_variable)

# This should never be reached due to exceptions above
print("Content-Type: text/html\r")
print("\r")
print("<!DOCTYPE html>")
print("<html><head><title>Python Should Have Crashed</title></head><body>")
print("<h1>If you see this, the crash test failed!</h1>")
print("</body></html>")