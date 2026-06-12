#!/bin/bash
# ─────────────────────────────────────────────────────────────────
#  Samiur Rahman Portfolio — Laravel Dev Server Start Script
# ─────────────────────────────────────────────────────────────────

cd "$(dirname "$0")"

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "  Samiur Rahman Portfolio — Laravel"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

# Clear caches silently
php artisan config:clear --quiet
php artisan view:clear   --quiet
php artisan cache:clear  --quiet

echo "  ✓ Caches cleared"
echo "  ➜  http://127.0.0.1:8000"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

php artisan serve
