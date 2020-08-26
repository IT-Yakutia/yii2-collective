<?php

use ityakutia\collective\models\Collective;
use uraankhayayaal\materializecomponents\grid\MaterialActionColumn;
use uraankhayayaal\sortable\grid\Column;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\widgets\LinkPager;
use yii\helpers\Url;

$this->title = 'Коллектив';
?>
<div class="collective-index">
    <div class="row">
        <div class="col s12">
            <p>
                <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <div class="fixed-action-btn">
                <?= Html::a('<i class="material-icons">add</i>', ['create'], [
                    'class' => 'btn-floating btn-large waves-effect waves-light tooltipped',
                    'title' => 'Сохранить',
                    'data-position' => "left",
                    'data-tooltip' => "Добавить",
                ]) ?>
            </div>

            <?= GridView::widget([
                'tableOptions' => [
                    'class' => 'striped bordered my-responsive-table',
                    'id' => 'sortable'
                ],
                'rowOptions' => function ($model, $key, $index, $grid) {
                    return ['data-sortable-id' => $model->id];
                },
                'options' => [
                    'data' => [
                        'sortable-widget' => 1,
                        'sortable-url' => Url::toRoute(['sorting']),
                    ]
                ],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => SerialColumn::class],
                    ['class' => MaterialActionColumn::class, 'template' => '{update}'],

                    [
                        'header' => 'Фото',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->photo ? '<img class="materialboxed" src="' . $model->photo . '" width="70">' : '';
                        }
                    ],
                    [
                        'attribute' => 'name',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->name, ['update', 'id' => $model->id]);
                        }
                    ],
                    [
                        'attribute' => 'post',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->post, ['update', 'id' => $model->id]);
                        }
                    ],
                    [
                        'attribute' => 'phone',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->phone, ['update', 'id' => $model->id]);
                        }
                    ],
                    [
                        'attribute' => 'email',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->email, ['update', 'id' => $model->id]);
                        }
                    ],
                    [
                        'attribute' => 'tree',
                        'format' => 'raw',
                        'filter' => Collective::find()->roots()->select('name', 'id')->indexBy('id')->column(),
                        'value' => function ($model) {
                            if ($model->depth > 0) {
                                $tree = $model->parents()->all();
                                $parents = [];
                                $head = '';
                                foreach ($tree as $parent) {
                                    $parents[] = Html::a($head . $parent->name, ['update', 'id' => $parent->id]);
                                    $head = $head . '-';
                                }

                                return implode("<br>", $parents); // todo добавить ссылки вместо имён
                            } else {
                                return 'Никому не подчинятся';
                            }
                        }
                    ],
                    [
                        'attribute' => 'is_publish',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->is_publish ? '<i class="material-icons green-text">done</i>' : '<i class="material-icons red-text">clear</i>';
                        },
                        'filter' => [0 => 'Нет', 1 => 'Да'],
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'datetime',
                    ],
                    ['class' => MaterialActionColumn::class, 'template' => '{delete}'],
                    [
                        'class' => Column::class,
                    ],
                ],
                'pager' => [
                    'class' => LinkPager::class,
                    'options' => ['class' => 'pagination center'],
                    'prevPageCssClass' => '',
                    'nextPageCssClass' => '',
                    'pageCssClass' => 'waves-effect',
                    'nextPageLabel' => '<i class="material-icons">chevron_right</i>',
                    'prevPageLabel' => '<i class="material-icons">chevron_left</i>',
                ],
            ]); ?>
        </div>
    </div>
</div>