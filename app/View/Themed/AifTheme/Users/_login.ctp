<?php

// $this->layout = 'login';
 echo $this->Html->css(array(
		'style_login',
		));
?>

	<div class="row">
	            
	   	<div class="span8">
		             <div class="home-txt-row">
	                        	<?php echo $this->Html->image('share-icon.png', array('style'=>'float:left'))?>
	                            <h3>Create</h3>
	                            <p>Create, Clasify, Categorize & Tag any information. </p>
	                    </div>
	                    <div class="clearfix"></div>
	                    
	                    <div class="home-txt-row">
	                    	<?php echo $this->Html->image('distribute-icon.png', array('style'=>'float:left'))?>
	                        <h3>Share</h3>
	                        <p>Select, Share, Co-Author, Contribute to organization growth.</p>
	                    </div>
	                    <div class="clearfix"></div>
	                    
	                    <div class="home-txt-row">
	                    	<?php echo $this->Html->image('spread-icon.png', array('style'=>'float:left'))?>
	                            <h3>Interact</h3>
	                            <p>Socialize, Energize, bringh forth Social Platforms and Participation.</p>
	                    </div>
	                    
	                    
	                    
	      </div>
	      
	    <div class="span3 offset1">
	    	<br><br>
	    	<?php echo $this->element('login_form'); ?>
	    	
			<?php echo $this->Regions->blocks('right'); ?>        
	    </div><!-- end of home right -->
	</div><!-- end of home middle --> 
