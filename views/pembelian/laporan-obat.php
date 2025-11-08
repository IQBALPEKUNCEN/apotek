<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Supplier;

/** @var yii\web\View $this */
/** @var array $data */
/** @var string $tanggalMulai */
/** @var string $tanggalSelesai */
/** @var int|null $supplierId */

$this->title = "Laporan Pembelian Obat";
$this->params['breadcrumbs'][] = $this->title;

// Ambil semua supplier untuk filter
$suppliers = ArrayHelper::map(Supplier::find()->all(), 'id', 'nama_supplier');
?>

<div class="pembelian-laporan-obat">

    <h2><?= Html::encode($this->title) ?></h2>

    <div class="mb-3">
        <?= Html::beginForm(['pembelian/laporan-obat'], 'get', ['class' => 'form-inline']) ?>
        <label class="mr-2">Tanggal Mulai:</label>
        <?= Html::input('date', 'tanggal_mulai', $tanggalMulai, ['class' => 'form-control mr-2']) ?>

        <label class="mr-2">Tanggal Selesai:</label>
        <?= Html::input('date', 'tanggal_selesai', $tanggalSelesai, ['class' => 'form-control mr-2']) ?>

        <label class="mr-2">Supplier:</label>
        <?= Html::dropDownList('supplier_id', $supplierId, $suppliers, ['prompt' => '-- Semua Supplier --', 'class' => 'form-control mr-2']) ?>

        <?= Html::submitButton('Filter', ['class' => 'btn btn-primary']) ?>
        <?= Html::endForm() ?>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Supplier</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data)): ?>
                <?php foreach ($data as $index => $item): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= Html::encode($item['nama_obat']) ?></td>
                        <td><?= Html::encode($item['supplier']) ?></td>
                        <td><?= $item['jumlah'] ?></td>
                        <td><?= Yii::$app->formatter->asCurrency($item['total']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Data tidak ditemukan</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>