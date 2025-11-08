<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TransaksiDetil $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="transaksi-detil-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'transaksi_id')->textInput() ?>

    <?= $form->field($model, 'obat_id')->textInput() ?>

    <?= $form->field($model, 'harga_jual')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'qty')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
