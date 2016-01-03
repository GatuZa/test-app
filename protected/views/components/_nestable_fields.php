<?php
/**
 * @var CActiveForm $form
 * @var CActiveRecord $model
 * @var CActiveRecord $rel
 * @var string $join
 * @var integer $grid_iterator
 */
$related = $model->getRelated($join);

$rel = $model->getActiveRelation($join)->className;
$related[] = new $rel;
$grid_iterator = 0;
?>
<div class="form-group">
	<div class="control-label col-md-2">
		<b><?= $model->getAttributeLabel($join) ?></b>
	</div>
	<div class="nestable-list col-md-10 row">
		<? foreach ($related as $rel): ?>
			<div class="col-md-6">
				<div class="well">
					<?
					foreach ($rel->getIterator() as $field => $value)
					{
						if ($field != $model->tableSchema->primaryKey)
						{
							$this->renderPartial('../layout/_form_iterator', array(
								'columns' => isset($columns) ? $columns : null,
								'field' => $field,
								'form' => $form,
								'model' => $rel,
								'grid_type' => 'nestable',
								'grid_iterator' => $grid_iterator,
							));

						}
					}
					$grid_iterator++;
					?>
				</div>
			</div>
		<?php
		endforeach;
		?>
	</div>
</div>