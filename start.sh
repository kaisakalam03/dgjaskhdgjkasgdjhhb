#!/bin/bash

# Start PHP built-in web server
php -S 0.0.0.0:${PORT:-8080} -t .
