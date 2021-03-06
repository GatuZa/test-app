<?php

/**
 * This is the model base class for the table "setting".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Setting".
 *
 * Columns in table "setting" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $intSettingID
 * @property string $varName
 * @property string $varValue
 *
 */
abstract class BaseSetting extends GxActiveRecord{
	/**
	 * @param string $className
	 *
	 * @return CActiveRecord
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string
	 */
	public function tableName()
	{
		return 'setting';
	}

	/**
	 * @param int $n
	 *
	 * @return string
	 */
	public static function label($n = 1)
	{
		return Yii::t('app', 'Setting|Settings', $n);
	}

	/**
	 * @return array|string
	 */
	public static function representingColumn()
	{
		return 'varName';
	}

	/**
	 * @return array
	 */
	public function rules()
	{
		return array(
			array('varName, varValue', 'required'),
			array('varName', 'length', 'max'=>30),
			array('varValue', 'length', 'max'=>1000),
			array('intSettingID, varName, varValue', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array
	 */
	public function relations()
	{
		return array(
		);
	}

	/**
	 * @return array
	 */
	public function pivotModels()
	{
		return array(
		);
	}

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		return array(
			'intSettingID' => Yii::t('app', 'Int Setting'),
			'varName' => Yii::t('app', 'Var Name'),
			'varValue' => Yii::t('app', 'Var Value'),
		);
	}

	/**
	 * @return CActiveDataProvider
	 */
	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('intSettingID', $this->intSettingID);
		$criteria->compare('varName', $this->varName, true);
		$criteria->compare('varValue', $this->varValue, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}