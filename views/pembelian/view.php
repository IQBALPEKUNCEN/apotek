<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Pembelian $model */

$this->title = 'Detail Pembelian #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Daftar Pembelian', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pembelian-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<i class="glyphicon glyphicon-pencil"></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="glyphicon glyphicon-trash"></i> Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Apakah Anda yakin ingin menghapus pembelian ini?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Kembali', ['index'], ['class' => 'btn btn-default']) ?>
    </p>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Informasi Pembelian</h3>
        </div>
        <div class="panel-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'supplier_id',
                        'value' => function ($model) {
                            return $model->supplier ? $model->supplier->nama_supplier : '-';
                        },
                        'label' => 'Supplier',
                    ],
                    [
                        'attribute' => 'tanggal',
                        'value' => date('d-m-Y', strtotime($model->tanggal)),
                        'label' => 'Tanggal Pembelian',
                    ],
                    [
                        'attribute' => 'total',
                        'value' => 'Rp ' . number_format($model->total, 0, ',', '.'),
                        'label' => 'Total Pembelian',
                    ],
                ],
            ]) ?>
        </div>
    </div>

</div>