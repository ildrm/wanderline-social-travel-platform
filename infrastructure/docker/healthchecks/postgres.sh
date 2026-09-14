#!/bin/sh
set -eu
exec pg_isready -q -U "${POSTGRES_USER}" -d "${POSTGRES_DB}"

