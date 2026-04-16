/**
 * Villa Monceau — Bloc Slider Chambre (éditeur)
 * Block server-side rendered — affiche un placeholder dans l'éditeur.
 */
(function(blocks, element) {
  var el = element.createElement;

  blocks.registerBlockType('villa-monceau/chambre-slider', {
    title: 'Slider Photos Chambre',
    icon: 'format-gallery',
    category: 'design',
    description: 'Affiche toutes les photos attachées à la chambre en slider horizontal.',
    attributes: {},

    edit: function() {
      return el('div', {
        style: {
          background: '#f0ece6',
          border: '2px dashed #CEA77C',
          borderRadius: '4px',
          padding: '2rem',
          textAlign: 'center',
          color: '#7c6a55',
          fontFamily: 'DM Sans, sans-serif',
        }
      },
        el('span', { style: { fontSize: '2rem', display: 'block', marginBottom: '0.5rem' } }, '🖼'),
        el('strong', null, 'Slider Photos Chambre'),
        el('p', { style: { margin: '0.5rem 0 0', fontSize: '0.85rem' } },
          'Affiche automatiquement toutes les photos de la chambre. Rendu visible en frontend.'
        )
      );
    },

    save: function() {
      return null;
    },
  });

})(window.wp.blocks, window.wp.element);
