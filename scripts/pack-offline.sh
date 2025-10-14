#!/usr/bin/env bash
set -euo pipefail

# Script to create an offline package of the project.
# Usage: ./scripts/pack-offline.sh
# Run this on your machine (online) after you have built assets and installed composer vendor.

PROJECT_ROOT="$(cd "$(dirname "$0")/.." && pwd)"
OUTDIR="$PROJECT_ROOT/dist"
OUTNAME="inventaris-offline-$(date +%Y%m%d-%H%M%S).tar.gz"
TMPDIR="/tmp/inventaris-offline-pack"

echo "Project root: $PROJECT_ROOT"

# Checks
if [ ! -f "$PROJECT_ROOT/database/database.sqlite" ]; then
  echo "ERROR: database/database.sqlite not found. Please create or copy your sqlite file before packaging." >&2
  exit 1
fi

if [ ! -d "$PROJECT_ROOT/vendor" ]; then
  echo "ERROR: vendor directory not found. Run 'composer install --no-dev --optimize-autoloader' before packaging." >&2
  exit 1
fi

# Clean up previous tmp
rm -rf "$TMPDIR"
mkdir -p "$TMPDIR"

# Copy project into temp dir excluding development-only folders
rsync -a --exclude ".git" \
          --exclude "node_modules" \
          --exclude "tests" \
          --exclude ".vscode" \
          --exclude ".idea" \
          --exclude "*.log" \
          --exclude "dist" \
          "$PROJECT_ROOT/" "$TMPDIR/project/"

# Ensure .env exists in the copy. If you want to include your .env, copy it into the repo before running this script.
if [ ! -f "$TMPDIR/project/.env" ]; then
  echo "WARNING: .env not included in package. If the app requires a specific APP_KEY or env values, copy .env into the project root before packaging." >&2
fi

mkdir -p "$OUTDIR"

tar -C "$TMPDIR" -czf "$OUTDIR/$OUTNAME" project

# Clean up
rm -rf "$TMPDIR"

echo "Created offline package: $OUTDIR/$OUTNAME"

echo "Files included (top-level in archive):"
 tar -tzf "$OUTDIR/$OUTNAME" | sed -n '1,40p'

exit 0
