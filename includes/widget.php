<?php
/**
 * Create a sidebar widget
 *
 * @package Metaphor Galleries
 */




add_action( 'widgets_init', 'mtphr_gallery_categories_widget_init' );
/**
 * Register the widget
 *
 * @since 1.0.0
 */
function mtphr_gallery_categories_widget_init() {
	register_widget( 'mtphr_gallery_categories_widget' );
}




/**
 * Create a class for the widget
 *
 * @since 1.0.0
 */
class mtphr_gallery_categories_widget extends WP_Widget {




	/**
	 * Widget setup
	 *
	 * @since 1.0.0
	 */
	function mtphr_gallery_categories_widget() {

		// Widget settings
		$widget_ops = array(
			'classname' => 'mtphr-gallery-categories',
			'description' => __('Displays a list of Metaphor Gallery categories.', 'mtphr-galleries')
		);

		// Widget control settings
		$control_ops = array(
			'id_base' => 'mtphr-gallery-categories'
		);

		// Create the widget
		$this->WP_Widget( 'mtphr-gallery-categories', __('Metaphor Gallery Categories', 'mtphr-galleries'), $widget_ops, $control_ops );
	}




	/**
	 * Display the widget
	 *
	 * @since 1.0.0
	 */
	function widget( $args, $instance ) {

		extract( $args );

		// User-selected settings
		$title = $instance['title'];
		$title = apply_filters( 'widget_title', $title );

		$count = isset( $instance['count'] );
		$hierarchical = isset( $instance['hierarchical'] );
		$all = $instance['all'];

		// Before widget (defined by themes)
		echo $before_widget;

		// Title of widget (before and after defined by themes)
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		// Get the current category
		$current = isset( $_GET['category'] ) ? $_GET['category'] : '';

		// Get the terms
		$args = array(
			'hierarchical' => $hierarchical
		);
		$terms = get_terms( array('mtphr_gallery_category'), $args );
		$total = count($terms);
		 if ( $total > 0 ) {
	     echo '<ul>';

	     $active = ( $current == '' ) ? ' class="mtphr-galleries-current-category"' : '';
	     $post_count = wp_count_posts('mtphr_gallery');
	     $term_count = ( $count ) ? ' <span class="mtphr-galleries-count">('.$post_count->publish.')</span>' : '';
	     $obj = get_post_type_object( 'mtphr_gallery' );
	     $label = $obj->labels->name;
	     echo '<li'.$active.'><a href="'.add_query_arg( 'category', false ).'">'.sprintf(__('All %s', 'mtphr-galleries'), $label).$term_count.'</a></li>';

	     foreach ( $terms as $term ) {

		     $active = ( $current == $term->slug ) ? ' class="mtphr-galleries-current-category"' : '';
		     $term_count = ( $count ) ? ' <span class="mtphr-galleries-count">('.$term->count.')</span>' : '';
	       echo '<li'.$active.'><a href="'.add_query_arg( 'category', $term->slug ).'">'.$term->name.$term_count.'</a></li>';
	     }
	     echo '</ul>';
		 }

		// After widget (defined by themes)
		echo $after_widget;
	}




	/**
	 * Update the widget
	 *
	 * @since 1.0.0
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		// Strip tags (if needed) and update the widget settings
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['count'] = $new_instance['count'];
		$instance['hierarchical'] = $new_instance['hierarchical'];
		$instance['all'] = $new_instance['all'];

		return $instance;
	}




	/**
	 * Widget settings
	 *
	 * @since 1.0.0
	 */
	function form( $instance ) {

		// Set up some default widget settings
		$defaults = array(
			'title' => '',
			'count' => '',
			'hierarchical' => '',
			'all' => ''
		);

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

	  <!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'mtphr-galleries' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:97%;" />
		</p>

		<p>
		<!-- Count: Checkbox -->
		<input class="checkbox" type="checkbox" <?php checked( $instance['count'], 'on' ); ?> id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Show post counts', 'mtphr-galleries' ); ?></label><br/>

		<!-- Hierarchical: Checkbox -->
		<input class="checkbox" type="checkbox" <?php checked( $instance['hierarchical'], 'on' ); ?> id="<?php echo $this->get_field_id( 'hierarchical' ); ?>" name="<?php echo $this->get_field_name( 'hierarchical' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'hierarchical' ); ?>"><?php _e( 'Show hierarchy', 'mtphr-galleries' ); ?></label>

		</p>

	  <!-- All Page: Select -->
		<p>
			<label for="<?php echo $this->get_field_id( 'all' ); ?>"><?php _e( 'All Galleries Page:', 'mtphr-galleries' ); ?></label><br/>
			<select id="<?php echo $this->get_field_id( 'all' ); ?>" name="<?php echo $this->get_field_name( 'all' ); ?>">
			<?php
			$pages = get_pages( 'numberposts=0&orderby=name&order=ASC' );
			foreach( $pages as $page ) {
				if( $instance['all'] == $page->ID ) {
					echo '<option value="'.$page->ID.'" selected="selected">'.$page->post_title.'</option>';
				} else {
					echo '<option value="'.$page->ID.'">'.$page->post_title.'</option>';
				}
			}
			?>
			</select>
		</p>

		<?php
	}
}

