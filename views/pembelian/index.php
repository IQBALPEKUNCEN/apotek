<?php

use app\models\Pembelian;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\PembelianSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Daftar Pembelian';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pembelian-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Tambah Pembelian', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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
                'format' => ['date', 'php:d-m-Y'],
                'label' => 'Tanggal',
            ],
            [
                'attribute' => 'total',
                'value' => function ($model) {
                    return 'Rp ' . number_format($model->total, 0, ',', '.');
                },
                'label' => 'Total',
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => 'View',
                            'class' => 'btn btn-sm btn-info',
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'title' => 'Update',
                            'class' => 'btn btn-sm btn-primary',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title' => 'Delete',
                            'class' => 'btn btn-sm btn-danger',
                            'data' => [
                                'confirm' => 'Apakah Anda yakin ingin menghapus pembelian ini?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
                'urlCreator' => function ($action, Pembelian $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>