@echo off
REM Setup script to deploy this project into a local XAMPP installation
REM Usage: Run this script from the project root (double-click or run in cmd as Administrator recommended)

setlocal
set "DEFAULT_XAMPP=C:\xampp"
echo This script will copy the project into your XAMPP htdocs and import the database.
echo.
set /p XAMPP=Enter XAMPP installation path (press Enter for %DEFAULT_XAMPP%): 
if "%XAMPP%"=="" set "XAMPP=%DEFAULT_XAMPP%"

if not exist "%XAMPP%\htdocs" (
  echo Could not find XAMPP htdocs at %XAMPP%\htdocs
  echo Please ensure XAMPP is installed and try again.
  pause
  exit /b 1
)

set "TARGET=%XAMPP%\htdocs\class-management"
echo Copying project to %TARGET% ...
robocopy "%~dp0" "%TARGET%" /MIR /XD .git .gitpod docker node_modules vendor .vscode

echo.
echo Importing database schema into MySQL (this requires MySQL to be running in XAMPP)...
if not exist "%XAMPP%\mysql\bin\mysql.exe" (
  echo Could not find mysql.exe in %XAMPP%\mysql\bin
  echo Start MySQL via the XAMPP Control Panel and press any key to continue, or Cancel to abort.
  pause
) 

set /p MYSQL_PW=Enter MySQL root password (leave blank if none): 
if "%MYSQL_PW%"=="" (
  "%XAMPP%\mysql\bin\mysql.exe" -u root < "%TARGET%\db.sql"
) else (
  "%XAMPP%\mysql\bin\mysql.exe" -u root -p%MYSQL_PW% < "%TARGET%\db.sql"
)

echo.
echo Running seed script to add demo users and sample class (uses XAMPP PHP CLI)...
if exist "%XAMPP%\php\php.exe" (
  "%XAMPP%\php\php.exe" "%TARGET%\seed.php"
) else (
  echo PHP CLI not found at %XAMPP%\php\php.exe. You can run the seed script via the web: http://localhost/class-management/seed.php
)

echo.
echo Setup complete. Opening the app in your browser...
start "" "http://localhost/class-management/"

echo.
echo If Apache or MySQL are not running, open XAMPP Control Panel and start Apache and MySQL.
pause
