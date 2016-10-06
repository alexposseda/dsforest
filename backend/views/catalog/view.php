<?php
    /**
     * @var \yii\web\View                                  $this
     * @var \common\models\Category | \common\models\Offer $model
     * @var string                                         $file    view file name
     */
    $this->title = $model->title;
    if(empty($this->title)){
        $this->title = Yii::t('error', 'Empty title');
    }
?>

<?= $this->render('inc/view_'.$file, ['model' => $model])?>
