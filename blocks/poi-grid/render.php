<?php
$default_pois = [
    ['imageId' => 111, 'imageUrl' => '', 'title' => 'Louvain-la-Neuve',    'cat' => 'Ville universitaire · 5 min'],
    ['imageId' => 112, 'imageUrl' => '', 'title' => 'Domaine de Lauzelle',  'cat' => 'Nature & Golf · 10 min'],
    ['imageId' => 113, 'imageUrl' => '', 'title' => "L'Esplanade",          'cat' => 'Shopping & Restaurants · 5 min'],
    ['imageId' => 114, 'imageUrl' => '', 'title' => 'Aéroport de Zaventem', 'cat' => 'Connexions internationales · 25 min'],
];

$pois = ! empty( $attributes['pois'] ) ? $attributes['pois'] : $default_pois;
$rows = [
    array_slice( $pois, 0, 2 ),
    array_slice( $pois, 2, 2 ),
];

$html = '<section class="vm-pois" id="alentours">'
      . '<p class="vm-label">Aux alentours</p>'
      . '<h2 class="vm-pois__title">Que faire aux alentours&nbsp;?</h2>';

foreach ( $rows as $row ) {
    $html .= '<div class="vm-pois__row">';
    foreach ( $row as $poi ) {
        $img_url = ! empty( $poi['imageUrl'] ) ? $poi['imageUrl'] : '';
        if ( ! $img_url && ! empty( $poi['imageId'] ) ) {
            $src = wp_get_attachment_image_src( (int) $poi['imageId'], 'large' );
            if ( $src ) {
                $img_url = $src[0];
            }
        }
        $bg = $img_url
            ? ' style="background-image:url(&quot;' . esc_url( $img_url ) . '&quot;);background-size:cover;background-position:center;"'
            : '';
        $title = esc_html( $poi['title'] ?? '' );
        $cat   = esc_html( $poi['cat'] ?? '' );
        $html .= '<div class="vm-pois__col">'
               . '<div class="vm-pois__cover"' . $bg . '>'
               . '<div class="vm-pois__cover-overlay"></div>'
               . '<div class="vm-pois__cover-inner">'
               . '<p class="vm-pois__cover-title">' . $title . '</p>'
               . '<p class="vm-pois__cover-cat">' . $cat . '</p>'
               . '</div></div></div>';
    }
    $html .= '</div>';
}

$html .= '</section>';
echo $html;
