<h2>How does the Worflow Plugin Works?</h2>

<p>It is bassed on redmine´s workflow</p>

<p>
	
	<ol>
		<li>You have a set of states created in <?php echo $this->Html->link('Admin > Workflow > Content States', '/admin/workflow/states');?></li>
		<li>When new content is added, a default initial state is setted. You can change it 
			<?php echo $this->Html->link('Admin > Settings > Workflow', '/admin/settings/settings/prefix/Workflow');?></li>
		<li>When editing a node or content, you will see a tab named "Workflow". From there you can change the node´s state by following the 
			rules setted in its <?php echo $this->Html->link('State Tables', '/admin/workflow/state_tables');?> and
			the options you get depends on the table setted for each Role and Content Type combination.</li>
	</ol>
</p>
