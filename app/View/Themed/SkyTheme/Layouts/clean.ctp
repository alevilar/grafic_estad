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
                //	'/croogo/css/croogo-bootstrap',
                //	'/croogo/css/croogo-bootstrap-responsive',
                '/croogo/css/thickbox',
            ));


            echo $this->Html->css(array(
                '/bootstrap/css/bootstrap.min',
                '/bootstrap/css/bootstrap-responsive.min',
                "bootstrap-combined.no-icons.min.css",
                "font-awesome.css",
                'style',
            ));

            



            
            echo $this->Html->script(array(
                '/croogo/js/html5',
                'jquery-1.10.1.min',
                //'/croogo/js/jquery/jquery.min',
                '/croogo/js/jquery/jquery-ui.min',
                '/croogo/js/jquery/jquery.slug',
                '/croogo/js/jquery/jquery.cookie',
                '/croogo/js/jquery/jquery.hoverIntent.minified',
                '/croogo/js/jquery/superfish',
                '/croogo/js/jquery/supersubs',
                '/croogo/js/jquery/jquery.tipsy',
                '/croogo/js/jquery/jquery.elastic-1.6.1.js',
                '/croogo/js/jquery/thickbox-compressed',
                '/croogo/js/underscore-min',
                    //		'/croogo/js/admin',
                    //		'/croogo/js/choose',
                    //	'/croogo/js/croogo-bootstrap.js',
            ));

            echo $this->Layout->js();
            ?>

            
            <?php echo $this->fetch('head'); ?>

            


        <!--[if IE 7]><?php echo $this->Html->css('ie7'); ?><![endif]-->
        <!--[if IE]><?php echo $this->Html->css('iefix'); ?><![endif]-->

            <link rel="shortcut icon" href="images/favicon.ico"  />

            <?php
            echo $this->Html->script(array(
                //	'jquery-1.10.1.min',
                '/bootstrap/js/bootstrap.min',
            ));

            echo $this->Blocks->get('css');
            echo $this->Blocks->get('script');
            echo $this->fetch('css');
            echo $this->fetch('script');
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
                        echo $this->Html->link($logoImg, '/', array('escape' => false, 'class' => 'brand', 'alt' => Configure::read('Site.title')));
                        ?>
                        </div>
                        <div class="span4">
                            <h1><?php echo $title_for_layout; ?></h1>
                        </div>

                        <div class="span5">
                            <?php if ($this->fetch('search')): ?>
                                <div class="search">
                                    <?php echo $this->fetch('search'); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
            
        </div>

        <div id="main-container">            
            
            <div class="container-fluid content-wrapper">
                <div class="row-fluid">

                    <?php
                    $blockRight = $this->Regions->blocks('right');
                    if (!empty($blockRight)) {                        
                    ?>
                        <div id="content-body" class="span8">
                            <?php echo $this->fetch('content'); ?>
                            <?php echo $this->fetch('body_content'); ?>
                        </div>

                        <div id="sidebar" class="span4">
                            <?php echo $this->Regions->blocks('right'); ?>
                        </div>
                    <?php
                    } else {
                        echo $this->fetch('content');
                        echo $this->fetch('body_content');
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
    

        </div><!-- end of wrapper -->

<?php
echo $this->Blocks->get('scriptBottom');
echo $this->Js->writeBuffer();
?>

    </body>
</html>
