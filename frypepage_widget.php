<?php
/**
 * Plugin Name: Draugiem.lv/lapas Fan page
 * Plugin URI: http://mediabox.lv/blog/wordpress/spraudni/draugiem-lv-lapas-fanu-lapa/
 * Description: Parāda draugiem.lv/lapas lietotājus, to skaitu, logo un iespēju kļūt par lapas fanu, Shows draugiem.lv/lapas users, fan count, logo and possibility to became a fan <a href=""></a>
 * Version: 0.1.5.1
 * Author: Rolands Umbrovskis
 * Author URI: http://umbrovskis.com
 * License: GPL
 */

/**
 * Add function to widgets_init that will load meblog Draugiem Lapas fanu widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'meblogfrypepage_load_widgets' );

define('VERSION','0.1.5.1');
define('FRYPEFANPAGEF','draugiemlvlapas-fan-page');

function meblogfrypepage_set_plugin_meta($links, $file) {
	$plugin = plugin_basename(__FILE__);
	// create link
	if ($file == $plugin) {
		return array_merge( $links, array( 
			'<a href="http://wordpress.org/tags/draugiemlvlapas-fan-page?forum_id=10#postform">' . __('Support Forum') . '</a>',
			'<a href="http://mediabox.lv/code/Draugiem.lv_Lapas_Fan_page">' . __('Wiki page') . '</a>',
			'<a href="http://umbrovskis.com/donate/">' . __('Donate') . '</a>',
			'<a href="http://umbrovskis.com/">Umbrovskis.com</a>' 
		));
	}
	return $links;
}

add_filter( 'plugin_row_meta', 'meblogfrypepage_set_plugin_meta', 10, 2 );

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
		$control_ops = array( 'width' => 300, 'height' => 200, 'id_base' => 'meblogfrypepage-widget' );
		/* Create the widget. */
		$this->WP_Widget( 'meblogfrypepage-widget', __('Draugiem Lapas Widget', 'frypepage_widget'), $widget_ops, $control_ops );
		//Additional links on the plugin page
		
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
		$show_cssfrp = $instance['show_cssfrp'];
		$show_pageaboutlenght = $instance['show_aboutpagelenght'];
		
		
		if(!is_numeric($show_pageaboutlenght)||!$show_pageaboutlenght){$show_pageaboutlenght='200';}
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ($title)	echo $before_title . $title . $after_title;
			echo "\n\n<!-- draugiem.lv/lapas fani ".VERSION." via http://umbrovskis.com | MediaBox.lv -->\n".'<div id="pageswidget"></div>'."\n";
		 // * @since 0.2

			?><script type="text/javascript">
D = {
	w:function(par){
		// load external css
		var fileref=document.createElement("link")
		fileref.setAttribute("rel", "stylesheet")
		fileref.setAttribute("type", "text/css")
		
		<?php if($show_cssfrp!=WP_PLUGIN_URL.'/'.FRYPEFANPAGEF.'/js/widget.css' && $show_cssfrp!=''):?>
		fileref.setAttribute("href", "<?php echo $show_cssfrp;?>");
		<?php elseif(!$show_cssfrp): ?>
		fileref.setAttribute("href", "<?php echo WP_PLUGIN_URL.'/'.FRYPEFANPAGEF.'/js';?>/widget.css?v=<?php echo VERSION;?>");
		<?php else: ?>
		fileref.setAttribute("href", "<?php echo WP_PLUGIN_URL.'/'.FRYPEFANPAGEF.'/js';?>/widget.css?v=<?php echo VERSION;?>");
		<?php endif; ?>
		
		document.getElementsByTagName("head")[0].appendChild(fileref);
		var node = document.getElementById(par['container']);
		var content = document.createElement('div');
		html = '<div style="width:<?php echo $wwidth;?>px;"><div class="draugiemwidget_shadbox"><div class="shtext"><img src="'+par['page']['image'] +'" class="pageimage"/><span class="draugiemwidget_pagedsc">'+par['page']['about'].substring(0,<?php echo $show_pageaboutlenght; ?>)+'</span><p class="clear"></p><div class="fixedcount"><p class="fancounts"><a class="title" href="http://mediabox.lv/a/fryped.php?gotopage='+par['page']['url']+'"><b>'+par['page']['totalfans']+'</b> <?php _e('fans', 'frypepage_widget'); ?></a></p><p class="joinbutton"><a href="http://mediabox.lv/a/fryped.php?gotopage=' + par['page']['url']+ '"></a></p></div><p class="clear"></p></div>';
		if (par['fans'].length){
			html += '<div class="fanlist">';
			for (i=0;i<par['fans'].length;i++){
				html += '<div class="fancontainer"><a class="pbg" href="http://mediabox.lv/a/fryped.php?gotou='+par['fans'][i]['url']+'"><div style="background-image: url('+par['fans'][i]['image']+')"></div></a><a class="name" href="http://mediabox.lv/a/fryped.php?gotou='+par['fans'][i]['url']+'">'+par['fans'][i]['name']+'</a></div><?php  //fancontainer ?>';
			}
			html += '<div class="dfoot"></div></div><?php  //fanlist ?>';
		}
		html += '</div>';
		content.innerHTML = html;
		node.appendChild(content);
	}
		
}
			</script>
            <?php echo "\n";
			echo'<script type="text/javascript" src="http://www.draugiem.lv/'.$name.'/js/fans/?container=pageswidget&count='.$show_usersfrp.'&w='.$wwidth.'"></script>'."\n<!-- draugiem.lv/lapas fani ".VERSION."  beidzas footer -->\n\n";

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
		$instance['show_cssfrp'] = $new_instance['show_cssfrp'];
		$instance['show_aboutpagelenght'] = $new_instance['show_aboutpagelenght'];
		

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Draugiem.lv/lapas', 'frypepage_widget'), 'name' => __('umbrovskiscom', 'frypepage_widget'), 'wwidth' => '240', 'show_usersfrp' => '0', 'show_cssfrp' =>WP_PLUGIN_URL.'/'.FRYPEFANPAGEF.'/js/widget.css', 'show_aboutpagelenght'=> '1000');
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
            <span class="small"><?php _e('recomended:', 'frypepage_widget'); ?> 160, 240, 320, 400, 480, 560, 640, 720, 800, 880, 960<br />
			<input id="<?php echo $this->get_field_id( 'wwidth' ); ?>" name="<?php echo $this->get_field_name( 'wwidth' ); ?>" value="<?php echo $instance['wwidth']; ?>" style="width:100%;" />

		<!-- Show Users? Input -->
		<p><label for="<?php echo $this->get_field_id( 'show_usersfrp' ); ?>"><?php _e('How many users to show?', 'frypepage_widget'); ?></label><br />
        <span class="small"><?php _e('0 for none', 'frypepage_widget'); ?></span><br />
        	<input id="<?php echo $this->get_field_id( 'show_usersfrp' ); ?>" name="<?php echo $this->get_field_name( 'show_usersfrp' ); ?>" value="<?php echo $instance['show_usersfrp']; ?>" style="width:100%;" />
		</p>
		<!-- Show CSS? Input -->
		<p><label for="<?php echo $this->get_field_id( 'show_cssfrp' ); ?>"><?php _e('StyleSheet (CSS) URL', 'frypepage_widget'); ?></label><br />
        <span class="small"><?php _e('Theme (CSS) URL', 'frypepage_widget'); ?>: <strong><?php bloginfo('stylesheet_url'); ?></strong></span><br />
        <span class="small"><strong><?php echo WP_PLUGIN_URL.'/'.FRYPEFANPAGEF.'/js/widget.css'; ?></strong></span><br />
        	<input id="<?php echo $this->get_field_id( 'show_cssfrp' ); ?>" name="<?php echo $this->get_field_name( 'show_cssfrp' ); ?>" value="<?php echo $instance['show_cssfrp']; ?>" style="width:100%;" />
		</p>
		<!-- Show CSS? Input -->
		<p><label for="<?php echo $this->get_field_id( 'show_aboutpagelenght' ); ?>"><?php _e('Lenght of page description', 'frypepage_widget'); ?></label><br />
        	<input id="<?php echo $this->get_field_id( 'show_aboutpagelenght' ); ?>" name="<?php echo $this->get_field_name( 'show_aboutpagelenght' ); ?>" value="<?php echo $instance['show_aboutpagelenght']; ?>" style="width:100%;" />
		</p>
        <!-- HELP link-->
        <p><a href="http://mediabox.lv/blog/wordpress/spraudni/draugiem-lv-lapas-fanu-lapa/" title="draugiem.lv/lapas fanu lapa" target="_blank"><?php _e('Help?', 'frypepage_widget'); ?></a> <?php _e('(in new window/tab)', 'frypepage_widget'); ?></p>

	<?php
	}
}
?>