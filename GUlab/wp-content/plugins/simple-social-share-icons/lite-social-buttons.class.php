<?php 

class LiteSocialButtons 
{
	public function getAll() {
		$included_socialnets = array('facebook', 'twitter', 'pinterest', 'google', 'mail');
		foreach ($included_socialnets as $soc_net) {
			$button_array[] = self::buildSocialButton($soc_net);
		}
		return '<div class="social-links">'.implode('', $button_array).'</div>';
	}

	private $new_window = true;
	private $included_socialnets = array('facebook', 'twitter', 'pinterest', 'google', 'mail');
	private $charmap = array(
			'facebook' => 'facebook',
			'twitter' => 'twitter',
			'pinterest' => 'pinterest',
			'google' => 'google-plus',
			'mail' => 'envelope-o'
	);
	private $titlemap = array(
		'facebook' =>  'Share this article on Facebook',
		'twitter' => 'Share this article on Twitter',
		'pinterest' =>  'Share an image of this article on Pinterest',
		'google' => 'Share this article on Google+',
		'mail' => 'Email this article to a friend'	);

	private function buildSocialButton($this_one) {
		$new_window = true;
		$charmap = array(
			'facebook' => 'facebook',
			'twitter' => 'twitter',
			'pinterest' => 'pinterest',
			'google' => 'google-plus',
			'mail' => 'envelope-o'
		);
		if ($this_one != 'mail' && $this->new_window == true)
			$target =  ' target="_blank"';
		else $target = '';

		return '<a href="'.$this->getSocialUrl($this_one).'"'.$target.'><span class="wrapper" title="'.$this->titlemap[$this_one].'"><i class="fa fa-'.$this->charmap[$this_one].'"></i></span></a>';
	}

	private function getSocialUrl($service) {
		global $post;
		$text = urlencode("A great post: ".$post->post_title);
		$escaped_url = urlencode(get_permalink());
		$image = has_post_thumbnail( $post->ID ) ? wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ) : null;

		switch ($service) {
			case "twitter" :
				$api_link = 'https://twitter.com/intent/tweet?source=webclient&amp;original_referer='.$escaped_url.'&amp;text='.$text.'&amp;url='.$escaped_url;
				break;

			case "facebook" :
				$api_link = 'https://www.facebook.com/sharer/sharer.php?u='.$escaped_url;
				break;

			case "google" :
				$api_link = 'https://plus.google.com/share?url='.$escaped_url;
				break;

			case "pinterest" :
				if (isset($image)) {
					$api_link = 'http://pinterest.com/pin/create/bookmarklet/?media='.$image[0].'&amp;url='.$escaped_url.'&amp;title='.get_the_title().'&amp;description='.esc_html( $post->post_excerpt );
				}
				else {
					$api_link = "javascript:void((function(){var%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)})());";
				}
				break;

			case "mail" :
				$subject = 'A great piece from Spoonwiz';
				$body = 'See it at: ';
				$api_link = 'mailto:?subject='.str_replace('&amp;','%26',rawurlencode($subject)).'&body='.str_replace('&amp;','%26',rawurlencode($body).$escaped_url);
				break;
		}

		return $api_link;
	}
}