<?php
    
    /* @var $this yii\web\View */
    
    use common\models\Category;
    
    $this->title = 'My Yii Application';
?>
<div class="site-index">
    
    <div class="jumbotron">
        <h1><?= Yii::t('app', 'Test') ?></h1>
        
        <p class="lead">You have successfully created your Yii-powered application.</p>
        
        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>
    
    <div class="body-content">
        <?php
            $model = Category::findOne(1);
            var_dump($model->title);
//            $langModel = new \common\models\CategoryLang();
            
            var_dump($model->getTranslations()->all());
        ?>
    
    </div>
</div>
