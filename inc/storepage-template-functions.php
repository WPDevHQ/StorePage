<?php
/**
 * Query WooCommerce activation
 */
if ( ! function_exists( 'is_woocommerce_activated' ) ) {

    function is_woocommerce_activated() {
	    return class_exists( 'woocommerce' ) ? true : false;
    }

}

if ( ! function_exists( 'storepage_product_categories' ) ) {
	/**
	 * Display Product Categories
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function storepage_product_categories( $args ) {

		if ( is_woocommerce_activated() ) {

			$args = apply_filters( 'storepage_product_categories_args', array(
				'limit' 			=> 3,
				'columns' 			=> 3,
				'child_categories' 	=> 0,
				'orderby' 			=> 'name',
				'title'				=> __( 'Shop by Category', 'storepage' ),
			) );

			echo '<section class="storepage-product-section storepage-product-categories">';

			do_action( 'storepage_before_product_categories' );

			echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';

			do_action( 'storepage_after_product_categories_title' );

			echo storepage_do_shortcode( 'product_categories', array(
				'number'  => intval( $args['limit'] ),
				'columns' => intval( $args['columns'] ),
				'orderby' => esc_attr( $args['orderby'] ),
				'parent'  => esc_attr( $args['child_categories'] ),
			) );

			do_action( 'storepage_after_product_categories' );

			echo '</section>';
		}
	}
}

if ( ! function_exists( 'storepage_recent_products' ) ) {
	/**
	 * Display Recent Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function storepage_recent_products( $args ) {

		if ( is_woocommerce_activated() ) {

			$args = apply_filters( 'storepage_recent_products_args', array(
				'limit' 			=> 4,
				'columns' 			=> 4,
				'title'				=> __( 'New In', 'storepage' ),
			) );

			echo '<section class="storepage-product-section storepage-recent-products">';

			do_action( 'storepage_before_recent_products' );

			echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';

			do_action( 'storepage_after_recent_products_title' );

			echo storepage_do_shortcode( 'recent_products', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
			) );

			do_action( 'storepage_after_recent_products' );

			echo '</section>';
		}
	}
}

if ( ! function_exists( 'storepage_featured_products' ) ) {
	/**
	 * Display Featured Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function storepage_featured_products( $args ) {

		if ( is_woocommerce_activated() ) {

			$args = apply_filters( 'storepage_featured_products_args', array(
				'limit'   => 4,
				'columns' => 4,
				'orderby' => 'date',
				'order'   => 'desc',
				'title'   => __( 'We Recommend', 'storepage' ),
			) );

			echo '<section class="storepage-product-section storepage-featured-products">';

			do_action( 'storepage_before_featured_products' );

			echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';

			do_action( 'storepage_after_featured_products_title' );

			echo storepage_do_shortcode( 'featured_products', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
				'orderby'  => esc_attr( $args['orderby'] ),
				'order'    => esc_attr( $args['order'] ),
			) );

			do_action( 'storepage_after_featured_products' );

			echo '</section>';
		}
	}
}

if ( ! function_exists( 'storepage_popular_products' ) ) {
	/**
	 * Display Popular Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function storepage_popular_products( $args ) {

		if ( is_woocommerce_activated() ) {

			$args = apply_filters( 'storepage_popular_products_args', array(
				'limit'   => 4,
				'columns' => 4,
				'title'   => __( 'Fan Favorites', 'storepage' ),
			) );

			echo '<section class="storepage-product-section storepage-popular-products">';

			do_action( 'storepage_before_popular_products' );

			echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';

			do_action( 'storepage_after_popular_products_title' );

			echo storepage_do_shortcode( 'top_rated_products', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
			) );

			do_action( 'storepage_after_popular_products' );

			echo '</section>';
		}
	}
}

if ( ! function_exists( 'storepage_on_sale_products' ) ) {
	/**
	 * Display On Sale Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @param array $args the product section args.
	 * @since  1.0.0
	 * @return void
	 */
	function storepage_on_sale_products( $args ) {

		if ( is_woocommerce_activated() ) {

			$args = apply_filters( 'storepage_on_sale_products_args', array(
				'limit'   => 4,
				'columns' => 4,
				'title'   => __( 'On Sale', 'storepage' ),
			) );

			echo '<section class="storepage-product-section storepage-on-sale-products">';

			do_action( 'storepage_before_on_sale_products' );

			echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';

			do_action( 'storepage_after_on_sale_products_title' );

			echo storepage_do_shortcode( 'sale_products', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
			) );

			do_action( 'storepage_after_on_sale_products' );

			echo '</section>';
		}
	}
}

if ( ! function_exists( 'storepage_best_selling_products' ) ) {
	/**
	 * Display Best Selling Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since 2.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function storepage_best_selling_products( $args ) {
		if ( is_woocommerce_activated() ) {
			
			$args = apply_filters( 'storepage_best_selling_products_args', array(
				'limit'   => 4,
				'columns' => 4,
				'title'	  => esc_attr__( 'Best Sellers', 'storepage' ),
			) );
			
			echo '<section class="storepage-product-section storepage-best-selling-products">';
			
			do_action( 'storepage_before_best_selling_products' );
			
			echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';
			
			do_action( 'storepage_after_best_selling_products_title' );
			
			echo storepage_do_shortcode( 'best_selling_products', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
			) );
			
			do_action( 'storepage_after_best_selling_products' );
			
			echo '</section>';
		}
	}
}

if ( ! function_exists( 'storepage_content' ) ) {
	/**
	 * Display the_content
	 * Hooked into the `storepage` action in the storepage template
	 *
	 * @since  1.0.0
	 * @return  void
	 */
	function storepage_content() {
		while ( have_posts() ) {
			the_post();
            echo '<section class="storepage-section">';
			echo '<div class="storepage-content">';
			echo '<div class="storepage-content-inner">';
			    storepage_page_content();
			echo '</div>';
			echo '</div>';
			echo '</section>';

		} // end of the loop.
	}
}


if ( ! function_exists( 'storepage_page_content' ) ) {
	/**
	 * Display the post content with a link to the single post
	 * @since 1.0.0
	 */
	function storepage_page_content() {
		?>
		<header class="storepage entry-header">
			<?php
			    the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' );
			?>
		</header><!-- .entry-header -->
		<div class="storepage entry-content" itemprop="mainContentOfPage">
			<?php 
			global $more;
            $more = 0;
			the_content( 'Continue Reading' ); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'actions' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
		<?php
	}
}

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
function storepage_do_shortcode( $tag, array $atts = array(), $content = null ) {

	global $shortcode_tags;

	if ( ! isset( $shortcode_tags[ $tag ] ) ) {
		return false;
	}

	return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
}