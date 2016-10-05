<?php
    /**
     * @var \yii\web\View                                  $this
     * @var \common\models\Category | \common\models\Offer $model
     */
    use yii\alexposseda\fileManager\FileManager;
    use yii\helpers\Url;
    
    $this->params['breadcrumbs'][] = $this->title;
    
    $categoryCover = json_decode($model->cover);
?>

<div class="row">
    <div class="col-lg-2 text-center category-icon">
        <div class="category-icon-holder" data-spy="affix" data-offset-top="60" data-offset-bottom="70">
            <div>
                <?php if(!empty($categoryCover)):?>
                    <img class="img-responsive img-thumbnail" src="<?= FileManager::getInstance()
                                                                                  ->getStorageUrl().$categoryCover[0] ?>">
                <?php else:?>
                    <img class="img-responsive img-thumbnail" src="<?= Url::to('/img/nopic.jpg', true)?>">
                <?php endif;?>
            </div>
            <br>
            <div class="list-group">
                <?php if($model->isAvailableTranslate(Yii::$app->language)): ?>
                    <a href="<?= Url::to([
                                             'catalog/create-offer',
                                             'categoryId' => $model->id
                                         ]) ?>" class="list-group-item list-group-item-success"><?= Yii::t('app', 'Add offer') ?></a>
                <?php else: ?>
                    <a href="<?= Url::to([
                                             'catalog/update-category',
                                             'id' => $model->id
                                         ]) ?>" class="list-group-item list-group-item-warning"><?= Yii::t('app', 'Update Category') ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-10">
        <div class="row">
            <div class="col-lg-10">
                <div class="btn-group btn-group-sm pull-right">
                    <a class="btn btn-sm btn-warning" href="<?= Url::to([
                                                                            'catalog/update-category',
                                                                            'id' => $model->id
                                                                        ]) ?>"><?= Yii::t('app', 'Update Category') ?></a>
                    <a
                        class="btn btn-sm btn-danger"
                        href="<?= Url::to([
                                              'catalog/delete-category',
                                              'id' => $model->id
                                          ]) ?>"
                        data-method="POST"
                        data-confirm="<?= Yii::t('app',
                                                 'Removing a category will delete all the related products and offers. You confirm the removal?') ?>"
                    ><?= Yii::t('app', 'Delete Category') ?></a>
                </div>
                <?php if($model->isAvailableTranslate(Yii::$app->language)): ?>
                    <h1><?= $model->title ?></h1>
                    <?php if(empty($model->offers)): ?>
                        <div class="alert alert-info"><?= Yii::t('app', 'There are no results for this category offers') ?></div>
                    <?php else: ?>
                        <?php
                        $offers = $model->getOffers()
                                           ->orderBy(['id' => SORT_DESC])
                                           ->all();
                        foreach($offers as $offer):
                            ?>
                            <?= $this->render('inc/_offer', ['offer' => $offer]) ?>
                            <?php
                        endforeach;
                        ?>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="clearfix"></div>
                    <br>
                    <div class="alert alert-danger"><?= Yii::t('app', 'There is no data for this language!') ?></div>
                <?php endif; ?>
            </div>
            <div class="col-lg-2 text-center available-lang">
                <?= $this->render('_availableLangList', ['model' => $model])?>
            </div>
        </div>
    </div>
</div>
