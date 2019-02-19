<?php
/**
 * Plugin Name: SMNTCS Wapuu Widget
 * Plugin URI: https://github.com/nielslange/smntcs-simple-events-widget
 * Description: Sidebar widget to show random Wapuu
 * Author: Niels Lange
 * Author URI: https://nielslange.com
 * Text Domain: smntcs-wapuu-widget
 * Domain Path: /languages/
 * Version: 1.2
 * Requires at least: 3.4
 * Tested up to: 5.0
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

/* Copyright 2014-2016	Niels Lange (email : info@nielslange.de)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Avoid direct plugin access
if ( !defined( 'ABSPATH' ) ) exit;

// Load text domain
add_action('plugins_loaded', 'smntcs_wapuu_widget_plugins_loaded');
function smntcs_wapuu_widget_plugins_loaded() {
	load_plugin_textdomain( 'smntcs-wapuu-widget', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}

// Load plugin styles
add_action( 'wp_enqueue_scripts', 'smntcs_wapuu_widget_enqueue_scripts' );
function smntcs_wapuu_widget_enqueue_scripts() {
    wp_register_style( 'smntcs_wapuu_widget-style', plugins_url('style.css', __FILE__) );
    wp_enqueue_style( 'smntcs_wapuu_widget-style' );
}

// Add settings link on plugin page
add_filter("plugin_action_links_" . plugin_basename(__FILE__), 'smntcs_wapuu_widget_plugin_settings_link' );
function smntcs_wapuu_widget_plugin_settings_link($links) {
	$admin_url     = admin_url( 'widgets.php' );
	$settings_url  = sprintf( '<a href="%s">%s</a>', $admin_url, __('Settings', 'smntcs-wapuu-widget') );
	array_unshift( $links, $settings_url );
	
  return $links;
}

class SMNTCS_Wapuu_Widget extends WP_Widget {
  /**
  * To create the example widget all four methods will be 
  * nested inside this single instance of the WP_Widget class.
  **/
  public function __construct() {
    $widget_options = array( 
      'classname'   => 'smntcs_wapuu_widget',
      'description' => 'Displays Wapuu Widget',
    );
    
    parent::__construct( 'smntcs_wapuu_widget', 'Wapuu Widget', $widget_options );
  }
  
  public function widget( $args, $instance ) {
    $title    = apply_filters( 'widget_title', $instance[ 'title' ] );
    $filePath = 'wp-content/plugins/smntcs-wapuu-widget/images/';  
    $files    = glob($filePath. '*.{jpeg,gif,png}', GLOB_BRACE);
    $min      = 0;
    $max      = count($files) - 1;
    $image    = $files[rand($min, $max)];
    
    print($args['before_widget'] . $args['before_title'] . $title . $args['after_title']);
    printf('<img src="/%s" alt="" class="wapuu">', $image);
    printf($args['after_widget']);
  }
  
  public function form( $instance ) {
    $title = !empty( $instance['title'] ) ? $instance['title'] : ''; ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
      <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
    </p><?php 
  }
  
  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
    
    return $instance;
  }
  
}

add_action( 'widgets_init', 'smntcs_register_wapuu_widget' );
function smntcs_register_wapuu_widget() { 
  register_widget( 'SMNTCS_Wapuu_Widget' );
}