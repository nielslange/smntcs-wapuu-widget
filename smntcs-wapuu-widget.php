<?php
/**
 * Plugin Name:           SMNTCS Wapuu Widget
 * Plugin URI:            https://github.com/nielslange/smntcs-wapuu-widget
 * Description:           Sidebar widget to show random Wapuu.
 * Author:                Niels Lange
 * Author URI:            https://nielslange.de
 * Text Domain:           smntcs-wapuu-widget
 * Version:               2.0
 * Requires PHP:          7.4
 * Requires at least:     3.4
 * License:               GPL v2 or later
 * License URI:           https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package SMNTCS_Wapuu_Widget
 */

defined( 'ABSPATH' ) || exit;

// Include required files.
require_once plugin_dir_path( __FILE__ ) . 'includes/class-smntcs-wapuu-manager.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-smntcs-wapuu-widget.php';
