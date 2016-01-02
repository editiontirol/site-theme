<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package et_shop
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function et_shop_page_menu_args( $args ) {
  $args['show_home'] = true;
  return $args;
}

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function et_shop_body_classes( $classes ) {
  // Adds a class of group-blog to blogs with more than 1 published author.
  if ( is_multi_author() ) {
    $classes[] = 'group-blog';
  }

  if ( ! function_exists( 'woocommerce_breadcrumb' ) ) {
    $classes[]  = 'no-wc-breadcrumb';
  }

  /**
   * What is this?!
   * Take the blue pill, close this file and forget you saw the following code.
   * Or take the red pill, filter et_shop_make_me_cute and see how deep the rabbit hole goes...
   */
  $cute  = apply_filters( 'et_shop_make_me_cute', false );

  if ( true === $cute ) {
    $classes[] = 'et_shop-cute';
  }

  return $classes;
}

/**
 * Query WooCommerce activation
 */
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
  function is_woocommerce_activated() {
    return class_exists( 'woocommerce' ) ? true : false;
  }
}

/**
 * Schema type
 * @return string schema itemprop type
 */
function et_shop_html_tag_schema() {
  $schema   = 'http://schema.org/';
  $type     = 'WebPage';

  // Is single post
  if ( is_singular( 'post' ) ) {
    $type   = 'Article';
  }

  // Is author page
  elseif ( is_author() ) {
    $type   = 'ProfilePage';
  }

  // Is search results page
  elseif ( is_search() ) {
    $type   = 'SearchResultsPage';
  }

  echo 'itemscope="itemscope" itemtype="' . esc_attr( $schema ) . esc_attr( $type ) . '"';
}

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function et_shop_categorized_blog() {
  if ( false === ( $all_the_cool_cats = get_transient( 'et_shop_categories' ) ) ) {
    // Create an array of all the categories that are attached to posts.
    $all_the_cool_cats = get_categories( array(
      'fields'     => 'ids',
      'hide_empty' => 1,

      // We only need to know if there is more than one category.
      'number'     => 2,
    ) );

    // Count the number of categories that are attached to the posts.
    $all_the_cool_cats = count( $all_the_cool_cats );

    set_transient( 'et_shop_categories', $all_the_cool_cats );
  }

  if ( $all_the_cool_cats > 1 ) {
    // This blog has more than 1 category so et_shop_categorized_blog should return true.
    return true;
  } else {
    // This blog has only 1 category so et_shop_categorized_blog should return false.
    return false;
  }
}

/**
 * Flush out the transients used in et_shop_categorized_blog.
 */
function et_shop_category_transient_flusher() {
  // Like, beat it. Dig?
  delete_transient( 'et_shop_categories' );
}
add_action( 'edit_category', 'et_shop_category_transient_flusher' );
add_action( 'save_post',     'et_shop_category_transient_flusher' );

/**
 * Call a shortcode function by tag name.
 *
 * @since  1.4.6
 *
 * @param string $tag     The shortcode whose function to call.
 * @param array  $atts    The attributes to pass to the shortcode function. Optional.
 * @param array  $content The shortcode's content. Default is null (none).
 *
 * @return string|bool False on failure, the result of the shortcode on success.
 */
function et_shop_do_shortcode( $tag, array $atts = array(), $content = null ) {

  global $shortcode_tags;

  if ( ! isset( $shortcode_tags[ $tag ] ) ) {
    return false;
  }

  return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
}
