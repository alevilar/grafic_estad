<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--[if lte IE 7 ]><html id="ie7" lang="en"> <![endif]-->
	<title><?php echo strip_tags($title_for_layout); ?> &raquo; <?php echo strip_tags(Configure::read('Site.title')); ?></title>

	<?php
	echo $this->Meta->meta();
	echo $this->Layout->feed();
	echo $this->Layout->js();
	echo $this->Html->css(array(
	'/bootstrap/css/bootstrap.min',
	'/bootstrap/css/bootstrap-responsive.min',
	'style',
	
	));
	?>

	<!--[if IE 7]><?php echo $this->Html->css('ie7'); ?><![endif]-->
	<!--[if IE]><?php echo $this->Html->css('iefix'); ?><![endif]-->

	<link rel="shortcut icon" href="images/favicon.ico"  />

	<?php
	 echo $this->Html->script(array(
		'jquery-1.10.1.min',
		'/bootstrap/js/bootstrap.min',
	));

	echo $this->Blocks->get('css');
	echo $this->Blocks->get('script');
	?>

</head>

<body>


<!-- Navbar
    ================================================== -->
    <div class="navbar">
      
      <div class="header">
	      <div class="container-fluid">
			      	<div class="row-fluid">
			      		<div class="span3" class="img-logo">
			      			<?php 
							$logoImg = $this->Html->image('logo.png');
							echo $this->Html->link($logoImg, '/', array('escape'=>false, 'class' => 'brand'));
							?>
						</div>
			    		<div class="span6">
			    			<h1><?php echo Configure::read('Site.title'); ?></h1>
						</div>
				            
			            <div class="span3">
				           		<?php echo $this->element('user_login_head'); ?>
			           	</div>
			        </div>
		    </div>
	  </div>
	    
      <?php echo $this->element('navbar'); ?>
    </div>

    
    <div class="content-body">
    	<div class="container">
    		<?php echo $this->fetch('featured'); ?>
    		<style>
    			div.alert:empty{display: none}
    		</style>
			<div class="alert"><?php echo $this->Layout->sessionFlash(); ?></div>
			
            <?php echo $this->fetch('content'); ?>
            <?php echo $this->fetch('body_content'); ?>
        </div>
    </div>

	<div class="clearfix"></div>
	
	<div id="footer">
    	<div class="row_fluid">
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
