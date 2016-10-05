<?php
    /**
     * @var \yii\web\View           $this
     * @var \common\models\Category $model
     */
    use backend\widgets\FileManagerWidget\FileManagerWidget;
    use common\models\Lang;
    use yii\bootstrap\ActiveForm;
    use yii\bootstrap\Html;
    use yii\bootstrap\Tabs;
    use yii\helpers\Url;
    
    $tabItems       = [];
    $necessaryLangs = $model->necessaryLangs;
    $languages      = Lang::getLanguagesAsCodeTitle();
?>
<div class="row">
    <?php $form = ActiveForm::begin() ?>
    <div class="col-lg-9">
        <?php
            if($model->isNewRecord){
                foreach($necessaryLangs as $index => $langModel){
                    $tabItems[] = [
                        'label'   => $languages[$langModel->language],
                        'content' => $form->field($model,
                                                  ($langModel->language == Yii::$app->sourceLanguage) ? 'title' : 'title_'.$langModel->language)
                                          ->label(Yii::t('app', 'Title', [], $langModel->language)),
                        'active'  => (Yii::$app->language == $langModel->language) ? true : false,
                    ];
                }
            }else{
                foreach($necessaryLangs as $index => $langModel){
                    $tabItems[] = [
                        'label'   => $languages[$langModel->language],
                        'content' => $form->field($model,
                                                  ($langModel->language == Yii::$app->sourceLanguage) ? 'title' : 'title_'.$langModel->language)
                                          ->textInput(['value' => $langModel->title])
                                          ->label(Yii::t('app', 'Title', [], $langModel->language)),
                        'active'  => (Yii::$app->language == $langModel->language) ? true : false,
                    ];
                }
            }
        ?>
        <?= Tabs::widget([
                             'items' => $tabItems
                         ]) ?>
    </div>
    <div class="col-lg-3">
        <?= Html::activeHiddenInput($model, 'cover', ['id' => 'categoryCover']) ?>
        <?= FileManagerWidget::widget([
                                          'uploadUrl'     => Url::to('category-upload'),
                                          'removeUrl'     => Url::to('category-remove'),
                                          'files'         => ($model->isNewRecord) ? '' : $model->cover,
                                          'targetInputId' => 'categoryCover',
                                          'maxFiles'      => 1,
                                          'title'         => Yii::t('app', 'Cover')
                                      ]) ?>
    </div>
    
    <?= Html::submitButton(($model->isNewRecord) ? Yii::t('app', 'Create Category') : Yii::t('app', 'Update Category'),
                           ['class' => 'btn '.(($model->isNewRecord) ? 'btn-primary' : 'btn-warning')]) ?>
    <?php ActiveForm::end() ?>
</div>

