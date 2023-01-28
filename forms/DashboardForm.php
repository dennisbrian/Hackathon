<?php

namespace app\forms;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Movies;
use app\models\User;

class DashboardForm extends Model
{
	public $id;
	public $movie_name;
	public $genre;
	public $cover;
	public $path;
	public $is_vip;

	public function rules()
	{
		return [
			[['id','movie_name','genre','cover','path','is_vip'],'safe'],
			[['id','movie_name','genre','cover','path'],'safe','on' => 'create'],
			[['id','movie_name','genre','cover','path'],'safe','on' => 'update'],
			[['path'], 'file', 'skipOnEmpty' => true, 'extensions' => 'mp4','maxSize' => 1024 * 1024 * 50],
			[['cover'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpeg,JPG,jpg','maxSize' => 1024 * 1024 * 5],
		];
	}

	public function getQuery()
	{
		$query = Movies::find();
		$query->andWhere(['is_delete' => 0]);
		$query->andFilterWhere(['genre' => $this->genre]);
		$query->andFilterWhere(['movie_name' => $this->movie_name]);
		$query->orderBy(['id' => SORT_DESC]);
		return $query;
	}

	public function getProvider()
	{
		$dataProvider =  new ActiveDataProvider([
			'query' => $this->getQuery(),
			'sort'  => [
				'defaultOrder' => [
					'id' => SORT_DESC,
				],
				'attributes' => [
				],
			],
			'pagination'   => false
		]);

		return $dataProvider;
	}

	public function getContent($id)
	{
		$model = Movies::findOne(['id' => $id, 'is_delete' => 0]);
		if(empty($model)){
			throw new \Exception('Movies id not found');
		}
		$this->movie_name = $model->movie_name;
		$this->genre   = $model->genre;
		$this->cover = $model->cover;
		$this->path   = $model->path;
		$this->is_vip = $model->is_vip;
	}

	public function updateFile($id,$data_file,$file_type)
	{
		$model = Movies::findOne(['id' => $id, 'is_delete' => 0]);
		if(empty($model)){
			throw new \Exception('Movies id not found');
		}
		$filepath  ='';

		if(!empty($data_file)){
			$file      = date("Ymdhis")."-{$data_file->name}";
			$filename  = Yii::getAlias("@app/runtime/$file");
			$data_file->saveAs($filename);

			$s3file  = Yii::getAlias("@s3-file/{$file}");
			$type    = mime_content_type($filename);

			$aws = Yii::$app->aws->client();
			$s3  = $aws->createS3();
			$result = $s3->putObject([
				'ACL' => 'public-read',
				'Bucket' => Yii::$app->params['s3_bucket'],
				'ContentType' => $type,
				'SourceFile' => $filename,
				'Key' => $s3file,
			]);

			$filepath = $result->get('ObjectURL');
			gc_collect_cycles();
			unlink($filename);
			$model->updated_at = date("Y-m-d H:i:s");
			if($file_type == 'cover'){
				$model->cover = $filepath;
			}else{
				$model->path = $filepath;
			}

			$model->update(false, ['cover','path','updated_at']);
		}
	}

	public function saveContent()
	{
		$action_by = Yii::$app->user->identity->id;
		$model = new Movies;
		$model->movie_name      = $this->movie_name;
		$model->genre        = $this->genre;
		$model->is_vip   = $this->is_vip;
		$model->created_at = date('Y-m-d H:i:s');

		if(!$model->save()){
			throw new \Exception(current($model->getFirstErrors()));
		}

		$this->updateFile($model->id,$this->cover,'cover');
		$this->updateFile($model->id,$this->path,'path');

		return $model;
	}

	public function updateContent($id)
	{
		$model = Movies::findOne(['id' => $id, 'is_delete' => 0]);
		if(empty($model)){
			return false;
		}

		if(isset($this->movie_name)){
			$model->movie_name    = $this->movie_name;
		}

		if(isset($this->genre)){
			$model->genre    = $this->genre;
		}

		if(isset($this->is_vip)){
			$model->is_vip    = $this->is_vip;
		}

		$model->update(false,['movie_name','genre','cover','path','is_vip','updated_at']);
		$this->updateFile($model->id,$this->cover,'cover');
		$this->updateFile($model->id,$this->path,'path');

		return $model;
	}

	public function deleteContent($id)
	{
		$model = Movies::findOne(['id' => $id, 'is_delete' => 0]);
		if(empty($model)) {
			return false;
		}

		$model->is_delete = 1;
		$model->update([false, 'is_delete']);

		return true;
	}

	public function getUserQuery()
	{
		$query = User::find();
		$query->andWhere(['is_delete' => 0]);
		$query->andWhere(['role' => 'user']);
		$query->orderBy(['id' => SORT_DESC]);
		return $query;
	}

	public function getUserProvider()
	{
		$dataProvider =  new ActiveDataProvider([
			'query' => $this->getUserQuery(),
			'sort'  => [
				'defaultOrder' => [
					'id' => SORT_DESC,
				],
				'attributes' => [
				],
			],
			'pagination'   => false
		]);

		return $dataProvider;
	}

	public function setVip($id)
	{
		$model = User::findOne(['id' => $id, 'is_delete' => 0]);
		if(empty($model)) {
			return false;
		}

		if($model->is_vip == 0){
			$model->is_vip = 1;
		}else{
			$model->is_vip = 0;
		}

		$model->update([false, 'is_vip']);

		return true;
	}
}