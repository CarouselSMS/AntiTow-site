/*	
	Javascript & PHP Image Replacement 
	Created by Tab Atkins Jr.
*/
(function($){

$.fn.pir = function( options ) {

	return $(this).hide().each(function(){ $.pir(this,options); }).show();
};

$.pir = function( elem, options ) {
	//Settings
	var $e = $(elem),
		meta = ($.metadata)?$(elem).metadata():{},
		o = $.extend(
				{ size: $e.css("font-size"), color: $e.css("color"), bgColor: $e.css("background-color"), text: $e.text().split("'").join("&#039;") },
				$.pir.options,
				meta,
				options),
		e = encodeURIComponent;
	

	
	$e.html(""); //clear out the current contents
	$.each( o.wrap ? o.text.split(" ") : [o.text], function() {
		if( $.trim(this) != "" ) {
			$e.append( "<img alt='" + e(this) + "' src='" + o.php + "?text=" + e(this) + "&font=" + e(o.font) + "&size=" + e(o.size) + "&color=" + e(o.color) + "&bgcolor=" + e(o.bgColor) + "'>" );
			$e.append( " " );
		}
	});

	if( o.prettyPrint ) {
		$("img", $e).addClass("pir-prettyprint-image");
		$("<span>" + o.text + "</span>").addClass("pir-prettyprint-text").appendTo($e);
		$("<style type='text/css' media='print'></style>").text(".pir-prettyprint-image { display: none; }").appendTo("head");
		$("<style type='text/css' media='screen'></style>").text(".pir-prettyprint-text { display: none; }").appendTo("head");
	};
	return $e;
};

//Defaults
$.pir.options = {
	php: "/pir.php",
	font: "denmark.ttf",
	wrap: false,
	prettyPrint: false
};

//Version
$.pir.version = "0.1";

//Auto-run
$(function(){ $(".pir").pir(); });

})(jQuery);

