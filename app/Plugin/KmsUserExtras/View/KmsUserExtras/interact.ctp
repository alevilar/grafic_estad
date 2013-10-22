<style>
	.tab-content{
		background: white;
		min-heigth: 400px;
		border: 1px solid #ddd;
		padding: 30px;
	}
	
	.tabs-right>.nav-tabs{
		margin-left: -1px;
	}
</style>

<div class="users form well">
	<h3>Interaction Zone</h3>
	
	
	<div class="tabbable tabs-right">
		  <ul class="nav nav-tabs">
		    <li class="active"><a href="#profile" data-toggle="tab">My Profile</a></li>
		    <li><a href="#connections" data-toggle="tab">My Connections</a></li>
		    <li><a href="#forum" data-toggle="tab">Forum & Polls</a></li>
		    <li><a href="#calendar" data-toggle="tab">Calendar</a></li>
		    
		  </ul>
		  
		  <div class="tab-content">
				<div id="profile" class="tab-pane active" >
					
					<?php  echo $this->Form->create('User'); ?>
					<div class="span3">
			  			<?php
						if ( !empty($this->data['User']['image']) ) {
								echo $this->Html->image("../profiles/".$this->data['User']['image']);			
						}
						 ?>
						 <h5>My Interests</h5>
						 <fieldset>
						<?php
							echo $this->Form->input('kms_writing', array('label' => 'Writing', 'type' => 'checkbox'));
							echo $this->Form->input('kms_reading', array('label' => 'Reading', 'type' => 'checkbox'));
							echo $this->Form->input('kms_editing', array('label' => 'Editing', 'type' => 'checkbox'));
							echo $this->Form->input('kms_traveling', array('label' => 'Traveling', 'type' => 'checkbox'));
							echo $this->Form->input('kms_others', array('label' => 'Others', 'type' => 'checkbox'));
							?>
						</fieldset>
			  		</div>
			  		<div class="span8">
			  			<fieldset>
						<?php
                                                        echo "<h5>About Me</h5>";
							echo $this->Form->input('id');
                                                        echo $this->Form->hidden('username');
							echo $this->Form->input('name', array('placeholder'=>'Name... as seen by others', 'label' => false, 'class' => 'input-block-level'));
							echo $this->Form->input('skills', array('placeholder'=>'Skills, separated by commas', 'label' => false, 'class' => 'input-block-level'));
							echo $this->Form->input('generally_about', array('label' => 'Areas of Expertize', 'class' => 'input-block-level'));
							echo $this->Form->input('my_favourite_tags', array('label'=>'Keywords', 'placeholder' => 'your interest tags, separated by commas', 'class' => 'input-block-level'));
                                                        echo $this->Form->input('email', array( ));
                                                        echo $this->Form->input('allow_contact', array('label'=>'Receive messages from other users'));
                                                        
                                                        
                                                        echo "<h5>My Social Settings</h5>";
                                                        echo "<div class='row-fluid'>";
                                                        echo $this->Form->input('facebook', array('label'=> 'My Facebook webpage', 'type' => 'url', 'div'=>array('class'=> 'span6')));
                                                        echo $this->Form->input('twitter', array('label'=> 'My Twitter webpage', 'type' => 'url', 'div'=>array('class'=> 'span6')));
                                                        echo "</div>";
                                                        echo "<div class='row-fluid'>";
                                                        echo $this->Form->input('google_plus', array('label'=> 'My Google Plus webpage', 'type' => 'url', 'div'=>array('class'=> 'span6')));
                                                        echo $this->Form->input('linkedin', array('label'=> 'My Linkeidn webpage', 'type' => 'url', 'div'=>array('class'=> 'span6')));
                                                        echo "</div>";
							?>
						</fieldset>
						<br><br>
						<?php echo $this->Form->submit('Save', array('class'=> 'btn btn-primary pull-right btn-large'));?>
				
			  		</div>
			  		<div class="clearfix"></div>
				<?php echo $this->Form->end();?>
				</div>
				
				<div id="connections" class="tab-pane">
					<h3>My Connections</h3>
					<div class="here"></div>	
					<br><br><br><br><br><br>	
				</div>
				
				<div id="forum" class="tab-pane">
					<h3>Forum</h3>
					<div class="row-fluid">
						   <iframe 
					   			src="<?php echo $this->Html->url('/forum/stations/view/general-discussion'); ?>"
					   			class="container well well-small span12"
					           style="height: 900px;"></iframe>
			        </div>
				</div>
				
				<div id="calendar" class="tab-pane">
					<h3>Calendar >> Next Activities</h3>
                                        <div class="here"></div>
				</div>
				
		  </div>
	</div>
	<script>
		(function(){
			$('.here','#connections').load('<?php echo $this->Html->url('/connect')?>');
                        
                        $('.here','#connections').on('submit','.formUserSearch', function(e){
                            e.preventDefault();
                            $('.here','#connections').load(this.action+"?"+$(this).serialize());
                            
                            return false;
                        });
                                                                

                        
                        $('.here','#calendar').load('<?php echo $this->Html->url('/activities')?>');

		})();
                
                
	</script>
	
	
	
</div>