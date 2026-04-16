/**
 * Villa Monceau — Bloc Google Maps (éditeur)
 * Permet de choisir l'adresse et la hauteur de la carte.
 */
(function(blocks, element, blockEditor, components) {
  var el = element.createElement;
  var useBlockProps = blockEditor.useBlockProps;
  var InspectorControls = blockEditor.InspectorControls;
  var TextControl = components.TextControl;
  var RangeControl = components.RangeControl;
  var PanelBody = components.PanelBody;

  blocks.registerBlockType('villa-monceau/google-maps', {
    title: 'Google Maps',
    icon: 'location',
    category: 'embed',
    description: 'Carte Google Maps embarquée, configurable via le panneau latéral.',
    attributes: {
      address: { type: 'string', default: "Avenue de l'Étoile, 1340 Ottignies-LLN, Belgique" },
      height:  { type: 'integer', default: 450 },
    },

    edit: function(props) {
      var address = props.attributes.address;
      var height  = props.attributes.height;
      var blockProps = useBlockProps({ className: 'vm-google-maps' });
      var encoded = encodeURIComponent(address);
      var src = 'https://maps.google.com/maps?q=' + encoded + '&output=embed&zoom=15';

      return [
        el(InspectorControls, { key: 'inspector' },
          el(PanelBody, { title: 'Paramètres', initialOpen: true },
            el(TextControl, {
              label: 'Adresse',
              value: address,
              onChange: function(val) { props.setAttributes({ address: val }); },
            }),
            el(RangeControl, {
              label: 'Hauteur (px)',
              value: height,
              min: 200,
              max: 800,
              onChange: function(val) { props.setAttributes({ height: val }); },
            })
          )
        ),
        el('div', Object.assign({ key: 'map' }, blockProps, { style: { height: height + 'px', overflow: 'hidden' } }),
          el('iframe', {
            src: src,
            width: '100%',
            height: '100%',
            style: { border: 0 },
            allowFullScreen: true,
            loading: 'lazy',
          })
        )
      ];
    },

    save: function() {
      return null;
    },
  });

})(window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components);
