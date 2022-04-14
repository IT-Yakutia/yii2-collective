<?php

use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\LinkPager;

$this->title = "Наш коллектив";

$this->params['breadcrumbs'][] = $this->title;

$itemView = Yii::$app->params['custom_view_for_modules']['collective_front']['_item'] ?? '_item';

?>

<div id="collective">
    <section class="container">
        <div class="row">
            <div class="col-12">
                <h3><?= $this->title ?></h3>
            </div>
        </div>
        <div class="row mb-3">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item'],
                'itemView' => $itemView,
                'options' => ['tag' => false, 'class' => false, 'id' => false],
                'itemOptions' => [
                    'tag' => false,
                    'class' => 'news-item',
                ],
                'layout' => '{items}',
                'summaryOptions' => ['class' => 'summary grey-text'],
                'emptyTextOptions' => ['class' => 'empty grey-text'],
            ]) ?>
        </div>
        <div class="d-flex justify-content-center align-items-center">
            <?= LinkPager::widget([
                'pagination' => $dataProvider->pagination,
                'registerLinkTags' => true,
                'options' => ['class' => 'pagination'],
                'prevPageCssClass' => '',
                'nextPageCssClass' => '',
                'pageCssClass' => 'page-item',
                'nextPageLabel' => '>',
                'prevPageLabel' => '<',
                'linkOptions' => ['class' => 'page-link btn'],
                'disabledPageCssClass' => 'd-none',
            ]); ?>
        </div>
    </section>
</div>