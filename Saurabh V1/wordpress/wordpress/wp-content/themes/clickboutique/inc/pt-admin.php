<?php 
/*  Loading the admin Panel  */
$panel = new PTPanel();
$panel->panelName = 'ClickBoutique Settings';
$panel->addPanelStyles('fonts', get_template_directory_uri().'/css/fonts.css');
$pt_colors = new PanelSectionFactory('pt-color', 'Color Settings', array(2, 0), 'Create your own color scheme for site in this panel');
$pt_header = new PanelSectionFactory('pt-global', 'Theme Settings', array(3, 1), 'Set global site options (logo, site description, main fonts, etc) in this panel');
$pt_layout = new PanelSectionFactory('pt-layout', 'Layout Settings', array(1, 0), 'Set global layout options for pages in this panel');
$pt_blog = new PanelSectionFactory('pt-blog', 'Blog Settings', array(3, 2), 'Modify sites Blog output');
$pt_store = new PanelSectionFactory('pt-store', 'Store Settings', array(1, 1), 'Modify sites Store output');
$panel->addSection($pt_header);
$panel->addSection($pt_colors);
$panel->addSection($pt_layout);
$panel->addSection($pt_blog);
$panel->addSection($pt_store);




/*  Global Settings Forms  */
$logo_upload_option = OptionFactory::create('site_logo_id',
	'site_logo',
	FieldType::$MEDIAUPLOAD,
	'pt-global',
	'Choose logo image',
	array('required' => false), 
false);

$logo_position_option = OptionFactory::create('site_logo_position_id',
	'site_logo_position',
	FieldType::$RADIOBUTTON,
	'pt-global',
	'Select logo position',
	array(
		'description' => 'You have to set Logo position in header',
		'required' => false,
		'default' => 'center',
		'options' => array(
			'left'  => 'Left',
			'right' => 'Right',
			'center' => 'Center'
		)
), false);

$transp_header = OptionFactory::create('transp_header_id',
    'transp_header',
    FieldType::$ONOFF,
    'pt-global',
    'Turn on/off transparent header',
    array(
        'default' => 'off',
        'description' => 'Switch to "On" if you want the header to be transparent'
    ),
    false);

$main_font_option = OptionFactory::create('main_font_id', 
	'main_font', 
	FieldType::$SELECT, 
	'pt-global', 
	'Select global theme font', array(
		'requiered' => false,
		'description' => 'Default for theme is "Lato"',
		'options' => array(
			'default' => 'Default',
			'lato' => 'Lato',
			'robotocondenced' => 'Roboto Condensed',
			'mavenpro' => 'Maven Pro',
			'monda' => 'Monda',
			'nexa' => 'Nexa',
			'opensans' => 'Open Sans',
			'merriweather' => 'Merriweather',
			'economica'  => 'Economica',
			'galdeano'   => 'Galdeano',
			'nixieone' => 'Nixie One',
			'actor' => 'Actor',
			'museo' => 'Museo',
			'ropasans' => 'Ropa Sans',
			'roboto' => 'Roboto',
			'quicksand' => 'Quicksand',
			'lovelo' => 'Lovelo'
	)
), false);

$heading_font_option = OptionFactory::create('heading_font_id',
	'heading_font', 
	FieldType::$SELECT, 
	'pt-global', 
	'Select font for headings in theme', array(
		'requiered' => false,
		'description' => 'Default for headings is "Lato"',
		'options' => array(
			'default' => 'Default',
			'lato' => 'Lato',
			'robotocondenced' => 'Roboto Condensed',
			'mavenpro' => 'Maven Pro',
			'monda' => 'Monda',
			'nexa' => 'Nexa',
			'opensans' => 'Open Sans',
			'merriweather' => 'Merriweather',
			'economica'  => 'Economica',
			'galdeano'   => 'Galdeano',
			'nixieone' => 'Nixie One',
			'actor' => 'Actor',
			'museo' => 'Museo',
			'ropasans' => 'Ropa Sans',
			'roboto' => 'Roboto',
			'quicksand' => 'Quicksand',
			'lovelo' => 'Lovelo'
	)
), false);

$menu_font_option = OptionFactory::create('menu_font_id',
	'menu_font', 
	FieldType::$SELECT, 
	'pt-global', 
	'Select menu font', array(
		'requiered' => false,
		'description' => 'Default for menu is "Roboto Condensed"',
		'options' => array(
			'default' => 'Default',
			'lato' => 'Lato',
			'robotocondenced' => 'Roboto Condensed',
			'mavenpro' => 'Maven Pro',
			'monda' => 'Monda',
			'nexa' => 'Nexa',
			'opensans' => 'Open Sans',
			'merriweather' => 'Merriweather',
			'economica'  => 'Economica',
			'galdeano'   => 'Galdeano',
			'nixieone' => 'Nixie One',
			'actor' => 'Actor',
			'museo' => 'Museo',
			'ropasans' => 'Ropa Sans',
			'roboto' => 'Roboto',
			'quicksand' => 'Quicksand',
			'lovelo' => 'Lovelo'
	)
), false);

$logo_font_option = OptionFactory::create('logo_font_id',
	'logo_font', 
	FieldType::$SELECT, 
	'pt-global', 
	'Select logo font', array(
		'requiered' => false,
		'description' => 'Default for menu is "Lato"',
		'options' => array(
			'default' => 'Default',
			'lato' => 'Lato',
			'robotocondenced' => 'Roboto Condensed',
			'mavenpro' => 'Maven Pro',
			'monda' => 'Monda',
			'nexa' => 'Nexa',
			'opensans' => 'Open Sans',
			'merriweather' => 'Merriweather',
			'economica'  => 'Economica',
			'galdeano'   => 'Galdeano',
			'nixieone' => 'Nixie One',
			'actor' => 'Actor',
			'museo' => 'Museo',
			'ropasans' => 'Ropa Sans',
			'roboto' => 'Roboto',
			'quicksand' => 'Quicksand',
			'lovelo' => 'Lovelo'
	)
), false);

$menu_color_option = OptionFactory::create('menu_color_id',
	'menu_color',
	FieldType::$COLORPICKER,
	'pt-header',
	'Set main menu color',
	array('required' => false,
		  'description' => 'Default: #454544'), 
false);

/*$menu_decor_color_option = OptionFactory::create('menu_decor_color_id',
	'menu_decor_color',
	FieldType::$COLORPICKER,
	'pt-header',
	'Set color for main menu on hover',
	array('required' => false,
		'description' => 'Color on hover effects for main menu items. Default: #849EC1'), 
false);*/
	
$logo_color_option = OptionFactory::create('logo_color_id',
	'logo_color',
	FieldType::$COLORPICKER,
	'pt-header',
	'Set logo color',
	array('required' => false,
		  'description' => 'Default: #000' ), 

false);

$hidden_panel_option = OptionFactory::create('hidden_panel_id',
		'hidden_panel',
		FieldType::$ONOFF,
		'pt-global',
		'Hidden panel view switcher',
			array(
			'default' => 'on',
			'description' => 'Switch to "Off" if you don&rsquo;t want to use hidden navi panel'
		),
false);

$site_copyright_option = OptionFactory::create('site_copyright_id', 
	'site_copyright', 
	FieldType::$TEXTAREA, 
	'pt-global', 
	'Enter sites copyright', 
	array('description' => 'Enter copyright (appears at the bottom of site)'), 
false);


/*  Global  Settings Output  */
$header_content = '<div class="wrapper container-fluid"><div class="row-fluid">'
.'<div class="span6">'
.'<h1>Menu and Logo</h1>'
.$menu_font_option
.$menu_color_option
//.$menu_decor_color_option
.$logo_font_option
.$logo_color_option
.$logo_upload_option
.$logo_position_option
.'</div>'
.'<div class="span6">'
.'<h1>Global Theme Options</h1>'
.$main_font_option
.$transp_header
.$heading_font_option
.$site_copyright_option
.$hidden_panel_option
.'</div>'
.'</div></div>';


/*  Colors Settings Forms  */
$main_color_option = OptionFactory::create('main_color_id',
	'main_color',
	FieldType::$COLORPICKER,
	'pt-colors',
	'Set global text color',
	array('required' => false,
		  'description' => 'Default: #7D7D7D' ), 
false);

$headings_content_option = OptionFactory::create('headings_content_id',
	'headings_content',
	FieldType::$COLORPICKER,
	'pt-colors',
	'Set color for headings in content zone',
	array('required' => false,
		  'description' => 'Default: #000'), 
false);

$headings_sidebar_option = OptionFactory::create('headings_sidebar_id',
	'headings_sidebar',
	FieldType::$COLORPICKER,
	'pt-colors',
	'Set color for headings in sidebar zone',
	array('required' => false,
		  'description' => 'Default: #000'), 
false);

$headings_footer_option = OptionFactory::create('headings_footer_id',
	'headings_footer',
	FieldType::$COLORPICKER,
	'pt-colors',
	'Set color for headings in footer zone',
	array('required' => false,
		  'description' => 'Default: #000'), 
false);

$headings_first_word_option = OptionFactory::create('headings_first_word_id',
	'headings_first_word',
	FieldType::$COLORPICKER,
	'pt-colors',
	'Set color for 1st word in headings',
	array('required' => false,
		  'description' => 'Default: #91A9C7'), 
false);

$link_color_option = OptionFactory::create('link_color_id',
	'link_color',
	FieldType::$COLORPICKER,
	'pt-colors',
	'Set color for links',
	array('required' => false,
		'description' => 'Default: #454544'), 
false);

$link_color_hover_option = OptionFactory::create('link_color_hover_id',
	'link_color_hover',
	FieldType::$COLORPICKER,
	'pt-colors',
	'Set link color on hover',
	array('required' => false,
		'description' => 'Default: #7790B1'), 
false);

$button_color_option = OptionFactory::create('button_color_id',
	'button_color',
	FieldType::$COLORPICKER,
	'pt-colors',
	'Set bg color for buttons',
	array('required' => false,
		'description' => 'Default: #454544'), 
false);

$button_color_hover_option = OptionFactory::create('button_color_hover_id',
	'button_color_hover',
	FieldType::$COLORPICKER,
	'pt-colors',
	'Set button bg color on hover',
	array('required' => false,
		'description' => 'Default: #849EC1'), 
false);

$button_color_text_option = OptionFactory::create('button_color_text_id',
	'button_color_text',
	FieldType::$COLORPICKER,
	'pt-colors',
	'Set button text color',
	array('required' => false,
		'description' => 'Default: #FFF'), 
false);

/*  Global  Settings Output  */
$colors_content = '<div class="wrapper container-fluid"><div class="row-fluid">'
.'<div class="span6">'
.'<h1>Advanced Color Options</h1>'
.$main_color_option
.$headings_content_option
.$headings_sidebar_option
.$headings_footer_option
.$headings_first_word_option
.'</div>'
.'<div class="span6">'
.'<h1>Links and Buttons</h1>'
.$link_color_option
.$link_color_hover_option
.$button_color_option
.$button_color_hover_option
.$button_color_text_option
.'</div>'
.'</div></div>';


/*  Layout Settings Forms  */
$frontpage_layout_option = OptionFactory::create('home_layout_id',
	'front_layout',
	FieldType::$COLLECTION,
	'pt-layout',
	'Set Front page layout',
	array(
		'required' => false,
		'description' => 'Specify the location of sidebars about the content on the front page',
		'default' => 'two-col-left',
		'options'   => array(
			array('value' => 'one-col', 'label' => '1 Column (no sidebars)', 'icon' => get_template_directory_uri().'/assets/one-col.png'),
			array('value' => 'two-col-left', 'label' => '2 Columns, sidebar on left', 'icon' => get_template_directory_uri().'/assets/two-col-left.png'),
			array('value' => 'two-col-right', 'label' => '2 Columns, sidebar on right', 'icon' => get_template_directory_uri().'/assets/two-col-right.png') )
), false);

$page_layout_option = OptionFactory::create('page_layout_id',
	'page_layout',
	FieldType::$COLLECTION,
	'pt-layout',
	'Set global layout for Pages',
	array(
		'required' => false,
		'description' => 'Specify the location of sidebars about the content on the Pages of your site',
		'default' => 'two-col-left',
		'options'   => array(
			array('value' => 'one-col', 'label' => '1 Column (no sidebars)', 'icon' => get_template_directory_uri().'/assets/one-col.png'),
			array('value' => 'two-col-left', 'label' => '2 Columns, sidebar on left', 'icon' => get_template_directory_uri().'/assets/two-col-left.png'),
			array('value' => 'two-col-right', 'label' => '2 Columns, sidebar on right', 'icon' => get_template_directory_uri().'/assets/two-col-right.png') )
), false);

$blog_layout_option = OptionFactory::create('blog_layout_id',
	'blog_layout',
	FieldType::$COLLECTION,
	'pt-layout',
	'Set Blog page layout',
	array(
		'required' => false,
		'description' => 'Specify the location of sidebars about the content on the Blog page',
		'default' => 'two-col-left',
		'options'   => array(
			array('value' => 'one-col', 'label' => '1 Column (no sidebars)', 'icon' => get_template_directory_uri().'/assets/one-col.png'),
			array('value' => 'two-col-left', 'label' => '2 Columns, sidebar on left', 'icon' => get_template_directory_uri().'/assets/two-col-left.png'),
			array('value' => 'two-col-right', 'label' => '2 Columns, sidebar on right', 'icon' => get_template_directory_uri().'/assets/two-col-right.png') )
), false);

$single_layout_option = OptionFactory::create('single_layout_id',
	'single_layout',
	FieldType::$COLLECTION,
	'pt-layout',
	'Set Single post view layout',
	array(
		'required' => false,
		'description' => 'Specify the location of sidebars about the content on the single posts',
		'default' => 'two-col-left',
		'options'   => array(
			array('value' => 'one-col', 'label' => '1 Column (no sidebars)', 'icon' => get_template_directory_uri().'/assets/one-col.png'),
			array('value' => 'two-col-left', 'label' => '2 Columns, sidebar on left', 'icon' => get_template_directory_uri().'/assets/two-col-left.png'),
			array('value' => 'two-col-right', 'label' => '2 Columns, sidebar on right', 'icon' => get_template_directory_uri().'/assets/two-col-right.png') )
), false);

$taxonomy_layout_option = OptionFactory::create('taxonomy_layout_id',
	'archive_layout',
	FieldType::$COLLECTION,
	'pt-layout',
	'Set Taxonomy pages layout',
	array(
		'required' => false,
		'default' => 'two-col-left',
		'description' => 'Specify the location of sidebars about the content on the taxonomy pages (archives, tags, categories, etc)',
		'options'   => array(
			array('value' => 'one-col', 'label' => '1 Column (no sidebars)', 'icon' => get_template_directory_uri().'/assets/one-col.png'),
			array('value' => 'two-col-left', 'label' => '2 Columns, sidebar on left', 'icon' => get_template_directory_uri().'/assets/two-col-left.png'),
			array('value' => 'two-col-right', 'label' => '2 Columns, sidebar on right', 'icon' => get_template_directory_uri().'/assets/two-col-right.png') )
), false);

$shop_layout_option = OptionFactory::create('shop_layout_id',
	'shop_layout',
	FieldType::$COLLECTION,
	'pt-layout',
	'Set Products page (Shop page) layout',
	array(
		'required' => false,
		'default' => 'two-col-left',
		'description' => 'Specify the location of sidebars about the content on the products page',
		'options'   => array(
			array('value' => 'one-col', 'label' => '1 Column (no sidebars)', 'icon' => get_template_directory_uri().'/assets/one-col.png'),
			array('value' => 'two-col-left', 'label' => '2 Columns, sidebar on left', 'icon' => get_template_directory_uri().'/assets/two-col-left.png'),
			array('value' => 'two-col-right', 'label' => '2 Columns, sidebar on right', 'icon' => get_template_directory_uri().'/assets/two-col-right.png') )
), false);

$product_layout_option = OptionFactory::create('product_layout_id',
	'product_layout',
	FieldType::$COLLECTION,
	'pt-layout',
	'Set Single Product pages layout',
	array(
		'required' => false,
		'default' => 'two-col-left',
		'description' => 'Specify the location of sidebars about the content on the single product pages',
		'options'   => array(
			array('value' => 'one-col', 'label' => '1 Column (no sidebars)', 'icon' => get_template_directory_uri().'/assets/one-col.png'),
			array('value' => 'two-col-left', 'label' => '2 Columns, sidebar on left', 'icon' => get_template_directory_uri().'/assets/two-col-left.png'),
			array('value' => 'two-col-right', 'label' => '2 Columns, sidebar on right', 'icon' => get_template_directory_uri().'/assets/two-col-right.png') )
), false);

/*  Layout Settings Output  */
$layout_content = '<div class="wrapper container-fluid"><div class="row-fluid">'
.'<div class="span6">'
.'<h1>Blog Layout Options</h1>'
.$frontpage_layout_option
.$page_layout_option
.$blog_layout_option
.$single_layout_option
.$taxonomy_layout_option
.'</div>'
.'<div class="span6">'
.'<h1>Store Layout Options</h1>'
.$shop_layout_option
.$product_layout_option
.'</div>'
.'</div></div>';


/*  Blog Settings  */
$posts_pagination_option = OptionFactory::create('posts_pagination_id',
	'posts_pagination',
	FieldType::$ONOFF,
	'pt-blog',
	'Single post pagination switcher',
		array(
		'default' => 'on',
		'description' => 'Switch to "Off" if you don&rsquo;t want to use posts pagination (Older/Newer posts)'
	),
false);

$blog_pagination_option = OptionFactory::create('blog_pagination_id',
	'blog_pagination',
	FieldType::$RADIOBUTTON,
	'pt-blog',
	'Select pagination view for blog page',
	array(
		'description' => '',
		'required' => false,
		'default' => 'numeric',
		'options' => array(
			'getmore'  => '&quot;Get More&quot; button',
			'numeric' => 'Numeric pagination',
		)
), false);

$comments_pagination_option = OptionFactory::create('comments_pagination_id',
	'comments_pagination',
	FieldType::$RADIOBUTTON,
	'pt-blog',
	'Select pagination view for comments',
	array(
		'description' => '',
		'required' => false,
		'default' => 'numeric',
		'options' => array(
			'newold'  => 'Newer/Older pagination',
			'numeric' => 'Numeric pagination',
		)
), false);

$blog_pagenavi_counter_option = OptionFactory::create('blog_pagenavi_counter_id',
	'blog_pagenavi_counter',
	FieldType::$ONOFF,
	'pt-blog',
	'Blog numeric pagination counter switcher',
		array(
		'default' => 'on',
		'description' => 'Switch to "Off" if you don&rsquo;t want to use counter (Page {current} of {last})'
	),
false);

$blog_pagenavi_qty_option = OptionFactory::create('blog_pagenavi_qty_id', 
	'blog_pagenavi_qty', 
	FieldType::$NUMBER, 
	'pt-blog', 
	'Set quantity of links for pagination', 
		array('description' => ''), 
false);

$blog_pagenavi_step_option = OptionFactory::create('blog_pagenavi_step_id', 
	'blog_pagenavi_step', 
	FieldType::$NUMBER, 
	'pt-blog', 
	'Set step of links for pagination', 
		array('description' => 'Example: step = 10  => 1,2,3 ... 10,20,30'), 
false);

$blog_pagenavi_intermidiate_text_option = OptionFactory::create('blog_pagenavi_intermidiate_text_id', 
	'blog_pagenavi_intermidiate_text', 
	FieldType::$TEXT, 
	'pt-blog', 
	'Enter intermediate text for links', 
	array('description' => 'Example: 1,2,3{intermediate text}10,11. Default: " ... "'), 
false);

$blog_pagenavi_previous_text_option = OptionFactory::create('blog_pagenavi_previous_text_id', 
	'blog_pagenavi_previous_text', 
	FieldType::$TEXT, 
	'pt-blog', 
	'Enter "Previous page" text', 
	array('description' => 'Default: "font awesome arrow"'), 
false);

$blog_pagenavi_next_text_option = OptionFactory::create('blog_pagenavi_next_text_id', 
	'blog_pagenavi_next_text', 
	FieldType::$TEXT, 
	'pt-blog', 
	'Enter "Next page" text', 
	array('description' => 'Default: "font awesome arrow"'), 
false);

$blog_pagenavi_first_text_option = OptionFactory::create('blog_pagenavi_first_text_id', 
	'blog_pagenavi_first_text', 
	FieldType::$TEXT, 
	'pt-blog', 
	'Enter "First page" text', 
	array('description' => 'Default: " "'), 
false);

$blog_pagenavi_last_text_option = OptionFactory::create('blog_pagenavi_last_text_id', 
	'blog_pagenavi_last_text', 
	FieldType::$TEXT, 
	'pt-blog', 
	'Enter "Last page" text', 
	array('description' => 'Default: " "'), 
false);

$blog_spacer_bg_color_option = OptionFactory::create('blog_spacer_bg_color_id',
	'blog_spacer_bg_color',
	FieldType::$COLORPICKER,
	'pt-blog',
	'Set background color for blog header spacer',
	array('required' => false,
		  'description' => 'For transparent bg choose #fff' ), 
false);

$blog_spacer_custom_pattern_option = OptionFactory::create('blog_spacer_custom_pattern_id',
	'blog_spacer_custom_pattern',
	FieldType::$MEDIAUPLOAD,
	'pt-blog',
	'Upload custom pattern for blog spacer',
	array('required' => false), 
false);

$blog_spacer_default_pattern_option = OptionFactory::create('blog_spacer_default_pattern_id',
	'blog_spacer_default_pattern',
	FieldType::$COLLECTION,
	'pt-blog',
	'Set pattern for blog spacer',
	array(
		'required' => false,
		'description' => '',
		'default' => 'pattern1',
		'options'   => array(
			array('value' => 'pattern2', 'label' => 'Set background for header spacer from default patterns', 'icon' => get_template_directory_uri().'/assets/spacer-pattern2.png'),
			array('value' => 'pattern3', 'label' => 'Set background for header spacer from default patterns', 'icon' => get_template_directory_uri().'/assets/spacer-pattern3.png'),
			array('value' => 'pattern4', 'label' => 'Set background for header spacer from default patterns', 'icon' => get_template_directory_uri().'/assets/spacer-pattern4.png'),
			array('value' => 'pattern5', 'label' => 'Set background for header spacer from default patterns', 'icon' => get_template_directory_uri().'/assets/spacer-pattern5.png'),
			array('value' => 'pattern6', 'label' => 'Set background for header spacer from default patterns', 'icon' => get_template_directory_uri().'/assets/spacer-pattern6.png') 
			)
), false);

$post_breadcrumbs_option = OptionFactory::create('post_breadcrumbs_id',
	'post_breadcrumbs',
	FieldType::$ONOFF,
	'pt-blog',
	'Single post breadcrumbs switcher',
		array(
		'default' => 'on',
		'description' => 'Switch to "Off" if you don&rsquo;t want to use breadcrumbs on Single post view'
	),
false);

$blog_read_more_text_option = OptionFactory::create('blog_read_more_text_id', 
	'blog_read_more_text', 
	FieldType::$TEXT, 
	'pt-blog', 
	'Enter text for "Read More" button', 
	array('description' => ''), 
false);

$blog_isotope_layout_option = OptionFactory::create('blog_isotope_layout_id',
	'blog_isotope_layout',
	FieldType::$RADIOBUTTON,
	'pt-blog',
	'Select layout for blog',
	array(
		'description' => '',
		'required' => false,
		'default' => 'list',
		'options' => array(
			'list'  => 'List',
			'grid' => 'Grid',
			'isotope' => 'Isotope with filters'
		)
), false);

$blog_isotope_filters_option = OptionFactory::create('blog_isotope_filters_id',
	'blog_isotope_filters',
	FieldType::$RADIOBUTTON,
	'pt-blog',
	'Select what taxonomy will be used for blog filters',
	array(
		'description' => 'Required if blog layout set to &rsquo;Isotope with filters&rsquo;',
		'required' => false,
		'default' => 'cats',
		'options' => array(
			'cats'  => 'Categories',
			'tags' => 'Tags',
		)
), false);


/*  Blog Settings Output  */
$blog_content = '<div class="wrapper container-fluid"><div class="row-fluid">'
.'<div class="span6">'
.'<h1>Blog Advanced Options</h1>'
.$blog_pagination_option
.$blog_read_more_text_option
.$blog_isotope_layout_option
.$blog_isotope_filters_option
.'<br /><br />'
.'<p><strong>Advanced options for blog numeric pagination</strong></p>'
.$blog_pagenavi_counter_option
.$blog_pagenavi_qty_option
.$blog_pagenavi_step_option
.$blog_pagenavi_intermidiate_text_option
.$blog_pagenavi_previous_text_option
.$blog_pagenavi_next_text_option
.$blog_pagenavi_first_text_option
.$blog_pagenavi_last_text_option
.'</div>'
.'<div class="span6">'
.'<h1>Header Spacer Options</h1>'
.'<p>Here you can chose header spacer look. You may chose among default patterns, upload your custom pattern or pick a background color.</p>'
.$blog_spacer_default_pattern_option
.$blog_spacer_custom_pattern_option
.$blog_spacer_bg_color_option
.'<br /><br />'
.'<h1>Single Post Options</h1>'
.$posts_pagination_option
.$post_breadcrumbs_option
.$comments_pagination_option
.'</div>'
.'</div></div>';


/*  Store Settings  */

$store_per_page_option = OptionFactory::create('store_per_page_id', 
	'store_per_page', 
	FieldType::$NUMBER, 
	'pt-store', 
	'Enter number of products to show on Products page', 
		array('description' => ''), 
false);

$catalog_mode = OptionFactory::create('catalog_mode_id',
    'catalog_mode',
    FieldType::$ONOFF,
    'pt-shop',
    'Catalog Mode ON/OFF',
    array(
        'default' => 'off',
        'description' => 'Switch to "ON" if you want to switch your shop into a catalog mode'
    ),
    false
);

$new_badge = OptionFactory::create('new_badge_id',
    'new_badge',
    FieldType::$ONOFF,
    'pt-shop',
    'New Product Badge ON/OFF',
    array(
        'default' => 'off',
        'description' => 'Switch to "ON" if you want to show a "New Product Badge" on product listing'
    ),
    false
);

$new_product_days = OptionFactory::create('new_product_days_id',
    'new_product_days',
    FieldType::$NUMBER,
    'pt-shop',
    'Set the number of dates while product is considered new',
    array('description' => ''),
false);

$cart_count = OptionFactory::create('cart_count_id',
    'cart_count',
    FieldType::$ONOFF,
    'pt-shop',
    'Show number of products in the cart ON/OFF',
    array(
        'default' => 'off',
        'description' => 'Switch to "ON" if you want to show a a number of products currently in the cart'
    ),
    false
);

$store_breadcrumbs_option = OptionFactory::create('store_breadcrumbs_id',
		'store_breadcrumbs',
		FieldType::$ONOFF,
		'pt-store',
		'Store Breadcrumbs view switcher',
			array(
			'default' => 'on',
			'description' => 'Switch to "Off" if you don&rsquo;t want to use breadcrumbs on store page'
		),
false);

$product_pagination_option = OptionFactory::create('product_pagination_id',
		'product_pagination',
		FieldType::$ONOFF,
		'pt-store',
		'Single Product pagination (prev/next product) view switcher',
			array(
			'default' => 'on',
			'description' => 'Switch to "Off" if you don&rsquo;t want to use single pagination on product page'
		),
false);

$store_spacer_bg_color_option = OptionFactory::create('store_spacer_bg_color_id',
	'store_spacer_bg_color',
	FieldType::$COLORPICKER,
	'pt-store',
	'Set background color for store header spacer',
	array('required' => false,
		  'description' => 'For transparent bg choose #fff' ), 
false);

$store_spacer_custom_pattern_option = OptionFactory::create('store_spacer_custom_pattern_id',
	'store_spacer_custom_pattern',
	FieldType::$MEDIAUPLOAD,
	'pt-store',
	'Upload custom pattern for store header spacer',
	array('required' => false), 
false);

$store_spacer_default_pattern_option = OptionFactory::create('store_spacer_default_pattern_id',
	'store_spacer_default_pattern',
	FieldType::$COLLECTION,
	'pt-store',
	'Set pattern for store header spacer',
	array(
		'required' => false,
		'description' => '',
		'default' => 'pattern1',
		'options'   => array(
			array('value' => 'pattern2', 'label' => 'Set background for header spacer from default patterns', 'icon' => get_template_directory_uri().'/assets/spacer-pattern2.png'),
			array('value' => 'pattern3', 'label' => 'Set background for header spacer from default patterns', 'icon' => get_template_directory_uri().'/assets/spacer-pattern3.png'),
			array('value' => 'pattern4', 'label' => 'Set background for header spacer from default patterns', 'icon' => get_template_directory_uri().'/assets/spacer-pattern4.png'),
			array('value' => 'pattern5', 'label' => 'Set background for header spacer from default patterns', 'icon' => get_template_directory_uri().'/assets/spacer-pattern5.png'),
			array('value' => 'pattern6', 'label' => 'Set background for header spacer from default patterns', 'icon' => get_template_directory_uri().'/assets/spacer-pattern6.png') 
			)
), false);

$use_product_image_gallery = OptionFactory::create('product_image_gallery_id',
		'use_product_image_gallery',
		FieldType::$ONOFF,
		'pt-store',
		'Wether to use sliding gallery',
			array(
			'default' => 'on',
			'description' => 'Switch to "Off" if you don&rsquo;t want to use image gallery on the products page'
		)
);

$store_banner_option = OptionFactory::create('store_banner_id',
		'store_banner',
		FieldType::$ONOFF,
		'pt-store',
		'Store Banner view switcher',
			array(
			'default' => 'on',
			'description' => 'Switch to "Off" if you don&rsquo;t want to use banner on store page'
		),
false);

$store_banner_img_option = OptionFactory::create('store_banner_img_id',
	'store_banner_img',
	FieldType::$MEDIAUPLOAD,
	'pt-store',
	'Upload banner image',
	array('required' => false), 
false);

$store_banner_title_option = OptionFactory::create('store_banner_title_id', 
	'store_banner_title', 
	FieldType::$TEXT, 
	'pt-store', 
	'Enter a title for banner', 
		array('description' => ''), 
false);

$store_banner_description_option = OptionFactory::create('store_banner_description_id', 
	'store_banner_description', 
	FieldType::$TEXT, 
	'pt-store', 
	'Enter a description for banner', 
		array('description' => ''), 
false);

$store_banner_url_option = OptionFactory::create('store_banner_url_id', 
	'store_banner_url', 
	FieldType::$TEXT, 
	'pt-store', 
	'Enter an url for banner', 
		array('description' => 'Where you&rsquo;d like the banner to link to. If you leave this field blank the banner will not link anywhere.'), 
false);

$store_banner_button_text_option = OptionFactory::create('store_banner_button_text_id', 
	'store_banner_button_text', 
	FieldType::$TEXT, 
	'pt-store', 
	'Enter banner button text', 
		array('description' => ''), 
false);

$store_banner_text_position_option = OptionFactory::create('store_banner_text_position_id',
	'store_banner_text_position',
	FieldType::$RADIOBUTTON,
	'pt-store',
	'Select baner text position',
	array(
		'required' => false,
		'default' => 'left',
		'options' => array(
			'left'  => 'Left',
			'right' => 'Right',
		)
), false);

$store_banner_img_position_option = OptionFactory::create('store_banner_img_position_id',
	'store_banner_img_position',
	FieldType::$RADIOBUTTON,
	'pt-store',
	'Select banner img position',
	array(
		'required' => false,
		'default' => 'right',
		'options' => array(
			'left'  => 'Left',
			'right' => 'Right',
		)
), false);

$store_banner_custom_bg_option = OptionFactory::create('store_banner_custom_bg_id',
	'store_banner_custom_bg',
	FieldType::$MEDIAUPLOAD,
	'pt-store',
	'Upload custom background img for store banner',
	array('required' => false), 
false);

$product_hover_option = OptionFactory::create('product_hover_id',
	'product_hover',
	FieldType::$RADIOBUTTON,
	'pt-store',
	'Choose hover animation type for products',
	array(
		'required' => false,
		'default' => 'sliding-controls',
		'options' => array(
			'sliding-controls'  => 'Sliding from bottom',
			'fading-controls' => 'Full height fading',
		)
), false);

$checkout_steps_option = OptionFactory::create('checkout_steps_id',
	'checkout_steps',
	FieldType::$ONOFF,
	'pt-store',
	'Step-By-Step Checkout',
		array(
		'default' => 'on',
		'description' => 'Switch to "Off" if you don&rsquo;t want to use step-by-step checkout'
	),
false);

$list_grid_switcher_option = OptionFactory::create('list_grid_switcher_id',
	'list_grid_switcher',
	FieldType::$ONOFF,
	'pt-store',
	'List/Grid products switcher',
		array(
		'default' => 'on',
		'description' => 'Switch to "Off" if you don&rsquo;t want to use switcher on products page'
	),
false);

$add_to_cart_position_option = OptionFactory::create('add_to_cart_position_id',
	'add_to_cart_position',
	FieldType::$RADIOBUTTON,
	'pt-store',
	'"Add to cart" button position',
	array(
		'required' => false,
		'default' => 'grouped',
		'description' => 'Choose where to show "Add to cart" button.',
		'options' => array(
			'stand-alone'  => 'Under title',
			'grouped' => 'In hidden block',
		)
), false);

/*  Store Settings Output  */
$store_content = '<div class="wrapper container-fluid"><div class="row-fluid">'
.'<div class="span6">'
.'<h1>Shop parameters</h1>'
.$catalog_mode
.$new_badge
.$new_product_days
.$cart_count
.$list_grid_switcher_option
.$add_to_cart_position_option
.$checkout_steps_option
.$store_per_page_option
.$store_breadcrumbs_option
.$product_pagination_option
.$product_hover_option
.$use_product_image_gallery
.'</div>'
.'<div class="span6">'
.'<h1>Shop spacer options</h1>'
.'<p>Here you can chose header spacer look. You may chose among default patterns, upload your custom pattern or pick a background color.</p>'
.$store_spacer_default_pattern_option
.$store_spacer_custom_pattern_option
.$store_spacer_bg_color_option
.'<br /><br />'
.'<h1>Store banner parameters</h1>'
.$store_banner_option
.$store_banner_custom_bg_option
.$store_banner_img_option
//.$store_banner_img_position_option
.$store_banner_title_option
.$store_banner_description_option
.$store_banner_button_text_option
.$store_banner_url_option
.$store_banner_text_position_option
.'</div>'
.'</div></div>';


$pt_colors->setContent($colors_content);
$pt_header->setContent($header_content);
$pt_layout->setContent($layout_content);
$pt_blog->setContent($blog_content);
$pt_store->setContent($store_content);
