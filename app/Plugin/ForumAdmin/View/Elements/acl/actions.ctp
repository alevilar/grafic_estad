<div class="action-buttons">
	<?php
	echo $this->Html->link('<span class="icon-pencil icon-white"></span> ' . __d('admin', 'Add Requester'),
		array('controller' => 'crud', 'action' => 'create', 'model' => 'ForumAdmin.request_object'),
		array('class' => 'btn btn-primary btn-large', 'escape' => false));

	echo $this->Html->link('<span class="icon-pencil icon-white"></span> ' . __d('admin', 'Add Controller'),
		array('controller' => 'crud', 'action' => 'create', 'model' => 'ForumAdmin.control_object'),
		array('class' => 'btn btn-primary btn-large', 'escape' => false)); ?>
</div>