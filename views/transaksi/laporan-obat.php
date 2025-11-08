<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\base\DynamicModel $model */
/** @var yii\data\ArrayDataProvider $dataProvider */
/** @var string $tanggalMulai */
/** @var string $tanggalSelesai */
/** @var float $totalPenjualan */

$this->title = 'Laporan Penjualan Per Obat';
$this->params['breadcrumbs'][] = ['label' => 'Transaksi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Laporan', 'url' => ['laporan']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="transaksi-laporan-obat">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="glyphicon glyphicon-filter"></i> Filter Laporan</h5>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => ['laporan-obat'],
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
                        <?= Html::a('<i class="glyphicon glyphicon-refresh"></i> Reset', ['laporan-obat'], ['class' => 'btn btn-default']) ?>
                    </div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <?php if ($dataProvider->totalCount > 0): ?>

        <!-- Info Periode -->
        <div class="alert alert-info">
            <strong><i class="glyphicon glyphicon-calendar"></i> Periode:</strong>
            <?= date('d-m-Y', strtotime($tanggalMulai)) ?> s/d <?= date('d-m-Y', strtotime($tanggalSelesai)) ?>
        </div>

        <!-- Statistik Card -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">💰 Total Penjualan Obat</h5>
                        <h2>Rp <?= number_format($totalPenjualan ?? 0, 0, ',', '.') ?></h2>
                        <small>Total penjualan semua obat dalam periode ini</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Per Obat -->
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0"><i class="glyphicon glyphicon-list"></i> Detail Penjualan Per Obat</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Obat</th>
                                <th>Kategori</th>
                                <th class="text-right">Harga Jual</th>
                                <th class="text-right">Jumlah Transaksi</th>
                                <th class="text-right">Total QTY Terjual</th>
                                <th class="text-right">Total Penjualan</th>
                                <th class="text-right">% Kontribusi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($dataProvider->models as $row):
                                $persenKontribusi = $totalPenjualan > 0 ? ($row['total_penjualan'] / $totalPenjualan) * 100 : 0;
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <strong><?= Html::encode($row['nama_obat']) ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge badge-info"><?= Html::encode($row['kategori']) ?></span>
                                    </td>
                                    <td class="text-right">
                                        Rp <?= number_format($row['harga_jual'], 0, ',', '.') ?>
                                    </td>
                                    <td class="text-right">
                                        <?= number_format($row['transaksi_terjual'], 0, ',', '.') ?>x
                                    </td>
                                    <td class="text-right">
                                        <strong><?= number_format($row['total_qty'], 0, ',', '.') ?></strong> pcs
                                    </td>
                                    <td class="text-right">
                                        <strong>Rp <?= number_format($row['total_penjualan'], 0, ',', '.') ?></strong>
                                    </td>
                                    <td class="text-right">
                                        <span class="badge badge-success"><?= number_format($persenKontribusi, 2) ?>%</span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="font-weight-bold bg-light">
                                <td colspan="6" class="text-right"><strong>TOTAL</strong></td>
                                <td class="text-right">
                                    <strong>Rp <?= number_format($totalPenjualan, 0, ',', '.') ?></strong>
                                </td>
                                <td class="text-right">
                                    <span class="badge badge-success">100%</span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Pagination -->
                <?= \yii\widgets\LinkPager::widget([
                    'pagination' => $dataProvider->pagination,
                ]) ?>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-3">
            <?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Kembali', ['laporan'], ['class' => 'btn btn-default']) ?>
            <?= Html::a('<i class="glyphicon glyphicon-print"></i> Print', ['laporan-obat', 'tanggal_awal' => $tanggalMulai, 'tanggal_akhir' => $tanggalSelesai, 'print' => 1], ['class' => 'btn btn-secondary', 'target' => '_blank']) ?>
        </div>

    <?php else: ?>
        <div class="alert alert-info">
            <i class="glyphicon glyphicon-info-sign"></i>
            <strong>Informasi:</strong> Tidak ada penjualan obat pada periode yang dipilih.
        </div>

        <?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Kembali', ['laporan'], ['class' => 'btn btn-default']) ?>
    <?php endif; ?>

</div>

<style>
    .card {
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .card-header {
        border-radius: 8px 8px 0 0;
    }

    .text-right {
        text-align: right;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .badge {
        padding: 5px 10px;
        border-radius: 3px;
        font-size: 12px;
    }

    .badge-info {
        background-color: #17a2b8;
        color: white;
    }

    .badge-success {
        background-color: #28a745;
        color: white;
    }
</style>