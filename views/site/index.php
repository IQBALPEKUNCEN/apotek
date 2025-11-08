<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Dashboard Apotek';
?>
<div class="site-index">

    <!-- Hero Section -->
    <div class="jumbotron text-center bg-gradient text-white p-5 rounded-3 mb-4 shadow-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <h1 class="display-4">🏥 Sistem Informasi Apotek</h1>
        <p class="lead">Kelola apotek Anda dengan mudah dan efisien</p>

        <?php if (Yii::$app->user->isGuest): ?>
            <p class="mt-4">
                <?= Html::a('Login untuk Memulai', ['/user-management/auth/login'], ['class' => 'btn btn-lg btn-light shadow']) ?>
            </p>
        <?php else: ?>
            <p class="mt-3 mb-0">
                <strong>Selamat Datang, <?= Html::encode(Yii::$app->user->identity->username) ?>!</strong>
            </p>
            <small class="text-white-50">
                Role: <?= implode(', ', array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id))) ?>
            </small>
        <?php endif; ?>
    </div>

    <div class="body-content">

        <?php if (!Yii::$app->user->isGuest): ?>

            <!-- Dashboard Cards untuk User yang sudah Login -->
            <div class="row mb-4">
                <!-- Card Total Obat -->
                <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('kasir')): ?>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card text-white bg-primary shadow">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title mb-0">Total Obat</h6>
                                        <h2 class="mb-0">
                                            <?php
                                            $totalObat = \app\models\Obat::find()->count();
                                            echo $totalObat;
                                            ?>
                                        </h2>
                                    </div>
                                    <div style="font-size: 48px; opacity: 0.3;">💊</div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <?= Html::a('Lihat Detail →', ['/obat/index'], ['class' => 'text-white text-decoration-none']) ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Card Penjualan Hari Ini -->
                <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('kasir')): ?>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card text-white bg-success shadow">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title mb-0">Transaksi Hari Ini</h6>
                                        <h2 class="mb-0">
                                            <?php
                                            $transaksiHariIni = \app\models\Transaksi::find()
                                                ->where(['DATE(tanggal)' => date('Y-m-d')])
                                                ->count();
                                            echo $transaksiHariIni;
                                            ?>
                                        </h2>
                                    </div>
                                    <div style="font-size: 48px; opacity: 0.3;">🛒</div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <?= Html::a('Lihat Detail →', ['/transaksi/index'], ['class' => 'text-white text-decoration-none']) ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Card Stok Menipis -->
                <?php if (Yii::$app->user->can('admin')): ?>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card text-white bg-warning shadow">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title mb-0">Stok Menipis</h6>
                                        <h2 class="mb-0">
                                            <?php
                                            $stokMenipis = \app\models\Obat::find()
                                                ->where(['<', 'stok', 10])
                                                ->count();
                                            echo $stokMenipis;
                                            ?>
                                        </h2>
                                    </div>
                                    <div style="font-size: 48px; opacity: 0.3;">⚠️</div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <?= Html::a('Lihat Detail →', ['/obat/index', 'stok_menipis' => 1], ['class' => 'text-white text-decoration-none']) ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Card Akan Expired -->
                <?php if (Yii::$app->user->can('admin')): ?>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card text-white bg-danger shadow">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title mb-0">Akan Expired</h6>
                                        <h2 class="mb-0">
                                            <?php
                                            $akanExpired = \app\models\Obat::find()
                                                ->where(['<=', 'expired_date', date('Y-m-d', strtotime('+30 days'))])
                                                ->andWhere(['>=', 'expired_date', date('Y-m-d')])
                                                ->count();
                                            echo $akanExpired;
                                            ?>
                                        </h2>
                                    </div>
                                    <div style="font-size: 48px; opacity: 0.3;">📅</div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <?= Html::a('Lihat Detail →', ['/obat/index', 'akan_expired' => 1], ['class' => 'text-white text-decoration-none']) ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        <?php endif; ?>

        <!-- Menu Utama - Tampil untuk semua user (guest & login) -->
        <div class="row">
            <div class="col-lg-4 mb-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <div style="font-size: 64px; margin-bottom: 20px;">💊</div>
                        <h2>Data Obat</h2>
                        <p>Kelola data obat, stok, harga, dan informasi obat lainnya. Monitor obat yang akan expired dan stok yang menipis.</p>
                        <?php if (!Yii::$app->user->isGuest && (Yii::$app->user->can('admin') || Yii::$app->user->can('kasir'))): ?>
                            <?= Html::a('Kelola Obat →', ['/obat/index'], ['class' => 'btn btn-primary']) ?>
                        <?php else: ?>
                            <?= Html::a('Login untuk Akses →', ['/user-management/auth/login'], ['class' => 'btn btn-outline-primary']) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <div style="font-size: 64px; margin-bottom: 20px;">🛒</div>
                        <h2>Transaksi Penjualan</h2>
                        <p>Catat transaksi penjualan obat kepada pelanggan. Cetak struk dan monitor riwayat penjualan dengan mudah.</p>
                        <?php if (!Yii::$app->user->isGuest && (Yii::$app->user->can('admin') || Yii::$app->user->can('kasir'))): ?>
                            <?= Html::a('Transaksi Penjualan →', ['/transaksi/index'], ['class' => 'btn btn-success']) ?>
                        <?php else: ?>
                            <?= Html::a('Login untuk Akses →', ['/user-management/auth/login'], ['class' => 'btn btn-outline-success']) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <div style="font-size: 64px; margin-bottom: 20px;">📦</div>
                        <h2>Pembelian Obat</h2>
                        <p>Kelola pembelian obat dari supplier, update stok secara otomatis, dan monitor riwayat pembelian obat.</p>
                        <?php if (!Yii::$app->user->isGuest && (Yii::$app->user->can('admin') || Yii::$app->user->can('kasir'))): ?>
                            <?= Html::a('Kelola Pembelian →', ['/pembelian/index'], ['class' => 'btn btn-info']) ?>
                        <?php else: ?>
                            <?= Html::a('Login untuk Akses →', ['/user-management/auth/login'], ['class' => 'btn btn-outline-info']) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!Yii::$app->user->isGuest && (Yii::$app->user->can('admin') || Yii::$app->user->can('kasir'))): ?>
            <!-- Informasi Tambahan untuk User yang Login -->
            <div class="row mt-4">
                <div class="col-lg-6 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">📊 Obat dengan Stok Menipis</h5>
                        </div>
                        <div class="card-body">
                            <?php
                            $obatMenipis = \app\models\Obat::find()
                                ->where(['<', 'stok', 10])
                                ->orderBy(['stok' => SORT_ASC])
                                ->limit(5)
                                ->all();

                            if ($obatMenipis): ?>
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($obatMenipis as $obat): ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <?= Html::encode($obat->nama_obat) ?>
                                            <span class="badge bg-warning text-dark">Stok: <?= $obat->stok ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                <div class="mt-3 text-center">
                                    <?= Html::a('Lihat Semua', ['/obat/index', 'stok_menipis' => 1], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                                </div>
                            <?php else: ?>
                                <p class="text-muted mb-0">✅ Semua stok obat dalam kondisi aman</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0">⏰ Obat Mendekati Expired</h5>
                        </div>
                        <div class="card-body">
                            <?php
                            $obatExpired = \app\models\Obat::find()
                                ->where(['<=', 'expired_date', date('Y-m-d', strtotime('+30 days'))])
                                ->andWhere(['>=', 'expired_date', date('Y-m-d')])
                                ->orderBy(['expired_date' => SORT_ASC])
                                ->limit(5)
                                ->all();

                            if ($obatExpired): ?>
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($obatExpired as $obat): ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <?= Html::encode($obat->nama_obat) ?>
                                            <span class="badge bg-danger">
                                                <?= Yii::$app->formatter->asDate($obat->expired_date, 'php:d M Y') ?>
                                            </span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                <div class="mt-3 text-center">
                                    <?= Html::a('Lihat Semua', ['/obat/index', 'akan_expired' => 1], ['class' => 'btn btn-sm btn-outline-danger']) ?>
                                </div>
                            <?php else: ?>
                                <p class="text-muted mb-0">✅ Tidak ada obat yang akan expired dalam 30 hari</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<style>
    .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .jumbotron {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .bg-gradient {
        animation: gradientShift 10s ease infinite;
        background-size: 200% 200%;
    }

    @keyframes gradientShift {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    .shadow-sm {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .shadow-lg {
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
    }

    .list-group-item {
        border-left: none;
        border-right: none;
    }

    .list-group-item:first-child {
        border-top: none;
    }
</style>