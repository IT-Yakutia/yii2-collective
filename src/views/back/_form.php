<?php

use uraankhayayaal\materializecomponents\checkbox\WCheckbox;
use uraankhayayaal\materializecomponents\imgcropper\Cropper;
use uraankhayayaal\redactor\RedactorWidget;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="collective-form">

    <?php $form = ActiveForm::begin([
        'errorCssClass' => 'red-text',
    ]); ?>

    <?= WCheckbox::widget(['model' => $model, 'attribute' => 'is_publish']); ?>

    <div class="row">
        <div class="col s12 m6 l6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col s12 m6 l6">
            <?= $form->field($model, 'post')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col s12 m6 l6">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col s12 m6 l6">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col s12 m6 l6">
            <?= $form->field($model, 'vk_link')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col s12 m6 l6">
            <?= $form->field($model, 'fb_link')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col s12 m6 l6">
            <?= $form->field($model, 'inst_link')->textInput(['maxlength' => true]) ?>
        </div>

    </div>

    <div class="row">
        <div class="col s12">
            <?= $form->field($model, 'description')->widget(RedactorWidget::class, [
                'settings' => [
                    'lang' => 'ru',
                    'minHeight' => 200,
                    'plugins' => [
                        'fullscreen',
                        'fontcolor',
                        'fontfamily',
                        'fontsize',
                        'limiter',
                        'table',
                        'textdirection',
                        'textexpander',
                    ]
                ],
                'class' => 'materialize-textarea',
            ]); ?>
        </div>
    </div>

    <div class='form-group field-attribute-parentId'>
        <?= Html::label('Подчинённый у', 'parent', ['class' => 'control-label']); ?>
        <?= Html::dropdownList(
            'Collective[parentId]',
            $model->parentId,
            $model::getTree($model->id),
            ['prompt' => 'Не подчиняется', 'class' => 'form-control']
        ); ?>

    </div>

    <?= $form->field($model, 'position')->textInput(['type' => 'number']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn']) ?>
    </div>
    <div class="fixed-action-btn">
        <?= Html::submitButton('<i class="material-icons">save</i>', [
            'class' => 'btn-floating btn-large waves-effect waves-light tooltipped',
            'title' => 'Сохранить',
            'data-position' => "left",
            'data-tooltip' => "Сохранить",
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>