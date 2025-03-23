<?php
/**
 * SMNTCS Wapuu Widget Class
 *
 * @package SMNTCS_Wapuu_Widget
 */

defined( 'ABSPATH' ) || exit;

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
		$image = SMNTCS_Wapuu_Manager::get_random_image_url();

		echo wp_kses_post( $args['before_widget'] );
		echo wp_kses_post( $args['before_title'] );
		echo esc_attr( $title );
		echo wp_kses_post( $args['after_title'] );

		printf(
			'<p><img src="%s" alt="" class="wapuu"></p>',
			esc_url( plugin_dir_url( dirname( __DIR__ ) ) . 'images/' . $image )
		);

		echo wp_kses_post( $args['after_widget'] );
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
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">Title:</label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" />
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
