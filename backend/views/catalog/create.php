<?php
    /**
     * @var \yii\web\View                                                           $this
     * @var \common\models\Category | \common\models\Offer | \common\models\Product $model
     * @var string                                                                  $file
     */
    
    $this->title = Yii::t('app', 'Create '.ucfirst(substr(Yii::$app->controller->action->id, strpos(Yii::$app->controller->action->id, '-')+1)));
    $this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('inc/form_'.$file, ['model' => $model])?>
