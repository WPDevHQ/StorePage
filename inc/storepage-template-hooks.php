<?php

/**
 * Homepage
 *
 * @see  storepage_homepage_content()
 * @see  storepage_product_categories()
 * @see  storepage_recent_products()
 * @see  storepage_featured_products()
 * @see  storepage_popular_products()
 * @see  storepage_on_sale_products()
 * @see  storepage_best_selling_products()
 */
add_action( 'storepage', 'storepage_content',      10 );
add_action( 'storepage', 'storepage_product_categories',    20 );
add_action( 'storepage', 'storepage_recent_products',       30 );
add_action( 'storepage', 'storepage_featured_products',     40 );
add_action( 'storepage', 'storepage_popular_products',      50 );
add_action( 'storepage', 'storepage_on_sale_products',      60 );
add_action( 'storepage', 'storepage_best_selling_products', 70 );