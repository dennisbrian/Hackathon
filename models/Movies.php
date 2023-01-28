<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "movies".
 *
 * @property int $id
 * @property string|null $movie_name
 * @property string|null $genre
 * @property string|null $cover
 * @property string|null $path
 * @property string $created_at
 * @property string|null $updated_at
 * @property int|null $is_delete
 */
class Movies extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'movies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['is_delete'], 'integer'],
            [['movie_name', 'genre', 'cover', 'path'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'movie_name' => 'Movie Name',
            'genre' => 'Genre',
            'cover' => 'Cover',
            'path' => 'Path',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_delete' => 'Is Delete',
        ];
    }
}
