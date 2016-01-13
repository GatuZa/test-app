<?php
/**
 * @var CModel|MultiLangBehavior $model
 * @var string $field
 * @var array $css
 * @var string $type
 * @var CActiveForm $form
 * @var string $placeholder
 * @var ListLang $lang
 * @var array $data
 */
$langError = '';
if (isset($lang)) {
	$valueModel = $model->lang($lang->varSing);
	$value = $valueModel->$field;
	$langError = $valueModel->getError($field);

	$lang_attr = [
		'name' => sprintf('%s[%s][%s]', get_class($model), $lang->varSing, $field),
		'id' => sprintf('%s_%s_%s', get_class($model), $lang->varSing, $field),
		'value' => $value ? $value : ''
	];

	$css = array_merge($css, $lang_attr);
} else {
	$langError = $model->getError($field);
	$lang_attr = [];
}

switch ($type) {
	case 'readonly':
		echo '<span class="form-control">' . $model->$field . '</span>';
		break;

	case 'redactor':
		$css = array_merge($css, ['class' => 'redactor']);

		$cs = Yii::app()->clientScript;

		$cs->registerCSSFile('/themes/bootstrap/css/redactor.css');
		$cs->registerScriptFile('/themes/bootstrap/js/redactor.js');
		echo '
		<script type="text/javascript">
			$(function() {
				$(".redactor").redactor({
					minHeight: 300
				});
			})
		</script>';
		echo $form->textArea($model, $field, array_merge($css, ['rows' => 5]));
		break;

	case 'textarea':
		echo $form->textArea($model, $field, array_merge($css, ['rows' => 5]));
		break;
	case 'file':
		$css['data-ui-file-upload'] = '';
		$css['class'] .= ' form-control-file';
		$css['value'] = $model->$field;

		echo $form->fileField($model, $field, $css);

		if ($model->$field) {
			$destination = $model->getStoragePath() . $model->$field;
			$stored = $model->getStorageDir() . $model->$field;

			$mime = null;

			if (file_exists($stored)) {
				$mime = mime_content_type($stored);
			}

			$is_image = (strpos($mime, 'image') !== false);
			?>
			<span class="file-input-name" data-ng-controller="ModalDemoCtrl">
				<script type="text/ng-template" id="myModalContent.html">
					<div class="modal-body">
						<img style="width: 560px;" src="<?= $destination ?>">
					</div>
				</script>

				<?= ($mime == null) ? '<span class="label label-danger" title="Файл не найден"><i class="glyphicon glyphicon-info-sign"></i></span>' : '' ?>
				<?php if ($is_image): ?>
					<a href="<?= $destination ?>" data-trigger="openimage"
					   data-src="<?= $destination ?>"><?= $model->$field ?></a>
				<?php else: ?>
					<a href="<?= $destination ?>"><?= $model->$field ?></a>
				<?php endif; ?>
			</span>
		<?php
		}
		break;
	case 'checkbox':
		printf('<span class="checkbox col-md-1">%s</span>', $form->checkBox($model, $field, $lang_attr));
		break;
	case 'radio':
		printf('<span class="radio">%s</span>', $form->radioButton($model, $field, $lang_attr));
		break;
	case 'dropdown':
		echo $form->dropDownList($model, $field, $data, $css);
		break;
	case 'dropdown_multiple':
		echo $form->dropDownList($model, $field, $data, array_merge($css, ['multiple' => 'multiple']));
		break;
	case 'password':
		$model->$field = '';
		echo $form->passwordField($model, $field, $css);
		break;
	case 'datetime':
		$this->widget('CJuiDateTimePicker', [
			'model' => $model,
			'attribute' => $field,
			'language' => 'ru',
			'htmlOptions' => $css,
			'options' => [
				'dateFormat' => 'yy-mm-dd',
				'timeFormat' => 'hh:mm:ss',
				'showAnim' => 'fadeIn',
				'changeMonth' => true,
				'changeYear' => true,
				'yearRange' => date('Y', strtotime('-70 years')) . ':' . date('Y')
			]
		]);
		break;
	case 'date':
		$this->widget('zii.widgets.jui.CJuiDatePicker', [
			'model' => $model,
			'attribute' => $field,
			'language' => 'ru',
			'htmlOptions' => $css,
			'options' => [
				'dateFormat' => 'yy-mm-dd',
				'showAnim' => 'fadeIn',
				'changeMonth' => true,
				'changeYear' => true,
				'yearRange' => date('Y', strtotime('-70 years')) . ':' . date('Y')
			]
		]);
		break;
	case 'tags':
		$this->widget('CAutoComplete', [
			'attribute' => $field,
			'model' => $model,
			'url' => '/admin/index/tags',
			'multiple' => true,
			'mustMatch' => false,
			'matchCase' => false,
			'htmlOptions' => $css
		]);
		break;
	case 'text':
	default:
		echo $form->textField($model, $field, $css);
		break;
}

if (!empty($langError)) {
	if ($type == 'checkbox') {
		echo '<div class="help-block text-danger error-block" style="margin-left: 20px;">' . $langError . '</div>'; // ошибки чекбокса криво отображались
	} else {
		echo '<div class="help-block text-danger error-block">' . $langError . '</div>';
	}
} else if ($placeholder) {
	echo '<div class="help-block text-info">' . $placeholder . '</div>';
}