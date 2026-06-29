#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT_DIR"

BASE_PATH="${VITE_BASE_PATH:-/tokentosser/}"
OUTPUT_DIR="${GITHUB_PAGES_OUTPUT_DIR:-dist}"

if [[ ! -f .env ]]; then
    cp .env.example .env
    php artisan key:generate --force --no-interaction
fi

sed -i \
    -e 's/^SESSION_DRIVER=.*/SESSION_DRIVER=file/' \
    -e 's/^CACHE_STORE=.*/CACHE_STORE=file/' \
    -e 's/^QUEUE_CONNECTION=.*/QUEUE_CONNECTION=sync/' \
    .env

# Avoid database requirements when exporting a static page.
php artisan config:clear --no-interaction

export VITE_BASE_PATH="$BASE_PATH"

npm ci
npm run build

rm -rf "$OUTPUT_DIR"
mkdir -p "$OUTPUT_DIR"

php artisan tinker --execute 'file_put_contents(base_path("'"$OUTPUT_DIR"'/index.html"), view("welcome")->render());'

for asset in favicon.ico robots.txt tokentosser.gif; do
    if [[ -f "public/$asset" ]]; then
        cp "public/$asset" "$OUTPUT_DIR/$asset"
    fi
done

cp -r public/build "$OUTPUT_DIR/build"
touch "$OUTPUT_DIR/.nojekyll"

echo "GitHub Pages site built in $OUTPUT_DIR (base: $BASE_PATH)"
