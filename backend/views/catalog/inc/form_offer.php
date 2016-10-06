<?php
    /**
     * @var \yii\web\View        $this
     * @var \common\models\Offer $model
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
        'label' => (!empty($model->category->title)) ? Yii::t('app', 'Category').': '.$model->category->title : Yii::t('app',
                                                                                                                       'Category').': '.$model->category->id,
        'url'   => Url::to([
                               'catalog/view-category',
                               'id' => $model->category->id
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
        <div class="alert alert-warning"><?= Yii::t('info',
                                                    'You can not create a proposal for the current language and in the current category') ?></div>
    <?php endif; ?>
    <?php if(count($availableLangs) < count($languages)): ?>
        <div class="alert alert-info"><?= Yii::t('info', 'To add in other languages, you must') ?> <strong><a href="<?= Url::to([
                                                                                                                                    'catalog/update-category',
                                                                                                                                    'id' => $model->categoryId
                                                                                                                                ]) ?>"><?= Yii::t('app',
                                                                                                                                                  'Update Category') ?></a></strong>
        </div>
    <?php endif; ?>
    <?php $form = ActiveForm::begin() ?>
    <div class="col-lg-9">
        <?php
            if($model->isNewRecord){
                foreach($necessaryLangs as $langModel){
                    $tabItems[] = [
                        'label'   => $languages[$langModel->language],
                        'content' => $form->field($model, ($langModel->language == Yii::$app->language) ? 'title' : 'title_'.$langModel->language)
                                          ->label(Yii::t('app', 'Title', [], $langModel->language)).$form->field($model,
                                                                                                                 ($langModel->language == Yii::$app->language) ? 'advantages' : 'advantages_'.$langModel->language)
                                                                                                         ->textarea()
                                                                                                         ->label(Yii::t('app', 'Advantages', [],
                                                                                                                        $langModel->language)),
                        'active'  => (Yii::$app->language == $langModel->language) ? true : false,
                    ];
                }
            }else{
                foreach($necessaryLangs as $langModel){
                    $tabItems[] = [
                        'label'   => $languages[$langModel->language],
                        'content' => $form->field($model, ($langModel->language == Yii::$app->language) ? 'title' : 'title_'.$langModel->language)
                                          ->textInput(['value' => $langModel->title])
                                          ->label(Yii::t('app', 'Title', [], $langModel->language)).$form->field($model,
                                                                                                                 ($langModel->language == Yii::$app->language) ? 'advantages' : 'advantages_'.$langModel->language)
                                                                                                         ->textarea(['value' => $langModel->advantages])
                                                                                                         ->label(Yii::t('app', 'Advantages', [],
                                                                                                                        $langModel->language)),
                        'active'  => (Yii::$app->language == $langModel->language) ? true : false,
                    ];
                }
            }
        ?>
        <?= Tabs::widget([
                             'items' => $tabItems
                         ]) ?>
        <?= Html::activeHiddenInput($model, 'gallery', ['id' => 'gallery']) ?>
        <?= FileManagerWidget::widget([
                                          'uploadUrl'     => Url::to('offer-upload'),
                                          'removeUrl'     => Url::to('offer-remove'),
                                          'files'         => ($model->isNewRecord) ? '' : $model->gallery,
                                          'targetInputId' => 'gallery',
                                          'maxFiles'      => 10,
                                          'title'         => Yii::t('app', 'Gallery')
                                      ]) ?>
    </div>
    <div class="col-lg-3">
        <?= Html::activeHiddenInput($model, 'cover', ['id' => 'offerCover']) ?>
        <?= FileManagerWidget::widget([
                                          'uploadUrl'     => Url::to('offer-upload-cover'),
                                          'removeUrl'     => Url::to('offer-remove-cover'),
                                          'files'         => ($model->isNewRecord) ? '' : $model->cover,
                                          'targetInputId' => 'offerCover',
                                          'maxFiles'      => 1,
                                          'title'         => Yii::t('app', 'Cover')
                                      ]) ?>
        <?= Html::submitButton(($model->isNewRecord) ? Yii::t('app', 'Create Offer') : Yii::t('app', 'Update Offer'),
                               ['class' => 'btn '.(($model->isNewRecord) ? 'btn-primary' : 'btn-warning')]) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>
