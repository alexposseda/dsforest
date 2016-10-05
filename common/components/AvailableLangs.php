<?php
    
    namespace common\components;
   
    use common\models\Lang;
    use yii\base\Behavior;
    
    /**
     * Class AvailableLangs
     * @package common\components
     *
     */
    class AvailableLangs extends Behavior{
        protected $_availableLangs = [];
        protected $_languages      = [];
        public    $baseModel       = null;
        
        public function init(){
            $this->_languages = Lang::find()
                                    ->all();
            
            parent::init();
        }
        
        public function setBaseModel($model){
            $this->baseModel = $model;
            
            return $this->owner;
        }
    
        /**
         * @return Lang[]
         */
        public function getAvailableLangs(){
            if(empty($this->_availableLangs)){
                if(is_null($this->baseModel)){
                    $this->_availableLangs = $this->_languages;
                }else{
                    $baseModelLangs = $this->baseModel->translations;
                    
                    for($i = 0; $i < count($this->_languages); $i++){
                        foreach($baseModelLangs as $langModel){
                            if($langModel->language == $this->_languages[$i]->langCode){
                                $this->_availableLangs[] = $this->_languages[$i];
                                break;
                            }
                        }
                    }
                }
            }
            
            return $this->_availableLangs;
        }
        
        public function getNecessaryLangs(){
            $availableLangs = $this->getAvailableLangs();
            $necessaryLangs = [];
            $langModelClassName = $this->owner->langClassName;
            if($this->owner->isNewrecord){
                foreach($availableLangs as $lang){
                    $model = new $langModelClassName;
                    $model->language = $lang->langCode;
                    $necessaryLangs[] = $model;
                }
            }else{
                $currentLangs = $this->owner->translations;
                foreach($availableLangs as $availableLang){
                    $setLang = true;
                    foreach($currentLangs as $currentLang){
                        if($currentLang->language == $availableLang->langCode){
                            $necessaryLangs[] = $currentLang;
                            $setLang = false;
                            break;
                        }
                    }
                    if($setLang){
                        $model = new $langModelClassName;
                        $model->language = $availableLang->langCode;
                        $necessaryLangs[] = $model;
                    }
                }
            }
            
            return $necessaryLangs;
        }
        
        public function isAvailableTranslate($langCode){
            $availableTranslations = $this->owner->translations;
            foreach($availableTranslations as $tr){
                if($tr->language == $langCode){
                    return true;
                }
            }
            return false;
        }
    }