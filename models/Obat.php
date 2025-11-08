<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "obat".
 *
 * @property int $id
 * @property string|null $kode_obat
 * @property string|null $nama_obat
 * @property string|null $kategori
 * @property int|null $stok
 * @property float|null $harga_beli
 * @property float|null $harga_jual
 * @property string|null $expired_date
 *
 * @property TransaksiDetil[] $transaksiDetils
 */
class Obat extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'obat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_obat', 'nama_obat', 'kategori', 'harga_beli', 'harga_jual', 'expired_date'], 'default', 'value' => null],
            [['stok'], 'default', 'value' => 0],
            [['stok'], 'integer'],
            [['harga_beli', 'harga_jual'], 'number'],
            [['expired_date'], 'safe'],
            [['kode_obat'], 'string', 'max' => 50],
            [['nama_obat'], 'string', 'max' => 200],
            [['kategori'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode_obat' => 'Kode Obat',
            'nama_obat' => 'Nama Obat',
            'kategori' => 'Kategori',
            'stok' => 'Stok',
            'harga_beli' => 'Harga Beli',
            'harga_jual' => 'Harga Jual',
            'expired_date' => 'Expired Date',
        ];
    }

    /**
     * Gets query for [[TransaksiDetils]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransaksiDetils()
    {
        return $this->hasMany(TransaksiDetil::class, ['obat_id' => 'id']);
    }

}
