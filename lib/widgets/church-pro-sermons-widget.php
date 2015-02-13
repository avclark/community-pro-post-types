<?php
/**
 * Church Pro - Sermons Widget
 *
 * @package Genesis
 * @author  StudioPress
 * @author  Jo Waltham
 * @author  Pete Favelle
 * @author  Robin Cornett
 * @author  Calvin Koepke
 * @license GPL-2.0+
 *
 */

 /**
* Please note that this widget is derived from the Custom Post Types Widget, developed by Jo and others, based off
* of the Genesis Featured Posts Widget. I've simply stripped it to show only a certain post type with specific features.
*/


class Church_Pro_Sermon_Widget extends WP_Widget {

	/**
	 * Holds widget settings defaults, populated in constructor.
	 *
	 * @var array
	 */
	protected $defaults;

	/**
	 * Constructor. Set the default widget options and create widget.
	 *
	 * @since 0.1.8
	 */
	function __construct() {

		$this->defaults = array(
			'title'                   => '',
			'post_type'               => 'church-pro-sermons',
			//'tax_term'                => '',
			'posts_num'               => 1,
			'posts_offset'            => 0,
			'orderby'                 => '',
			'order'                   => '',
			'exclude_displayed'       => 0,
			'show_image'              => 0,
			'show_gravatar'           => 0,
			'gravatar_alignment'      => '',
			'gravatar_size'           => '',
			'show_title'              => 0,
			'show_byline'             => 0,
			'post_info'               => '[post_date] ' . __( 'By', 'church_pro' ) . ' [post_author_posts_link] [post_comments]',
			'show_content'            => 'excerpt',
			'content_limit'           => '',
			'more_text'               => __( '[Read More...]', 'church_pro' )
		);

		$widget_ops = array(
			'classname'   => 'sermon-widget',
			'description' => __( 'Displays Church Pro Sermons', 'church_pro' ),
		);

		$control_ops = array(
			'id_base' => 'church-pro-sermons-widget',
			'width'   => 288,
			'height'  => 350,
		);

		parent::__construct( 'church-pro-sermons-widget', __( 'CP - Sermons Widget', 'church_pro' ), $widget_ops, $control_ops );

		// Register our Ajax handler
		add_action( 'wp_ajax_tax_term_action', array( $this, 'tax_term_action_callback' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ) );
	}

	/**
	 * Echo the widget content.
	 *
	 * @since 0.1.8
	 *
	 * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array $instance The settings for the particular instance of the widget
	 */
	function widget( $args, $instance ) {

		global $wp_query, $_genesis_displayed_ids;

		extract( $args );

		//* Merge with defaults
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		echo $before_widget;

		//* Set up the author bio
		if ( ! empty( $instance['title'] ) )
			echo $before_title . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $after_title;

		$query_args = array(
			'post_type' => $instance['post_type'],
			'showposts' => $instance['posts_num'],
			'offset'    => $instance['posts_offset'],
			'orderby'   => $instance['orderby'],
			'order'     => $instance['order'],
		);

		//* Exclude displayed IDs from this loop?
		if ( $instance['exclude_displayed'] )
			$query_args['post__not_in'] = (array) $_genesis_displayed_ids;

		$wp_query = new WP_Query( $query_args );

		if ( have_posts() ) : while ( have_posts() ) : the_post();

			global $post;

			//* Custom Meta Data
			$sermon_speaker = get_post_meta( $post->ID, '_church_pro_speaker_field', true );
			$sermon_date = date("d M", strtotime( get_post_meta( $post->ID, '_church_pro_sermon_date_field', true ) ) );

			$_genesis_displayed_ids[] = get_the_ID();

			genesis_markup( array(
				'html5'   => '<article %s>',
				'xhtml'   => sprintf( '<div class="%s">', implode( ' ', get_post_class() ) ),
				'context' => 'entry',
			) );

			echo '<div class="sermon-info">';

			if ( ! empty( $sermon_date ) )
				echo '<div class="sermon-date">' . $sermon_date . '</div>';

			if ( $instance['show_title'] )
				echo genesis_html5() ? '<header class="entry-header">' : '';

				if ( ! empty( $instance['show_title'] ) ) {

					if ( genesis_html5() )
						printf( '<h2 class="entry-title"><a href="%s" title="%s">%s</a></h4>', get_permalink(), the_title_attribute( 'echo=0' ), get_the_title() );
					else
						printf( '<h2 class="entry-title"><a href="%s" title="%s">%s</a></h4>', get_permalink(), the_title_attribute( 'echo=0' ), get_the_title() );

				}

			if ( $instance['show_title'] )
				echo genesis_html5() ? '</header>' : '';

			if ( ! empty( $sermon_speaker ) )
				//* Make date look pretty
				echo '<div class="sermon-speaker"><span class="dashicons dashicons-admin-users"></span> ' . $sermon_speaker . '</div>';

			echo '</div>';

			genesis_markup( array(
				'html5' => '</article>',
				'xhtml' => '</div>',
			) );

		endwhile; endif;

		//* Restore original query
		wp_reset_query();

		echo $after_widget;

	}

	/**
	 * Update a particular instance.
	 *
	 * This function should check that $new_instance is set correctly.
	 * The newly calculated value of $instance should be returned.
	 * If "false" is returned, the instance won't be saved/updated.
	 *
	 * @since 0.1.8
	 *
	 * @param array $new_instance New settings for this instance as input by the user via form()
	 * @param array $old_instance Old settings for this instance
	 * @return array Settings to save or bool false to cancel saving
	 */
	function update( $new_instance, $old_instance ) {

		$new_instance['title']     = strip_tags( $new_instance['title'] );
		$new_instance['more_text'] = strip_tags( $new_instance['more_text'] );
		$new_instance['post_info'] = wp_kses_post( $new_instance['post_info'] );
		return $new_instance;

	}

	/**
	 * Echo the settings update form.
	 *
	 * @since 0.1.8
	 *
	 * @param array $instance Current settings
	 */
	function form( $instance ) {

		//* Merge with defaults
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'church_pro' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>

		<div class="genesis-widget-column-box genesis-widget-column-box-top">

			<p>
				<input id="<?php echo $this->get_field_id( 'show_title' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'show_title' ); ?>" value="1" <?php checked( $instance['show_title'] ); ?>/>
				<label for="<?php echo $this->get_field_id( 'show_title' ); ?>"><?php _e( 'Show Sermon Title', 'church_pro' ); ?></label>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'posts_num' ); ?>"><?php _e( 'Number of Sermons to Show', 'church_pro' ); ?>:</label>
				<input type="text" id="<?php echo $this->get_field_id( 'posts_num' ); ?>" name="<?php echo $this->get_field_name( 'posts_num' ); ?>" value="<?php echo esc_attr( $instance['posts_num'] ); ?>" size="2" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'posts_offset' ); ?>"><?php _e( 'Number of Sermons to Offset', 'church_pro' ); ?>:</label>
				<input type="text" id="<?php echo $this->get_field_id( 'posts_offset' ); ?>" name="<?php echo $this->get_field_name( 'posts_offset' ); ?>" value="<?php echo esc_attr( $instance['posts_offset'] ); ?>" size="2" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Order By', 'church_pro' ); ?>:</label>
				<select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
					<option value="date" <?php selected( 'date', $instance['orderby'] ); ?>><?php _e( 'Date', 'church_pro' ); ?></option>
					<option value="title" <?php selected( 'title', $instance['orderby'] ); ?>><?php _e( 'Title', 'church_pro' ); ?></option>
					<option value="ID" <?php selected( 'ID', $instance['orderby'] ); ?>><?php _e( 'ID', 'church_pro' ); ?></option>
					<option value="rand" <?php selected( 'rand', $instance['orderby'] ); ?>><?php _e( 'Random', 'church_pro' ); ?></option>
				</select>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Sort Order', 'church_pro' ); ?>:</label>
				<select id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>">
					<option value="DESC" <?php selected( 'DESC', $instance['order'] ); ?>><?php _e( 'Descending (3, 2, 1)', 'church_pro' ); ?></option>
					<option value="ASC" <?php selected( 'ASC', $instance['order'] ); ?>><?php _e( 'Ascending (1, 2, 3)', 'church_pro' ); ?></option>
				</select>
			</p>

			<p>
				<input id="<?php echo $this->get_field_id( 'exclude_displayed' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'exclude_displayed' ); ?>" value="1" <?php checked( $instance['exclude_displayed'] ); ?>/>
				<label for="<?php echo $this->get_field_id( 'exclude_displayed' ); ?>"><?php _e( 'Exclude Previously Displayed Sermons?', 'church_pro' ); ?></label>
			</p>

		</div>
		<?php

	}

	/**
	 * Comparison function to allow custom taxonomy terms to be displayed
	 * alphabetically. Required because the display is a compound of term
	 * *and* taxonomy.
	 */
	function tax_term_compare( $a, $b ) {
		if ( $a->taxonomy == $b->taxonomy ) {
			return ($a->name < $b->name) ? -1 : 1;
		}
		return ($a->taxonomy <  $b->taxonomy)? -1 : 1;
	}

	/**
	 * Enqueues the small bit of Javascript which will handle the Ajax
	 * callback to correctly populate the custom term dropdown.
	 */
	function admin_enqueue() {
		$screen = get_current_screen()->id;
		if ( $screen === 'widgets' || $screen === 'customize' ) {
			wp_enqueue_script( 'tax-term-ajax-script', plugins_url( '/ajax_handler.js', __FILE__ ), array('jquery') );
			wp_localize_script( 'tax-term-ajax-script', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		}
	}

	/**
	 * Handles the callback to populate the custom term dropdown. The
	 * selected post type is provided in $_POST['post_type'], and the
	 * calling script expects a JSON array of term objects.
	 */
	function tax_term_action_callback() {

		// Fetch a list of available taxonomies for the current post type
		if ( 'any' == $_POST['post_type'] ) {
			$taxonomies = get_taxonomies();
		} else {
			$taxonomies = get_object_taxonomies( $_POST['post_type'] );
		}

		// And from there, a list of available terms in that tax
		$tax_args = array(
			'hide_empty'	=> 0,
		);
		$tax_term_list = get_terms( $taxonomies, $tax_args );

		// Build an appropriate JSON response containing this info
		foreach ( $tax_term_list as $tax_term_item ) {
			$taxes [$tax_term_item->taxonomy . '/' . $tax_term_item->slug] =
				$tax_term_item->taxonomy . '/' . $tax_term_item->name;
		}
		$taxes['any'] = 'any';

		// And emit it
		echo json_encode( $taxes );
		die();
	}
}
