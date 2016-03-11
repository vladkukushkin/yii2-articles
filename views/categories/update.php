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

// Javascript to load Options Data
$options = json_decode($model->params);
$script  = "
	jQuery('div.field-categories-categoriesImageWidth select').val('".$options->categoriesImageWidth."');
	jQuery('div.field-categories-categoryImageWidth select').val('".$options->categoryImageWidth."');
	jQuery('div.field-categories-itemImageWidth select').val('".$options->itemImageWidth."');
	jQuery('div.field-categories-categoriesViewData select').val('".$options->categoriesViewData."');
	jQuery('div.field-categories-categoryViewData select').val('".$options->categoryViewData."');
	jQuery('div.field-categories-itemViewData select').val('".$options->itemViewData."');
";
$this->registerJs($script);

// Set Title and Breadcrumbs
$this->title = Yii::t('articles', 'Update ', ['modelClass' => 'Categories',]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('articles', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Render Yii2-Articles Menu
echo Yii::$app->view->renderFile('@vendor/vladkukushkin/yii2-articles/views/default/_menu.php');

?>
<div class="categories-update">

	<?php if(Yii::$app->getModule('articles')->showTitles): ?>
		<div class="page-header">
			<h1><?= Html::encode($this->title) ?></h1>
		</div>
	<?php endif ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
