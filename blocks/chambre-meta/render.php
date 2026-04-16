<?php
$superficie = get_post_meta( get_the_ID(), '_vm_superficie', true );
$capacite   = get_post_meta( get_the_ID(), '_vm_capacite', true );
$prix       = get_post_meta( get_the_ID(), '_vm_prix_nuit', true );

if ( ! $superficie && ! $capacite && ! $prix ) {
    return '';
}

$html = '<div class="vm-chambre-meta"><div class="vm-chambre-meta__strip">';
if ( $superficie ) {
    $html .= '<div class="vm-chambre-meta__item"><span class="vm-chambre-meta__value">' . esc_html( $superficie ) . ' m²</span><span class="vm-chambre-meta__label">Superficie</span></div>';
}
if ( $capacite ) {
    $html .= '<div class="vm-chambre-meta__item"><span class="vm-chambre-meta__value">' . esc_html( $capacite ) . '</span><span class="vm-chambre-meta__label">Personnes</span></div>';
}
if ( $prix ) {
    $html .= '<div class="vm-chambre-meta__item"><span class="vm-chambre-meta__value">' . esc_html( $prix ) . ' €</span><span class="vm-chambre-meta__label">Par nuit</span></div>';
}
$html .= '</div></div>';

echo $html;
