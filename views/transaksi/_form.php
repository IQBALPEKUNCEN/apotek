<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\jui\DatePicker;
use webvimark\modules\UserManagement\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Transaksi */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="transaksi-form">

    <?php $form = ActiveForm::begin([
        'id' => 'transaksi-form',
        'options' => ['autocomplete' => 'off'],
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'form-label mt-2'],
            'inputOptions' => ['class' => 'form-control'],
            'errorOptions' => ['class' => 'invalid-feedback d-block'],
        ],
    ]); ?>

    <?= $form->field($model, 'kode_transaksi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tanggal')->widget(DatePicker::class, [
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control']
    ]) ?>

    <?= $form->field($model, 'kasir_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(
            User::find()->where(['status' => 10])->all(), // aktif
            'id',
            'username'
        ),
        ['prompt' => 'Pilih Kasir']
    ) ?>

    <?= $form->field($model, 'total')->textInput(['maxlength' => true, 'type' => 'number']) ?>

    <div class="d-grid mt-3">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success btn-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>