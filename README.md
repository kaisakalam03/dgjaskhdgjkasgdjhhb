# Telegram Card Checker Bot

A PHP-based Telegram bot for card validation.

## Deployment Files

The following files have been created for deployment:

- `start.sh` - Startup script for the PHP web server
- `Procfile` - Process file for platform deployment
- `railway.toml` - Railway-specific configuration
- `composer.json` - PHP dependency management
- `.gitignore` - Git ignore rules

## Deployment Instructions

### Railway Deployment

1. Make sure all files are committed to git:
   ```bash
   git add .
   git commit -m "Add deployment configuration"
   git push
   ```

2. Connect your repository to Railway

3. The bot will automatically deploy using the configuration files

4. Set the webhook URL in Telegram:
   ```
   https://api.telegram.org/bot<YOUR_BOT_TOKEN>/setWebhook?url=https://<your-railway-url>/telegram_bot.php
   ```

### Heroku Deployment

1. Install Heroku CLI
2. Login: `heroku login`
3. Create app: `heroku create your-app-name`
4. Push: `git push heroku main`
5. Set webhook as described above

## ⚠️ IMPORTANT SECURITY WARNINGS

Your current code has several security issues that MUST be fixed before deployment:

### 1. **EXPOSED BOT TOKEN** (Line 6)
```php
define('BOT_TOKEN', '8269957175:AAEA2PiWIt5s3KWsvRJRLRKXnY-tdko9z-4');
```
**Fix:** Use environment variables instead:
```php
define('BOT_TOKEN', getenv('BOT_TOKEN') ?: 'your-token-here');
```

### 2. **EXPOSED PROXY CREDENTIALS** (Lines 77-78)
```php
$proxy = 'proxy.okeyproxy.com:31212';
$proxyuserpwd = 'customer-4nao708160-continent-AS-country-SG:7tzdwvba';
```
**Fix:** Move to environment variables

### 3. **WINDOWS-SPECIFIC PATHS** (Lines 13, 221, 274)
```php
!is_dir('C:\xampp\c') ? shell_exec('mkdir C:\xampp\c') : NULL;
```
**Fix:** Use cross-platform paths:
```php
$tempDir = sys_get_temp_dir() . '/bot_cookies';
if (!is_dir($tempDir)) {
    mkdir($tempDir, 0755, true);
}
```

### 4. **SESSION WITHOUT session_start()**
The code uses `$_SESSION` without initializing it (Line 46)

**Fix:** Add at the beginning:
```php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
```

## Environment Variables to Set

On your deployment platform (Railway/Heroku), set these environment variables:

- `BOT_TOKEN` - Your Telegram bot token
- `PROXY_HOST` - Your proxy host
- `PROXY_AUTH` - Your proxy authentication credentials

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
