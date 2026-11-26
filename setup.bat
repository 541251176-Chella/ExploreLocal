@echo off
setlocal
title Setup ExploreLocal
set APP_DIR=explorelocal-app

echo ============================================
echo   Setup ExploreLocal (Laravel)
echo ============================================

where php >nul 2>nul || (echo [ERROR] PHP belum terpasang / belum ada di PATH. Install PHP 8.2+ dulu. & pause & exit /b 1)
where composer >nul 2>nul || (echo [ERROR] Composer belum terpasang. Download di https://getcomposer.org & pause & exit /b 1)

if not exist "%APP_DIR%" (
    echo [1/5] Mengunduh kerangka Laravel... ^(butuh internet, +/- 2-5 menit^)
    call composer create-project laravel/laravel %APP_DIR% --prefer-dist
    if errorlevel 1 (echo [ERROR] Gagal membuat project Laravel. & pause & exit /b 1)
) else (
    echo [1/5] Folder %APP_DIR% sudah ada, dilewati.
)

echo [2/5] Menyalin kode ExploreLocal ke project...
xcopy "source\*" "%APP_DIR%\" /E /Y /I /Q >nul

cd %APP_DIR%

echo [3/5] Mengatur file .env...
powershell -NoProfile -Command "(Get-Content .env) -replace '^APP_NAME=.*','APP_NAME=ExploreLocal' -replace '^APP_LOCALE=.*','APP_LOCALE=id' -replace '^APP_FAKER_LOCALE=.*','APP_FAKER_LOCALE=id_ID' | Set-Content .env -Encoding ascii"

echo [4/5] Membuat database ^& mengisi data contoh...
call php artisan migrate:fresh --seed --force
if errorlevel 1 (echo [ERROR] Migrasi gagal. Pastikan ekstensi pdo_sqlite aktif di php.ini. & pause & exit /b 1)

echo [5/5] Menautkan folder storage untuk upload foto...
call php artisan storage:link

echo.
echo ============================================
echo   SELESAI! Membuka server di http://127.0.0.1:8000
echo   Website : http://127.0.0.1:8000
echo   Admin   : http://127.0.0.1:8000/admin/login
echo   Email   : admin@explorelocal.test
echo   Password: admin123
echo ============================================
call php artisan serve
