@echo off
echo ========================================
echo Bot Restart Options
echo ========================================
echo.
echo Choose your restart method:
echo.
echo 1. Restart on Railway (Recommended)
echo 2. Force redeploy (push empty commit)
echo 3. Restart local test server
echo.
set /p choice="Enter choice (1-3): "
echo.

if "%choice%"=="1" goto railway
if "%choice%"=="2" goto redeploy
if "%choice%"=="3" goto local
goto end

:railway
echo ========================================
echo Restarting on Railway
echo ========================================
echo.
echo To restart your bot on Railway:
echo.
echo Option A: Using Railway Dashboard
echo   1. Go to: https://railway.app/
echo   2. Select your project
echo   3. Click on your service
echo   4. Click the three dots (...)
echo   5. Click "Restart"
echo.
echo Option B: Using Railway CLI
echo   Run: railway service restart
echo.
pause
goto end

:redeploy
echo ========================================
echo Force Redeployment
echo ========================================
echo.
echo Creating empty commit to trigger redeploy...
cd /d "d:\xampp\htdocs\telegrambot"
& "C:\Program Files\Git\bin\git.exe" commit --allow-empty -m "Restart bot - force redeploy"
& "C:\Program Files\Git\bin\git.exe" push
echo.
echo ========================================
echo Redeploy Triggered!
echo ========================================
echo.
echo Railway will automatically detect the push and redeploy.
echo This takes about 2-3 minutes.
echo.
pause
goto end

:local
echo ========================================
echo Restart Local Test Server
echo ========================================
echo.
echo To restart locally:
echo 1. Press Ctrl+C in the terminal running the bot
echo 2. Run: php -S localhost:8080 -t .
echo 3. In another terminal: ngrok http 8080
echo.
pause
goto end

:end
