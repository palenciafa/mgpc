@echo off
REM Database Backup Script for MGPC
REM This script runs the database backup command

cd /d C:\xampp\htdocs\mgpc

REM Run the backup command
php artisan db:backup

REM Log the result
echo Backup completed at %date% %time% >> storage\logs\backup.log

pause
