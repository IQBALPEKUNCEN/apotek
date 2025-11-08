<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Obat $model */

$this->title = 'Detail Obat: ' . $model->nama_obat;
$this->params['breadcrumbs'][] = ['label' => 'Data Obat', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->nama_obat;
\yii\web\YiiAsset::register($this);
?>
<div class="obat-view">

    <div class="page-header">
        <h1><?= Html::encode($model->nama_obat) ?></h1>
        <p class="text-muted">Kode: <?= Html::encode($model->kode_obat) ?></p>
    </div>

    <div class="btn-group" role="group">
        <?= Html::a('<i class="glyphicon glyphicon-pencil"></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="glyphicon glyphicon-trash"></i> Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Apakah Anda yakin ingin menghapus obat "' . $model->nama_obat . '"?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Kembali', ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-8">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-striped table-bordered detail-view'],
                'attributes' => [
                    [
                        'attribute' => 'kode_obat',
                        'label' => 'Kode Obat',
                    ],
                    [
                        'attribute' => 'nama_obat',
                        'label' => 'Nama Obat',
                    ],
                    [
                        'attribute' => 'kategori',
                        'label' => 'Kategori',
                    ],
                    [
                        'attribute' => 'stok',
                        'label' => 'Stok',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $stok = $model->stok;
                            if ($stok == 0) {
                                return '<span class="label label-danger">HABIS (0)</span>';
                            } elseif ($stok < 10) {
                                return '<span class="label label-warning">' . $stok . ' (Stok Rendah)</span>';
                            } else {
                                return '<span class="label label-success">' . $stok . '</span>';
                            }
                        }
                    ],
                    [
                        'attribute' => 'harga_beli',
                        'label' => 'Harga Beli',
                        'format' => 'raw',
                        'value' => 'Rp ' . number_format($model->harga_beli, 0, ',', '.'),
                    ],
                    [
                        'attribute' => 'harga_jual',
                        'label' => 'Harga Jual',
                        'format' => 'raw',
                        'value' => 'Rp ' . number_format($model->harga_jual, 0, ',', '.'),
                    ],
                    [
                        'attribute' => 'expired_date',
                        'label' => 'Tanggal Kadaluarsa',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if (empty($model->expired_date)) {
                                return '-';
                            }

                            $expiredDate = new DateTime($model->expired_date);
                            $now = new DateTime();
                            $diff = $now->diff($expiredDate);

                            $formatted = Yii::$app->formatter->asDate($model->expired_date, 'php:d F Y');

                            if ($expiredDate < $now) {
                                return '<span class="text-danger"><strong>' . $formatted . '</strong><br><small>⚠ Sudah kadaluarsa</small></span>';
                            } elseif ($diff->days <= 30) {
                                return '<span class="text-warning"><strong>' . $formatted . '</strong><br><small>⚠ Kadaluarsa dalam ' . $diff->days . ' hari</small></span>';
                            } elseif ($diff->days <= 90) {
                                return '<span class="text-info"><strong>' . $formatted . '</strong><br><small>ℹ Kadaluarsa dalam ' . $diff->days . ' hari</small></span>';
                            } else {
                                return '<span class="text-success"><strong>' . $formatted . '</strong></span>';
                            }
                        }
                    ],
                ],
            ]) ?>
        </div>

        <div class="col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="glyphicon glyphicon-stats"></i> Informasi Profit</h3>
                </div>
                <div class="panel-body">
                    <?php
                    $profit = $model->harga_jual - $model->harga_beli;
                    $profitPercentage = $model->harga_beli > 0 ? ($profit / $model->harga_beli) * 100 : 0;
                    ?>
                    <dl>
                        <dt>Margin per Unit:</dt>
                        <dd class="text-success"><strong>Rp <?= number_format($profit, 0, ',', '.') ?></strong></dd>

                        <dt>Persentase Profit:</dt>
                        <dd class="text-success"><strong><?= number_format($profitPercentage, 2) ?>%</strong></dd>

                        <dt>Total Nilai Stok (Beli):</dt>
                        <dd>Rp <?= number_format($model->stok * $model->harga_beli, 0, ',', '.') ?></dd>

                        <dt>Potensi Pendapatan:</dt>
                        <dd class="text-primary"><strong>Rp <?= number_format($model->stok * $model->harga_jual, 0, ',', '.') ?></strong></dd>

                        <dt>Potensi Profit Total:</dt>
                        <dd class="text-success"><strong>Rp <?= number_format($model->stok * $profit, 0, ',', '.') ?></strong></dd>
                    </dl>
                </div>
            </div>

            <?php if ($model->stok < 10 || (new DateTime($model->expired_date) < (new DateTime())->modify('+30 days'))): ?>
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="glyphicon glyphicon-alert"></i> Peringatan</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled">
                            <?php if ($model->stok == 0): ?>
                                <li class="text-danger"><i class="glyphicon glyphicon-remove-circle"></i> <strong>Stok habis!</strong> Segera lakukan pemesanan ulang.</li>
                            <?php elseif ($model->stok < 10): ?>
                                <li class="text-warning"><i class="glyphicon glyphicon-exclamation-sign"></i> Stok menipis. Pertimbangkan untuk restock.</li>
                            <?php endif; ?>

                            <?php
                            $expiredDate = new DateTime($model->expired_date);
                            $now = new DateTime();
                            if ($expiredDate < $now): ?>
                                <li class="text-danger"><i class="glyphicon glyphicon-remove-circle"></i> <strong>Obat sudah kadaluarsa!</strong></li>
                            <?php elseif ($expiredDate < $now->modify('+30 days')): ?>
                                <li class="text-warning"><i class="glyphicon glyphicon-exclamation-sign"></i> Akan kadaluarsa dalam waktu dekat.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>