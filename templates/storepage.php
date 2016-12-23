<?php
/**
 * The template for displaying the storepage.
 *
 * This page template will display any functions hooked into the 'storepage' action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components on/off
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Storepage
 *
 * @package storepage
 */

get_header(); ?>

	<div id="primary" class="storepage-content-area">
		<main id="main" class="site-main" role="main">

			<?php
			/**
			 * Functions hooked in to homepage action
			 *
			 * @hooked storepage_homepage_content      - 10
			 * @hooked storepage_product_categories    - 20
			 * @hooked storepage_recent_products       - 30
			 * @hooked storepage_featured_products     - 40
			 * @hooked storepage_popular_products      - 50
			 * @hooked storepage_on_sale_products      - 60
			 * @hooked storepage_best_selling_products - 70
			 */
			do_action( 'storepage' ); ?>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();