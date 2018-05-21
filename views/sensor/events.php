<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = 'scud - список событий';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="proelements-index">
    <div class="row">
        <div class="col-md-6">
            <?= Html::a(
                'События',
                '#',
                [
                    'id' => 'reglament_btn',
                    'name' => 'reglament-btn',
                    'class' => 'btn btn-success',
                    'name' => 'reglament-btn',
                ]) ?>
            <?= Html::a(
                'Оборудование',
                '/scud/sensor/list',
                [
                    'id' => 'reglamentdouch_btn',
                    'name' => 'reglamentdouch-btn',
                    'class' => 'btn btn-default',
                    'name' => 'reglamentdouch-btn',
                ]) ?>
        </div>
    </div>
    <hr>
    <?php Pjax::begin(); ?>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => '_view_events',
            'layout' => '{items}<div class="clearfix"></div>{pager}',
        ]) ?>
    <?php Pjax::end(); ?>
</div>
