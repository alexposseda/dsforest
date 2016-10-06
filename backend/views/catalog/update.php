<?php
    /**
     * @var \yii\web\View                                                           $this
     * @var \common\models\Category | \common\models\Offer | \common\models\Product $model
     * @var string                                                                  $file
     */
    
    $this->title = Yii::t('app', 'Update').': '.$model->title;
    if(empty($this->title)){
        $this->title = Yii::t('error', 'Empty title');
    }
    $this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('inc/form_'.$file, ['model' => $model])?>
