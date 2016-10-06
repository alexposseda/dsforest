<?php
    /**
     * @var \yii\web\View          $this
     * @var \common\models\Product $product
     */
    use yii\alexposseda\fileManager\FileManager;
    use yii\helpers\Url;
    $cover = json_decode($product->cover);
?>
<div class="col s12 m3 l2">
    <div class="card card-medium hoverable">
        <div class="card-title-wrap">
            <p class="card-title"><?= $product->title?></p>
        </div>
        <div class="card-image">
            <?php if(!empty($cover)): ?>
                <img src="<?= FileManager::getInstance()
                                         ->getStorageUrl().$cover[0] ?>" alt="<?= $product->title ?>">
            <?php else: ?>
                <img src="<?= Url::to('/img/nopic.jpg', true) ?>" alt="no category cover">
            <?php endif; ?>
        </div>
    </div>
</div>
