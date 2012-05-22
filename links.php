<?php
/*
Template Name: Links Page
*/
?>
<?php get_header() ?>
	
	<div id="container">
		<div id="content" class="links">
		<ul>		
		<?php wp_list_bookmarks('category=35&title_after=</h2>&between=<br/>&show_description=true'); ?>
		
		<?php wp_list_bookmarks('category=2&title_after=</h2>&between=<br/>&show_description=true'); ?>
				
		<?php wp_list_bookmarks('category=36&title_after=</h2>&between=<br/>&show_description=true'); ?>
 </ul>
 <div class="clear"></div>
		</div><!-- #content -->
	</div><!-- #container -->
<?php include (TEMPLATEPATH . '/bottom.php'); ?>	
<?php get_footer() ?>