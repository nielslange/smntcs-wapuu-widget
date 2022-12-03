<?php
/**
 * Plugin Name:           SMNTCS Wapuu Widget
 * Plugin URI:            https://github.com/nielslange/smntcs-wapuu-widget
 * Description:           Sidebar widget to show random Wapuu.
 * Author:                Niels Lange
 * Author URI:            https://nielslange.de
 * Text Domain:           smntcs-wapuu-widget
 * Version:               1.8
 * Requires PHP:          5.6
 * Requires at least:     3.4
 * License:               GPL v2 or later
 * License URI:           https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package SMNTCS_Wapuu_Widget
 */

defined( 'ABSPATH' ) || exit;

/**
 * Fetch plugin version.
 */
$plugin_data    = get_file_data( __FILE__, array( 'Version' => 'Version' ), false );
$plugin_version = $plugin_data['Version'];
define( 'SMNTCS_WAPUU_WIDGET_CURRENT_VERSION', $plugin_version );

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
 */
function smntcs_wapuu_widget_plugin_settings_link( $url ) {
	$admin_url     = admin_url( 'widgets.php' );
	$settings_link = sprintf( '<a href="%s">%s</a>', $admin_url, __( 'Settings', 'smntcs-wapuu-widget' ) );
	array_unshift( $url, $settings_link );

	return $url;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'smntcs_wapuu_widget_plugin_settings_link' );

/**
 * Register SMNTCS Wapuu Widget
 */
class SMNTCS_Wapuu_Widget extends WP_Widget {

	/**
	 * Construct widget
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
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$image = smntcs_get_random_image_url();

		printf(
			'%s %s %s %s',
			$args['before_widget'], // phpcs:ignore.
			$args['before_title'],  // phpcs:ignore.
			esc_attr( $title ),
			$args['after_title']    // phpcs:ignore.
		);

		printf(
			'<p><img src="%s" alt="" class="wapuu"></p>',
			esc_html( plugin_dir_url( __FILE__ ) . 'images/' . $image )
		);

		printf(
			'%s',
			$args['after_widget'] // phpcs:ignore.
		);

	}

	/**
	 * Prepare form
	 *
	 * @param array $instance Current settings.
	 * @return void
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
 */
function smntcs_register_wapuu_widget() {
	register_widget( 'SMNTCS_Wapuu_Widget' );
}
add_action( 'widgets_init', 'smntcs_register_wapuu_widget' );

/**
 * Get random image URL
 *
 * @return string
 */
function smntcs_get_random_image_url() {
	$image = array(
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
		'gollum-wapuu-230x244.png',
		'gravity-forms-astronaut-wapuu-jupiter-icon@3x-230x245.png',
		'gravity-forms-astronaut-wapuu-mars-w-icon-230x245.png',
		'gravity-forms-astronaut-wapuu-moon-w-icon-230x245.png',
		'gravity-forms-astronaut-wapuu-saturn-w-icon-230x186.png',
		'gravity-forms-franklin-san-jose-wapuu-230x245.png',
		'gutenpuu@3x-230x225.png',
		'haobhau-in-jungle-230x294.png',
		'heart_wapuu-230x230.png',
		'heian-wapuu-230x253.png',
		'hex-wapuu-1810917-230x230.png',
		'hip-hop-wapuu-230x291.png',
		'hot_air_balloon_wapuu-230x416.png',
		'indie-wapuu-with-text-598x660-230x254.png',
		'inpsyde-wapuu-230x253.png',
		'jedi_wapuu-230x341.png',
		'jeepney-wapuu-230x230.png',
		'jpop_wapuu-230x254.png',
		'kabuki_wapuu_seal-230x230.png',
		'kani-wapuu.png',
		'keep-austin-weird-wapuu-230x214.png',
		'krimpet-wapuu-230x230.png',
		'kurashiki-wapuu-230x254.png',
		'london2016-wapuu-230x253.png',
		'lumberjack_wapuu-230x291.png',
		'lyon-wapuu-lugdunum-230x253.png',
		'maido-wapuu@2x-230x249.png',
		'maiko-wapuu-230x266.png',
		'maikochan-and-wapuu-230x230.png',
		'main-wabster-230x279.png',
		'manawapuu-230x230.png',
		'manchester-wapuu.png',
		'mango-wapuu-230x361.png',
		'marinwapuu-230x242.png',
		'mascotte_final-230x225.png',
		'masuzushi-wapuu-230x253.png',
		'matsuri-wapuu-230x253.png',
		'mecha_wapuu_color-230x200.png',
		'mercenary-wapuu-e1507954765785-230x253.png',
		'mineiro-wapuu-230x230.png',
		'mineiro-wapuu.png',
		'mom-and-cubby-wapuus@3x-230x246.png',
		'monk_wapuu-230x255.png',
		'mr-nuremberg-wapuu.png',
		'mrs-nuremberg-wapuu-230x238.png',
		'mugen-wapuu@2x-230x229.png',
		'mummypuu_2017WCPhilly_300x300-230x230.png',
		'napuu-230x215.png',
		'nashville-wapuu-2017-230x181.png',
		'nepuu-230x288.png',
		'ninja_wapuu-230x286.png',
		'nom-nom-wapuu-230x232.png',
		'octapuu-230x239.png',
		'okita-wapuu-230x253.png',
		'okita-wapuu.png',
		'onsen-wapuu-230x253.png',
		'original_wapuu-230x254.png',
		'ottawa-wapuu-230x310.png',
		'piratepuu_2017WCPhilly-230x230.png',
		'pretzel-wapuu-230x230.png',
		'r2-the-rtcamp-wapuu-230x253.png',
		'r2wapuu-230x253.png',
		'rabelo-o-wapuu-230x232.png',
		'raleigh-wapuu-230x230.png',
		'roboto-wapuu-wc-singapore-2017-230x298.png',
		'rochester-wapuu-230x230.png',
		'rocky-wapuu-230x230.png',
		'rosie-the-wapuu-e1491020781914-230x230.png',
		'rubiks-wapuu-230x254.png',
		'sailor-wapuu-230x271.png',
		'salakot-wapuu-230x213.png',
		'santa_wapuu-230x230.png',
		'sauna-wapuu-wordcamp-finland-2016-230x217.png',
		'save-the-day-blue-230x230.png',
		'savvii-wapuu-230x222.png',
		'scope-creep-230x256.png',
		'scott-wapuu-230x253.png',
		'sele_wapuu2-230x235.png',
		'shachihoko-wapuu-230x253.png',
		'sheepuu-230x230.png',
		'shikari-wapuu-230x278.png',
		'shikasenbei-wapuu-230x253.png',
		'sitelock-wapuu-wcus18@4x-230x278.png',
		'space-cadet-wapuu@3x-230x254.png',
		'space_wapuu-230x254.png',
		'speaker-10min-wapuu-230x248.png',
		'speaker-5min-wapuu-230x246.png',
		'speaker-stop-wapuu-230x220.png',
		'squirrel-wapuu-230x258.png',
		'stateside_wappu-e1505339371784-230x222.png',
		'sunshinecoast-wapuu-230x171.png',
		'sunshinecoast-wapuu.png',
		'sweden-wapuu-230x253.png',
		'swiss-wapuu-1-230x253.png',
		'sydney-wapuu-230x230.png',
		'taekwon-blue-wapuu.png',
		'taekwon-red-wapuu-230x253.png',
		'takoyaki_wapuu-230x254.png',
		'tampa-gasparilla-wapuu-230x253.png',
		'tangerine-230x191.png',
		'the-guruu-230x199.png',
		'the-troll-230x246.png',
		'tonkotsu-wapuu-230x251.png',
		'tonkotsu-wapuu.png',
		'try-me-230x243.gif',
		'vampuu-liberty_2017WCPhilly-230x203.png',
		'w3-230x262.png',
		'wambhau-230x276.png',
		'wapanduu_2-230x254.png',
		'wapevil-wapuu-230x253.png',
		'wapmas-wapuu-230x253.png',
		'wappu-grad-230x317.png',
		'wappu-logo-id-01-230x293 2.png',
		'wappu-punt-230x241.png',
		'wapsara-230x240.png',
		'wapu-1-230x160.png',
		'wapu-bagel-230x254.png',
		'wapu-sloth-230x268.png',
		'wapuda_shingenn-230x236.png',
		'wapumura-kenshin-230x253.png',
		'wapuu-2018-opt-230x230.png',
		'wapuu-Robert-230x256.png',
		'wapuu-alaaf-230x230.png',
		'wapuu-arno-and-ezio-230x227.png',
		'wapuu-batchoy-230x265.png',
		'wapuu-blab-01-230x288.png',
		'wapuu-boldie@3x-230x186.png',
		'wapuu-brainhurts-230x182.png',
		'wapuu-camera-230x209.png',
		'wapuu-cangaceiro-230x230.png',
		'wapuu-cheesehead-230x253.png',
		'wapuu-cheesehead.png',
		'wapuu-collector-pin-for-accessibility-230x231.png',
		'wapuu-collector-pin-for-community-230x231.png',
		'wapuu-collector-pin-for-content-230x230.png',
		'wapuu-collector-pin-for-design-ui-230x230.png',
		'wapuu-collector-pin-for-development-230x231.png',
		'wapuu-collector-pin-for-support-230x230.png',
		'wapuu-collector-pin-for-training-230x231.png',
		'wapuu-collector-pin-for-translation-230x230.png',
		'wapuu-cosplay-230x213.png',
		'wapuu-de-la-wordcamp-santander-230x218.png',
		'wapuu-der-ber-230x259.png',
		'wapuu-dev-300x265.png',
		'wapuu-efendi-230x291.png',
		'wapuu-france-230x279.png',
		'wapuu-guitar-230x242.png',
		'wapuu-hampton-roads-230x239.png',
		'wapuu-hanuman-transparent@2x-230x346.png',
		'wapuu-heropress-230x236.png',
		'wapuu-hipster-230x306.png',
		'wapuu-jags.png',
		'wapuu-ji-chaudhary-230x253.png',
		'wapuu-logo-toque-230x361.png',
		'wapuu-macedonia-e1539815678794-230x239.png',
		'wapuu-magic-230x338.png',
		'wapuu-med-230x302.png',
		'wapuu-micro-230x221.png',
		'wapuu-minion-230x248.png',
		'wapuu-moto-230x247.png',
		'wapuu-mountie.png',
		'wapuu-newtlab-230x240.png',
		'wapuu-nijmegen-by-faktor22-230x408.png',
		'wapuu-noypi-230x253.png',
		'wapuu-nyc-230x385.png',
		'wapuu-orange-230x264.png',
		'wapuu-ottawa-mountie-230x361.png',
		'wapuu-pixar-230x150.png',
		'wapuu-pizza-230x222.png',
		'wapuu-poststatus-230x307.png',
		'wapuu-rome-230x230.png',
		'wapuu-santa-230x259.png',
		'wapuu-santa-230x288.png',
		'wapuu-skunk-230x177.png',
		'wapuu-sleepy-wordcamp-230x127.png',
		'wapuu-snitch-230x145.png',
		'wapuu-spy.png',
		'wapuu-struggle-230x182.png',
		'wapuu-tiger-230x254.png',
		'wapuu-torque-230x265.png',
		'wapuu-travel-230x255.png',
		'wapuu-tron-230x271.png',
		'wapuu-turku-lippu-2-230x282.png',
		'wapuu-twins-230x221.png',
		'wapuu-unipiper-230x485.png',
		'wapuu-unipiper.png',
		'wapuu-wptavern-230x275.png',
		'wapuu2-with-lines-230x200.png',
		'wapuu3-with-lines-230x273.png',
		'wapuu_07-26-2-230x217.png',
		'wapuu_cologne_baerbel_final-230x208.png',
		'wapuu_cologne_hannes_final-230x278.png',
		'wapuu_mcfly-230x170.png',
		'wapuu_of_the_north.png',
		'wapuu_on_fire-230x230.png',
		'wapuu_translation-230x219.png',
		'wapuu_translation2-230x219.png',
		'wapuu_translation3-230x219.png',
		'wapuu_translation4-230x219.png',
		'wapuu_world-230x210.png',
		'wapuubee-230x222.png',
		'wapuugu-230x288.png',
		'wapuujlo-230x256.png',
		'wapuunder-230x284.png',
		'wapuunicorn-230x325.png',
		'wapuushkin-wapuu-230x230.png',
		'wapuutah-wapuu-230x233.png',
		'war_wapuu-230x298.png',
		'wcb19_wapuu_@1x-230x261.png',
		'wcdfw2017-wapuu-flag-only-230x269.png',
		'wcdublin-wapuu-230x294.png',
		'wceu-2017-wapuu-female-230x271.png',
		'wceu-2017-wapuu-female.png',
		'wceu-2017-wapuu-male-230x271.png',
		'wceu2016-leopold-mozart-wapuu-230x253.png',
		'wceu2016-volto-mask-wapuu-230x253.png',
		'wck-wapuu-230x278.png',
		'wclvpa-wapuu-2016.png',
		'wct2012.png',
		'wct2013-kabuki-wapuu-230x233.png',
		'wctokyo-wapuu-230x253.png',
		'wctokyo2017-wapuu-230x155.png',
		'wharf-230x279.png',
		'white-hat-wapuu-230x192.png',
		'winter_wapuu-230x311.png',
		'wonder-wapuu-230x216.png',
		'wordcamp-tokyo-wapuu-2012-230x233.png',
		'wordpress_chs_wapuu-230x263.png',
		'wordpress_wapuu_1080x1265-230x269.png',
		'xiru-wapuu-230x230.png',
	);

	return $image[ wp_rand( 0, count( $image ) - 1 ) ];
}
