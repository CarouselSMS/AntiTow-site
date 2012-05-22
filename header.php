<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" <?php sandbox_blog_lang(); ?>>

<head profile="http://gmpg.org/xfn/11">

  <title><?php bloginfo('name'); if ( is_404() ) : _e(' &raquo; ', 'sandbox'); _e('Not Found', 'sandbox'); elseif ( is_home() ) : _e(' &raquo; ', 'sandbox'); bloginfo('description'); else : wp_title(); endif; ?></title>

  <meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
  <meta name="verifyownership" content="495396f979e8e198661cf31b9e239355" />
  <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />

  <!--[if lt IE 7]>
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/iealternate.css" type="text/css" media="screen" />
  <![endif]-->

  <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url') ?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?> <?php _e('Posts RSS feed', 'sandbox'); ?>" />
  <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?> <?php _e('Comments RSS feed', 'sandbox'); ?>" />
  <link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />
  <link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico" />

  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

  <?php wp_head() ?>

  <meta name="verify-v1" content="IQS6mC+WDcILB3HE2ksVLnWHWpaTgG36xa1xhkOxwCM=" />
  <meta name="google-site-verification" content="wUNqv-m2cWbqhsGqVKnetwa6I9bjIsZA3NHgkSPlQ0k" />

</head>

<?php
  if($post->post_parent) {
    $parent_title = get_the_title($post->post_parent);
  }
  else {
    $parent_title = get_the_title();
  }
?>

<?php
  $searchArray = array(" ", "-&#8211;-", "ñ");
  $replaceArray = array("-", "-", "n");
  $intoString = $parent_title;
?>

<body class="<?php sandbox_body_class() ?> <?php echo str_replace($searchArray, $replaceArray, $intoString) ?>">

<div id="wrapper" class="hfeed">
  <div id="header">
    <a class="header-home-link" href="<?php echo get_settings('home') ?>/" title="<?php bloginfo('name') ?>" rel="home">AntiTow street-sweeping and parking alerts home</a>
    <h1>
      <a class="blog-title" href="<?php echo get_settings('home') ?>/" title="<?php bloginfo('name') ?>" rel="home"><?php bloginfo('name') ?></a>
      <a class="description-tag" href="<?php echo get_settings('home') ?>/" title="<?php bloginfo('name') ?>" rel="home"> | <?php bloginfo('description') ?></a>
    </h1>

    <div class="cities">
      <h3>Select your city:</h3>
      <ul>
        <li>
          <a href="<?php echo get_settings('home') ?>/columbus" class="Columbus">Columbus</a>&nbsp;&#47;
        </li>
        <li>
          <a href="<?php echo get_settings('home') ?>/chicago" class="Chicago">Chicago</a> (<a href="<?php echo get_settings('home') ?>/chicago-espanol" class="Chicago-Espanol">Español</a>)
        </li>
      </ul>
    </div>

    <div id="nav">

      <div id="mainNav">
        <?php
          if($post->post_parent)
            $children = wp_list_pages("sort_column=menu_order&title_li=&child_of=".$post->post_parent."&echo=0");
          else
            $children = wp_list_pages("sort_column=menu_order&title_li=&child_of=".$post->ID."&echo=0");
          if ($children) { ?>
            <ul>
              <?php echo $children; ?>
            </ul>
        <?php } ?>
      </div>

      <div id="subNav">
        <ul>
         <li class="first-item">
           <h3><a href="<?php echo get_settings('home') ?>/faq/" class="sNav">FAQ</a></h3>
         </li>
         <li>
           <h3><a href="<?php echo get_settings('home') ?>/about/" class="sNav">About</a></h3>
         </li>
         <li>
           <h3><a href="<?php echo get_settings('home') ?>/contact/" class="sNav">Contact</a></h3>
         </li>
         <li>
           <h3><a href="<?php echo get_settings('home') ?>/antitow-availability/" class="sNav">Availability</a></h3>
         </li>
        </ul>
      </div>

    </div>

  </div>

<iframe id="temp-iframe" name="temp-iframe">temporary container</iframe>

<!--  #header -->
