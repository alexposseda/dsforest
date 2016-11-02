<?php
    /**
     * @var \yii\web\View             $this
     * @var \common\models\Category[] $categories
     */
    
    use frontend\assets\HomePageAsset;
    use yii\helpers\Url;
    
    HomePageAsset::register($this);
    
    $this->title = 'DsForest Trade';

?>
<section class="section catalog no-padding">
    <h2 class="black white-text center-align title no-margin" id="catalog-title"><?= Yii::t('info', 'A wide range of wood products') ?></h2>
    <?php if(!empty($categories)): ?>
        <div class="row mygrid mygrid-centered">
            <?php
                foreach($categories as $category):
                    if($category->isAvailableTranslate(Yii::$app->language)):
                        echo $this->render('_small', [
                            'model' => $category,
                            'url'   => Url::to([
                                                   'site/catalog',
                                                   'categoryId' => $category->id
                                               ])
                        ]);
                    endif;
                endforeach;
            ?>
        </div>
    <?php else: ?>
        <div class="card-panel red-text center-align"><?= Yii::t('info', 'No category found') ?></div>
    <?php endif; ?>
</section>
<section class="section contacts">
    <h2 class="black white-text center-align title no-margin" id="contacts"><?= Yii::t('app', 'Contacts') ?></h2>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <h3><?= Yii::t('info', 'Representation in the Czech Republic')?></h3>
                <p class="address flow-text">"DS Forest Trade" S.R.O.,<br>Czech Republic, Prague,<br>Vojtesska 211/6
                    Nove Mesto 11000 Prague 1 CR</p>
                <div class="info">
                    <h4><?= Yii::t('app', 'Contacts')?></h4>
                    <ul>
                        <li class="flow-text"><i class="material-icons">phone</i> +42 077 635 77 27</li>
                        <li class="flow-text"><i class="material-icons">email</i> info@dsft.eu</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
