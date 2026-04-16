<?php
$lien = get_post_meta( get_the_ID(), '_vm_lien_resa', true );
if ( ! $lien ) {
    return '';
}

echo '<a href="' . esc_url( $lien ) . '" class="vm-btn-resa-external" target="_blank" rel="noopener">Réserver en ligne →</a>';
