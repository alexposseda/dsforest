<?php
    
    namespace common\widgets;
    
    use common\models\Lang;
    use Yii;
    use yii\base\Widget;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;
    
    class ChangeLang extends Widget{
        protected $_languages;
        public    $options = [];
        
        public function init(){
            parent::init();
            $this->_languages = ArrayHelper::map(Lang::find()
                                                     ->all(), 'langCode', 'langTitle');
        }
        
        public function run(){
            return $this->renderList();
        }
        
        protected function renderItem($lang, $options){
            if(empty($options)){
                $options = [];
                $wrapperOptions = [];
            }else{
                if(isset($options['wrapperOptions'])){
                    $wrapperOptions = $options['wrapperOptions'];
                    unset($options['wrapperOptions']);
                }else{
                    $wrapperOptions = [];
                }
            }
            
            if($this->isItemActive($lang)){
                Html::addCssClass($options, 'active');
            }
            $link = Html::a($this->_languages[$lang], $this->getLangLink($lang), $options);
            
            return Html::tag('li', $link, $wrapperOptions);
        }
        
        protected function renderList(){
            if(!isset($this->options['listOptions'])){
                $this->options['listOptions'] = [];
            }
            $list         = Html::beginTag('ul', $this->options['listOptions']);
            $listElements = [];
            
            foreach($this->_languages as $langCode => $langName){
                $listElements[] = $this->renderItem($langCode, $this->options['linkOptions']);
            }
            
            return $list."\n".implode("\n", $listElements).Html::endTag('ul');
        }
        
        protected function isItemActive($lang){
            return Yii::$app->language == $lang;
        }
        
        protected function getLangLink($lang){
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
    }