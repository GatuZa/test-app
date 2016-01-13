<?php
/**
 * @var array $columns
 * @var string $field
 * @var string $grid_type
 * @var bool $readonly
 * @var CActiveForm $form
 * @var CActiveRecord $model
 *
 * Если указан массив $columns то выводим в грид только поля
 * которые описанны в этом массиве
 */
if ((isset($columns) && in_array($field, $columns)) || (!isset($columns) && empty($columns))) {
	$input = [
		'form' => $form,
		'model' => $model,
		'field' => $field
	];

	if (isset($relations) && array_key_exists($field, $relations)) {
		$input['type'] = 'dropdown';
		$input['join'] = $relations[$field];
	}

	if (isset($types) && !empty($types) && array_key_exists($field, $types)) {
		$input['type'] = $types[$field];
	}

	if (isset($grid_type) && !empty($grid_type)) {
		if (!isset($grid_iterator)) {
			throw new \Exception('Empty Grid Iterator');
		} elseif (!is_numeric($grid_iterator)) {
			throw new \Exception('Grid Iterator is not numeric');
		}

		$input['style']['name'] = sprintf('%s[%s][%s]', get_class($model), $grid_iterator, $field);
		$input['style']['id'] = sprintf('%s_%s_%s', get_class($model), $grid_iterator, $field);
	}

	if ($field == $model->tableSchema->primaryKey) {
		$input['type'] = 'hidden';
	}

	if (isset($readonly)) {
		$input['type'] = 'readonly';
	}

	$this->renderPartial('../components/_add_field', $input);
}
