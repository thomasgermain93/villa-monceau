<?php
/**
 * Title: Chambres
 * Slug: villa-monceau/rooms
 * Categories: villa-monceau
 * Description: Section chambres — headline gauche + photos droite (style Regent), puis grille.
 */
?>
<!-- wp:group {"className":"vm-rooms","align":"full","anchor":"chambres","layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group alignfull vm-rooms has-global-padding is-layout-constrained wp-block-group-is-layout-constrained" id="chambres">

  <!-- wp:columns {"className":"vm-rooms__intro"} -->
  <div class="wp-block-columns vm-rooms__intro is-layout-flex wp-block-columns-is-layout-flex">

    <!-- wp:column {"width":"40%","className":"vm-rooms__intro-left"} -->
    <div class="wp-block-column vm-rooms__intro-left is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:40%">
      <!-- wp:paragraph {"className":"vm-label"} -->
      <p class="vm-label">Nos Hébergements</p>
      <!-- /wp:paragraph -->
      <!-- wp:heading {"level":2,"fontSize":"heading-lg","fontFamily":"display","className":"vm-rooms__title"} -->
      <h2 class="wp-block-heading has-heading-lg-font-size has-display-font-family vm-rooms__title">Cinq chambres,<br><em>cinq univers</em></h2>
      <!-- /wp:heading -->
      <!-- wp:paragraph -->
      <p>Chaque chambre est un monde en soi — admirablement décorée, meublée avec soin et pensée pour votre confort et votre intimité.</p>
      <!-- /wp:paragraph -->
      <!-- wp:paragraph {"className":"vm-rooms__viewall"} -->
      <p class="vm-rooms__viewall"><a href="/chambres/">Voir toutes les chambres →</a></p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:column -->

    <!-- wp:column {"width":"60%","className":"vm-rooms__intro-photos"} -->
    <div class="wp-block-column vm-rooms__intro-photos is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:60%">
      <!-- wp:group {"className":"vm-rooms__photo-stack","layout":{"type":"default"}} -->
      <div class="wp-block-group vm-rooms__photo-stack is-layout-flow wp-block-group-is-layout-flow">
        <!-- wp:image {"id":48,"sizeSlug":"large","linkDestination":"none","className":"vm-rooms__photo-stack-top"} -->
        <figure class="wp-block-image size-large vm-rooms__photo-stack-top"><img src="/wp-content/uploads/vm-real-grande-suite.webp" alt="La Grande Suite" class="wp-image-48"/></figure>
        <!-- /wp:image -->
        <!-- wp:image {"id":50,"sizeSlug":"large","linkDestination":"none","className":"vm-rooms__photo-stack-bottom"} -->
        <figure class="wp-block-image size-large vm-rooms__photo-stack-bottom"><img src="/wp-content/uploads/vm-real-chambre-rouge.webp" alt="La Chambre Rouge" class="wp-image-50"/></figure>
        <!-- /wp:image -->
      </div>
      <!-- /wp:group -->
    </div>
    <!-- /wp:column -->

  </div>
  <!-- /wp:columns -->

  <!-- wp:separator {"backgroundColor":"gold","className":"vm-divider-light"} -->
  <hr class="wp-block-separator vm-divider-light has-text-color has-gold-color has-alpha-channel-opacity has-gold-background-color has-background"/>
  <!-- /wp:separator -->

  <!-- wp:query {"queryId":1,"query":{"postType":"chambre","perPage":6,"orderBy":"title","order":"ASC","inherit":false},"className":"vm-rooms__grid"} -->
  <div class="wp-block-query vm-rooms__grid">

    <!-- wp:post-template {"className":"vm-rooms__cards","layout":{"type":"grid","columnCount":3}} -->

      <!-- wp:group {"className":"vm-room-card","layout":{"type":"flex","orientation":"vertical"}} -->
      <div class="wp-block-group vm-room-card is-vertical is-layout-flex wp-block-group-is-layout-flex">

        <!-- wp:post-featured-image {"isLink":true,"height":"320px","className":"vm-room-card__img"} /-->

        <!-- wp:group {"className":"vm-room-card__body"} -->
        <div class="wp-block-group vm-room-card__body is-layout-flow wp-block-group-is-layout-flow">
          <!-- wp:post-title {"isLink":true,"level":3,"className":"vm-room-card__title"} /-->
          <!-- wp:post-excerpt {"moreText":"","excerptLength":15,"className":"vm-room-card__excerpt"} /-->
          <!-- wp:read-more {"content":"Découvrir →","className":"vm-room-card__link"} /-->
        </div>
        <!-- /wp:group -->

      </div>
      <!-- /wp:group -->

    <!-- /wp:post-template -->

  </div>
  <!-- /wp:query -->

</div>
<!-- /wp:group -->
