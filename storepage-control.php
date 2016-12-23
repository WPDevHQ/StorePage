<?php


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Returns the main instance of Storepage_Control to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Storepage_Control
 */
function Storepage_Control() {
	return Storepage_Control::instance();
} // End Storepage_Control()

Storepage_Control();

/**
 * Main Storepage_Control Class
 *
 * @class Storepage_Control
 * @version	1.0.0
 * @since 1.0.0
 * @package	Kudos
 * @author Matty
 */
final class Storepage_Control {
	/**
	 * Storepage_Control The single instance of Storepage_Control.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * The token.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $token;

	/**
	 * The version number.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $version;

	/**
	 * An instance of the Storepage_Control_Admin class.
	 * @var     object
	 * @access  public
	 * @since   1.0.0
	 */
	public $admin;

	/**
	 * The name of the hook on which we will be working our magic.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $hook;

	/**
	 * Constructor function.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct () {
		$this->token 			= 'storepage-control';
		$this->plugin_url 		= plugin_dir_url( __FILE__ );
		$this->plugin_path 		= plugin_dir_path( __FILE__ );
		$this->version 			= '2.0.2';
		$this->hook 			= (string)apply_filters( 'storepage_control_hook', 'storepage' );

		add_action( 'plugins_loaded', array( $this, 'maybe_migrate_data' ) );

		register_activation_hook( __FILE__, array( $this, 'install' ) );

		/* Setup Customizer. */
		require_once( 'classes/class-storepage-control-customizer.php' );

		/* Reorder Components. */
		if ( ! is_admin() ) {
			add_action( 'get_header', array( $this, 'maybe_apply_restructuring_filter' ) );
		}
	} // End __construct()

	/**
	 * Main Storepage_Control Instance
	 *
	 * Ensures only one instance of Storepage_Control is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see Storepage_Control()
	 * @return Main Kudos instance
	 */
	public static function instance () {
		if ( is_null( self::$_instance ) )
			self::$_instance = new self();
		return self::$_instance;
	} // End instance()

	/**
	 * Installation. Runs on activation.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function install () {
		$this->_log_version_number();
	} // End install()

	/**
	 * Log the plugin version number.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	private function _log_version_number () {
		// Log the version number.
		update_option( $this->token . '_version', $this->version );
	} // End _log_version_number()

	/**
	 * Migrate data from versions prior to 2.0.0.
	 * @access  public
	 * @since   2.0.0
	 * @return  void
	 */
	public function maybe_migrate_data () {
		$options = get_theme_mod( 'storepage_control' );

		if ( ! isset( $options ) ) {
			return; // Option is empty, probably first time installing the plugin.
		}

		if ( is_array( $options ) ) {
			$order = '';
			$disabled = '';
			$components = array();

			if ( isset( $options['component_order'] ) ) {
				$order = explode( ',', $options['component_order'] );

				if ( isset( $options['disabled_components'] ) ) {
					$disabled = explode( ',', $options['disabled_components'] );
				}

				if ( 0 < count( $order ) ) {
					foreach ( $order as $k => $v ) {
						if ( in_array( $v, $disabled ) ) {
							$components[] = '[disabled]' . $v; // Add disabled tag
						} else {
							$components[] = $v;
						}
					}
				}
			}

			$components = join( ',', $components );

			// Replace old data
			set_theme_mod( 'storepage_control', $components );
		}
	} // End maybe_migrate_data()

	/**
	 * Work through the stored data and display the components in the desired order, without the disabled components.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function maybe_apply_restructuring_filter () {
		$options = get_theme_mod( 'storepage_control' );
		$components = array();

		if ( isset( $options ) && '' != $options ) {
			$components = explode( ',', $options );

			// Remove all existing actions on woo_homepage.
			remove_all_actions( $this->hook );

			// Remove disabled components
			$components = $this->_maybe_remove_disabled_items( $components );

			// Perform the reordering!
			if ( 0 < count( $components ) ) {
				$count = 5;
				foreach ( $components as $k => $v ) {
					if (strpos( $v, '@' ) !== FALSE) {
						$obj_v = explode( '@' , $v );
						if ( class_exists( $obj_v[0] ) && method_exists( $obj_v[0], $obj_v[1] ) ) {
							add_action( $this->hook, array( $obj_v[0], $obj_v[1] ), $count );
						} // End If Statement
					} else {
						if ( function_exists( $v ) ) {
							add_action( $this->hook, esc_attr( $v ), $count );
						}
					} // End If Statement

					$count + 5;
				}
			}
		}
	} // End maybe_apply_restructuring_filter()

	/**
	 * Maybe remove disabled items from the main ordered array.
	 * @access  private
	 * @since   1.0.0
	 * @param   array $components 	Array with components order.
	 * @return  array           	Re-ordered components with disabled components removed.
	 */
	private function _maybe_remove_disabled_items( $components ) {
		if ( 0 < count( $components ) ) {
			foreach ( $components as $k => $v ) {
				if ( false !== strpos( $v, '[disabled]' ) ) {
					unset( $components[ $k ] );
				}
			}
		}
		return $components;
	} // End _maybe_remove_disabled_items()
} // End Class