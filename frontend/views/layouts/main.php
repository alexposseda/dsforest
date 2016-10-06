<?php
    
    /* @var $this \yii\web\View */
    /* @var $content string */
    
    use common\models\Category;
    use common\models\Lang;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use frontend\assets\AppAsset;
    
    $languages  = Lang::find()
                      ->all();
    $categories = Category::find()
                          ->all();
    
    AppAsset::register($this);
    
    function getLangLink($lang){
        $tmp    = [
            Yii::$app->controller->getRoute(),
            'language' => $lang
        ];
        $params = Yii::$app->request->getQueryParams();
        foreach($params as $k => $v){
            $tmp[$k] = $v;
        }
        
        return $tmp;
    }

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<header class="header">
    <div class="header-shadow">
        <div class="header-content">
            <div class="valign-wrapper full-height">
                <div class="valign full-width center-align">
                    <a href="<?= Url::home() ?>"><img src="<?= Url::to('/img/logo_big.png', true) ?>" class="logo_big"></a>
                    <p class="flow-text white-text"><?= Yii::t('info', 'By developing our technology, we are promoting your business') ?></p>
                </div>
            </div>
        </div>
        <div class="navbar">
            <nav class="transparent nav">
                <div class="nav-wrapper">
                    <a href="<?= Url::home() ?>" class="brand-logo center"><img src="<?= Url::to('/img/logo_small_white.png', true) ?>" class="logo"></a>
                    <a href="#" data-activates="mobile-menu" class="button-collapse"><i class="material-icons">menu</i></a>
                    <a class="dropdown-button right hide-on-large-only" href="#" data-activates="mobile-languages"><i
                            class="material-icons">language</i></a>
                    <ul class="hide-on-med-and-down menu center">
                        <li><a href="<?= Url::to(['site/catalog']) ?>"><?= Yii::t('app', 'Catalog') ?></a></li>
                        <li><a class="dropdown-button" href="#" data-activates="languages"><i class="material-icons">language</i></a></li>
                        <li><a href="<?= Url::to([
                                                     'site/index',
                                                     '#' => 'contacts'
                                                 ]) ?>"><?= Yii::t('app', 'Contacts') ?></a></li>
                    </ul>
                </div>
            </nav>
            <ul id="languages" class="dropdown-content">
                <?php foreach($languages as $lang): ?>
                    <li><a href="<?= Url::to(getLangLink($lang['langCode'])) ?>"
                           class="tooltipped waves-effect waves-green <?= (Yii::$app->language == $lang->langCode) ? 'active' : '' ?>"
                           data-position="right" data-delay="50" data-tooltip="<?= $lang->langTitle ?>"><span
                                class="lang-icon lang-icon-<?= $lang->langCode ?>"></span></a></li>
                <?php endforeach; ?>
            </ul>
            <ul id="mobile-languages" class="dropdown-content">
                <?php foreach($languages as $lang): ?>
                    <li><a href="<?= Url::to(getLangLink($lang['langCode'])) ?>"
                           class="tooltipped waves-effect waves-green <?= (Yii::$app->language == $lang->langCode) ? 'active' : '' ?>"
                           data-position="left" data-delay="50" data-tooltip="<?= $lang->langTitle ?>"><span
                                class="lang-icon lang-icon-<?= $lang->langCode ?>"></span></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</header>
<div class="header-space"></div>
<ul id="mobile-menu" class="side-nav">
    <li><a href="<?= Url::home() ?>" class="brand-logo waves-effect center-align"><img src="<?= Url::to('/img/logo_small_black.png', true) ?>"
                                                                                       class="logo"></a></li>
    <li class="divider"></li>
    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li class="active">
                <a href="#" class="waves-effect collapsible-header"><i class="material-icons">view_list</i><?= Yii::t('app', 'Catalog') ?></a>
                <div class="collapsible-body">
                    <ul>
                        <li class="divider"></li>
                        <?php
                            foreach($categories as $category):
                                if($category->isAvailableTranslate(Yii::$app->language)):
                                    ?>
                                    <li><a class="active waves-effect" href="<?= Url::to([
                                                                                             'site/catalog',
                                                                                             'categoryId' => $category->id
                                                                                         ]) ?>"><?= $category->title ?></a></li>
                                    <?php
                                endif;
                            endforeach;
                        ?>
                        <li class="divider"></li>
                    </ul>
                </div>
            </li>
        
        </ul>
    </li>
    <li><a href="<?= Url::to([
                                 'site/index',
                                 '#' => 'contacts'
                             ]) ?>" class="waves-effect"><i class="material-icons">contacts</i><?= Yii::t('app', 'Contacts') ?></a></li>
</ul>
<main>
    <?= $content ?>
</main>
<footer class="footer center-align">
    <button class="btn-floating waves-effect waves-light black" id="to-top"><i class="material-icons">expand_less</i></button>
    <p class="copyright">&copy; DSForest Trade. All rights reserved.</p>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
