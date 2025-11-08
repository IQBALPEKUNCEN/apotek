<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/** @var yii\web\View $this */
/** @var app\models\Obat $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="obat-form">

    <?php $form = ActiveForm::begin([
        'id' => 'obat-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{hint}\n{error}",
        ],
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'kode_obat')->textInput([
                'maxlength' => true,
                'placeholder' => 'Contoh: OBT001',
                'autofocus' => $model->isNewRecord
            ])->label('Kode Obat') ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'nama_obat')->textInput([
                'maxlength' => true,
                'placeholder' => 'Contoh: Paracetamol 500mg'
            ])->label('Nama Obat') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'kategori')->dropDownList([
                'Tablet' => 'Tablet',
                'Kapsul' => 'Kapsul',
                'Sirup' => 'Sirup',
                'Salep' => 'Salep',
                'Injeksi' => 'Injeksi',
                'Tetes' => 'Tetes',
                'Lainnya' => 'Lainnya',
            ], [
                'prompt' => '-- Pilih Kategori --'
            ])->label('Kategori') ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'stok')->textInput([
                'type' => 'number',
                'min' => 0,
                'placeholder' => '0'
            ])->label('Stok')->hint('Jumlah stok tersedia') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'harga_beli')->textInput([
                'type' => 'number',
                'min' => 0,
                'step' => '100',
                'placeholder' => '0'
            ])->label('Harga Beli (Rp)') ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'harga_jual')->textInput([
                'type' => 'number',
                'min' => 0,
                'step' => '100',
                'placeholder' => '0'
            ])->label('Harga Jual (Rp)') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'expired_date')->widget(DatePicker::class, [
                'dateFormat' => 'yyyy-MM-dd',
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => 'Pilih tanggal kadaluarsa'
                ],
                'clientOptions' => [
                    'changeMonth' => true,
                    'changeYear' => true,
                    'yearRange' => '2024:2035',
                    'minDate' => 0,
                    'showButtonPanel' => true,
                ]
            ])->label('Tanggal Kadaluarsa') ?>
        </div>
    </div>

    <div class="form-group">
        <div class="btn-group">
            <?= Html::submitButton(
                '<i class="glyphicon glyphicon-floppy-disk"></i> ' . ($model->isNewRecord ? 'Simpan' : 'Update'),
                ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
            ) ?>
            <?= Html::a(
                '<i class="glyphicon glyphicon-remove"></i> Batal',
                ['index'],
                ['class' => 'btn btn-default']
            ) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
// JavaScript untuk validasi harga jual > harga beli
$this->registerJs("
$('#obat-form').on('beforeSubmit', function(e) {
    var hargaBeli = parseFloat($('#obat-harga_beli').val()) || 0;
    var hargaJual = parseFloat($('#obat-harga_jual').val()) || 0;
    
    if (hargaJual <= hargaBeli) {
        alert('Harga jual harus lebih besar dari harga beli!');
        return false;
    }
    return true;
});

// Auto-format harga dengan pemisah ribuan
$('#obat-harga_beli, #obat-harga_jual').on('blur', function() {
    var val = $(this).val();
    if (val) {
        $(this).val(parseFloat(val));
    }
});
");
?>