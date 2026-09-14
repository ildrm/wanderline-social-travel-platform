#!/bin/sh
set -eu

lock_hash="$(sha256sum package-lock.json | awk '{print $1}')"
stamp_file="node_modules/.package-lock.sha256"
next_stamp_file="apps/web/.next/.package-lock.sha256"
installed_hash=""

if [ -f "${stamp_file}" ]; then
    installed_hash="$(cat "${stamp_file}")"
fi

case "$(uname -m)" in
    x86_64) oxide_arch=x64 ;;
    aarch64) oxide_arch=arm64 ;;
    *) echo "Unsupported development container architecture: $(uname -m)" >&2; exit 1 ;;
esac

oxide_binding="tailwindcss-oxide.linux-${oxide_arch}-musl.node"

if [ "${installed_hash}" != "${lock_hash}" ] || [ ! -f "apps/web/node_modules/@tailwindcss/oxide/${oxide_binding}" ]; then
    echo "npm lock or native platform changed; synchronizing the development dependency volume."
    npm ci
    oxide_version="$(node -p "JSON.parse(require('fs').readFileSync('apps/web/node_modules/@tailwindcss/oxide/package.json')).version")"
    npm install --no-save --package-lock=false --prefix apps/web "@tailwindcss/oxide-linux-${oxide_arch}-musl@${oxide_version}"
    cp "apps/web/node_modules/@tailwindcss/oxide-linux-${oxide_arch}-musl/${oxide_binding}" \
        "apps/web/node_modules/@tailwindcss/oxide/${oxide_binding}"
    printf '%s\n' "${lock_hash}" > "${stamp_file}"
fi

next_hash=""
if [ -f "${next_stamp_file}" ]; then
    next_hash="$(cat "${next_stamp_file}")"
fi

if [ "${next_hash}" != "${lock_hash}" ]; then
    echo "npm lock changed; invalidating the Next.js development cache."
    find apps/web/.next -mindepth 1 -delete
    printf '%s\n' "${lock_hash}" > "${next_stamp_file}"
fi

exec "$@"
