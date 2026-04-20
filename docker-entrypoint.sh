#!/usr/bin/env bash
set -e

if [ "${MIGRATE_ON_START:-false}" = "true" ]; then
  echo "[Render] Running Laravel migrations..."
  retries=10
  until php artisan migrate --force; do
    retries=$((retries - 1))
    if [ $retries -le 0 ]; then
      echo "[Render] Migration failed after multiple attempts."
      exit 1
    fi
    echo "[Render] Migration failed, retrying in 5 seconds... ($retries remaining)"
    sleep 5
  done
  echo "[Render] Migrations completed."
fi

# Configure Apache for Render
echo "[Render] Configuring Apache port..."

# Change port to PORT environment variable if set
if [ -n "$PORT" ]; then
  sed -i "s/:80/:$PORT/g" /etc/apache2/sites-available/000-default.conf
  sed -i "s/Listen 80/Listen $PORT/g" /etc/apache2/ports.conf
fi

echo "[Render] Apache port configured."

exec apache2-foreground
