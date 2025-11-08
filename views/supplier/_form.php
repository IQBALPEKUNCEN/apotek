<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Supplier $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="supplier-form">

    <?php $form = ActiveForm::begin([
        'id' => 'supplier-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{hint}\n{error}",
            'labelOptions' => ['class' => 'control-label'],
        ],
    ]); ?>

    <div class="box box-primary">
        <div class="box-body">

            <?= $form->field($model, 'nama_supplier')->textInput([
                'maxlength' => true,
                'placeholder' => 'Masukkan nama supplier',
                'class' => 'form-control'
            ])->label('Nama Supplier <span class="text-danger">*</span>') ?>

            <?= $form->field($model, 'alamat')->textarea([
                'rows' => 4,
                'placeholder' => 'Masukkan alamat lengkap supplier',
                'class' => 'form-control'
            ])->label('Alamat <span class="text-danger">*</span>') ?>

            <?= $form->field($model, 'no_hp')->textInput([
                'maxlength' => true,
                'placeholder' => 'Contoh: 081234567890',
                'class' => 'form-control'
            ])->label('No. HP/Telepon <span class="text-danger">*</span>') ?>

        </div>

        <div class="box-footer">
            <div class="form-group">
                <?= Html::submitButton('<i class="fa fa-save"></i> Simpan', [
                    'class' => 'btn btn-success'
                ]) ?>
                <?= Html::a('<i class="fa fa-times"></i> Batal', ['index'], [
                    'class' => 'btn btn-default'
                ]) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>