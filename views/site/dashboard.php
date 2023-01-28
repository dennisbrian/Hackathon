<?php

$this->title = Yii::t('app', 'Dashboard');
use yii\grid\GridView;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use app\models\User;

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
