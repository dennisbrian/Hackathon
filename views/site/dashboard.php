<?php

$this->title = Yii::t('app', 'Dashboard');
use yii\grid\GridView;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use app\models\User;
use yii\bootstrap\Carousel;

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

<div class="a-box card">
  <h3>Sponsoring Brokers</h3>
  
  <p>The brokers featured have been approved by InformedTrades editors and contribute financially to helping our learning community grow.   </p>
  
  <p class="td-text">TD Ameritrade, Inc. and InformedTrades are separate, unaffiliated companies and are not responsible for each other’s services and products.</p>
  
  <p class="td-text">The same is true for the relationship between InformedTrades and all other sponsors. </p>
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
	</div>
	<!-- /.card-header -->
	<div class="card-body" style="align-self:center;">
		<h3 style="text-align:center;">Upcoming Movie</h3>
		<?php echo Carousel::widget(
			[
				'items' => [
					[
						'content' => '<img src="https://pentajeucms-bucket.s3.ap-southeast-1.amazonaws.com/test-app/file/20230128041058-a%20garden%20of%20words.jpg"/>',
						'caption' => '<h4>This is title</h4><p>This is the caption text</p>',
						'options' => [
							'interval' => '600',
							'class'=>'carousel slide'
						]
					],
			]
		]); ?>
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

  <div class="row">
  	<?php 
	   	foreach($model->getInfo() as $data => $info) 
	  	{
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

  <?php if (false): ?>
		<div class="card-body col-md-3">
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
				'showHeader' => false,
				'showFooter' => false,
				'columns'    => [
					[
						//'label' => Yii::t('app','Cover'),
						'headerOptions' => ['style' => 'width:20%'],
						'format'=> 'raw',
						'headerOptions' => ['width' => '300px'],
						'contentOptions' => ['style'=>'padding:0px 0px 0px 30px;vertical-align: middle;'],
						'value' => function ($model){
							if(empty($model->cover)){
								return "-";
							}
							$html = Html::img($model->cover, [
								'width' => '200px',
								//'height' => '10%'
							]);
							return $html;
						}
					],
					[
						'label' => Yii::t('app','Genre'),
						'visible' => false,
						'value' => function ($model){
							if(empty($model->genre)){
								return "-";
							}
							return ucwords($model->genre);
						}
					],
					[
						'label' => Yii::t('app','Movie Name'),
						'visible' => false,
						'value' => function ($model){
							if(empty($model->movie_name)){
								return "-";
							}
							return ucwords($model->movie_name);
						}
					],
					[
						'class'    => 'yii\grid\ActionColumn',
						'visible' => false,
						'template' => '
						{view}
						',
						'buttons'  => [		
							'view' => function ($url, $model) {
								$web = $model->path;
								if(!empty($web)){
									$user = User::findOne(['id' => Yii::$app->user->id]);
									if($model->is_vip == 0){
										if(!Yii::$app->user->isGuest){
											return Html::a(Yii::t('app', 'View'), ['admin/view-content', 'id' => $model->id], [
												'class' => 'btn btn-default',
											]);
										}
									}else{
										if(!empty($user)){
											if($user->is_vip == 1){
												return Html::a(Yii::t('app', 'View'), ['admin/view-content', 'id' => $model->id], [
													'class' => 'btn btn-default',
												]);
											}
										}
									}

								}
							},
							
						],
					],
				],
			]); ?>
		</div>
	<?php endif; ?>
	<!-- /.card-body -->
	<div class="card-footer">
	</div>
	<!-- /.card-footer -->
</div>
<!-- /.card -->

<div class="a-box card">
  <h3>Sponsoring Brokers</h3>
  
  <p>The brokers featured have been approved by InformedTrades editors and contribute financially to helping our learning community grow.   </p>
  
  <p class="td-text">TD Ameritrade, Inc. and InformedTrades are separate, unaffiliated companies and are not responsible for each other’s services and products.</p>
  
  <p class="td-text">The same is true for the relationship between InformedTrades and all other sponsors. </p>
</div>
