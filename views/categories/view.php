<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/vladkukushkin/yii2-articles
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-articles
* @version 0.6.2
*/

use yii\helpers\Html;
use yii\widgets\DetailView;

// Set Title and Breadcrumbs
$this->title = $model->name;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="categories-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'alias',
            'description:ntext',
            'parentid',
            'state',
            'access',
            'ordering',
            'image',
            'image_caption:ntext',
            'image_credits',
            'params:ntext',
            'metadesc:ntext',
            'metakey:ntext',
            'robots',
            'author',
            'copyright',
            'language',
        ],
    ]) ?>

</div>
