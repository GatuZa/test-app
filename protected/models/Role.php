<?php

Yii::import('application.models._base.BaseRole');

/**
 * Class Role
 */
class Role extends BaseRole
{
	/**
	 * @param string $className
	 *
	 * @return CActiveRecord
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}