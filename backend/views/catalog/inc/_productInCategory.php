<?php
    /**
     * @var \yii\web\View          $this
     * @var \common\models\Product $model
     */
    use yii\alexposseda\fileManager\FileManager;
    use yii\helpers\Url;
    $productCover = json_decode($model->cover);
?>
<?php if($model->isAvailableTranslate(Yii::$app->language)):?>
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title text-center"><?= $model->title ?></h3></div>
    <div class="panel-body">
        <?php if(!empty($productCover)): ?>
            <img class="img-responsive img-thumbnail" src="<?= FileManager::getInstance()
                                                                          ->getStorageUrl().$productCover[0] ?>">
        <?php else: ?>
            <img class="img-responsive img-thumbnail" src="<?= Url::to('/img/nopic.jpg', true) ?>">
        <?php endif; ?>
    </div>
    <div class="panel-footer text-center">
        <a href="<?= Url::to([
                                 'catalog/update-product',
                                 'id'   => $model->id,
                             ]) ?>" class="btn btn-block btn-sm btn-warning"><?= Yii::t('app', 'Update Product') ?></a>
        <a href="<?= Url::to([
                                 'catalog/view-product',
                                 'id' => $model->id
                             ]) ?>" class="btn btn-block btn-sm btn-info"><?= Yii::t('app', 'View Product') ?></a>
        <a href="<?= Url::to([
                                 'catalog/delete-product',
                                 'id'   => $model->id,
                             ]) ?>" class="btn btn-block btn-sm btn-danger" data-method="POST"
           data-confirm="<?= Yii::t('info', 'You confirm the removal?') ?>"><?= Yii::t('app', 'Delete Product') ?></a>
    </div>
</div>
<?php else: ?>
    <div class="panel panel-danger">
        <div class="panel-body">
            <div class="alert alert-danger"><?= Yii::t('error', 'No data for this language')?></div>
        </div>
        <div class="panel-footer">
            <a href="<?= Url::to([
                                     'catalog/update-product',
                                     'id'   => $model->id,
                                 ]) ?>" class="btn btn-block btn-sm btn-warning"><?= Yii::t('app', 'Update Product') ?></a>
        </div>
    </div>
<?php endif; ?>
