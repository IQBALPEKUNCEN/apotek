<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\Supplier;
use app\models\Obat;

/** @var yii\web\View $this */
/** @var app\models\Pembelian $model */
/** @var yii\widgets\ActiveForm $form */

$this->registerJsFile('@web/js/pembelian-form.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>

<div class="pembelian-form">

    <?php $form = ActiveForm::begin(['id' => 'pembelian-form']); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'supplier_id')->dropDownList(
                ArrayHelper::map(Supplier::find()->all(), 'id', 'nama_supplier'),
                [
                    'prompt' => '-- Pilih Supplier --',
                    'class' => 'form-control'
                ]
            ) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'tanggal')->widget(DatePicker::class, [
                'dateFormat' => 'yyyy-MM-dd',
                'value' => date('Y-m-d'),
                'options' => ['class' => 'form-control'],
                'clientOptions' => [
                    'changeMonth' => true,
                    'changeYear' => true,
                    'yearRange' => '2020:2030',
                ]
            ]) ?>
        </div>
    </div>

    <hr>

    <h4>Detail Pembelian</h4>

    <table class="table table-bordered" id="detail-pembelian">
        <thead>
            <tr>
                <th width="40%">Obat</th>
                <th width="15%">Jumlah</th>
                <th width="20%">Harga Beli</th>
                <th width="20%">Subtotal</th>
                <th width="5%">
                    <button type="button" class="btn btn-success btn-sm" id="tambah-baris">
                        <i class="glyphicon glyphicon-plus"></i>
                    </button>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class="item-row">
                <td>
                    <?= Html::dropDownList(
                        'obat_id[]',
                        null,
                        ArrayHelper::map(Obat::find()->all(), 'id', 'nama_obat'),
                        ['prompt' => '-- Pilih Obat --', 'class' => 'form-control obat-select']
                    ) ?>
                </td>
                <td>
                    <input type="number" name="jumlah[]" class="form-control jumlah-input" min="1" value="1" required>
                </td>
                <td>
                    <input type="number" name="harga_beli[]" class="form-control harga-input" min="0" step="0.01" value="0" required>
                </td>
                <td>
                    <input type="number" name="subtotal[]" class="form-control subtotal-input" readonly value="0">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm hapus-baris">
                        <i class="glyphicon glyphicon-trash"></i>
                    </button>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right"><strong>Total:</strong></td>
                <td colspan="2">
                    <?= $form->field($model, 'total')->textInput([
                        'readonly' => true,
                        'class' => 'form-control',
                        'id' => 'total-pembelian'
                    ])->label(false) ?>
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="form-group">
        <?= Html::submitButton('Simpan Pembelian', ['class' => 'btn btn-success btn-lg']) ?>
        <?= Html::a('Batal', ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$obatList = ArrayHelper::map(Obat::find()->all(), 'id', 'nama_obat');
$obatListJson = json_encode($obatList);

$this->registerJs("
var obatList = $obatListJson;

// Hitung subtotal
$(document).on('input', '.jumlah-input, .harga-input', function() {
    var row = $(this).closest('tr');
    var jumlah = parseFloat(row.find('.jumlah-input').val()) || 0;
    var harga = parseFloat(row.find('.harga-input').val()) || 0;
    var subtotal = jumlah * harga;
    row.find('.subtotal-input').val(subtotal.toFixed(2));
    hitungTotal();
});

// Hitung total
function hitungTotal() {
    var total = 0;
    $('.subtotal-input').each(function() {
        total += parseFloat($(this).val()) || 0;
    });
    $('#total-pembelian').val(total.toFixed(2));
}

// Tambah baris
$('#tambah-baris').click(function() {
    var newRow = $('.item-row:first').clone();
    newRow.find('input, select').val('');
    newRow.find('.subtotal-input').val('0');
    $('#detail-pembelian tbody').append(newRow);
});

// Hapus baris
$(document).on('click', '.hapus-baris', function() {
    if ($('.item-row').length > 1) {
        $(this).closest('tr').remove();
        hitungTotal();
    } else {
        alert('Minimal harus ada 1 item pembelian!');
    }
});
");
?>