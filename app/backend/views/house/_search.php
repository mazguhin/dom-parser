<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\search\HouseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="house-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'address') ?>

    <?= $form->field($model, 'year') ?>

    <?= $form->field($model, 'floors') ?>

    <?= $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'quarters') ?>

    <?php // echo $form->field($model, 'series') ?>

    <?php // echo $form->field($model, 'floor_type') ?>

    <?php // echo $form->field($model, 'walls_material') ?>

    <?php // echo $form->field($model, 'emergency') ?>

    <?php // echo $form->field($model, 'cadastral_number') ?>

    <?php // echo $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'square') ?>

    <?php // echo $form->field($model, 'region_id') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
