@echo off
REM Run Laravel migrations to fix database schema
cd /d "e:\Binus\Sems 4\WBP\AOL\kependudukan"

echo.
echo ========================================
echo Running Database Migration...
echo ========================================
echo.

php artisan migrate --no-interaction

if %ERRORLEVEL% EQU 0 (
    echo.
    echo ✓ Migration completed successfully!
    echo.
) else (
    echo.
    echo ✗ Migration failed. Please check the error above.
    echo.
)

pause
