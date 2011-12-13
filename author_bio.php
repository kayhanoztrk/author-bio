<?php
/*
Plugin Name: Author Bio
Plugin URI: http://www.kayhanozturk.org
Description: Show about author's bio with social icons.
Author: Kayhan Öztürk
Version: 1.0
Author URI: http://www.kayhanozturk.org
*/

function author_bio($content)
{
	
	$options['page'] = get_option('show_page');
	$options['post'] = get_option('show_post');
	$options['posts_count']=get_option('posts_count');
	$options['twitter']=get_option('twitter'); 
	$options['facebook']=get_option('facebook');
	$options['friendfeed']=get_option('friendfeed');
	$options['tumblr']=get_option('tumblr');
	
	
	
	$images_dir = plugins_url()."/author-bio"."/images/";
	
	if ( (is_single() && $options['post']) || (is_page() && $options['page']) )
	{
		$author_site=get_the_author_meta('url');
		
		if(get_the_author_meta('description')=="")
			$author_description="";
		else
			$author_description=get_the_author_meta('description');
		$author_box = 
		'<div id="author_bio_box">
			<div class="picBox">'.get_avatar( get_the_author_meta('user_email'), '80' ).'</div>
			<span class="author_name">'.get_the_author_meta('display_name').'</span>
			<p>'.$author_description.'</p>
			<div class="author_social"><a href="'.get_the_author_meta('url').'"'.'target="_blank" ><img src="'.$images_dir.'wordpress.png" title="Yazarın Web Sitesi"/></a>';
		
		if($options['facebook'])
			{
			$author_box.='<a href="http://facebook.com/'.$options["facebook"].'" '.'target="_blank" /><img src="'.$images_dir.'facebook.png" title="Facebook"/></a>';
			}
			
			if($options['twitter'])
			{
			$author_box.='<a href="http://twitter.com/'.$options["twitter"].'"'.'target="_blank" /><img src="'.$images_dir.'twitter.png"  title="Twitter" /></a>';
			}
		
			if($options['friendfeed'])
			{
			
			$author_box.='<a href="http://friendfeed.com/'.$options["friendfeed"].'" '.'target="_blank" /><img src="'.$images_dir.'friendfeed.png" title="Friendfeed"/></a>';
			}
			if($options['tumblr'])
			{
			
			$author_box.='<a href="http://'.$options["tumblr"].'.tumblr.com" '.'target="_blank" /><img src="'.$images_dir.'tumblr.png" title="Tumblr"/></a>';
			}
		$author_box.='</div>'; 
		  if($options['posts_count'])
		  {
			$author_box.='<div class="taban"><p>Toplam'.' '.'<b>'.(int)get_the_author_posts().'</b>'.'  '.'adet yazısı var</p></div>
		</div>';
		}
		if(!$options['posts_count'])
		{
		 $author_box.='<div class="taban"></div>
		</div>';
		}
		
		return $content . $author_box;
	} else {
		return $content;
	}
}

function author_bio_style()
{
	
		echo 
	'<style type=\'text/css\'>
	#author_bio_box {
		border: 1px solid gray;
		background: white;
		padding: 5px;
		border-radius: 10px; 
    	-moz-border-radius: 10px; 
   		-webkit-border-radius: 10px; 

	}
	
	.picBox {
    	background: url(golge.gif) no-repeat bottom right;
    	clear: right;
    	float: left;
		border-radius: 10px; 
    	-moz-border-radius: 10px; 
   		-webkit-border-radius: 10px; 
	}
	.picBox img {
    	background-color: #fff;
		border: 1px solid;
		padding: 3px;
		margin: -2px 2px 2px -2px;
		border-radius: 5px;
    	-moz-border-radius: 5px; 
   		-webkit-border-radius: 5px; 
	}
	
	#author_bio_box img {
		float: left;
		margin-right: 10px;
	}
	
	#author_bio_box .author_name {
		font-weight: bold;
		margin: 0px;
		font-size: 14px;
	}
	
	
	#author_bio_box p {
		font-size: 13px;
		line-height: 14px;
		font-style: italic;
	}
	
	.author_social {
		font-weight: bold;
		font-size: 14px;
		float:left;
		text-align:center;
		padding-right:10px;
		padding-left:10px;
		padding-top:5px;
		padding-bottom:5px;
		
		background: #FFFFFF;
		

		
	}
	.author_social p {
	     float:right;
		 font-size:13px;
		 font-weight:bold;
		 }
	
	
	.taban { display: block; clear: both; }
	</style>';
}

function author_bio_settings()
{



echo '<script type="text/javascript" src="'.plugins_url().'/jquery.js"></script>
<script type="text/javascript" src="'.plugins_url().'/farbtastic.js"></script>
<link rel="stylesheet" href="'.plugins_url().'/farbtastic.css" type="text/css" />
<script type="text/javascript">
  $(document).ready(function() {
    $(\'#demo\').hide();
    var f = $.farbtastic(\'#picker\');
    var p = $(\'#picker\').css(\'opacity\', 0.25);
    var selected;
    $(\'.colorwell\')
      .each(function () { f.linkTo(this); $(this).css(\'opacity\', 0.75); })
      .focus(function() {
        if (selected) {
          $(selected).css(\'opacity\', 0.75).removeClass(\'colorwell-selected\');
        }
        f.linkTo(this);
        p.css(\'opacity\', 1);
        $(selected = this).css(\'opacity\', 1).addClass(\'colorwell-selected\');
      });
  });

</script>
<style type="text/css" media="screen">
   .colorwell {
     border: 2px solid #fff;
     width: 6em;
     text-align: center;
     cursor: pointer;
   }
   body .colorwell-selected {
     border: 2px solid #000;
     font-weight: bold;
   }
 </style>';

	if ($_POST['action'] == 'update')
	{
		
		$_POST['show_pages'] == 'on' ? update_option('show_page', 'checked') : update_option('show_page', '');
		$_POST['show_posts'] == 'on' ? update_option('show_post', 'checked') : update_option('show_post', '');
		$_POST['posts_count']=='on' ? update_option('posts_count','checked') : update_option('posts_count','');
		isset($_POST['twitter']) ? update_option('twitter',$_POST['twitter']) : update_option('twitter','');
		isset($_POST['facebook']) ? update_option('facebook',$_POST['facebook']) : update_option('facebook','');
	    isset($_POST['friendfeed'])? update_option('friendfeed',$_POST['friendfeed']): update_option('friendfeed','');
		isset($_POST['tumblr'])? update_option('tumblr',$_POST['tumblr']): update_option('tumblr','');
		$say = '<div id="message" class="updated fade"><p><strong>Changes Saved!</strong></p></div>';
	}
	
	$options['page'] = get_option('show_page');
	$options['post'] = get_option('show_post');
	$options['posts_count']=get_option('posts_count');
	$options['faceook']=get_option('facebook');
	$options['twitter']=get_option('twitter');
	$options['friendfeed']=get_option('friendfeed');
	$options['tumblr']=get_option('tumblr');
	
	
	echo '
	<div class="wrap">
		'.$say.'
		<div id="icon-options-general" class="icon32"><br /></div>
		<h2>Author Bio Settings</h2>
		
		<form method="post" action="">
		<input type="hidden" name="action" value="update" />
		
		<h3>Show in where?</h3>
		Show Pages:<input name="show_pages" type="checkbox" id="show_pages" '.$options['page'].' /> <br /> <br />
		Show Posts:<input name="show_posts" type="checkbox" id="show_posts" '.$options['post'].'" /> <br /> <br />
		Show posts count:<input name="posts_count" type="checkbox" id="posts_count" '.$options['posts_count'].'" /> <br /> <br />
		  <b>Twitter:<i>(user_name)</i></b><input name="twitter" type="text" id="twitter" value="'.$options["twitter"].'"  /> <br /> <br />
		  <b>Facebook:<i>(user_name)</i></b><input name="facebook" type="text" id="facebook" value="'.$options["facebook"].'" /> <br />
	
		<br />
		   <b>Tumblr:<i>(user_name)</i></b><input name="tumblr" type="text" id="tumblr" value="'.$options["tumblr"].'" /><br /> <br />
		     <b>Friendfeed:<i>(user_name)</i></b><input name="friendfeed" type="text" id="friendfeed" value="'.$options["friendfeed"].'" /> <br />
		<input type="submit" class="button-primary" value="Save" />
		</form>
		
	</div>';
}

function author_bio_admin_menu()
{
	add_options_page('Author_bio', 'Author_bio', 9, basename(__FILE__), 'author_bio_settings');
}

add_action('the_content', 'author_bio');
add_action('admin_menu', 'author_bio_admin_menu');
add_action('wp_head', 'author_bio_style');

?>