(function (wp) {
  var el = wp.element.createElement;
  var registerBlockType = wp.blocks.registerBlockType;
  var ServerSideRender = wp.serverSideRender;
  var InspectorControls = wp.blockEditor.InspectorControls;
  var PanelBody = wp.components.PanelBody;
  var TextControl = wp.components.TextControl;
  var TextareaControl = wp.components.TextareaControl;
  var RangeControl = wp.components.RangeControl;

  function safariIcon(emoji) {
    return el('span', { style: { fontSize: '20px' } }, emoji);
  }

  function textAttr(props, key, label, help) {
    return el(TextControl, {
      label: label,
      help: help || '',
      value: props.attributes[key] || '',
      onChange: function (v) {
        var obj = {};
        obj[key] = v;
        props.setAttributes(obj);
      },
    });
  }

  function textareaAttr(props, key, label) {
    return el(TextareaControl, {
      label: label,
      value: props.attributes[key] || '',
      onChange: function (v) {
        var obj = {};
        obj[key] = v;
        props.setAttributes(obj);
      },
    });
  }

  function ssrPreview(blockName, props) {
    return el(ServerSideRender, {
      block: blockName,
      attributes: props.attributes,
    });
  }

  /* ── Hero ─────────────────────────────── */
  registerBlockType('safari/hero', {
    title: 'Safari Hero (Base Camp)',
    icon: safariIcon('🏕️'),
    category: 'safari',
    description: 'Full-width hero section with name, mission console, and time-of-day selector.',
    edit: function (props) {
      return el(
        wp.element.Fragment,
        null,
        el(
          InspectorControls,
          null,
          el(
            PanelBody,
            { title: 'Hero Content', initialOpen: true },
            textAttr(props, 'badge', 'Badge'),
            textAttr(props, 'tag', 'Tag line'),
            textAttr(props, 'name', 'Name'),
            textAttr(props, 'title', 'Title'),
            textareaAttr(props, 'desc', 'Description'),
            textAttr(props, 'missionTitle', 'Mission title'),
            textAttr(props, 'missionSub', 'Mission subtitle'),
            textAttr(props, 'confirmLabel', 'Confirm button'),
            textAttr(props, 'miniLog', 'Mini log text'),
            textAttr(props, 'scrollHint', 'Scroll hint'),
            textAttr(props, 'location', 'Location'),
            textAttr(props, 'hudLabel', 'HUD label')
          )
        ),
        ssrPreview('safari/hero', props)
      );
    },
    save: function () {
      return null;
    },
  });

  /* ── Toolkit ──────────────────────────── */
  registerBlockType('safari/toolkit', {
    title: 'Safari Toolkit',
    icon: safariIcon('🔧'),
    category: 'safari',
    description: 'Skills / tools grid populated from Field Equipment CPT.',
    edit: function (props) {
      return el(
        wp.element.Fragment,
        null,
        el(
          InspectorControls,
          null,
          el(
            PanelBody,
            { title: 'Section Text', initialOpen: true },
            textAttr(props, 'sectionLabel', 'Label'),
            textAttr(props, 'sectionTitle', 'Title'),
            textareaAttr(props, 'sectionSub', 'Subtitle')
          )
        ),
        ssrPreview('safari/toolkit', props)
      );
    },
    save: function () {
      return null;
    },
  });

  /* ── Sightings ────────────────────────── */
  registerBlockType('safari/sightings', {
    title: 'Safari Sightings',
    icon: safariIcon('🦁'),
    category: 'safari',
    description: 'Projects grid populated from Wildlife Sightings CPT.',
    edit: function (props) {
      return el(
        wp.element.Fragment,
        null,
        el(
          InspectorControls,
          null,
          el(
            PanelBody,
            { title: 'Section Text', initialOpen: true },
            textAttr(props, 'sectionLabel', 'Label'),
            textAttr(props, 'sectionTitle', 'Title'),
            textareaAttr(props, 'sectionSub', 'Subtitle'),
            textAttr(props, 'logCountLabel', 'Log count label')
          )
        ),
        ssrPreview('safari/sightings', props)
      );
    },
    save: function () {
      return null;
    },
  });

  /* ── Ranger ───────────────────────────── */
  registerBlockType('safari/ranger', {
    title: 'Safari Ranger',
    icon: safariIcon('🦒'),
    category: 'safari',
    description: 'Ranger profile: avatar, stats, bio, specialties. Reads from The Ranger CPT.',
    edit: function (props) {
      return el(
        wp.element.Fragment,
        null,
        el(
          InspectorControls,
          null,
          el(
            PanelBody,
            { title: 'Section Text', initialOpen: true },
            textAttr(props, 'sectionLabel', 'Label'),
            textAttr(props, 'sectionTitle', 'Title')
          )
        ),
        ssrPreview('safari/ranger', props)
      );
    },
    save: function () {
      return null;
    },
  });

  /* ── Contact ──────────────────────────── */
  registerBlockType('safari/contact', {
    title: 'Safari Contact (Field Notes)',
    icon: safariIcon('📬'),
    category: 'safari',
    description: 'Contact section with quote, details, and form (built-in or plugin).',
    edit: function (props) {
      return el(
        wp.element.Fragment,
        null,
        el(
          InspectorControls,
          null,
          el(
            PanelBody,
            { title: 'Section Text', initialOpen: true },
            textAttr(props, 'sectionLabel', 'Label'),
            textAttr(props, 'sectionTitle', 'Title'),
            textareaAttr(props, 'quote', 'Quote'),
            textAttr(props, 'location', 'Location'),
            textAttr(props, 'website', 'Website'),
            textAttr(props, 'availability', 'Availability')
          )
        ),
        ssrPreview('safari/contact', props)
      );
    },
    save: function () {
      return null;
    },
  });

  /* ── HUD ──────────────────────────────── */
  registerBlockType('safari/hud', {
    title: 'Safari HUD',
    icon: safariIcon('🧭'),
    category: 'safari',
    description: 'Fixed header bar with logo, navigation, rank display, and compass.',
    edit: function (props) {
      return el(
        wp.element.Fragment,
        null,
        el(
          InspectorControls,
          null,
          el(
            PanelBody,
            { title: 'HUD Content', initialOpen: true },
            textAttr(props, 'logo', 'Logo text'),
            textAttr(props, 'mission', 'Mission label')
          )
        ),
        ssrPreview('safari/hud', props)
      );
    },
    save: function () {
      return null;
    },
  });

  /* ── Progress Bar ─────────────────────── */
  registerBlockType('safari/progress-bar', {
    title: 'Safari Progress Bar',
    icon: safariIcon('📊'),
    category: 'safari',
    description: 'Horizontal progress bar that fills as user scrolls.',
    edit: function (props) {
      return ssrPreview('safari/progress-bar', props);
    },
    save: function () {
      return null;
    },
  });

  /* ── Divider ──────────────────────────── */
  registerBlockType('safari/divider', {
    title: 'Safari Divider',
    icon: safariIcon('〰️'),
    category: 'safari',
    description: 'Decorative divider between sections.',
    edit: function (props) {
      return el(
        wp.element.Fragment,
        null,
        el(
          InspectorControls,
          null,
          el(
            PanelBody,
            { title: 'Variant', initialOpen: true },
            textAttr(props, 'variant', 'Variant', 'default or alt')
          )
        ),
        ssrPreview('safari/divider', props)
      );
    },
    save: function () {
      return null;
    },
  });

  /* ── Boot Screen ──────────────────────── */
  registerBlockType('safari/boot-screen', {
    title: 'Safari Boot Screen',
    icon: safariIcon('🖥️'),
    category: 'safari',
    description: 'Full-screen loading animation shown on first visit.',
    edit: function (props) {
      return el(
        wp.element.Fragment,
        null,
        el(
          InspectorControls,
          null,
          el(
            PanelBody,
            { title: 'Boot Content', initialOpen: true },
            textAttr(props, 'kicker', 'Kicker text')
          )
        ),
        ssrPreview('safari/boot-screen', props)
      );
    },
    save: function () {
      return null;
    },
  });

  /* ── Testimonials ─────────────────────── */
  registerBlockType('safari/testimonials', {
    title: 'Safari Testimonials (Animal Tracks)',
    icon: safariIcon('🐾'),
    category: 'safari',
    description: 'Testimonial cards from Animal Tracks CPT.',
    edit: function (props) {
      return el(
        wp.element.Fragment,
        null,
        el(
          InspectorControls,
          null,
          el(
            PanelBody,
            { title: 'Section Text', initialOpen: true },
            textAttr(props, 'sectionLabel', 'Label'),
            textAttr(props, 'sectionTitle', 'Title'),
            el(RangeControl, {
              label: 'Max count',
              value: props.attributes.count || 6,
              min: 1,
              max: 20,
              onChange: function (v) {
                props.setAttributes({ count: v });
              },
            })
          )
        ),
        ssrPreview('safari/testimonials', props)
      );
    },
    save: function () {
      return null;
    },
  });

  /* ── Achievements ─────────────────────── */
  registerBlockType('safari/achievements', {
    title: 'Safari Achievements (Field Medals)',
    icon: safariIcon('🏅'),
    category: 'safari',
    description: 'Achievement badge grid from Field Medals CPT.',
    edit: function (props) {
      return el(
        wp.element.Fragment,
        null,
        el(
          InspectorControls,
          null,
          el(
            PanelBody,
            { title: 'Section Text', initialOpen: true },
            textAttr(props, 'sectionLabel', 'Label'),
            textAttr(props, 'sectionTitle', 'Title')
          )
        ),
        ssrPreview('safari/achievements', props)
      );
    },
    save: function () {
      return null;
    },
  });

  /* ── Dispatches ───────────────────────── */
  registerBlockType('safari/dispatches', {
    title: 'Safari Dispatches (Field Dispatches)',
    icon: safariIcon('📰'),
    category: 'safari',
    description: 'Recent dispatches (blog posts) from Field Dispatches CPT.',
    edit: function (props) {
      return el(
        wp.element.Fragment,
        null,
        el(
          InspectorControls,
          null,
          el(
            PanelBody,
            { title: 'Section Text', initialOpen: true },
            textAttr(props, 'sectionLabel', 'Label'),
            textAttr(props, 'sectionTitle', 'Title'),
            el(RangeControl, {
              label: 'Max count',
              value: props.attributes.count || 3,
              min: 1,
              max: 12,
              onChange: function (v) {
                props.setAttributes({ count: v });
              },
            })
          )
        ),
        ssrPreview('safari/dispatches', props)
      );
    },
    save: function () {
      return null;
    },
  });
})(window.wp);
