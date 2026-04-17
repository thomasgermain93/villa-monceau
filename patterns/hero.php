<?php
/**
 * Title: Hero — Page d'accueil
 * Slug: villa-monceau/hero
 * Categories: villa-monceau
 * Inserter: false
 * Description: Section hero plein écran avec overlay et headline.
 */
?>
<!-- wp:cover {"dimRatio":60,"overlayColor":"dark","minHeight":100,"minHeightUnit":"vh","isDark":true,"align":"full","className":"vm-hero"} -->
<div class="wp-block-cover alignfull vm-hero is-dark" style="min-height:100vh">
<span aria-hidden="true" class="wp-block-cover__background has-dark-background-color has-background-dim-60 has-background-dim"></span>
<div class="wp-block-cover__inner-container">

  <!-- wp:paragraph {"align":"center","className":"vm-hero__label"} -->
  <p class="has-text-align-center vm-hero__label">Hôtel Boutique &nbsp;·&nbsp; Ottignies-LLN</p>
  <!-- /wp:paragraph -->

  <!-- wp:heading {"level":1,"textAlign":"center","fontSize":"heading-xl","fontFamily":"display","className":"vm-hero__title"} -->
  <h1 class="wp-block-heading has-text-align-center has-heading-xl-font-size has-display-font-family vm-hero__title">Une escapade au<br><em>cœur du Brabant</em></h1>
  <!-- /wp:heading -->

  <!-- wp:separator {"backgroundColor":"gold","className":"vm-divider-gold"} -->
  <hr class="wp-block-separator vm-divider-gold has-text-color has-gold-color has-alpha-channel-opacity has-gold-background-color has-background"/>
  <!-- /wp:separator -->

  <!-- wp:paragraph {"align":"center","className":"vm-hero__tagline"} -->
  <p class="has-text-align-center vm-hero__tagline">Charme, confort et authenticité à deux pas de Louvain-la-Neuve</p>
  <!-- /wp:paragraph -->

  <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
  <div class="wp-block-buttons is-content-justification-center is-layout-flex wp-block-buttons-is-layout-flex">
    <!-- wp:button {"className":"vm-btn-hero"} -->
    <div class="wp-block-button vm-btn-hero"><a class="wp-block-button__link wp-element-button" href="/chambres">Voir les chambres</a></div>
    <!-- /wp:button -->
  </div>
  <!-- /wp:buttons -->


</div>
</div>
<!-- /wp:cover -->
