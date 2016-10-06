<?php
    /**
     * @var \yii\web\View $this
     * @var \common\models\Product $model
     */
    use yii\alexposseda\fileManager\FileManager;
    use yii\helpers\Url;
    
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
    $this->params['breadcrumbs'][] = Yii::t('app', 'Product').': '.$this->title;
?>
<div class="row">
    <div class="col-lg-10">
        <?php if($model->isAvailableTranslate(Yii::$app->language)): ?>
            <div class="btn-group btn-group-sm pull-right">
                <a class="btn btn-sm btn-warning" href="<?= Url::to([
                                                                        'catalog/update-product',
                                                                        'id' => $model->id
                                                                    ]) ?>"><?= Yii::t('app', 'Update Product') ?></a>
                <a
                    class="btn btn-sm btn-danger"
                    href="<?= Url::to([
                                          'catalog/delete-product',
                                          'id' => $model->id
                                      ]) ?>"
                    data-method="POST"
                    data-confirm="<?= Yii::t('info', 'You confirm the removal?') ?>"
                ><?= Yii::t('app', 'Delete Product') ?></a>
            </div>
            <h2><?= $model->title ?></h2>
            <div class="row">
                <?php if(!empty($productCover)): ?>
                    <img class="img-responsive img-thumbnail" src="<?= FileManager::getInstance()
                                                                                  ->getStorageUrl().$productCover[0] ?>">
                <?php else: ?>
                    <img class="img-responsive img-thumbnail" src="<?= Url::to('/img/nopic.jpg', true) ?>">
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-danger"><?= Yii::t('app', 'No data for this language') ?></div>
            <a href="<?= Url::to([
                                     'catalog/update-product',
                                     'id' => $model->id
                                 ]) ?>" class="btn btn-block btn-warning"><?= Yii::t('app', 'Update Product') ?></a>
        <?php endif; ?>
    </div>
    <div class="col-lg-2">
        <?= $this->render('_availableLangList', ['model' => $model]) ?>
    </div>
</div>
