<?php

use uraankhayayaal\materializecomponents\checkbox\WCheckbox;
use uraankhayayaal\materializecomponents\imgcropper\Cropper;
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
            <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col s12 m6 l6">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col s12 m6 l6">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>

        
    </div>

    <div class="row">
        <div class="col s12 m6 l6">
            
            <?= $form->field($model, 'photo')->widget(Cropper::class, [
                //'aspectRatio' => 734/1920,
                'maxSize' => [1000, 1000, 'px'],
                'minSize' => [10, 10, 'px'],
                'startSize' => [100, 100, '%'],
                'uploadUrl' => Url::to(['/collective/back/uploadImg']),
            ]); ?>
            <small>Your upload img have to has maximum size of: 1000x1000 px and 2Mb</small>
        </div>
    </div>


    <div class='form-group field-attribute-parentId'>
    <?= Html::label('Parent', 'parent', ['class' => 'control-label']);?>
    <?= Html::dropdownList(
        'Collective[parentId]',
        $model->parentId,
        $model::getTree($model->id),
        ['prompt' => 'No Parent (saved as root)', 'class' => 'form-control']
    );?>

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
