<?php
/**
 * SMNTCS Wapuu Manager Class
 *
 * @package SMNTCS_Wapuu_Widget
 */

defined( 'ABSPATH' ) || exit;

/**
 * SMNTCS Wapuu Manager
 *
 * Core functionality for the plugin
 */
class SMNTCS_Wapuu_Manager {

	/**
	 * Plugin version
	 *
	 * @var string
	 */
	private $version;

	/**
	 * Instance of this class
	 *
	 * @var SMNTCS_Wapuu_Manager
	 */
	private static $instance = null;

	/**
	 * Constructor
	 */
	private function __construct() {
		$plugin_data   = get_file_data( dirname( __DIR__ ) . '/smntcs-wapuu-widget.php', array( 'Version' => 'Version' ), false );
		$this->version = $plugin_data['Version'];

		$this->define_constants();
		$this->init_hooks();
	}

	/**
	 * Get the singleton instance
	 *
	 * @return SMNTCS_Wapuu_Manager
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Define plugin constants
	 */
	private function define_constants() {
		define( 'SMNTCS_WAPUU_WIDGET_CURRENT_VERSION', $this->version );
	}

	/**
	 * Initialize hooks
	 */
	private function init_hooks() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_filter( 'plugin_action_links_' . plugin_basename( dirname( __DIR__ ) . '/smntcs-wapuu-widget.php' ), array( $this, 'add_plugin_settings_link' ) );
		add_action( 'widgets_init', array( $this, 'register_wapuu_widget' ) );
	}

	/**
	 * Load plugin styles
	 */
	public function enqueue_scripts() {
		wp_register_style( 'smntcs_wapuu_widget-style', plugins_url( 'style.css', __DIR__ ), array(), $this->version );
		wp_enqueue_style( 'smntcs_wapuu_widget-style' );
	}

	/**
	 * Add settings link on plugin page
	 *
	 * @param string[] $links The original settings link on the plugin page.
	 * @return string[] $links The updated settings link on the plugin page.
	 */
	public function add_plugin_settings_link( $links ) {
		$admin_url     = admin_url( 'widgets.php' );
		$settings_link = sprintf( '<a href="%s">%s</a>', $admin_url, __( 'Settings', 'smntcs-wapuu-widget' ) );
		array_unshift( $links, $settings_link );

		return $links;
	}

	/**
	 * Register widget
	 */
	public function register_wapuu_widget() {
		register_widget( 'SMNTCS_Wapuu_Widget' );
	}

	/**
	 * Get random image URL
	 *
	 * @return string
	 */
	public static function get_random_image_url() {
		$images = self::get_wapuu_images();
		return $images[ array_rand( $images ) ];
	}

	/**
	 * Get all available Wapuu images
	 *
	 * @return array
	 */
	public static function get_wapuu_images() {
		return array(
			'10uppu-230x230.png',
			'8-bit-wapuu-large-230x288.png',
			'80s-wapuu-230x212.png',
			'930C06B1-D040-4D31-BF2C-D66930897495-230x196.png',
			'Achilles1-230x330.png',
			'BG_Wapuu-01-230x237.png',
			'Colorado-Wapuu-230x257.png',
			'CopernicusWapuu-230x230.png',
			'DEVMan-1-230x288.png',
			'Defender-1-230x288.png',
			'Fayapuu-230x247.png',
			'FishingWapuu-230x279.png',
			'Habu-230x198.png',
			'Hummingbird-1-230x288.png',
			'Large_lobster_wapuu-230x320.png',
			'Manapuu-230x386.png',
			'Pantheon-Wapuu@3x-230x252.png',
			'Patheon-Waving-Wapuu-230x257.png',
			'Permalink_1024-with-wp-230x370.png',
			'Smush-1-230x288.png',
			'Snapshot-1-230x288.png',
			'Swag-Wapuu-Orlando-2016-230x237.png',
			'WAPUU-ATI-230x362.png',
			'WC-Biratnagar-Logo-n-Mascot-230x230.png',
			'WC-Denpasar-2016-Wapuu-Garuda-e1548453921415-230x290.png',
			'WC-Denpasar-2016-Wapuu-Wayan-230x293.png',
			'WC-Jakarta-2017-Wapuu-Ondel-ondel-male-230x351.png',
			'WC-Jakarta-2019-Wapuu-Ojol-230x266.png',
			'WC-Jakarta-2019-Wapuu-Ondel-ondel-female-230x348.png',
			'WC-Jakarta-2019-Wapuu-Si-Pitung-230x280.png',
			'WC-Jakarta-2019-Wapuu-Wiro-Sableng-230x271.png',
			'WC-Ubud-2017-Wapuu-Kelapa-Muda-230x304.png',
			'WCATL_Wapuu_Web.png',
			'WCEU-18-Astropuu-230x230.png',
			'WCPHX-Wapuu-W-no-pants_preview-230x282.png',
			'WCPHX-Wapuu-W_preview-230x282.png',
			'WCPHX-Wapuu-plane-9-purple@3x_preview-230x230.png',
			'WCUS2018-wapuu-blue-230x181.png',
			'WPTD3-wapuu-800-230x230.png',
			'Wabully_2048x2580-1-230x290.png',
			'WapUshanka-230x286.png',
			'Wapoutine-230x244.png',
			'Wapuu-01-230x267.png',
			'Wapuu-02-230x271.png',
			'Wapuu-03-230x229.png',
			'Wapuu-04-230x276.png',
			'Wapuu-Salentinu-230x230.png',
			'Wapuu-Sofia-2017-all-01-230x290.png',
			'Wapuu-Sofia-2017-all-02-230x315.png',
			'Wapuu-Thessaloniki-Alexander-230x253.png',
			'Wapuu-sleepy-jacksonville-230x101.png',
			'WapuuFinal-230x318.png',
			'WapuuNashville-230x167.png',
			'WapuuPepa-230x253.png',
			'WapuuPepe-230x253.png',
			'WapuuSticker-Die-curves-230x309.png',
			'Wapuubble-230x135.png',
			'WelshWapuuV2-2-230x212.png',
			'WordSesh-Wapuu-230x199.png',
			'ahmedabad-wordcamp2017-Wapuu2-230x282.png',
			'ahmedabad-wordpress-Wapuu-150517-03-230x312.png',
			'ammuappu-230x171.png',
			'auguste-230x280.png',
			'baap-wapuu.png',
			'bapuu-wapuu-230x253.png',
			'basile-wapuu-230x252.png',
			'batpuu-230x276.png',
			'benpuu-230x230.png',
			'better-off-WordPress-230x148.png',
			'bicycling-wapuu-230x245.png',
			'birthday-wapuu-230x256.png',
			'black-hat-230x271.png',
			'brighton-wapuu-and-sid-2016-230x233.png',
			'brownie-shading@3x-230x225.png',
			'building-block-wapuu-orlando-2016-230x237.png',
			'canvas-wapuu.png',
			'captian-w-230x292.png',
			'carole-community-wapuu-230x284.png',
			'catering-wapuu.png',
			'cheesesteak-wapuu-230x230.png',
			'cossack-wapuula-230x253.png',
			'cowboy-coder-230x269.png',
			'cowboy-wapuu-230x321.png',
			'cowpuu-jacksonvill-pin@3x-230x237.png',
			'crab_wapuu-230x230.png',
			'cropped-wapuu-brno-512-512-230x230.png',
			'cubby-wapuu-230x232.png',
			'david-bowie-wapuu-230x203.png',
			'delhi-wapuu-2017-230x316.png',
			'dokuganryu-wapuu-230x253.png',
			'dracuu-230x215.png',
			'duerer-wapuu-230x230.png',
			'edinburgh-wapuu-230x247.png',
			'eduwapuu-230x253.png',
			'eight-ball-wapuu-230x254.png',
			'exercisering-wapuu-230x255.png',
			'fes-wapuu-230x253.png',
			'football_wapuu-230x254.png',
			'frankenpuu-230x230.png',
			'frapuu-01-768x750-230x225.png',
			'fujisan-wapuu-230x229.png',
			'geekpuu-right@4x-230x240.png',
			'ghost-costume-wapuu-230x233.png',
			'ghostbuster_wapuu-230x260.png',
			'gianduu_wapuu-230x301.png',
			'gokart_wapuu-230x204.png',
		);
	}
}

SMNTCS_Wapuu_Manager::get_instance();
