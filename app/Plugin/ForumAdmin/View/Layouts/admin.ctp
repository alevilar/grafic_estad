<?php
echo $this->Html->docType(); ?>
<html lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php echo $this->Breadcrumb->pageTitle($config['Admin']['appName'], array('reverse' => true)); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
	echo $this->Html->css('ForumAdmin.bootstrap.min');
	echo $this->Html->css('ForumAdmin.bootstrap-responsive.min');
	echo $this->Html->css('ForumAdmin.font-awesome.min');
	echo $this->Html->css('ForumAdmin.style');
	echo $this->Html->script('//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js');
	echo $this->Html->script('ForumAdmin.bootstrap.min');
	echo $this->Html->script('ForumAdmin.jquery.gridalicious.min');
	echo $this->Html->script('ForumAdmin.admin');
	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script'); ?>
</head>
<body class="controller-<?php echo $this->request->controller; ?>">
	<?php echo $this->element('ForumAdmin.navbar'); ?>

	<div class="body container-fluid action-<?php echo $this->action; ?>">
		<div class="row-fluid">
			<?php
			$this->Breadcrumb->prepend(__d('admin', 'Dashboard'), array('controller' => 'admin', 'action' => 'index'));

			if ($crumbs = $this->Breadcrumb->get()) { ?>
				<div class="well well-small breadcrumbs">
					<ul class="breadcrumb">
						<?php foreach ($crumbs as $crumb) { ?>
							<li>
								<?php echo $this->Html->link($crumb['title'], $crumb['url']); ?>
								<span class="divider icon-chevron-right"></span>
							</li>
						<?php } ?>
					</ul>
				</div>
			<?php }

			echo $this->Session->flash();
			echo $this->fetch('content'); ?>
		</div>
	</div>

	<footer class="foot">
		
		<?php if (!CakePlugin::loaded('DebugKit')) {
			echo $this->element('sql_dump');
		} ?>
	</footer>
</body>
</html>