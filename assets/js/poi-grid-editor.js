(function (blocks, element, blockEditor, components) {
    var el = element.createElement;
    var InspectorControls = blockEditor.InspectorControls;
    var MediaUpload        = blockEditor.MediaUpload;
    var PanelBody   = components.PanelBody;
    var TextControl = components.TextControl;
    var Button      = components.Button;

    var DEFAULT_POIS = [
        { imageId: 0, imageUrl: '', title: 'Louvain-la-Neuve',    cat: 'Ville universitaire · 5 min' },
        { imageId: 0, imageUrl: '', title: 'Domaine de Lauzelle',  cat: 'Nature & Golf · 10 min' },
        { imageId: 0, imageUrl: '', title: "L'Esplanade",          cat: 'Shopping & Restaurants · 5 min' },
        { imageId: 0, imageUrl: '', title: 'Aéroport de Zaventem', cat: 'Connexions internationales · 25 min' },
    ];

    blocks.registerBlockType('villa-monceau/poi-grid', {
        title: 'POI Grid — Aux alentours',
        icon: 'location-alt',
        category: 'design',
        attributes: {
            pois: { type: 'array', default: DEFAULT_POIS },
        },

        edit: function (props) {
            var pois = props.attributes.pois && props.attributes.pois.length ? props.attributes.pois : DEFAULT_POIS;

            function updatePoi(index, key, value) {
                var updated = pois.map(function (p, i) {
                    if (i !== index) return p;
                    var copy = { imageId: p.imageId, imageUrl: p.imageUrl, title: p.title, cat: p.cat };
                    copy[key] = value;
                    return copy;
                });
                props.setAttributes({ pois: updated });
            }

            var panels = pois.map(function (poi, i) {
                return el(PanelBody, { key: i, title: 'POI ' + (i + 1) + ' — ' + (poi.title || ''), initialOpen: i === 0 },
                    el(MediaUpload, {
                        onSelect: function (media) {
                            updatePoi(i, 'imageId', media.id);
                            updatePoi(i, 'imageUrl', media.url);
                        },
                        allowedTypes: ['image'],
                        value: poi.imageId || 0,
                        render: function (obj) {
                            return el('div', {},
                                poi.imageUrl
                                    ? el('img', { src: poi.imageUrl, style: { width: '100%', height: '70px', objectFit: 'cover', borderRadius: '2px', marginBottom: '6px' } })
                                    : null,
                                el(Button, { onClick: obj.open, variant: 'secondary', style: { marginBottom: '8px' } },
                                    poi.imageUrl ? 'Changer l\'image' : 'Choisir une image'
                                )
                            );
                        },
                    }),
                    el(TextControl, { label: 'Titre', value: poi.title, onChange: function (v) { updatePoi(i, 'title', v); } }),
                    el(TextControl, { label: 'Catégorie / distance', value: poi.cat, onChange: function (v) { updatePoi(i, 'cat', v); } })
                );
            });

            // Mini-preview dans le canvas
            var preview = el('div', {
                style: { background: '#0d1f25', padding: '1.5rem', borderRadius: '4px' }
            },
                el('p', { style: { color: '#CEA77C', textAlign: 'center', fontSize: '11px', letterSpacing: '0.15em', textTransform: 'uppercase', margin: '0 0 0.5rem' } }, 'Aux alentours'),
                el('p', { style: { color: '#fff', textAlign: 'center', fontFamily: 'Georgia,serif', fontSize: '1.4rem', margin: '0 0 1rem' } }, 'Que faire aux alentours ?'),
                el('div', { style: { display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '8px' } },
                    pois.map(function (poi, i) {
                        return el('div', {
                            key: i,
                            style: {
                                height: '120px', borderRadius: '2px', overflow: 'hidden',
                                position: 'relative', background: '#16323C',
                                backgroundImage: poi.imageUrl ? 'url(' + poi.imageUrl + ')' : 'none',
                                backgroundSize: 'cover', backgroundPosition: 'center',
                            }
                        },
                            el('div', { style: { position: 'absolute', inset: 0, background: 'rgba(22,50,60,0.55)' } }),
                            el('div', { style: { position: 'absolute', bottom: '8px', left: '10px', right: '10px' } },
                                el('p', { style: { color: '#fff', margin: 0, fontSize: '13px', fontFamily: 'Georgia,serif' } }, poi.title),
                                el('p', { style: { color: '#CEA77C', margin: 0, fontSize: '9px', letterSpacing: '0.1em', textTransform: 'uppercase' } }, poi.cat)
                            )
                        );
                    })
                )
            );

            return [
                el(InspectorControls, { key: 'controls' }, panels),
                preview,
            ];
        },

        save: function () { return null; },
    });
}(window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components));
