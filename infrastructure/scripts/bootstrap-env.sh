#!/bin/sh
set -eu

if [ ! -f .env ]; then
    cp .env.example .env
fi

if grep -q '^APP_KEY=$' .env; then
    key="base64:$(openssl rand -base64 32 | tr -d '\n')"
    temporary_file="$(mktemp)"
    sed "s|^APP_KEY=$|APP_KEY=${key}|" .env > "${temporary_file}"
    mv "${temporary_file}" .env
    chmod 600 .env
fi

echo "Local environment is ready. Secrets remain in the git-ignored .env file."
