<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo strip_tags($title_for_layout); ?> &raquo; <?php echo strip_tags(Configure::read('Site.title')); ?></title>
        <meta name="author" content="KMTF" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="keywords" content=""/>
        <meta name="description" content=""/>

        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="HandheldFriendly" content="True"/>
        <meta name="MobileOptimized" content="320"/>
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <meta name="apple-touch-fullscreen" content="yes"/>

        <!--icons-->
        <link rel="shortcut icon" href="<?php $this->Html->url('/img/favicon.ico'); ?>"/>
        <link rel="apple-touch-icon" href="<?php $this->Html->url('/img/apple-touch-icon.png'); ?>"/>
        <link rel="apple-touch-icon" sizes="72x72" href="<?php $this->Html->url('/img/apple-touch-icon-72x72.png'); ?>"/>
        <link rel="apple-touch-icon" sizes="114x114" href="<?php $this->Html->url('/img/apple-touch-icon-114x114.png'); ?>"/>

        <?php
        echo $this->Meta->meta();
        echo $this->Layout->feed();
        echo $this->Layout->js();

        echo $this->Html->css(array(
            '/bootstrap/css/bootstrap',
            '/bootstrap/css/bootstrap-responsive',
            "http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css",
            'style',
            'camera',
        ));

        echo $this->Html->script(array(
            'jquery.min',
            'jquery.easing.1.3',
            'camera',
            '/bootstrap/js/bootstrap',
            'respond',
        ));
        ?>
        <meta name="application-name" content="KMTF"/>

        <script type="text/javascript">
            jQuery(function() {
                jQuery('#camera_wrap_1').camera({
                    thumbnails: false
                });
            });
        </script>

        <?php
        echo $this->Blocks->get('css');
        echo $this->Blocks->get('script');
        ?>
    </head>

    <body>
        <div id="wrapper">
            <header>
                <div class="top-section">   
                    <div class="container">
                        <?php echo $this->element('public_top_links', array('cache' => false)); ?>
                    </div><!-- .container -->
                </div><!-- end of top section -->

                <div class="top-header">
                    <div class="container-fluid">
                        <div class="logodiv">
                            <h1 class="logo">
                                <?php
                                $logoImg = $this->Html->image('logo.png');
                                echo $this->Html->link($logoImg, '/', array('escape' => false, 'class' => 'brand', 'alt' => Configure::read('Site.title')));
                                ?>                                    
                            </h1>
                        </div>
                        <div class="top-tagline"><h2><?php echo Configure::read('Site.title'); ?></h2></div>

                        <div class="mobile-menu"><a class="home menu" href="#"></a></div>

                        <div class="pull-right">
                        <?php
                        echo $this->Menus->menu('main', array(
                            'selected' => 'active',
                            'dropdownClass' => 'navul',
                            'dropdown' => true,
                            'element' => 'menu'));
                        ?>
                        </div>
                        <div class="clearfix"></div>
                    </div><!-- .container -->
                </div><!-- end of top header -->
            </header> <!-- end of header -->

            <div id="middle-container">
                <div class="container-fluid">                    
                    <?php echo $this->Regions->blocks('region1'); ?>                                        
                    <div class="row-fluid">
                        <?php
                        $blockRight = $this->Regions->blocks('right');
                        if (!empty($blockRight)) {
                            ?>
                            <div class="span8">                                
                                <div class="round-boxes">
                                    <div class="padding">
                                        <?php echo $this->Regions->blocks('region5'); ?>
                                        <?php echo $this->Layout->sessionFlash(); ?>                                        
                                        <?php echo $this->fetch('content'); ?>
                                        <?php echo $this->fetch('body_content'); ?>
                                    </div>
                                </div>
                                   
                                
                                <div class="row-fluid">
                                    <div class="span6">
                                        <?php echo $this->Regions->blocks('region2'); ?>
                                    </div>
                                    <div class="span6">
                                        <?php echo $this->Regions->blocks('region3'); ?>
                                    </div>
                                </div>
                                <?php echo $this->Regions->blocks('region4'); ?>
                            </div>

                            <!-- Right COlumn -->
                            <div class="span4">
                                <?php echo $this->Regions->blocks('right'); ?>
                            </div>

                            <?php
                        } else {
                            ?>
                            <div class="span12">
                                <div class="round-boxes">
                                    <div class="padding">
                                    <?php echo $this->Regions->blocks('region5'); ?>
                                    <?php echo $this->Layout->sessionFlash(); ?>                                        
                                    <?php echo $this->fetch('content'); ?>
                                    <?php echo $this->fetch('body_content'); ?>
                                    </div>
                                </div>
                                

                                <div class="row-fluid">
                                    <div class="span6">
                                        <?php echo $this->Regions->blocks('region2'); ?>
                                    </div>
                                    <div class="span6">
                                        <?php echo $this->Regions->blocks('region3'); ?>
                                    </div>
                                </div>
                                <?php echo $this->Regions->blocks('region4'); ?>
                            </div>
                            <?php
                        }
                        ?>

                    </div><!-- end of row -->
                </div><!-- end of container -->

            </div><!-- end of middle coontainer -->

            <div id="footer">    
                <div class="container">
                    <?php echo $this->Regions->blocks('region4'); ?>
                    <?php echo $this->element('social_links'); ?>
                    <div class="footerlink"><p><a href="index.html">Home</a>&nbsp;|&nbsp;<a href="about.html">About Us</a>&nbsp;|&nbsp;<a href="#">Collaborations</a>&nbsp;|&nbsp;<a href="#">Knowledge Bank</a>&nbsp;|&nbsp;<a href="#">KMC</a>&nbsp;|&nbsp;<a href="#">Upcoming Events / Programmes</a>&nbsp;|&nbsp;<a href="#">Blog</a>&nbsp;|&nbsp;<a href="#">Poll</a>&nbsp;|&nbsp;<a href="#">Announcement</a>&nbsp;|&nbsp;<a href="#">Contact Us</a></p></div>
                    <div class="copyright">2010 - 2013 &copy; Asian Institute of Finance. All rights reserved.</div>
                </div>
            </div>


        </div><!-- end of wrapper -->
        <?php echo $this->Html->script('custom'); ?>

        <?php
        echo $this->Blocks->get('scriptBottom');
        echo $this->Js->writeBuffer();
        ?>
    </body>
</html>