#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
DIST_DIR="$ROOT_DIR/dist"
TIMESTAMP="$(date +%Y%m%d-%H%M%S)"
ZIP_PATH="$DIST_DIR/edulaw-hostinger-$TIMESTAMP.zip"

mkdir -p "$DIST_DIR"

cd "$ROOT_DIR"

zip -qr "$ZIP_PATH" . \
    -x "vendor/*" \
    -x "node_modules/*" \
    -x ".git/*" \
    -x ".github/*" \
    -x ".vscode/*" \
    -x "dist/*" \
    -x ".env" \
    -x ".env.backup" \
    -x ".env.production" \
    -x ".DS_Store" \
    -x "*/.DS_Store" \
    -x "__MACOSX/*" \
    -x "*/__MACOSX/*" \
    -x "storage/logs/*" \
    -x "storage/framework/cache/*" \
    -x "storage/framework/sessions/*" \
    -x "storage/framework/views/*" \
    -x "bootstrap/cache/*.php"

echo "$ZIP_PATH"
