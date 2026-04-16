<?php
$prix = get_post_meta( get_the_ID(), '_vm_prix_nuit', true );
if ( ! $prix ) {
    return '';
}

echo '<div class="vm-booking-card__price"><span class="vm-booking-card__price-amount">' . esc_html( $prix ) . ' €</span><span class="vm-booking-card__price-label">/ nuit</span></div>';
