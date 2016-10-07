<?php
    /**
     * @var \yii\web\View             $this
     * @var \common\models\Category[] $categories
     * @var \common\models\Category   $currentCategory
     */
    use yii\helpers\Url;
    
    $this->title = Yii::t('app', 'Catalog');
?>
<section class="section catalog no-padding">
    <h2 class="black white-text title subtitle no-margin truncate" id="catalog-title"><span class="hide-on-small-only"><?= Yii::t('app', 'Catalog') ?>
            <i class="material-icons">navigate_next</i></span>
        <?= $currentCategory->title ?></h2>
    <div class="row">
        <div class="col l2 hide-on-med-and-down">
            <?php if(!empty($categories)): ?>
                <div class="collection">
                    <?php
                        foreach($categories as $i => $category):
                            if($category->isAvailableTranslate(Yii::$app->language)):
                                if(empty(Yii::$app->request->get('categoryId'))):
                                    ?>
                                    <a href="<?= Url::to([
                                                             'site/catalog',
                                                             'categoryId' => $category->id
                                                         ]) ?>" class="collection-item <?= ($i == 0) ? 'active' : '' ?>"><?= $category->title ?></a>
                                    <?php
                                else:
                                    ?>
                                    <a href="<?= Url::to([
                                                             'site/catalog',
                                                             'categoryId' => $category->id
                                                         ]) ?>"
                                       class="collection-item <?= (Yii::$app->request->get('categoryId') == $category->id) ? 'active' : '' ?>"><?= $category->title ?></a>
                                    <?php
                                endif;
                            endif;
                        endforeach;
                    ?>
                </div>
            <?php else: ?>
                <div class="card-panel red-text center-align"><?= Yii::t('info', 'No category found') ?></div>
            <?php endif; ?>
        </div>
        <div class="col s12 m12 l10">
            
            <?php if(!empty($currentCategory->availableOffers)): ?>
                <div class="row no-margin-bottom mygrid">
                    <?php foreach($currentCategory->availableOffers as $offer): ?>
                        <?= $this->render('_small', [
                            'model' => $offer,
                            'url'   => Url::to([
                                                   'site/offer',
                                                   'id' => $offer->id
                                               ])
                        ]) ?>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="card-panel red-text center-align"><?= Yii::t('info', 'No offer found') ?></div>
            <?php endif; ?>
        </div>
    </div>
</section>
