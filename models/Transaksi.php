<?php

namespace app\models;

use Yii;
use app\models\User; // ✅ perbaikan: gunakan User, bukan Users

class Transaksi extends \yii\db\ActiveRecord
{
    // ✅ atribut untuk filter laporan (bukan kolom database)
    public $tanggal_awal;
    public $tanggal_akhir;

    public static function tableName()
    {
        return 'transaksi';
    }

    public function rules()
    {
        return [
            [['kode_transaksi', 'tanggal', 'total', 'kasir_id'], 'default', 'value' => null],
            [['tanggal'], 'safe'],
            [['total'], 'number'],
            [['kasir_id'], 'integer'],
            [['kode_transaksi'], 'string', 'max' => 50],

            // ✅ filter laporan
            [['tanggal_awal', 'tanggal_akhir'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode_transaksi' => 'Kode Transaksi',
            'tanggal' => 'Tanggal',
            'total' => 'Total Harga',
            'kasir_id' => 'Kasir',
            'tanggal_awal' => 'Tanggal Awal',
            'tanggal_akhir' => 'Tanggal Akhir',
        ];
    }

    public function getKasir()
    {
        return $this->hasOne(User::class, ['id' => 'kasir_id']);
    }

    public function getTransaksiDetils()
    {
        return $this->hasMany(TransaksiDetil::class, ['transaksi_id' => 'id']);
    }
}
