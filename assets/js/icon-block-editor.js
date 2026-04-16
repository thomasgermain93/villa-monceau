/**
 * Villa Monceau — Bloc Icône (éditeur)
 * ES5 sans build step — enregistré uniquement dans le block editor.
 */
(function(blocks, element, blockEditor, components) {
  var el = element.createElement;
  var useBlockProps = blockEditor.useBlockProps;
  var InspectorControls = blockEditor.InspectorControls;
  var SelectControl = components.SelectControl;
  var PanelBody = components.PanelBody;

  var icons = {
    wifi: '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#CEA77C" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><circle cx="12" cy="20" r="1" fill="#CEA77C" stroke="none"/></svg>',
    breakfast: '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#CEA77C" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>',
    parking: '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#CEA77C" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg"><rect x="1" y="3" width="15" height="13" rx="2"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>',
    clock: '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#CEA77C" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
  };

  var labels = {
    wifi: 'Wi-Fi',
    breakfast: 'Petit-déjeuner',
    parking: 'Parking',
    clock: 'Horloge',
  };

  blocks.registerBlockType('villa-monceau/icon', {
    title: 'Icône VM',
    icon: 'star-filled',
    category: 'design',
    description: 'Icône SVG décorative pour les blocs USP Villa Monceau.',
    attributes: {
      type: { type: 'string', default: 'wifi' },
    },

    edit: function(props) {
      var type = props.attributes.type;
      var blockProps = useBlockProps({ className: 'vm-usp__icon vm-usp__icon--' + type });
      return [
        el(InspectorControls, { key: 'inspector' },
          el(PanelBody, { title: 'Icône', initialOpen: true },
            el(SelectControl, {
              label: 'Type d\'icône',
              value: type,
              options: Object.keys(icons).map(function(k) {
                return { label: labels[k], value: k };
              }),
              onChange: function(val) { props.setAttributes({ type: val }); },
            })
          )
        ),
        el('div', Object.assign({ key: 'preview' }, blockProps, {
          dangerouslySetInnerHTML: { __html: icons[type] },
        }))
      ];
    },

    save: function() {
      // Server-side rendered — save retourne null
      return null;
    },
  });

})(window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components);
