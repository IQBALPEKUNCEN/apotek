<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\base\DynamicModel $model */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var float $totalTransaksi */
/** @var int $jumlahTransaksi */
/** @var float $rataRataTransaksi */
/** @var string $tanggalMulai */
/** @var string $tanggalSelesai */

$this->title = 'Laporan Transaksi Penjualan';
$this->params['breadcrumbs'][] = ['label' => 'Transaksi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="transaksi-laporan">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="glyphicon glyphicon-filter"></i> Filter Laporan</h5>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => ['laporan'],
            ]); ?>

            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'tanggal_awal')->input('date', [
                        'class' => 'form-control',
                        'value' => $tanggalMulai ?? date('Y-m-01')
                    ])->label('Tanggal Mulai') ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'tanggal_akhir')->input('date', [
                        'class' => 'form-control',
                        'value' => $tanggalSelesai ?? date('Y-m-d')
                    ])->label('Tanggal Selesai') ?>
                </div>
                <div class="col-md-4">
                    <label class="control-label">&nbsp;</label>
                    <div>
                        <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> Tampilkan', ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('<i class="glyphicon glyphicon-refresh"></i> Reset', ['laporan'], ['class' => 'btn btn-default']) ?>
                        <?= Html::a(
                            '<i class="glyphicon glyphicon-download-alt"></i> Export Excel',
                            ['export-excel', 'tanggal_mulai' => $tanggalMulai, 'tanggal_selesai' => $tanggalSelesai],
                            ['class' => 'btn btn-success']
                        ) ?>
                    </div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <?php if (isset($dataProvider) && $dataProvider->totalCount > 0): ?>

        <!-- Statistik Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">💰 Total Penjualan</h5>
                        <h3>Rp <?= number_format($totalTransaksi ?? 0, 0, ',', '.') ?></h3>
                        <small>Periode: <?= date('d/m/Y', strtotime($tanggalMulai)) ?> - <?= date('d/m/Y', strtotime($tanggalSelesai)) ?></small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">📊 Jumlah Transaksi</h5>
                        <h3><?= number_format($jumlahTransaksi ?? 0, 0, ',', '.') ?> Transaksi</h3>
                        <small>Total transaksi dalam periode ini</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">📈 Rata-rata Transaksi</h5>
                        <h3>Rp <?= number_format($rataRataTransaksi ?? 0, 0, ',', '.') ?></h3>
                        <small>Rata-rata per transaksi</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Transaksi -->
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0"><i class="glyphicon glyphicon-list"></i> Detail Transaksi</h5>
            </div>
            <div class="card-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'summary' => 'Menampilkan {begin}-{end} dari {totalCount} transaksi',
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        [
                            'attribute' => 'tanggal',
                            'format' => ['date', 'php:d-m-Y'],
                            'label' => 'Tanggal',
                        ],
                        [
                            'attribute' => 'nama_pelanggan',
                            'label' => 'Nama Pelanggan',
                        ],
                        [
                            'attribute' => 'total_harga',
                            'value' => function ($model) {
                                return 'Rp ' . number_format($model->total_harga, 0, ',', '.');
                            },
                            'label' => 'Total Harga',
                            'contentOptions' => ['class' => 'text-right'],
                        ],
                        [
                            'attribute' => 'bayar',
                            'value' => function ($model) {
                                return 'Rp ' . number_format($model->bayar, 0, ',', '.');
                            },
                            'label' => 'Bayar',
                            'contentOptions' => ['class' => 'text-right'],
                        ],
                        [
                            'attribute' => 'kembalian',
                            'value' => function ($model) {
                                return 'Rp ' . number_format($model->kembalian, 0, ',', '.');
                            },
                            'label' => 'Kembalian',
                            'contentOptions' => ['class' => 'text-right'],
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view}',
                            'buttons' => [
                                'view' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                        'title' => 'View',
                                        'class' => 'btn btn-sm btn-info',
                                    ]);
                                },
                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>

    <?php else: ?>
        <div class="alert alert-info">
            <i class="glyphicon glyphicon-info-sign"></i>
            <strong>Informasi:</strong> Tidak ada transaksi pada periode yang dipilih.
        </div>
    <?php endif; ?>

</div>

<style>
    .card {
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        border-radius: 8px 8px 0 0;
    }

    .text-right {
        text-align: right;
    }
</style>