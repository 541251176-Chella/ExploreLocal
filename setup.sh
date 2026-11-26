#!/usr/bin/env bash
set -e
APP_DIR="explorelocal-app"

command -v php >/dev/null 2>&1 || { echo "[ERROR] PHP belum terpasang (butuh 8.2+)."; exit 1; }
command -v composer >/dev/null 2>&1 || { echo "[ERROR] Composer belum terpasang: https://getcomposer.org"; exit 1; }

if [ ! -d "$APP_DIR" ]; then
  echo "[1/5] Mengunduh kerangka Laravel..."
  composer create-project laravel/laravel "$APP_DIR" --prefer-dist
else
  echo "[1/5] Folder $APP_DIR sudah ada, dilewati."
fi

echo "[2/5] Menyalin kode ExploreLocal ke project..."
cp -R source/. "$APP_DIR"/

cd "$APP_DIR"

echo "[3/5] Mengatur file .env..."
sed -i.bak \
  -e 's/^APP_NAME=.*/APP_NAME=ExploreLocal/' \
  -e 's/^APP_LOCALE=.*/APP_LOCALE=id/' \
  -e 's/^APP_FAKER_LOCALE=.*/APP_FAKER_LOCALE=id_ID/' .env
rm -f .env.bak

echo "[4/5] Membuat database & mengisi data contoh..."
php artisan migrate:fresh --seed --force

echo "[5/5] Menautkan folder storage..."
php artisan storage:link || true

echo
echo "============================================"
echo " SELESAI! Server berjalan di http://127.0.0.1:8000"
echo " Admin   : http://127.0.0.1:8000/admin/login"
echo " Email   : admin@explorelocal.test"
echo " Password: admin123"
echo "============================================"
php artisan serve
