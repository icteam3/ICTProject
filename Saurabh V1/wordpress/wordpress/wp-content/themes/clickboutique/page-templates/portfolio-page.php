<?php
/**
 * Template Name: Portfolio Page Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Plum_Tree
 * @since Plum Tree 0.1
 */


// Custom Gallery shortcode output

function pt_portfolio_gallery( $blank = NULL, $attr ) {

    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post ? $post->ID : 0,
        'itemtag'    => 'dl',
        'icontag'    => 'dt',
        'captiontag' => 'dd',
        'columns'    => 3,
        'size'       => 'pt-portfolio-thumb',
        'include'    => '',
        'exclude'    => '',
        'link'       => ''
    ), $attr, 'gallery'));

    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';

    if ( !empty($include) ) {
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( empty($attachments) )
        return '';

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }

    $itemtag = tag_escape($itemtag);
    $captiontag = tag_escape($captiontag);
    $icontag = tag_escape($icontag);
    $valid_tags = wp_kses_allowed_html( 'post' );
    if ( ! isset( $valid_tags[ $itemtag ] ) )
        $itemtag = 'dl';
    if ( ! isset( $valid_tags[ $captiontag ] ) )
        $captiontag = 'dd';
    if ( ! isset( $valid_tags[ $icontag ] ) )
        $icontag = 'dt';

    $columns = intval($columns);
    $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
    $float = is_rtl() ? 'right' : 'left';

    $selector = "portfolio-gallery";

    $gallery_style = $gallery_div = '';
    if ( apply_filters( 'use_default_gallery_style', true ) )
        $gallery_style = "
        <style type='text/css'>
            #{$selector} .gallery-item {
                float: {$float};
                width: {$itemwidth}%;
            }
            /* see gallery_shortcode() in wp-includes/media.php */
        </style>";
    $size_class = sanitize_html_class( $size );
    $gallery_div = "<div id='$selector' data-isotope='container' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";

    // Get isotope filters
    $filters = array();

    foreach ( $attachments as $id => $attachment ) {
        if ( !empty($attachment->portfolio_filter) ) {
            $filters = array_merge($filters, explode(',' ,$attachment->portfolio_filter));
        }
    }
            
    $filters_cleared = array();
            
    foreach($filters as $filter){
        array_push($filters_cleared, trim($filter));
    }
            
    $filters = array_unique($filters_cleared);
            
    $output_filters = '';
                        
    if (!empty($filters)) {
        
        $output_filters = '<ul data-isotope="filter" id="pt-image-filters" class="filter"><li data-filter="*" class="selected"><a href="#">'.__('All', 'plumtree').'</a></li>';
                
        foreach($filters as $filter){
            $output_filters .= '<li data-filter="'.strtolower($filter).'"><a href="#">'.$filter.'</a></li>';
        }
                
        $output_filters .= '</ul>';

    }

    $output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $output_filters . $gallery_div );

    $i = 0;
    foreach ( $attachments as $id => $attachment ) {
        if ( ! empty( $link ) && 'file' === $link )
            $image_output = wp_get_attachment_link( $id, $size, false, false );
        elseif ( ! empty( $link ) && 'none' === $link )
            $image_output = wp_get_attachment_image( $id, $size, false );
        else
            $image_output = wp_get_attachment_link( $id, $size, true, false );

        $image_meta  = wp_get_attachment_metadata( $id );

        // Adding special isotope attr
        $special_filters = get_post_meta( $id, 'portfolio_filter', true );

        $attr = '';

        if( ! empty( $special_filters ) ) {
            $arr = explode( ",", $special_filters);

            $special_filter_cleared = array();
            
            foreach($arr as $special_filter){
                array_push($special_filter_cleared, trim($special_filter));
            }

            $special_filters = implode(", ", $special_filter_cleared);

            $attr = strtolower( $special_filters );
        } 

        $orientation = '';
        if ( isset( $image_meta['height'], $image_meta['width'] ) )
            $orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';

        $output .= "<{$itemtag} class='gallery-item' data-element='" . $attr . "'>";
        $output .= "
            <{$icontag} class='gallery-icon {$orientation}'><i class='fa fa-search'></i>
                $image_output
            </{$icontag}>";
        if ( $captiontag && trim($attachment->post_title) ) {
            $output .= "
                <{$captiontag} class='portfolio-item-description'>
                <h3>" . wptexturize($attachment->post_title) . "</h3>";
                if ( !empty($attachment->post_content) ) {
                    $output .= "<div>" . wptexturize($attachment->post_content) . "</div>";
                }
                
            $output .= "</{$captiontag}>";
        }
        $output .= "</{$itemtag}>";
        if ( $columns > 0 && ++$i % $columns == 0 )
            $output .= '<br style="clear: both" />';
    }

    $output .= "
            <br style='clear: both;' />
        </div>\n";

    return $output;

}
add_filter( 'post_gallery', 'pt_portfolio_gallery', 10, 2);
?>

<?php get_header(); ?>

<?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>

    <?php 
        if ( (get_option('blog_spacer_bg_color') != '') && (get_option('blog_spacer_bg_color') != '#fff') ) {
            $spacer_bg = 'style="background:'.get_option('blog_spacer_bg_color').';"';
        } elseif ( get_option('blog_spacer_custom_pattern') != '' ) {
            $spacer_bg = 'style="background: url('.get_option('blog_spacer_custom_pattern').') repeat;"';
        } else {
            $spacer_bg = 'style="background: url('.get_template_directory_uri().'/assets/spacer-'.get_option('blog_spacer_default_pattern').'.png) repeat;"';
        }
    ?>

        <div class="spacer" <?php echo $spacer_bg; ?> data-stellar-background-ratio="0.5">
            <div class="container-fluid">
                <div class="row-fluid">
                    <h1 class="spacer-title" data-stellar-ratio="0.93"><?php the_title(); ?></h1>
                </div>
            </div>
        </div>

    <div class="container-fluid">
        <div class="row-fluid">

            <section id="content" role="main" class="site-content portfolio span12"><!-- Main content -->

                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div><!-- .entry-content -->
                    <?php endwhile; ?>
                <?php endif; ?>

            </section><!-- Main content -->

        </div>
    </div>

<?php get_footer(); ?>
