<?php

class StorePagePro {

        /**
         * A reference to an instance of this class.
         */
        private static $instance;

        /**
         * The array of templates that this plugin tracks.
         */
        protected $templates;

        /**
         * Returns an instance of this class. 
         */
        public static function get_instance() {

                if( null == self::$instance ) {
                    self::$instance = new StorePagePro();
                } 

                return self::$instance;

        }

        public function storepage_load_plugin_textdomain() {
		    load_plugin_textdomain( 'storepage' );
	    }
		
        /**
         * Initializes the plugin by setting filters and administration functions.
         */
        private function __construct() {

            $this->templates = array();
				
			add_action( 'init', array( $this, 'storepage_load_plugin_textdomain' ) );
			
			add_action( 'init', array( $this, 'storepage_setup' ) );
				
			add_action( 'wp_enqueue_scripts', array( $this, 'storepage_styles' ), 999 );
			add_action( 'wp_enqueue_scripts', array( $this, 'storepage_scripts' ) );

            // Add a filter to the attributes metabox to inject template into the cache.
			if ( version_compare( floatval($GLOBALS['wp_version']), '4.7', '<' ) ) { // 4.6.1 and older
				add_filter(
					'page_attributes_dropdown_pages_args',
				array( $this, 'register_project_templates' )
			);
			} else { // Add a filter to the wp 4.7 version attributes metabox
				add_filter(
					'theme_page_templates', array( $this, 'add_new_template' )
				);
			}

			// Add a filter to the save post to inject out template into the page cache
            add_filter(
				'wp_insert_post_data', 
				array( $this, 'register_storepage_templates' ) 
			);


            // Add a filter to the template include to determine if the page has our 
			// template assigned and return it's path
            add_filter(
				'template_include', 
				array( $this, 'view_storepage_template') 
			);


            // Add your templates to this array.
            $this->templates = array(
                'templates/storepage.php'     => __( 'StorePagePro: Woo StoreFront', 'storepage' ),
            );
				
        }
		
		/**
     	 * Adds our template to the page dropdown for v4.7+
     	 *
     	 */
    	public function add_new_template( $posts_templates ) {
        	$posts_templates = array_merge( $posts_templates, $this->templates );
        	return $posts_templates;
    	}

        /**
         * Adds our template to the pages cache in order to trick WordPress
         * into thinking the template file exists where it doens't really exist.
         *
         */

        public function register_storepage_templates( $atts ) {

                // Create the key used for the themes cache
                $cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

                // Retrieve the cache list. 
				// If it doesn't exist, or it's empty prepare an array
				$templates = wp_get_theme()->get_page_templates();
                if ( empty( $templates ) ) {
                        $templates = array();
                } 

                // New cache, therefore remove the old one
                wp_cache_delete( $cache_key , 'themes');

                // Now add our template to the list of templates by merging our templates
                // with the existing templates array from the cache.
                $templates = array_merge( $templates, $this->templates );

                // Add the modified cache to allow WordPress to pick it up for listing
                // available templates
                wp_cache_add( $cache_key, $templates, 'themes', 1800 );

                return $atts;

        } 

        /**
         * Checks if the template is assigned to the page
         */
        public function view_storepage_template( $template ) {

                global $post;

                if (!isset($this->templates[get_post_meta( 
					$post->ID, '_wp_page_template', true 
				)] ) ) {
					
                    return $template;
						
                } 

                $file = plugin_dir_path(__FILE__). get_post_meta( 
					$post->ID, '_wp_page_template', true 
				);
				
                // Just to be safe, we check if the file exist first
                if( file_exists( $file ) ) {
                    return $file;
                } 
				else { echo $file; }

                return $template;

        }
		
		/**
	     * Setup all the things.
	     * Only executes if Storefront or a child theme using Storefront as a parent is active and the extension specific filter returns true.
	     * Child themes can disable this extension using the storefront_homepage_extra_sections_supported filter
	     * @return void
	     */
	    public function storepage_setup() {
			// Declare WooCommerce support
	        add_theme_support( 'woocommerce' );
		}
		
		/**
	     * Enqueue CSS for active theme.
	     * @since   1.0.0
	     * @return  void
	     */
	    public function storepage_styles() {
		    wp_enqueue_style( 'storepage-styles', plugins_url( '/assets/css/styles.css', __FILE__  ) );
	    }
		
		/**
	     * Enqueue JS and custom scripts.
	     * @since   1.0.0
	     * @return  void
	     */
	    public function storepage_scripts() {

	        wp_enqueue_script( 'clip-path-polygon', plugins_url( '/assets/js/clip-path-polygon.min.js', __FILE__ ), array( 'jquery' ), '0.1.10', true );
	    
		    wp_enqueue_script( 'storepage-js', plugins_url( '/assets/js/storepage.js', __FILE__ ), array( 'clip-path-polygon' ), '', true );
	    }
} 

add_action( 'plugins_loaded', array( 'StorePagePro', 'get_instance' ) );