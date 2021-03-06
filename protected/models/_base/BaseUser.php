<?php

/**
 * This is the model base class for the table "user".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "User".
 *
 * Columns in table "user" available as properties of the model,
 * followed by relations of table "user" available as properties of the model.
 *
 * @property string $intUserID
 * @property string $varName
 * @property string $varPassword
 * @property integer $intRoleID
 * @property integer $isActive
 *
 * @property Role $intRole
 */
abstract class BaseUser extends GxActiveRecord{
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
		return 'user';
	}

	/**
	 * @param int $n
	 *
	 * @return string
	 */
	public static function label($n = 1)
	{
		return Yii::t('app', 'User|Users', $n);
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
			array('varName, intRoleID', 'required'),
			array('intRoleID, isActive', 'numerical', 'integerOnly'=>true),
			array('varName', 'length', 'max'=>20),
			array('varPassword', 'length', 'max'=>40),
			array('varPassword, isActive', 'default', 'setOnEmpty' => true, 'value' => null),
			array('intUserID, varName, varPassword, intRoleID, isActive', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array
	 */
	public function relations()
	{
		return array(
			'intRole' => array(self::BELONGS_TO, 'Role', 'intRoleID'),
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
			'intUserID' => Yii::t('app', 'Int User'),
			'varName' => Yii::t('app', 'Var Name'),
			'varPassword' => Yii::t('app', 'Var Password'),
			'intRoleID' => null,
			'isActive' => Yii::t('app', 'Is Active'),
			'intRole' => null,
		);
	}

	/**
	 * @return CActiveDataProvider
	 */
	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('intUserID', $this->intUserID, true);
		$criteria->compare('varName', $this->varName, true);
		$criteria->compare('varPassword', $this->varPassword, true);
		$criteria->compare('intRoleID', $this->intRoleID);
		$criteria->compare('isActive', $this->isActive);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}