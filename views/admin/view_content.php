<?php

$this->title = Yii::t('app', 'View Content');
use yii\grid\GridView;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

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
	<div class="card-header">
		<h3 class="card-title"><?= $model->movie_name ?></h3>
		<div class="card-tools">
			<!-- Buttons, labels, and many other things can be placed here! -->
			<!-- Here is a label for example -->
			<span class="badge badge-primary"></span>
		</div>
		<!-- /.card-tools -->
	</div>
	<!-- /.card-header -->
	<div class="card-body">
		<div class="col-md-12">
			<!-- Video Player Starts -->
			<?php 
			//throw new \Exception($model->path);
				$movie_file_path = $model->path;
				echo "<div class=\"video-player\">
				<video controls autoplay fullscreen>
				<source src=\"$movie_file_path\" type='video/mp4'>
				</video>
				</div>";
			?>
			<!-- Video Player Ends -->
		</div>
	</div>
	<!-- /.card-body -->
	<div class="card-footer">
	</div>
	<!-- /.card-footer -->
</div>
<!-- /.card -->