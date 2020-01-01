<?php
/**
 * Plugin Name: SMNTCS Wapuu Widget
 * Plugin URI: https://github.com/nielslange/smntcs-simple-events-widget
 * Description: Sidebar widget to show random Wapuu
 * Author: Niels Lange <info@nielslange.de>
 * Author URI: https://nielslange.de
 * Text Domain: smntcs-wapuu-widget
 * Domain Path: /languages/
 * Version: 1.5
 * Requires at least: 3.4
 * Tested up to: 5.2
 * Requires PHP: 5.6
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @category   Plugin
 * @package    WordPress
 * @subpackage SMNTCS Wapuu Widget
 * @author     Niels Lange <info@nielslange.de>
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 */

$plugin_data    = get_file_data( __FILE__, array( 'Version' => 'Version' ), false );
$plugin_version = $plugin_data['Version'];
define( 'SMNTCS_WAPUU_WIDGET_CURRENT_VERSION', $plugin_version );

/**
 * Avoid direct plugin access
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( '¯\_(ツ)_/¯' );
}

/**
 * Load text domain
 */
function smntcs_wapuu_widget_plugins_loaded() {
	load_plugin_textdomain( 'smntcs-wapuu-widget', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'smntcs_wapuu_widget_plugins_loaded' );

/**
 * Load plugin styles
 */
function smntcs_wapuu_widget_enqueue_scripts() {
	wp_register_style( 'smntcs_wapuu_widget-style', plugins_url( 'style.css', __FILE__ ), array(), SMNTCS_WAPUU_WIDGET_CURRENT_VERSION );
	wp_enqueue_style( 'smntcs_wapuu_widget-style' );
}
add_action( 'wp_enqueue_scripts', 'smntcs_wapuu_widget_enqueue_scripts' );

/**
 * Add settings link on plugin page
 *
 * @param string $links The original settings link on the plugin page.
 * @return string $links The updated settings link on the plugin page.
 * @since 1.0.0
 */
function smntcs_wapuu_widget_plugin_settings_link( $links ) {
	$admin_url    = admin_url( 'widgets.php' );
	$settings_url = sprintf( '<a href="%s">%s</a>', $admin_url, __( 'Settings', 'smntcs-wapuu-widget' ) );
	array_unshift( $links, $settings_url );

	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'smntcs_wapuu_widget_plugin_settings_link' );

/**
 * Register SMNTCS Wapuu Widget
 *
 * @since 1.0.0
 */
class SMNTCS_Wapuu_Widget extends WP_Widget {

	/**
	 * Construct widget
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		$widget_options = array(
			'classname'   => 'smntcs_wapuu_widget',
			'description' => 'Displays Wapuu Widget',
		);

		parent::__construct( 'smntcs_wapuu_widget', 'Wapuu Widget', $widget_options );

	}

	/**
	 * Prepare widget
	 *
	 * @param array $args Display arguments including 'before_title', 'after_title', 'before_widget', and 'after_widget'.
	 * @param array $instance The settings for the particular instance of the widget.
	 * @since 1.0.0
	 */
	public function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', $instance['title'] );
		$files = preg_grep( '/^([^.])/', scandir( plugin_dir_path( __FILE__ ) . 'images' ) );
		$files = array_merge( $files );

		$min   = 0;
		$max   = count( $files ) - 1;
		$image = $files[ wp_rand( $min, $max ) ];

		if ( ! empty( $title ) ) {
			print( $args['before_widget'] . $args['before_title'] . esc_html( $title ) . $args['after_title'] );
		}

		printf( '<p><img src="%s" alt="" class="wapuu"></p>', esc_html( plugin_dir_url( __FILE__ ) ) . 'images/' . esc_html( $image ) );
		printf( $args['after_widget'] );

	}

	/**
	 * Prepare form
	 *
	 * @param array $instance Current settings.
	 * @return void
	 * @since 1.0.0
	 */
	public function form( $instance ) {

		$title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>">Title:</label>
			<input type="text" id="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php

	}

	/**
	 * Update widget
	 *
	 * @param array $new_instance New settings for this instance as input by the user via WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @since 1.0.0
	 */
	public function update( $new_instance, $old_instance ) {

		$instance          = $old_instance;
		$instance['title'] = wp_strip_all_tags( $new_instance['title'] );

		return $instance;

	}

}

/**
 * Register widget
 *
 * @since 1.0.0
 */
function smntcs_register_wapuu_widget() {
	register_widget( 'SMNTCS_Wapuu_Widget' );
}
add_action( 'widgets_init', 'smntcs_register_wapuu_widget' );
