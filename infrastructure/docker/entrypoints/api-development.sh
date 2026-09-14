#!/bin/sh
set -eu

lock_hash="$(sha256sum composer.lock | awk '{print $1}')"
stamp_file="vendor/.composer-lock.sha256"
installed_hash=""

if [ -f "${stamp_file}" ]; then
    installed_hash="$(cat "${stamp_file}")"
fi

if [ "${installed_hash}" != "${lock_hash}" ] || [ ! -f vendor/autoload.php ]; then
    echo "Composer lock changed; synchronizing the development dependency volume."
    composer install --prefer-dist --no-interaction --no-progress
    printf '%s\n' "${lock_hash}" > "${stamp_file}"
fi

exec "$@"
