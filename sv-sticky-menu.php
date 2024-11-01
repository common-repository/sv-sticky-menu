<?php
/*
Plugin Name: SV Sticky Menu
Plugin URI: http://wordpress.org/plugins/sv-sticky-menu/
Description: SV Sticky Menu is WordPress's plugin that transform menu to sticky menu on top of page by scrolling.
Version: 1.0.5
Author: Andrey Svyatovets
Author URI: http://svyatovets.wordpress.com
Text Domain: sv-sticky-menu
Domain Path: /languages
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

define('SVSM_VERSION', '1.0.5');

if (!defined('ABSPATH')) die('No direct access allowed');

class CSvStickyMenu {

   public $Options;

   public function __construct() {
	add_action( 'admin_menu', array( $this, 'add_options_page' ) );
	add_action( 'admin_init', array( $this, 'init_options_page' ) );
        add_action( 'admin_enqueue_scripts',  array( $this, 'enqueue_admin_scripts' ) );	
   }
   public function enqueue_admin_scripts () {
	wp_enqueue_media();

	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'features-script-handle', plugins_url('js/features-adm.js', __FILE__ ), array( 'wp-color-picker' ), SVSM_VERSION );
   }
   public function add_options_page() {
        add_options_page (__('Sticky Menu Options Page', 'sv-sticky-menu' ), __('SV Sticky Menu','sv-sticky-menu'), 'manage_options', 'sv-sticky-menu-page', array( $this, 'create_page' )); // Page = 'sv-sticky-menu-page'
   }
   public function init_options_page () {
	register_setting ( 'sv-sticky-menu-page-group', 'sv-sticky-menu-page-options', array( $this, 'senitize_cb' )); // Group='sv-sticky-menu-page-group' OptionsName='sv-sticky-menu-page-options'
        //add_settings_section ('sv-sticky-menu-page-section', __('CSS Options', 'sv-sticky-menu' ), array( $this, 'section_cb' ), 'sv-sticky-menu-page'); //Page='sv-sticky-menu-page'

	$default = array(
        		'field_css_selector' => '.navbar',
        		'field_css_hide' => '',
        		'field_set_bgcolor' => 'false',
        		'field_bgcolor' => '#FFFFFF',
        		'field_opacity' => '0.9',
        		'field_min_media' => '768',
                        'field_transition' => 'slide',
                        'field_slide_start' => '-55',
                        'field_transition_time' => '0.4',
        		'field_shadow' => 'true',
        		'field_shadow_color' => '#000000',
        		'field_shadow_opacity' => '.25',
        		'field_logo' => 'true',
        		'field_logo_img' => '',
        		'field_logo_url' => '',
        		'field_logo_height' => '51',
                        'field_zindex' => '99'
		);

		if ( get_option('sv-sticky-menu-page-options') == false ) {	
			update_option( 'sv-sticky-menu-page-options', $default );		
		}

   }
   public function senitize_cb( $input ) {
	$new_input = array();
	$intarray = array( 
                           'field_min_media'
                          ,'field_slide_start'
                          ,'field_logo_height'
                          ,'field_zindex'
                         );
	$textarray = array( 
        		   'field_css_selector'
			  ,'field_css_hide'
        		  ,'field_set_bgcolor'
        		  ,'field_bgcolor'
                          ,'field_transition'
        		  ,'field_shadow'
                          ,'field_shadow_color'
        		  ,'field_logo'
        		  ,'field_logo_img'
        		  ,'field_logo_url'
                         );
	$floatarray = array( 
                             'field_opacity' 
                            ,'field_transition_time'
        		    ,'field_shadow_opacity'
                           );
        foreach ( $intarray as &$value ) {
	   if( isset( $input[$value] ) )
		$new_input[$value] = intval( $input[$value] );
        }

        foreach ( $textarray as &$value ) {
	   if( isset( $input[$value] ) )
		$new_input[$value] = sanitize_text_field( $input[$value] );
        }

        foreach ( $floatarray as &$value ) {
	   if( isset( $input[$value] ) )
		$new_input[$value] = floatval( $input[$value] );
        }
        return $new_input;
   }
//   public function section_cb () {
//     _e('Set css options', 'sv-sticky-menu');
//   }
   public function create_page () {
 
        $this->Options = get_option( 'sv-sticky-menu-page-options' );
        //var_dump( $this->Options );
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>       
		<form method="post" action="options.php">
		<?php settings_fields( 'sv-sticky-menu-page-group' ); ?>
		<h2><?php echo ( __('General Options', 'sv-sticky-menu' ) ); ?> </h2>
                <?php echo ( __('In this section options for general functionality.', 'sv-sticky-menu' ) ); ?>

		<table class="form-table"><tbody>

                  <tr>
                  <th scope="row"><?php _e('CSS Selector class or id','sv-sticky-menu');  ?>:</th>
                  <td> 
                    <input name="sv-sticky-menu-page-options[field_css_selector]" id="field_css_selector" type="text" class="regular-text" size="15" value="<?php echo esc_attr( $this->Options['field_css_selector'] ); ?>" placeholder="#id, .class"  />  
 		    <span class="howto"><?php _e( 'Input class name or id in CSS style. You can input several selectors but  plugin works only with one object.', 'sv-sticky-menu' ); ?></span>
                  </td></tr>

                  <tr>
                  <th scope="row"><?php _e('CSS Selector for hiding objects','sv-sticky-menu');  ?>:</th>
                  <td> 
                    <input name="sv-sticky-menu-page-options[field_css_hide]" id="field_css_hide" type="text" class="regular-text" size="15" value="<?php echo esc_attr( $this->Options['field_css_hide'] ); ?>" placeholder="#id, .class"  />  
 		    <span class="howto"><?php _e( 'Input class name or id in CSS style elements wich must be hided when menu is sticked. You can input several selectors but.', 'sv-sticky-menu' ); ?></span>
                  </td></tr>

                  <tr>
                  <th scope="row"><?php _e('Set background color','sv-sticky-menu');  ?>:</th>
                  <td> 
                    <input name="sv-sticky-menu-page-options[field_set_bgcolor]" id="field_set_bgcolor" 
                         onclick="jQuery('#block_bgcolor').fadeToggle();" 
                         type="checkbox" value="true"  <?php echo esc_attr( $this->Options['field_set_bgcolor']=='true' ? 'checked' : '' ); ?> />  
 		    <span class="description"><?php _e( 'If object has no background and look as transparent you can add you own background color when object is sticked.', 'sv-sticky-menu' ); ?></span>
                  </td></tr>
                </tbody></table>                            
                 

           	  <div id="block_bgcolor" class="postbox" style="display:<?php echo ($this->Options['field_set_bgcolor']=='true' ? 'block' : 'none'); ?>;">
           	  <div class="inside" >
  
		<table class="form-table"><tbody>

                  <tr>
                  <th scope="row"><?php _e('Background color of sticky object','sv-sticky-menu');  ?>:</th>
                  <td> 
                    <input name="sv-sticky-menu-page-options[field_bgcolor]" id="field_bgcolor" type="text" size="15" class="colorfield" value="<?php echo esc_attr( $this->Options['field_bgcolor'] ); ?>" />  
 		    <span class="description"><?php _e( 'Select background color', 'sv-sticky-menu' ); ?></span>
                  </td></tr>

                </tbody></table>                            
                </div></div>

		<table class="form-table"><tbody>
                  <tr>
                  <th scope="row"><?php _e('Opacity','sv-sticky-menu');  ?>:</th>
                  <td> 
                    <input name="sv-sticky-menu-page-options[field_opacity]" id="field_opacity" type="number" min="0" max="1" step="0.01"  size="5" value="<?php echo esc_attr( $this->Options['field_opacity'] ); ?>"  />  
 		    <span class="description"><?php _e( 'Set object opacity between 0 and 1 for example 0.95', 'sv-sticky-menu' ); ?></span>
                  </td></tr>

                  <tr>
                  <th scope="row"><?php _e('Minimum media width','sv-sticky-menu');  ?>:</th>
                  <td> 
                    <input name="sv-sticky-menu-page-options[field_min_media]" id="field_min_media" type="number" min="0" max="9999" step="1"  size="4" value="<?php echo esc_attr( $this->Options['field_min_media'] ); ?>"  />  
 		    <span class="description"><?php _e( 'px. Input media size for stop sticky.', 'sv-sticky-menu' ); ?></span> 
 		    <span class="howto"><?php _e( 'For devices with small screen such functionality can be not useful. In this case you can set minimum screen width in pixels for disabling stiky menu functionality.', 'sv-sticky-menu' ); ?></span>
                  </td></tr>

                  <tr>
                  <th scope="row"> <?php _e( 'Select transition', 'sv-sticky-menu' ); ?>:</th>
                  <td> 
			<select id="field_transition" name="sv-sticky-menu-page-options[field_transition]"
                           onchange="jQuery(this)[0].value == 'slide' ? jQuery('#block_slide').fadeIn() : jQuery('#block_slide').fadeOut();" 
                        >
				<option value="slide"  <?php selected($this->Options['field_transition'], 'slide' ); ?>><?php _e( 'Slide', 'sv-sticky-menu' ); ?></option>	
				<option value="fade"   <?php selected($this->Options['field_transition'], 'fade');   ?>><?php _e( 'Fade', 'sv-sticky-menu' ); ?></option>											
				<option value="scale"  <?php selected($this->Options['field_transition'], 'scale');   ?>><?php _e( 'Scale', 'sv-sticky-menu' ); ?></option>											
				<option value="rotate" <?php selected($this->Options['field_transition'], 'rotate');   ?>><?php _e( 'Rotate', 'sv-sticky-menu' ); ?></option>											
				<option value="skew"   <?php selected($this->Options['field_transition'], 'skew');   ?>><?php _e( 'Skew', 'sv-sticky-menu' ); ?></option>											
				<option value="custom" <?php selected($this->Options['field_transition'], 'custom');   ?>><?php _e( 'Custom', 'sv-sticky-menu' ); ?></option>											
			</select>	
 		    <span class="description"><?php _e( 'Select transition type for sticky object', 'sv-sticky-menu' ); ?></span>
                  </td></tr>

                </tbody></table>                            

           	  <div id="block_slide" class="postbox" style="display:<?php echo ($this->Options['field_transition']=='slide' ? 'block' : 'none'); ?>;">
           	  <div class="inside" >
  
		<table class="form-table"><tbody>
                  <tr>
                  <th scope="row"><?php  _e('Start position','sv-sticky-menu'); ?>:</th>
                  <td> 
                    <input name="sv-sticky-menu-page-options[field_slide_start]" id="field_slide_start" type="number" min="-999" step="1" max="999" size="3" value="<?php echo esc_attr( $this->Options['field_slide_start'] ); ?>" />  
 		    <span class="description"><?php _e( 'px. Input negative value of start posion of object', 'sv-sticky-menu' ); ?></span>
                  </td></tr>
                </tbody></table>                            

                  </div></div> 


		<table class="form-table"><tbody>
                  <tr>
                  <th scope="row"><?php _e('Transition time','sv-sticky-menu');  ?>:</th>
                  <td> 
                    <input name="sv-sticky-menu-page-options[field_transition_time]" id="field_transition_time" type="number" min="0.1" step="0.1" max="10" size="15" value="<?php echo esc_attr( $this->Options['field_transition_time'] ); ?>" />  
 		    <span class="description"><?php _e( 'seconds. Input transition time in seconds (between 0.1 and 10) for example 0.4 or 2', 'sv-sticky-menu' ); ?></span>
                  </td></tr>

                  <tr>
                  <th scope="row"><?php _e('Z-index of object','sv-sticky-menu');  ?></th>
                  <td> 
                    <input name="sv-sticky-menu-page-options[field_zindex]" id="field_zindex" type="number" min="0" max="999999" size="15" value="<?php echo esc_attr( $this->Options['field_zindex'] ); ?>" />  
 		    <span class="description"><?php _e( 'Input bigger value if object is not visible.', 'sv-sticky-menu' ); ?></span>
                  </td></tr>

                  <tr>
                  <th scope="row"><?php _e('Show shadow','sv-sticky-menu');  ?>:</th>
                  <td> 
                    <input name="sv-sticky-menu-page-options[field_shadow]" id="field_shadow" 
                         onclick="jQuery('#block_shadow').fadeToggle();" 
                         type="checkbox" value="true"  <?php echo esc_attr( $this->Options['field_shadow']=='true' ? 'checked' : '' ); ?> />  
 		    <span class="description"><?php _e( 'Set for display shadow.', 'sv-sticky-menu' ); ?></span>
                  </td></tr>

                </tbody></table>                            

           <div id="block_shadow" class="postbox" style="display:<?php echo ($this->Options['field_shadow']=='true' ? 'block' : 'none'); ?>;">
           <div class="inside" >
		<h2><?php echo ( __('Shadow Options', 'sv-sticky-menu' ) ); ?> </h2>
                <?php echo ( __('In this section options for shadow.', 'sv-sticky-menu' ) ); ?>
		<table class="form-table"><tbody>

                  <tr>
                  <th scope="row"><?php _e('Shadow color','sv-sticky-menu');  ?>:</th>
                  <td> 
                    <input name="sv-sticky-menu-page-options[field_shadow_color]" id="field_shadow_color" class="colorfield" type="color" value="<?php echo esc_attr( $this->Options['field_shadow_color'] ); ?>" />  
 		    <span class="description"><?php _e( 'Select shadow color.', 'sv-sticky-menu' ); ?></span>
                  </td></tr>

                  <tr>
                  <th scope="row"><?php _e('Shadow opacity','sv-sticky-menu');  ?>:</th>
                  <td> 
                    <input name="sv-sticky-menu-page-options[field_shadow_opacity]" id="field_shadow_opacity" type="number" min="0" max="1" step="0.01" size="5" value="<?php echo esc_attr( $this->Options['field_shadow_opacity'] ); ?>" />  
 		    <span class="description"><?php _e( 'Select shadow transparency ( from 0 to 1 default 0.25).', 'sv-sticky-menu' ); ?></span>
                  </td></tr>

                </tbody></table>                            
           </div></div>


		<table class="form-table"><tbody>
                  <tr>
                  <th scope="row"><?php _e('Show logo','sv-sticky-menu');  ?>:</th>
                  <td> 
                    <input name="sv-sticky-menu-page-options[field_logo]" id="field_logo" 
                           onclick="jQuery('#block_logo').fadeToggle();" 
		           type="checkbox" value="true"  <?php echo esc_attr( $this->Options['field_logo']=='true' ? 'checked' : '' ); ?> />  
 		    <span class="description"><?php _e( 'Set for display logo.', 'sv-sticky-menu' ); ?></span>
                  </td></tr>
                </tbody></table>                            

           <div id="block_logo" class="postbox" style="display:<?php echo ($this->Options['field_logo']=='true' ? 'block' : 'none'); ?>;">
           <div class="inside">  
		<h2><?php echo ( __('Logo Options', 'sv-sticky-menu' ) ); ?> </h2>
                <?php echo ( __('In this section options for logo setup.', 'sv-sticky-menu' ) ); ?>
		<table class="form-table"><tbody>

                  <tr>
                  <th scope="row"><?php _e('Logo image','sv-sticky-menu');  ?>:</th>
                  <td> 
                    <input name="sv-sticky-menu-page-options[field_logo_img]" id="field_logo_img" type="text" size="70" readonly value="<?php echo esc_attr( $this->Options['field_logo_img'] ); ?>" />  
                    <input  id="upload_image_button" type="button" value="..." class="button button-secondary" />  
 		    <span class="description"><?php _e( 'Select logo image from media library.', 'sv-sticky-menu' ); ?></span>
                    <p>  <img  id="logo_img_view" style="height:<?php echo $this->Options['field_logo_height'] ?>px;" src="<?php echo $this->Options['field_logo_img'] ?>" /></p>
                    <script type="text/javascript">
                       	jQuery(document).ready(function() {
				var file_frame;
				jQuery('#upload_image_button').on('click', function( event ){
					event.preventDefault();

					// If the media frame already exists, reopen it.
					if (file_frame) {
						file_frame.open();
						return;
					}
									
					// Create the media frame.
					file_frame = wp.media.frames.file_frame = wp.media({
						title: '<?php _e('Upload a logo', $this -> plugin_name); ?>',
						button: {
							  text: '<?php _e('Select as Logo Image', $this -> plugin_name); ?>',
							},
							multiple: false  // Set to true to allow multiple files to be selected
						});
										
						// When an image is selected, run a callback.
						file_frame.on( 'select', function() {
							// We set multiple to false so only get one image from the uploader
							attachment = file_frame.state().get('selection').first().toJSON();
										
							// Do something with attachment.id and/or attachment.url here
							jQuery('#field_logo_img').val(attachment.url);
							jQuery('#logo_img_view').attr('src', attachment.url);
						});
									
					// Finally, open the modal
					file_frame.open();
				});
                       	});
                    </script>
                  </td></tr>

                  <tr>
                  <th scope="row"><?php _e('Logo height','sv-sticky-menu');  ?>:</th>
                  <td> 
                    <input name="sv-sticky-menu-page-options[field_logo_height]" id="field_logo_height"  
                           onchange="jQuery('#logo_img_view').css ('height', jQuery(this)[0].value + 'px'  );" 
                           onkeyup="jQuery('#logo_img_view').css ('height', jQuery(this)[0].value + 'px'  );" 
                           type="number" min="1" max="9999" step="1" size="4" value="<?php echo esc_attr( $this->Options['field_logo_height'] ); ?>"  />  
 		    <span>px</span>
 		    <span class="description"><?php _e( 'Input logo height.', 'sv-sticky-menu' ); ?></span>
		    <span class="howto"><?php _e('Logo will be inserted as first child element of object. Logo height must be
                                                  lower then sticked object height. In some cases logo can push menu elements to second row. 
                                                  In this case do not use logo or decrease logo height.', $this -> plugin_name); ?></span>
                  </td></tr>

                  <tr>
                  <th scope="row"><?php _e('Logo URL','sv-sticky-menu');  ?>:</th>
                  <td> 
                    <input name="sv-sticky-menu-page-options[field_logo_url]" id="field_logo_url"  type="url" class="regular-text" value="<?php echo esc_attr( $this->Options['field_logo_url'] ); ?>" placeholder="http://mysite.com/home" />  
 		    <span class="description"><?php _e( 'Input url for logo click navigation.', 'sv-sticky-menu' ); ?></span>
                  </td></tr>
		
                </tbody></table>                            
           </div></div>

                <?php 
 		  submit_button(); 
		?>
		</form>
	</div>
	<?php
   }
}

if( is_admin() )
  $options_page = new CSvStickyMenu();

function init_stylesheet_content() {
         $options = get_option ('sv-sticky-menu-page-options');
      ?>
      <style type="text/css">
 	<?php echo $options['field_css_selector'] ?> { z-index: <?php echo $options['field_zindex'] ?>; }
        #sticky-logo { float: left; height: <?php echo $options['field_logo_height'] ?>px; padding: 0 10px; } 
        .sticky-transparency { filter: alpha(opacity=<?php echo intval($options['field_opacity']*100); ?>);
  	   opacity: <?php echo $options['field_opacity']; ?>;
	}
	<?php 
            $hex = $options['field_shadow_color'];
            //echo '/*' .  $hex . '*/';
	    if ( strlen($hex) == 3 ) {
              $r = hexdec(substr($hex,1,1).substr($hex,0,1));  
              $g = hexdec(substr($hex,2,1).substr($hex,1,1));
              $b = hexdec(substr($hex,3,1).substr($hex,2,1));
           } else {
	      $r = hexdec(substr($hex,1,2));
              $g = hexdec(substr($hex,3,2));
              $b = hexdec(substr($hex,5,2));
	   }
        ?>
        .sticky-shadow {
 	 -webkit-box-shadow: 3px 5px 5px rgba(<?php echo $r . ',' . $g . ',' . $b . ', ' . $options['field_shadow_opacity'] ?> ); 
 	    -moz-box-shadow: 3px 5px 5px rgba(<?php echo $r . ',' . $g . ',' . $b . ', ' . $options['field_shadow_opacity'] ?> );
          	 box-shadow: 3px 5px 5px rgba(<?php echo $r . ',' . $g . ',' . $b . ', ' . $options['field_shadow_opacity'] ?> );
	}
        .fixedmenu { position: fixed; width: 100%; top: 0px; 
        <?php if ( $options['field_set_bgcolor'] == 'true' ) : ?>
               background-color: <?php echo $options['field_bgcolor'] ?>; 
        <?php endif; ?>   
        }
	.fixedmenu:hover { opacity : 1; }
        <?php if ( $options['field_transition'] == 'slide' ) : ?>
        /* Transition slide */
	.outside { top: <?php echo $options['field_slide_start']; ?>px; }   
	.onside { top: 0px; }   
        .fixedtransition {
  	  -webkit-transition: top <?php echo $options['field_transition_time']; ?>s ease-in-out;
               -o-transition: top <?php echo $options['field_transition_time']; ?>s ease-in-out;
                  transition: top <?php echo $options['field_transition_time']; ?>s ease-in-out;
        }
        <?php elseif ( $options['field_transition'] == 'fade' ) : ?>
        /* Transition fade */
	.outside { filter: alpha(opacity=0); opacity: 0; }   
	.onside { filter: alpha(opacity=<?php echo intval($options['field_opacity']*100);?>); opacity: <?php echo $options['field_opacity']; ?>; }   
        .fixedtransition {
  	  -webkit-transition: opacity <?php echo $options['field_transition_time']; ?>s linear;
               -o-transition: opacity <?php echo $options['field_transition_time']; ?>s linear;
                  transition: opacity <?php echo $options['field_transition_time']; ?>s linear;
        }
        <?php elseif ( $options['field_transition'] == 'scale' ) : ?>
        /* Transition scale */
	.outside {
  	  -webkit-transform: scale(0, 0);
              -ms-transform: scale(0, 0);
               -o-transform: scale(0, 0);
                  transform: scale(0, 0);
        }   
	.onside {
  	  -webkit-transform: scale(1, 1);
              -ms-transform: scale(1, 1);
               -o-transform: scale(1, 1);
                  transform: scale(1, 1);
        }   
       .fixedtransition {
  	  -webkit-transition: -webkit-transform <?php echo $options['field_transition_time']; ?>s ease-out;
               -o-transition:      -o-transform <?php echo $options['field_transition_time']; ?>s ease-out;
                  transition:         transform <?php echo $options['field_transition_time']; ?>s ease-out;
       }
        <?php elseif ( $options['field_transition'] == 'rotate' ) : ?>
        /* Transition rotate */
	.outside {
  	  -webkit-transform: rotateX(90deg);
              -ms-transform: rotateX(90deg);
               -o-transform: rotateX(90deg);
                  transform: rotateX(90deg);
        }   
	.onside {

  	  -webkit-transform: rotateX(360deg);
              -ms-transform: rotateX(360deg);
               -o-transform: rotateX(360deg);
                  transform: rotateX(360deg);
        }   
       .fixedtransition {
     -webkit-transform-origin: 0% 100%;
	 -ms-transform-origin: 0% 100%;
     	     transform-origin: 0% 100%;

  	  -webkit-transition: -webkit-transform <?php echo $options['field_transition_time']; ?>s ease-out;
               -o-transition:      -o-transform <?php echo $options['field_transition_time']; ?>s ease-out;
                  transition:         transform <?php echo $options['field_transition_time']; ?>s ease-out;
       }
        <?php elseif ( $options['field_transition'] == 'skew' ) : ?>
        /* Transition Skew */
	.outside {
  	  -webkit-transform: skewX(90deg);
              -ms-transform: skewX(90deg);
               -o-transform: skewX(90deg);
                  transform: skewX(90deg);
        }   
	.onside {
  	  -webkit-transform: skewX(0deg);
              -ms-transform: skewX(0deg);
               -o-transform: skewX(0deg);
                  transform: skewX(0deg);
        }   
       .fixedtransition {
  	  -webkit-transition: -webkit-transform <?php echo $options['field_transition_time']; ?>s ease-out;
               -o-transition:      -o-transform <?php echo $options['field_transition_time']; ?>s ease-out;
                  transition:         transform <?php echo $options['field_transition_time']; ?>s ease-out;
       }
        <?php elseif ( $options['field_transition'] == 'custom' ) : ?>
        /* Transition from css/style.css */

        <?php endif; ?>   

      </style>
     <?php  
   }
add_action( 'wp_head', 'init_stylesheet_content' );

function enqueue_client_scripts () {
        $options = get_option ('sv-sticky-menu-page-options');

	if ( $options['field_transition'] == 'custom' ) {
  	  wp_register_style( 'sv-sticky-menu-stylesheet', plugins_url( 'css/style.css', __FILE__ ), false, SVSM_VERSION );
	  wp_enqueue_style( 'sv-sticky-menu-stylesheet' );
	}

	wp_register_script( 'sv-sticky-menu-script', plugins_url( 'js/sv-sticky-menu.min.js', __FILE__ ), false, SVSM_VERSION, false );
	wp_enqueue_script( 'sv-sticky-menu-script' );
	$script_data = array( 
		    'selector' => $options['field_css_selector'],
		    'selector_hide' => $options['field_css_hide'],
                    'zindex' => $options['field_zindex'],
		    'logo' => $options['field_logo'],
		    'min_media' => $options['field_min_media'],
		    'logo_img' => $options['field_logo_img'],
		    'logo_url' => $options['field_logo_url'],
		    'shadow' => $options['field_shadow']
		);
	wp_localize_script( 'sv-sticky-menu-script', 'SVSTDDATA', $script_data );
   }
add_action( 'wp_enqueue_scripts', 'enqueue_client_scripts' );	

