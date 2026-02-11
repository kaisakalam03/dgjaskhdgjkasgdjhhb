@echo off
echo ========================================
echo Node.js Bot Deployment
echo ========================================
echo.

cd /d "d:\xampp\htdocs\telegrambot"

echo [1/4] Installing dependencies...
call npm install
echo.

echo [2/4] Testing bot...
node -e "console.log('Node.js version:', process.version)"
echo.

echo [3/4] Committing changes...
& "C:\Program Files\Git\bin\git.exe" add .
set /p commit_msg="Commit message (or press Enter for default): "
if "%commit_msg%"=="" set commit_msg="Convert to Node.js"
& "C:\Program Files\Git\bin\git.exe" commit -m "%commit_msg%"
echo.

echo [4/4] Pushing to GitHub...
& "C:\Program Files\Git\bin\git.exe" push
echo.

echo ========================================
echo Deployment Complete!
echo ========================================
echo.
echo Next steps:
echo 1. Railway will automatically detect package.json
echo 2. Set environment variables in Railway dashboard
echo 3. Set webhook after deployment
echo.
pause
