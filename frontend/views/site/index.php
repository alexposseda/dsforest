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
                                                   'category_id' => $category->id
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
            <div class="col s12 m6 l6">
                <h3>Представительство в Украине</h3>
                <p class="address flow-text">"ГК Форест" Украина,<br>65007 г.Одесса,<br>Болгарская 20</p>
                <div class="info">
                    <h4>Контакты</h4>
                    <ul>
                        <li class="flow-text"><i class="material-icons">phone</i> +38 048 788 18 51</li>
                        <li class="flow-text"><i class="material-icons">phone</i> +38 048 788 18 51</li>
                        <li class="flow-text"><i class="material-icons">phone</i> +38 048 788 18 51</li>
                        <li class="flow-text"><i class="material-icons">email</i> example@mail.com</li>
                        <li class="flow-text"><i class="material-icons">link</i> www.example.com</li>
                    </ul>
                </div>
            </div>
            <div class="col s12 m6 l6">
                <h3>Представительство в Чехии</h3>
                <p class="address flow-text">"ГК Форест" Украина,<br>65007 г.Одесса,<br>Болгарская 20</p>
                <div class="info">
                    <h4>Контакты</h4>
                    <ul>
                        <li class="flow-text"><i class="material-icons">phone</i> +38 048 788 18 51</li>
                        <li class="flow-text"><i class="material-icons">phone</i> +38 048 788 18 51</li>
                        <li class="flow-text"><i class="material-icons">phone</i> +38 048 788 18 51</li>
                        <li class="flow-text"><i class="material-icons">email</i> example@mail.com</li>
                        <li class="flow-text"><i class="material-icons">link</i> www.example.com</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
