<?php
    /**
     * @var \yii\web\View                                                           $this
     * @var \common\models\Category | \common\models\Offer | \common\models\Product $model
     * @var string                                                                  $file
     */
?>

<?= $this->render('inc/form_'.$file, ['model' => $model])?>
