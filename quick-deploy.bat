@echo off
echo ========================================
echo Telegram Bot Deployment Helper
echo ========================================
echo.

echo Checking requirements...
echo.

REM Check if git is installed
where git >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo [!] Git is not installed
    echo     Download from: https://git-scm.com/download/win
    echo.
    goto :nogit
)

echo [+] Git found
echo.

echo ========================================
echo Deploying to Git Repository
echo ========================================
echo.

REM Add all files
git add .

REM Commit changes
git commit -m "Add deployment configuration and security fixes"

REM Push to origin
git push

echo.
echo ========================================
echo Deployment Complete!
echo ========================================
echo.
echo Next steps:
echo 1. Your code is now pushed to your git repository
echo 2. Go to https://railway.app/ or https://render.com/
echo 3. Create a new project and connect your GitHub repo
echo 4. Set BOT_TOKEN environment variable
echo 5. Deploy will happen automatically
echo.
echo After deployment, set webhook:
echo https://api.telegram.org/bot8269957175:AAEA2PiWIt5s3KWsvRJRLRKXnY-tdko9z-4/setWebhook?url=https://YOUR-APP-URL/telegram_bot.php
echo.
pause
exit /b 0

:nogit
echo ========================================
echo Install Git First
echo ========================================
echo.
echo Option 1: Install Git
echo - Download: https://git-scm.com/download/win
echo - Install with default settings
echo - Run this script again
echo.
echo Option 2: Deploy without Git
echo - Go to https://railway.app/
echo - Click "Start a New Project"
echo - Choose "Deploy from GitHub"
echo - Or use "Deploy from Local Directory" if available
echo.
echo Option 3: Use Railway CLI
echo - Install Node.js from https://nodejs.org/
echo - Run: npm i -g @railway/cli
echo - Run: railway login
echo - Run: railway up
echo.
pause
exit /b 1
