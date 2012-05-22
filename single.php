<?php get_header() ?>
	<div id="container">
		<div id="content">
		
                <div class="left-col">
				<?php rewind_posts(); ?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php the_category(); ?>
				<h2 class="entry-title"><?php the_title(); ?></h2>
				<div class="excerpt"><?php the_excerpt(); ?></div>

<div class="author-desc"><p><?php the_author_description(); ?></p></div>
<div class="author-links">Author's articles <?php the_author_posts_link(); ?><br/>
<?php the_author(); ?>&rsquo;s <a href="<?php the_author_url(); ?>">Website</a>
<?php edit_post_link(__('Edit', 'sandbox'), "\n\t\t\t\t\t<span class=\"edit-link\">", "</span>"); ?></div>

				</div>




			<div id="post-<?php the_ID(); ?>" class="<?php sandbox_post_class(); ?>">
								<div class="entry-content">
								
<?php the_content(''.__('Read more <span class="meta-nav">&raquo;</span>', 'sandbox').''); ?>

<?php link_pages("\t\t\t\t\t<div class='page-link'>".__('Pages: ', 'sandbox'), "</div>\n", 'number'); ?>
				

<?php if (function_exists('the_tags') ) : ?>
<?php the_tags(); ?>
<?php endif; ?>

</div>
				

<div class="entry-meta">
<div id="comments-headline"><h2 class="comments-headline">WHAT TO DO NOW?</h2></div>
			<div class="entry-meta-content"><?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) : // Comments and trackbacks open ?>
					<?php printf(__('<a class="comment-link" href="#respond" title="Post a comment">Post a comment</a> or leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', 'sandbox'), get_trackback_url()) ?>
<?php elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) : // Only trackbacks open ?>
					<?php printf(__('Comments are closed, but you can leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', 'sandbox'), get_trackback_url()) ?>
<?php elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) : // Only comments open ?>
					<?php printf(__('Trackbacks are closed, but you can <a class="comment-link" href="#respond" title="Post a comment">post a comment</a>.', 'sandbox')) ?>
<?php elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) : // Comments and trackbacks closed ?>
					<?php _e('Both comments and trackbacks are currently closed.') ?>
<?php endif; ?></div>

</div>

		<div id="nav-below" class="navigation">
		<h3>Read</h3>
				<div class="nav-previous"><?php previous_post_link('<span class="meta-nav">&laquo;</span> %link') ?></div>
    <div class="nav-next"><?php next_post_link('<span class="meta-nav">&raquo;</span> %link') ?></div>
				<h3>Read in <?php
foreach((get_the_category()) as $cat) { 
echo $cat->cat_name . ' '; 
} ?></h3>
			<div class="nav-previous"><?php previous_post_link('&laquo; %link', '%title', TRUE); ?></div>
			<div class="nav-next"><?php next_post_link('&raquo; %link', '%title', TRUE); ?></div>

				<?php if ( function_exists('related_posts')) :?>
			<h3>Related Posts</h3>
			<ul>				
			<?php related_posts(); ?>
			</ul>
	
		<?php endif; ?>

			</div>

<?php comments_template(); ?>
<?php endwhile;?><?php endif; ?>
								
				<?php the_post(); ?>
		</div><!-- .post -->
		<?php get_sidebar() ?>
				</div><!-- #content -->

	</div><!-- #container -->
<?php include (TEMPLATEPATH . '/bottom.php'); ?>
<?php get_footer() ?>