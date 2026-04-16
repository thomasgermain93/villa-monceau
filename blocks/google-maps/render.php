<?php
$address = ! empty( $attributes['address'] ) ? $attributes['address'] : "Avenue de l'Étoile, 1340 Ottignies-LLN, Belgique";
$height  = ! empty( $attributes['height'] ) ? intval( $attributes['height'] ) : 450;
$encoded = urlencode( $address );
$map_url = esc_url( 'https://maps.google.com/maps?q=' . $encoded . '&output=embed&zoom=15' );

echo '<div class="vm-google-maps" style="height:' . $height . 'px;overflow:hidden;">'
   . '<iframe src="' . $map_url . '" '
   . 'width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>'
   . '</div>';
