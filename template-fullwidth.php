<?php // Template Name: Full-Width

get_header(); ?>
  <div id="primary" class="content-area">
    <main id="main" class="site-main">
      <?php while(have_posts()) {
        the_post();

        do_action('et_shop_page_before');
        get_template_part('content', 'page');
        do_action('et_shop_page_after');
      } ?>
    </main>
  </div>
<?php get_footer(); ?>
