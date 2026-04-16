<?php
/**
 * Villa Monceau — Functions
 */

add_action('after_setup_theme', function() {
    add_theme_support('wp-block-styles');
    // Charge les fonts et le CSS dans le Site Editor (canvas iframe)
    add_editor_style('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=DM+Sans:wght@300;400;500&display=swap');
    add_editor_style('assets/css/custom.css');
    add_editor_style('assets/css/editor.css');
});

// Google Fonts + styles
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style(
        'villa-monceau-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=DM+Sans:wght@300;400;500&display=swap',
        [],
        null
    );
    wp_enqueue_style('villa-monceau-style', get_stylesheet_uri(), [], '1.0.0');
    wp_enqueue_style('villa-monceau-custom', get_template_directory_uri() . '/assets/css/custom.css', ['villa-monceau-style'], '1.0.1');
    wp_enqueue_script('villa-monceau-js', get_template_directory_uri() . '/assets/js/main.js', [], '1.1.0', true);
});

// Register pattern category only (WP 6.0+ auto-discovers patterns in /patterns/*.php)
add_action('init', function() {
    register_block_pattern_category('villa-monceau', ['label' => 'Villa Monceau']);
});

// CPT Chambres
add_action('init', function() {
    register_post_type('chambre', [
        'labels' => [
            'name'               => 'Chambres',
            'singular_name'      => 'Chambre',
            'add_new'            => 'Ajouter une chambre',
            'add_new_item'       => 'Ajouter une chambre',
            'edit_item'          => 'Modifier la chambre',
            'view_item'          => 'Voir la chambre',
            'search_items'       => 'Rechercher une chambre',
            'not_found'          => 'Aucune chambre trouvée',
            'menu_name'          => 'Chambres',
        ],
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => ['slug' => 'chambres', 'with_front' => false],
        'supports'      => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'menu_icon'     => 'dashicons-admin-home',
        'show_in_rest'  => true,
    ]);
});

// Register SCF-style custom meta fields for chambres
add_action('init', function() {
    $fields = [
        '_vm_superficie'    => ['label' => 'Superficie (m²)',    'type' => 'number'],
        '_vm_capacite'      => ['label' => 'Capacité (personnes)', 'type' => 'number'],
        '_vm_prix_nuit'     => ['label' => 'Prix par nuit (€)',  'type' => 'number'],
        '_vm_equipements'   => ['label' => 'Équipements (un par ligne)', 'type' => 'textarea'],
        '_vm_lien_resa'     => ['label' => 'Lien réservation externe', 'type' => 'url'],
    ];
    foreach ($fields as $key => $field) {
        register_post_meta('chambre', $key, [
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => $field['type'] === 'number' ? 'integer' : 'string',
        ]);
    }
});

// Meta box pour les champs custom chambres
add_action('add_meta_boxes', function() {
    add_meta_box(
        'vm_chambre_details',
        'Détails de la chambre',
        'vm_chambre_meta_box_render',
        'chambre',
        'normal',
        'high'
    );
});

function vm_chambre_meta_box_render($post) {
    wp_nonce_field('vm_chambre_save', 'vm_chambre_nonce');
    $fields = [
        '_vm_superficie'  => ['label' => 'Superficie (m²)',           'type' => 'number', 'placeholder' => 'ex: 35'],
        '_vm_capacite'    => ['label' => 'Capacité (personnes)',       'type' => 'number', 'placeholder' => 'ex: 2'],
        '_vm_prix_nuit'   => ['label' => 'Prix par nuit (€)',          'type' => 'number', 'placeholder' => 'ex: 150'],
        '_vm_equipements' => ['label' => 'Équipements (un par ligne)', 'type' => 'textarea', 'placeholder' => "TV\nWi-Fi\nSalle de bain privée"],
        '_vm_lien_resa'   => ['label' => 'Lien réservation externe',   'type' => 'url', 'placeholder' => 'https://...'],
    ];
    echo '<style>.vm-meta-row{margin-bottom:1rem}.vm-meta-row label{display:block;font-weight:600;margin-bottom:4px;font-size:13px}.vm-meta-row input,.vm-meta-row textarea{width:100%;border:1px solid #ddd;padding:6px 8px;border-radius:3px;font-size:13px}.vm-meta-row textarea{height:80px;resize:vertical}</style>';
    foreach ($fields as $key => $field) {
        $value = get_post_meta($post->ID, $key, true);
        echo '<div class="vm-meta-row">';
        echo '<label for="' . esc_attr($key) . '">' . esc_html($field['label']) . '</label>';
        if ($field['type'] === 'textarea') {
            echo '<textarea id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" placeholder="' . esc_attr($field['placeholder']) . '">' . esc_textarea($value) . '</textarea>';
        } else {
            echo '<input type="' . esc_attr($field['type']) . '" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '" placeholder="' . esc_attr($field['placeholder']) . '">';
        }
        echo '</div>';
    }
}

add_action('save_post_chambre', function($post_id) {
    if (!isset($_POST['vm_chambre_nonce']) || !wp_verify_nonce($_POST['vm_chambre_nonce'], 'vm_chambre_save')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $fields = ['_vm_superficie', '_vm_capacite', '_vm_prix_nuit', '_vm_equipements', '_vm_lien_resa'];
    foreach ($fields as $key) {
        if (isset($_POST[$key])) {
            update_post_meta($post_id, $key, sanitize_textarea_field($_POST[$key]));
        }
    }
});

// ── Custom blocks — registered via block.json (FSE standard) ──────────────────
add_action('init', function() {
    $blocks = [
        'chambre-meta',
        'chambre-equipements',
        'chambre-prix',
        'chambre-lien-resa',
        'icon',
        'chambre-slider',
        'google-maps',
        'poi-grid',
    ];
    foreach ( $blocks as $block ) {
        register_block_type( get_template_directory() . '/blocks/' . $block );
    }
});

// Live Links — réécriture des URLs localhost → live URL dans tout le contenu rendu
add_action('init', function() {
    if (!defined('VM_LIVE_URL')) return;

    $local_url = 'http://localhost:10004';
    $live_url  = VM_LIVE_URL;

    $replace = function($val) use ($local_url, $live_url) {
        return is_string($val) ? str_replace($local_url, $live_url, $val) : $val;
    };

    add_filter('the_content',             $replace);
    add_filter('wp_get_attachment_url',   $replace);
    add_filter('wp_get_attachment_image_src', function($image) use ($local_url, $live_url) {
        if (is_array($image) && isset($image[0])) {
            $image[0] = str_replace($local_url, $live_url, $image[0]);
        }
        return $image;
    });
    add_filter('wp_calculate_image_srcset', function($sources) use ($local_url, $live_url) {
        if (!is_array($sources)) return $sources;
        foreach ($sources as &$s) {
            $s['url'] = str_replace($local_url, $live_url, $s['url']);
        }
        return $sources;
    });
}, 5);

// Flush rewrite rules on theme activation
add_action('after_switch_theme', function() {
    flush_rewrite_rules();
});

// ─── Titre SEO front page — override RankMath ─────────────────────────────────
// RankMath utilise pre_get_document_title (priority 15) et ignore le _rank_math_title
// de la front page statique. On force le custom title via le même hook à priority 99.
add_filter('pre_get_document_title', function(string $title): string {
    if (is_front_page()) {
        $custom = get_post_meta((int) get_option('page_on_front'), '_rank_math_title', true);
        if ($custom) {
            return $custom;
        }
    }
    return $title;
}, 99);

// OG title + twitter:title pour la front page (RankMath lit le page title par défaut).
add_filter('rank_math/frontend/og_title', function(string $title): string {
    if (is_front_page()) {
        $custom = get_post_meta((int) get_option('page_on_front'), '_rank_math_title', true);
        if ($custom) return $custom;
    }
    return $title;
}, 99);

// ─── Schema markup JSON-LD ────────────────────────────────────────────────────
//
// LodgingBusiness sur la page d'accueil (avec aggregateRating + amenityFeature).
// HotelRoom sur les pages chambre individuelles.
// Injecté via wp_head (priority 20) pour ne pas interférer avec RankMath.

add_action('wp_head', function() {

    // ── Page d'accueil : LodgingBusiness ──────────────────────────────────────
    if (is_front_page()) {
        $schema = [
            '@context'      => 'https://schema.org',
            '@type'         => 'LodgingBusiness',
            'name'          => 'Villa Monceau',
            'url'           => 'https://villamonceau.be',
            'logo'          => 'https://villamonceau.be/wp-content/uploads/logo_villamonceau.webp',
            'image'         => 'https://villamonceau.be/wp-content/uploads/vm-real-grande-suite.webp',
            'telephone'     => '+32493871859',
            'email'         => 'info@villamonceau.be',
            'priceRange'    => '€€',
            'numberOfRooms' => 5,
            'checkinTime'   => '15:00',
            'checkoutTime'  => '11:00',
            'currenciesAccepted' => 'EUR',
            'paymentAccepted'    => 'Cash, Credit Card',
            'address' => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => "Avenue de l'Étoile",
                'addressLocality' => 'Ottignies-Louvain-la-Neuve',
                'postalCode'      => '1340',
                'addressCountry'  => 'BE',
            ],
            'geo' => [
                '@type'     => 'GeoCoordinates',
                'latitude'  => 50.5985,
                'longitude' => 4.6104,
            ],
            'amenityFeature' => [
                ['@type' => 'LocationFeatureSpecification', 'name' => 'Wi-Fi gratuit',       'value' => true],
                ['@type' => 'LocationFeatureSpecification', 'name' => 'Parking gratuit',     'value' => true],
                ['@type' => 'LocationFeatureSpecification', 'name' => 'Petit-déjeuner',      'value' => true],
                ['@type' => 'LocationFeatureSpecification', 'name' => 'Climatisation',       'value' => true],
                ['@type' => 'LocationFeatureSpecification', 'name' => 'Jardin',              'value' => true],
                ['@type' => 'LocationFeatureSpecification', 'name' => 'Réception 7j/7',      'value' => true],
            ],
            'aggregateRating' => [
                '@type'       => 'AggregateRating',
                'ratingValue' => '4.9',
                'reviewCount' => '27',
                'bestRating'  => '5',
                'worstRating' => '1',
            ],
            'sameAs' => [
                'https://www.instagram.com/villamonceau1340',
                'https://www.facebook.com/villamonceau1340',
            ],
        ];
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
        return;
    }

    // ── Page chambre individuelle : HotelRoom ──────────────────────────────────
    if (is_singular('chambre')) {
        $id          = get_the_ID();
        $superficie  = get_post_meta($id, '_vm_superficie', true);
        $capacite    = get_post_meta($id, '_vm_capacite', true);
        $prix        = get_post_meta($id, '_vm_prix_nuit', true);
        $raw_equip   = get_post_meta($id, '_vm_equipements', true);
        $equipements = $raw_equip
            ? array_values(array_filter(array_map('trim', explode("\n", $raw_equip))))
            : [];

        $img_url = '';
        $thumb   = get_post_thumbnail_id($id);
        if ($thumb) {
            $img_src = wp_get_attachment_image_src($thumb, 'large');
            if ($img_src) $img_url = $img_src[0];
        }

        $schema = [
            '@context'    => 'https://schema.org',
            '@type'       => 'HotelRoom',
            'name'        => get_the_title(),
            'url'         => get_permalink(),
            'description' => get_the_excerpt() ?: get_bloginfo('description'),
            'containedInPlace' => [
                '@type' => 'LodgingBusiness',
                'name'  => 'Villa Monceau',
                'url'   => 'https://villamonceau.be',
            ],
        ];

        if ($img_url)    $schema['image']          = $img_url;
        if ($superficie) $schema['floorSize']       = ['@type' => 'QuantitativeValue', 'value' => (int) $superficie, 'unitCode' => 'MTK'];
        if ($capacite)   $schema['occupancy']       = ['@type' => 'QuantitativeValue', 'minValue' => 1, 'maxValue' => (int) $capacite];
        if ($prix)       $schema['offers']          = ['@type' => 'Offer', 'price' => (float) $prix, 'priceCurrency' => 'EUR', 'priceSpecification' => ['@type' => 'UnitPriceSpecification', 'price' => (float) $prix, 'priceCurrency' => 'EUR', 'unitText' => 'night']];
        if ($equipements) $schema['amenityFeature'] = array_map(fn($e) => ['@type' => 'LocationFeatureSpecification', 'name' => $e, 'value' => true], $equipements);

        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }

}, 20);
