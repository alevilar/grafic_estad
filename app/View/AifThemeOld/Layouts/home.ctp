<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script>
    var URL_LOGINFORM = "<?php echo $this->Html->url(array('admin'=>false, 'plugin'=>'kms_user_extras', 'controller'=>'kms_user_extras', 'action'=>'login_form'))?>";
    </script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to KMTF</title>
<meta name="author" content="KMTF">
<meta name="keywords" content="">
<meta name="description" content="">
<!--icons-->
<link rel="icon" href="<?php echo $this->Html->url('/login/img/icons/favicon.png')?>">
<meta name="application-name" content="KMTF">
<?php
    echo $this->Html->css(array(
        '/login/css/style',
        '/login/css/extra_style',
        '/login/css/camera',
        ));
    
    echo $this->Html->script(array(
            '/login/js/jquery.min',
            '/login/js/jquery.easing.1.3',
            '/login/js/camera',
            '/login/js/script',
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
                        <?php if ( !$this->Session->check('Auth.User.id') ) { ?>
			<a href="#user-login-box" id="link-login" role="button" class="btn" data-toggle="modal">
		                User Login
    	                </a>
                        <?php } else {                        
                        echo $this->Session->read('Auth.User.username')." - ".$this->Html->link('Go to My Dashboard','/dashboard');
                            
                        }?>
		</div>
                <div class="clear"></div>
            </div><!-- end of top links -->
    		<div class="top-section">
            	<div class="logodiv">
 	 	    <h1 class="logo">
                            <?php 
                            $logoImgs = $this->Html->image('/login/img/logo.png');
                            echo $this->Html->link($logoImgs, '/', array('escape'=>false));
                            ?>
                    </h1>
		</div>
                <div class="navdiv">
                	<ul class="navul">
                    	<li><a href="#">Home</a></li>
                        <li><a href="#">About Us</a>
                        	<ul>
                            	<li><a href="#">Background</a></li>
                                <li><a href="#">Objectives</a></li>
                                <li><a href="#">Roadmap</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Collaborations</a>
                        	<ul>
                            	<li><a href="#">AIF</a></li>
                                <li><a href="#">MII</a></li>
                                <li><a href="#">IBBM</a></li>
                                <li><a href="#">IBFIM</a></li>
                                <li><a href="#">INCEIF</a></li>
                                <li><a href="#">SIDC</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Knowledage Bank</a>
                        	<ul>
                            	<li><a href="#">Printed</a></li>
                                <li><a href="#">Multimedia</a></li>
                                <li><a href="#">Expert Database</a></li>
                                <li><a href="#">OPAC</a></li>
                            </ul>
                        </li>
                        <li><a href="#">KMC</a>
                        	<ul>
                            	<li><a href="#">AIF</a></li>
                                <li><a href="#">MII</a></li>
                                <li><a href="#">IBBM</a></li>
                                <li><a href="#">IBFIM</a></li>
                                <li><a href="#">INCEIF</a></li>
                                <li><a href="#">SIDC</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
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
                
                <div class="col1 columns">
                	<div class="boxes">                    
                    	
                        <div class="camera_wrap" id="camera_wrap_1">
                            <div data-thumb="<?php echo $this->Html->url('/login/img/slides/banner1.jpg')?>" data-src="<?php echo $this->Html->url('/login/img/slides/banner1.jpg')?>">
                                <div class="camera_caption fadeFromBottom">
                                    <p class="tite">Curabitur eget nunc tortor</p>
                                    <p class="subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed a nisl non sem lobortis vulputate at eget turpis. Sed ut nisl tempor, posuere velit a, consequat sem.</p>
                                </div>
                            </div>
                             <div data-thumb="i<?php echo $this->Html->url('/login/img/slides/banner2.jpg')?>" data-src="<?php echo $this->Html->url('/login/img/slides/banner2.jpg')?>">
                                <div class="camera_caption fadeFromBottom">
                                   <p class="tite">Curabitur eget nunc tortor</p>
                                    <p class="subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed a nisl non sem lobortis vulputate at eget turpis. Sed ut nisl tempor, posuere velit a, consequat sem.</p>
                                </div>
                            </div>
                            <div data-thumb="<?php echo $this->Html->url('/login/img/slides/banner3.jpg')?>" data-src="<?php echo $this->Html->url('/login/img/slides/banner3.jpg')?>">
                                <div class="camera_caption fadeFromBottom">
                                    <p class="tite">Curabitur eget nunc tortor</p>
                                    <p class="subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed a nisl non sem lobortis vulputate at eget turpis. Sed ut nisl tempor, posuere velit a, consequat sem.</p>
                                </div>
                            </div>
                             <div data-thumb="<?php echo $this->Html->url('/login/img/slides/banner4.jpg')?>" data-src="<?php echo $this->Html->url('/login/img/slides/banner4.jpg')?>">
                                <div class="camera_caption fadeFromBottom">
                                    <p class="tite">Curabitur eget nunc tortor</p>
                                    <p class="subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed a nisl non sem lobortis vulputate at eget turpis. Sed ut nisl tempor, posuere velit a, consequat sem.</p>
                                </div>
                            </div>
                            <div data-thumb="<?php echo $this->Html->url('/login/img/slides/banner5.jpg')?>" data-src="<?php echo $this->Html->url('/login/img/slides/banner5.jpg')?>">
                                <div class="camera_caption fadeFromBottom">
                                    <p class="tite">Curabitur eget nunc tortor</p>
                                    <p class="subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed a nisl non sem lobortis vulputate at eget turpis. Sed ut nisl tempor, posuere velit a, consequat sem.</p>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        
                        
                    </div>
                </div>   <!-- end of col1 columns -->             
                <div class="col2 columns">
                    <div class="boxes">                    
                    	<div class="home-quote-div">
                        	<p>“The only source of knowledge is experience". <br /><span>Albert Einstein</span></p>
                        </div>
                    </div>
                </div><!-- end of col2 columns -->
                <div class="col3 columns">
                    <div class="boxes">                   
                       	<?php echo $this->element('Kms.events'); ?>
                    </div>
                </div><!-- end of col3 columns -->
                <div class="col3 columns last">
                    <div class="boxes">                    
                        <?php echo $this->element('Kms.public_blogs');?>
                    </div>
                </div><!-- end of col3 columns -->
                <div class="col2 columns">
                	<div class="boxes">                    
                    	<div class="home-publication-container">
                        	<h2 class="blue">Publication and Newsletter</h2>
                            
                            <div class="publication-link">
                            	<ul>
                                	<li><a href="#" class="ex-large">Asian Link</a></li>
                                    <li><a href="#" class="large">Ethics</a></li>
                                    <li><a href="#" class="med">Financial Inclusion</a></li>
                                    <li><a href="#" class="ex-large">Research & Publications</a></li>
                                    <li><a href="#" class="small">Risk Management</a></li>
                                    <li><a href="#" class="med">Standards Development & Assurance</a></li>
                                    <li><a href="#" class="ex-large">Strategic Human Resources</a></li>
                                    <li><a href="#" class="small">Strategy & Policy Development</a></li>
                                </ul>
                                <div class="clear"></div>
                            </div>
                            
                        </div>
                    </div>
                </div><!-- end of col2 columns -->
                <div class="clear"></div>
                
            </div>
        </div><!-- end of home conteiner -->
    	
    </div><!-- end of middle-container -->
    
    <div id="footer">    
    	<div class="container">
        	
            <div class="btm-social">
                <a href="#" class="linkdin">Linkdin</a>
                <a href="#" class="facebook">Facebook</a>
                <a href="#" class="mail">Email</a>
            </div>
            <div class="footerlink"><p><a href="#">Home</a>&nbsp;|&nbsp;<a href="#">About Us</a>&nbsp;|&nbsp;<a href="#">Collaborations</a>&nbsp;|&nbsp;<a href="#">Knowledge Bank</a>&nbsp;|&nbsp;<a href="#">KMC</a>&nbsp;|&nbsp;<a href="#">Contact Us</a></p></div>
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