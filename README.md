## Safari Portfolio

Safari Portfolio is a game‑style WordPress portfolio theme bundled with a small “core” plugin.  
The front page is a single, highly‑designed safari console composed of server‑rendered blocks
(Hero, Toolkit, Sightings, Ranger, Testimonials, Achievements, Contact, Dispatches) driven by
custom post types and a lightweight JS game engine.

This repository is the **full working project**, not just a distributable zip. It is intended
for:

- Running the theme on real client sites.
- Iterating on the Safari game UX.
- Preparing a WordPress.org‑friendly theme + companion plugin if desired.

---

### Features

- **One‑page game layout**
  - Hero “Base Camp” with mission console.
  - Toolkit (skills) grid.
  - Wildlife Sightings (projects) grid.
  - Ranger profile (stats, bio, specialties).
  - Testimonials (“Animal Tracks”), Achievements (“Field Medals”), Dispatches (blog), Contact.
- **Bundled core plugin (`plugins/safari-portfolio-core/`)**
  - Custom post types: `safari_project`, `safari_skill`, `safari_ranger`,
    `safari_testimonial`, `safari_achievement`, `safari_dispatch`, `safari_easter_egg`.
  - ACF‑free field groups (works with free ACF, or via post meta if ACF is absent).
  - Global settings stored in a single option (`safari_global_settings`) via
    `Safari_Settings` (no ACF options pages).
  - Seed tools (admin Seed Content page + WP‑CLI commands).
- **Blocks**
  - Server‑rendered blocks registered under the `safari/*` namespace.
  - Editor‑side JS (`assets/js/safari-blocks-editor.js`) so blocks appear in the inserter under
    the “Safari Portfolio” category with Inspector controls and live ServerSideRender previews.
- **Game engine**
  - `assets/js/game.js` consumes localized `SafariData` (skills, projects, achievements,
    easter eggs, config) and wires up animations, achievements, and progress tracking in the UI.

---

### Project structure

- `themes/safari-portfolio/`
  - Classic theme (non–block‑theme) templates: `front-page.php`, `page.php`, `single.php`,
    `archive-safari_dispatch.php`, `comments.php`, `template-parts/*`.
  - Theme bootstrap and hooks in `functions.php`, `inc/theme-setup.php`, `inc/enqueue.php`,
    `inc/block-registration.php`, `inc/game-data.php`, `inc/contact-*`.
  - Game UI assets: `assets/css/game.css`, `assets/js/game.js`, audio files.
  - Editor‑only block JS: `assets/js/safari-blocks-editor.js`.
- `themes/safari-portfolio/plugins/safari-portfolio-core/`
  - `safari-portfolio-core.php`: plugin loader, admin menu (`Safari` top‑level), settings page,
    and field group loader.
  - `includes/class-safari-register-cpts.php`: registers all CPTs.
  - `includes/class-safari-settings.php`: native WP settings page + helper API.
  - `includes/class-safari-seed.php`: seed logic and admin Seed Content page.
  - `includes/class-safari-wpcli.php`: `wp safari` seed commands.
  - `field-groups/*.php`: ACF local field group definitions (only free field types).
  - `seed-data/*.json`: skills, projects, ranger, and global defaults.

---

### Requirements

- PHP 7.4+
- WordPress 5.8+ (tested up to WP 6.4)
- Optional (but supported):
  - ACF (free) – enhances the edit UI for CPT meta fields.
  - Any common contact‑form plugin (CF7, WPForms, Gravity Forms, Ninja Forms,
    Formidable, Fluent Forms) – can be wired into the Contact section.

The project **does not require ACF Pro**; all former Pro‑only usage has been refactored into
native settings and simple post meta.

---

### Installation & setup

1. **Clone the repo into your WordPress `wp-content` directory**

   ```bash
   cd wp-content
   git clone https://github.com/<your-user>/safari-portfolio.git Safari-Game-Portfolio
   ```

2. **Activate the theme**

   - In the WP admin, go to Appearance → Themes.
   - Activate **“Safari Portfolio”**.
   - The bundled **Safari Portfolio Core** plugin is loaded automatically from
     `themes/safari-portfolio/plugins/safari-portfolio-core/`.

3. **Configure the homepage**

   - Go to Settings → Reading.
   - Set “Your homepage displays” to **A static page**.
   - Choose any page as the front page. The theme’s `front-page.php` will render the full
     safari layout automatically.
   - Alternatively, select the **“Safari Portfolio”** page template (`page-safari-portfolio.php`)
     on a page; it renders the same layout.

4. **Seed demo content (skills, projects, ranger, copy)**

   - In the WP admin sidebar, open **Safari → Seed Content**.
   - Click **“Seed all content”**. This will:
     - Create/update demo skills (`safari_skill`).
     - Create/update demo projects (`safari_project`).
     - Create/update the ranger profile (`safari_ranger`).
     - Populate global settings (hero text, section labels, contact copy, HUD nav, toggles).

   Or via WP‑CLI:

   ```bash
   wp safari seed-all
   # or individually:
   wp safari seed-skills
   wp safari seed-projects
   wp safari seed-ranger
   wp safari seed-defaults
   ```

5. **Adjust global settings**

   - Go to **Safari → Global Settings**.
   - Tabs:
     - **Sections** – show/hide hero, toolkit, sightings, ranger, testimonials, achievements,
       contact, dispatches, HUD, progress bar, boot screen.
     - **Hero** – all hero text and meta.
     - **Section Labels** – per‑section labels/titles/subtitles.
     - **Contact** – contact copy + choice of built‑in form, plugin form, or custom shortcode.
     - **HUD** – HUD logo, mission label, and up to 6 nav links.
     - **Boot Screen** – kicker text.

---

### Development notes

- The project is designed to work **without ACF Pro**:
  - All options are in a native `Safari_Settings` page.
  - CPT meta is read via `safari_read_field()` which falls back from ACF to `get_post_meta()`.
- Blocks are **server‑rendered**, with a small editor‑side wrapper so they appear in Gutenberg:
  - Registration: `inc/block-registration.php`
  - Editor JS: `assets/js/safari-blocks-editor.js`
  - Render callbacks: `inc/blocks/safari-*.php`
- Game data passed to JS:
  - `inc/game-data.php` builds `SafariData` (skills, projects, achievements, easter eggs, config).
  - Localized in `inc/enqueue.php` for front page and Safari Portfolio template pages.

To iterate on styles/JS, edit `assets/css/game.css` and `assets/js/game.js`, then reload the
front page. File modification times are used as cache‑busting versions.

---

### Theme Check / WordPress.org considerations

This repo is optimized for **real‑world use**, not strict WordPress.org theme directory rules.
Notable differences:

- CPT registration and some block registration live in the bundled `safari-portfolio-core`
  plugin under the theme folder. For .org submission, they should be moved to a separate
  plugin outside the theme.
- Multiple text domains exist (`safari-portfolio`, `safari-portfolio-core`, `safari-cpts`).
  For .org compatibility, you’d want to standardize on a single text domain.

If you plan to publish to WordPress.org, use this repo as the canonical source, then extract:

- A pure theme (no CPTs, no plugin‑territory code).
- A companion “Safari Portfolio Core” plugin containing CPTs, seed logic, and block
  registration.

