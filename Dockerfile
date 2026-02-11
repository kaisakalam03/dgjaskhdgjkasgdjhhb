FROM php:8.2-cli

# Install required PHP extensions
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    && docker-php-ext-install curl \
    && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /app

# Copy application files
COPY . .

# Create temp directory for cookies
RUN mkdir -p /tmp/bot_cookies && chmod 777 /tmp/bot_cookies

# Expose port
EXPOSE 8080

# Start the application
CMD ["php", "-S", "0.0.0.0:8080", "-t", "."]
