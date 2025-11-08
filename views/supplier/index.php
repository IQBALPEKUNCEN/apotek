<?php

use app\models\Supplier;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\SupplierSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Data Supplier';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-index">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
            <div class="box-tools pull-right">
                <?= Html::a('<i class="fa fa-plus"></i> Tambah Supplier', ['create'], [
                    'class' => 'btn btn-success btn-sm'
                ]) ?>
            </div>
        </div>

        <div class="box-body">
            <?php Pjax::begin(['id' => 'supplier-pjax']); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'layout' => "{summary}\n{items}\n{pager}",
                'tableOptions' => ['class' => 'table table-striped table-bordered'],
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'No',
                        'headerOptions' => ['style' => 'width: 50px; text-align: center;'],
                        'contentOptions' => ['style' => 'text-align: center;'],
                    ],

                    [
                        'attribute' => 'nama_supplier',
                        'label' => 'Nama Supplier',
                        'format' => 'text',
                        'headerOptions' => ['style' => 'width: 250px;'],
                    ],

                    [
                        'attribute' => 'alamat',
                        'label' => 'Alamat',
                        'format' => 'ntext',
                        'value' => function ($model) {
                            return mb_strlen($model->alamat) > 100
                                ? mb_substr($model->alamat, 0, 100) . '...'
                                : $model->alamat;
                        },
                    ],

                    [
                        'attribute' => 'no_hp',
                        'label' => 'No. HP/Telepon',
                        'format' => 'text',
                        'headerOptions' => ['style' => 'width: 150px;'],
                    ],

                    [
                        'class' => ActionColumn::class,
                        'header' => 'Aksi',
                        'headerOptions' => ['style' => 'width: 120px; text-align: center;'],
                        'contentOptions' => ['style' => 'text-align: center;'],
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a('<i class="fa fa-eye"></i>', $url, [
                                    'title' => 'Lihat Detail',
                                    'class' => 'btn btn-info btn-xs',
                                    'data-pjax' => '0',
                                ]);
                            },
                            'update' => function ($url, $model, $key) {
                                return Html::a('<i class="fa fa-pencil"></i>', $url, [
                                    'title' => 'Edit',
                                    'class' => 'btn btn-warning btn-xs',
                                    'data-pjax' => '0',
                                ]);
                            },
                            'delete' => function ($url, $model, $key) {
                                return Html::a('<i class="fa fa-trash"></i>', $url, [
                                    'title' => 'Hapus',
                                    'class' => 'btn btn-danger btn-xs',
                                    'data' => [
                                        'confirm' => 'Apakah Anda yakin ingin menghapus supplier "' . $model->nama_supplier . '"?',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                        ],
                        'urlCreator' => function ($action, Supplier $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>

</div>