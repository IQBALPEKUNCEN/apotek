<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "supplier".
 *
 * @property int $id
 * @property string|null $nama_supplier
 * @property string|null $alamat
 * @property string|null $no_hp
 *
 * @property Pembelian[] $pembelians
 */
class Supplier extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supplier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_supplier', 'alamat', 'no_hp'], 'default', 'value' => null],
            [['alamat'], 'string'],
            [['nama_supplier'], 'string', 'max' => 200],
            [['no_hp'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_supplier' => 'Nama Supplier',
            'alamat' => 'Alamat',
            'no_hp' => 'No Hp',
        ];
    }

    /**
     * Gets query for [[Pembelians]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPembelians()
    {
        return $this->hasMany(Pembelian::class, ['supplier_id' => 'id']);
    }

}
