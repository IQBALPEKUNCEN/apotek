<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model webvimark\modules\UserManagement\models\forms\PasswordRecoveryForm */

$this->title = 'Lupa Password';
?>

<div class="user-management-password-recovery container mt-5">

    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-primary text-white">
                    <h4 class="mb-0"><?= Html::encode($this->title) ?></h4>
                </div>
                <div class="card-body">

                    <?php $form = ActiveForm::begin([
                        'id' => 'password-recovery-form',
                        'options' => ['autocomplete' => 'off'],
                        'fieldConfig' => [
                            'template' => "{label}\n{input}\n{error}",
                            'labelOptions' => ['class' => 'form-label'],
                            'inputOptions' => ['class' => 'form-control'],
                            'errorOptions' => ['class' => 'invalid-feedback'],
                        ],
                    ]); ?>

                    <?= $form->field($model, 'email')->textInput([
                        'autofocus' => true,
                        'placeholder' => 'Email Anda'
                    ]) ?>

                    <div class="d-grid mt-3">
                        <?= Html::submitButton('Kirim Link Reset Password', ['class' => 'btn btn-primary']) ?>
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