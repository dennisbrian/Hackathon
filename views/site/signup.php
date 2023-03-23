<?php
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
$this->title = Yii::t('app', 'Signup');
?>

<div class="login-box">
    <div class="login-logo text-center" style= "padding: 10px;" >
        <?php if (!empty(Yii::$app->params['company_login'])): ?>
            <img src="<?= Yii::$app->params['company_login'] ?>"width="50%" height="50%" ;>
        <?php endif; ?>
    </div>
    <!-- /.login-logo -->
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class = "card-header text-center">
                <?= $this->render('/admin/_alert_flash', []) ?>
                <p class="login-box-msg"><?= Yii::t('app','Create Your Account') ?></p>
            </div>

            <div class="card-body login-card-body">
                <?php $form = ActiveForm::begin(['id' => 'signup-form']) ?>
                <?= $form->field($model,'email', [
                    'options' => ['class' => 'form-group '],
                    'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>',
                    'template' => '{beginWrapper}{input}{endWrapper}',
                    'wrapperOptions' => ['class' => 'input-group']
                ])
                ->label(false)
                ->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>

                <?= $form->field($model, 'password', [
                    'options' => ['class' => 'form-group '],
                    'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
                    'template' => '{beginWrapper}{input}{endWrapper}',
                    'wrapperOptions' => ['class' => 'input-group']
                ])
                ->label(false)
                ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>
                <div class="row">
                    <div class="col-12">
                        <?= Html::submitButton('Sign Up', [
                            'class' => 'btn btn-primary btn-block',
                            'name'  => 'submited',
                            'id'    => 'submited',
                            'value' => 1,
                        ]
                        ) ?>
                        <a href="<?=\yii\helpers\Url::home()?>" class="btn btn-primary btn-block">Back</a>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            <!-- /.login-card-body -->
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
