<?php

$this->title = Yii::t('app', 'View Content');
use yii\grid\GridView;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\models\User;

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
	<div class="page-title">
		<?= Breadcrumbs::widget([
			'itemTemplate' => "<li> <i>{link} / </i> </li>\n",
			'links' => [
				['label' => 'Dashboard', 'url' => ['site/dashboard']],
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
		<div class="row col-md-12">
			<div class="col-md-12">Suggestion</div>
			<br>
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

	</div>
	<!-- /.card-footer -->
</div>
<!-- /.card -->