<?php

Yii::import('application.models._base.BaseSetting');

/**
 * Class Setting
 */
class Setting extends BaseSetting
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

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		return [
			'intSettingID' => 'ID',
			'varName' => Yii::t('app', 'Name'),
			'varValue' => Yii::t('app', 'Value')
		];
	}
}