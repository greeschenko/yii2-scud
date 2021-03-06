<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = 'scud - список датчиков';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="proelements-index">
    <div class="row">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>

        <div class="col-md-6">
            <?= Html::a(
                'События',
                '/scud/sensor/events',
                [
                    'id' => 'reglament_btn',
                    'name' => 'reglament-btn',
                    'class' => 'btn btn-default',
                    'name' => 'reglament-btn',
                ]) ?>
            <?= Html::a(
                'Оборудование',
                '#',
                [
                    'id' => 'reglamentdouch_btn',
                    'name' => 'reglamentdouch-btn',
                    'class' => 'btn btn-success',
                    'name' => 'reglamentdouch-btn',
                ]) ?>
        </div>
    </div>
    <hr>
    <?php Pjax::begin(); ?>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => '_view',
            'layout' => '{items}<div class="clearfix"></div>{pager}',
        ]) ?>
    <?php Pjax::end(); ?>
</div>
