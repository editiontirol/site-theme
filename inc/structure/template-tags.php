<?php

if(! function_exists('et_shop_product_categories')) {
  /**
   * Display Product Categories
   * Hooked into the `homepage` action in the homepage template
   * @since  1.0.0
   * @return void
   */
  function et_shop_product_categories($args) {

    if(is_woocommerce_activated()) {

      $args = apply_filters( 'et_shop_product_categories_args', array(
        'limit'       => 3,
        'columns'       => 3,
        'child_categories'   => 0,
        'orderby'       => 'name',
        'title'        => __('Product Categories', 'et_shop'),
        ) );

      echo '<section class="et_shop-product-section et_shop-product-categories">';

        do_action('et_shop_homepage_before_product_categories');

        echo '<h2 class="section-title">' . wp_kses_post($args['title']) . '</h2>';

        echo et_shop_do_shortcode( 'product_categories',
          array(
            'number'   => intval($args['limit']),
            'columns'  => intval($args['columns']),
            'orderby'  => esc_attr($args['orderby']),
            'parent'  => esc_attr($args['child_categories']),
            ) );

        do_action('et_shop_homepage_after_product_categories');

      echo '</section>';

    }
  }
}

if(! function_exists('et_shop_recent_products')) {
  /**
   * Display Recent Products
   * Hooked into the `homepage` action in the homepage template
   * @since  1.0.0
   * @return void
   */
  function et_shop_recent_products($args) {

    if(is_woocommerce_activated()) {

      $args = apply_filters( 'et_shop_recent_products_args', array(
        'limit'       => 4,
        'columns'       => 4,
        'title'        => __('Recent Products', 'et_shop'),
        ) );

      echo '<section class="et_shop-product-section et_shop-recent-products">';

        do_action('et_shop_homepage_before_recent_products');

        echo '<h2 class="section-title">' . wp_kses_post($args['title']) . '</h2>';

        echo et_shop_do_shortcode( 'recent_products',
          array(
            'per_page'   => intval($args['limit']),
            'columns'  => intval($args['columns']),
            ) );

        do_action('et_shop_homepage_after_recent_products');

      echo '</section>';
    }
  }
}

if(! function_exists('et_shop_featured_products')) {
  /**
   * Display Featured Products
   * Hooked into the `homepage` action in the homepage template
   * @since  1.0.0
   * @return void
   */
  function et_shop_featured_products($args) {

    if(is_woocommerce_activated()) {

      $featured_query = new WP_Query(array(
          'post_type' => 'product',
          'meta_key' => '_featured',
          'meta_value' => 'yes'
      ));

      if($featured_query->have_posts()) {

        $args = apply_filters( 'et_shop_featured_products_args', array(
          'limit'   => 4,
          'columns' => 4,
          'orderby' => 'date',
          'order'   => 'desc',
          'title'   => __('Featured Products', 'et_shop'),
        ));

        echo '<section class="et_shop-product-section et_shop-featured-products">';

          do_action('et_shop_homepage_before_featured_products');

          echo '<h2 class="section-title">'.wp_kses_post($args['title']).'</h2>';

          echo et_shop_do_shortcode( 'featured_products', array(
            'per_page'   => intval($args['limit']),
            'columns'  => intval($args['columns']),
            'orderby'  => esc_attr($args['orderby']),
            'order'    => esc_attr($args['order']),
          ));

          do_action('et_shop_homepage_after_featured_products');

        echo '</section>';

      }
    }
  }
}

if(! function_exists('et_shop_popular_products')) {
  /**
   * Display Popular Products
   * Hooked into the `homepage` action in the homepage template
   * @since  1.0.0
   * @return void
   */
  function et_shop_popular_products($args) {

    if(is_woocommerce_activated()) {

      $args = apply_filters( 'et_shop_popular_products_args', array(
        'limit'       => 4,
        'columns'       => 4,
        'title'        => __('Top Rated Products', 'et_shop'),
        ) );

      echo '<section class="et_shop-product-section et_shop-popular-products">';

        do_action('et_shop_homepage_before_popular_products');

        echo '<h2 class="section-title">' . wp_kses_post($args['title']) . '</h2>';

        echo et_shop_do_shortcode( 'top_rated_products',
          array(
            'per_page'   => intval($args['limit']),
            'columns'  => intval($args['columns']),
            ) );

        do_action('et_shop_homepage_after_popular_products');

      echo '</section>';

    }
  }
}

if(! function_exists('et_shop_on_sale_products')) {

  // Display On Sale Products
  // Hooked into the `homepage` action in the homepage template
  function et_shop_on_sale_products($args) {

    if(is_woocommerce_activated()) {

      $args = apply_filters( 'et_shop_on_sale_products_args', array(
        'limit'       => 4,
        'columns'       => 4,
        'title'        => __('On Sale', 'et_shop'),
        ) );

      echo '<section class="et_shop-product-section et_shop-on-sale-products">';

        do_action('et_shop_homepage_before_on_sale_products');

        echo '<h2 class="section-title">' . wp_kses_post($args['title']) . '</h2>';

        echo et_shop_do_shortcode( 'sale_products',
          array(
            'per_page'   => intval($args['limit']),
            'columns'  => intval($args['columns']),
            ) );

        do_action('et_shop_homepage_after_on_sale_products');

      echo '</section>';

    }
  }
}

if(! function_exists('et_shop_homepage_content')) {
  /**
   * Display homepage content
   * Hooked into the `homepage` action in the homepage template
   * @since  1.0.0
   * @return  void
   */
  function et_shop_homepage_content() {
    while(have_posts()) : the_post();

      get_template_part('content', 'page');

    endwhile; // end of the loop.
  }
}

if(! function_exists('et_shop_social_icons')) {
  /**
   * Display social icons
   * If the subscribe and connect plugin is active, display the icons.
   * @link http://wordpress.org/plugins/subscribe-and-connect/
   * @since 1.0.0
   */
  function et_shop_social_icons() {
    if(class_exists('Subscribe_And_Connect')) {
      echo '<div class="subscribe-and-connect-connect">';
      subscribe_and_connect_connect();
      echo '</div>';
    }
  }
}


// Display et_shop sidebar
function et_shop_get_sidebar() {
  get_sidebar();
}


if(! function_exists('et_shop_post_thumbnail')) {
  /**
   * Display post thumbnail
   * @var $size thumbnail size. thumbnail|medium|large|full|$custom
   * @uses has_post_thumbnail()
   * @uses the_post_thumbnail
   * @param string $size
   * @since 1.5.0
   */
  function et_shop_post_thumbnail($size) {
    if(has_post_thumbnail()) {
      the_post_thumbnail($size, array('itemprop' => 'image'));
    }
  }
}
