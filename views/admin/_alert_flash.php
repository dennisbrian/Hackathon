<?php
	$base_url = Yii::$app->request->baseUrl;
 ?>
<div class="">
	<?php if (Yii::$app->session->hasFlash('success')): ?>
		<div class="alert alert-success"><?= Yii::t('app', Yii::$app->session->getFlash('success')) ?>
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
	<?php endif; ?>

	<?php if (Yii::$app->session->hasFlash('error')): ?>
		<div class="alert alert-danger" role="alert"><?= Yii::t('app', Yii::$app->session->getFlash('error')) ?>
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
	<?php endif; ?>

	<?php if (Yii::$app->session->hasFlash('warning')): ?>
		<div class="alert alert-warning"><?= Yii::t('app', Yii::$app->session->getFlash('warning')) ?>
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
	<?php endif; ?>

	<?php if (Yii::$app->session->hasFlash('info')): ?>
		<div class="alert alert-info"><?= Yii::t('app', Yii::$app->session->getFlash('info')) ?>
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
	<?php endif; ?>
</div>
