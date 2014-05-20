<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Sky Kpis');
$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Sky Kpis'), array('action' => 'index'));

if ($this->action == 'admin_edit') {
	$this->Html->addCrumb($this->data['Kpi']['name'], '/' . $this->request->url);
	$this->viewVars['title_for_layout'] = 'Sky Kpis: ' . $this->data['Kpi']['name'];
} else {
	$this->Html->addCrumb(__d('croogo', 'Add'), '/' . $this->request->url);
}

echo $this->Form->create('Kpi');

?>
<div class="skyKpis row-fluid">
	<div class="span8">
		<ul class="nav nav-tabs">
		<?php
			echo $this->Croogo->adminTab(__d('croogo', 'Sky Kpi'), '#sky-kpi');
			echo $this->Croogo->adminTabs();
		?>
		</ul>

		<div class="tab-content">
			<div id='sky-kpi' class="tab-pane">
			<?php
				echo $this->Form->input('id');
				$this->Form->inputDefaults(array('label' => false, 'class' => 'span10'));
				echo $this->Form->input('col_name', array(
					'label' => 'Nombre del Campo o Columna en la base de datos',
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
				echo $this->Form->input('sql_formula', array(
					'label' => 'Fórmula',
                                        'after' => '<br><span class="text-info">Código SQL que irá como FIELDS de la consulta SQL. Si no se escribe nada se calcula el promedio y se usa este nombre de columna para buscar entre los contadores</span>',                                        
				));
				echo $this->Form->input('sql_threshold_warning', array(
					'label' => 'Sql Threshold Warning',
                                        'placeholder' => 'Ej: "? > 10 && ? < 20" (OJO: no colocar las comillas)',
                                        'after' => '<br><span class="text-info">Niveles en los que el Threshold da warning. Se utiliza el símbolo de interrogacion como comodín del valor. Usa la funcion eval() de php para eso.</span>',
				));
				echo $this->Form->input('sql_threshold_danger', array(
					'label' => 'Sql Threshold Danger',
                                        'placeholder' => 'Ej: "? < 45" (OJO: no colocar las comillas)',
                                        'after' => '<br><span class="text-info">Niveles en los que el Threshold da: need-improve. Se utiliza el símbolo de interrogacion como comodín del valor. Usa la funcion eval() de php para eso.</span>',
				));

				echo $this->Form->input('Counter', array(
					'label' => 'Contadores que usa este Kpi',
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
