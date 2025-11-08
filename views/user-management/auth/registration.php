<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $model webvimark\modules\UserManagement\models\forms\RegistrationForm */

$this->title = 'Daftar Akun Baru';
?>

<div class="user-management-registration container mt-5">

    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-primary text-white">
                    <h4 class="mb-0"><?= Html::encode($this->title) ?></h4>
                </div>
                <div class="card-body">

                    <?php $form = ActiveForm::begin([
                        'id' => 'registration-form',
                        'options' => ['autocomplete' => 'off'],
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
                    ])->hint('Password minimal 8 karakter, huruf besar, huruf kecil & angka') ?>

                    <?= $form->field($model, 'repeat_password')->passwordInput([
                        'placeholder' => 'Ulangi Password'
                    ]) ?>

                    <?= $form->field($model, 'captcha')->widget(Captcha::class, [
                        'captchaAction' => '/user-management/auth/captcha',
                        'options' => ['placeholder' => 'Masukkan kode captcha'],
                        'template' => '<div class="row"><div class="col-6">{image}</div><div class="col-6">{input}</div></div>',
                    ]) ?>

                    <div class="d-grid mt-3">
                        <?= Html::submitButton('Daftar', ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                    <div class="auth-links mt-3 text-center">
                        <p>Sudah punya akun? <?= Html::a('Login di sini', ['/user-management/auth/login']) ?></p>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>