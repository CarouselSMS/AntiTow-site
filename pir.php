<?php
/*
    Dynamic Heading Generator
    By Stewart Rosenberger
    http://www.stewartspeak.com/headings/ 

	Extensively modified and extended by TJ Atkins   

    This script generates PNG images of text, written in
    the font/size that you specify. These PNG images are passed
    back to the browser. Optionally, they can be cached for later use. 
    If a cached image is found, a new image will not be generated,
    and the existing copy will be sent to the browser.

    Additional documentation on PHP's image handling capabilities can
    be found at http://www.php.net/image/    
*/

$font_folder = "./fonts/";
$font_file  = isset( $_GET['font'] ) ? $font_folder . $_GET['font'] : $FONT_FOLDER . 'ocrbs.ttf';
$font_size  = isset( $_GET['size'] ) ? (substr($_GET['size'],-2) == "px" ? .77 : 1) * intval( $_GET['size'] ) : 50 ; //approximate conversion from pixels to points
$font_color = isset( $_GET['color'] ) ? $_GET['color'] : '#000000' ;
$background_color = isset( $_GET['bgcolor'] ) ? $_GET['bgcolor'] : '#ffffff' ;
$cache_images = isset( $_GET['cache'] ) ? !!$_GET['cache'] : true ;
$cache_folder = 'cache' ;







/*
  ---------------------------------------------------------------------------
   For basic usage, you should not need to edit anything below this comment.
   If you need to further customize this script's abilities, make sure you
   are familiar with PHP and its image handling capabilities.
  ---------------------------------------------------------------------------
*/

$mime_type = 'image/png' ;
$extension = '.png' ;
$send_buffer_size = 4096 ;

// check for GD support
if(!function_exists('ImageCreate')) {
    fatal_error('Error: Server does not support PHP image generation');
}

// clean up text
if(empty($_GET['text'])) {
    fatal_error('Error: No text specified.') ;
}
    
$text = $_GET['text'] ;
if(get_magic_quotes_gpc()) {
    $text = stripslashes($text) ;
}
$text = urldecode($text);

// look for cached copy, send if it exists
$hash = md5(basename($font_file) . $font_size . $font_color . $background_color . $transparent_background . $text);
$cache_filename = $cache_folder . '/' . $hash . $extension ;
if( $cache_images && ( $file = @fopen( $cache_filename, 'rb' ) ) ) {
    header('Content-type: ' . $mime_type);
    while(!feof($file)) {
        print(($buffer = fread($file,$send_buffer_size)));
	}
    fclose($file);
    exit;
}

// check font availability
$font_found = is_readable($font_file) ;
if(!$font_found) {
    fatal_error('Error: The server is missing the specified font.') ;
}

// create image
$background_rgba = extract_color($background_color);
$font_rgba = extract_color($font_color);
$dip = get_dip($font_file,$font_size);
$box = @ImageTTFBBox($font_size,0,$font_file,$text);
$image = @ImageCreatetruecolor(abs($box[2]-$box[0])+1,abs($box[5]-$dip));
if(!$image || !$box) {
    fatal_error('Error: The server could not create this heading image.');
}

imagealphablending($image,false);
imagesavealpha($image,true);







// allocate colors and draw text
$background_color = ImageColorAllocateAlpha($image,$background_rgba[0], $background_rgba[1],$background_rgba[2], $background_rgba[3]);
imagefill( $image, 0, 0, $background_color );

$font_color = ImageColorAllocateAlpha($image,$font_rgba[0], $font_rgba[1],$font_rgba[2], $font_rgba[3]);
ImageTTFText($image,$font_size,0,-$box[0],abs($box[5]-$box[3])-$box[1], $font_color,$font_file,$text);


header('Content-type: ' . $mime_type) ;
ImagePNG($image) ;





// save copy of image for cache
if($cache_images)
{
    @ImagePNG($image,$cache_filename) ;
}

ImageDestroy($image) ;
exit ;


/*
	try to determine the "dip" (pixels dropped below baseline) of this
	font for this size.
*/
function get_dip($font,$size)
{
	$test_chars = 'abcdefghijklmnopqrstuvwxyz' .
			      'ABCDEFGHIJKLMNOPQRSTUVWXYZ' .
				  '1234567890' .
				  '!@#$%^&*()\'"\\/;.,`~<>[]{}-+_-=' ;
	$box = @ImageTTFBBox($size,0,$font,$test_chars) ;
	return $box[3] ;
}


/*
    attempt to create an image containing the error message given. 
    if this works, the image is sent to the browser. if not, an error
    is logged, and passed back to the browser as a 500 code instead.
*/
function fatal_error($message)
{
    // send an image
    if(function_exists('ImageCreate'))
    {
        $width = ImageFontWidth(5) * strlen($message) + 10 ;
        $height = ImageFontHeight(5) + 10 ;
        if($image = ImageCreate($width,$height))
        {
            $background = ImageColorAllocate($image,255,255,255) ;
            $text_color = ImageColorAllocate($image,0,0,0) ;
            ImageString($image,5,5,5,$message,$text_color) ;    
            
            ImagePNG($image) ;
            ImageDestroy($image) ;
            exit ;
        }
    }

    // send 500 code
    header("HTTP/1.0 500 Internal Server Error") ;
    print($message) ;
    exit ;
}


/* 
    decode an HTML color into an array of rgb values
*/
function extract_color( $color ) {
	$svg_colors = array( "aliceblue" => "f0f8ff", "antiquewhite" => "faebd7", "aqua" => "00ffff", "aquamarine" => "7fffd4", "azure" => "f0ffff", "beige" => "f5f5dc", "bisque" => "ffe4c4", "black" => "000000", "blanchedalmond" => "ffebcd", "blue" => "0000ff", "blueviolet" => "8a2be2", "brown" => "a52a2a", "burlywood" => "deb887", "cadetblue" => "5f9ea0", "chartreuse" => "7fff00", "chocolate" => "d2691e", "coral" => "ff7f50", "cornflowerblue" => "6495ed", "cornsilk" => "fff8dc", "crimson" => "dc143c", "cyan" => "00ffff", "darkblue" => "00008b", "darkcyan" => "008b8b", "darkgoldenrod" => "b8860b", "darkgray" => "a9a9a9", "darkgreen" => "006400", "darkgrey" => "a9a9a9", "darkkhaki" => "bdb76b", "darkmagenta" => "8b008b", "darkolivegreen" => "556b2f", "darkorange" => "ff8c00", "darkorchid" => "9932cc", "darkred" => "8b0000", "darksalmon" => "e9967a", "darkseagreen" => "8fbc8f", "darkslateblue" => "483d8b", "darkslategray" => "2f4f4f", "darkslategrey" => "2f4f4f", "darkturquoise" => "00ced1", "darkviolet" => "9400d3", "deeppink" => "ff1493", "deepskyblue" => "00bfff", "dimgray" => "696969", "dimgrey" => "696969", "dodgerblue" => "1e90ff", "firebrick" => "b22222", "floralwhite" => "fffaf0", "forestgreen" => "228b22", "fuchsia" => "ff00ff", "gainsboro" => "dcdcdc", "ghostwhite" => "f8f8ff", "gold" => "ffd700", "goldenrod" => "daa520", "gray" => "808080", "green" => "008000", "greenyellow" => "adff2f", "grey" => "808080", "honeydew" => "f0fff0", "hotpink" => "ff69b4", "indianred" => "cd5c5c", "indigo" => "4b0082", "ivory" => "fffff0", "khaki" => "f0e68c", "lavender" => "e6e6fa", "lavenderblush" => "fff0f5", "lawngreen" => "7cfc00", "lemonchiffon" => "fffacd", "lightblue" => "add8e6", "lightcoral" => "f08080", "lightcyan" => "e0ffff", "lightgoldenrodyellow" => "fafad2", "lightgray" => "d3d3d3", "lightgreen" => "90ee90", "lightgrey" => "d3d3d3", "lightpink" => "ffb6c1", "lightsalmon" => "ffa07a", "lightseagreen" => "20b2aa", "lightskyblue" => "87cefa", "lightslategray" => "778899", "lightslategrey" => "778899", "lightsteelblue" => "b0c4de", "lightyellow" => "ffffe0", "lime" => "00ff00", "limegreen" => "32cd32", "linen" => "faf0e6", "magenta" => "ff00ff", "maroon" => "800000", "mediumaquamarine" => "66cdaa", "mediumblue" => "0000cd", "mediumorchid" => "ba55d3", "mediumpurple" => "9370db", "mediumseagreen" => "3cb371", "mediumslateblue" => "7b68ee", "mediumspringgreen" => "00fa9a", "mediumturquoise" => "48d1cc", "mediumvioletred" => "c71585", "midnightblue" => "191970", "mintcream" => "f5fffa", "mistyrose" => "ffe4e1", "moccasin" => "ffe4b5", "navajowhite" => "ffdead", "navy" => "000080", "oldlace" => "fdf5e6", "olive" => "808000", "olivedrab" => "6b8e23", "orange" => "ffa500", "orangered" => "ff4500", "orchid" => "da70d6", "palegoldenrod" => "eee8aa", "palegreen" => "98fb98", "paleturquoise" => "afeeee", "palevioletred" => "db7093", "papayawhip" => "ffefd5", "peachpuff" => "ffdab9", "peru" => "cd853f", "pink" => "ffc0cb", "plum" => "dda0dd", "powderblue" => "b0e0e6", "purple" => "800080", "red" => "ff0000", "rosybrown" => "bc8f8f", "royalblue" => "4169e1", "saddlebrown" => "8b4513", "salmon" => "fa8072", "sandybrown" => "f4a460", "seagreen" => "2e8b57", "seashell" => "fff5ee", "sienna" => "a0522d", "silver" => "c0c0c0", "skyblue" => "87ceeb", "slateblue" => "6a5acd", "slategray" => "708090", "slategrey" => "708090", "snow" => "fffafa", "springgreen" => "00ff7f", "steelblue" => "4682b4", "tan" => "d2b48c", "teal" => "008080", "thistle" => "d8bfd8", "tomato" => "ff6347", "turquoise" => "40e0d0", "violet" => "ee82ee", "wheat" => "f5deb3", "white" => "ffffff", "whitesmoke" => "f5f5f5", "yellow" => "ffff00", "yellowgreen" => "9acd32" );
	if( preg_match( "/^#?([0-9a-fA-F])([0-9a-fA-F])([0-9a-fA-F])$/", $color, $matches ) ) {
		//three-digit hex
		return array( hexdec($matches[1] . $matches[1]), hexdec($matches[2] . $matches[2]), hexdec($matches[3] . $matches[3]), 0 );
	} elseif( preg_match( "/^#?([0-9a-fA-F]{2,2})([0-9a-fA-F]{2,2})([0-9a-fA-F]{2,2})$/", $color, $matches ) ) {
		//six-digit hex
		return array( hexdec($matches[1]), hexdec($matches[2]), hexdec($matches[3]), 0 );
	} elseif( preg_match( "/^rgb[^0-9]*([0-9]*)[^0-9]*([0-9]*)[^0-9]*([0-9]*)[^0-9]*$/", $color, $matches ) ) {
		// three-part rgb
		return array( $matches[1], $matches[2], $matches[3], 0 );
	} elseif( preg_match( "/^rgba[^0-9]*([0-9]*)[^0-9]*([0-9]*)[^0-9]*([0-9]*)[^0-9]*(0?\.?[0-9]*)[^0-9]*$/", $color, $matches ) ) {
		// four-part rgba
		return array( $matches[1], $matches[2], $matches[3], floor((1-$matches[4])*127) );
	} elseif( $color == "transparent" ) {
		return array( 255, 255, 255, 127 );
	} elseif( $svg_colors[$color] ) { 
		preg_match( "/^([0-9a-fA-F]{2,2})([0-9a-fA-F]{2,2})([0-9a-fA-F]{2,2})$/", $svg_colors[$color], $matches );
		return array( hexdec($matches[1]), hexdec($matches[2]), hexdec($matches[3]), 0 );
	} else {
		// something else, just bail to white
		return array( 255, 255, 255, 0 );
	}
}



?>