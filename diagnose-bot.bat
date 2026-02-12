@echo off
echo ========================================
echo Telegram Bot Troubleshooting
echo ========================================
echo.

set /p bot_token="Enter your Bot Token: "

echo.
echo [1/5] Checking if bot token is valid...
echo ========================================
curl "https://api.telegram.org/bot%bot_token%/getMe"
echo.
echo.

echo [2/5] Checking current webhook status...
echo ========================================
curl "https://api.telegram.org/bot%bot_token%/getWebhookInfo"
echo.
echo.

echo [3/5] Getting recent updates...
echo ========================================
curl "https://api.telegram.org/bot%bot_token%/getUpdates"
echo.
echo.

echo ========================================
echo Diagnostics Complete!
echo ========================================
echo.
echo Please check the output above:
echo.
echo 1. If "getMe" failed - Your bot token is invalid
echo 2. If "webhook" url is empty - Webhook is not set
echo 3. If you see messages in "getUpdates" - Bot received them but didn't respond
echo.
echo Common Issues:
echo - Webhook not set (run setup-webhook.bat)
echo - Bot not deployed on Railway
echo - BOT_TOKEN environment variable not set in Railway
echo - App URL is wrong in webhook
echo.
pause
