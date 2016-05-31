<?php
/**
 * JCK Settings Framework
 * 
 * @author James Kemp / Gilbitron / Alex Mukho
 * @link https://github.com/jamesckemp/JCK-Settings-Framework
 * @version 1.0.1
 * @license MIT
 */

if (!class_exists('JckSettingsFramework')) {

    class JckSettingsFramework {

        private $option_group;
        private $settings_name;
        private $settings;
        private $tabs = array();
        private $first_tab = false;
        private $options_path;
        private $options_url;
        private $admin_page_slug;

        /**
         * Constructor
         * 
         * @param string path to settings file
         * @param string optional "option_group" override
         */
        public function __construct( $settings_file, $admin_page_slug = '', $option_group = '' )
        {
            if( !is_file( $settings_file ) ) return;
				
            $this->settings = include( $settings_file );
            
            $this->options_path = plugin_dir_path( __FILE__ );
			$this->options_url = plugin_dir_url( __FILE__ );
            
            $this->option_group = preg_replace("/[^a-z0-9]+/i", "", basename($settings_file, '.php'));
            if ($option_group)
                $this->option_group = $option_group;
                
            $this->settings_name = $this->option_group.'_settings';
            
            $this->admin_page_slug = $admin_page_slug;
             
            add_action('admin_init', array($this, 'adminInit'));
            add_action('admin_enqueue_scripts', array($this, 'adminEnqueueScripts'));
        }
        
        /**
         * Get the option group for this instance
         * 
         * @return string the "option_group"
         */
        public function getOptionGroup()
        {
            return $this->option_group;
        }
        
        /**
         * Registers the internal WordPress settings
         */
        public function adminInit()
    	{
    		register_setting( $this->option_group, $this->settings_name, array($this, 'settingsValidate') );
			$this->processTabs();
    		$this->processSettings();
    	}
    	
    	/**
         * Enqueue scripts and styles
         */
        public function adminEnqueueScripts($hook_suffix)
    	{
    		if($hook_suffix == $this->admin_page_slug)
    		{
	            wp_enqueue_style('farbtastic');
	            wp_enqueue_style('thickbox');
	            
	            wp_enqueue_style( 
	            	'jcksf-admin-ui-css', 
					'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/themes/ui-darkness/jquery-ui.css'
				);
	            
	            wp_enqueue_script('jquery');
	            wp_enqueue_script('jquery-ui-core');
	            wp_enqueue_script('jquery-ui-datepicker');
	            wp_enqueue_script('farbtastic');
	            wp_enqueue_script('media-upload');
	            wp_enqueue_script('thickbox');
	            
	            wp_register_script( 'jckfw-timepicker', $this->options_url.'js/timepicker/jquery.ui.timepicker.js', array('jquery', 'jquery-ui-core'), false, true );
	            wp_enqueue_script( 'jckfw-timepicker' );
	            
	            wp_register_script( 'jckfw-scripts', $this->options_url.'js/scripts.js', array('jquery'), false, true );
	            wp_enqueue_script( 'jckfw-scripts' );
	            
	            wp_register_style( 'jckfw-styles', $this->options_url.'css/styles.css' );
				wp_enqueue_style( 'jckfw-styles' );
			}
    	}
    	
    	/**
         * Adds a filter for settings validation
         * 
         * @param array the un-validated settings
         * @return array the validated settings
         */
        public function settingsValidate( $input )
    	{    		
    		return apply_filters( $this->option_group .'_settings_validate', $input );
    	}
    	
    	/**
         * Displays the "section_description" if speicified in $settings
         *
         * @param array callback args from add_settings_section()
         */
        public function sectionIntro( $args )
    	{
        	if (isset($this->settings['sections']) && !empty($this->settings['sections']))
            {
        		foreach ($this->settings['sections'] as $section)
                {
                    if ($section['section_id'] == $args['id'])
                    {
                        if (isset($section['section_description']) && $section['section_description'])
                            echo '<p class="jckSectionDesc">'. $section['section_description'] .'</p>';

                        break;
                    }
        		}
            }
    	}

    /* 	==== Output the settings form ====  */
    
        public function displaySettings() 
        {
            do_action('jck_sf_before_settings'); 
            $this->displayTabs();
            ?>
            <form id="jck_sf" action="options.php" method="post">
            	<?php wp_nonce_field( 'update-options' ); ?>
                <?php settings_fields( $this->option_group ); ?>
                <?php $i = 0; foreach ( $this->tabs as $tab_key => $tab_caption ) { ?>
                	<div id="tab<?php echo $tab_key; ?>" class="jckTabs <?php if($i == 0) echo 'activeTab'; ?>">
                		<div class="postbox">
                			<?php do_settings_sections( $tab_key.'_settings' ); ?>
                		</div>
                	</div>
                <?php $i++; } ?>
                <?php submit_button(); ?>
            </form>            
            <?php

            do_action('jck_sf_after_settings');
        }
        
    /* 	==== Tabs ====  */
        
        function displayTabs() 
        {
		    $current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $this->first_tab;
		
		    screen_icon();
		    echo '<h2 class="nav-tab-wrapper">';
		    foreach ( $this->tabs as $tab_key => $tab_caption ) {
		        $active = $current_tab == $tab_key ? 'nav-tab-active' : '';
		        echo '<a class="nav-tab triggerTab ' . $active . '" href="#tab' . $tab_key . '">' . $tab_caption . '</a>';
		    }
		    echo '</h2>';
		}
		
	/* 	==== Process Tabs ====  */
	
		public function processTabs(){
			if (isset($this->settings['tabs']) && !empty($this->settings['tabs']))
			{
				foreach ($this->settings['tabs'] as $tab)
                {
                	if(!$this->first_tab) $this->first_tab = $tab['id'];
                    	
                	//register_setting( $this->option_group, $tab['id'] .'_settings', array($this, 'settingsValidate') );
                	$this->tabs[$tab['id']] = $tab['title'];
                }
			}
		}
    	
    	/**
         * Processes $settings and adds the sections and fields via the WordPress settings API
         */
        public function processSettings()
    	{    		
        	if (isset($this->settings['sections']) && !empty($this->settings['sections']))
            {
        	    // usort($this->settings['sections'], array($this, '_sortArray'));

        		foreach ($this->settings['sections'] as $section)
                {
            		if (isset($section['section_id']) && $section['section_id'] && isset($section['section_title']))
                    {
                    	
                		add_settings_section( $section['section_id'], $section['section_title'], array($this, 'sectionIntro'), $section['tab_id'] .'_settings' );

                		if (isset($section['fields']) && is_array($section['fields']) && !empty($section['fields']))
                        {
                    		foreach ($section['fields'] as $field)
                            {
                        		if (isset($field['id']) && $field['id'] && isset($field['title'])) {
                        			
                        			$theTitle = $field['title'];
                        			
                        			if(isset($field['subtitle']) && $field['subtitle'] != '') $theTitle .= ' <span class="subtitle">'.$field['subtitle'].'</span>';
                        			
                        		    add_settings_field( $field['id'], $theTitle, array($this, 'generateSetting'), $section['tab_id'] .'_settings', $section['section_id'], array('section' => $section, 'field' => $field) );
                        		    }
                    		}
                		}
            		}
        		}
    		}
    	}
    	
    	/**
         * Usort callback. Sorts $settings by "section_order"
         * 
         * @param mixed section order a
         * @param mixed section order b
         * @return int order
         */
        private function _sortArray( $a, $b )
    	{
        	return $a['section_order'] > $b['section_order'];
    	}
    	
    	/**
         * Generates the HTML output of the settings fields
         *
         * @param array callback args from add_settings_field()
         */
        public function generateSetting( $args )
    	{
    	    $section = $args['section'];
            $defaults = array(
        		'id' => 'default_field',
        		'title' => 'Default Field',
        		'subtitle' => '',
        		'desc' => '',
        		'default' => '',
        		'placeholder' => '',
        		'type' => 'text',
        		'choices' => array(),
        		'class' => '',
        		'labels' => '',
        		// For grouped fields
        		'subfields' => array(),
        		'parent_id' => false,
        		'row_num' => false,
        		'row_title' => '',
        		'format' => 'table',
        		'col_width' => 'medium',
        		// For Img Checkboxes
        		'show_labels' => false,
        		// For datetime
        		'show_date' => true,
        		'show_time' => true,
        		'date_args' => array(),
        		'time_args' => array()
        	);

        	$defaults = apply_filters('jck_sf_defaults', $defaults);
        	$field = wp_parse_args($args['field'], $defaults);
        	
        	$options = get_option( $this->settings_name );
        	$element_id = $section['tab_id'].'_'. $section['section_id'] .'_';
        	$element_id .= ($field['parent_id']) ? $field['parent_id'] : $field['id'];
        	
        	/*
        	if( ( isset($field['subfields']) && !empty($field['subfields']) ) || $field['parent_id'] ){
        		
        		$defaults = $this->getSubfieldDefaults($field); //unset($options[$element_id]);
        		
        		if(isset($options[$element_id])){
        			
        			foreach($options[$element_id] as $key => $row){
        				$options[$element_id][$key] = array_replace($defaults, $row);
        			}
        			
	        		$value = $options[$element_id];
        		} else {
	        		$value = array($defaults);
        		}
        		
        	} else {
        		$value = (isset($options[$element_id])) ? $options[$element_id] : $field['default'];
        	}
        	*/
        	
        	$value = (isset($options[$element_id])) ? $options[$element_id] : $field['default'];
        	
        	// $this->d($value);
        	// if($field['parent_id']) $this->d($value, 'Groupfield Val');
        	
        	do_action('jck_sf_before_field');
        	do_action('jck_sf_before_field_'. $element_id);

    		switch( $field['type'] )
            {
    		    case 'text': $this->_generateTextField($element_id, $field, $value, $section);
                    break;

                case 'password': $this->_generatePasswordField($element_id, $field, $value, $section);
                    break;

    		    case 'textarea': $this->_generateTextareaField($element_id, $field, $value, $section);
    		        break;

    		    case 'select': $this->_generateSelectField($element_id, $field, $value, $section);
    		        break;

    		    case 'radio': $this->_generateRadioField($element_id, $field, $value, $section);
    		        break;

    		    case 'checkbox': $this->_generateCheckboxField($element_id, $field, $value, $section);
                    break;

    		    case 'checkboxes': $this->_generateCheckboxesField($element_id, $field, $value, $section);
                    break;
                
                case 'imgcheckboxes': $this->_generateImgCheckboxesField($element_id, $field, $value, $section);
                    break;

                case 'color': $this->_generateColorField($element_id, $field, $value, $section);
                    break;

                case 'file': $this->_generateFileField($element_id, $field, $value, $section);
                    break;

                case 'editor': $this->_generateEditorField($element_id, $field, $value, $section);
                    break;
                    
                case 'group': $this->_generateGroupField($element_id, $field, $value, $section);
                    break;
                    
                case 'datetime': $this->_generatedatetimeField($element_id, $field, $value, $section);
                    break;
                    
                case 'multiinputs': $this->_generateMultiFields($element_id, $field, $value, $section);
                    break;

                case 'custom':
    		        echo $field['default'];
                break;

        		default:
        		    break;
    		}

    		do_action('jck_sf_after_field');
        	do_action('jck_sf_after_field_'. $element_id);
    	}
    	
    	private function getSubfieldDefaults($field){
	    	$defaults = array();
    		foreach($field['subfields'] as $subfield){
    			$defaults[$subfield['id']] = (isset($subfield['default'])) ? $subfield['default'] : "";
    		}
    		return $defaults;
    	}

        private function _generateTextField($element_id, $field, $value, $section)
        {
        	$fieldName = $this->settings_name.'['. $element_id .']';
        	
        	if($field['parent_id']){
        		$value = (isset($value[$field['row_num']][$field['id']])) ? $value[$field['row_num']][$field['id']] : $field['default'];
        		$fieldName .= '['.$field['row_num'].']['.$field['id'].']';
        	}
            
            $value = esc_attr(stripslashes($value));    
            
	        	
        	echo '<input type="text" name="'. $fieldName .'" id="'. $element_id .'" value="'. $value .'" class="regular-text '. $field['class'] .'" placeholder="'. $field['placeholder'] .'" />';

            if($field['desc']) 
            	echo '<p class="description">'. $field['desc'] .'</p>';
          
        }

        private function _generatePasswordField($element_id, $field, $value, $section)
        {
        	if($field['parent_id']){
        		echo 'Not currently allowed as a subfield';
	        	return;
        	}
        	
            $value = esc_attr(stripslashes($value));

            echo '<input type="password" name="'. $this->settings_name.'['. $element_id .']" id="'. $element_id .'" value="'. $value .'" class="regular-text '. $field['class'] .'" placeholder="'. $field['placeholder'] .'" />';

            if ($field['desc'])
                echo '<p class="description">'. $field['desc'] .'</p>';
        }

        private function _generateTextareaField($element_id, $field, $value, $section)
        {
        	if($field['parent_id']){
        		echo 'Not currently allowed as a subfield';
	        	return;
        	}
        	
            $value = esc_html(stripslashes($value));

            echo '<textarea name="'. $this->settings_name.'['. $element_id .']" id="'. $element_id .'" rows="5" cols="60" class="'. $field['class'] .'" placeholder="'. $field['placeholder'] .'">'. $value .'</textarea>';

            if ($field['desc'])
                echo '<p class="description">'. $field['desc'] .'</p>';
        }

        private function _generateSelectField($element_id, $field, $value, $section)
        {
        	if($field['parent_id']){
        		echo 'Not currently allowed as a subfield';
	        	return;
        	}
        	
            $value = esc_html(esc_attr($value));

            echo '<select name="'. $this->settings_name.'['. $element_id .']" id="'. $element_id .'" class="'. $field['class'] .'">';

            foreach ($field['choices'] as $k => $v)
            {
                echo '<option value="'. $k .'"'. (($k == $value) ? ' selected="selected"' : '') .'>'. $v .'</option>';
            }

            echo '</select>';

            if ($field['desc'])
                echo '<p class="description">'. $field['desc'] .'</p>';
        }

        private function _generateRadioField($element_id, $field, $value, $section)
        {
        	if($field['parent_id']){
        		echo 'Not currently allowed as a subfield';
	        	return;
        	}
        	
            $value = esc_html(esc_attr($value));

            foreach($field['choices'] as $k => $v)
            {
                echo '<label><input type="radio" name="'. $this->settings_name.'['. $element_id .']" id="'. $element_id .'_'. $k .'" value="'. $k .'" class="'. $field['class'] .'"'. (($k == $value) ? ' checked="checked"' : '') .' /> '. $v .'</label><br />';
            }

            if ($field['desc'])
                echo '<p class="description">'. $field['desc'] .'</p>';
        }

        private function _generateCheckboxField($element_id, $field, $value, $section)
        {
        	if($field['parent_id']){
        		echo 'Not currently allowed as a subfield';
	        	return;
        	}
        	
            $value = esc_attr(stripslashes($value));

            echo '<input type="hidden" name="'. $this->settings_name.'['. $element_id .']" value="0" />';
            echo '<label><input type="checkbox" name="'. $this->settings_name.'['. $element_id .']" id="'. $element_id .'" value="1" class="'. $field['class'] .'"'. (($value) ? ' checked="checked"' : '') .' /> '. $field['desc'] .'</label>';
        }

        private function _generateCheckboxesField($element_id, $field, $value, $section)
        {
        	if($field['parent_id']){
        		echo 'Not currently allowed as a subfield';
	        	return;
        	}
        	
        	//$this->d($value);
        	
        	echo '<input type="hidden" name="'. $this->settings_name.'['. $element_id .']" value="">';
        	
            $cbx_i = 0; foreach ($field['choices'] as $k => $v)
            {
                $checked = (is_array($value) && in_array($k, $value))  ? true : false;
				
                echo '<label><input type="checkbox" name="'. $this->settings_name.'['. $element_id .']['.$cbx_i.']" id="'. $element_id .'_'. $k .'" value="'. $k .'" class="'. $field['class'] .'"'. ($checked ? ' checked="checked"' : '') .' /> '. $v .'</label><br />';
                
            $cbx_i++; }

            if ($field['desc'])
                echo '<p class="description">'. $field['desc'] .'</p>';
        }
        
        private function _generateImgCheckboxesField($element_id, $field, $value, $section)
        {
        	if($field['parent_id']){
        		echo 'Not currently allowed as a subfield';
	        	return;
        	}
        	
        	echo '<input type="hidden" name="'. $this->settings_name.'['. $element_id .']" value="">';
        	
            $cbx_i = 0; foreach ($field['choices'] as $k => $v)
            {
            	
            	$checked = (is_array($value) && in_array($k, $value))  ? true : false;
            	
                echo '<label class="jckCheckImg'. ($checked ? ' checked' : '') . (($field['show_labels']) ? ' hasLabel' : '') .'">';
                	echo '<input type="checkbox" name="'. $this->settings_name.'['. $element_id .']['.$cbx_i.']" id="'. $element_id .'_'. $k .'" value="'. $k .'" class="jckCheckImgInput '. $field['class'] .'"'. ($checked ? ' checked="checked"' : '') .' />';
                	echo '<img src="' . $v['img'] .'">';
                	echo (($field['show_labels']) ? $v['label'] : '');
                echo '</label>';
                
            $cbx_i++; }

            if ($field['desc'])
                echo '<p class="description">'. $field['desc'] .'</p>';
        }

        private function _generateColorField($element_id, $field, $value, $section)
        {
        	if($field['parent_id']){
        		echo 'Not currently allowed as a subfield';
	        	return;
        	}
        	
            $value = esc_attr(stripslashes($value));

            echo '<div style="position:relative;">';
            echo '<input type="text" name="'. $this->settings_name.'['. $element_id .']" id="'. $element_id .'" value="'. $value .'" class="'. $field['class'] .'" />';
            echo '<div id="'. $element_id .'_cp" style="position:absolute;top:0;left:190px;background:#fff;z-index:9999;"></div>';

            if ($field['desc'])
                echo '<p class="description">'. $field['desc'] .'</p>';

            echo '<script type="text/javascript">
    		        jQuery(document).ready(function($){
                        var colorPicker = $("#'. $element_id .'_cp");
                        colorPicker.farbtastic("#'. $element_id .'");
                        colorPicker.hide();
                        $("#'. $element_id .'").live("focus", function(){
                            colorPicker.show();
                        });
                        $("#'. $element_id .'").live("blur", function(){
                            colorPicker.hide();
                            if($(this).val() == "") $(this).val("#");
                        });
                    });
                    </script></div>';
        }

        private function _generateFileField($element_id, $field, $value, $section)
        {
        	if($field['parent_id']){
        		echo 'Not currently allowed as a subfield';
	        	return;
        	}
        	
            $value = esc_attr($value);

            echo '<input type="text" name="'. $this->settings_name.'['. $element_id .']" id="'. $element_id .'" value="'. $value .'" class="regular-text '. $field['class'] .'" /> ';
            echo '<input type="button" class="button wpsf-browse" id="'. $element_id .'_button" value="Browse" />';
            echo '<script type="text/javascript">
                    jQuery(document).ready(function($){
                		$("#'. $element_id .'_button").click(function() {
                			tb_show("", "media-upload.php?post_id=0&amp;type=image&amp;TB_iframe=true");
                			window.original_send_to_editor = window.send_to_editor;
                        	window.send_to_editor = function(html) {
                        		var imgurl = $("img",html).attr("src");
                        		$("#'. $element_id .'").val(imgurl);
                        		tb_remove();
                        		window.send_to_editor = window.original_send_to_editor;
                        	};
                			return false;
                		});
                    });
                    </script>';
        }

        private function _generateEditorField($element_id, $field, $value, $section)
        {
        	if($field['parent_id']){
        		echo 'Not currently allowed as a subfield';
	        	return;
        	}
        	
            wp_editor( $value, $element_id, array( 'textarea_name' => $this->settings_name.'['. $element_id .']' ) );

            if ($field['desc'])
                echo '<p class="description">'. $field['desc'] .'</p>';
        }
        
        private function _generateGroupField($element_id, $field, $value, $section)
        {
        	$rowCount = count($value);
        	$row_i = 0;
        	
        	if($field['format'] == 'table'){
        		
        		echo '<table class="jckGroup wp-list-table widefat fixed">';
        			
        			echo '<thead>';
        				echo '<tr>';
	        				foreach($field['subfields'] as $subfield){	
	        					
	        					$safeId = str_replace('-', '_', $field['id'].'_'.$subfield['id']);
	        					$dateId = $safeId.'_date';
	        					$timeId = $safeId.'_time';
	        					$colWidth = (isset($subfield['col_width'])) ? $subfield['col_width'] : $field['col_width'];	
	        					
	        					echo '<th class="manage-colum '.$colWidth.'">';
	        					
		        					if($subfield['type'] == 'datetime'){
			        					echo "<script>";
											
							        		if(!empty($subfield['show_date'])){
									        	echo "function trigger".$dateId."() { jQuery( 'input[data-sharedid=". $dateId ."]').datepicker(\n";
										        	if(!empty($subfield['date_args'])) echo json_encode($subfield['date_args']);		        		
												echo "); }\n";	
												
												echo "jQuery(document).ready(function($) { trigger".$dateId."(); });";
											} 
											
											if(!empty($subfield['show_time'])){
												echo "function trigger".$timeId."() { jQuery( 'input[data-sharedid=". $timeId ."]' ).each(function(){ if(jQuery(this).hasClass('hasTimepicker')) { jQuery(this).timepicker('destroy'); } jQuery(this).timepicker(\n";						
									        		if(!empty($subfield['time_args'])) echo json_encode($subfield['time_args']);	        		
									        	echo "); }); }\n";	
									        	
									        	echo "jQuery(document).ready(function($) { trigger".$timeId."(); });";  
											} 
							        	
							        	echo '</script>';
							        	
							        	$onclick = "javascript: ";
							        	if(!empty($subfield['show_date'])) $onclick .= 'trigger'.$dateId.'(); ';
							        	if(!empty($subfield['show_time'])) $onclick .= 'trigger'.$timeId.'(); ';
							        	$onclick .= 'return false;';
							        	
							        	echo '<a href="#" class="cloneTrigger hide" onclick="'.$onclick.'">Reset</a>';
		        					}
	        							            	
				            	echo $subfield['title'].'</th>';
				            }
			            echo '<th class="actions">&nbsp;</th></tr>';
		            echo '</thead>';
		            
		            echo '<tbody>';
        	
		        		while ($row_i < $rowCount) {
		        			
				        	echo '<tr class="jckGroupRow '.($row_i%2 == 0 ? 'alternate' : '').'">';
					            foreach($field['subfields'] as $subfield){
					            	$subfield['parent_id'] = $field['id'];
					            	$subfield['row_num'] = $row_i;
					            	
					            	// $this->d($value[$row_i][$subfield['id']], 'Test');
					            	
					            	$subfield['default'] = isset($value[$row_i][$subfield['id']]) ? $value[$row_i][$subfield['id']] : '';
					            	
					            	$colWidth = (isset($subfield['col_width'])) ? $subfield['col_width'] : $field['col_width'];	
					            	
					            	echo '<td class="'.$colWidth.'">';
					            		$this->generateSetting(array('section' => $section, 'field' => $subfield));
					            	echo '</td>';
					            }
								echo '<td class="actions"><a href="#" class="jckAddRow" title="Add '.$field['row_title'].'"><i class="icon-plus-circled"></i></a> <a href="#" class="jckRmRow '.($rowCount <= 1 ? 'hide' : '').'" title="Remove '.$field['row_title'].'"><i class="icon-minus-circled"></i></a></td>';	            
					        echo '</tr>';
					        $row_i++;
				        }
			        
			        echo '</tbody>';
		        
		        echo '</table>';
	        	
        	} else {
        		
        		while ($row_i < $rowCount) {
		        	echo '<div class="jckGroupRow">';
			            foreach($field['subfields'] as $subfield){
			            	$subfield['parent_id'] = $field['id'];
			            	$subfield['row_num'] = $row_i;
			            	
			            	$subfield['default'] = isset($value[$row_i][$subfield['id']]) ? $value[$row_i][$subfield['id']] : '';
			            	
			            	$this->generateSetting(array('section' => $section, 'field' => $subfield));
			            }
						echo '<a href="#" class="jckAddRow">Add '.$field['row_title'].'</a>';
						echo '<a href="#" class="jckRmRow">Remove '.$field['row_title'].'</a>';	            
			        echo '</div>';
			        $row_i++;
		        }
	        	
        	}
	        
        }
    
		private function _generateDatetimeField($element_id, $field, $value, $section)
        {
        	$fieldName = $this->settings_name.'['. $element_id .']';
        	$fieldId = $element_id;
        	$dateId = $fieldId.'_date';
        	$timeId = $fieldId.'_time';
        	
        	if($field['parent_id']){
        		$value = (isset($value[$field['row_num']][$field['id']])) ? $value[$field['row_num']][$field['id']] : $field['default'];
        		$fieldName .= '['.$field['row_num'].']['.$field['id'].']';
        		$fieldId .= '-id'.$field['row_num'].'-'.$field['id'];
        		
        		$safeId = str_replace('-', '_', $field['parent_id'].'_'.$field['id']);
				$dateId = $safeId.'_date';
				$timeId = $safeId.'_time';
        	} else {
	        	echo "<script> jQuery(document).ready(function($) {\n";
	        		
	        		if(!empty($field['show_date'])){
			        	echo '$( "#'.$dateId.'" ).datepicker(';	        		
				        	if(!empty($field['date_args'])) echo json_encode($field['date_args']);		        		
						echo ');';	
					} 
					
					if(!empty($field['show_time'])){
						echo '$( "#'.$timeId.'" ).timepicker(';	        			
			        		if(!empty($field['time_args'])) echo json_encode($field['time_args']);	        		
			        	echo ");\n";	  
					} 
	        	
	        	echo '}); </script>';
        	}
        	
        	$labels = (is_array($field['labels'])) ? $field['labels'] : array('date' => "Date", 'time' => "Time");
	        	
	        echo '<div class="jckDateTime '.(empty($field['show_date']) || empty($field['show_time']) ? 'singlePicker' : '').'">';
		        if(!empty($field['show_date'])){
		        	echo '<div class="jckDateWrap jckDateTimeField">';
		        		$dateVal = (isset($value['date'])) ? esc_attr(stripslashes($value['date'])) : ""; 
						if(!$field['parent_id']) echo '<label for="'. $fieldId .'_date">'.$field['labels']['date'].'</label>';
						
						$datePh = (is_array($field['placeholder']) && isset($field['placeholder']['date'])) ? $field['placeholder']['date'] : "Date";
						
						echo '<input type="text" name="'. $fieldName .'[date]" id="'. $fieldId .'_date" '.($field['parent_id'] ? 'data-sharedid="'.$dateId.'"' : '') .' value="'. $dateVal .'" class="regular-text jckDatepicker '. $field['class'] .'" placeholder="'. $datePh .'" />';
						
	        		echo '</div>';
	        	}
	        	
	        	if(!empty($field['show_time'])){
	        		echo '<div class="jckTimeWrap jckDateTimeField">';
	        			$timeVal = (isset($value['time'])) ? esc_attr(stripslashes($value['time'])) : ""; 
						if(!$field['parent_id']) echo '<label for="'. $fieldId .'_time">'.$field['labels']['time'].'</label>';
						
						$timePh = (is_array($field['placeholder']) && isset($field['placeholder']['time'])) ? $field['placeholder']['time'] : "Time";
						
						echo '<input type="text" name="'. $fieldName .'[time]" id="'. $fieldId .'_time" '.($field['parent_id'] ? 'data-sharedid="'.$timeId.'"' : '') .' value="'. $timeVal .'" class="regular-text jckTimepicker '. $field['class'] .'" placeholder="'. $timePh .'" />';
	        		echo '</div>';
	        	}
        	echo '</div>';
        	


            if($field['desc']) 
            	echo '<p class="description">'. $field['desc'] .'</p>';
          
        }
        
        private function _generateMultiFields($element_id, $field, $value, $section)
        {
        	$fieldName = $this->settings_name.'['. $element_id .']';
        	
        	if($field['parent_id']){
        		echo 'Not currently allowed as a subfield';
	        	return;
        	}
        	
        	$fieldTitles = array_keys($field['default']);
        	$value = array_values($value);
        	
        	echo '<div class="multifields">'; 
        		
        		$i = 0; while($i < count($value)):     
	        		
	        		echo '<div class="multifield">';
						echo '<input type="text" name="'. $fieldName .'[]" id="'. $element_id .'_'.$i.'" value="'. esc_attr(stripslashes($value[$i])) .'" class="regular-text '. $field['class'] .'" placeholder="'. $field['placeholder'] .'" />';
						echo '<br><span>'.$fieldTitles[$i].'</span>';
	        		echo '</div>';
	        	
	        	$i++; endwhile;
        	
        	echo '</div>';

            if($field['desc']) 
            	echo '<p class="description">'. $field['desc'] .'</p>';
          
        }

        /* Static functions */
        
        public static function __getOptionGroup($settings_file)
        {
            $option_group = preg_replace("/[^a-z0-9]+/i", "", basename($settings_file, '.php'));

            return $option_group;
        }

        public function __getSettings()
        {
        	// delete_option($this->settings_name);
        	$options = get_option($this->settings_name);
        	
        	if($options) return $options;
        	
        	$options = array();
        	
        	foreach($this->settings['sections'] as $section){
        		foreach($section['fields'] as $field){
        			$options[$section['tab_id'].'_'.$section['section_id'].'_'.$field['id']] = (isset($field['default'])) ? $field['default'] : false;
        		}
        	}
        	
        	return $options;
        }

        public function __getSetting($tab_id, $section_id, $field_id)
        {
            $options = get_option($this->settings_name);

            if (isset($options[$tab_id .'_'. $section_id .'_'. $field_id]))
                return $options[$tab_id .'_'. $section_id .'_'. $field_id];

            return false;
        }

        public static function __deleteSettings($settings_file, $option_group = '')
        {
            $opt_group = preg_replace("/[^a-z0-9]+/i", "", basename($settings_file, '.php'));

            if ($option_group)
                $opt_group = $option_group;

            delete_option( $opt_group .'_settings' );

            return true;
        }

        public static function __addSettingsLink($links, $settings_link)
        {
            array_push($links, $settings_link);

            return $links;
        }
        
    /*	=== Helpers ===  */
        
		private function d($arr = array(), $title = false, $dump = false, $die = false){
		    echo '<pre>';
		    if($title) echo '<h2>'.$title.'</h2>';
		    if($dump){
		        var_dump($arr);
		    } else {
		    	print_r($arr);
		    }
		    echo '</pre>';
		    if($die) die;
		}
		
		private function searchArr($array, $key, $value)
		{
		    $results = array();
		    $this->search_r($array, $key, $value, $results);
		    return $results;
		}
		
		private function search_r($array, $key, $value, &$results)
		{
		    if (!is_array($array)) {
		        return;
		    }
		
		    if ($array[$key] == $value) {
		        $results[] = $array;
		    }
		
		    foreach ($array as $subarray) {
		        $this->search_r($subarray, $key, $value, $results);
		    }
		}
    
    }
}