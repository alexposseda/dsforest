<?php
    /**
     * @var \yii\web\View           $this
     * @var \common\models\Product $model
     */
    use backend\widgets\FileManagerWidget\FileManagerWidget;
    use common\models\Lang;
    use yii\bootstrap\ActiveForm;
    use yii\bootstrap\Html;
    use yii\bootstrap\Tabs;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Url;
    
    $lastBreadCrumb = array_pop($this->params['breadcrumbs']);
    $this->params['breadcrumbs'][] = [
        'label' => (!empty($model->offer->category->title)) ? Yii::t('app', 'Category').': '.$model->offer->category->title : Yii::t('app',
                                                                                                                                     'Category').': '.$model->offer->category->id,
        'url'   => Url::to([
                               'catalog/view-category',
                               'id' => $model->offer->category->id
                           ])
    ];
    $this->params['breadcrumbs'][] = [
        'label' => (!empty($model->offer->title)) ? Yii::t('app', 'Offer').': '.$model->offer->title : Yii::t('app', 'Offer').': '.$model->offer->id,
        'url'   => Url::to([
                               'catalog/view-offer',
                               'id' => $model->offer->id
                           ])
    ];
    $this->params['breadcrumbs'][] = $lastBreadCrumb;
    
    $necessaryLangs = $model->necessaryLangs;
    $availableLangs = ArrayHelper::map($model->availableLangs, 'langCode', 'langTitle');
    $tabItems       = [];
    $languages      = Lang::getLanguagesAsCodeTitle();
?>
<div class="row">
    <?php if(!key_exists(Yii::$app->language, $availableLangs)): ?>
        <div class="alert alert-warning"><?= Yii::t('info', 'You can not create a proposal for the current language and in the current category') ?></div>
    <?php endif; ?>
    <?php if(count($availableLangs) < count($languages)): ?>
        <div class="alert alert-info"><?= Yii::t('info', 'To add in other languages, you must') ?> <strong><a href="<?= Url::to([
                                                                                                                                    'catalog/update-offer',
                                                                                                                                    'id' => $model->offerId
                                                                                                                                ]) ?>"><?= Yii::t('app',
                                                                                                                                                  'Update Offer') ?></a></strong>
        </div>
    <?php endif; ?>
    <?php $form = ActiveForm::begin() ?>
    <div class="col-lg-9">
        <?php
            if($model->isNewRecord){
                foreach($necessaryLangs as $langModel){
                    $tabItems[] = [
                        'label'   => $languages[$langModel->language],
                        'content' => $form->field($model,
                                                  ($langModel->language == Yii::$app->language) ? 'title' : 'title_'.$langModel->language)
                                          ->label(Yii::t('app', 'Title', [], $langModel->language)),
                        'active'  => (Yii::$app->language == $langModel->language) ? true : false,
                    ];
                }
            }else{
                foreach($necessaryLangs as $langModel){
                    $tabItems[] = [
                        'label'   => $languages[$langModel->language],
                        'content' => $form->field($model,
                                                  ($langModel->language == Yii::$app->language) ? 'title' : 'title_'.$langModel->language)
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
        <?= Html::activeHiddenInput($model, 'cover', ['id' => 'cover']) ?>
        <?= FileManagerWidget::widget([
                                          'uploadUrl'     => Url::to('product-upload'),
                                          'removeUrl'     => Url::to('product-remove'),
                                          'files'         => ($model->isNewRecord) ? '' : $model->cover,
                                          'targetInputId' => 'cover',
                                          'maxFiles'      => 1,
                                          'title'         => Yii::t('app', 'Cover')
                                      ]) ?>
    </div>
    
    <?= Html::submitButton(($model->isNewRecord) ? Yii::t('app', 'Create Product') : Yii::t('app', 'Update Product'),
                           ['class' => 'btn '.(($model->isNewRecord) ? 'btn-primary' : 'btn-warning')]) ?>
    <?php ActiveForm::end() ?>
</div>