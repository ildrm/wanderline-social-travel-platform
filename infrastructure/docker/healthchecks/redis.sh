#!/bin/sh
set -eu
test "$(redis-cli --raw ping)" = "PONG"

