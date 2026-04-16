<?php
$raw = get_post_meta( get_the_ID(), '_vm_equipements', true );
if ( ! $raw ) {
    return '';
}

$items = array_filter( explode( "\n", $raw ) );
$html  = '<div class="vm-chambre-equipements"><h3 class="vm-chambre-equipements__title">Équipements</h3><ul class="vm-chambre-equipements__list">';
foreach ( $items as $item ) {
    $html .= '<li>' . esc_html( trim( $item ) ) . '</li>';
}
$html .= '</ul></div>';

echo $html;
