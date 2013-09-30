
<div class="navigation">
	

	<?php $links = array();

	if ($user) {
		$links[] = $this->Html->link(__d('forum', 'View New Posts'), array('controller' => 'search', 'action' => 'index', 'new_posts', 'admin' => false));
	}

	foreach ($links as $link) { ?>

		<div>
			<?php echo $link; ?>
		</div>

	<?php }

	if ($user) { ?>

		<div>
			<?php // echo sprintf(__d('forum', 'Welcome %s'), $this->Html->link($user[$userFields['username']], $this->Forum->profileUrl($user))); ?>
		</div>

	<?php } ?>

	<span class="clear"></span>
</div>
