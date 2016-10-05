<?php
    
    /* @var $this yii\web\View */
    
    use common\models\Category;
    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;
    
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
//            $langModels = $model->getTranslations()->all();
//            foreach($langModels as $key => $model){
//                $model->attachBehavior('timestampBehavior' ,[
//                                   'class'      => TimestampBehavior::className(),
//                                   'attributes' => [
//                                       ActiveRecord::EVENT_BEFORE_INSERT => [
//                                           'createdAt',
//                                           'updatedAt'
//                                       ],
//                                       ActiveRecord::EVENT_BEFORE_UPDATE => ['updatedAt'],
//                                   ]
//                               ]);
//            }
            var_dump($model->isAvailableTranslate(Yii::$app->language));
            var_dump($model->availableLangs);
            var_dump($model->necessaryLangs);
        ?>
    
    </div>
</div>
