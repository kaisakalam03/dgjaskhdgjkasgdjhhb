@echo off
echo ========================================
echo Starting Local Bot Test
echo ========================================
echo.

echo [1/2] Checking Node.js installation...
node --version
if %ERRORLEVEL% NEQ 0 (
    echo.
    echo ERROR: Node.js is not installed!
    echo Download from: https://nodejs.org/
    pause
    exit /b 1
)
echo.

echo [2/2] Starting bot server...
echo ========================================
echo.
echo Bot will start on http://localhost:8080
echo.
echo IMPORTANT: You need to set BOT_TOKEN first!
echo.
set /p bot_token="Enter your Bot Token (or press Ctrl+C to cancel): "
echo.

REM Set environment variable
set BOT_TOKEN=%bot_token%

echo Starting bot...
echo.
echo Once running:
echo 1. Keep this window open
echo 2. In another terminal, run: ngrok http 8080
echo 3. Set webhook with ngrok URL
echo 4. Test on Telegram!
echo.
echo Press Ctrl+C to stop the bot
echo.
echo ========================================
echo.

node bot.js
