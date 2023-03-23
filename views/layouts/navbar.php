<?php

use yii\helpers\Html;

?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?=\yii\helpers\Url::home()?>" class="nav-link">Home</a>
        </li>
        <?php if (Yii::$app->user->isGuest): ?>
            <li class="nav-item d-none d-sm-inline-block">
                <?=
                    Html::a(Yii::t('app', 'Login'), ['site/login'], [
                    'class' => 'nav-link',
                    ]);
                ?>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <?=
                    Html::a(Yii::t('app', 'Signup'), ['site/register'], [
                    'class' => 'nav-link',
                    ]);
                ?>
            </li>
        <?php endif; ?>
        <?php if (!Yii::$app->user->can('movies')): ?>
            <li class="nav-item d-none d-sm-inline-block">
                <?=
                Html::a(Yii::t('app', 'Premium'), ['site/premium'], [
                    'class' => 'nav-link',
                ]);
                ?>
            </li>
        <?php endif; ?>
        <?php if (Yii::$app->user->can('movies')): ?>
            <li class="nav-item d-none d-sm-inline-block">
                <?=
                    Html::a(Yii::t('app', 'User Management'), ['admin/user-management'], [
                    'class' => 'nav-link',
                    ]);
                ?>
            </li>
        <?php endif; ?>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
        </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <?= Html::a('<i class="fas fa-sign-out-alt"></i>', ['/site/logout'], ['data-method' => 'post', 'class' => 'nav-link']) ?>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->