<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model webvimark\modules\UserManagement\models\forms\LoginForm */
/* @var $form yii\bootstrap5\ActiveForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-management-login container mt-5">

    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-primary text-white">
                    <h4 class="mb-0"><?= Html::encode($this->title) ?></h4>
                </div>
                <div class="card-body">

                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'options' => ['autocomplete' => 'off'],
                        'validateOnBlur' => false,
                        'fieldConfig' => [
                            'template' => "{label}\n{input}\n{error}",
                            'labelOptions' => ['class' => 'form-label'],
                            'inputOptions' => ['class' => 'form-control'],
                            'errorOptions' => ['class' => 'invalid-feedback'],
                        ],
                    ]); ?>

                    <?= $form->field($model, 'username')->textInput([
                        'autofocus' => true,
                        'placeholder' => 'Username'
                    ]) ?>

                    <?= $form->field($model, 'password')->passwordInput([
                        'placeholder' => 'Password'
                    ]) ?>

                    <?= $form->field($model, 'rememberMe')->checkbox([
                        'label' => 'Ingat saya'
                    ]) ?>

                    <div class="d-grid mt-3">
                        <?= Html::submitButton('Login', ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                    <div class="auth-links mt-3 text-center">
                        <p><?= Html::a('Lupa password?', ['/user-management/auth/password-recovery']) ?></p>
                        <p>Belum punya akun? <?= Html::a('Daftar di sini', ['/user-management/auth/registration']) ?></p>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .user-management-login .card-header h4 {
        font-weight: 600;
    }

    .user-management-login .auth-links a {
        text-decoration: none;
        color: #667eea;
    }

    .user-management-login .auth-links a:hover {
        text-decoration: underline;
    }
</style>