<?php
/*-------Plumtree Theme Functions----------*/

// Replaces the excerpt "more" text by a link
function pt_excerpt_more() {
	if ( get_option('blog_read_more_text') != '' ) {
			$text = get_option('blog_read_more_text');
	} else { $text = __('Read More', 'plumtree'); }
	return $text;
}
add_filter('pt_more', 'pt_excerpt_more');

// ----- Plumtree menu args function
if ( ! function_exists( 'pt_page_menu_args' ) ) {
	function pt_page_menu_args( $args ) {
		if ( ! isset( $args['show_home'] ) )
			$args['show_home'] = true;
		return $args;
	}
}
add_filter( 'wp_page_menu_args', 'pt_page_menu_args' );

// ----- Plumtree custom media fields function
function pt_custom_media_fields( $form_fields, $post ) {

	$form_fields['portfolio_filter'] = array(
		'label' => 'Portfolio Filters',
		'input' => 'text',
		'value' => get_post_meta( $post->ID, 'portfolio_filter', true ),
		'helps' => 'Used only for Portfolio and Gallery Pages Isotope filtering',
	);

	return $form_fields;
}

add_filter( 'attachment_fields_to_edit', 'pt_custom_media_fields', 10, 2 );

function pt_custom_media_fields_save( $post, $attachment ) {

	if( isset( $attachment['portfolio_filter'] ) )
		update_post_meta( $post['ID'], 'portfolio_filter', $attachment['portfolio_filter'] );

	if( isset( $attachment['hover_style'] ) )
		update_post_meta( $post['ID'], 'hover_style', $attachment['hover_style'] );

	return $post;
}

add_filter( 'attachment_fields_to_save', 'pt_custom_media_fields_save', 10, 2 );

// ----- Plumtree content pagination function
if ( ! function_exists( 'pt_content_nav' ) ) {
	function pt_content_nav($before='', $after='', $echo=true) {
		if( is_singular() )	return;

		/* Settings */
		// Text for number of pages. {current} is replaced by the current page and the {last} by last . Example: 'Page {current} of {last}' = Page 4 of 60
		if ( get_option('blog_pagenavi_counter') == 'on' ) {
			$text_num_page = 'Page {current} of {last}';
		} else { $text_num_page = ''; }
		// How many links to display
		if ( get_option('blog_pagenavi_qty') != '' ) {
			$num_pages = get_option('blog_pagenavi_qty');
		} else { $num_pages = 3; }
		// Links with a certain step (value = number (step)). Example: 1,2,3 ... 10,20,30
		if ( get_option('blog_pagenavi_step') != '' ) {
			$stepLink = get_option('blog_pagenavi_step');
		} else { $stepLink = 10; }
		// Intermediate text
		if ( get_option('blog_pagenavi_intermidiate_text') != '' ) {
			$dotright_text = get_option('blog_pagenavi_intermidiate_text');
		} else { $dotright_text = '...'; }
		// 'Previous page' text
		if ( get_option('blog_pagenavi_previous_text') != '' ) {
			$backtext = get_option('blog_pagenavi_previous_text');
		} else { $backtext = '<i class="fa fa-angle-left"></i>'; }
		// 'Next page' text
		if ( get_option('blog_pagenavi_next_text') != '' ) {
			$nexttext = get_option('blog_pagenavi_next_text');
		} else { $nexttext = '<i class="fa fa-angle-right"></i>'; }
		// 'First page' text
		if ( get_option('blog_pagenavi_first_text') != '' ) {
			$first_page_text = get_option('blog_pagenavi_first_text');
		} else { $first_page_text = ''; }
		// 'Last page' text
		if ( get_option('blog_pagenavi_last_text') != '' ) {
			$last_page_text = get_option('blog_pagenavi_last_text');
		} else { $last_page_text = ''; }

		global $wp_query;
		$posts_per_page = $wp_query->query_vars['posts_per_page'];
		$paged = $wp_query->query_vars['paged'];
		$max_page = $wp_query->max_num_pages;

		if($max_page <= 1 ) return false; // Check if pagination needed

		if(empty($paged) || $paged == 0) $paged = 1;

		$pages_to_show = intval($num_pages);
		$pages_to_show_minus_1 = $pages_to_show-1;

		$half_page_start = floor($pages_to_show_minus_1/2);
		$half_page_end = ceil($pages_to_show_minus_1/2);

		$start_page = $paged - $half_page_start;
		$end_page = $paged + $half_page_end;

		if($start_page <= 0) $start_page = 1;
		if(($end_page - $start_page) != $pages_to_show_minus_1) $end_page = $start_page + $pages_to_show_minus_1;
		if($end_page > $max_page) {
			$start_page = $max_page - $pages_to_show_minus_1;
			$end_page = (int) $max_page;
		}

		if($start_page <= 0) $start_page = 1;

		$out=''; // Output function
			$out.= $before."<div class='pagination'>\n";
					if ($text_num_page){
						$text_num_page = preg_replace ('!{current}|{last}!','%s',$text_num_page);
						$out.= sprintf ("<span class='pages'>$text_num_page</span>",$paged,$max_page);
					}

					if ($backtext && $paged!=1) $out.= '<a rel="bookmark" href="'.get_pagenum_link(($paged-1)).'">'.$backtext.'</a>';

					if ($start_page >= 2 && $pages_to_show < $max_page) {
						if ($first_page_text != '') $out.= '<a rel="bookmark" href="'.get_pagenum_link().'">'. $first_page_text .'</a>';
						if ($dotright_text && $start_page!=2) $out.= '<span class="extend">'.$dotright_text.'</span>';
					}

					for($i = $start_page; $i <= $end_page; $i++) {
						if($i == $paged) {
							$out.= '<span class="current">'.$i.'</span>';
						} else {
							$out.= '<a rel="bookmark" href="'.get_pagenum_link($i).'">'.$i.'</a>';
						}
					}

					// Links with step
					if ($stepLink && $end_page < $max_page){
						for($i=$end_page+1; $i<=$max_page; $i++) {
							if($i % $stepLink == 0 && $i!==$num_pages) {
								if (++$dd == 1) $out.= '<span class="extend">'.$dotright_text.'</span>';
								$out.= '<a rel="bookmark" href="'.get_pagenum_link($i).'">'.$i.'</a>';
							}
						}
					}

					if ($end_page < $max_page) {
						if ($dotright_text && $end_page!=($max_page-1)) $out.= '<span class="extend">'.$dotright_text.'</span>';
						if ($last_page_text != '') $out.= '<a rel="bookmark" href="'.get_pagenum_link($max_page).'">'. $last_page_text .'</a>';
					}

					if ($nexttext && $paged!=$end_page) $out.= '<a href="'.get_pagenum_link(($paged+1)).'">'.$nexttext.'</a>';

			$out.= "</div>".$after."\n";
		if ($echo) echo $out;
		else return $out;
	}
}

// ----- Plumtree Blog Breadcrumbs Function
function pt_blog_breadcrumbs() {

	/* === OPTIONS === */
	$text['home'] = __('Home', 'plumtree'); // text for the 'Home' link
	$text['category'] = __('Archive by Category "%s"', 'plumtree'); // text for a category page
	$text['search'] = __('Search Results for "%s" Query', 'plumtree'); // text for a search results page
	$text['tag'] = __('Posts Tagged "%s"', 'plumtree'); // text for a tag page
	$text['author'] = __('Articles Posted by %s', 'plumtree'); // text for an author page
	$text['404'] = __('Error 404', 'plumtree'); // text for the 404 page

	$show_current = 1; // 1 - show current post/page/category title in breadcrumbs, 0 - don't show
	$show_on_home = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
	$show_home_link = 1; // 1 - show the 'Home' link, 0 - don't show
	$show_title = 1; // 1 - show the title for the links, 0 - don't show
	$delimiter = '&nbsp;&nbsp;&frasl;&nbsp;&nbsp;'; // delimiter between crumbs
	$before = '<span class="current">'; // tag before the current crumb
	$after = '</span>'; // tag after the current crumb
	/* === END OF OPTIONS === */

	global $post;

	$home_link = home_url('/');
	$link_before = '<span typeof="v:Breadcrumb">';
	$link_after = '</span>';
	$link_attr = ' rel="v:url" property="v:title"';
	$link = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
	$parent_id = $parent_id_2 = $post->post_parent;
	$frontpage_id = get_option('page_on_front');

	if (is_home() || is_front_page()) {

		if ($show_on_home == 1) echo '<div class="blog-breadcrumbs"><a href="' . $home_link . '">' . $text['home'] . '</a></div>';

	} else {

		echo '<div class="blog-breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">';
		if ($show_home_link == 1) {
			echo '<a href="' . $home_link . '" rel="v:url" property="v:title">' . $text['home'] . '</a>';
		if ($frontpage_id == 0 || $parent_id != $frontpage_id) echo $delimiter;
	}

	if ( is_category() ) {
		$this_cat = get_category(get_query_var('cat'), false);
		if ($this_cat->parent != 0) {
			$cats = get_category_parents($this_cat->parent, TRUE, $delimiter);
			if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
			$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
			$cats = str_replace('</a>', '</a>' . $link_after, $cats);
			if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
		echo $cats;
		}
		if ($show_current == 1) echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;

	} elseif ( is_search() ) {
		echo $before . sprintf($text['search'], get_search_query()) . $after;

	} elseif ( is_day() ) {
		echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
		echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
		echo $before . get_the_time('d') . $after;

	} elseif ( is_month() ) {
		echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
		echo $before . get_the_time('F') . $after;

	} elseif ( is_year() ) {
		echo $before . get_the_time('Y') . $after;

	} elseif ( is_single() && !is_attachment() ) {
		if ( get_post_type() != 'post' ) {
			$post_type = get_post_type_object(get_post_type());
			$slug = $post_type->rewrite;
			printf($link, $home_link . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
			if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;
		} else {
			$cat = get_the_category(); $cat = $cat[0];
			$cats = get_category_parents($cat, TRUE, $delimiter);
			if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
			$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
			$cats = str_replace('</a>', '</a>' . $link_after, $cats);
			if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
			echo $cats;
			if ($show_current == 1) echo $before . get_the_title() . $after;
		}

	} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
		$post_type = get_post_type_object(get_post_type());
		echo $before . $post_type->labels->singular_name . $after;

	} elseif ( is_attachment() ) {
		$parent = get_post($parent_id);
		$cat = get_the_category($parent->ID); $cat = $cat[0];
		if ($cat) {
			$cats = get_category_parents($cat, TRUE, $delimiter);
			$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
			$cats = str_replace('</a>', '</a>' . $link_after, $cats);
			if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
			echo $cats;
		}
		printf($link, get_permalink($parent), $parent->post_title);
		if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;

	} elseif ( is_page() && !$parent_id ) {
		if ($show_current == 1) echo $before . get_the_title() . $after;

	} elseif ( is_page() && $parent_id ) {
		if ($parent_id != $frontpage_id) {
			$breadcrumbs = array();
			while ($parent_id) {
				$page = get_page($parent_id);
				if ($parent_id != $frontpage_id) {
					$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
				}
				$parent_id = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			for ($i = 0; $i < count($breadcrumbs); $i++) {
				echo $breadcrumbs[$i];
				if ($i != count($breadcrumbs)-1) echo $delimiter;
			}
		}
		if ($show_current == 1) {
			if ($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) echo $delimiter;
			echo $before . get_the_title() . $after;
		}

	} elseif ( is_tag() ) {
		echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

	} elseif ( is_author() ) {
		global $author;
		$userdata = get_userdata($author);
		echo $before . sprintf($text['author'], $userdata->display_name) . $after;

	} elseif ( is_404() ) {
		echo $before . $text['404'] . $after;

	} elseif ( has_post_format() && !is_singular() ) {
		echo get_post_format_string( get_post_format() );
	}

	if ( get_query_var('paged') ) {
		if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
		echo __('Page', 'plumtree') . ' ' . get_query_var('paged');
		if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
	}

	echo '</div><!-- .breadcrumbs -->';

	}
}

// ----- Plumtree Posts Navigation
if ( ! function_exists( 'pt_post_nav' ) ) {
	function pt_post_nav() {
		global $post;
		// Don't print empty markup if there's nowhere to navigate.
		$previous  = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next      = get_adjacent_post( false, '', false );
		$separator = '<span class="separator">&nbsp;&nbsp;&nbsp;&frasl;&nbsp;&nbsp;&nbsp;</span>';

		if ( ! $next && ! $previous ) return;
		?>
			<div class="single-post-navi">
				<?php previous_post_link('%link', '<i class="fa fa-angle-left"></i>&nbsp;&nbsp;&nbsp;'.__('Prev', 'plumtree')); ?>
				<?php if (!$next || !$previous) {
						$separator ='';
					  }
					  echo $separator;
				?>
				<?php next_post_link('%link', __('Next', 'plumtree').'&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>'); ?>
			</div>
<?php }
}

// ----- Plumtree Comment function
if ( ! function_exists( 'pt_comments' ) ) {
	function pt_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
			// Display trackbacks differently than normal comments.
		?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
			<p><?php _e( 'Pingback:', 'plumtree' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'plumtree' ), '<span class="edit-link">', '</span>' ); ?></p>
		<?php
			break;
			default :
			// Proceed with normal comments.
			global $post;
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<article id="comment-<?php comment_ID(); ?>" class="comment">
				<?php echo get_avatar( $comment, 67 ); ?>
				<header class="comment-meta comment-author vcard">
					<?php
						$d = 'Y.m.d';
						$t = 'g:i A';
						printf( '<cite class="fn comment-author">%1$s %2$s</cite>',
							get_comment_author_link(),
							// If current post author is also comment author, make it known visually.
							( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'plumtree' ) . '</span>' : ''
						);
						printf( '<time datetime="%2$s" class="comment-date">%3$s</time>',
							esc_url( get_comment_link( $comment->comment_ID ) ),
							get_comment_time( 'c' ),
							/* translators: 1: date, 2: time */
							sprintf( __( '%1$s at %2$s', 'plumtree' ), get_comment_date( $d ), get_comment_time( $t ) )
						);
					?>
					<?php edit_comment_link( __( 'Edit this Comment', 'plumtree' ), '<p class="edit-link">', '</p>' ); ?>
				</header><!-- .comment-meta -->

				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'plumtree' ); ?></p>
				<?php endif; ?>

				<section class="comment-content comment">
					<?php comment_text(); ?>
				</section><!-- .comment-content -->

				<div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'plumtree' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div><!-- .reply -->
				<div class="clear"></div>
			</article><!-- #comment-## -->
		<?php
			break;
		endswitch; // end comment_type check
	}
}

// ----- Plumtree Meta output functions
if ( ! function_exists( 'pt_entry_publication_time' ) ) {
	function pt_entry_publication_time() {
		$date = sprintf( '<time class="entry-date" datetime="%1$s"><span class="day">%2$s</span>%3$s&nbsp;%4$s</time>',
			esc_attr( get_the_date('c') ),
			esc_html( get_the_date('j') ),
			esc_html( get_the_date('M') ),
			esc_html( get_the_date('Y') )
		);
		echo $output_text = '<div class="time-wrapper">'.$date.'</div>';
	}
}

if ( ! function_exists( 'pt_entry_comments_counter' ) ) {
	function pt_entry_comments_counter() {
		echo '<div class="post-comments">';
		comments_popup_link( '0 Comments', '1 Comment', '% Comments', 'comments-link', 'Commenting: OFF');
		echo '</div>';
	}
}

if ( ! function_exists( 'pt_entry_post_cats' ) ) {
	function pt_entry_post_cats() {
		$categories_list = get_the_category_list( __( '</span>, <span class="cat-name">', 'plumtree' ) );
		if ( $categories_list ) { echo '<div class="post-cats">'.__('Categories: ', 'plumtree').$categories_list.'</div>'; }
	}
}

if ( ! function_exists( 'pt_entry_post_tags' ) ) {
	function pt_entry_post_tags() {
		$tag_list = get_the_tag_list( '', __( '</span>, <span class="tag-name">', 'plumtree' ) );
		if ( $tag_list ) { echo '<div class="post-tags">'.__('Tags: ', 'plumtree').$tag_list.'</div>';	}
	}
}

if ( ! function_exists( 'pt_entry_author' ) ) {
	function pt_entry_author() {
		$author = sprintf( '<div class="post-author">'.__('Author: ', 'plumtree').'<a href="%1$s" title="%2$s" rel="author">%3$s</a></div>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'plumtree' ), get_the_author() ) ),
			get_the_author()
		);
		echo $author;
	}
}

if ( ! function_exists( 'pt_entry_post_views' ) ) {
	function pt_entry_post_views() {
		global $post;
		$views = get_post_meta ($post->ID,'views',true);
		if ($views) {
			echo '<div class="post-views" title="'.__('Total Views', 'plumtree').'"><i class="fa fa-eye"></i>'.$views.'</div>';
		} else { echo '<div class="post-views" title="'.__('Total Views', 'plumtree').'"><i class="fa fa-eye"></i>0</div>'; }
	}
}

if ( ! function_exists( 'pt_entry_post_format' ) ) {
	function pt_entry_post_format() {
		global $post;
		$format = get_post_format($post->ID);
		if ( false === $format ) { $format = 'standard'; }
		$icons = array(
			'aside' => '<i class="fa fa-comment-o"></i>',
			'standard' => '<i class="fa fa-file-text-o"></i>',
			'chat' => '<i class="fa fa-users"></i>',
			'gallery' => '<i class="fa fa-picture-o"></i>',
			'link' => '<i class="fa fa-link"></i>',
			'image' => '<i class="fa fa-camera-retro"></i>',
			'quote' => '<i class="fa fa-quote-right"></i>',
			'status' => '<i class="fa fa-exclamation-circle"></i>',
			'video' => '<i class="fa fa-film"></i>',
			'audio' => '<i class="fa fa-headphones"></i>',
		);
		echo '<div class="post-format">'.$icons[$format].'</div>';
	}
}

// ----- Plumtree get attached images function
if ( ! function_exists( 'pt_the_attached_image' ) ) {
	function pt_the_attached_image() {
		$post                = get_post();
		$attachment_size     = apply_filters( 'plumtree_attachment_size', array( 724, 724 ) );
		$next_attachment_url = wp_get_attachment_url();

		/**
		 * Grab the IDs of all the image attachments in a gallery so we can get the URL
		 * of the next adjacent image in a gallery, or the first image (if we're
		 * looking at the last image in a gallery), or, in a gallery of one, just the
		 * link to that image file.
		 */
		$attachment_ids = get_posts( array(
			'post_parent'    => $post->post_parent,
			'fields'         => 'ids',
			'numberposts'    => -1,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => 'ASC',
			'orderby'        => 'menu_order ID'
		) );

		// If there is more than 1 attachment in a gallery...
		if ( count( $attachment_ids ) > 1 ) {
			foreach ( $attachment_ids as $attachment_id ) {
				if ( $attachment_id == $post->ID ) {
					$next_id = current( $attachment_ids );
					break;
				}
			}

			// get the URL of the next image attachment...
			if ( $next_id )
				$next_attachment_url = get_attachment_link( $next_id );

			// or get the URL of the first image attachment.
			else
				$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}

		printf( '%1$s',	wp_get_attachment_image( $post->ID, $attachment_size ) );
	}
}

// ----- Plumtree Body class function
if ( ! function_exists( 'pt_body_class' ) ) {
	function pt_body_class( $classes ) {
		$background_color = get_background_color();

        if ( ( is_home() || is_front_page() ) && (get_option('transp_header') == 'on') ){
            $classes[] = 'transparent-header';
        }

		if ( is_page_template( 'page-templates/front-page.php' ) ) {
			$classes[] = 'template-front-page';
			if ( has_post_thumbnail() )
				$classes[] = 'has-post-thumbnail';
		}

		if ( empty( $background_color ) )
			$classes[] = 'custom-background-empty';
		elseif ( in_array( $background_color, array( 'fff', 'ffffff' ) ) )
			$classes[] = 'custom-background-white';

		// Enable custom font class only if the font CSS is queued to load.
		if ( wp_style_is( 'plumtree-fonts', 'queue' ) )
			$classes[] = 'custom-font-enabled';

		if ( ! is_multi_author() )
			$classes[] = 'single-author';

		if (get_option('checkout_steps') == 'on') {
			$classes[] = 'multistep-checkout';
		}

		return $classes;
	}
}
add_filter( 'body_class', 'pt_body_class' );


// ----- Plumtree Customize function
if ( ! function_exists( 'pt_customize_register' ) ) {
	function pt_customize_register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	}
}
add_action( 'customize_register', 'pt_customize_register' );

if ( ! function_exists( 'pt_customize_preview_js' ) ) {
	function pt_customize_preview_js() {
		wp_enqueue_script( 'plumtree-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20120827', true );
	}
}
add_action( 'customize_preview_init', 'pt_customize_preview_js' );


// ----- Plumtree Views counter function
if ( ! function_exists( 'pt_postviews' ) ) {
    function pt_postviews() {

    /* ------------ Settings -------------- */
    $meta_key       = 'views';  	// The meta key field, which will record the number of views.
    $who_count      = 0;            // Whose visit to count? 0 - All of them. 1 - Only the guests. 2 - Only registred users.
    $exclude_bots   = 1;            // Exclude bots, robots, spiders, and other mischief? 0 - no. 1 - yes.

    global $user_ID, $post;
        if(is_singular()) {
            $id = (int)$post->ID;
            static $post_views = false;
            if($post_views) return true;
            $post_views = (int)get_post_meta($id,$meta_key, true);
            $should_count = false;
            switch( (int)$who_count ) {
                case 0: $should_count = true;
                    break;
                case 1:
                    if( (int)$user_ID == 0 )
                        $should_count = true;
                    break;
                case 2:
                    if( (int)$user_ID > 0 )
                        $should_count = true;
                    break;
            }
            if( (int)$exclude_bots==1 && $should_count ){
                $useragent = $_SERVER['HTTP_USER_AGENT'];
                $notbot = "Mozilla|Opera"; //Chrome|Safari|Firefox|Netscape - all equals Mozilla
                $bot = "Bot/|robot|Slurp/|yahoo";
                if ( !preg_match("/$notbot/i", $useragent) || preg_match("!$bot!i", $useragent) )
                    $should_count = false;
            }

            if($should_count)
                if( !update_post_meta($id, $meta_key, ($post_views+1)) ) add_post_meta($id, $meta_key, 1, true);
        }
        return true;
    }
}
add_action('wp_head', 'pt_postviews');

// ----- Plumtree Adding infinity for aside post format
if ( ! function_exists( 'pt_aside_infinity' ) ) {
	function pt_aside_infinity( $content ) {

		if ( has_post_format( 'aside' ) && !is_singular() )
			$content .= ' <a class="aside-infinity" rel="bookmark" href="' . get_permalink() . '">&#8734;</a>';

		return $content;
	}
}
add_filter( 'the_content', 'pt_aside_infinity', 9 ); // run before wpautop

// ----- Plumtree Adding Custom editor CSS styles
if ( ! function_exists( 'pt_add_editor_styles' ) ) {
	function pt_add_editor_styles() {
	    add_editor_style( get_template_directory_uri().'/css/editor.css' );
	}
}
add_action( 'init', 'pt_add_editor_styles' );

// ----- Plumtree Adding inline CSS styles
if ( ! function_exists( 'pt_add_inline_styles' ) ) {

	function pt_add_inline_styles() {

	$font_map_1 = array(
		'default' => "'Lato' !important",
		'lato' => "'Lato' !important",
		'robotocondenced' => "'Roboto Condensed' !important",
		'mavenpro' => "'Maven Pro' !important",
		'monda' => "'Monda' !important",
		'nexa' => "'Nexa' !important",
		'opensans' => "'Open Sans' !important",
		'merriweather' => "'Merriweather' !important",
		'economica'  => "'Economica' !important",
		'galdeano'   => "'Galdeano' !important",
		'nixieone' => "'Nixie One' !important",
		'actor' => "'Actor' !important",
		'museo' => "'Museo' !important",
		'ropasans' => "'Ropa Sans' !important",
		'roboto' => "'Roboto' !important",
		'quicksand' => "'Quicksand' !important",
		'lovelo' => "'Lovelo' !important"
	);

	$font_map_2 = array(
		'default' => "'Roboto Condensed' !important",
		'lato' => "'Lato' !important",
		'robotocondenced' => "'Roboto Condensed' !important",
		'mavenpro' => "'Maven Pro' !important",
		'monda' => "'Monda' !important",
		'nexa' => "'Nexa' !important",
		'opensans' => "'Open Sans' !important",
		'merriweather' => "'Merriweather' !important",
		'economica'  => "'Economica' !important",
		'galdeano'   => "'Galdeano' !important",
		'nixieone' => "'Nixie One' !important",
		'actor' => "'Actor' !important",
		'museo' => "'Museo' !important",
		'ropasans' => "'Ropa Sans' !important",
		'roboto' => "'Roboto' !important",
		'quicksand' => "'Quicksand' !important",
		'lovelo' => "'Lovelo' !important"
	);

    $pt_font_t  = (get_option('main_font')) ? get_option('main_font') : 'lato';
    $pt_h_font = (get_option('heading_font')) ? get_option('heading_font') : 'lato';
    $pt_l_font = (get_option('logo_font')) ? get_option('logo_font') : 'lato';
    $pt_m_font = (get_option('menu_font')) ? get_option('menu_font') : 'lato';

	$out = '<style type="text/css">
		body {
			font-family: '.$font_map_1[$pt_font_t].';
			color: '.get_option('main_color').';
		}
		ul.sf-menu li a, .widget ul.sf-menu li a {
			font-family: '.$font_map_2[$pt_m_font].';
			color: '.get_option('menu_color').';
		}
		ul.sf-menu li a:hover, ul.sf-menu li a:focus, ul.sf-menu li a:active,
		.widget ul.sf-menu li a:hover, .widget ul.sf-menu li a:focus, .widget ul.sf-menu li a:active {
			color: '.get_option('menu_decor_color').';
		}
		h1.site-title {
			font-family: '.$font_map_2[$pt_l_font].';
			color: '.get_option('logo_color').' !important;
		}
		h1.site-title a {
			color: '.get_option('logo_color').' !important;
		}
		.site-content a,
		.widget ul li a,
		.site-content article .entry-content a {
			color: '.get_option('link_color').';
		}
		.site-content a:hover,
		.site-content a:focus,
		.site-content a:active,
		.widget ul li a:hover,
		.widget ul li a:focus,
		.widget ul li a:active,
		.site-content article .entry-content a:hover,
		.site-content article .entry-content a:focus,
		.site-content article .entry-content a:active {
			color: '.get_option('link_color_hover').';
		}
		.woocommerce-tabs .tabs li.active a,
		.woocommerce-tabs .tabs li:hover a {
			color: '.get_option('link_color_hover').';
		}
		.products .product-title,
		.widget.woocommerce ul li .product-title {
			color: '.get_option('link_color').' !important;
		}
		.products .product-title:hover,
		.products .product-title:focus,
		.products .product-title:active,
		.widget.woocommerce ul li .product-title:hover,
		.widget.woocommerce ul li .product-title:focus,
		.widget.woocommerce ul li .product-title:active {
			color: '.get_option('link_color_hover').' !important;
		}
		.widget-title span {
		    color: '.get_option('headings_first_word').';
		}
		aside .widget .widget-title {
		    color: '.get_option('headings_sidebar').';
		}
		.site-content .widget .widget-title,
		.pt-page-title,
		.comment-reply-title,
		.pt-content-title,
		.pt-article-title,
		.entry-content h1,
		.entry-content h2,
		.entry-content h3,
		.entry-content h4,
		.entry-content h5,
		.entry-content h6,
		.single-product .related.products h2,
		.woocommerce-tabs .panel.entry-content h2,
		.product_title {
			font-family: '.$font_map_1[$pt_h_font].';
		    color: '.get_option('headings_content').';
		}
		#colophon .widget .widget-title {
		    color: '.get_option('headings_footer').';
		}
		.pt-button,
		.site-content button,
		.site-content input[type="submit"],
		.site-content input[type="button"],
		.site-content input[type="reset"],
		.widget button,
		.widget input[type="submit"],
		.widget input[type="button"],
		.widget input[type="reset"],
		button,
		input[type="submit"],
		input[type="button"],
		input[type="reset"],
		.site-content a.more-link,
		.site-content article .entry-content a.more-link,
		.more-link,
		.button.single_add_to_cart_button,
		.pt-dark-button.step-checkout,
		.shop_table.cart .coupon-submit,
		.cart-totals .update {
			background-color: '.get_option('button_color').';
			color: '.get_option('button_color_text').';
		}
		.pt-button:hover,
		.pt-button:focus,
		.site-content   button:hover,
		.site-content   button:focus,
		.site-content   input[type="submit"]:hover,
		.site-content   input[type="button"]:hover,
		.site-content   input[type="reset"]:hover,
		.site-content   input[type="submit"]:focus,
		.site-content   input[type="button"]:focus,
		.site-content   input[type="reset"]:focus,
		.widget button:hover,
		.widget button:focus,
		.widget input[type="submit"]:hover,
		.widget input[type="button"]:hover,
		.widget input[type="reset"]:hover,
		.widget input[type="submit"]:focus,
		.widget input[type="button"]:focus,
		.widget input[type="reset"]:focus,
		button:hover,
		input[type="submit"]:hover,
		input[type="button"]:hover,
		input[type="reset"]:hover,
		button:focus,
		input[type="submit"]:focus,
		input[type="button"]:focus,
		input[type="reset"]:focus,
		.site-content a.more-link:hover,
		.site-content article .entry-content a.more-link:hover,
		.more-link:hover,
		.site-content a.more-link:focus,
		.site-content article .entry-content a.more-link:focus,
		.more-link:focus,
		.button.single_add_to_cart_button:hover,
		.button.single_add_to_cart_button:focus,
		.pt-dark-button.step-checkout:hover,
		.pt-dark-button.step-checkout:focus ,
		.shop_table.cart .coupon-submit:hover,
		.cart-totals .update:hover,
		.shop_table.cart .coupon-submit:focus,
		.cart-totals .update:focus {
		    background-color: '.get_option('button_color_hover').';
		    color: '.get_option('button_color_text').';
		}


		</style>';

	echo $out;

	}
}
add_action ( 'wp_head', 'pt_add_inline_styles' );


/* Related Posts */
if ( ! function_exists( 'pt_related_posts' ) ) {

	function pt_related_posts(){

		global $post;
		$orig_post = $post;
    	$categories = get_the_category($post->ID);

    	if ($categories) {
    		$category_ids = array();
    		foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;

		    $args = array(
			    'category__in' => $category_ids,
			    'post__not_in' => array($post->ID),
			    'posts_per_page'=> 3, // Number of related posts that will be shown.
			    'ignore_sticky_posts'=>1
		    );

    		$my_query = new wp_query( $args );

    		if ( $my_query->have_posts() ) : ?>
    			<div id="related_posts">
					<h3 class="pt-content-title"><?php _e('Related Posts', 'plumtree'); ?></h3>
    				<ul>

				<?php while ( $my_query->have_posts() ) : $my_query->the_post(); ?>

				<li>
   					<div class="relatedthumb">
   						<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_post_thumbnail('related-post-thumb'); ?></a>
   					</div>
    				<div class="relatedcontent">
	    				<h3>
	    					<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
	    				</h3>
    				</div>
    			</li>

				<?php endwhile;
				echo '</ul></div>';
			endif;
    	}
	    $post = $orig_post;
	    wp_reset_query();
	}

}

/* Adding magnific popup only if attached to image file */

add_filter( 'post_gallery', 'pt_default_gallery', 10, 2);

function pt_default_gallery($output , $attr) {
	if ( ! empty( $attr['link'] ) && 'file' === $attr['link'] )
		add_filter('gallery_style', 'pt_add_gallery_class');
}

function pt_add_gallery_class($output){
	$new_output =  str_replace( 'gallery galleryid', 'gallery magnific-gallery galleryid', $output);
	return $new_output;
};




function cb_wp_title( $title, $sep ) {
    global $paged, $page;

    if ( is_feed() ) {
        return $title;
    }

    // Add the site name.
    $title .= get_bloginfo( 'name', 'display' );

    // Add the site description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) ) {
        $title = "$title $sep $site_description";
    }

    // Add a page number if necessary.
    if ( $paged >= 2 || $page >= 2 ) {
        $title = "$title $sep " . sprintf( __( 'Page %s', 'plumtree' ), max( $paged, $page ) );
    }

    return $title;
}
add_filter( 'wp_title', 'cb_wp_title', 10, 2 );

function hidden_menu_show() {
    if ( get_option('hidden_panel') == 'on') :
    ?>
    <script type="text/javascript">
    /* Waypoint */
    jQuery(function($) {

            enquire.register("screen and (min-width: 1024px)", {

                match: function() {

                    $('header.site-header').waypoint('sticky', {
                        stuckClass: 'stuck',
                        wrapper: '<div class="sticky-wrapper" />',
                        offset: function(){
                            return - ($(this).height() * 2);
                        }
                    });

                    $('header.site-header').waypoint(function(direction){
                        if (direction === 'down'){
                            $('header.site-header').hide();$('body').addClass('header-stuck'); $('header.site-header').fadeIn(500);   }
                        else { $('body').removeClass('header-stuck');  }
                    }, {
                        offset: function(){
                            return - ($(this).height() * 2);
                        }
                    });

                },
                unmatch: function() {

                }

            });
    });

    </script> <?php
 endif;  // This depends on jquery

}
add_action('wp_footer', 'hidden_menu_show');
