<?php

    namespace frontend\assets;

    use yii\web\AssetBundle;

    class HomePageAsset extends AssetBundle{
        public $basePath = '@webroot';
        public $baseUrl = '@web';
        public $css = [];
        public $js = [
            'js/homepage.js'
        ];
        public $depends = [
            'frontend\assets\AppAsset'
        ];
    }