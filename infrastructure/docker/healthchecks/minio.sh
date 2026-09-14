#!/bin/sh
set -eu
exec curl --fail --silent --show-error http://127.0.0.1:9000/minio/health/live
