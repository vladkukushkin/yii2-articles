<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-articles
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-articles
* @version 0.6.2
*/

use yii\helpers\Html;
use cinghie\articles\assets\ArticlesAsset;
use yii\helpers\Url;

// Load Kartik Libraries
use kartik\widgets\ActiveForm;
use kartik\widgets\ActiveField;
use kartik\widgets\DateTimePicker;
use kartik\widgets\FileInput;
use kartik\widgets\InputWidget;
use kartik\widgets\Select2;

// Load Editors Libraries
use dosamigos\ckeditor\CKEditor;
use dosamigos\tinymce\TinyMce;
use kartik\markdown\MarkdownEditor;

// Load Articles Assets
ArticlesAsset::register($this);
$asset = $this->assetBundles['cinghie\articles\assets\ArticlesAsset'];

// Get info For the Select2 Categories 
if ($model->id) { $id = $_REQUEST['id']; } else { $id = 0; }
$select2categories = $model->getCategoriesSelect2();

// Get info by Module Configuration
$editor    = Yii::$app->controller->module->editor;
$language  = substr(Yii::$app->language,0,2);
$languages = Yii::$app->controller->module->languages;
$imagetype = Yii::$app->controller->module->imageType;
$roles     = $model->getRoles();
?>

<div class="categories-form">

    <?php $form = ActiveForm::begin([
		'options' => [
			'enctype'=>'multipart/form-data'
		],
	]); ?>
	
	<div class="row">
    
    	<div class="col-lg-12">
		
			<div class="bs-example bs-example-tabs">
			
				<!-- Tab Control -->
				<ul class="nav nav-tabs" id="myTab">
					<li class="active">
						<a data-toggle="tab" href="#item">
							<?= Yii::t('articles', 'Category') ?>
						</a>
					</li>
					<li class="">
						<a data-toggle="tab" href="#seo">
							<?= Yii::t('articles', 'SEO') ?>
						</a>
					</li>
                    <li class="">
						<a data-toggle="tab" href="#image">
							<?= Yii::t('articles', 'Image') ?>
						</a>
					</li>
					<li class="">
						<a data-toggle="tab" href="#params">
							<?= Yii::t('articles', 'Options') ?>
						</a>
					</li>
                </ul>
				
				<!-- Tab Contents -->
				<div class="tab-content" id="myTabContent">
					
					<div class="separator"></div>
				
					<!-- Item -->
					<div id="item" class="tab-pane fade active in">
                    
						<div class="col-lg-8">
						
							<?= $form->field($model, 'name', [
									'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-plus"></i>'
										]
									]
								])->textInput(['maxlength' => 255]) ?>
                                
                            <?php if ($editor=="imperavi"): ?>
                            	<?= $form->field($model, 'description')->widget(yii\imperavi\Widget::className(), [
									'options' => [
										'css'  => 'wym.css',
										'imageUpload' => Url::to(['/articles/categories/image-upload']),
										'imageManagerJson' => Url::to(['/articles/categories/images-get']),
									],
									'plugins' => [
										'fullscreen',
										'clips',
										'imagemanager',
									],
								]); ?>
                            <?php else: ?>
                            	<?= $form->field($model, 'description')->textarea(['rows' => 12]); ?>
                            <?php endif ?>
						
						</div> <!-- col-lg-8 -->
						
						<div class="col-lg-4">
						
							<?= $form->field($model, 'parentid')->widget(Select2::classname(), [
								'data' => $select2categories,
								'addon' => [
									'prepend' => [
										'content'=>'<i class="glyphicon glyphicon-folder-open"></i>'
									]
								],
							]); ?>
						
							<?= $form->field($model, 'state')->widget(Select2::classname(), [
                                    'data' => [
										1 => Yii::t('articles', 'Published'),
										0 => Yii::t('articles', 'Unpublished'),
									],
                                    'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-check"></i>'
										]
									],
                                ]); ?>
                                
                            <?= $form->field($model, 'access')->widget(Select2::classname(), [
                                    'data' => $roles,
                                    'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-log-in"></i>'
										]
									],
                                ]); ?>
                            
                            <?php if ($model->isNewRecord): ?>
                            <?= $form->field($model, 'ordering')->widget(Select2::classname(), [
                                    'data' => [ "0" =>  Yii::t('articles', 'In Development') ],
									'options' => [
										'disabled' => 'disabled'
									],
                                    'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-sort"></i>'
										]
									],
                                ]); ?>
                            <?php else : ?>
                            <?= $form->field($model, 'ordering')->widget(Select2::classname(), [
                                    'data' => [ "0" =>  Yii::t('articles', 'In Development') ],
									'options' => [
										'disabled' => 'disabled'
									],                                 
                                    'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-sort"></i>'
										]
									],
                                ]); ?>
                            <?php endif ?>
                            
                            <?= $form->field($model, 'language')->widget(Select2::classname(), [
                                    'data' => $languages,
                                    'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-globe"></i>'
										]
									],
                                ]); ?> 
						
						</div> <!-- col-lg-4 -->
						
					</div> <!-- #item -->
					
					<!-- SEO -->
					<div id="seo" class="tab-pane fade">
                    
                    	<div class="col-lg-5">
						
							<?= $form->field($model, 'alias', ['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-bookmark"></i>']]] )->textInput(['maxlength' => 255]) ?>
							
                            <?= $form->field($model, 'robots')->widget(Select2::classname(), [
                                    'data' => [ "index, follow" => "index, follow", "no index, no follow" => "no index, no follow", "no index, follow" => "no index, follow", "index, no follow" => "index, no follow" ],
                                    'addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-globe"></i>']],
                                ]); ?>   
                            
							<?= $form->field($model, 'author', [
									'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-user"></i>'
										]
									]
								])->textInput(['maxlength' => 50]) ?>

   							<?= $form->field($model, 'copyright', [
									'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-ban-circle"></i>'
										]
									]
								])->textInput(['maxlength' => 50]) ?>
						
						</div> <!-- col-lg-5 -->
                        
                        <div class="col-lg-7">
						
							<?= $form->field($model, 'metadesc', [
									'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-info-sign"></i>'
										]
									]
								])->textarea(['rows' => 4]) ?>
                            
                            <?= $form->field($model, 'metakey', [
									'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-tags"></i>'
										]
									]
								])->textarea(['rows' => 4]) ?>
						
						</div> <!-- col-lg-7 -->
                        
                    </div> <!-- #seo -->
                    
                    <!-- Image -->
					<div id="image" class="tab-pane fade">
                    
                    	<p class="bg-info">
							<?= Yii::t('articles', 'Allowed Extensions')?>: <?= $imagetype ?>
						</p>
                    
                    	<div class="col-lg-6">
                                                
                        	<?= $form->field($model, 'image')->widget(FileInput::classname(), [
                                	'options' => [
                                    	'accept' => 'image/'.$imagetype
                                    ],
                                    'pluginOptions' => [
                                        'previewFileType' => 'image',
                                        'showUpload'      => false,
                                        'browseLabel'     => Yii::t('articles', 'Browse &hellip;'),
                                    ],
                            ]); ?> 
                            
                            <?php if ( isset($model->image) && !empty($model->image) ): ?>
                            
                            <div class="thumbnail">                       	
                            	<img alt="200x200" class="img-thumbnail" data-src="holder.js/300x250" style="width: 300px;" src="<?= $model->getImageUrl() ?>">
                            	<div class="caption">
                            		<p></p>
                            	    <p>
										<?= Html::a(Yii::t('articles', 'Delete Image'), ['deleteimage', 'id' => $model->id], [
                                                'class' => 'btn btn-danger',
                                                'data' => [
                                                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                                ],
										]) ?>
                            	    </p>
                            	</div>
                            </div>
                            
                            <?php endif ?>
						
						</div> <!-- col-lg-6 -->
                        
                        <div class="col-lg-6">
						
							<?= $form->field($model, 'image_caption', [
									'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-picture"></i>'
										]
									 ]
								])->textarea(['rows' => 6]) ?>
                            
                            <?= $form->field($model, 'image_credits', [
									'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-barcode"></i>'
										]
									]
								])->textInput(['maxlength' => 255]) ?>
						
						</div> <!-- col-lg-6 -->
					
					</div> <!-- #image -->
					
					<!-- Params -->
					<div id="params" class="tab-pane fade">
					
						<!-- Categories View -->
						<div class="col-md-4">
                            
							<h4><?= Yii::t('articles', 'Categories View')?></h4>
							
							<?php 
								
								// Categories Image Width
								echo '<div class="form-group field-categories-categoriesImageWidth">';
								echo '<label class="control-label">'.Yii::t('articles', 'Image Width').'</label>';
								echo Select2::widget([
									'name' => 'categoriesImageWidth',
									'data' => [ 
										'small'  => Yii::t('articles', 'Small'), 
										'medium' => Yii::t('articles', 'Medium'), 
										'large'  => Yii::t('articles', 'Large'), 
										'extra'  => Yii::t('articles', 'Extra')
									],
								]);
								echo '</div>';
								
								// Show Categories Item Data
								echo '<div class="form-group field-categories-categoriesViewData">';
								echo '<label class="control-label">'.Yii::t('articles', 'Show Item Data').'</label>';
								echo Select2::widget([
									'name' => 'categoriesViewData',
									'data' => [ 
										1 => Yii::t('articles','Yes'), 
										0 => Yii::t('articles','No') 
									],
								]);
								echo '</div>';
							
							?>
							
						</div> <!-- col-md-4 -->
						
						<!-- Category View -->
						<div class="col-md-4">
							
							<h4><?= Yii::t('articles', 'Category View')?></h4>
							
							<?php 
							
								// Category Image Width
								echo '<div class="form-group field-categories-categoryImageWidth">';
								echo '<label class="control-label">'.Yii::t('articles', 'Image Width').'</label>';
								echo Select2::widget([
									'name' => 'categoryImageWidth',
									'data' => [ 
										'small'  => Yii::t('articles', 'Small'), 
										'medium' => Yii::t('articles', 'Medium'), 
										'large'  => Yii::t('articles', 'Large'), 
										'extra'  => Yii::t('articles', 'Extra')
									],
								]);
								echo '</div>';
								
								// Show Item Data
								echo '<div class="form-group field-categories-categoryViewData">';
								echo '<label class="control-label">'.Yii::t('articles', 'Show Item Data').'</label>';
								echo Select2::widget([
									'name' => 'categoryViewData',
									'data' => [ 
										1 => Yii::t('articles','Yes'), 
										0 => Yii::t('articles','No') 
									],
								]);
								echo '</div>';
							?>
							
						</div> <!-- col-md-4 -->
						
						<!-- Item View -->
						<div class="col-md-4">
							
							<h4><?= Yii::t('articles', 'Item View')?></h4>
							
							<?php 
							
								// Item Image Width
								echo '<div class="form-group field-categories-itemImageWidth">';
								echo '<label class="control-label">'.Yii::t('articles', 'Image Width').'</label>';
								echo Select2::widget([
									'name' => 'itemImageWidth',
									'data' => [ 
										'small'  => Yii::t('articles', 'Small'), 
										'medium' => Yii::t('articles', 'Medium'), 
										'large'  => Yii::t('articles', 'Large'), 
										'extra'  => Yii::t('articles', 'Extra')
									],
								]);
								echo '</div>';
								
								// Show Item Data
								echo '<div class="form-group field-categories-itemViewData">';
								echo '<label class="control-label">'.Yii::t('articles', 'Show Item Data').'</label>';
								echo Select2::widget([
									'name' => 'itemViewData',
									'data' => [ 
										1 => Yii::t('articles','Yes'), 
										0 => Yii::t('articles','No') 
									],
								]);
								echo '</div>';
							?>
							
						</div> <!-- col-md-4 -->
                     
					</div> <!-- #params -->		
				
				</div> <!-- tab-content -->
			
			</div> <!-- bs-example -->

			<div class="col-lg-12">

				<div class="form-group">
					<?= Html::submitButton($model->isNewRecord ?  Yii::t('articles', 'Save & Exit') : Yii::t('articles', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
				</div>

			</div>
	
		</div> <!-- col-lg-12 -->
	
	</div> <!-- row -->

    <?php ActiveForm::end(); ?>

</div>
