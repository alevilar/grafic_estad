<?php if ( !$this->Session->read('Auth.User.id') ) return ""; ?>
<div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <?php
          
         // debug($this);
          ?>
          <div class="nav-collapse collapse">
            <ul class="nav">
            	
            		<?php 
                		$url = $this->Html->url('/') ;
		  				$activeClass = $this->request->here == $url? 'active': '';
					?>
                	<li class="<?php echo $activeClass?>">
                		<?php
                		echo $this->Html->link('Dashboard', '/dashboard')
                		?>
            		</li>
            		
                    <?php 
                		$url = $this->Html->url('/create') ;
		  				$activeClass = $this->request->here == $url? 'active': '';
					?>
                	<li class="<?php echo $activeClass?>">
                		<?php
                		echo $this->Html->link('Create', '/create')
                		?>
                	</li>
                	
                	 <?php 
                		$url = $this->Html->url('/share') ;
		  				$activeClass = $this->request->here == $url? 'active': '';
					?>
                	<li class="<?php echo $activeClass?>">
                		<?php
                		echo $this->Html->link('Share', '/share')
                		?>
					</li>
					
					 <?php 
                		$url = $this->Html->url('/search') ;
		  				$activeClass = $this->request->here == $url? 'active': '';
					?>
                	<li class="<?php echo $activeClass?>">
                		<?php
                		echo $this->Html->link('Search', '/search')
                		?>
                    </li>
                    

 					<?php 
                		$url = $this->Html->url('/interact') ;
		  				$activeClass = $this->request->here == $url? 'active': '';
					?>
                	<li class="<?php echo $activeClass?>">
                		<?php
                		echo $this->Html->link('Interact', '/interact')
                		?>
					</li>
            </ul>
          </div>
          
                <form class="navbar-search pull-right">
				  <input type="text" class="search-query" placeholder="Search">
				</form>
            
        </div>
      </div>