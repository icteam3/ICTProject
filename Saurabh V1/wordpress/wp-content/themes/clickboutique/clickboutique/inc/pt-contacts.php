<?php 
// Contacts shortcode
function show_contacts($atts, $content = null) {
	
	extract(shortcode_atts( array(
		'phone' => '',
		'fax' => '',
		'skype' => '',
		'email' => '',
		'address' => '',
 	), $atts ) );

	$html = '<div class="contacts-section">';

		if ($content) { $html .= '<h3 class="contacts-title pt-content-title">'.$content.'</h3>'; }
		if ($phone) { $html .= '<div class="contact phone"><i class="fa fa-phone fa-fw"></i>&nbsp;&nbsp;<strong>Phone:&nbsp;&nbsp;</strong><span>'.$phone.'</span></div>'; }
		if ($fax) { $html .= '<div class="contact fax"><i class="fa fa-print fa-fw"></i>&nbsp;&nbsp;<strong>Fax:&nbsp;&nbsp;</strong><span>'.$fax.'</span></div>'; }
		if ($skype) { $html .= '<div class="contact skype"><i class="fa fa-skype fa-fw"></i>&nbsp;&nbsp;<strong>Skype:&nbsp;&nbsp;</strong><span>'.$skype.'</span></div>'; }
		if ($email) { $html .= '<div class="contact email"><i class="fa fa-envelope fa-fw"></i>&nbsp;&nbsp;<strong>Email:&nbsp;&nbsp;</strong><span><a title="'.__('Email us', 'plumtree').'" href="mailto:'.$email.'">'.$email.'</a></span></div>'; }
		if ($address) { $html .= '<address class="contact address"><i class="fa fa-map-marker fa-fw"></i>&nbsp;&nbsp;<strong>Address:&nbsp;&nbsp;</strong><span>'.$address.'</span></address>'; }

	$html .= '</div>';	

	return $html;
}

function register_show_contacts(){
   add_shortcode('show-contacts', 'show_contacts');
}
add_action( 'init', 'register_show_contacts');


// Social Icons shortcode
function show_social_icons($atts, $content = null) {

	extract(shortcode_atts( array(
		'twitter'		=> '',
		'facebook'		=> '',
		'gplus'			=> '',
		'youtube'		=> '',
		'flickr'		=> '',
		'linkedin'		=> '',
 	), $atts ) );

	$twitter_url = ( $twitter && $twitter != '') ? 'http://twitter.com/' . $twitter : '';
	$services = array(
		'twitter'		=> array( 'name' => 'Twitter', 'icon' => 'twitter-square', 'url' => $twitter_url ),
		'facebook'		=> array( 'name' => 'Facebook', 'icon' => 'facebook-square', 'url' => $facebook ),
		'gplus'			=> array( 'name' => 'Google+', 'icon' => 'google-plus-square', 'url' => $gplus ),
		'youtube'		=> array( 'name' => 'YouTube', 'icon' => 'youtube-square', 'url' => $youtube ),
		'flickr'		=> array( 'name' => 'Flickr', 'icon' => 'flickr', 'url' => $flickr ),
		'linkedin'		=> array( 'name' => 'LinkedIn', 'icon' => 'linked-square', 'url' => $linkedin ),
	);

		$html = '<div class="social-icons-section">';

		if ($content) { $html .= '<h3 class="socials-title pt-content-title">'.$content.'</h3>'; }

			$html .= '<ul>';
			foreach ( $services as $service_id => $service ) {
				if ( isset($service['url']) && $service['url'] != '' ) {
					$text = apply_filters( "pt_social_{$service_id}", sprintf( __( 'Connect Us on %s', 'plumtree'), $service['name'] ) );
					$html .= '<li class="listing listing-' . $service_id . '">';
					$html .= '<a href="' . $service['url'] . '" target="_blank" title="' . $text . '">';
					$html .= '<i class="fa fa-' . $service['icon'] . ' fa-2x"></i>';
					$html .= '</a></li>';
				}
			}
			$html .= '</ul>';

		$html .= '</div>';

	return $html;

}
function register_show_social_icons(){
   add_shortcode('show-social-icons', 'show_social_icons');
}
add_action( 'init', 'register_show_social_icons');

