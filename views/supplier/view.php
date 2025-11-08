<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Supplier $model */

$this->title = 'Detail Supplier: ' . $model->nama_supplier;
$this->params['breadcrumbs'][] = ['label' => 'Data Supplier', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="supplier-view">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>

            <div class="box-tools pull-right">
                <?= Html::a('<i class="fa fa-pencil"></i> Edit', ['update', 'id' => $model->id], [
                    'class' => 'btn btn-warning btn-sm'
                ]) ?>
                <?= Html::a('<i class="fa fa-trash"></i> Hapus', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger btn-sm',
                    'data' => [
                        'confirm' => 'Apakah Anda yakin ingin menghapus supplier "' . $model->nama_supplier . '"?',
                        'method' => 'post',
                    ],
                ]) ?>
                <?= Html::a('<i class="fa fa-arrow-left"></i> Kembali', ['index'], [
                    'class' => 'btn btn-default btn-sm'
                ]) ?>
            </div>
        </div>

        <div class="box-body">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-striped table-bordered detail-view'],
                'attributes' => [
                    [
                        'attribute' => 'id',
                        'label' => 'ID',
                        'format' => 'text',
                    ],
                    [
                        'attribute' => 'nama_supplier',
                        'label' => 'Nama Supplier',
                        'format' => 'text',
                    ],
                    [
                        'attribute' => 'alamat',
                        'label' => 'Alamat',
                        'format' => 'ntext',
                    ],
                    [
                        'attribute' => 'no_hp',
                        'label' => 'No. HP/Telepon',
                        'format' => 'text',
                    ],
                ],
            ]) ?>
        </div>
    </div>

</div>