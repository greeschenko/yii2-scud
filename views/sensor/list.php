<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = 'ProZorro.продажі - державні аукціони';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="proelements-index">
    <div class="row">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>

        <div class="col-md-6">
            <?= Html::a(
                '<i class="fa fa-file-o" aria-hidden="true"></i> Регламент проведення торгів',
                '/',
                [
                    'id' => 'reglament_btn',
                    'name' => 'reglament-btn',
                    'class' => 'btn btn-default',
                    'name' => 'reglament-btn',
                    'target' => '_blunk',
                ]) ?>
            <?= Html::a(
                '<i class="fa fa-file-o" aria-hidden="true"></i> Регламент голландського аукціону',
                '/',
                [
                    'id' => 'reglamentdouch_btn',
                    'name' => 'reglamentdouch-btn',
                    'class' => 'btn btn-default',
                    'name' => 'reglamentdouch-btn',
                    'target' => '_blunk',
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
