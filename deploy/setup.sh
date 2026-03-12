#!/usr/bin/env bash
# Full fresh-install script for Safari Portfolio WordPress.
# Run from repo root or WordPress root. Expects wp-cli available and .env for config.
# After activating theme and plugins, runs Safari seed commands so the site has default content.

set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
REPO_ROOT="$(cd "$SCRIPT_DIR/.." && pwd)"
# If WP root is not current dir, set WP_ROOT to your WordPress path (e.g. REPO_ROOT/wp or /var/www/html)
WP_ROOT="${WP_ROOT:-$REPO_ROOT}"

echo "Safari Portfolio — fresh install (setup.sh)"
echo "Repo root: $REPO_ROOT"
echo "WP root:   $WP_ROOT"

cd "$WP_ROOT"

# 1. WordPress core (if not already present)
if [ ! -f wp-settings.php ]; then
  wp core download
fi

# 2. Config (requires .env or existing wp-config.php)
if [ ! -f wp-config.php ]; then
  wp config create --prompt 2>/dev/null || true
fi

# 3. Install (if not already installed)
wp core is-installed 2>/dev/null || wp core install --url="${WP_URL:-http://localhost}" --title="${WP_TITLE:-Eric Mutema}" --admin_user="${WP_USER:-admin}" --admin_password="${WP_PASSWORD:-admin}" --admin_email="${WP_EMAIL:-admin@localhost}" --skip-email

# 4. Composer (if composer.json present)
if [ -f "$REPO_ROOT/composer.json" ]; then
  (cd "$REPO_ROOT" && composer install --no-interaction)
fi

# 5. Activate custom plugins (from repo plugins dir)
for plug in safari-cpts safari-fields; do
  if [ -d "$REPO_ROOT/plugins/$plug" ]; then
    wp plugin activate "$plug" 2>/dev/null || true
  fi
done

# 6. Activate theme
if [ -d "$REPO_ROOT/themes/safari-portfolio" ]; then
  wp theme activate safari-portfolio 2>/dev/null || true
fi

# 7. Seed content (Safari CPTs plugin)
echo "Seeding Safari content..."
wp safari seed-skills   2>/dev/null || true
wp safari seed-projects  2>/dev/null || true
wp safari seed-ranger   2>/dev/null || true
wp safari seed-defaults 2>/dev/null || true

# 8. Site identity
wp option update blogname "Eric Mutema" 2>/dev/null || true

# 9. Rewrite flush
wp rewrite flush

echo "Setup complete. Visit the site and Safari > Seed Content to re-run seeds if needed."
