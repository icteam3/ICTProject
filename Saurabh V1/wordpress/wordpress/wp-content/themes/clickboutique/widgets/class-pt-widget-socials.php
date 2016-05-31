<?php
/**
 * Plumtree Social Networks
 *
 * Configurable social networks icons widget with Awesome font.
 *
 * @author TransparentIdeas
 * @package Plum Tree
 * @subpackage Widgets
 * @since 0.01
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'widgets_init', create_function( '', 'register_widget( "pt_socials_widget" );' ) );

class pt_socials_widget extends WP_Widget {
	
	public function __construct() {
		parent::__construct(
	 		'pt_socials_widget', // Base ID
			__('PT Socials Icons', 'plumtree'), // Name
			array( 'description' => __( 'Plum Tree special widget. Add links to Your social networks', 'plumtree' ), ) 
		);
	}

	public function form( $instance ) {

		$defaults = array( 
			'title' 		=> 'Social Networks', 
			'twitter'		=> '',
			'facebook'		=> '',
			'gplus'			=> '',
			'youtube'		=> '',
			'flickr'		=> '',
			'linkedin'		=> '',
			'tumblr'		=> '',
			'pinterest'		=> '',
			'instagram'		=> '',
			'color_hover'   => false,
		);

		$instance = wp_parse_args( (array) $instance, $defaults ); 
	?>
		<p><?php _e( 'Fill in the links for the Social Media tabs you wish to activate, please include <strong>http://</strong> on all links except Twitter.', 'plumtree') ;?></p>

		<p>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("color_hover"); ?>" name="<?php echo $this->get_field_name("color_hover"); ?>"<?php checked( (bool) $instance["color_hover"] ); ?> />
            <label for="<?php echo $this->get_field_id("color_hover"); ?>"><?php _e( 'Check for colour hover effect', 'plumtree' ); ?></label>
        </p>
		
		<?php 
		$params = array( 
			'title' 		=> __( 'Title:', 'plumtree' ), 
			'twitter'		=> __( 'Twitter username:', 'plumtree' ),
			'facebook'		=> __( 'Facebook:', 'plumtree' ),
			'gplus'			=> __( 'Google+:', 'plumtree' ),
			'youtube'		=> __( 'YouTube:', 'plumtree' ),
			'flickr'		=> __( 'Flickr:', 'plumtree' ),
			'linkedin'		=> __( 'LinkedIn:', 'plumtree' ),
			'tumblr'		=> __( 'Tumblr:', 'plumtree' ),
			'pinterest'		=> __( 'Pinterest:', 'plumtree' ),
			'instagram'		=> __( 'Instagram:', 'plumtree' ),
		);

		foreach ($params as $key => $value) {
			$html = '<p>';
			$html .= '<label for="'.$this->get_field_id( $key ).'">'.$value.'</label>';
			$html .= '<input class="widefat" id="'.$this->get_field_id( $key ).'" name="'.$this->get_field_name( $key ).'" type="text" value="'.$instance[ $key ].'" />';
			$html .= '</p>';
			echo $html;
		} ; ?>

		<?php 
	}

	public function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['twitter'] = strip_tags( $new_instance['twitter'] );
		$instance['facebook'] = strip_tags( $new_instance['facebook'] );
		$instance['gplus'] = strip_tags( $new_instance['gplus'] );
		$instance['youtube'] = strip_tags( $new_instance['youtube'] );
		$instance['flickr'] = strip_tags( $new_instance['flickr'] );
		$instance['linkedin'] = strip_tags( $new_instance['linkedin'] );
		$instance['tumblr'] = strip_tags( $new_instance['tumblr'] );
		$instance['pinterest'] = strip_tags( $new_instance['pinterest'] );
		$instance['instagram'] = strip_tags( $new_instance['instagram'] );
		$instance['color_hover'] = $new_instance['color_hover'];

		return $instance;
	}

	public function widget( $args, $instance ) {

		global $wpdb;

		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );
		$twitter_user = (isset($instance['twitter']) ? $instance['twitter'] : '' );
		$facebook = (isset($instance['facebook']) ? $instance['facebook'] : '' );
		$gplus = (isset($instance['gplus']) ? $instance['gplus'] : '' );
		$youtube = (isset($instance['youtube']) ? $instance['youtube'] : '' );
		$flickr = (isset($instance['flickr']) ? $instance['flickr'] : '' );
		$linkedin = (isset($instance['linkedin']) ? $instance['linkedin'] : '' );
		$tumblr = (isset($instance['tumblr']) ? $instance['tumblr'] : '' );
		$pinterest = (isset($instance['pinterest']) ? $instance['pinterest'] : '' );
		$instagram = (isset($instance['instagram']) ? $instance['instagram'] : '' );
		$color_hover = (isset($instance['color_hover']) ? $instance['color_hover'] : false );

		$twitter = 'http://twitter.com/' . $twitter_user;
		$color_class = '';
		if ( $color_hover ) {
			$color_class = 'color-hover';
		}

		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
		?>

			<ul class="pt-widget-socials <?php echo $color_class;?>">
				<?php if($twitter_user != '' ) : ?>
					<li class="option-title">
						<a href="<?php echo $twitter; ?>" title="<?php _e('Connect us on Twitter', 'plumtree');?>" target="_blank">
							<i class="fa fa-twitter"></i>
						</a>
					</li>
				<?php endif; ?>
				<?php if($facebook != '' ) : ?>
					<li class="option-title">
						<a href="<?php echo $facebook; ?>" title="<?php _e('Connect us on Facebook', 'plumtree');?>" target="_blank">
							<i class="fa fa-facebook"></i>
						</a>
					</li>
				<?php endif; ?>
				<?php if($gplus != '' ) : ?>
					<li class="option-title">
						<a href="<?php echo $gplus; ?>" title="<?php _e('Connect us on Google+', 'plumtree');?>" target="_blank">
							<i class="fa fa-google-plus"></i>
						</a>
					</li>
				<?php endif; ?>
				<?php if($youtube != '' ) : ?>
					<li class="option-title">
						<a href="<?php echo $youtube; ?>" title="<?php _e('Connect us on Youtube', 'plumtree');?>" target="_blank">
							<i class="fa fa-youtube"></i>
						</a>
					</li>
				<?php endif; ?>
				<?php if($flickr != '' ) : ?>
					<li class="option-title">
						<a href="<?php echo $flickr; ?>" title="<?php _e('Connect us on Flickr', 'plumtree');?>" target="_blank">
							<i class="fa fa-flickr"></i>
						</a>
					</li>
				<?php endif; ?>
				<?php if($linkedin != '' ) : ?>
					<li class="option-title">
						<a href="<?php echo $linkedin; ?>" title="<?php _e('Connect us on LinkedIn', 'plumtree');?>" target="_blank">
							<i class="fa fa-linkedin"></i>
						</a>
					</li>
				<?php endif; ?>
				<?php if($tumblr != '' ) : ?>
					<li class="option-title">
						<a href="<?php echo $tumblr; ?>" title="<?php _e('Connect us on Tumblr', 'plumtree');?>" target="_blank">
							<i class="fa fa-tumblr"></i>
						</a>
					</li>
				<?php endif; ?>
				<?php if($pinterest != '' ) : ?>
					<li class="option-title">
						<a href="<?php echo $pinterest; ?>" title="<?php _e('Connect us on Pinterest', 'plumtree');?>" target="_blank">
							<i class="fa fa-pinterest"></i>
						</a>
					</li>
				<?php endif; ?>
				<?php if($instagram != '' ) : ?>
					<li class="option-title">
						<a href="<?php echo $instagram; ?>" title="<?php _e('Connect us on Instagram', 'plumtree');?>" target="_blank">
							<i class="fa fa-instagram"></i>
						</a>
					</li>
				<?php endif; ?>

			</ul>

		<?php 
		echo $after_widget;
	}
}
