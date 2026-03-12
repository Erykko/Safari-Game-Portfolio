/**
 * safari-portfolio/assets/js/game.js
 * ─────────────────────────────────────────────────────────────
 * Safari Portfolio Game Engine
 * Depends on: data.js (SafariTools, SafariProjects must be
 * defined before this file runs)
 * ─────────────────────────────────────────────────────────────
 */

'use strict';

/* =====================================================================
   STATIC DATA (Toolkit + Projects) — overridden by SafariData when in WordPress
   ===================================================================== */
var SafariTools = [
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

var SafariProjects = [
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

if (typeof SafariData !== 'undefined') {
  if (Array.isArray(SafariData.skills)) SafariTools = SafariData.skills;
  if (Array.isArray(SafariData.projects)) SafariProjects = SafariData.projects;
}

/* =====================================================================
   HERO MISSION (cinematic, non-3D)
   ===================================================================== */
function updateHeroHudMini() {
  var el = document.getElementById('heroHudRankMini');
  if (!el || !safariState) return;
  var rank = getCurrentRank();
  var xp = typeof safariState.xp === 'number' ? safariState.xp : 0;
  el.textContent = 'Rank ' + rank.id + ' \u00b7 ' + rank.name + ' \u00b7 ' + xp + ' XP';
}

function initHeroMission() {
  var root = document.getElementById('heroMission');
  if (!root || !safariState) return;

  if (!safariState.heroMission || typeof safariState.heroMission !== 'object') {
    safariState.heroMission = getDefaultHeroMission();
  }

  var timeButtons = root.querySelectorAll('.hero-pill[data-time]');
  var missionButtons = root.querySelectorAll('.hero-pill[data-mission]');
  var confirmBtn = document.getElementById('heroMissionConfirm');
  var logEl = document.getElementById('heroMissionLog');
  var stepEls = root.querySelectorAll('.hero-mission-step');

  function updateSteps() {
    var hm = safariState.heroMission || getDefaultHeroMission();
    var step = 1;
    if (hm.timeOfDay) step = 2;
    if (hm.timeOfDay && hm.missionType) step = 3;
    stepEls.forEach(function (el) {
      if (!el || !el.dataset.step) return;
      el.classList.toggle('is-active', parseInt(el.dataset.step, 10) === step);
    });
  }

  function updateSelections() {
    var hm = safariState.heroMission || getDefaultHeroMission();

    timeButtons.forEach(function (btn) {
      var v = btn.getAttribute('data-time');
      btn.classList.toggle('is-selected', hm.timeOfDay === v);
    });
    missionButtons.forEach(function (btn) {
      var v = btn.getAttribute('data-mission');
      btn.classList.toggle('is-selected', hm.missionType === v);
    });

    if (confirmBtn) {
      var ready = !!hm.timeOfDay && !!hm.missionType;
      confirmBtn.disabled = !ready;
      confirmBtn.textContent = hm.completed
        ? 'Safari Briefing Complete'
        : 'Confirm Safari & Begin';
    }

    if (logEl) {
      if (hm.completed) {
        var labelMap = { toolkit: 'Toolkit', sightings: 'Safari Sightings', ranger: 'The Ranger' };
        var sectionLabel = labelMap[hm.missionType] || 'the trail';
        var timeLabel = hm.timeOfDay === 'dawn'
          ? 'Dawn Patrol'
          : hm.timeOfDay === 'golden'
            ? 'Golden Hour'
            : hm.timeOfDay === 'night'
              ? 'Night Safari'
              : 'Safari';
        logEl.textContent = 'Mission locked: ' + timeLabel + ' into ' + sectionLabel + '.';
      } else if (hm.timeOfDay || hm.missionType) {
        logEl.textContent = 'Adjust your briefing: pick both time of day and mission, then confirm.';
      } else {
        logEl.textContent = 'Choose a time of day and mission to begin your safari.';
      }
    }

    if (typeof document !== 'undefined' && document.body) {
      document.body.dataset.timeOfDay = safariState.heroMission.timeOfDay || '';
    }

    updateSteps();
  }

  timeButtons.forEach(function (btn) {
    btn.addEventListener('click', function () {
      var val = btn.getAttribute('data-time');
      if (!safariState.heroMission) safariState.heroMission = getDefaultHeroMission();
      safariState.heroMission.timeOfDay = val;
      safariState.heroMission.completed = false;
      saveSafariState();
      updateSelections();
    });
  });

  missionButtons.forEach(function (btn) {
    btn.addEventListener('click', function () {
      var val = btn.getAttribute('data-mission');
      if (!safariState.heroMission) safariState.heroMission = getDefaultHeroMission();
      safariState.heroMission.missionType = val;
      safariState.heroMission.completed = false;
      saveSafariState();
      updateSelections();
    });
  });

  if (confirmBtn) {
    confirmBtn.addEventListener('click', function () {
      var hm = safariState.heroMission || getDefaultHeroMission();
      if (!hm.timeOfDay || !hm.missionType) return;

      var firstCompletion = !hm.completed;
      hm.completed = true;

      if (firstCompletion) {
        if (typeof safariState.xp !== 'number') {
          safariState.xp = 0;
        }
        safariState.xp += 100;
        saveSafariState();
        updateHudRank();
        if (typeof unlockAchievement === 'function') {
          unlockAchievement(
            'first_brief',
            'First Mission Briefed',
            'You completed your first safari mission briefing.'
          );
        }
      } else {
        saveSafariState();
      }

      updateSelections();

      var targetId = hm.missionType === 'toolkit'
        ? 'toolkit'
        : hm.missionType === 'sightings'
          ? 'sightings'
          : 'ranger';

      var target = document.getElementById(targetId);
      if (target && typeof target.scrollIntoView === 'function') {
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      } else {
        window.location.hash = '#' + targetId;
      }

      var scrollHint = document.getElementById('scrollHint');
      if (scrollHint) scrollHint.classList.add('hidden');
    });
  }

  updateSelections();
}

/* =====================================================================
   GAME STATE (localStorage persistence)
   ===================================================================== */
var SAFARI_STATE_KEY = 'safari_state_v1';
var safariState      = null;
var storageAvailable = true;

function getDefaultHeroMission() {
  return {
    timeOfDay: null,
    missionType: null,
    completed: false,
  };
}

function createInitialState() {
  var now = Date.now();
  return {
    version: '1.0',
    firstVisit: now,
    lastVisit: now,
    visitCount: 0,
    xp: 0,
    sightings: [],
    achievements: [],
    audioEnabled: false,
    hoveredTools: [],
    thrownBigFive: [],
    heroMission: getDefaultHeroMission(),
  };
}

function loadSafariState() {
  if (typeof window === 'undefined' || typeof localStorage === 'undefined') {
    storageAvailable = false;
    return createInitialState();
  }

  try {
    var raw = localStorage.getItem(SAFARI_STATE_KEY);
    if (!raw) return createInitialState();

    var parsed = JSON.parse(raw);
    if (!parsed || typeof parsed !== 'object') return createInitialState();

    var base = createInitialState();
    for (var key in parsed) {
      if (Object.prototype.hasOwnProperty.call(parsed, key)) {
        base[key] = parsed[key];
      }
    }
    return base;
  } catch (e) {
    storageAvailable = false;
    return createInitialState();
  }
}

function saveSafariState() {
  if (!storageAvailable || !safariState) return;
  try {
    localStorage.setItem(SAFARI_STATE_KEY, JSON.stringify(safariState));
  } catch (e) {
    storageAvailable = false;
  }
}

function initSafariState() {
  safariState = loadSafariState();
  var now = Date.now();

  if (!safariState.firstVisit) {
    safariState.firstVisit = now;
  }

  safariState.lastVisit  = now;
  safariState.visitCount = (safariState.visitCount || 0) + 1;

  if (!Array.isArray(safariState.sightings)) {
    safariState.sightings = [];
  }
  if (!Array.isArray(safariState.achievements)) {
    safariState.achievements = [];
  }
  if (!Array.isArray(safariState.hoveredTools)) {
    safariState.hoveredTools = [];
  }
  if (!Array.isArray(safariState.thrownBigFive)) {
    safariState.thrownBigFive = [];
  }

  if (!safariState.heroMission || typeof safariState.heroMission !== 'object') {
    safariState.heroMission = getDefaultHeroMission();
  } else {
    var hm = safariState.heroMission;
    if (hm.timeOfDay !== 'dawn' && hm.timeOfDay !== 'golden' && hm.timeOfDay !== 'night') {
      hm.timeOfDay = null;
    }
    if (['toolkit', 'sightings', 'ranger'].indexOf(hm.missionType) === -1) {
      hm.missionType = null;
    }
    if (typeof hm.completed !== 'boolean') {
      hm.completed = false;
    }
  }

  if (typeof safariState.xp !== 'number') {
    safariState.xp = 0;
  }

  if (typeof safariState.audioEnabled !== 'boolean') {
    safariState.audioEnabled = false;
  }

  saveSafariState();
}

/* =====================================================================
   ACHIEVEMENTS (minimal system)
   ===================================================================== */
var ACHIEVEMENTS = {
  FIRST_SHOT: 'first_shot',
  BIG_NINE: 'big_nine',
};

var RANKS = [
  { id: 1, name: 'Day Tripper',      minXp: 0,    maxXp: 200 },
  { id: 2, name: 'Field Scout',      minXp: 200,  maxXp: 500 },
  { id: 3, name: 'Wildlife Photographer', minXp: 500,  maxXp: 1000 },
  { id: 4, name: 'Safari Guide',     minXp: 1000, maxXp: 2500 },
  { id: 5, name: 'Master Ranger',    minXp: 2500, maxXp: Infinity },
];

function hasAchievement(id) {
  if (!safariState || !Array.isArray(safariState.achievements)) return false;
  return safariState.achievements.indexOf(id) !== -1;
}

function unlockAchievement(id, title, message) {
  if (!safariState) return;
  if (hasAchievement(id)) return;

  if (!Array.isArray(safariState.achievements)) {
    safariState.achievements = [];
  }

  safariState.achievements.push(id);
  saveSafariState();
  showAchievementToast(title, message);
}

function showAchievementToast(title, message) {
  var toast = document.getElementById('achievementToast');
  if (!toast) {
    toast = document.createElement('div');
    toast.id = 'achievementToast';
    toast.className = 'achievement-toast';
    toast.innerHTML = '' +
      '<div class="achievement-title">Achievement Unlocked</div>' +
      '<div class="achievement-body">' +
        '<div class="achievement-name"></div>' +
        '<div class="achievement-desc"></div>' +
      '</div>';
    document.body.appendChild(toast);
  }

  var nameEl = toast.querySelector('.achievement-name');
  var descEl = toast.querySelector('.achievement-desc');
  if (nameEl) nameEl.textContent = title;
  if (descEl) descEl.textContent = message;

  toast.classList.add('show');
  setTimeout(function () {
    toast.classList.remove('show');
  }, 3200);
}

function applyPersistentSightings() {
  if (!safariState || !Array.isArray(safariState.sightings)) return;

  var grid = document.getElementById('projectsGrid');
  if (!grid) return;

  sightingsSeen = 0;

  safariState.sightings.forEach(function (idx) {
    var selector = '.project-card[data-index="' + idx + '"]';
    var card = grid.querySelector(selector);
    if (card && !card.dataset.seen) {
      card.dataset.seen = '1';
      sightingsSeen++;
    }
  });

  updateSightingsCount();
  renderFieldGuide();
}

function checkEncounterAchievements() {
  if (!safariState || !Array.isArray(safariState.sightings)) return;

  var seenCount = safariState.sightings.length;
  var total     = typeof SafariProjects !== 'undefined' ? SafariProjects.length : 9;

  if (seenCount === 1) {
    unlockAchievement(ACHIEVEMENTS.FIRST_SHOT, 'First Shot', 'You captured your first wildlife sighting.');
  }

  if (seenCount === total) {
    unlockAchievement(ACHIEVEMENTS.BIG_NINE, 'The Big Nine', 'You photographed all ' + total + ' species on the trail.');
  }
}

function getCurrentRank() {
  if (!safariState || typeof safariState.xp !== 'number') {
    return RANKS[0];
  }
  var xp = safariState.xp;
  for (var i = RANKS.length - 1; i >= 0; i--) {
    if (xp >= RANKS[i].minXp) return RANKS[i];
  }
  return RANKS[0];
}

function updateHudRank() {
  var labelEl = document.getElementById('hudRankLabel');
  var fillEl  = document.getElementById('hudRankFill');
  if (!labelEl || !fillEl) return;

  var rank = getCurrentRank();
  var xp   = safariState && typeof safariState.xp === 'number' ? safariState.xp : 0;

  labelEl.textContent = 'Rank ' + rank.id + ' \u00b7 ' + rank.name + ' (' + xp + ' XP)';

  var width = 0;
  if (rank.maxXp === Infinity) {
    width = 100;
  } else {
    var span = rank.maxXp - rank.minXp;
    var into = Math.max(0, Math.min(span, xp - rank.minXp));
    width = span > 0 ? (into / span) * 100 : 0;
  }

  fillEl.style.width = width + '%';
  updateHeroHudMini();
}

function initBootScreen() {
  var el = document.getElementById('bootScreen');
  if (!el) return;

  var titleEl    = document.getElementById('bootTitle');
  var subtitleEl = document.getElementById('bootSubtitle');

  var isFirstVisit = safariState && safariState.visitCount === 1;

  if (isFirstVisit) {
    if (titleEl) {
      titleEl.textContent = 'Initializing Field Equipment…';
    }
    if (subtitleEl) {
      subtitleEl.textContent = 'Calibrating compass, loading wildlife database (9 species detected).';
    }
  } else {
    var rank = getCurrentRank();
    if (titleEl) {
      titleEl.textContent = 'Welcome back, Ranger.';
    }
    if (subtitleEl) {
      subtitleEl.textContent = 'You are Rank ' + rank.id + ' · ' + rank.name + ' with ' +
        (safariState && typeof safariState.xp === 'number' ? safariState.xp : 0) + ' XP.';
    }
  }

  el.classList.add('visible');

  setTimeout(function () {
    el.classList.add('hidden');
  }, isFirstVisit ? 2600 : 1800);
}

/* =====================================================================
   AUDIO (ambient + shutter)
   ===================================================================== */
var ambientAudioEl = null;
var shutterAudioEl = null;

function initAudio() {
  ambientAudioEl = document.getElementById('ambientAudio');
  shutterAudioEl = document.getElementById('shutterAudio');

  var btn = document.getElementById('audioToggle');
  if (btn) {
    btn.addEventListener('click', toggleAudio);
    updateAudioButton();
  }
}

function updateAudioButton() {
  var btn = document.getElementById('audioToggle');
  if (!btn || !safariState) return;

  var enabled = !!safariState.audioEnabled;
  btn.textContent = enabled ? '🔊' : '🔈';
}

function toggleAudio() {
  if (!safariState) return;
  safariState.audioEnabled = !safariState.audioEnabled;
  saveSafariState();
  updateAudioButton();

  if (!ambientAudioEl) return;

  if (safariState.audioEnabled) {
    try {
      // Ensure the audio element (and its <source>) are loaded
      ambientAudioEl.load();
    } catch (e) {
      // ignore
    }
    ambientAudioEl.volume = 0.4;
    var playPromise = ambientAudioEl.play();
    if (playPromise && typeof playPromise.catch === 'function') {
      playPromise.catch(function () { /* ignore AbortError and others */ });
    }
  } else {
    try {
      ambientAudioEl.pause();
    } catch (e) {
      // ignore
    }
  }
}

function playShutterSound() {
  if (!safariState || !safariState.audioEnabled || !shutterAudioEl) return;
  try {
    shutterAudioEl.load();
    shutterAudioEl.currentTime = 0;
    var p = shutterAudioEl.play();
    if (p && typeof p.catch === 'function') {
      p.catch(function () { /* ignore AbortError and others */ });
    }
  } catch (e) {
    // ignore
  }
}

/* =====================================================================
   FIELD GUIDE OVERLAY
   ===================================================================== */
var fieldGuideCards = [];

function initFieldGuide() {
  var grid = document.getElementById('fieldGuideGrid');
  if (!grid || typeof SafariProjects === 'undefined') return;

  fieldGuideCards = [];
  grid.innerHTML = '';

  SafariProjects.forEach(function (p, idx) {
    var card = document.createElement('button');
    card.type = 'button';
    card.className = 'field-guide-card';
    card.dataset.index = idx;
    card.innerHTML = '' +
      '<div class="fg-animal">' + p.animal + '</div>' +
      '<div class="fg-name">' + p.name + '</div>' +
      '<div class="fg-status">Unseen</div>';
    grid.appendChild(card);
    fieldGuideCards.push(card);
  });

  renderFieldGuide();

  var openBtn  = document.getElementById('fieldGuideToggle');
  var closeBtn = document.getElementById('fieldGuideClose');
  var overlay  = document.getElementById('fieldGuide');

  if (openBtn && overlay) {
    openBtn.addEventListener('click', function () {
      overlay.classList.add('open');
    });
  }
  if (closeBtn && overlay) {
    closeBtn.addEventListener('click', function () {
      overlay.classList.remove('open');
    });
  }
}

function renderFieldGuide() {
  if (!fieldGuideCards.length || !safariState || !Array.isArray(safariState.sightings)) return;

  var seenSet = {};
  safariState.sightings.forEach(function (idx) {
    seenSet[idx] = true;
  });

  fieldGuideCards.forEach(function (card) {
    var idx = parseInt(card.dataset.index, 10);
    var seen = !!seenSet[idx];
    var statusEl = card.querySelector('.fg-status');
    if (seen) {
      card.classList.add('seen');
      if (statusEl) statusEl.textContent = 'Photographed';
    } else {
      card.classList.remove('seen');
      if (statusEl) statusEl.textContent = 'Unseen';
    }
  });
}

/* =====================================================================
   CURSOR
   ===================================================================== */
const cursor    = document.getElementById('cursor');
const cursorDot = document.getElementById('cursorDot');
let mx = 0, my = 0, cx = 0, cy = 0;

document.addEventListener('mousemove', (e) => {
  mx = e.clientX;
  my = e.clientY;
  cursorDot.style.left = mx + 'px';
  cursorDot.style.top  = my + 'px';
});

function animateCursor() {
  cx += (mx - cx) * 0.15;
  cy += (my - cy) * 0.15;
  cursor.style.left = cx + 'px';
  cursor.style.top  = cy + 'px';
  requestAnimationFrame(animateCursor);
}
animateCursor();

/* =====================================================================
   STAR FIELD
   ===================================================================== */
function initStars() {
  const container = document.getElementById('starsContainer');
  if (!container) return;

  for (let i = 0; i < 120; i++) {
    const star = document.createElement('div');
    star.className = 'star';
    const size = Math.random() * 2.5 + 0.5;
    star.style.cssText = [
      `left:${Math.random() * 100}%`,
      `top:${Math.random() * 55}%`,
      `width:${size}px`,
      `height:${size}px`,
      `--dur:${2 + Math.random() * 4}s`,
      `animation-delay:${Math.random() * 4}s`,
    ].join(';');
    container.appendChild(star);
  }
}

/* =====================================================================
   DUST PARTICLES
   ===================================================================== */
function initDust() {
  const container = document.getElementById('dustContainer');
  if (!container) return;

  for (let i = 0; i < 20; i++) {
    const dust = document.createElement('div');
    dust.className = 'dust';
    const size = Math.random() * 6 + 2;
    dust.style.cssText = [
      `left:${Math.random() * 100}%`,
      `bottom:${Math.random() * 25}%`,
      `width:${size}px`,
      `height:${size}px`,
      `--dur:${4 + Math.random() * 6}s`,
      `--dx:${(Math.random() - 0.5) * 40}px`,
      `animation-delay:${Math.random() * 6}s`,
    ].join(';');
    container.appendChild(dust);
  }
}

/* =====================================================================
   FIREFLIES
   ===================================================================== */
function initFireflies() {
  const container = document.getElementById('firefliesContainer');
  if (!container) return;

  for (let i = 0; i < 12; i++) {
    const ff = document.createElement('div');
    ff.className = 'firefly';
    ff.style.cssText = [
      `left:${Math.random() * 100}%`,
      `top:${Math.random() * 100}%`,
      `--dur:${6 + Math.random() * 8}s`,
      `--dx:${(Math.random() - 0.5) * 120}px`,
      `--dy:${(Math.random() - 0.5) * 80}px`,
      `--dx2:${(Math.random() - 0.5) * 100}px`,
      `--dy2:${(Math.random() - 0.5) * 100}px`,
      `animation-delay:${Math.random() * 8}s`,
      'opacity:0',
    ].join(';');
    container.appendChild(ff);
  }
}

/* =====================================================================
   TOOLKIT — build grid from SafariTools data
   ===================================================================== */
function initToolkit() {
  const grid = document.getElementById('toolkitGrid');
  if (!grid || typeof SafariTools === 'undefined') return;

  SafariTools.forEach((tool, i) => {
    const el = document.createElement('div');
    el.className = 'tool-item';
    el.style.transitionDelay = (i * 60) + 'ms';
    el.innerHTML = `
      <span class="tool-icon">${tool.icon}</span>
      <div class="tool-name">${tool.name}</div>
      <div class="tool-desc">${tool.desc}</div>
      <div class="tool-bar">
        <div class="tool-fill" style="--level:${tool.level}"></div>
      </div>`;
    el.addEventListener('mouseenter', () => handleToolHover(i));
    grid.appendChild(el);
  });
}

function handleToolHover(idx) {
  if (!safariState || !Array.isArray(safariState.hoveredTools)) return;
  if (safariState.hoveredTools.indexOf(idx) !== -1) return;

  safariState.hoveredTools.push(idx);

  if (typeof safariState.xp !== 'number') {
    safariState.xp = 0;
  }
  safariState.xp += 10;
  saveSafariState();
  updateHudRank();
}

/* Big Five interaction is now handled via 3D raycasting in the hero scene */

/* =====================================================================
   PROJECTS — build grid from SafariProjects data
   ===================================================================== */
let sightingsSeen = 0;

function initProjects() {
  const grid = document.getElementById('projectsGrid');
  if (!grid || typeof SafariProjects === 'undefined') return;

  SafariProjects.forEach((p, i) => {
    const card = document.createElement('div');
    card.className = 'project-card' + (p.featured ? ' featured' : '');
    card.dataset.index = i;

    const toolTags = p.tools
      .map(t => `<span class="tool-tag">${t}</span>`)
      .join('');

    card.innerHTML = `
      <div class="project-number">SIGHTING #${String(i + 1).padStart(2, '0')}</div>
      <span class="project-animal">${p.animal}</span>
      <div class="project-name">${p.name}</div>
      <p class="project-desc">${p.desc}</p>
      <div class="project-tools">${toolTags}</div>
      <a href="${p.url}" target="_blank" rel="noopener noreferrer" class="project-link">View Encounter</a>`;

    card.addEventListener('click', () => handleEncounter(i, p, card));
    grid.appendChild(card);
  });
}

/* =====================================================================
   ENCOUNTER SYSTEM
   ===================================================================== */
function handleEncounter(idx, project, card) {
  // Award first sighting
  if (!card.dataset.seen) {
    card.dataset.seen = '1';
    sightingsSeen++;
    if (safariState && Array.isArray(safariState.sightings)) {
      if (safariState.sightings.indexOf(idx) === -1) {
        safariState.sightings.push(idx);
      }
      if (typeof safariState.xp !== 'number') {
        safariState.xp = 0;
      }
      safariState.xp += 50;
      saveSafariState();
      checkEncounterAchievements();
      updateHudRank();
    }

    updateSightingsCount();
    renderFieldGuide();

    card.classList.add('encountered');
    setTimeout(() => card.classList.remove('encountered'), 700);
  }

  playShutterEffect(project);
  showEncounterPopup(`${project.animal} ${project.name}`);
}

function showEncounterPopup(name) {
  const popup = document.getElementById('encounterPopup');
  const label = document.getElementById('encounterName');
  if (!popup || !label) return;

  label.textContent = name;
  popup.classList.add('show');
  setTimeout(() => popup.classList.remove('show'), 2800);
}

function updateSightingsCount() {
  const hudCount = document.getElementById('sightingCount');
  const logCount = document.getElementById('logCount');
  const total    = typeof SafariProjects !== 'undefined' ? SafariProjects.length : 9;

  if (hudCount) hudCount.textContent = `${sightingsSeen}/${total}`;
  if (logCount) logCount.textContent = sightingsSeen;
}

/* =====================================================================
   SHUTTER OVERLAY / POLAROID
   ===================================================================== */
function playShutterEffect(project) {
  var overlay = document.getElementById('shutterOverlay');
  var card    = document.getElementById('polaroidCard');

  if (overlay) {
    overlay.classList.add('active');
    setTimeout(function () {
      overlay.classList.remove('active');
    }, 220);
  }

  if (card && project) {
    var nameEl = card.querySelector('.polaroid-name');
    var iconEl = card.querySelector('.polaroid-icon');
    if (nameEl) nameEl.textContent = project.name;
    if (iconEl) iconEl.textContent = project.animal;

    card.classList.add('show');
    setTimeout(function () {
      card.classList.remove('show');
    }, 1500);
  }

  playShutterSound();
}

/* =====================================================================
   SCROLL SYSTEM — progress bar + reveal animations
   ===================================================================== */
function onScroll() {
  const scrolled   = window.scrollY;
  const maxScroll  = document.body.scrollHeight - window.innerHeight;
  const progressEl = document.getElementById('progressFill');
  const scrollHint = document.getElementById('scrollHint');

  // Progress bar + cheetah position
  var pct = maxScroll > 0 ? (scrolled / maxScroll) * 100 : 0;
  if (progressEl) {
    progressEl.style.width = pct + '%';
  }
  var leopardEl = document.getElementById('progressLeopard');
  if (leopardEl) {
    leopardEl.style.left = 'calc(' + pct + '% - 0px)';
  }

  // Hide scroll hint after first scroll
  if (scrollHint && scrolled > 100) {
    scrollHint.classList.add('hidden');
  }

  revealOnScroll();
}

function revealOnScroll() {
  document.querySelectorAll('.tool-item:not(.visible), .project-card:not(.visible)')
    .forEach(el => {
      if (isInViewport(el)) el.classList.add('visible');
    });
}

function isInViewport(el) {
  const rect = el.getBoundingClientRect();
  return rect.top < window.innerHeight - 60 && rect.bottom > 0;
}

/* =====================================================================
   CONTACT FORM — submit feedback
   ===================================================================== */
function handleFormSubmit(btn) {
  const original = btn.textContent;
  btn.textContent              = '🦁 Dispatch Sent!';
  btn.style.background         = 'linear-gradient(135deg, #3D6B2A, #2D4A1E)';
  btn.style.color              = '#F5E6C8';

  setTimeout(() => {
    btn.textContent    = original;
    btn.style.background = '';
    btn.style.color      = '';
  }, 3000);
}

// Expose handleFormSubmit globally (called via inline onclick)
window.handleFormSubmit = handleFormSubmit;

/* =====================================================================
   EASTER EGGS
   ===================================================================== */
function initEasterEggs() {
  var logo = document.querySelector('.hud-logo');
  if (!logo) return;

  var pressTimer = null;

  logo.addEventListener('mousedown', function () {
    clearTimeout(pressTimer);
    pressTimer = setTimeout(function () {
      triggerLogoEasterEgg();
    }, 1800);
  });

  ['mouseup', 'mouseleave'].forEach(function (evt) {
    logo.addEventListener(evt, function () {
      clearTimeout(pressTimer);
    });
  });
}

function triggerLogoEasterEgg() {
  unlockAchievement('campfire_story', 'Campfire Story', 'You found the ranger\'s secret campfire briefing.');
}

/* =====================================================================
   INIT — wire everything up on DOMContentLoaded
   ===================================================================== */
function initMobileNav() {
  var toggle = document.getElementById('hudMenuToggle');
  var nav = document.getElementById('hudNav');
  if (!toggle || !nav) return;
  toggle.addEventListener('click', function () {
    var open = document.body.classList.toggle('nav-open');
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
  });
  nav.querySelectorAll('.nav-link').forEach(function (link) {
    link.addEventListener('click', function () {
      document.body.classList.remove('nav-open');
      toggle.setAttribute('aria-expanded', 'false');
    });
  });
}

document.addEventListener('DOMContentLoaded', () => {
  initSafariState();
  updateHudRank();
  initBootScreen();
  initAudio();
  initHeroMission();
  initStars();
  initDust();
  initFireflies();
  initToolkit();
  initProjects();
  applyPersistentSightings();
  initFieldGuide();
  initEasterEggs();
  initMobileNav();

  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  // Initial reveal check (elements already in viewport on load)
  setTimeout(revealOnScroll, 300);
});
