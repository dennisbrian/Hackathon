<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;

\hail812\adminlte3\assets\FontAwesomeAsset::register($this);
\hail812\adminlte3\assets\PluginAsset::register($this);
\hail812\adminlte3\assets\BaseAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="<?= Yii::$app->params['company_logo'] ?>">
	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
</head>

<?php $this->beginBody() ?>
<body class="login-page" style="min-height: 574px;padding-left:30%; padding-right: 30%;padding-top:10%;background-color:#e9ecef  ">
	<?= $content ?>
</body>

<?php $this->endBody() ?>

</html>
<?php $this->endPage() ?>
