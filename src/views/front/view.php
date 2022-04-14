<?php

use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\LinkPager;

$this->title = $model->name;

$this->params['breadcrumbs'][] = ['label' => 'Наш коллектив', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div id="collective">
    <section class="container">
        <div class="row">
            <div class="col-12 col-lg-4">
                <img class="mw-100" src="<?= $model->photo; ?>" alt="<?= $model->name; ?>">
                <p>Телефон: <?= $model->phone; ?></p>
                <p>Эл. почта: <?= $model->email; ?></p>
            </div>
            <div class="col-12 col-lg-8">
                <p>Должность: <?= $model->post; ?></p>
                <h1 class="h5">ФИО: <?= $model->name; ?></h1>
                <hr>
                <p><?= $model->description; ?></p>
            </div>
        </div>
    </section>
</div>