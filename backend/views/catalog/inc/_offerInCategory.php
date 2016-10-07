<?php
    /**
     * @var \yii\web\View        $this
     * @var \common\models\Offer $model
     */
    use yii\alexposseda\fileManager\FileManager;
    use yii\helpers\Url;
    
    $offerCover = json_decode($model->cover);
    $offerGallery = json_decode($model->gallery);

?>
<div class="panel panel-default small-panel">
    <?php if($model->isAvailableTranslate(Yii::$app->language)): ?>
        <div class="panel-heading">
            <a href="<?= Url::to([
                                     'catalog/view-offer',
                                     'id' => $model->id
                                 ]) ?>" class="pull-right btn btn-default">
                <span class="glyphicon glyphicon-circle-arrow-right"></span>
            </a>
            <h4><?= $model->title ?></h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-9">
                    <?php if(!empty($model->advantages)): ?>
                        <div class="well well-sm">
                            <?= nl2br($model->advantages) ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning"><?= Yii::t('info', 'Advantages not found') ?></div>
                    <?php endif; ?>
                    <br>
                    <?php if(!empty($model->products)): ?>
                        <div class="row">
                            <?php foreach($model->products as $product):?>
                                <div class="col-lg-6">
                                    <?= $this->render('_productInCategory', ['model' => $product])?>
                                </div>
                            <?php endforeach;?>
                        </div>
                    <?php else: ?>
                        
                        <div class="alert alert-info"><?= Yii::t('info', 'Products for this offer is not found') ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-lg-3">
                    <?php if(!empty($offerCover)):?>
                        <img class="img-responsive img-thumbnail" src="<?= FileManager::getInstance()
                                                                                      ->getStorageUrl().$offerCover[0] ?>">
                    <?php else:?>
                        <img class="img-responsive img-thumbnail" src="<?= Url::to('/img/nopic.jpg', true)?>">
                    <?php endif;?>
                </div>
            </div>
            <?php if(!empty($offerGallery)):?>
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
            <?php else:?>
                <div class="alert alert-info"><?= Yii::t('info', 'Gallery is empty')?></div>
            <?php endif;?>
        </div>
        <div class="panel-footer">
            <div class="btn-group btn-group-sm">
                <a class="btn btn-sm btn-primary" href="<?= Url::to([
                                                                        'catalog/create-product',
                                                                        'offerId' => $model->id,
                                                                    ]) ?>"><?= Yii::t('app', 'Create Product') ?></a>
                <a class="btn btn-sm btn-warning" href="<?= Url::to([
                                                                        'catalog/update-offer',
                                                                        'id' => $model->id,
                                                                    ]) ?>"><?= Yii::t('app', 'Update Offer') ?></a>
                <a
                    class="btn btn-sm btn-danger"
                    href="<?= Url::to([
                                          'catalog/delete-offer',
                                          'id' => $model->id
                                      ]) ?>"
                    data-method="POST"
                    data-confirm="<?= Yii::t('info', 'Removing an offer will delete all the related products. You confirm the removal?') ?>"
                ><?= Yii::t('app', 'Delete Offer') ?></a>
            </div>
        </div>
    <?php else: ?>
        <div class="panel-body">
            <div class="alert alert-danger"><?= Yii::t('error', 'For a given language offers not found') ?></div>
            <div class="text-center">
                <div class="btn-group btn-group-sm">
                    <a class="btn btn-sm btn-warning" href="<?= Url::to([
                                                                            'catalog/update-offer',
                                                                            'id' => $model->id,
                                                                        ]) ?>"><?= Yii::t('app', 'Update Offer') ?></a>
                    <a
                        class="btn btn-sm btn-danger"
                        href="<?= Url::to([
                                              'catalog/delete-offer',
                                              'id' => $model->id,
                                          ]) ?>"
                        data-method="POST"
                        data-confirm="<?= Yii::t('info', 'Removing an offer will delete all the related products. You confirm the removal?') ?>"
                    ><?= Yii::t('app', 'Delete Offer') ?></a>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>
