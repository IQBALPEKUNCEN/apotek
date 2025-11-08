<?php

use yii\db\Migration;

class m241105_000000_init_rbac_apotek extends Migration
{
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // ============================================
        // PERMISSIONS
        // ============================================

        // Permission untuk User Management (hanya Admin)
        $manageUsers = $auth->createPermission('/user-management/user/*');
        $manageUsers->description = 'Kelola pengguna';
        $auth->add($manageUsers);

        $manageRoles = $auth->createPermission('/user-management/role/*');
        $manageRoles->description = 'Kelola roles';
        $auth->add($manageRoles);

        $managePermissions = $auth->createPermission('/user-management/permission/*');
        $managePermissions->description = 'Kelola permissions';
        $auth->add($managePermissions);

        // Permission untuk Obat
        $manageObat = $auth->createPermission('/obat/*');
        $manageObat->description = 'Kelola data obat';
        $auth->add($manageObat);

        $viewObat = $auth->createPermission('/obat/index');
        $viewObat->description = 'Lihat daftar obat';
        $auth->add($viewObat);

        $viewObatDetail = $auth->createPermission('/obat/view');
        $viewObatDetail->description = 'Lihat detail obat';
        $auth->add($viewObatDetail);

        // Permission untuk Supplier (hanya Admin)
        $manageSupplier = $auth->createPermission('/supplier/*');
        $manageSupplier->description = 'Kelola supplier';
        $auth->add($manageSupplier);

        // Permission untuk Pembelian (hanya Admin)
        $managePembelian = $auth->createPermission('/pembelian/*');
        $managePembelian->description = 'Kelola pembelian';
        $auth->add($managePembelian);

        // Permission untuk Penjualan (Admin & Kasir)
        $managePenjualan = $auth->createPermission('/penjualan/*');
        $managePenjualan->description = 'Kelola penjualan';
        $auth->add($managePenjualan);

        // Permission untuk Laporan (hanya Admin)
        $viewLaporan = $auth->createPermission('/laporan/*');
        $viewLaporan->description = 'Lihat laporan';
        $auth->add($viewLaporan);

        // Permission untuk Site
        $accessSite = $auth->createPermission('/site/*');
        $accessSite->description = 'Akses halaman utama';
        $auth->add($accessSite);

        // ============================================
        // ROLE ADMIN
        // ============================================

        $admin = $auth->createRole('Admin');
        $admin->description = 'Administrator dengan akses penuh';
        $auth->add($admin);

        // Admin dapat akses semua
        $auth->addChild($admin, $manageUsers);
        $auth->addChild($admin, $manageRoles);
        $auth->addChild($admin, $managePermissions);
        $auth->addChild($admin, $manageObat);
        $auth->addChild($admin, $manageSupplier);
        $auth->addChild($admin, $managePembelian);
        $auth->addChild($admin, $managePenjualan);
        $auth->addChild($admin, $viewLaporan);
        $auth->addChild($admin, $accessSite);

        // ============================================
        // ROLE KASIR
        // ============================================

        $kasir = $auth->createRole('Kasir');
        $kasir->description = 'Kasir untuk transaksi penjualan';
        $auth->add($kasir);

        // Kasir hanya dapat lihat obat dan kelola penjualan
        $auth->addChild($kasir, $viewObat);
        $auth->addChild($kasir, $viewObatDetail);
        $auth->addChild($kasir, $managePenjualan);
        $auth->addChild($kasir, $accessSite);

        // ============================================
        // COMMON PERMISSION (untuk semua orang termasuk guest)
        // ============================================

        $commonPermission = $auth->createPermission('commonPermission');
        $commonPermission->description = 'Common permission for all users';
        $auth->add($commonPermission);

        // Public routes yang bisa diakses guest
        $loginPermission = $auth->createPermission('/user-management/auth/login');
        $auth->add($loginPermission);
        $auth->addChild($commonPermission, $loginPermission);

        $logoutPermission = $auth->createPermission('/user-management/auth/logout');
        $auth->add($logoutPermission);
        $auth->addChild($commonPermission, $logoutPermission);

        $registrationPermission = $auth->createPermission('/user-management/auth/registration');
        $auth->add($registrationPermission);
        $auth->addChild($commonPermission, $registrationPermission);

        $siteIndexPermission = $auth->createPermission('/site/index');
        $auth->add($siteIndexPermission);
        $auth->addChild($commonPermission, $siteIndexPermission);

        $siteAboutPermission = $auth->createPermission('/site/about');
        $auth->add($siteAboutPermission);
        $auth->addChild($commonPermission, $siteAboutPermission);

        $siteContactPermission = $auth->createPermission('/site/contact');
        $auth->add($siteContactPermission);
        $auth->addChild($commonPermission, $siteContactPermission);

        $siteErrorPermission = $auth->createPermission('/site/error');
        $auth->add($siteErrorPermission);
        $auth->addChild($commonPermission, $siteErrorPermission);

        // ============================================
        // ASSIGN SUPERADMIN
        // ============================================

        // Assign role Admin ke superadmin (user_id = 1)
        $auth->assign($admin, 1);

        echo "✅ RBAC Apotek berhasil diinisialisasi!\n";
        echo "=========================================\n";
        echo "Login default: superadmin / superadmin\n";
        echo "Role: Admin (Full Access)\n\n";
        echo "Role yang tersedia:\n";
        echo "1. Admin - Akses penuh ke semua fitur\n";
        echo "2. Kasir - Akses transaksi penjualan dan lihat obat\n";
        echo "=========================================\n";
    }

    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        echo "RBAC removed!\n";
    }
}
