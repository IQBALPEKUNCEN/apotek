<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Obat $model */

$this->title = 'Update Obat: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Obats', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="obat-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
