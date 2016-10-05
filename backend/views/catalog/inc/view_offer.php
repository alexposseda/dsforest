<?php
    /**
     * @var \yii\web\View        $this
     * @var \common\models\Offer $model
     */
    
    use yii\alexposseda\fileManager\FileManager;
    use yii\helpers\Url;
    
    $offerCover   = json_decode($model->cover);
    $offerGallery = json_decode($model->gallery);
?>
<div class="row">
    <div class="col-lg-2 text-center category-icon">
        <div class="category-icon-holder" data-spy="affix" data-offset-top="60" data-offset-bottom="70">
            <div>
                <?php if(!empty($offerCover)): ?>
                    <img class="img-responsive img-thumbnail" src="<?= FileManager::getInstance()
                                                                                  ->getStorageUrl().$offerCover[0] ?>">
                <?php else: ?>
                    <img class="img-responsive img-thumbnail" src="<?= Url::to('/img/nopic.jpg', true) ?>">
                <?php endif; ?>
            </div>
            <br>
            <div class="list-group">
                <?php if($model->isAvailableTranslate(Yii::$app->language)): ?>
                    <a href="<?= Url::to([
                                             'catalog/create-product',
                                             'offerId' => $model->id,
                                             'from'    => 'offer'
                                         ]) ?>" class="list-group-item list-group-item-success"><?= Yii::t('app', 'Add Product') ?></a>
                <?php else: ?>
                    <a href="<?= Url::to([
                                             'catalog/update-offer',
                                             'id' => $model->id
                                         ]) ?>" class="list-group-item list-group-item-warning"><?= Yii::t('app', 'Update Offer') ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <?php if($model->isAvailableTranslate(Yii::$app->language)): ?>
            <div class="btn-group btn-group-sm pull-right">
                <a class="btn btn-sm btn-warning" href="<?= Url::to([
                                                                        'catalog/update-offer',
                                                                        'id' => $model->id
                                                                    ]) ?>"><?= Yii::t('app', 'Update Offer') ?></a>
                <a
                    class="btn btn-sm btn-danger"
                    href="<?= Url::to([
                                          'catalog/delete-offer',
                                          'id' => $model->id
                                      ]) ?>"
                    data-method="POST"
                    data-confirm="<?= Yii::t('app/info', 'Removing an offer will delete all the related products. You confirm the removal?') ?>"
                ><?= Yii::t('app', 'Delete Offer') ?></a>
            </div>
            <h1><?= $model->title ?></h1>
            <h4><a href="<?= Url::to([
                                         'catalog/view-category',
                                         'id' => $model->categoryId
                                     ]) ?>"><?= Yii::t('app', 'Category').': '.$model->category->title ?></a></h4>
            <?php if(!empty($model->advantages)): ?>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?= nl2br($model->advantages) ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-warning"><?= Yii::t('app/error', 'Advantages not found') ?></div>
            <?php endif; ?>
            <?php if(empty($model->products)): ?>
                <div class="alert alert-info"><?= Yii::t('app/info', 'No products found') ?></div>
            <?php else: ?>
                <div class="row well well-sm">
                    <h3><?= Yii::t('app', 'Products') ?></h3>
                    <?php
                        $products = $model->getProducts()
                                          ->orderBy(['id' => SORT_DESC])
                                          ->all();
                        foreach($products as $prod):
                            ?>
                            <div class="col-lg-4">
                                <?= $this->render('inc/_product', ['product' => $prod]) ?>
                            </div>
                            <?php
                        endforeach;
                    ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="alert alert-danger"><?= Yii::t('app/error', 'No data for this language') ?></div>
        <?php endif; ?>
        <?php if(!empty($offerGallery)): ?>
            <div class="panel panel-primary">
                <div class="panel-heading"><p class="panel-title"><?= Yii::t('app', 'Gallery') ?></p></div>
                <div class="panel-body">
                    <div class="row">
                        <?php
                            foreach($offerGallery as $pic):
                                ?>
                                <div class="col-lg-4 img-wrap">
                                    <img
                                        src="<?= FileManager::getInstance()
                                                            ->getStorageUrl().$pic ?>"
                                        class="img-responsive img-thumbnail"
                                    >
                                </div>
                                <?php
                            endforeach;
                        ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info"><?= Yii::t('app/info', 'Gallery is Empty') ?></div>
        <?php endif; ?>
    </div>
    <div class="col-lg-2">
        <?= $this->render('_availableLangList', ['model' => $model]) ?>
    </div>
</div>
