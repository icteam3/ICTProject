<?php 
/*
*   Custom menu walker Class
*	Adds additional css classes to enable bootstrap and superfish menus
*
*
*/

class PTMenuWalker extends Walker_Nav_Menu {

	var $prefix = '';
	
	function __construct($prf = ''){
		$this->prefix = $prf;
	}
	  
// add classes to ul sub-menus
	function start_lvl( &$output, $depth = 0, $args = array() ) {
	    // depth dependent classes
	    $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
	    $display_depth = ( $depth + 1); // because it counts the first submenu as 0
	    $classes = array(
	        'dropdown',
	        ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
	        ( $display_depth >=2 ? 'subdropdown' : '' ),
	        'menu-depth-' . $display_depth
	        );
        $class_names = implode( ' ', $classes );
    	    // build html

        $offset = isset($args->m_offset) ? $args->m_offset : 100;
        $banner = isset($args->m_banner) ? $args->m_banner : '';

	    $output .= "\n" . $indent . '<ul class="' . $class_names . '" '.($offset !== 0 ? 'data-offset="'.$offset.'"' : '') .' '.($banner != '' ? 'style="background:url('.$banner.') top right no-repeat;"' : '').' >' . "\n";
	}
  
// add main/sub classes to li's and links
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0  ) {
	    global $wp_query;
	    $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
	  
	    // depth dependent classes
	    $depth_classes = array(
	        ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
	        ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
	        ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
	        'menu-item-depth-' . $depth
	    );
	    $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );
	  
	    // passed classes
	    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
	    
	    $cur_item_index = -1;
	    
	    
	    
	    if ($cur_item_index = array_search('current_page_item', $classes)) {
		    
		    $classes[$cur_item_index] = 'active';
		    
	    }
	    
	    $parent_item_index = -1;
	    
	    if ($parent_item_index = array_search('dropdown', $classes)) {
		   if ($depth >= 1)  $classes[$parent_item_index] = 'submenu';
	    }
	    
	    $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
	    
	    // build html
	    $output .= $indent . '<li id="'.$this->prefix.'_nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . ' '.( $item->megamenu == 1 ? " mega-menu " : "" ).' '.( $item->icon != '' ? " menu-icon " : "" ).' ">';
		
	    // link attributes
	    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
	    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
	    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
	    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
	
	    $attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . ' "';
	    
	    if (isset($args) && is_object($args)) 	  	
	    	  	    
	    $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
	        $args->before,
	        $attributes,
	        $args->link_before,
	        apply_filters( 'the_title', $item->title, $item->ID ),
	        $args->link_after,
	        $args->after
	    ); 
	    
	    else 
	
	    $item_output = sprintf( '<a%1$s>%2$s</a>',
	        $attributes,
	        apply_filters( 'the_title', $item->title, $item->ID )
	    );
	    
	    if ('' !== $item->title)
	    	$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	    else $output = ''; 
	}
	
	function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {

		if ( !$element )
			return;

		$id_field = $this->db_fields['id'];

		//display this element
		if ( isset( $args[0] ) && is_array( $args[0] ) )
			$args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array($this, 'start_el'), $cb_args);

		$id = $element->$id_field;

		// descend only when the depth is right and there are childrens for this element
		if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {

			foreach( $children_elements[ $id ] as $child ){

				if ( !isset($newlevel) ) {
					$newlevel = true;
					//start the child delimiter
                    if ($args[0]->theme_location == 'primary-aside') {

                        if (isset($element->icon) && $element->icon != '' && ($depth == 0) && ($element->megamenu == 1)){
                            $args[0]->m_banner = $element->icon;
                            $args[0]->m_offset = $element->megamenu_offset;
                        } else {
                            $args[0]->m_banner = '';
                            $args[0]->m_offset = 0;
                        }
                    }
					$cb_args = array_merge( array(&$output, $depth), $args);
					call_user_func_array(array($this, 'start_lvl'), $cb_args);
				}
				$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
			}
			unset( $children_elements[ $id ] );
		}

		if ( isset($newlevel) && $newlevel ){
			//end the child delimiter
			$cb_args = array_merge( array(&$output, $depth), $args);

            if (isset($element->megamenu_text) && $element->megamenu_text != '' && ($depth == 0) && ($element->megamenu == 1)){
                $output .= '<li class="mm-banner"><a href="'.$element->link.'">'.$element->megamenu_text.'</a></li>';
            }
			
			call_user_func_array(array($this, 'end_lvl'), $cb_args);
		}

		//end this element
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array($this, 'end_el'), $cb_args);
	}  
	
}


class PTMenuWalkerDL extends Walker_Nav_Menu {

	var $prefix = '';
	
	function __construct($prf = ''){
		$this->prefix = $prf;
	}
	  
// add classes to ul sub-menus
	function start_lvl( &$output, $depth = 0, $args = array() ) {
	    // depth dependent classes
	    $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
	    $display_depth = ( $depth + 1); // because it counts the first submenu as 0
	    $classes = array(
	        'dl-submenu',
	        ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
	        ( $display_depth >=2 ? 'dl-submenu' : '' ),
	        'menu-depth-' . $display_depth
	        );
	    $class_names = implode( ' ', $classes );
	  
	    // build html
	    $output .= "\n" . $indent . '<ul class="' . $class_names . '"><li class="dl-back"><a href="#">'.__('back', 'plumtree').'</a></li>' . "\n";
	}
  
// add main/sub classes to li's and links
	function start_el( &$output, $item, $depth = 0, $args = array() , $current_object_id = 0 ) {
	    global $wp_query;
	    $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
	  
	    // depth dependent classes
	    $depth_classes = array(
	        ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
	        ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
	        ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
	        'menu-item-depth-' . $depth
	    );
	    $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );
	  
	    // passed classes
	    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
	    
	    $cur_item_index = -1;
	    
	    
	    
	    if ($cur_item_index = array_search('current_page_item', $classes)) {
		    
		    $classes[$cur_item_index] = 'active';
		    
	    }
	    
	    $parent_item_index = -1;
	    
	    if ($parent_item_index = array_search('dropdown', $classes)) {
		   if ($depth >= 1)  $classes[$parent_item_index] = 'submenu';
	    }
	    
	    $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
	    
	    // build html
	    $output .= $indent . '<li id="'.$this->prefix.'_nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';
	  
	    // link attributes
	    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
	    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
	    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
	    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
	    $attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';
	    
	    if (isset($args) && is_object($args)) 	  	
	    	  	    
	    $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
	        $args->before,
	        $attributes,
	        $args->link_before,
	        apply_filters( 'the_title', $item->title, $item->ID ),
	        $args->link_after,
	        $args->after
	    ); 
	    
	    else 
	
	    $item_output = sprintf( '<a%1$s>%2$s</a>',
	        $attributes,
	        apply_filters( 'the_title', $item->title, $item->ID )
	    );
	    
	    if ('' !== $item->title)
	    	$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	    else $output = ''; 
	}
}

// Add a "dropdown" class to <li> items with sub-menu

add_filter( 'wp_nav_menu_objects', 'add_has_children_to_nav_items' );

function add_has_children_to_nav_items( $items )
{
    
    
    
    $parents = wp_list_pluck( $items, 'menu_item_parent');
    $out     = array ();

    foreach ( $items as $item )
    {
        in_array( $item->ID, $parents ) && $item->classes[] = 'dropdown';
        $out[] = $item;
    }
    return $items;
}


/*---------------- Additional Fields -----------------*/

class ptCustomMenu{
	
	function __construct(){
		add_filter( 'wp_setup_nav_menu_item', array( $this, 'addFields' ) );
		add_action( 'wp_update_nav_menu_item', array( $this, 'updateFields' ), 10, 3 );
		add_filter( 'wp_edit_nav_menu_walker', array( $this, 'editWalker' ), 10, 2 );
		add_action( 'admin_print_scripts', array(&$this, 'loadAssets'));
	}
	
	
	function loadAssets(){
		 wp_enqueue_media();
	}
	
	function addFields($menuItem){
		$menuItem->megamenu = get_post_meta( $menuItem->ID, '_menu_item_megamenu', true );
		$menuItem->icon = get_post_meta( $menuItem->ID, '_menu_item_icon', true );
		$menuItem->link = get_post_meta( $menuItem->ID, '_menu_item_link', true );
		$menuItem->megamenu_text = get_post_meta( $menuItem->ID, '_menu_item_megamenu_text', true );
        $menuItem->megamenu_offset = get_post_meta( $menuItem->ID, '_menu_item_megamenu_offset', true );
		return $menuItem;
	}
	
	function updateFields( $menu_id, $menu_item_db_id, $args ) {

	    if ( isset($_REQUEST['menu-item-megamenu']) && is_array( $_REQUEST['menu-item-megamenu']) ) {
	       
	        $megamenu_value = isset($_REQUEST['menu-item-megamenu'][$menu_item_db_id]) ? true : false;
	
	        update_post_meta( $menu_item_db_id, '_menu_item_megamenu', $megamenu_value );
	
	    }
	    
	    if ( isset($_REQUEST['menu-item-icon']) && is_array( $_REQUEST['menu-item-icon']) ) {
	       
	        $icon_value = isset($_REQUEST['menu-item-icon'][$menu_item_db_id]) ? $_REQUEST['menu-item-icon'][$menu_item_db_id] : '';
	
	        update_post_meta( $menu_item_db_id, '_menu_item_icon', $icon_value );
	
	    }
	    
	    if ( isset($_REQUEST['menu-item-link']) && is_array( $_REQUEST['menu-item-link']) ) {
	       
	        $link_value = isset($_REQUEST['menu-item-link'][$menu_item_db_id]) ? $_REQUEST['menu-item-link'][$menu_item_db_id] : '';
	
	        update_post_meta( $menu_item_db_id, '_menu_item_link', $link_value );
	
	    }

	    if ( isset($_REQUEST['menu-item-megamenu-text']) && is_array( $_REQUEST['menu-item-megamenu-text']) ) {
	       
	        $text_value = isset($_REQUEST['menu-item-megamenu-text'][$menu_item_db_id]) ? $_REQUEST['menu-item-megamenu-text'][$menu_item_db_id] : '';
	
	        update_post_meta( $menu_item_db_id, '_menu_item_megamenu_text', $text_value );
	
	    }

        if ( isset($_REQUEST['menu-item-megamenu-offset']) && is_array( $_REQUEST['menu-item-megamenu-offset']) ) {

            $offset_value = isset($_REQUEST['menu-item-megamenu-offset'][$menu_item_db_id]) ? $_REQUEST['menu-item-megamenu-offset'][$menu_item_db_id] : '';

            update_post_meta( $menu_item_db_id, '_menu_item_megamenu_offset', $offset_value );

        }

    
   }
   
   function editWalker($walker,$menu_id) {
		
    	return 'Walker_Nav_Menu_Edit_Custom';

	}

	
}


include_once( 'pt-menuform.php' );

$GLOBALS['pt_custom_menu'] = new ptCustomMenu();

