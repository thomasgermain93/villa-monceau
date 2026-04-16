<?php
$post_id = get_the_ID();
$images  = get_attached_media( 'image', $post_id );

// Fallback sur la featured image
if ( empty( $images ) ) {
    $thumb_id = get_post_thumbnail_id( $post_id );
    if ( $thumb_id ) {
        $img    = get_post( $thumb_id );
        $images = [ $img ];
    }
}

if ( empty( $images ) ) {
    return '';
}

$slides = '';
foreach ( $images as $img ) {
    $src = wp_get_attachment_image_url( $img->ID, 'large' );
    $alt = get_post_meta( $img->ID, '_wp_attachment_image_alt', true ) ?: esc_attr( get_the_title( $img->ID ) );
    $slides .= '<div class="vm-chambre-slider__slide"><img src="' . esc_url( $src ) . '" alt="' . esc_attr( $alt ) . '" loading="lazy"></div>';
}

$dots  = '';
$count = count( $images );
for ( $i = 0; $i < $count; $i++ ) {
    $active = $i === 0 ? ' is-active' : '';
    $dots  .= '<button class="vm-chambre-slider__dot' . $active . '" aria-label="Image ' . ( $i + 1 ) . '"></button>';
}

echo '<div class="vm-chambre-slider"><div class="vm-chambre-slider__track">' . $slides . '</div>'
   . '<div class="vm-chambre-slider__dots">' . $dots . '</div></div>';
