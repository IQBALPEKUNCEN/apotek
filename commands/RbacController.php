<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    /**
     * Command untuk membuat role & permission
     * Jalankan: php yii rbac/init
     */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // Hapus data lama RBAC (opsional)
        $auth->removeAll();

        // ==== PERMISSIONS ====

        $manageApotek = $auth->createPermission('manageApotek');
        $manageApotek->description = "Mengelola seluruh sistem apotek";
        $auth->add($manageApotek);

        $kasirTransaksi = $auth->createPermission('kasirTransaksi');
        $kasirTransaksi->description = "Melakukan transaksi kasir";
        $auth->add($kasirTransaksi);

        // ==== ROLES ====

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $manageApotek); // Admin dapat semuanya
        $auth->addChild($admin, $kasirTransaksi);

        $kasir = $auth->createRole('kasir');
        $auth->add($kasir);
        $auth->addChild($kasir, $kasirTransaksi);

        echo "\n✅ RBAC berhasil dibuat (Role & Permission selesai)\n";
    }


    /**
     * Assign role ke user tertentu
     * Jalankan: php yii rbac/assign admin 1
     */
    public function actionAssign($roleName, $userId)
    {
        $auth = Yii::$app->authManager;

        $role = $auth->getRole($roleName);
        if (!$role) {
            echo "❌ Role tidak ditemukan!\n";
            return;
        }

        $auth->assign($role, $userId);
        echo "✅ Role '{$roleName}' berhasil diberikan ke user ID: {$userId}\n";
    }
}
