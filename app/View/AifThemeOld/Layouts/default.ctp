<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <script>
            var URL_LOGINFORM = "<?php echo $this->Html->url(array('admin' => false, 'plugin' => 'kms_user_extras', 'controller' => 'kms_user_extras', 'action' => 'login_form')) ?>";
        </script>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Welcome to KMTF</title>
        <meta name="author" content="KMTF" />
        <meta name="keywords" content=""/>
        <meta name="description" content=""/>
        <!--icons-->
        <link rel="icon" href="<?php echo $this->Html->url('/login/img/icons/favicon.png') ?>" />
        <meta name="application-name" content="KMTF" />
        <?php
        echo $this->Html->css(array(
            'style',
            'extra_style',
            'camera',
        ));

        echo $this->Html->script(array(
            'jquery.min',
            'jquery.easing.1.3',
            'camera',
            'script',
        ));
        ?>
    </head>

    <body>
        <div id="wrapper">

            <div id="header">
                <div class="container">
                    <div class="top-links">
                        <div class="top-social">
                            <span>Follow Us:</span>
                            <a href="#" class="linkdin">Linkdin</a>
                            <a href="#" class="facebook">Facebook</a>
                            <a href="#" class="mail">Email</a>
                        </div>
                        <div class="top-right-link">                    
                            <?php echo $this->element('public_top_links'); ?>
                        </div>
                        <div class="clear"></div>
                    </div><!-- end of top links -->
                    <div class="top-section">

                        <div class="logodiv">
                            <h1 class="logo">
                                <?php
                                $logoImgs = "";
                                $logoImgs = $this->Html->image('logo.png', array('width' => '200', 'height' => '80'));
                                echo $this->Html->link($logoImgs, '/', array('escape' => false));
                                ?>
                            </h1>
                        </div>
                        <div class="navdiv">
                            <?php echo $this->Regions->blocks('header'); ?>
                            
                            <?php echo $this->Menus->menu('main', array('dropdown' => true)); ?>

                        </div>
                        <div class="clear"></div>
                    </div><!-- end of top section -->
                    <div class="clear"></div>
                </div><!-- end of conteiner -->
            </div><!-- end of header -->

            <div id="middle-container">
                <?php echo $this->Layout->sessionFlash(); ?>
                <div class="container">
                    <div class="home-container">
                        <div class="wide columns ">
                            <div class="boxes">                    
                                <div id="content">
                                    <?php echo $this->Regions->blocks('region1'); ?>
                                    <?php echo $this->fetch('content'); ?>
                                    <?php echo $this->fetch('body_content'); ?>
                                    <?php echo $this->Regions->blocks('region2'); ?>
                                </div>
                            </div>
                        </div><!-- end of wide columns -->           
                        <div class="col3 columns ">
                            <div class="boxes">
                                <div id="content">
                                    <?php echo $this->Regions->blocks('region3'); ?>
                                    <?php echo $this->element('public_blogs'); ?>
                                    <?php echo $this->element('tagcloud'); ?>
                                </div>
                            </div>
                        </div><!-- end of side columns -->
                        <div class="col3 columns ">
                            <div class="boxes">
                                <div id="content">
                                    <?php echo $this->Regions->blocks('region4'); ?>
                                    <?php echo $this->element('events'); ?>
                                </div>
                            </div>
                        </div><!-- end of side columns -->
                        <div class="clear"></div>


                        <div class="bottom-logo">
                            <?php echo $this->Regions->blocks('lowercontainer'); ?>
                        </div> 


                    </div><!-- end of home conteiner -->
                </div><!-- end of container -->
                <!-- end of middle-container -->

                <div id="footer">    
                    <div class="container">
                        <?php echo $this->Regions->blocks('footer'); ?>
                        <div class="btm-social">
                            <a href="#" class="linkdin">Linkdin</a>
                            <a href="#" class="facebook">Facebook</a>
                            <a href="#" class="mail">Email</a>
                        </div>
                        <div class="footerlink">
                            <?php echo $this->Regions->blocks('footer'); ?>
                            <!--
                            <p><a href="#">Home</a>&nbsp;|&nbsp;<a href="#">About Us</a>&nbsp;|&nbsp;<a href="#">Collaborations</a>&nbsp;|&nbsp;<a href="#">Knowledge Bank</a>&nbsp;|&nbsp;<a href="#">KMC</a>&nbsp;|&nbsp;<a href="#">Contact Us</a></p>
                            -->
                        </div>
                        <div class="copyright">2010 - 2013 &copy; Asian Institute of Finance. All rights reserved.</div>
                    </div>
                </div>


            </div><!-- end of wrapper -->



            <!-- Modal -->
            <div id="user-login-box" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">  
                <div style="text-align: right; margin-bottom: -36px;"><button type="button" id="cancel-login" style="padding: 10px;">X</button></div>
                <div id="logincontain" style="width: 256px; height: 350px">
                </div>    
            </div>

    </body>
</html>
