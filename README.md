# Telegram Card Checker Bot

A PHP-based Telegram bot for card validation.

## Deployment Files

The following files have been created for deployment:

- `Dockerfile` - Docker container configuration (primary deployment method)
- `.dockerignore` - Files to exclude from Docker build
- `railway.toml` - Railway-specific configuration
- `start.sh` - Startup script for the PHP web server (fallback)
- `Procfile` - Process file for platform deployment (fallback)
- `nixpacks.toml` - Nixpacks configuration (alternative)
- `composer.json` - PHP dependency management
- `.gitignore` - Git ignore rules
- `vendor/autoload.php` - Minimal autoload stub (no external dependencies)

## Deployment Instructions

### Railway Deployment (Docker)

1. Make sure all files are committed to git:
   ```bash
   git add .
   git commit -m "Add Docker deployment configuration"
   git push
   ```

2. Connect your repository to Railway

3. Railway will automatically detect and use the Dockerfile

4. Set environment variables in Railway dashboard:
   - `BOT_TOKEN` = Your Telegram bot token
   - `PROXY_HOST` = Your proxy (optional)
   - `PROXY_AUTH` = Your proxy credentials (optional)

5. After deployment, set the webhook URL in Telegram:
   ```
   https://api.telegram.org/bot<YOUR_BOT_TOKEN>/setWebhook?url=https://<your-railway-url>/telegram_bot.php
   ```

### Heroku Deployment (Docker)

1. Install Heroku CLI
2. Login: `heroku login`
3. Create app: `heroku create your-app-name`
4. Set buildpack: `heroku stack:set container`
5. Push: `git push heroku main`
6. Set environment variables: `heroku config:set BOT_TOKEN=your_token`
7. Set webhook as described above

### Local Docker Testing

```bash
# Build the image
docker build -t telegram-bot .

# Run the container
docker run -p 8080:8080 -e BOT_TOKEN=your_token telegram-bot
```

## ✅ SECURITY FEATURES

This bot implements the following security best practices:

### 1. **Environment Variables for Secrets**
All sensitive data (bot token, proxy credentials) are loaded from environment variables:
```php
$botToken = getenv('BOT_TOKEN');
if (!$botToken) {
    die('ERROR: BOT_TOKEN environment variable is required.');
}
```

### 2. **No Hardcoded Credentials**
All tokens and credentials MUST be set via environment variables on your deployment platform.

### 3. **Cross-Platform Compatibility**
Uses system temp directory instead of Windows-specific paths:
```php
$tempDir = sys_get_temp_dir() . '/bot_cookies';
```

### 4. **Proper Session Handling**
Session is properly initialized before use:
```php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
```

## Environment Variables to Set

On your deployment platform (Railway/Heroku), set these environment variables:

- `BOT_TOKEN` - **REQUIRED** - Get from @BotFather on Telegram
- `PROXY_HOST` - *Optional* - Your proxy host:port (leave empty if not using)
- `PROXY_AUTH` - *Optional* - Your proxy credentials (leave empty if not using)

### How to Get Your Bot Token:
1. Open Telegram and search for @BotFather
2. Send `/newbot` command
3. Follow instructions to create your bot
4. Copy the token provided by BotFather
5. Set it as BOT_TOKEN environment variable

## Testing Locally

```bash
php -S localhost:8080 -t .
```

Then use ngrok to expose your local server:
```bash
ngrok http 8080
```

Set the webhook to your ngrok URL.

## Bot Commands

- `/start` - Show welcome message and commands
- `/help` - Show help information
- Send card in format: `CCNUMBER|MM|YYYY|CVV`

## Requirements

- PHP 8.1 or higher (PHP 8.2 recommended)
- cURL extension enabled
- JSON extension enabled
- mbstring extension enabled
- Internet connection for API calls
