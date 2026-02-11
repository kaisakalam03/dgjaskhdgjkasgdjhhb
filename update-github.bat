@echo off
echo ========================================
echo GitHub Update Script
echo ========================================
echo.

cd /d "d:\xampp\htdocs\telegrambot"

echo [1/4] Checking changes...
& "C:\Program Files\Git\bin\git.exe" status
echo.

echo [2/4] Adding all changes...
& "C:\Program Files\Git\bin\git.exe" add .
echo.

echo [3/4] Enter commit message (describe what you changed):
set /p commit_msg="Message: "
echo.

if "%commit_msg%"=="" (
    echo Error: Commit message cannot be empty!
    pause
    exit /b 1
)

echo [4/4] Committing and pushing to GitHub...
& "C:\Program Files\Git\bin\git.exe" commit -m "%commit_msg%"
& "C:\Program Files\Git\bin\git.exe" push
echo.

echo ========================================
echo Update Complete!
echo ========================================
echo.
echo Your changes have been pushed to GitHub.
echo Railway will automatically redeploy your bot.
echo.
pause
