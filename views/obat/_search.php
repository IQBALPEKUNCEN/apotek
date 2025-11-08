<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ObatSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="obat-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'kode_obat') ?>

    <?= $form->field($model, 'nama_obat') ?>

    <?= $form->field($model, 'kategori') ?>

    <?= $form->field($model, 'stok') ?>

    <?php // echo $form->field($model, 'harga_beli') ?>

    <?php // echo $form->field($model, 'harga_jual') ?>

    <?php // echo $form->field($model, 'expired_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
