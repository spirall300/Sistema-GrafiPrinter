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

exec apache2-foreground
