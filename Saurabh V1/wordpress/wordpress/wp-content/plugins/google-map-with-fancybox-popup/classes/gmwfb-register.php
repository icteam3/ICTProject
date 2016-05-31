<?php
class gmwfb_registerhook
{
	public static function gmwfb_activation()
	{
		global $wpdb, $gmwfb_db_version;
		$prefix = $wpdb->prefix;
		
		// Plugin tables
		$array_tables_to_plugin = array('gmwfb_mapdetails');
		$errors = array();
		
		// loading the sql file, load it and separate the queries
		$sql_file = GMWFB_DIR.'sql'.DS.'createDB.sql';
		$prefix = $wpdb->prefix;
        $handle = fopen($sql_file, 'r');
        $query = fread($handle, filesize($sql_file));
        fclose($handle);
        $query=str_replace('CREATE TABLE IF NOT EXISTS `','CREATE TABLE IF NOT EXISTS `'.$prefix, $query);
        $queries=explode('-- SQLQUERY ---', $query);

        // run the queries one by one
        $has_errors = false;
        foreach($queries as $qry)
		{
		    $wpdb->query($qry);
        }

		// list the tables that haven't been created
        $missingtables=array();
        foreach($array_tables_to_plugin as $table_name)
		{
			if(strtoupper($wpdb->get_var("SHOW TABLES like  '". $prefix.$table_name . "'")) != strtoupper($prefix.$table_name))  
			{
                $missingtables[] = $prefix.$table_name;
            }
        }
		
		// add error in to array variable
        if($missingtables) 
		{
			$errors[] = __('These tables could not be created on installation ' . implode(', ',$missingtables), 'google-map-with-fancybox-popup');
            $has_errors=true;
        }
		
		// if error call wp_die()
        if($has_errors) 
		{
			wp_die( __( $errors[0] , 'google-map-with-fancybox-popup' ) );
			return false;
		}
		else
		{
			gmwfb_dbquery::gmwfb_default();
		}
        return true;
	}
	
	public static function gmwfb_deactivation()
	{
		// do not generate any output here
	}
	
	public static function gmwfb_adminmenu()
	{
		if (is_admin()) 
		{
			add_options_page( __('Google Map', 'google-map-with-fancybox-popup'), 
				__('Google Map', 'google-map-with-fancybox-popup'), 'manage_options', GMWFB_PLUGIN_NAME, array( 'gmwfb_intermediate', 'gmwfb_admin' ) );
		}		
	}
	
	public static function gmwfb_widget_loading()
	{
		register_widget( 'gmwfb_widget_register' );
	}
}

function gmwfb_js_admin_head() 
{
		?>
<script src="http://maps.google.com/maps/api/js?libraries=places&region=uk&language=en&sensor=true"></script>
<script type="text/javascript"> 
var geocoder;
var map;
function initialize() {
  geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(-34.397, 150.644);
 
var imgurl= '';
if(imgurl=='')
{
   var image = 'http://www.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png';
}
else
{
	var image= imgurl;
}
	
  var mapOptions = {
    zoom: 15,
    center: latlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  map = new google.maps.Map(document.getElementById('map'), mapOptions);
 
 				
 marker = new google.maps.Marker({
                 position: latlng,
                 map: map,
                 icon: image,
    			 animation: google.maps.Animation.DROP,
             });
  		google.maps.event.addListener(marker, 'click',function() { });
		
		var input = document.getElementById('googlemap_address');
        
		 var autocomplete = new google.maps.places.Autocomplete(input, {
             types: ["geocode"]
         });
		 
         autocomplete.bindTo('bounds', map);
         var infowindow = new google.maps.InfoWindow();
         google.maps.event.addListener(autocomplete, 'place_changed', function (event) {
             infowindow.close();
             var place = autocomplete.getPlace();
             if (place.geometry.viewport) {
                 map.fitBounds(place.geometry.viewport);
             } else {
                 map.setCenter(place.geometry.location);
                 map.setZoom(17);
             }
			
			 moveMarker(place.name, place.geometry.location);
             jQuery('.google_latitude').val(place.geometry.location.lat());
             jQuery('.google_longitude').val(place.geometry.location.lng());
         });
         google.maps.event.addListener(map, 'click', function (event) {
             jQuery('.google_latitude').val(event.latLng.lat());
             jQuery('.google_longitude').val(event.latLng.lng());
             infowindow.close();
                     var geocoder = new google.maps.Geocoder();
                     geocoder.geocode({
                         "latLng":event.latLng
                     }, function (results, status) {
                         console.log(results, status);
                         if (status == google.maps.GeocoderStatus.OK) {
                             console.log(results);
                             var lat = results[0].geometry.location.lat(),
                                 lng = results[0].geometry.location.lng(),
                                 placeName = results[0].address_components[0].long_name,
                                 latlng = new google.maps.LatLng(lat, lng);
                             moveMarker(placeName, latlng);
                             $("#googlemap_address").val(results[0].formatted_address);
                         }
                     });
         });
         function moveMarker(placeName, latlng)
		 {
             marker.setIcon(image);
             marker.setPosition(latlng);
         }
geocodeaddress();
}
function geocodeaddress() {
	
var imgurl= '';
if(imgurl=='')
{
   var image = 'http://www.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png';
}
else
{
	var image= imgurl;
}

  var latlng = new google.maps.LatLng(-34.397, 150.644);
 
  var mapOptions = {
    zoom: 15,
    center: latlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  map = new google.maps.Map(document.getElementById('map'), mapOptions);

	
  var address = document.getElementById('googlemap_address').value;
  geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
          map: map,
		  icon:image,
          position: results[0].geometry.location
      });
	  var latitude = results[0].geometry.location.lat();
     var longitude = results[0].geometry.location.lng();
		
	document.getElementById("googlemap_latitude").value = latitude;
	document.getElementById("googlemap_longitude").value = longitude;
    }
  });
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
<?php
}

class gmwfb_widget_register extends WP_Widget 
{
	function __construct() 
	{
		$widget_ops = array('classname' => 'widget_text gmwfb_widget', 'description' => __(GMWFB_PLUGIN_DISPLAY, 'google-map-with-fancybox-popup'), GMWFB_PLUGIN_NAME);
		parent::__construct(GMWFB_PLUGIN_NAME, __(GMWFB_PLUGIN_DISPLAY, 'google-map-with-fancybox-popup'), $widget_ops);
	}
	
	function widget( $args, $instance ) 
	{
		extract( $args, EXTR_SKIP );
		
		$gmwfb_title 	= apply_filters( 'widget_title', empty( $instance['gmwfb_title'] ) ? '' : $instance['gmwfb_title'], $instance, $this->id_base );
		$gmwfb_id	= $instance['gmwfb_id'];

		echo $args['before_widget'];
		if ( ! empty( $gmwfb_title ) )
		{
			echo $args['before_title'] . $gmwfb_title . $args['after_title'];
		}
		// Call widget method
		$arr = array();
		$arr["id"] 	= $gmwfb_id;
		echo gmwfb_loadmap::gmwfb_widget($arr);
		// Call widget method
		
		echo $args['after_widget'];
	}
	
	function update( $new_instance, $old_instance ) 
	{
		$instance 					= $old_instance;
		$instance['gmwfb_title']	= ( ! empty( $new_instance['gmwfb_title'] ) ) ? strip_tags( $new_instance['gmwfb_title'] ) : '';
		$instance['gmwfb_id'] 		= ( ! empty( $new_instance['gmwfb_id'] ) ) ? strip_tags( $new_instance['gmwfb_id'] ) : '';
		return $instance;
	}
	
	function form( $instance ) 
	{
		$defaults = array(
			'gmwfb_title' => '',
            'gmwfb_id' 	=> ''
        );
		$instance 		= wp_parse_args( (array) $instance, $defaults);
		$gmwfb_title 	= $instance['gmwfb_title'];
        $gmwfb_id 		= $instance['gmwfb_id'];
		?>
		<p>
		<label for="<?php echo $this->get_field_id('gmwfb_title'); ?>"><?php _e('Widget Title', 'google-map-with-fancybox-popup'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('gmwfb_title'); ?>" name="<?php echo $this->get_field_name('gmwfb_title'); ?>" type="text" value="<?php echo $gmwfb_title; ?>" />
        </p>
		<p>
		<label for="<?php echo $this->get_field_id('gmwfb_id'); ?>"><?php _e('Map Id', 'google-map-with-fancybox-popup'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('gmwfb_id'); ?>" name="<?php echo $this->get_field_name('gmwfb_id'); ?>" type="text" value="<?php echo $gmwfb_id; ?>" />
        </p>
		<?php
	}
}

function gmwfb_shortcode( $atts ) 
{
	if ( ! is_array( $atts ) )
	{
		return '';
	}
	//[google-map-fb-popup id="1"]
	$id = isset($atts['id']) ? $atts['id'] : '0';
	
	$arr = array();
	$arr["id"] 	= $id;
	return gmwfb_loadmap::gmwfb_widget($arr);
}

function gmwfb( $id = "" )
{
	$arr = array();
	$arr["id"] 	= $id;
	echo gmwfb_loadmap::gmwfb_widget($arr);
}

function gmwfb_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script('jquery');
		wp_enqueue_style( 'jquery.fancybox-1.3.4', GMWFB_URL.'inc/jquery.fancybox-1.3.4.css');
		wp_enqueue_script('jquery.fancybox-1.3.4', GMWFB_URL.'inc/jquery.fancybox-1.3.4.js');
	}
}
?>