<?php

use app\models\Obat;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\ObatSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Data Obat';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="obat-index">

    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <p>
        <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Tambah Obat Baru', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="glyphicon glyphicon-export"></i> Export Excel', ['export'], ['class' => 'btn btn-info']) ?>
    </p>

    <?php Pjax::begin(['id' => 'obat-pjax']); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-striped table-bordered'],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => 'No',
                'headerOptions' => ['style' => 'width: 50px; text-align: center;'],
                'contentOptions' => ['style' => 'text-align: center;'],
            ],

            [
                'attribute' => 'kode_obat',
                'label' => 'Kode',
                'headerOptions' => ['style' => 'width: 100px;'],
            ],

            [
                'attribute' => 'nama_obat',
                'label' => 'Nama Obat',
                'format' => 'raw',
                'value' => function ($model) {
                    $badge = '';
                    if ($model->stok < 10) {
                        $badge = ' <span class="label label-danger">Stok Rendah</span>';
                    }
                    return Html::encode($model->nama_obat) . $badge;
                }
            ],

            [
                'attribute' => 'kategori',
                'label' => 'Kategori',
                'headerOptions' => ['style' => 'width: 120px;'],
                'filter' => ['Tablet' => 'Tablet', 'Kapsul' => 'Kapsul', 'Sirup' => 'Sirup', 'Salep' => 'Salep', 'Injeksi' => 'Injeksi', 'Tetes' => 'Tetes', 'Lainnya' => 'Lainnya'],
            ],

            [
                'attribute' => 'stok',
                'label' => 'Stok',
                'headerOptions' => ['style' => 'width: 80px; text-align: center;'],
                'contentOptions' => function ($model) {
                    $class = 'text-center';
                    if ($model->stok == 0) {
                        $class .= ' bg-danger';
                    } elseif ($model->stok < 10) {
                        $class .= ' bg-warning';
                    }
                    return ['style' => 'text-align: center;', 'class' => $class];
                },
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->stok == 0) {
                        return '<strong style="color: red;">HABIS</strong>';
                    }
                    return $model->stok;
                }
            ],

            [
                'attribute' => 'harga_jual',
                'label' => 'Harga Jual',
                'headerOptions' => ['style' => 'width: 130px; text-align: right;'],
                'contentOptions' => ['style' => 'text-align: right;'],
                'format' => 'raw',
                'value' => function ($model) {
                    return 'Rp ' . number_format($model->harga_jual, 0, ',', '.');
                }
            ],

            [
                'attribute' => 'expired_date',
                'label' => 'Expired',
                'headerOptions' => ['style' => 'width: 110px;'],
                'format' => 'raw',
                'value' => function ($model) {
                    if (empty($model->expired_date)) {
                        return '-';
                    }

                    $expiredDate = new DateTime($model->expired_date);
                    $now = new DateTime();
                    $diff = $now->diff($expiredDate);

                    $formatted = Yii::$app->formatter->asDate($model->expired_date, 'php:d/m/Y');

                    if ($expiredDate < $now) {
                        return '<span class="label label-danger">' . $formatted . '</span><br><small class="text-danger">Kadaluarsa</small>';
                    } elseif ($diff->days <= 30) {
                        return '<span class="label label-warning">' . $formatted . '</span><br><small class="text-warning">' . $diff->days . ' hari lagi</small>';
                    } else {
                        return $formatted;
                    }
                }
            ],

            [
                'class' => ActionColumn::class,
                'header' => 'Aksi',
                'headerOptions' => ['style' => 'width: 100px; text-align: center;'],
                'contentOptions' => ['style' => 'text-align: center;'],
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => 'Lihat Detail',
                            'class' => 'btn btn-xs btn-info',
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'title' => 'Edit',
                            'class' => 'btn btn-xs btn-primary',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title' => 'Hapus',
                            'class' => 'btn btn-xs btn-danger',
                            'data-confirm' => 'Apakah Anda yakin ingin menghapus obat "' . $model->nama_obat . '"?',
                            'data-method' => 'post',
                        ]);
                    },
                ],
                'urlCreator' => function ($action, Obat $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
        'summary' => 'Menampilkan {begin}-{end} dari {totalCount} data obat',
        'emptyText' => 'Tidak ada data obat.',
    ]); ?>

    <?php Pjax::end(); ?>

</div>

<style>
    .table>tbody>tr>td {
        vertical-align: middle;
    }
</style>