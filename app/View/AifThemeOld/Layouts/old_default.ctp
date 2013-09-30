<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--[if lte IE 7 ]><html id="ie7" lang="en"> <![endif]-->
	<title><?php echo $title_for_layout; ?> &raquo; <?php echo strip_tags(Configure::read('Site.title')); ?></title>

	<?php
	echo $this->Meta->meta();
	echo $this->Layout->feed();
	echo $this->Layout->js();
	echo $this->Html->css(array(
	'old_style',
	));
	?>

	<!--[if IE 7]><?php echo $this->Html->css('ie7'); ?><![endif]-->
	<!--[if IE]><?php echo $this->Html->css('iefix'); ?><![endif]-->

	<link rel="shortcut icon" href="images/favicon.ico"  />

	<?php
	 echo $this->Html->script(array(
		'jquery-1.8.0.min',
		'jquery.smooth-scroll.min',
	));

	echo $this->Blocks->get('css');
	echo $this->Blocks->get('script');
	?>

</head>

<body>

<div id="wrapper" class="home">
	<div id="header">
    	<div class="container">
		<?php echo $this->Regions->blocks('header'); ?>     
        	<div class="logodiv"><h1 class="logo">
			<?php 
			$logoImg = $this->Html->image('logo.png');
			echo $this->Html->link($logoImg, '/', array('escape'=>false));
			?>
			</div>
            <div class="top-sub-title"><?php echo Configure::read('Site.title'); ?></div>
            <?php echo $this->element('user_login_head'); ?>
            <div class="clr"></div>        
        </div>
    </div><!-- end of header -->
    
    <div class="container">
    	<div id="home-middle">
    	   <?php echo $this->Layout->sessionFlash(); ?>
	   	   <?php echo $this->Regions->blocks('region_1'); ?> 
           <?php echo $this->fetch('featured'); ?>
            
            <div class="home-btm-div">
                <div class="home-left">
                	<?php echo $this->fetch('body_content'); ?>
			   		<?php echo $this->Regions->blocks('region_2'); ?>
					<?php
						// echo $this->Layout->sessionFlash();
						echo $content_for_layout;
					?>
                </div><!-- end of home left -->
                
                
                <div class="home-right">      
                	<?php echo $this->element('login_form'); ?>
					<?php echo $this->Regions->blocks('right'); ?>        
                </div><!-- end of home right -->
                
                <div class="clr"></div>
            </div><!-- end of home btm div -->
         
         	<div class="clr"></div>  
        </div><!-- end of home middle --> 
    </div>

	<div id="footer">
    	<div class="container">
		<?php echo $this->Regions->blocks('footer'); ?> 
        	<p>© 2012-2013 All rights reserved.</p>
        </div>    
    </div><!--end of footer -->
</div><!-- end of wrapper -->

<?php
	echo $this->Blocks->get('scriptBottom');
	echo $this->Js->writeBuffer();
?>

</body>
</html>
