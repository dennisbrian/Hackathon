<?php

use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use kartik\datetime\DateTimePicker;
use yii\widgets\Breadcrumbs;
use app\forms\CMSForm;
use app\models\SystemSetting;
use kartik\file\FileInput;

if ($type == 'create' ) {
	$this->title = Yii::t('app','Create Content');
} else {
	$this->title = Yii::t('app','Update Content');
}

$this->registerCss(
	"
	.btn.btn-file {
		padding-right: 500%;
	}

	.input-group-addon.kv-datetime-picker{
		width:40px
	}

	.input-group-addon.kv-datetime-remove{
		width:40px
	}
 "
);

Yii::$app->assetManager->bundles['yii\web\YiiAsset'] = false; // Add this to prevent bootstrap4 Modal css file injected
Yii::$app->assetManager->bundles['yii\bootstrap\BootstrapAsset'] = false; // Add this to prevent bootstrap4 Modal js file injected
Yii::$app->assetManager->bundles['kartik\base\WidgetAsset'] = false; // Add this to prevent jquery file injected

?>
<div class="card card-default">
	<div class="page-title">
		<?= Breadcrumbs::widget([
			'itemTemplate' => "<li> <i>{link} / </i> </li>\n",
			'links' => [
				['label' => 'Dashboard', 'url' => ['admin/dashboard']],
				$this->title,
			],
		]);
		?>
	</div>
	<?= $this->render('/admin/_alert_flash', []) ?>

	<div class ="card-body">
		<?php $form = ActiveForm::begin([
			'method' => 'post',
			'options' => [
				'data-pjax' => true,
			],
			'fieldConfig' => [
				'inputOptions' => [
					'class' => 'input-sm form-control',
				],
			],
		]);
		?>
		<div class="row">
			<div class="col-md-12">
				<label><b><?= Yii::t('app','Genre')?></b></label>
			</div>
			<div class="col-md-12">
				<?= $form->field($model, 'genre')->dropDownList([
					''       => Yii::t('app' , 'Please Select Your Genre'),
					'action'    => Yii::t('app' , 'Action'),
					'romance'    => Yii::t('app' , 'Romance'),
					'drama'    => Yii::t('app' , 'Drama'),
				] , [
				])->label(false) ?>

			</div>

			<div class="col-md-12">
				<label><b><?= Yii::t('app','Movie Name')?></b></label>
			</div>
			<div class="col-md-12">
				<?= $form->field($model, 'movie_name')->textInput(['style'=>'width:100%','disabled'=> false])->label(false) ?>
			</div>

			<div class="col-md-12">
				<label><b><?= Yii::t('app','Cover Image')."<span style='color:red'> *</span>" ?></b></label>
			</div>
			<div class="col-md-12">
				<?= $form->field($model, 'cover')->fileInput()->label(false)->hint((Yii::t('app','Only Accept PNG , and JPEG , Max File Size is 5MB ')));
				?>
			</div>
			<div class="col-md-12">
				<label><b><?= Yii::t('app','Video File')."<span style='color:red'> *</span>" ?></b></label>
			</div>

			<div class="col-md-12">
				<?= $form->field($model, 'path')->fileInput()->label(false)->hint((Yii::t('app','Only Accept mp4 , Max File Size is 50MB')));
				?>
			</div>

			<div class="col-md-12">
				<label><b><?= Yii::t('app','Is VIP')?></b></label>
			</div>
			<div class="col-md-12">
				<?= $form->field($model, 'is_vip')->dropDownList([
					''       => Yii::t('app' , 'Please Select Your VIP type'),
					0    => Yii::t('app' , 'No'),
					1    => Yii::t('app' , 'Yes'),
				] , [
				])->label(false) ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group" style="float: right;">
					<?php if ($type == 'create'): ?>
						<?php $action = 'Create'; ?>
					<?php endif; ?>
					<?php if ($type == 'update'): ?>
						<?php $action = 'Update'; ?>
					<?php endif; ?>
					<?= Html::submitButton(Yii::t('app', $action), [
						'class' => 'btn btn-flat btn-success',
						'name'  => $action,
						'value' => 1,
					]) ?>
				</div>
				<div class="form-group" style="float: right;">
					<?= Html::a(Yii::t('app','Back'),Url::to(['admin/dashboard']),['class' => 'btn btn-flat btn-primary',]); ?>
				</div>
			</div>
		</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>
