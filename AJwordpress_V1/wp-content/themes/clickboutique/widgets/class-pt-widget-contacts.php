<?php
/**
 * Plumtree Contacts
 *
 * Configurable contacts widget with Google Map.
 *
 * @author TransparentIdeas
 * @package Plum Tree
 * @subpackage Widgets
 * @since 0.01
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'widgets_init', create_function( '', 'register_widget( "pt_contacts_widget" );' ) );

class pt_contacts_widget extends WP_Widget {
	
	public function __construct() {
		parent::__construct(
	 		'pt_contacts_widget', // Base ID
			__('PT Contacts Widget', 'plumtree'), // Name
			array( 'description' => __( 'Plum Tree special widget. An Address Widget with Google map', 'plumtree' ), ) 
		);
	}

	public function form( $instance ) {

		$defaults = array( 
			'title' 		=> 'Location',
			'precontent'    => '',
			'postcontent'   => '',
			'phone'			=> '',
			'fax' 			=> '',
			'skype' 		=> '',
			'email' 		=> '', 
			'address' 		=> '',
		);

		$instance = wp_parse_args( (array) $instance, $defaults ); 
	?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'plumtree' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id ('precontent'); ?>"><?php _e('Pre-Content', 'plumtree'); ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id('precontent'); ?>" name="<?php echo $this->get_field_name('precontent'); ?>" rows="2" cols="25"><?php echo $instance['precontent']; ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id ('postcontent'); ?>"><?php _e('Post-Content', 'plumtree'); ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id('postcontent'); ?>" name="<?php echo $this->get_field_name('postcontent'); ?>" rows="2" cols="25"><?php echo $instance['postcontent']; ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e( 'Phone:', 'plumtree' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" type="text" value="<?php echo $instance['phone']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'fax' ); ?>"><?php _e( 'Fax:', 'plumtree' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'fax' ); ?>" name="<?php echo $this->get_field_name( 'fax' ); ?>" type="text" value="<?php echo $instance['fax']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'skype' ); ?>"><?php _e( 'Skype:', 'plumtree' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'skype' ); ?>" name="<?php echo $this->get_field_name( 'skype' ); ?>" type="text" value="<?php echo $instance['skype']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'Email:', 'plumtree' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" type="text" value="<?php echo $instance['email']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'address' ); ?>"><?php _e( 'Address:', 'plumtree' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>" type="text" value="<?php echo $instance['address']; ?>" />
		</p>
		<?php 
	}

	public function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;

		$instance['title'] = ( $new_instance['title'] );
		$instance['precontent'] = stripslashes( $new_instance['precontent'] );
		$instance['postcontent'] = stripslashes( $new_instance['postcontent'] );
		$instance['phone'] = ( $new_instance['phone'] );
		$instance['fax'] = ( $new_instance['fax'] );
		$instance['skype'] = ( $new_instance['skype'] );
		$instance['email'] = ( $new_instance['email'] );
		$instance['address'] = ( $new_instance['address'] );

		return $instance;
	}

	public function widget( $args, $instance ) {

		global $wpdb;

		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );
		$precontent = (isset($instance['precontent']) ? $instance['precontent'] : '' );
		$postcontent = (isset($instance['postcontent']) ? $instance['postcontent'] : '' );
		$phone = (isset($instance['phone']) ? $instance['phone'] : '' );
		$fax = (isset($instance['fax']) ? $instance['fax'] : '' );
		$skype = (isset($instance['skype']) ? $instance['skype'] : '' );
		$email = (isset($instance['email']) ? $instance['email'] : '' );
		$address = (isset($instance['address']) ? $instance['address'] : '' );

		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
		?>

		<?php if ( ! empty( $precontent ) ) {
			echo '<div class="precontent">'.$precontent.'</div>';
		} ?>

			<ul class="pt-widget-contacts">
				<?php if($phone != '' ) : ?><li class="option-title a-phone"><span class="phone"><?php echo $phone; ?></span></li><?php endif; ?>
				<?php if($fax != '' ) : ?><li class="option-title a-fx"><span class="fax"><?php echo $fax; ?></span></li><?php endif; ?>
				<?php if($skype != '' ) : ?><li class="option-title a-skype"><span class="skype"><?php echo $skype; ?></span></li><?php endif; ?>
				<?php if($email != '' ) : ?><li class="option-title a-email"><span class="email"><a title="<?php _e('Email us', 'plumtree');?>" href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></span></li><?php endif; ?>
				<?php if($address != '' ) : ?><li class="option-title a-address"><span class="address"><?php echo $address; ?></span></li><?php endif; ?>
			</ul>

		<?php 
		if ( ! empty( $postcontent ) ) {
			echo '<div class="postcontent">'.$postcontent.'</div>';
		}

		echo $after_widget;
	}
}
