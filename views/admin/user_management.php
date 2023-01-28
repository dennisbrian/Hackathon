<?php

$this->title = Yii::t('app', 'User Management');
use yii\grid\GridView;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;
?>
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
	<?php ActiveForm::end(); ?>
	<!-- /.card-header -->
	<div class="card-body">
		<?= GridView::widget([
			'dataProvider' => $model->getUserProvider(),
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
					'label' => Yii::t('app','Email'),
					'value' => function ($model){
						if(empty($model->email)){
							return "-";
						}
						return ucwords($model->email);
					}
				],
				[
					'label' => Yii::t('app','Is VIP'),
					'value' => function ($model){
						if(empty($model->is_vip)){
							return "No";
						}
						return "Yes";
					}
				],
				[
					'class'    => 'yii\grid\ActionColumn',
					'template' => '
					{vip}
					',
					'buttons'  => [
						'vip' => function ($url, $model) {
							if($model->is_vip == 0){
								return Html::a(Yii::t('app', 'Set to VIP'), ['admin/set-vip', 'id' => $model->id], [
									'class' => 'btn btn-success',
									'data'      => [
										'confirm' => Yii::t('app', 'Are you sure you want to set this user VIP?'),
										'method'  => 'post',
									],
								]);
							}else{
								return Html::a(Yii::t('app', 'Set to Non VIP'), ['admin/set-vip', 'id' => $model->id], [
									'class' => 'btn btn-success',
									'data'      => [
										'confirm' => Yii::t('app', 'Are you sure you want to set this user non VIP?'),
										'method'  => 'post',
									],
								]);
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