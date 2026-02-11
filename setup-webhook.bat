@echo off
echo ========================================
echo Telegram Bot Webhook Setup
echo ========================================
echo.

echo This script will help you set up your Telegram webhook.
echo.
echo You need:
echo 1. Your Bot Token (from @BotFather)
echo 2. Your deployment URL (from Railway/Heroku)
echo.

set /p bot_token="Enter your Bot Token: "
set /p app_url="Enter your App URL (e.g., https://your-app.railway.app): "

echo.
echo ========================================
echo Setting Webhook...
echo ========================================
echo.

REM Remove trailing slash if present
set "app_url=%app_url:/=%"

REM Set webhook URL
set "webhook_url=https://api.telegram.org/bot%bot_token%/setWebhook?url=%app_url%"

echo Calling Telegram API...
echo.
curl "%webhook_url%"
echo.
echo.

echo ========================================
echo Checking Webhook Status...
echo ========================================
echo.

REM Get webhook info
set "info_url=https://api.telegram.org/bot%bot_token%/getWebhookInfo"
curl "%info_url%"
echo.
echo.

echo ========================================
echo Setup Complete!
echo ========================================
echo.
echo If you see "ok":true above, your webhook is set!
echo.
echo You can now:
echo 1. Send /start to your bot on Telegram
echo 2. Test card checking: 4350940005555920^|07^|2025^|123
echo.
pause
