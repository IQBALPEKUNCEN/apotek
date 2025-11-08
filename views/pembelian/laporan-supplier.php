<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var array $data */
/** @var string $tanggalMulai */
/** @var string $tanggalSelesai */
/** @var string $supplierId */
/** @var float $totalPembelian */
/** @var int $jumlahPembelian */

$this->title = "Laporan Pembelian Per Supplier";
?>

<div class="card mt-4">
    <div class="card-header bg-primary text-white">
        <h4><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-body">

        <!-- FILTER FORM -->
        <form action="<?= Url::to(['pembelian/laporan-supplier']) ?>" method="GET" class="row g-2">

            <div class="col-md-3">
                <label>Dari Tanggal</label>
                <input type="date" name="tanggal_mulai" class="form-control"
                    value="<?= $tanggalMulai ?>" onchange="this.form.submit()">
            </div>

            <div class="col-md-3">
                <label>Sampai Tanggal</label>
                <input type="date" name="tanggal_selesai" class="form-control"
                    value="<?= $tanggalSelesai ?>" onchange="this.form.submit()">
            </div>

            <div class="col-md-3">
                <label>ID Supplier</label>
                <input type="text" name="supplier_id" class="form-control"
                    value="<?= $supplierId ?>" placeholder="ID Supplier" onchange="this.form.submit()">
            </div>

        </form>

        <hr>

        <!-- TABEL DATA -->
        <table class="table table-bordered table-striped mt-3">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Supplier</th>
                    <th>Jumlah Pembelian</th>
                    <th>Total Pembelian</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($data)): ?>
                    <?php $no = 1; ?>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['supplier'] ?></td>
                            <td><?= $row['jumlah'] ?></td>
                            <td><b>Rp <?= number_format($row['total'], 0, ',', '.') ?></b></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data</td>
                    </tr>
                <?php endif; ?>
            </tbody>

            <tfoot>
                <tr class="table-info">
                    <th colspan="2">TOTAL</th>
                    <th><?= $jumlahPembelian ?></th>
                    <th>Rp <?= number_format($totalPembelian, 0, ',', '.') ?></th>
                </tr>
            </tfoot>
        </table>

    </div>
</div>