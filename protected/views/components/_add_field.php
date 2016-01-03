<?php
/**
 * @var CController $this
 * @var CActiveDataProvider $dataProvider
 * @var CModel $model
 * @var CActiveForm $form
 * @var array $data
 * @var string $field
 * @var array $style
 * @var string $type
 * @var string $placeholder
 * @var string $join
 * @var bool $isSearch
 */
Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');

$css = array(
	'class' => 'form-control',
	'parent_class' => 'col-md-9',
	'label_class' => 'control-label col-md-3',
	'group_class' => 'form-group'
);

$data = array();

$modelName = get_class($model);
$isSearch = isset($isSearch) ? $isSearch : false;
$required = array();
if (!isset($type)) {
	$type = null;
}
foreach ($model->getValidators($field) as $validator)
{
	/** @val CValidator $validator */
	if ($validator instanceof CRequiredValidator)
	{
		$required = $validator->attributes;
	}

	/** @val CValidator $validator */
	if ($validator instanceof CStringValidator)
	{
		$style['maxlength'] = $validator->max;

		if ($validator->max > 256 && !$type == 'redactor')
		{
			$type = 'textarea';
		}
	}

	if ($validator instanceof CDateValidator && $type != 'datetime')
	{
		$type = 'date';

		if (!empty($model->$field))
		{
			$model->$field = Yii::app()->dateFormatter->format($validator->format, $model->$field);
		}
	}
	elseif ($validator instanceof CFileValidator)
	{
		$type = 'file';
	}
	elseif ($validator instanceof CBooleanValidator)
	{
		if ($isSearch == true)
		{
			$data = array(
				null => '--Все--',
				1 => 'Да',
				0 => 'Нет',
			);

			$type = 'dropdown';
		}
		else
		{
			$type = 'checkbox';
		}
	}
}

$type 			= isset($type) ? $type : 'textfield';
$css 			= isset($style) ? array_merge($css, $style) : $css;

$placeholder 	= isset($placeholder) ? $placeholder : null;
if (isset($defaultValue) && empty($model->$field))
{
	$model->$field = $defaultValue;
}

if ($type == 'hidden')
{
	echo $form->hiddenField($model, $field, $css);
}
else
{
	$label_config = array(
		'class' => $css['label_class']
	);

	if (isset($style['id']) && !empty($style['id']))
	{
		$label_config['for'] = $style['id'];
	}
?>
<div class="<?= $css['group_class'] ?>">
	<?php
		if (in_array($field, $required))
		{
			$label_config['label'] = $model->getAttributeLabel($field) . ' <span class="text-danger">*</span>';

			echo $form->label($model, $field, $label_config);
		}
		else
		{
			echo $form->label($model, $field, $label_config);
		}
	?>

	<?php
	if (isset($join))
	{
		$provider['model'] = (key($join));

		$provider['model'] = $provider['model']::model()->findAll(array(
			'order' => current($join)[1])
		);

		$data = CHtml::listData($provider['model'], current($join)[0], current($join)[1]);

		if ($isSearch == true)
		{
			$data[null] = '--Все--';
			ksort($data);
		}
	}
	?>

	<div class="<?= $css['parent_class'] ?>">
		<?php
			$this->renderPartial('../components/_field_type', array(
				'model' => $model,
				'field' => $field,
				'css' => $css,
				'type' => $type,
				'form' => $form,
				'data' => $data,
				'placeholder' => $placeholder,
			));
		?>
	</div>
</div>
<?php
}