<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model webvimark\modules\UserManagement\models\forms\ResetPasswordForm */

$this->title = 'Reset Password';
?>

<div class="user-management-password-reset container mt-5">

    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-primary text-white">
                    <h4 class="mb-0"><?= Html::encode($this->title) ?></h4>
                </div>
                <div class="card-body">

                    <?php $form = ActiveForm::begin([
                        'id' => 'password-reset-form',
                        'options' => ['autocomplete' => 'off'],
                        'fieldConfig' => [
                            'template' => "{label}\n{input}\n{error}",
                            'labelOptions' => ['class' => 'form-label'],
                            'inputOptions' => ['class' => 'form-control'],
                            'errorOptions' => ['class' => 'invalid-feedback'],
                        ],
                    ]); ?>

                    <?= $form->field($model, 'password')->passwordInput([
                        'placeholder' => 'Password Baru'
                    ])->hint('Password minimal 8 karakter, huruf besar, huruf kecil & angka') ?>

                    <?= $form->field($model, 'repeat_password')->passwordInput([
                        'placeholder' => 'Ulangi Password Baru'
                    ]) ?>

                    <div class="d-grid mt-3">
                        <?= Html::submitButton('Reset Password', ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                    <div class="auth-links mt-3 text-center">
                        <p><?= Html::a('Login', ['/user-management/auth/login']) ?></p>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>