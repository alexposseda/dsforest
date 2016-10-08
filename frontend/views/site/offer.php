<?php
    /**
     * @var \yii\web\View $this
     * @var \common\models\Offer $offer
     */

    use frontend\assets\OfferPageAsset;
    use yii\alexposseda\fileManager\FileManager;
    use yii\helpers\Url;

    OfferPageAsset::register($this);
    $gallery = json_decode($offer->gallery);

    $this->title = $offer->title;
?>
    <section class="section no-padding offer line">
        <h2 class="black white-text title subtitle no-margin truncate" id="catalog-title">
        <span class="hide-on-small-only">
            <a href="<?= Url::to(['site/catalog']) ?>">
                <?= Yii::t('app', 'Catalog') ?>
            </a>
            <i class="material-icons">navigate_next</i>
        </span>
            <a href="<?= Url::to([
                                     'site/catalog',
                                     'categoryId' => $offer->category->id
                                 ]) ?>">
                <?= $offer->category->title ?>
            </a>
            <i class="material-icons">navigate_next</i>
            <?= $offer->title ?>
        </h2>
        <?php if($offer->availableProducts): ?>
            <div class="row mygrid mygrid mygrid-centered">
                <?php foreach($offer->availableProducts as $product): ?>
                    <?= $this->render('product', ['product' => $product]); ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="card-panel red-text center-align"><?= Yii::t('info', 'No products found') ?></div>
        <?php endif; ?>
    </section>
<?php if(!empty($gallery)): ?>
    <section class="section line ">
        <div class="carousel-wrap">
            <button class="btn-floating hide-on-med-and-up black carousel-btn carousel-btn-left" id="carousel-btn-left"><i class="material-icons">navigate_before</i>
            </button>
            <button class="btn-floating hide-on-med-and-up black carousel-btn carousel-btn-right" id="carousel-btn-right"><i class="material-icons">navigate_next</i>
            </button>
            <div class="carousel">
                <?php foreach($gallery as $pic): ?>
                    <div class="carousel-item"><img src="<?= FileManager::getInstance()
                                                                        ->getStorageUrl().$pic ?>"></div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php
    if(!empty($offer->advantages)):
        $advantages = explode("\n", \yii\helpers\Html::encode($offer->advantages));
        ?>
        <section class="section">
            <h2 class="black white-text title subtitle center-align no-margin" id="advantage-title"><?= Yii::t('app', 'Advantages') ?></h2>
            <ul class="advantage-list browser-default" id="advantage-list">
                <?php foreach($advantages as $advantage): ?>
                    <li class="flow-text"><?= $advantage ?></li>
                <?php endforeach; ?>
            </ul>
        </section>
    <?php endif; ?>