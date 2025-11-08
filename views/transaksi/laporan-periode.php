<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\base\DynamicModel $model */
/** @var yii\data\ArrayDataProvider $dataProvider */
/** @var array $data */
/** @var string $periode */
/** @var string $tahun */
/** @var string $bulan */
/** @var string $tanggal */
/** @var float $totalKeseluruhan */
/** @var int $jumlahTransaksi */

$this->title = 'Laporan Transaksi Per Periode';
$this->params['breadcrumbs'][] = ['label' => 'Transaksi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Laporan', 'url' => ['laporan']];
$this->params['breadcrumbs'][] = $this->title;

// Buat array bulan Indonesia
$namaBulan = [
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maret',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Agustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember'
];

// Format judul periode
$judulPeriode = '';
switch ($periode) {
    case 'harian':
        $judulPeriode = 'Tanggal: ' . date('d-m-Y', strtotime($tanggal));
        break;
    case 'bulanan':
        $judulPeriode = 'Bulan: ' . $namaBulan[$bulan] . ' ' . $tahun;
        break;
    case 'tahunan':
        $judulPeriode = 'Tahun: ' . $tahun;
        break;
}
?>

<div class="transaksi-laporan-periode">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="glyphicon glyphicon-filter"></i> Filter Periode</h5>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => ['laporan-periode'],
            ]); ?>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'periode')->dropDownList([
                        'harian' => 'Harian',
                        'bulanan' => 'Bulanan',
                        'tahunan' => 'Tahunan',
                    ], [
                        'class' => 'form-control',
                        'id' => 'periode-select'
                    ]) ?>
                </div>

                <div class="col-md-3" id="filter-tahun">
                    <?= $form->field($model, 'tahun')->dropDownList(
                        array_combine(range(date('Y'), date('Y') - 5), range(date('Y'), date('Y') - 5)),
                        ['class' => 'form-control']
                    ) ?>
                </div>

                <div class="col-md-3" id="filter-bulan" style="display: <?= $periode == 'bulanan' ? 'block' : 'none' ?>;">
                    <?= $form->field($model, 'bulan')->dropDownList([
                        '01' => 'Januari',
                        '02' => 'Februari',
                        '03' => 'Maret',
                        '04' => 'April',
                        '05' => 'Mei',
                        '06' => 'Juni',
                        '07' => 'Juli',
                        '08' => 'Agustus',
                        '09' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember'
                    ], ['class' => 'form-control']) ?>
                </div>

                <div class="col-md-3" id="filter-tanggal" style="display: <?= $periode == 'harian' ? 'block' : 'none' ?>;">
                    <?= $form->field($model, 'tanggal')->input('date', [
                        'class' => 'form-control',
                        'value' => $tanggal
                    ]) ?>
                </div>

                <div class="col-md-3">
                    <label class="control-label">&nbsp;</label>
                    <div>
                        <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> Tampilkan', ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('<i class="glyphicon glyphicon-refresh"></i> Reset', ['laporan-periode'], ['class' => 'btn btn-default']) ?>
                    </div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <?php if (!empty($data)): ?>

        <!-- Info Periode -->
        <div class="alert alert-info">
            <strong><i class="glyphicon glyphicon-calendar"></i> Periode:</strong> <?= $judulPeriode ?>
        </div>

        <!-- Statistik Cards -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">💰 Total Penjualan</h5>
                        <h3>Rp <?= number_format($totalKeseluruhan ?? 0, 0, ',', '.') ?></h3>
                        <small><?= $judulPeriode ?></small>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">📊 Jumlah Transaksi</h5>
                        <h3><?= number_format($jumlahTransaksi ?? 0, 0, ',', '.') ?> Transaksi</h3>
                        <small>Total transaksi dalam periode ini</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Per Periode -->
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0"><i class="glyphicon glyphicon-list"></i> Detail Penjualan Per <?= ucfirst($periode == 'harian' ? 'Jam' : ($periode == 'bulanan' ? 'Hari' : 'Bulan')) ?></h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>
                                    <?php
                                    switch ($periode) {
                                        case 'harian':
                                            echo 'Jam';
                                            break;
                                        case 'bulanan':
                                            echo 'Tanggal';
                                            break;
                                        case 'tahunan':
                                            echo 'Bulan';
                                            break;
                                    }
                                    ?>
                                </th>
                                <th class="text-right">Jumlah Transaksi</th>
                                <th class="text-right">Total Penjualan</th>
                                <th class="text-right">Rata-rata</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($data as $row):
                                $rataRata = $row['jumlah'] > 0 ? $row['total'] / $row['jumlah'] : 0;
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <?php
                                        switch ($periode) {
                                            case 'harian':
                                                echo $row['periode'];
                                                break;
                                            case 'bulanan':
                                                echo date('d-m-Y', strtotime($row['periode']));
                                                break;
                                            case 'tahunan':
                                                $bulanAngka = date('m', strtotime($row['periode'] . '-01'));
                                                echo $namaBulan[$bulanAngka] . ' ' . date('Y', strtotime($row['periode'] . '-01'));
                                                break;
                                        }
                                        ?>
                                    </td>
                                    <td class="text-right"><?= number_format($row['jumlah'], 0, ',', '.') ?></td>
                                    <td class="text-right">Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
                                    <td class="text-right">Rp <?= number_format($rataRata, 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="font-weight-bold bg-light">
                                <td colspan="2" class="text-right"><strong>TOTAL</strong></td>
                                <td class="text-right"><strong><?= number_format($jumlahTransaksi, 0, ',', '.') ?></strong></td>
                                <td class="text-right"><strong>Rp <?= number_format($totalKeseluruhan, 0, ',', '.') ?></strong></td>
                                <td class="text-right">
                                    <strong>Rp <?= number_format($jumlahTransaksi > 0 ? $totalKeseluruhan / $jumlahTransaksi : 0, 0, ',', '.') ?></strong>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-3">
            <?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Kembali', ['laporan'], ['class' => 'btn btn-default']) ?>
            <?= Html::a('<i class="glyphicon glyphicon-print"></i> Print', ['laporan-periode', 'periode' => $periode, 'tahun' => $tahun, 'bulan' => $bulan, 'tanggal' => $tanggal, 'print' => 1], ['class' => 'btn btn-secondary', 'target' => '_blank']) ?>
        </div>

    <?php else: ?>
        <div class="alert alert-info">
            <i class="glyphicon glyphicon-info-sign"></i>
            <strong>Informasi:</strong> Tidak ada transaksi pada periode yang dipilih.
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
</style>

<?php
$this->registerJs("
    // Toggle filter berdasarkan periode yang dipilih
    $('#periode-select').change(function() {
        var periode = $(this).val();
        
        // Sembunyikan semua filter
        $('#filter-bulan').hide();
        $('#filter-tanggal').hide();
        
        // Tampilkan filter sesuai periode
        if (periode === 'harian') {
            $('#filter-tanggal').show();
        } else if (periode === 'bulanan') {
            $('#filter-bulan').show();
        }
    });
");
?>