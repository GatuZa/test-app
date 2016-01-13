<?php
/**
 * @var CController $this
 * @var CActiveDataProvider $dataProvider
 * @var CActiveRecord $model
 * @var array $columns
 * @var array $decorate
 * @var array $extra_fields
 * @var string $provider
 * @var array $custom_action
 * @var array $filter
 */
if (!isset($provider) && empty($provider)) {
	$provider = 'search';
}

if (!isset($columns) && empty($columns)) {
	$columns = [];
}

if (!isset($extra_fields) && empty($extra_fields)) {
	$extra_fields = [];
}

if (!isset($actions) && empty($actions)) {
	$actions = '';

	if (method_exists($model, 'getSortField')) {
		$actions .= '{sort_up}{sort_down}';
	}

	$actions .= '{edit} {delete}';
}

if (!isset($custom_action) && empty($custom_action)) {
	$custom_action = [];
} else if (strpos('{custom}', $actions) === false) {
	$actions .= ' {custom}';
}

$config = [
	'id' => $model->tableSchema->name . '-list',
	'dataProvider' => $model->$provider($provider ? $provider : 'search'),
	'ajaxUpdate' => false,
	'cssFile' => false,
	'summaryText' => '',
	'pager' => [
		'header' => false,
		'footer' => false,
		'htmlOptions' => ['class' => 'pagination'],
		'cssFile' => false
	],
	'itemsCssClass' => 'table table-striped table-bordered table-hover',
	'filterCssClass' => 'table-filters-box'
];

$config['columns'] = [];

$fields = iterator_to_array($model->getIterator());
$fields = array_merge($fields, array_fill_keys($extra_fields, null));
$columns = array_merge($columns, $extra_fields);

if ($columns) {
	$iterate = [];
	foreach ($columns as $field) {
		$iterate[$field] = $fields[$field];
	}
} else {
	$iterate = $fields;
}

foreach ($iterate as $field => $value) {
	/**
	 * Если указан массив $columns то выводим в грид только поля
	 * которые описанны в этом массиве
	 */
	if (isset($columns) && !empty($columns) && !in_array($field, $columns)) {
		continue;
	}

	/**
	 * Праймари ключ всегда в начале списка
	 */
	if ($field == $model->tableSchema->primaryKey) {
		array_unshift($config['columns'], [
			'name' => $field,
			'htmlOptions' => ['class' => 'column_' . $field]
		]);
	} /**
	 * Если есть JOIN поля, то подключаем выводим используя magic method __toString
	 */
	elseif (isset($relations) && array_key_exists($field, $relations)) {
		$join = $relations[$field];

		if (!is_array($join)) {
			/**
			 * @see $model->representingColumn()
			 * @link http://php.net/manual/ru/language.oop5.magic.php#object.tostring
			 */
			$relation_name = $join;
			$relation_value = '(string) $data->' . $join;
		} else {
			$relation_name = key($join);
			$relation_value = '$data->' . $relation_name . '->' . current($join);
		}

		array_push($config['columns'], [
			'name' => $relation_name,
			'type' => 'html',
			'value' => $relation_value,
			'header' => $model->getAttributeLabel($field),
			'htmlOptions' => ['class' => 'column_' . $field]
		]);
	} else {
		$validated = false;

		/**
		 * Преобразовываем поля в соответствия к валтидаторам
		 */
		foreach ($model->getValidators($field) as $validator) {
			/**
			 * Если поле описано как boolean - то рендерим как Да/Нет
			 */
			if ($validator instanceof CBooleanValidator) {
				array_push($config['columns'], [
					'name' => $field,
					'header' => $model->getAttributeLabel($field),
					'value' => '$data->' . $field . ' ? "<span data-value=\'".$data->' . $field . '."\' class=\'label label-warning\'>Да</span>" : "<span data-value=\'".$data->' . $field . '."\' class=\'label label-danger\'>Нет</span>"',
					'type' => 'raw',
					'htmlOptions' => ['class' => 'column_' . $field]

				]);

				$validated = true;
			} elseif ($validator instanceof CDateValidator) {
				array_push($config['columns'], [
					'name' => $field,
					'header' => $model->getAttributeLabel($field),
					'type' => 'html',
					'value' => 'Yii::app()->dateFormatter->format(\'' . $validator->format . '\', $data->' . $field . ')',
					'htmlOptions' => ['class' => 'column_' . $field]
				]);

				$validated = true;
			}
		}

		if (isset($decorate) && array_key_exists($field, $decorate)) {
			array_push($config['columns'], [
				'name' => $field,
				'header' => $model->getAttributeLabel($field),
				'type' => 'html',
				'htmlOptions' => ['class' => 'column_' . $field],
				'value' => sprintf('$data->%s', $decorate[$field])
			]);

			$validated = true;
		}

		/**
		 * Остальные поля выводим стандартно
		 */
		if ($validated === false) {
			array_push($config['columns'], [
				'name' => $field,
				'type' => 'html',
				'header' => $model->getAttributeLabel($field),
				'htmlOptions' => ['class' => 'column_' . $field]
			]);
		}
	}
}

if ($actions !== false) {
	$config['columns'][] = [
		'class' => 'CButtonColumn',
		'htmlOptions' => ['nowrap' => 'nowrap', 'style' => 'width: 110px;text-align:center'],
		'template' => '<div class="btn-group">' . $actions . '</div>',
		'buttons' => [
			'edit' => [
				'label' => CHtml::tag('span', ['class' => 'glyphicon glyphicon-pencil']),
				'imageUrl' => false,
				'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->id . '/edit", array("id" => $data->' . $model->tableSchema->primaryKey . '));',
				'options' => ['class' => 'btn btn-success btn-xs edit', 'title' => 'Edit']
			],
			'delete' => [
				'label' => CHtml::tag('span', ['class' => 'glyphicon glyphicon-floppy-remove']),
				'imageUrl' => false,
				'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->id . '/delete", array("id" => $data->' . $model->tableSchema->primaryKey . '));',
				'options' => ['class' => 'btn btn-danger btn-xs delete', 'title' => 'Delete'],
				'visible' => '!($data->' . $model->tableSchema->primaryKey . ' == Yii::app()->user->id && ' . $model->tableSchema->name . '== "user")'
			],
			'custom' => $custom_action
		]
	];
}

if (isset($search)) {
	echo '<div class="row">';
	$uri = parse_url($_SERVER['REQUEST_URI']);

	$form = $this->beginWidget('CActiveForm', [
		'id' => $model->tableSchema->name . '-search-form',
		'htmlOptions' => [
			'class' => 'form-vertical',

		],
		'action' => $uri['path'],
		'method' => 'get',
		'enableAjaxValidation' => false,
	]);


	foreach ($search as $field) {
		$input = [
			'type' => 'text',
			'form' => $form,
			'model' => $model,
			'field' => $field,
			'isSearch' => true,
			'style' => [
				'parent_class' => '',
				'label_class' => 'control-label',
				'group_class' => 'form-group col-md-6'
			]
		];

		if (isset($searchRelations) && array_key_exists($field, $searchRelations)) {
			$input['type'] = 'dropdown';
			$input['join'] = $searchRelations[$field];
		}

		$value = null;

		if (isset($_GET[ucfirst($model->tableName())]) && isset($_GET[ucfirst($model->tableName())][$field])) {
			$value = $_GET[ucfirst($model->tableName())][$field];
		}

		$model->$field = $value;
		$this->renderPartial('../components/_add_field', $input);
	}

	?>
	<div class="form-group buttons">
		<div class="col-md-12 btn-group">
			<?= CHtml::submitButton('Искать', [
				'class' => 'btn btn-primary'
			]); ?>

			<?= CHtml::link('Сбросить', $uri['path'], [
				'class' => 'btn btn-danger'
			]); ?>
		</div>
	</div>
	<?php

	$this->endWidget();

	echo '</div><br clear="all"><br clear="all">';
}


$this->widget('zii.widgets.grid.CGridView', $config); ?>