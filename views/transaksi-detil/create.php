<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TransaksiDetil $model */

$this->title = 'Create Transaksi Detil';
$this->params['breadcrumbs'][] = ['label' => 'Transaksi Detils', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaksi-detil-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
