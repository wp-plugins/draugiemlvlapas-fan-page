<?php
/**
 * Plugin Name: Draugiem.lv/lapas Fan page
 * Plugin URI: http://mediabox.lv/blog/wordpress/spraudni/draugiem-lv-lapas-fanu-lapa/
 * Description: Parāda draugiem.lv/lapas lietotājus, to skaitu, logo un iespēju kļūt par lapas fanu
 * Version: 0.1
 * Author: Rolands Umbrovskis
 * Author URI: http://umbrovskis.com
 * License: GPL
 */

/**
 * Add function to widgets_init that will load meblog Draugiem Lapas fanu widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'meblogfrypepage_load_widgets' );

/**
 * Register our widget.
 * 'MeblogFrypePage_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function meblogfrypepage_load_widgets() {
	register_widget( 'MeblogFrypePage_Widget' );
}

/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.
 *
 * @since 0.1
 */
$currentLocale = get_locale();
			if(!empty($currentLocale)) {
				$moFile = dirname(__FILE__) . "/lang/frypepage_widget-" . $currentLocale . ".mo";
				if(@file_exists($moFile) && is_readable($moFile)) load_textdomain('frypepage_widget', $moFile);
			}

class MeblogFrypePage_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function MeblogFrypePage_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'meblogfrypepage', 'description' => __('Shows draugiem.lv/lapas users', 'frypepage_widget') );
		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'meblogfrypepage-widget' );
		/* Create the widget. */
		$this->WP_Widget( 'meblogfrypepage-widget', __('Draugiem Lapas Widget', 'frypepage_widget'), $widget_ops, $control_ops );
	}

	/**
	 * Display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$name = $instance['name'];
		$wwidth = $instance['wwidth'];
		$show_usersfrp = $instance['show_usersfrp'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ($title)	echo $before_title . $title . $after_title;
			/* if ($show_usersfrp) return $show_usersfrp;
			if ($name)  return $name;
			if ( $wwidth ) return $wwidth;
			*/
			echo"\n<!-- draugiem.lv/lapas fani via http://umbrovskis.com | MediaBox.lv -->\n".'<div id="pageswidget"></div><script type="text/javascript" src="http://www.draugiem.lv/lapas/widgets/fans.js"></script>';
			echo'<script type="text/javascript" src="http://www.draugiem.lv/'.$name.'/js/fans/?container=pageswidget&count='.$show_usersfrp.'&w='.$wwidth.'"></script>'."\n<!-- draugiem.lv/lapas fani beidzas -->\n";

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['name'] = strip_tags( $new_instance['name'] );

		/* No need to strip tags for sex and show_usersfrp. */
		$instance['wwidth'] = $new_instance['wwidth'];
		$instance['show_usersfrp'] = $new_instance['show_usersfrp'];

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Draugiem.lv/lapas', 'frypepage_widget'), 'name' => __('umbrovskiscom', 'frypepage_widget'), 'wwidth' => '240', 'show_usersfrp' => '0' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'frypepage_widget'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- Your Name: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'name' ); ?>"><?php _e('Page URL:', 'frypepage_widget'); ?></label>
			<input id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'name' ); ?>" value="<?php echo $instance['name']; ?>" style="width:100%;" />
		</p>

		<!-- Sex: Select Box -->
		<p>
			<label for="<?php echo $this->get_field_id( 'wwidth' ); ?>"><?php _e('Width:', 'frypepage_widget'); ?></label><br />
            <span class="small"><?php _e('recomended:', 'frypepage_widget'); ?>: 160, 240, 320, 400, 480, 560, 640, 720, 800, 880, 960</<br />
			<input id="<?php echo $this->get_field_id( 'wwidth' ); ?>" name="<?php echo $this->get_field_name( 'wwidth' ); ?>" value="<?php echo $instance['wwidth']; ?>" style="width:100%;" />

		<!-- Show Users? Checkbox -->
		<p><label for="<?php echo $this->get_field_id( 'show_usersfrp' ); ?>"><?php _e('How much users to show?', 'frypepage_widget'); ?></label>
        <span class="small"><?php _e('0 for none', 'frypepage_widget'); ?></span><br />
        	<input id="<?php echo $this->get_field_id( 'show_usersfrp' ); ?>" name="<?php echo $this->get_field_name( 'show_usersfrp' ); ?>" value="<?php echo $instance['show_usersfrp']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}

?>