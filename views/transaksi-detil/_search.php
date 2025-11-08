<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TransaksiDetilSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="transaksi-detil-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'transaksi_id') ?>

    <?= $form->field($model, 'obat_id') ?>

    <?= $form->field($model, 'harga_jual') ?>

    <?= $form->field($model, 'qty') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
