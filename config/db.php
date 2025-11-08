<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=apotek_db',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',

    // Set charset dan collation untuk semua koneksi
    'attributes' => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
    ],

    // Enable schema cache untuk performa
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 3600,
    'schemaCache' => 'cache',
];
