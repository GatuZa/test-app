<?php
/**
 * @var CActiveForm $form
 * @var CModel $model
 * @var CModel $relations
 * @var array $types
 * @var array $columns
 * @var array $nestable
 * @var bool $readonly
 */
$form = $this->beginWidget('CActiveForm', array(
	'id' => $model->tableSchema->name . '-form',
	'htmlOptions' => array(
		'class' => 'form-horizontal',
		'enctype' => 'multipart/form-data'
	),
	'enableAjaxValidation' => false,
));

if (!empty($columns))
{
	$iterate = array();
	foreach ($columns as $field)
	{
		if (is_array($field))
		{
			$iterate[] = $field;
		}
		else
		{
			$iterate[$field] = $model->$field;
		}
	}
}
else
{
	$iterate = iterator_to_array($model->getIterator());
	ksort($iterate);
}


foreach ($iterate as $field => $value)
{
	if (!empty($value) && is_array($value))
	{
		if (array_key_exists('separator', $value))
		{
			printf('
				<div style="position: relative;">
					<div class="well well-sm row well-no-round">
						<i class="glyphicon glyphicon-th"></i> <b>%s</b>

						<div style="position: absolute;right:0;top:3px;">%s</div>
					</div>
				</div>', $value['separator'], CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array(
				'class' => 'btn btn-primary'
			)));
		}
		elseif (array_key_exists('widget', $value))
		{
			echo '<div class="col-md-offset-3 col-md-9">';
			$this->widget($value['widget']['name'], $value['widget']['options']);
			echo '</div>';
		}
		elseif (array_key_exists($field, $model->relations()))
		{
			$this->renderPartial('_form_iterator', array(
				'columns' => isset($columns) ? $columns : null,
				'field' => $field,
				'types' => isset($types) ? $types : null,
				'form' => $form,
				'model' => $model,
				'readonly' => isset($readonly) ? $readonly : null,
				'relations' => isset($relations) ? $relations : null,
			));
		}
	}
	else
	{
		$this->renderPartial('../components/_form_iterator', array(
			'columns' => isset($columns) ? $columns : null,
			'field' => $field,
			'types' => isset($types) ? $types : null,
			'form' => $form,
			'model' => $model,
			'readonly' => isset($readonly) ? $readonly : null,
			'relations' => isset($relations) ? $relations : null,
		));
	}
}

if (isset($nestable))
{
	foreach ($nestable as $key => $data)
	{
		$input['form'] = $form;
		$input['model'] = $model;
		$input['join'] = $data;

		if (is_array($data))
		{
			$input = array_merge($input, $data);

			$input['join'] = $key;
		}

		$this->renderPartial('../layout/_nestable_fields', $input);
	}
}
?>

	<div class="form-group buttons">
		<div class="col-md-12 text-right">
			<?=
			CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array(
				'class' => 'btn btn-primary'
			)); ?>
		</div>
	</div>

	<script type="text/javascript">
		$(function ()
		{
			$('[data-trigger=openimage]').click(function ()
			{
				$.facebox({ image: $(this).attr('data-src') });

				return false;
			});

			var error_block = $('.error-block:first');
			var error_tab = error_block.parents('[role=custom_tab]');
			$('a[role=custom_tab][href=#' + error_tab.attr('id') + ']').click();
			error_block.goTo();
		});
	</script>

<?php $this->endWidget(); ?>