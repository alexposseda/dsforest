<?php
    /**
     * @var \yii\web\View $this
     *
     */
    use yii\alexposseda\fileManager\FileManager;
    use yii\helpers\Url;

?>
<div class="row">
    <div class="col-lg-2">
        <div class="list-group">
            <a href="<?= Url::to(['catalog/create-category']) ?>" class="list-group-item"><?= Yii::t('app', 'Create Category') ?></a>
        </div>
    </div>
    <div class="col-lg-10">
        <?php if(!empty($models)): ?>
            <div class="row">
                <?php foreach($models as $category): ?>
                    <div class="col-lg-3">
                        <?php if($category->isAvailableTranslate(Yii::$app->language)): ?>
                            <div class="panel panel-default">
                                <div class="panel-heading"><p class="panel-title"><?= $category->title ?></p></div>
                                <div class="panel-body">
                                    <div class="category-cover-wrap">
                                        <?php
                                            $cover = json_decode($category->cover);
                                            if(!empty($cover)):
                                                ?>
                                                <img class="img-responsive img-thumbnail" src="<?= FileManager::getInstance()
                                                                                                              ->getStorageUrl().$cover[0] ?>">
                                                <?php
                                            else:
                                                ?>
                                                <img class="img-responsive img-thumbnail" src="<?= Url::to('/img/nopic.jpg', true) ?>">
                                                <?php
                                            endif;
                                        ?>
                                    </div>
                                </div>
                                <div class="panel-footer text-center">
                                    <a class="btn btn-sm btn-info btn-block" href="<?= Url::to([
                                                                                                   'catalog/view-category',
                                                                                                   'id' => $category->id
                                                                                               ]) ?>"><?= Yii::t('app', 'View Category') ?></a>
                                    <a class="btn btn-sm btn-warning btn-block" href="<?= Url::to([
                                                                                                      'catalog/update-category',
                                                                                                      'id' => $category->id
                                                                                                  ]) ?>"><?= Yii::t('app', 'Update Category') ?></a>
                                    <a
                                        class="btn btn-sm btn-danger btn-block"
                                        href="<?= Url::to([
                                                              'catalog/delete-category',
                                                              'id' => $category->id
                                                          ]) ?>"
                                        data-method="POST"
                                        data-confirm="<?= Yii::t('info',
                                                                 'Removing a category will delete all the related products and offers. You confirm the removal?') ?>"
                                    ><?= Yii::t('app', 'Delete Category') ?></a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="panel panel-danger">
                                <div class="panel-body">
                                    <div class="alert alert-danger"><?= Yii::t('app', 'No data for this language') ?></div>
                                    <a href="<?= Url::to([
                                                             'catalog/update-category',
                                                             'id' => $category->id
                                                         ]) ?>" class="btn btn-block btn-warning"><?= Yii::t('app', 'Update Category') ?></a>
                                </div>
                            </div>
                        
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info"><?= Yii::t('error', 'Categories not found') ?></div>
        <?php endif; ?>
    </div>
</div>
