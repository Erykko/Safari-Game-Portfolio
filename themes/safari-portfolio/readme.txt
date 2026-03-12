=== Safari Portfolio ===
Contributors: ericmutema
Requires at least: 5.8
Tested up to: 6.4
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Block-based portfolio theme with a game-style front page. Includes bundled Safari Portfolio Core (CPTs, ACF fields, seed).

== Description ==

Safari Portfolio is a classic WordPress theme with a one-page game-style front layout. The homepage is built from section blocks (Hero, Toolkit, Sightings, Ranger, Contact) that match a safari/portfolio metaphor. Ideal for developers and creatives who want a distinctive portfolio or landing page.

**Bundled plugin:** The theme includes Safari Portfolio Core, loaded automatically. It registers custom post types (Wildlife Sightings, Field Equipment, The Ranger, etc.), ACF field groups (when ACF Pro is active), and a one-click seed tool plus WP-CLI commands to load default content.

**Features:**
* Custom Gutenberg section blocks (Hero, Toolkit, Sightings, Ranger, Contact, HUD, Progress bar, Divider, Boot screen)
* Bundled Safari Portfolio Core: CPTs, ACF fields, seed data and WP-CLI commands (wp safari seed-skills, seed-projects, seed-ranger, seed-defaults, seed-all)
* Works without ACF Pro (sections show defaults or empty); ACF Pro recommended for full editing
* Translation-ready (load_theme_textdomain)
* Custom logo support
* Threaded comments support
* Responsive, mobile-friendly layout

== Installation ==

1. Install the theme via Appearance → Themes → Add New (or upload the zip).
2. Activate the theme. Safari Portfolio Core (CPTs and seed) is loaded automatically from the theme.
3. Set a static front page in Settings → Reading so the game-style front page is used.
4. (Optional) Install ACF Pro for Global Settings and CPT field editing. Without it, the theme still works with defaults.
5. Use Safari → Seed Content in the admin to load default skills, projects, ranger profile, and copy (or run `wp safari seed-all` via WP-CLI).

== Frequently Asked Questions ==

= Does the theme require any plugins? =

No. The theme bundles Safari Portfolio Core (CPTs and seed). Optional: ACF Pro enables the Global Settings and CPT field groups for full editing. Without ACF Pro, the theme and CPTs still work; you get defaults or empty fields.

= How do I show the game-style front page? =

Set your homepage to a static page in Settings → Reading, and assign any page as the front page. The theme uses front-page.php for that page and displays the full safari layout.

== Changelog ==

= 1.0.0 =
* Initial release.
* Section blocks: Hero, Toolkit, Sightings, Ranger, Contact, HUD, Progress bar, Boot screen, Divider.
* Optional integration with safari-cpts and safari-fields.

== Upgrade Notice ==

= 1.0.0 =
* Initial release of Safari Portfolio.
