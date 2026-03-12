/**
 * safari-portfolio/assets/js/data.js
 * ─────────────────────────────────────────────────────────────
 * Static game data: toolkit equipment & wildlife sightings.
 * Loaded before game.js so SafariData is available at runtime.
 * ─────────────────────────────────────────────────────────────
 */

/* =====================
   FIELD EQUIPMENT (Skills)
   ===================== */
const SafariTools = [
  { icon: '🌐', name: 'WordPress',     desc: 'Core CMS platform — from themes to plugins',   level: '95%' },
  { icon: '🛒', name: 'WooCommerce',   desc: 'E-commerce solutions and custom stores',         level: '90%' },
  { icon: '⚙️', name: 'PHP / Laravel', desc: 'Backend logic, APIs, and frameworks',            level: '85%' },
  { icon: '🧱', name: 'Bricks Builder',desc: 'Advanced visual website construction',           level: '92%' },
  { icon: '🎨', name: 'Elementor',     desc: 'Page building and visual design',                level: '88%' },
  { icon: '📋', name: 'ACF',           desc: 'Advanced Custom Fields for flexible data',       level: '94%' },
  { icon: '⚡', name: 'JavaScript',    desc: 'Dynamic interactions and frontend logic',        level: '82%' },
  { icon: '💅', name: 'CSS / ACSS',    desc: 'Styling, animations, and design systems',        level: '88%' },
  { icon: '🤖', name: 'OpenAI API',    desc: 'AI-powered plugin and tool development',         level: '70%' },
  { icon: '📬', name: 'Gravity Forms', desc: 'Complex form solutions and integrations',        level: '87%' },
];

/* =====================
   WILDLIFE SIGHTINGS (Projects)
   ===================== */
const SafariProjects = [
  {
    animal:   '🦁',
    name:     'Heritage Hills',
    desc:     'Bespoke development for a subscriptions and membership website — a majestic lion among web projects.',
    tools:    ['ACF', 'WooCommerce'],
    url:      'https://heritagehills.org/',
    featured: true,
  },
  {
    animal:   '🐘',
    name:     'Natural Circles of Support',
    desc:     'A powerful community website built with precision and care, standing tall like an elephant.',
    tools:    ['Bricks', 'ACSS', 'ACF', 'Gravity Forms'],
    url:      'https://naturalcircles.org/',
    featured: false,
  },
  {
    animal:   '🐆',
    name:     'The Underdog Family',
    desc:     'Non-profit site with speed and agility — a swift leopard leaping across the savanna.',
    tools:    ['Bricks', 'ACSS', 'ACF'],
    url:      'https://iamtuf.org/',
    featured: false,
  },
  {
    animal:   '🦏',
    name:     'DFH Environmental',
    desc:     'A rugged, reliable environmental services platform — built like the rhino, made to endure.',
    tools:    ['Bricks Builder', 'ACSS', 'ACF'],
    url:      'https://dfhenvironmental.com/',
    featured: false,
  },
  {
    animal:   '🦓',
    name:     'Extreme Occasions',
    desc:     'Events management site with striking stripes of design and functionality.',
    tools:    ['Kadence Blocks', 'ACF', 'Gravity Forms'],
    url:      'https://www.extremeoccasions.com/',
    featured: false,
  },
  {
    animal:   '🦒',
    name:     'South Seattle Food Hub',
    desc:     'Community food hub site stretching its reach high, built with GeneratePress for clean performance.',
    tools:    ['GeneratePress', 'GenerateBlocks'],
    url:      'https://communityfoodhub.org/',
    featured: false,
  },
  {
    animal:   '🐊',
    name:     'E.D.G & Atelier Architects',
    desc:     'A sleek portfolio for architects — precise, low-profile, and impossible to ignore.',
    tools:    ['ACF', 'Elementor'],
    url:      'https://www.edgatelier.com/',
    featured: false,
  },
  {
    animal:   '🦋',
    name:     'LashLash',
    desc:     'A vibrant e-commerce store fluttering beautifully with WooCommerce and Elementor.',
    tools:    ['WooCommerce', 'Elementor'],
    url:      'https://lashlash.no/',
    featured: false,
  },
  {
    animal:   '🦅',
    name:     'AI Posts Generator',
    desc:     'A soaring plugin powered by OpenAI — generating blog posts from the clouds.',
    tools:    ['PHP', 'OpenAI API', 'WordPress'],
    url:      'https://github.com/Erykko/Ai-Posts-Generator',
    featured: false,
  },
];
