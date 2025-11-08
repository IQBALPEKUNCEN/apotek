<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var array $data */
/** @var string $periode */
/** @var string $tahun */
/** @var string $bulan */
/** @var string $tanggal */
/** @var float $totalKeseluruhan */
/** @var int $jumlahPembelian */

$this->title = "Laporan Pembelian Periode";
?>

<div class="card mt-4">
    <div class="card-header bg-primary text-white">
        <h4>Laporan Pembelian Per Periode</h4>
    </div>

    <div class="card-body">

        <!-- FILTER FORM -->
        <form action="<?= Url::to(['pembelian/laporan-periode']) ?>" method="GET" class="row g-2">

            <div class="col-md-3">
                <label>Periode</label>
                <select name="periode" class="form-control" onchange="this.form.submit()">
                    <option value="harian" <?= $periode == 'harian' ? 'selected' : '' ?>>Harian</option>
                    <option value="bulanan" <?= $periode == 'bulanan' ? 'selected' : '' ?>>Bulanan</option>
                    <option value="tahunan" <?= $periode == 'tahunan' ? 'selected' : '' ?>>Tahunan</option>
                </select>
            </div>

            <?php if ($periode == 'harian'): ?>
                <div class="col-md-3">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="<?= $tanggal ?>" onchange="this.form.submit()">
                </div>
            <?php endif; ?>

            <?php if ($periode == 'bulanan'): ?>
                <div class="col-md-3">
                    <label>Bulan</label>
                    <input type="month" name="bulan" class="form-control"
                        value="<?= $tahun . '-' . $bulan ?>" onchange="this.form.submit()">
                </div>
            <?php endif; ?>

            <?php if ($periode == 'tahunan'): ?>
                <div class="col-md-3">
                    <label>Tahun</label>
                    <input type="number" name="tahun" class="form-control"
                        value="<?= $tahun ?>" onchange="this.form.submit()">
                </div>
            <?php endif; ?>

        </form>

        <hr>

        <!-- TABEL DATA -->
        <table class="table table-bordered table-striped mt-3">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Periode</th>
                    <th>Jumlah Pembelian</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data)): ?>
                    <?php $no = 1; ?>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['periode'] ?></td>
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
                    <th>Rp <?= number_format($totalKeseluruhan, 0, ',', '.') ?></th>
                </tr>
            </tfoot>

        </table>

    </div>
</div>