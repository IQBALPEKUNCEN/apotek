<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pembelian".
 *
 * @property int $id
 * @property int|null $supplier_id
 * @property string|null $tanggal
 * @property float|null $total
 *
 * @property Supplier $supplier
 */
class Pembelian extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pembelian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['supplier_id', 'tanggal', 'total'], 'default', 'value' => null],
            [['supplier_id'], 'integer'],
            [['tanggal'], 'safe'],
            [['total'], 'number'],
            [['supplier_id'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::class, 'targetAttribute' => ['supplier_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'supplier_id' => 'Supplier ID',
            'tanggal' => 'Tanggal',
            'total' => 'Total',
        ];
    }

    /**
     * Gets query for [[Supplier]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupplier()
    {
        return $this->hasOne(Supplier::class, ['id' => 'supplier_id']);
    }

    

}
