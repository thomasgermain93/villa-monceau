<?php
/**
 * Title: Situation
 * Slug: villa-monceau/location
 * Categories: villa-monceau
 * Description: Section localisation — fond vert foncé, infos gauche, carte droite.
 */
?>
<!-- wp:group {"className":"vm-location","align":"full","anchor":"situation","layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group alignfull vm-location has-global-padding is-layout-constrained wp-block-group-is-layout-constrained" id="situation">

  <!-- wp:columns {"className":"vm-location__cols"} -->
  <div class="wp-block-columns vm-location__cols is-layout-flex wp-block-columns-is-layout-flex">

    <!-- wp:column {"width":"45%","className":"vm-location__left"} -->
    <div class="wp-block-column vm-location__left is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:45%">

      <!-- wp:paragraph {"className":"vm-label vm-label--light"} -->
      <p class="vm-label vm-label--light">Situation</p>
      <!-- /wp:paragraph -->

      <!-- wp:heading {"level":2,"textColor":"white","className":"vm-location__title"} -->
      <h2 class="wp-block-heading vm-location__title has-white-color has-text-color">Idéalement<br><em>situé</em></h2>
      <!-- /wp:heading -->

      <!-- wp:list {"className":"vm-location__list"} -->
      <ul class="wp-block-list vm-location__list">
        <!-- wp:list-item --><li>5 min de la gare d'Ottignies</li><!-- /wp:list-item -->
        <!-- wp:list-item --><li>20 min de l'aéroport de Zaventem</li><!-- /wp:list-item -->
        <!-- wp:list-item --><li>À deux pas de Louvain-la-Neuve</li><!-- /wp:list-item -->
        <!-- wp:list-item --><li>Cœur du Brabant Wallon</li><!-- /wp:list-item -->
      </ul>
      <!-- /wp:list -->

      <!-- wp:paragraph {"className":"vm-location__address"} -->
      <p class="vm-location__address">Avenue de l'Étoile<br>1340 Ottignies-LLN, Belgique</p>
      <!-- /wp:paragraph -->

      <!-- wp:buttons -->
      <div class="wp-block-buttons is-layout-flex wp-block-buttons-is-layout-flex">
        <!-- wp:button {"className":"vm-btn-outline-white"} -->
        <div class="wp-block-button vm-btn-outline-white"><a class="wp-block-button__link wp-element-button" href="https://maps.google.com/?q=Avenue+de+l'Étoile,+1340+Ottignies" target="_blank" rel="noopener">Voir sur Google Maps →</a></div>
        <!-- /wp:button -->
      </div>
      <!-- /wp:buttons -->

    </div>
    <!-- /wp:column -->

    <!-- wp:column {"width":"55%","className":"vm-location__right"} -->
    <div class="wp-block-column vm-location__right is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:55%">

      <!-- wp:group {"className":"vm-location__map-wrapper","layout":{"type":"default"}} -->
      <div class="wp-block-group vm-location__map-wrapper"></div>
      <!-- /wp:group -->

    </div>
    <!-- /wp:column -->

  </div>
  <!-- /wp:columns -->

</div>
<!-- /wp:group -->
