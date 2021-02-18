<?php 
# DFN Image Text Embedder
# John Nebel (digifuzz@gmail.com)	
# -------------------------------------------------
# Grabs an image, embeds text, returns the result.			
function dfn_image_text_embed( $w_image, $w_font, $w_text, $w_size, $w_rotation, $w_color, $w_x, $w_y ) 
{
    # Create a copy of the image to work with.
    $new_image = ImageCreateFromJPEG( $w_image );

    # Set the color we want to use for the text - we're using white here.	
    $w_rgb = hex2rgb( $w_color );
    $w_color = imagecolorallocate( $new_image, $w_rgb[0], $w_rgb[1], $w_rgb[2] );

    ImageTTFText($new_image,$w_size,$w_rotation,$w_x,$w_y,$w_color,$w_font,$w_text );

    # Create the image and display it!
    header("Content-Type: image/JPEG");
    ImageJPEG( $new_image );

    # Clean up and free memory
    imagedestroy( $new_image );		
}

# Converts a hexadecimal color value and returns an array containing
# the rgb values.
function hex2rgb( $color )
{
    $color = str_replace( "#", "", $color );
    if( strlen( $color ) != 6 )
    { 
        return array(0,0,0); 
    }    
    $rgb = array();

    for( $x = 0; $x < 3; $x++ )     {         $rgb[$x] = hexdec( substr( $color,( 2 * $x ), 2 ) );     }     return $rgb; } # Grab query string variables # ----------------------------------------------------------------- # Path to image file: ie: /img/my_image.jpg.  If the image is being # pulled from a remote server, simply remove $_SERVER['DOCUMENT_ROOT'] # and enter a valid web url - ie:  http://www.myhost.com/myimage.jpg. $get_image 	= 	$_SERVER['DOCUMENT_ROOT'] . $_GET['image']; # Path to valid ttf file: ie: /fonts/my_font.ttf.  This too can be # called remotely, same as for the original image file. $get_font 	=	$_SERVER['DOCUMENT_ROOT'] . $_GET['font']; $get_text 	= 	$_GET['text']; 		# Text to Overlay $get_size	= 	$_GET['size']; 		# Font size (in px) $get_rotation	= 	$_GET['rotation'];	# Angle of text $get_color	=	$_GET['color'];		# Color in hex (without '#') $get_x 		= 	$_GET['x'];		# Coordinates on image where $get_y		=	$_GET['y'];		# - we are placing overlay. # Call the function and make the magic happen. dfn_image_text_embed( $get_image, $get_font, $get_text, $get_size, $get_rotation, $get_color, $get_x, $get_y ); ?>