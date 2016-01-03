<?php
//print_r($isAdmin === false); die;
/**
 * @param $controller
 * @param $name
 * @param $isAdmin
 * @param $check
 *
 * @return string
 */
function add_menu($controller, $name, $isAdmin, $check = false)
{
	if (($check && $isAdmin) || !$check)
	{
		return sprintf('
			<li class="%s">
				<a href="/%s/">%s</a>
			</li>',
			Yii::app()->controller->id == $controller ? 'active' : '',
			$controller,
			$name
		);
	}

	return null;
}
?>

<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Открыть меню</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="/" class="navbar-brand"><span><?= Yii::app()->name ?></span></a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<?= add_menu('accounting', 'Accounting', $isAdmin); ?>
				<?= add_menu('user', 'Users', $isAdmin); ?>
				<?= add_menu('setting', 'Settings', $isAdmin, 1); ?>
			</ul>

			<ul class="nav navbar-nav pull-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="glyphicon glyphicon-user"></i>  <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="<?= Yii::app()->createUrl("user/edit", array("id" => Yii::app()->user->id)) ?>">
								<i class="glyphicon glyphicon-edit"></i>
								<?= Yii::app()->user->name ?>
							</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="/logout" id="logout">
								<i class="glyphicon glyphicon-off text-danger"></i>
								Выход
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>