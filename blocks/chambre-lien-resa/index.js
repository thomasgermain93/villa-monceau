/* Villa Monceau — Editor stubs pour les blocs dynamiques chambre */
(function() {
    var registerBlockType = wp.blocks.registerBlockType;
    var el = wp.element.createElement;

    var blocks = [
        {
            name: 'chambre-meta',
            title: 'Chambre — Superficie / Capacité / Prix',
            icon: 'info-outline',
        },
        {
            name: 'chambre-equipements',
            title: 'Chambre — Équipements',
            icon: 'list-view',
        },
        {
            name: 'chambre-prix',
            title: 'Chambre — Prix / nuit',
            icon: 'tag',
        },
        {
            name: 'chambre-lien-resa',
            title: 'Chambre — Lien réservation',
            icon: 'admin-links',
        },
    ];

    blocks.forEach(function(block) {
        registerBlockType('villa-monceau/' + block.name, {
            title: block.title,
            icon: block.icon,
            category: 'theme',
            edit: function() {
                return el(
                    'div',
                    {
                        style: {
                            padding: '0.75rem 1rem',
                            background: '#f9f6f1',
                            border: '1px solid #CEA77C',
                            borderRadius: '4px',
                            color: '#6b5740',
                            fontSize: '13px',
                            fontStyle: 'italic',
                        },
                    },
                    block.title + ' — rendu côté serveur'
                );
            },
            save: function() {
                return null;
            },
        });
    });
})();
