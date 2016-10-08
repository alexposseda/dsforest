<?php
    /**
     * @var \yii\web\View                                  $this
     * @var \common\models\Lang[]                          $availableLanguages
     * @var \common\models\Category | \common\models\Offer $model
     */
    use yii\helpers\Url;
    
    $availableLanguages = $model->availableLangs;
?>
<div class="available-lang-holder" data-spy="affix" data-offset-top="60" data-offset-bottom="70">
    <h6><?= Yii::t('info', 'Available in languages') ?></h6>
    <div class="list-group">
        <?php foreach($availableLanguages as $lang): ?>
            <?php if($model->isAvailableTranslate($lang->langCode)): ?>
                <?php if($lang->langCode == Yii::$app->language): ?>
                    <div class="list-group-item list-group-item-info">
                        <?= $lang->langTitle ?>
                        <span class="glyphicon glyphicon-ok pull-right"></span>
                    </div>
                <?php else: ?>
                    <a class="list-group-item list-group-item-success"
                       href="<?= Url::to([
                                             Yii::$app->controller->getRoute(),
                                             'language' => $lang->langCode,
                                             'id'       => $model->id
                                         ]) ?>">
                        <?= $lang->langTitle ?>
                        <span class="glyphicon glyphicon-ok pull-right"></span>
                    </a>
                <?php endif; ?>
            <?php else: ?>
                <div class="list-group-item list-group-item-danger">
                    <?= $lang->langTitle ?>
                </div>
            <?php endif; ?>
        
        <?php endforeach; ?>
    </div>
</div>
