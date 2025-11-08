<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TransaksiDetil $model */

$this->title = 'Update Transaksi Detil: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Transaksi Detils', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="transaksi-detil-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
