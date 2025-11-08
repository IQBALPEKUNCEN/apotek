<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var string $tanggalMulai */
/** @var string $tanggalSelesai */
/** @var string $supplierId */
/** @var float $totalPembelian */
/** @var integer $jumlahPembelian */
/** @var float $rataRataPembelian */

$this->title = "Laporan Pembelian";
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="pembelian-laporan">

    <h2><?= Html::encode($this->title) ?></h2>
    <hr>

    <!-- Form Filter -->
    <div class="card p-3 mb-3 bg-light">
        <?php $form = ActiveForm::begin(['method' => 'GET']); ?>

        <div class="row">
            <div class="col-md-3">
                <label>Tanggal Mulai</label>
                <input type="date" class="form-control" name="tanggal_mulai" value="<?= $tanggalMulai ?>">
            </div>
            <div class="col-md-3">
                <label>Tanggal Selesai</label>
                <input type="date" class="form-control" name="tanggal_selesai" value="<?= $tanggalSelesai ?>">
            </div>
            <div class="col-md-3">
                <label>Supplier (Opsional)</label>
                <input type="text" class="form-control" name="supplier_id" value="<?= $supplierId ?>" placeholder="ID Supplier">
            </div>
            <div class="col-md-3">
                <label>&nbsp;</label><br>
                <button class="btn btn-primary" type="submit">Filter</button>
                <a href="<?= \yii\helpers\Url::to(['pembelian/laporan', 'export' => 'pdf']) ?>" class="btn btn-danger">Export PDF</a>
                <a href="<?= \yii\helpers\Url::to(['pembelian/export-excel']) ?>" class="btn btn-success">Export Excel</a>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <!-- Statistik -->
    <div class="alert alert-info">
        <strong>Total Pembelian:</strong> Rp <?= number_format($totalPembelian, 0, ',', '.') ?><br>
        <strong>Jumlah Transaksi:</strong> <?= $jumlahPembelian ?><br>
        <strong>Rata-rata Pembelian:</strong> Rp <?= number_format($rataRataPembelian, 0, ',', '.') ?>
    </div>

    <!-- Tabel Laporan -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => 'Menampilkan {begin} - {end} dari {totalCount} data',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'tanggal',
                'format' => ['date', 'php:d-m-Y'],
                'label' => 'Tanggal Pembelian'
            ],
            [
                'attribute' => 'supplier.nama_supplier',
                'label' => 'Supplier',
                'value' => function ($model) {
                    return $model->supplier ? $model->supplier->nama_supplier : '-';
                },
            ],
            [
                'attribute' => 'total',
                'label' => 'Total Pembelian',
                'format' => ['currency'],
                'contentOptions' => ['style' => 'text-align:right;']
            ],
        ],
    ]) ?>

</div>