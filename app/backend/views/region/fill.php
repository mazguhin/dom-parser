<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\entities\Region */

$this->title = 'Заполнить';
$this->params['breadcrumbs'][] = ['label' => 'Regions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="region-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="panel panel-default">
        <div class="panel-body">
            <form action="/region/fill" method="post">
                <div class="form-group">
                    <textarea placeholder="URLs" name="urls" class="form-control" id="urls" cols="30" rows="10"></textarea>
                </div>
                <div class="form-group">
                    <textarea placeholder="Names" name="names" class="form-control" id="urls" cols="30" rows="10"></textarea>

                </div>
                <?= \common\models\App::csrf_field() ?>
                <button type="submit" class="btn btn-default">Отправить</button>
            </form>
        </div>
    </div>

</div>
