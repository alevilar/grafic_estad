<?php
$foreignModel = $this->Admin->introspect($assoc['className']);
$withModel = $this->Admin->introspect($assoc['with']);
$fields = $this->Admin->filterFields($withModel); ?>

<section class="has-and-belongs-to-many">
	<h5>
		<?php if (isset($counts[$alias])) {
			$total = $counts[$alias];
			$count = $assoc['limit'] ?: count($results);

			if ($count > $total) {
				$count = $total;
			} ?>

			<span class="muted pull-right"><?php echo __d('admin', '%s of %s', array($count, $total)); ?></span>
		<?php } ?>

		<?php echo $this->Admin->outputAssocName($foreignModel, $alias, $assoc['className']); ?> &rarr;
		<?php echo $this->Admin->outputAssocName($withModel, $withModel->alias, $assoc['with']); ?>
	</h5>

	<table class="table table-striped table-bordered table-hover clickable">
		<thead>
			<tr>
				<th>
					<span><?php echo $alias; ?></span>
				</th>

				<?php foreach ($fields as $field => $data) {
					if (mb_strpos($field, '_id') !== false) {
						continue;
					} ?>

					<th class="col-<?php echo $field; ?> type-<?php echo $data['type']; ?>">
						<span><?php echo $data['title']; ?></span>
					</th>
				<?php } ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($results as $result) { ?>

				<tr>
					<td>
						<?php echo $this->Html->link($result[$foreignModel->displayField], array(
							'action' => 'read',
							'model' => $foreignModel->urlSlug,
							$result[$foreignModel->primaryKey]
						)); ?>
					</td>

					<?php foreach ($fields as $field => $data) {
						if (mb_strpos($field, '_id') !== false) {
							continue;
						} ?>

						<td class="col-<?php echo $field; ?> type-<?php echo $data['type']; ?>">
							<?php echo $this->element('ForumAdmin.field', array(
								'result' => $result,
								'field' => $field,
								'data' => $data,
								'value' => $result[$withModel->alias][$field],
								'model' => $withModel
							)); ?>
						</td>

					<?php } ?>
				</tr>

			<?php } ?>
		</tbody>
	</table>
</section>