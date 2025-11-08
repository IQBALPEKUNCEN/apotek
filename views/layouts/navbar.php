<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\NavBar;
use yii\bootstrap5\Nav;

NavBar::begin([
    'brandLabel' => '🏥 Sistem Apotek',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => ['class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top'],
]);

$menuItems = [
    ['label' => 'Home', 'url' => ['/site/index']],
];

// ✅ Master Data (hanya admin)
if (!Yii::$app->user->isGuest && Yii::$app->user->can('admin')) {
    $menuItems[] = [
        'label' => 'Master Data',
        'items' => [
            ['label' => '💊 Data Obat', 'url' => ['/obat/index']],
            ['label' => '🚚 Data Supplier', 'url' => ['/supplier/index']],
        ]
    ];
}

// ✅ Transaksi (admin & kasir)
if (!Yii::$app->user->isGuest && (Yii::$app->user->can('admin') || Yii::$app->user->can('kasir'))) {
    $menuItems[] = [
        'label' => 'Transaksi',
        'items' => [
            ['label' => '📦 Pembelian', 'url' => ['/pembelian/index']],
            ['label' => '🛒 Penjualan', 'url' => ['/transaksi/index']],
        ]
    ];
}

// ✅ Laporan (admin & kasir)
if (!Yii::$app->user->isGuest && (Yii::$app->user->can('admin') || Yii::$app->user->can('kasir'))) {
    $menuItems[] = [
        'label' => 'Laporan',
        'items' => [
            // Laporan Penjualan/Transaksi
            '<div class="dropdown-header">📊 Laporan Penjualan</div>',
            ['label' => '📋 Laporan Transaksi', 'url' => ['/transaksi/laporan']],
            ['label' => '📅 Laporan Periode', 'url' => ['/transaksi/laporan-periode']],
            ['label' => '💊 Laporan per Obat', 'url' => ['/transaksi/laporan-obat']],
            '<div class="dropdown-divider"></div>',
            
            // Laporan Pembelian
            '<div class="dropdown-header">📈 Laporan Pembelian</div>',
            ['label' => '📋 Laporan Pembelian', 'url' => ['/pembelian/laporan']],
            ['label' => '📅 Laporan Periode', 'url' => ['/pembelian/laporan-periode']],
            ['label' => '🚚 Laporan per Supplier', 'url' => ['/pembelian/laporan-supplier']],
            ['label' => '💊 Laporan per Obat', 'url' => ['/pembelian/laporan-obat']],
            '<div class="dropdown-divider"></div>',
            
            // Statistik & Export
            '<div class="dropdown-header">📊 Statistik & Export</div>',
            ['label' => '📊 Statistik Pembelian', 'url' => ['/pembelian/statistik']],
            ['label' => '📉 Laporan Stok', 'url' => ['/obat/laporan-stok']],
        ]
    ];
}

// ✅ User Management (hanya admin)
if (!Yii::$app->user->isGuest && Yii::$app->user->can('admin')) {
    $menuItems[] = [
        'label' => '⚙️ Admin',
        'items' => [
            ['label' => '👥 Kelola User', 'url' => ['/user-management/user/index']],
            ['label' => '🔐 Kelola Role', 'url' => ['/user-management/role/index']],
            ['label' => '🔑 Kelola Permission', 'url' => ['/user-management/permission/index']],
        ]
    ];
}

// ✅ Login/Logout
if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => '🔐 Login', 'url' => ['/user-management/auth/login']];
} else {
    $menuItems[] = [
        'label' => '👤 ' . Yii::$app->user->identity->username,
        'items' => [
            ['label' => '👤 Profile', 'url' => ['/user-management/user/view', 'id' => Yii::$app->user->id]],
            '<div class="dropdown-divider"></div>',
            [
                'label' => '🚪 Logout',
                'url' => ['/user-management/auth/logout'],
                'linkOptions' => ['data-method' => 'post'],
            ],
        ]
    ];
}

// ✅ Render menu
echo Nav::widget([
    'options' => ['class' => 'navbar-nav ms-auto'],
    'encodeLabels' => false,
    'items' => $menuItems,
]);

NavBar::end();