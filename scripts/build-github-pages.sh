#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT_DIR"

OUTPUT_DIR="${GITHUB_PAGES_OUTPUT_DIR:-dist}"
BASE_PATH="${VITE_BASE_PATH:-}"
PAGES_URL="${GITHUB_PAGES_URL:-}"
ASSET_URL_PATH=""

if [[ -f public/CNAME ]]; then
    CUSTOM_DOMAIN="$(tr -d '[:space:]' < public/CNAME)"
    PAGES_URL="${PAGES_URL:-https://${CUSTOM_DOMAIN}}"
    BASE_PATH="${BASE_PATH:-./}"
    ASSET_URL_PATH=""
elif [[ -z "$BASE_PATH" ]]; then
    BASE_PATH="/tokentosser/"
fi

BASE_PATH_TRIM="${BASE_PATH%/}"

if [[ -z "$PAGES_URL" ]]; then
    if [[ -z "$BASE_PATH_TRIM" || "$BASE_PATH_TRIM" == "." || "$BASE_PATH_TRIM" == "/" ]]; then
        PAGES_URL="https://${GITHUB_REPOSITORY_OWNER:-benbrackenbury}.github.io"
    else
        PAGES_URL="https://${GITHUB_REPOSITORY_OWNER:-benbrackenbury}.github.io${BASE_PATH_TRIM}"
        ASSET_URL_PATH="$BASE_PATH_TRIM"
    fi
fi

if [[ "$BASE_PATH" == "./" || "$BASE_PATH" == "." ]]; then
    ASSET_URL_PATH=""
fi

if [[ ! -f .env ]]; then
    cp .env.example .env
    php artisan key:generate --force --no-interaction
fi

sed -i \
    -e 's/^SESSION_DRIVER=.*/SESSION_DRIVER=file/' \
    -e 's/^CACHE_STORE=.*/CACHE_STORE=file/' \
    -e 's/^QUEUE_CONNECTION=.*/QUEUE_CONNECTION=sync/' \
    -e "s|^APP_URL=.*|APP_URL=${PAGES_URL}|" \
    -e 's/^APP_NAME=.*/APP_NAME="Token Tosser"/' \
    .env

if grep -q '^ASSET_URL=' .env; then
    sed -i "s|^ASSET_URL=.*|ASSET_URL=${ASSET_URL_PATH}|" .env
else
    echo "ASSET_URL=${ASSET_URL_PATH}" >> .env
fi

php artisan config:clear --no-interaction

export VITE_BASE_PATH="$BASE_PATH"

npm ci
npm run build

rm -rf "$OUTPUT_DIR"
mkdir -p "$OUTPUT_DIR"

php artisan tinker --execute 'file_put_contents(base_path("'"$OUTPUT_DIR"'/index.html"), view("welcome", app(\App\Services\ProfileDataService::class)->get())->render());'

sed -i "s|http://localhost|${PAGES_URL}|g" "$OUTPUT_DIR/index.html"

for asset in favicon.ico robots.txt tokentosser.gif og-image.png CNAME; do
    if [[ -f "public/$asset" ]]; then
        cp "public/$asset" "$OUTPUT_DIR/$asset"
    fi
done

cp -r public/build "$OUTPUT_DIR/build"
touch "$OUTPUT_DIR/.nojekyll"

echo "GitHub Pages site built in $OUTPUT_DIR (base: $BASE_PATH, url: $PAGES_URL)"
