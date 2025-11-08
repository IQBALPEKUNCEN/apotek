<?php

namespace app\models;

use yii\base\Model;

class LaporanForm extends Model
{
    public $tanggal_awal;
    public $tanggal_akhir;

    public function rules()
    {
        return [
            [['tanggal_awal', 'tanggal_akhir'], 'safe'],
        ];
    }
}
