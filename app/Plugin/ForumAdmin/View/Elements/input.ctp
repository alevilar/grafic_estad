<?php
$classes = array($data['type']);
$hasError = isset($model->validationErrors[$field]);
$isRequired = false;
$isEditor = in_array($field, $model->admin['editorFields']);
$validate = false;

if ($hasError) {
	$classes[] = 'error';
}

if ($isEditor) {
	$classes[] = 'is-editor';
}

if (isset($model->validate[$field])) {
	$validate = $model->validate[$field];
} else if (isset($model->validations['default'][$field])) {
	$validate = $model->validations['default'][$field];
}

if ($validate) {
	$isRequired = true;

	if (isset($validate['allowEmpty']) && $validate['allowEmpty']) {
		$isRequired = false;
	} else if (isset($validate['required'])) {
		$isRequired = $validate['required'];
	}

	if ($isRequired) {
		$classes[] = 'required';
	}
}

if ($hasError) {
	$classes[] = 'text-error';
} else if ($isRequired) {
	$classes[] = 'text-info';
} ?>

<div class="control-group <?php echo implode(' ', $classes); ?>">
	<?php echo $this->Form->label($field, $data['title'], array('class' => 'control-label')); ?>

	<div class="controls">
		<?php
		$element = 'default';

		if (!empty($data['belongsTo'])) {
			$element = 'belongs_to';

		} else if (!empty($data['habtm'])) {
			$element = 'has_and_belongs_to_many';

		} else if ($field === 'id') {
			$element = 'id';

		} else if (in_array($field, $model->admin['fileFields'])) {
			$element = 'file';

		} else if (in_array($data['type'], array('datetime', 'date', 'time'))) {
			$element = 'datetime';
		}

		echo $this->element('ForumAdmin.input/' . $element, array(
			'field' => $field,
			'data' => $data
		));

		// Show a null checkbox for fields that support it
		if (isset($data['null']) && $data['null'] && !$isRequired) {
			if (isset($this->data[$model->alias][$field])) {
				$null = $this->data[$model->alias][$field];
				$checked = ($null === null || $null === '');
			} else {
				$checked = ($data['default'] === null);
			} ?>

			<div class="controls-null">
				<?php echo $this->Form->input($field . '_null', array(
					'type' => 'checkbox',
					'checked' => $checked,
					'div' => false,
					'error' => false,
					'label' => __d('admin', 'Empty?')
				)); ?>
			</div>

		<?php } ?>
	</div>

	<?php // Include an element that may wrap the input with a wysiwyg
	if ($isEditor && $model->admin['editorElement']) {
		echo $this->element($model->admin['editorElement'], array(
			'inputId' => $this->Form->domId()
		));
	} ?>
</div>
