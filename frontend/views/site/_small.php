<?php
    /**
     * @var \yii\web\View $this
     * @var \common\models\Category | \common\models\Offer $model ;
     * @var string $url
     */
    use yii\alexposseda\fileManager\FileManager;
    use yii\helpers\Url;

    $cover = json_decode($model->cover);
?>
<div class="col s12 m3 l2">
    <a href="<?= $url?>">
        <div class="card card-medium hoverable">
            <div class="card-image">
                <?php if(!empty($cover)): ?>
                    <img src="<?= FileManager::getInstance()
                                             ->getStorageUrl().$cover[0] ?>" alt="<?= $model->title ?>">
                <?php else: ?>
                    <img src="<?= Url::to('/img/nopic.jpg', true) ?>" alt="no category cover">
                <?php endif; ?>
                <span class="card-title white-text center-align"><?= $model->title ?></span>
            </div>
        </div>
    </a>
</div>
