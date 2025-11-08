-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 08, 2025 at 02:02 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apotek_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 1762326233),
('kasir', '2', 1762326243),
('Kasir', '3', 1762338293),
('Kasir', '4', 1762339462);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` smallint NOT NULL,
  `description` text COLLATE utf8mb3_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `group_code` varchar(64) COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`, `group_code`) VALUES
('/*', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('//*', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('//controller', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('//crud', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('//extension', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('//form', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('//index', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('//model', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('//module', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/asset/*', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/asset/compress', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/asset/template', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/cache/*', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/cache/flush', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/cache/flush-all', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/cache/flush-schema', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/cache/index', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/fixture/*', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/fixture/load', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/fixture/unload', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/gii/*', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/gii/default/*', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/gii/default/action', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/gii/default/diff', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/gii/default/index', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/gii/default/preview', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/gii/default/view', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/hello/*', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/hello/index', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/help/*', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/help/index', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/help/list', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/help/list-action-options', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/help/usage', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/message/*', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/message/config', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/message/config-template', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/message/extract', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/migrate/*', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/migrate/create', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/migrate/down', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/migrate/fresh', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/migrate/history', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/migrate/mark', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/migrate/new', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/migrate/redo', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/migrate/to', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/migrate/up', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/rbac/*', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/rbac/assign', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/rbac/init', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/serve/*', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/serve/index', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/*', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/auth-item-group/*', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/auth-item-group/bulk-activate', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/auth-item-group/bulk-deactivate', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/auth-item-group/bulk-delete', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/auth-item-group/create', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/auth-item-group/delete', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/auth-item-group/grid-page-size', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/auth-item-group/grid-sort', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/auth-item-group/index', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/auth-item-group/toggle-attribute', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/auth-item-group/update', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/auth-item-group/view', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/auth/*', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/auth/captcha', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/auth/change-own-password', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/auth/confirm-email', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/auth/confirm-email-receive', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/auth/confirm-registration-email', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/auth/login', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/auth/logout', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/auth/password-recovery', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/auth/password-recovery-receive', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/auth/registration', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/permission/*', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/permission/bulk-activate', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/permission/bulk-deactivate', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/permission/bulk-delete', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/permission/create', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/permission/delete', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/permission/grid-page-size', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/permission/grid-sort', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/permission/index', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/permission/refresh-routes', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/permission/set-child-permissions', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/permission/set-child-routes', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/permission/toggle-attribute', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/permission/update', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/permission/view', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/role/*', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/role/bulk-activate', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/role/bulk-deactivate', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/role/bulk-delete', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/role/create', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/role/delete', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/role/grid-page-size', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/role/grid-sort', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/role/index', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/role/set-child-permissions', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/role/set-child-roles', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/role/toggle-attribute', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/role/update', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/role/view', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/user-permission/*', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/user-permission/set', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/user-permission/set-roles', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/user-visit-log/*', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/user-visit-log/bulk-activate', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/user-visit-log/bulk-deactivate', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/user-visit-log/bulk-delete', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/user-visit-log/create', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/user-visit-log/delete', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/user-visit-log/grid-page-size', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/user-visit-log/grid-sort', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/user-visit-log/index', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/user-visit-log/toggle-attribute', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/user-visit-log/update', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/user-visit-log/view', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/user/*', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/user/bulk-activate', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/user/bulk-deactivate', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/user/bulk-delete', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/user/change-password', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/user/create', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/user/delete', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/user/grid-page-size', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/user/grid-sort', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/user/index', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/user/toggle-attribute', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/user/update', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('/user-management/user/view', 3, NULL, NULL, NULL, 1762333220, 1762333220, NULL),
('admin', 1, NULL, NULL, NULL, 1762326217, 1762326217, NULL),
('assignRolesToUsers', 2, 'Assign roles to users', NULL, NULL, 1762333220, 1762333220, 'userManagement'),
('bindUserToIp', 2, 'Bind user to IP', NULL, NULL, 1762333220, 1762333220, 'userManagement'),
('changeOwnPassword', 2, 'Change own password', NULL, NULL, 1762333220, 1762333220, 'userCommonPermissions'),
('changeUserPassword', 2, 'Change user password', NULL, NULL, 1762333220, 1762333220, 'userManagement'),
('commonPermission', 2, 'Common permission', NULL, NULL, 1762333218, 1762333218, NULL),
('createUsers', 2, 'Create users', NULL, NULL, 1762333220, 1762333220, 'userManagement'),
('deleteUsers', 2, 'Delete users', NULL, NULL, 1762333220, 1762333220, 'userManagement'),
('editUserEmail', 2, 'Edit user email', NULL, NULL, 1762333220, 1762333220, 'userManagement'),
('editUsers', 2, 'Edit users', NULL, NULL, 1762333220, 1762333220, 'userManagement'),
('kasir', 1, NULL, NULL, NULL, 1762326217, 1762326217, NULL),
('kasirTransaksi', 2, 'Melakukan transaksi kasir', NULL, NULL, 1762326217, 1762326217, NULL),
('manageApotek', 2, 'Mengelola seluruh sistem apotek', NULL, NULL, 1762326217, 1762326217, NULL),
('viewRegistrationIp', 2, 'View registration IP', NULL, NULL, 1762333220, 1762333220, 'userManagement'),
('viewUserEmail', 2, 'View user email', NULL, NULL, 1762333220, 1762333220, 'userManagement'),
('viewUserRoles', 2, 'View user roles', NULL, NULL, 1762333220, 1762333220, 'userManagement'),
('viewUsers', 2, 'View users', NULL, NULL, 1762333220, 1762333220, 'userManagement'),
('viewVisitLog', 2, 'View visit log', NULL, NULL, 1762333220, 1762333220, 'userManagement');

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('changeOwnPassword', '/user-management/auth/change-own-password'),
('assignRolesToUsers', '/user-management/user-permission/set'),
('assignRolesToUsers', '/user-management/user-permission/set-roles'),
('viewVisitLog', '/user-management/user-visit-log/grid-page-size'),
('viewVisitLog', '/user-management/user-visit-log/index'),
('viewVisitLog', '/user-management/user-visit-log/view'),
('editUsers', '/user-management/user/bulk-activate'),
('editUsers', '/user-management/user/bulk-deactivate'),
('deleteUsers', '/user-management/user/bulk-delete'),
('changeUserPassword', '/user-management/user/change-password'),
('createUsers', '/user-management/user/create'),
('deleteUsers', '/user-management/user/delete'),
('viewUsers', '/user-management/user/grid-page-size'),
('viewUsers', '/user-management/user/index'),
('editUsers', '/user-management/user/update'),
('viewUsers', '/user-management/user/view'),
('admin', 'assignRolesToUsers'),
('admin', 'changeOwnPassword'),
('admin', 'changeUserPassword'),
('admin', 'createUsers'),
('admin', 'deleteUsers'),
('admin', 'editUsers'),
('admin', 'kasirTransaksi'),
('kasir', 'kasirTransaksi'),
('admin', 'manageApotek'),
('editUserEmail', 'viewUserEmail'),
('assignRolesToUsers', 'viewUserRoles'),
('admin', 'viewUsers'),
('assignRolesToUsers', 'viewUsers'),
('changeUserPassword', 'viewUsers'),
('createUsers', 'viewUsers'),
('deleteUsers', 'viewUsers'),
('editUsers', 'viewUsers');

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_group`
--

CREATE TABLE `auth_item_group` (
  `code` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `auth_item_group`
--

INSERT INTO `auth_item_group` (`code`, `name`, `created_at`, `updated_at`) VALUES
('userCommonPermissions', 'User common permission', 1762333220, 1762333220),
('userManagement', 'User management', 1762333220, 1762333220);

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1762323403),
('m140506_102106_rbac_init', 1762326143),
('m140608_173539_create_user_table', 1762332739),
('m140611_133903_init_rbac', 1762332739),
('m140808_073114_create_auth_item_group_table', 1762333217),
('m140809_072112_insert_superadmin_to_user', 1762333218),
('m140809_073114_insert_common_permisison_to_auth_item', 1762333218),
('m141023_141535_create_user_visit_log', 1762333218),
('m141116_115804_add_bind_to_ip_and_registration_ip_to_user', 1762333218),
('m141121_194858_split_browser_and_os_column', 1762333218),
('m141201_220516_add_email_and_email_confirmed_to_user', 1762333219),
('m141207_001649_create_basic_user_permissions', 1762333220),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1762326143),
('m180523_151638_rbac_updates_indexes_without_prefix', 1762326143),
('m200409_110543_rbac_update_mssql_trigger', 1762326143);

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id` int NOT NULL,
  `kode_obat` varchar(50) DEFAULT NULL,
  `nama_obat` varchar(200) DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `stok` int DEFAULT '0',
  `harga_beli` decimal(12,2) DEFAULT NULL,
  `harga_jual` decimal(12,2) DEFAULT NULL,
  `expired_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id`, `kode_obat`, `nama_obat`, `kategori`, `stok`, `harga_beli`, `harga_jual`, `expired_date`) VALUES
(1, 'narkoboy', 'kokain', 'narkoba', 999, '12000.00', '5000000.00', '2025-11-14'),
(3, '0BIUTU', 'sabu sabu', 'Lainnya', 1000000, '12000.00', '5000000.00', '2025-11-29');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id` int NOT NULL,
  `supplier_id` int DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `total` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id`, `supplier_id`, `tanggal`, `total`) VALUES
(1, NULL, NULL, '18999999.00'),
(2, 1, '2025-11-07', '270000000.00');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int NOT NULL,
  `nama_supplier` varchar(200) DEFAULT NULL,
  `alamat` text,
  `no_hp` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `nama_supplier`, `alamat`, `no_hp`) VALUES
(1, 'lukman', 'pekuncen', '1234567890'),
(2, 'celeng', 'bumiayu rt 09/02', '12345678900987654');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `kode_transaksi` varchar(50) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `total` decimal(12,2) DEFAULT NULL,
  `kasir_id` int DEFAULT NULL,
  `total_harga` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detil`
--

CREATE TABLE `transaksi_detil` (
  `id` int NOT NULL,
  `transaksi_id` int DEFAULT NULL,
  `obat_id` int DEFAULT NULL,
  `harga_jual` decimal(12,2) DEFAULT NULL,
  `qty` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `confirmation_token` varchar(255) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `superadmin` smallint DEFAULT '0',
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `registration_ip` varchar(15) DEFAULT NULL,
  `bind_to_ip` varchar(255) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `email_confirmed` smallint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `confirmation_token`, `status`, `superadmin`, `created_at`, `updated_at`, `registration_ip`, `bind_to_ip`, `email`, `email_confirmed`) VALUES
(1, 'superadmin', 'WP-pkuKtsJj6cWOptCMlj8gB-JrhsrlE', '$2y$13$UBiIWzfwhvLtkjFHy.WTHOGDca/pSFSRpGjfKParOBmyskz6mRArG', NULL, 1, 1, 1762333218, 1762333218, NULL, NULL, NULL, 0),
(2, 'kasirapotek', 'SzXogDEcx6ZIIoNSWG7TYleh5AE8LJay', '$2y$13$cIIKYTh3AT3BcD1zZgYDiOJPMvGa6/fwySGHHFp1jjw/Dfloh2XLu', NULL, 1, 0, 1762334810, 1762334810, '127.0.0.1', '', NULL, 0),
(3, 'Babi', 'ZWm3Y2bow8ZMbI0MS7MNjUpW7JSa7XlU', '$2y$13$ve8hk7zqigZYVccWXQG5ieFNE/b2d3sDskE0MiF85sG1Z81R/RD/G', NULL, 1, 0, 1762338293, 1762338293, '127.0.0.1', '', NULL, 0),
(4, 'Kasir2', 'ydkXQT4GbO2vvJ8Bi-SlRpXpVTQrAPZb', '$2y$13$fjd4.F3QmXgNZvkwm.tlrONbeXViceaXm76x4c.jIw7KZwTnyv7du', NULL, 1, 0, 1762339462, 1762339462, '127.0.0.1', '', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','kasir','owner') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_visit_log`
--

CREATE TABLE `user_visit_log` (
  `id` int NOT NULL,
  `token` varchar(255) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `language` char(2) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `user_id` int DEFAULT NULL,
  `visit_time` int NOT NULL,
  `browser` varchar(30) DEFAULT NULL,
  `os` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_visit_log`
--

INSERT INTO `user_visit_log` (`id`, `token`, `ip`, `language`, `user_agent`, `user_id`, `visit_time`, `browser`, `os`) VALUES
(1, '690b12ed1cb59', '127.0.0.1', 'en', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 1, 1762333421, 'Chrome', 'Windows'),
(2, '690b185a46653', '127.0.0.1', 'en', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 2, 1762334810, 'Chrome', 'Windows'),
(3, '690b187adce64', '127.0.0.1', 'en', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 1, 1762334842, 'Chrome', 'Windows'),
(4, '690b18dbc62a1', '127.0.0.1', 'en', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 2, 1762334939, 'Chrome', 'Windows'),
(5, '690b1de30a5ab', '127.0.0.1', 'en', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 1, 1762336227, 'Chrome', 'Windows'),
(6, '690b259fba615', '127.0.0.1', 'en', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 1, 1762338207, 'Chrome', 'Windows'),
(7, '690b25f539680', '127.0.0.1', 'en', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 3, 1762338293, 'Chrome', 'Windows'),
(8, '690b268c0ebc2', '127.0.0.1', 'en', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 2, 1762338444, 'Chrome', 'Windows'),
(9, '690b271bee32f', '127.0.0.1', 'en', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 1, 1762338587, 'Chrome', 'Windows'),
(10, '690b2a86b20bc', '127.0.0.1', 'en', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 4, 1762339462, 'Chrome', 'Windows'),
(11, '690b3d9073f9e', '127.0.0.1', 'en', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 1, 1762344336, 'Chrome', 'Windows'),
(12, '690b3db2d03a6', '127.0.0.1', 'en', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 2, 1762344370, 'Chrome', 'Windows'),
(13, '690b3f2921b38', '127.0.0.1', 'en', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 1, 1762344745, 'Chrome', 'Windows'),
(14, '690b4f63e64c2', '127.0.0.1', 'en', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 1, 1762348899, 'Chrome', 'Windows'),
(15, '690c05a90c06a', '127.0.0.1', 'en', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 2, 1762395561, 'Chrome', 'Windows'),
(16, '690c069da26ec', '127.0.0.1', 'en', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 2, 1762395805, 'Chrome', 'Windows'),
(17, '690c075a9a4c4', '127.0.0.1', 'en', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 1, 1762395994, 'Chrome', 'Windows'),
(18, '690c0e9173553', '127.0.0.1', 'en', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 2, 1762397841, 'Chrome', 'Windows'),
(19, '690d601ee1e63', '127.0.0.1', 'en', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 1, 1762484254, 'Chrome', 'Windows'),
(20, '690d64db7fdba', '127.0.0.1', 'en', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 2, 1762485467, 'Chrome', 'Windows'),
(21, '690d758d90d3c', '127.0.0.1', 'en', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 1, 1762489741, 'Chrome', 'Windows'),
(22, '690dcd71c44f5', '127.0.0.1', 'en', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 1, 1762512241, 'Chrome', 'Windows'),
(23, '690e898bc61c5', '127.0.0.1', 'en', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 2, 1762560395, 'Chrome', 'Windows'),
(24, '690ea1fc955ab', '127.0.0.1', 'en', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 1, 1762566652, 'Chrome', 'Windows');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `idx-auth_assignment-user_id` (`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_item_group`
--
ALTER TABLE `auth_item_group`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kasir_id` (`kasir_id`);

--
-- Indexes for table `transaksi_detil`
--
ALTER TABLE `transaksi_detil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_id` (`transaksi_id`),
  ADD KEY `obat_id` (`obat_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_visit_log`
--
ALTER TABLE `user_visit_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_detil`
--
ALTER TABLE `transaksi_detil`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_visit_log`
--
ALTER TABLE `user_visit_log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `pembelian_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`kasir_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `transaksi_detil`
--
ALTER TABLE `transaksi_detil`
  ADD CONSTRAINT `transaksi_detil_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`),
  ADD CONSTRAINT `transaksi_detil_ibfk_2` FOREIGN KEY (`obat_id`) REFERENCES `obat` (`id`);

--
-- Constraints for table `user_visit_log`
--
ALTER TABLE `user_visit_log`
  ADD CONSTRAINT `user_visit_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
