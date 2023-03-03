<?php

$this->title = Yii::t('app', 'Dashboard');
use yii\grid\GridView;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use app\models\User;
use yii\bootstrap\Carousel;

$this->registerJs('
	function actionAdjustment() {
	$(".modelButton").click(function(){
		$("#adjustment").modal("show")
		.find("#modelContent")
		.load($(this).attr("value"));
		});
	}

	function init() {
		actionAdjustment();
	}
	init();
');

$this->registerCss(
	"
	.a-box {
	  width: 100%;
	  border: 3px dotted;
	  border-color:#ffac81;
	  border-radius: 10px;
	  padding:5px 10px 5px 10px;
	  background-color:#f6e8ea;
	}

	.a-box h3 {
	    font-size:22px;
	}

	.a-box img {display:inline;
	padding:0 8px 0 0;}

	p.td-text {font-size:10px;
	  
	}

	.carousel {
		width:500px;
		height: 250px;
		margin-bottom: 30px;
	}

	* {
	box-sizing: border-box;
	}

	.column {
		float: left;
		width: 33.33%;
		padding: 5px;
	}

	.row::after {
		content: '';
		display: table;
		clear: both;
	}

 "
);
?>

<div id="adjustment" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div id="modelContent"></div>
		</div>
	</div>
</div>


<div class="card">
	<?= $this->render('/admin/_alert_flash', []) ?>
	<div class="card-header">
		<h3 class="card-title">Main</h3>
		<div class="card-tools">
			<!-- Buttons, labels, and many other things can be placed here! -->
			<!-- Here is a label for example -->
			<span class="badge badge-primary"></span>
		</div>
		<!-- /.card-tools -->
		<div class="text-right">
			<?= Html::button(Yii::t('app','Create'), [
				'value'=> Url::to(['admin/create-content']),
				'class'=> 'btn btn-sm btn-success modelButton',
				'style'=> ''
			]); ?>
		</div>
	</div>
	<?php $form = ActiveForm::begin([
			'method'      => 'get',
			'fieldConfig' => [
				'inputOptions' => [
					'class' => '',
					],
				],
		]); ?>
		<div class="card card-secondary">
			<div class="card-body">
				<div class="d-inline-block">
					<?= $form->field($model, 'genre')->dropDownList([
						''       => Yii::t('app' , 'Please Select Your Genre'),
						'action'    => Yii::t('app' , 'Action'),
						'romance'    => Yii::t('app' , 'Romance'),
						'drama'    => Yii::t('app' , 'Drama'),
					] , [
					])->label("Genre") ?>
				</div>

				<div class="d-inline-block">
					<?= $form->field($model, 'movie_name')->textInput(['style'=>'','disabled'=> false])->label('Movie Name') ?>
				</div>

				<div class="d-inline-block float-right">
					<?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-default btn-sm']) ?>
				</div>
			</div>
		</div>
	<?php ActiveForm::end(); ?>
	<!-- /.card-header -->
	<div class="card-body">
		<?= GridView::widget([
			'dataProvider' => $model->getProvider(),
			'layout'       => '{items}{pager}',
			'tableOptions' => [
				'class' => 'table dataTable table-bordered table-condensed table-hover table-head-fixed text-nowrap',
			],
			'options' => [
				'class' => 'grid-view table-responsive',
			],
			'pager' => [
				'class' => '\yii\bootstrap4\LinkPager',
			],
			'showFooter' => false,
			'columns'    => [
				[
					'label' => Yii::t('app','Cover'),
					'headerOptions' => ['style' => 'width:20%'],
					'format'=> 'raw',
					'value' => function ($model){
						if(empty($model->cover)){
							return "-";
						}
						$html = Html::img($model->cover, [
							'width' => '50%',
							//'height' => '10%'
						]);
						return $html;
					}
				],
				[
					'label' => Yii::t('app','Genre'),
					'value' => function ($model){
						if(empty($model->genre)){
							return "-";
						}
						return ucwords($model->genre);
					}
				],
				[
					'label' => Yii::t('app','Movie Name'),
					'value' => function ($model){
						if(empty($model->movie_name)){
							return "-";
						}
						return ucwords($model->movie_name);
					}
				],
				[
					'class'    => 'yii\grid\ActionColumn',
					'template' => '
					{update}{delete}{view}
					',
					'buttons'  => [
						'update' => function ($url, $model) {
							return Html::a(Yii::t('app', 'Update'), ['admin/update-content', 'id' => $model->id], [
								'class' => 'btn btn-default',
							]);
						},
						'delete' => function ($url, $model) {
							return Html::a(Yii::t('app', 'Delete'), ['admin/delete-content', 'id' => $model->id], [
								'class' => 'btn btn-danger',
								'data'      => [
									'confirm' => Yii::t('app', 'Are you sure you want to delete this content?'),
									'method'  => 'post',
								],
							]);
						},
						'view' => function ($url, $model) {
							$web = $model->path;
							if(!empty($web)){
								// return $tx_id =  Html::a('Views', Url::to($web),['target' => '_blank'
								// 	,'style' => 'color: black;','class' => 'btn btn-default',]);
								return Html::a(Yii::t('app', 'View'), ['admin/view-content', 'id' => $model->id], [
									'class' => 'btn btn-default',
								]);
							}
						},
					],
				],
			],
		]); ?>
	</div>
	<div class="row col-md-12">
		<?php 
		foreach($model->getInfo() as $data => $info) 
		{
			$path = '';
			$movie_cover_path = $info['cover'];
			$movie_name = ucwords($info['movie_name']);

			$user = User::findOne(['id' => Yii::$app->user->id]);
	  		if($info['is_vip'] == 0){
	  			if(Yii::$app->user->isGuest){
	  				 $path =  'site/view-content?id='.$info['id'];
	  			}
	  		}elseif(!empty($user)){
	  			if($user->is_vip == 1){
	  				$path =  'site/view-content?id='.$info['id'];
	  			}
	  		}else{
	  			$path = $info['path'];
	  		}
			echo "<div class = 'column' >";
			echo "<a href=".$path.">
			<img src=\"$movie_cover_path\" alt=\"$movie_name\" width=\"100%\">
			</a>";
			echo "</div>";
		}
		?>
	</div>
	<!-- /.card-body -->
	<div class="card-footer">
	</div>
	<!-- /.card-footer -->
</div>
<!-- /.card -->