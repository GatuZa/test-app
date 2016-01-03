<?php
/**
 * @var array $buttons
 * @var CModel $model
 */
if (isset($buttons) && !Yii::app()->request->isAjaxRequest):
	?>
	<div class="pull-right">
		<div class="row">
			<div class="col-md-12 text-right">
				<div class="btn-group">
					<?php
					if (array_key_exists('custom', $buttons))
					{
						echo $buttons['custom'];
					}
					else
					{
						foreach ($buttons as $link)
						{
							$class = 'btn btn-flow-header btn-';
							$icon = 'glyphicon glyphicon-';

							switch ($link)
							{
								case 'create':
									$class .= 'primary';
									$label = 'Добавить';
									$icon .= 'plus';
									break;
								case 'back':
									$class .= 'info';
									$label = 'Назад';
									$icon .= 'arrow-left';
									$link = '';
									break;
								default:
									$class = 'default';
									$label = 'Добавить';
									$icon .= 'plus';
									break;
							}

							printf('<a href="/%1$s/%2$s" id="action_%2$s" class="%3$s"><i class="%4$s"></i> %5$s</a>', Yii::app()->controller->id, $link, $class, $icon, $label);
						}
					}
					?>
				</div>
			</div>
		</div>
	</div>
<?php
endif;
?>