<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_role".
 *
 * @property string $name
 * @property string|null $label
 * @property string|null $description
 * @property string $created_at
 * @property string|null $updated_at
 * @property int|null $is_delete
 */
class UserRole extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'user_role';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['name'], 'required'],
			[['created_at', 'updated_at'], 'safe'],
			[['is_delete'], 'integer'],
			[['name', 'label'], 'string', 'max' => 100],
			[['description'], 'string', 'max' => 255],
			[['name'], 'unique'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'name' => 'Name',
			'label' => 'Label',
			'description' => 'Description',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'is_delete' => 'Is Delete',
		];
	}
}
