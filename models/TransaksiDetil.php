<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaksi_detil".
 *
 * @property int $id
 * @property int|null $transaksi_id
 * @property int|null $obat_id
 * @property float|null $harga_jual
 * @property int|null $qty
 *
 * @property Obat $obat
 * @property Transaksi $transaksi
 */
class TransaksiDetil extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaksi_detil';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['transaksi_id', 'obat_id', 'harga_jual', 'qty'], 'default', 'value' => null],
            [['transaksi_id', 'obat_id', 'qty'], 'integer'],
            [['harga_jual'], 'number'],
            [['transaksi_id'], 'exist', 'skipOnError' => true, 'targetClass' => Transaksi::class, 'targetAttribute' => ['transaksi_id' => 'id']],
            [['obat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Obat::class, 'targetAttribute' => ['obat_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'transaksi_id' => 'Transaksi ID',
            'obat_id' => 'Obat ID',
            'harga_jual' => 'Harga Jual',
            'qty' => 'Qty',
        ];
    }

    /**
     * Gets query for [[Obat]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObat()
    {
        return $this->hasOne(Obat::class, ['id' => 'obat_id']);
    }

    /**
     * Gets query for [[Transaksi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransaksi()
    {
        return $this->hasOne(Transaksi::class, ['id' => 'transaksi_id']);
    }

}
