<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Sky Counter');
$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Sky Kpis'), array('action' => 'index'));

if ($this->action == 'admin_edit') {
	$this->Html->addCrumb($this->data['Counter']['name'], '/' . $this->request->url);
	$this->viewVars['title_for_layout'] = 'Sky Counter: ' . $this->data['Counter']['name'];
} else {
	$this->Html->addCrumb(__d('croogo', 'Add'), '/' . $this->request->url);
}

echo $this->Form->create('Counter');

?>
<div class="skyKpis row-fluid">
	<div class="span8">
		<ul class="nav nav-tabs">
		<?php
			echo $this->Croogo->adminTab(__d('croogo', 'Sky Counter'), '#sky-kpi');
			echo $this->Croogo->adminTabs();
		?>
		</ul>

		<div class="tab-content">
			<div id='sky-kpi' class="tab-pane">
			<?php
				echo $this->Form->input('id');
				$this->Form->inputDefaults(array('label' => false, 'class' => 'span10'));
				echo $this->Form->input('col_name', array(
					'label' => 'Field Name',
                                        'after' => '<br><span class="text-info">El nombre exacto del nombre del campo en la base de datos a migrar</span>'
				));
				echo $this->Form->input('name', array(
					'label' => 'Name',
				));
                
                echo $this->Form->input('string_format', array(
					'label' => 'Formato',
                                        'after' => '<br><span class="text-info">Formato de la función sprintf()</span>',
                                        'placeholder' => 'Ej: "%s\%" para introducir un símbolo de porcentaje % al final del valor del KPI'
				));
				echo $this->Form->input('graph', array(
					'legend' => 'Mostrar en Gráfico',
                                        'type' => 'radio',
                                        'options' => array(
                                               0 => 'No',
                                               1 => 'Si'
                                        )
				));

				echo $this->Form->input('Kpi', array(
					'label' => 'Kpi´s que usan este contador',
				));
				
				echo $this->Croogo->adminTabs();
			?>
			</div>
		</div>

	</div>

	<div class="span4">
	<?php
		echo $this->Html->beginBox(__d('croogo', 'Publishing')) .
			$this->Form->button(__d('croogo', 'Apply'), array('name' => 'apply')) .
			$this->Form->button(__d('croogo', 'Save'), array('class' => 'btn btn-primary')) .
			$this->Html->link(__d('croogo', 'Cancel'), array('action' => 'index'), array('class' => 'btn btn-danger')) .
			$this->Html->endBox();
		?>
	</div>

</div>
<?php echo $this->Form->end(); ?>
