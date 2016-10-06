<?php

    namespace frontend\assets;

    use yii\web\AssetBundle;

    class OfferPageAsset extends AssetBundle{
        public $basePath = '@webroot';
        public $baseUrl = '@web';
        public $css = [];
        public $js = [
            'js/offerpage.js'
        ];
        public $depends = [
            'frontend\assets\AppAsset'
        ];
    }