<?php
    
    namespace common\components;
    
    use omgdef\multilingual\MultilingualBehavior;
    use Yii;
    
    class MultiLangBehavior extends MultilingualBehavior{
        public function createLangClass(){
            if(!class_exists($this->langClassName, false)){
                $namespace = substr($this->langClassName, 0, strrpos($this->langClassName, '\\'));
                eval('
            namespace '.$namespace.';
            use yii\db\ActiveRecord;
            use yii\behaviors\TimestampBehavior;
            class '.substr($this->langClassName, strrpos($this->langClassName, '\\') + 1).' extends ActiveRecord
            {
                public function behaviors(){
                    return [
                        \'timestampBehavior\' => [
                            \'class\'      => TimestampBehavior::className(),
                            \'attributes\' => [
                                ActiveRecord::EVENT_BEFORE_INSERT => [
                                    \'createdAt\',
                                    \'updatedAt\'
                                ],
                                ActiveRecord::EVENT_BEFORE_UPDATE => [\'updatedAt\'],
                            ]
                        ]
                    ];
                }
                public static function tableName()
                {
                    return \''.$this->tableName.'\';
                }
            }');
            }
        }
        
        public function checkLangs(){
            foreach($this->languages as $lang){
                if(!empty($this->getLangAttribute('title_'.$lang))){
                    return true;
                }
            }
            Yii::$app->session->setFlash('error', Yii::t('error', 'Fill at least one field title'));
            
            return false;
        }
        
        public function afterUpdate(){
            $langModels = $this->getTranslations()
                               ->all();
            foreach($langModels as $langModel){
                if(empty($this->getLangAttribute('title_'.$langModel->language))){
                    $langModel->delete();
                }
            }
            foreach($this->languages as $lang){
                $newLang = true;
                foreach($langModels as $langModel){
                    if($langModel->language == $lang){
                        $newLang = false;
                        foreach($langModel->attributes as $key => $attr){
                            $canSave = false;
                            if(!in_array($key, $this->attributes)){
                                continue;
                            }
                            if($langModel->getAttribute($key) != $this->getLangAttribute($key.'_'.$lang)){
                                $langModel->$key = $this->getLangAttribute($key.'_'.$lang);
                                $canSave          = true;
                            }
                            if($canSave){
                                $langModel->save();
                            }
                        }
                        break;
                    }
                }
                if($newLang && !empty($this->getLangAttribute('title_'.$lang))){
                    $translation                          = new $this->langClassName;
                    $translation->{$this->languageField}  = $lang;
                    $translation->{$this->langForeignKey} = $this->owner->getPrimaryKey();
                    foreach($this->attributes as $attr){
                        $translation->$attr = $this->getLangAttribute($attr.'_'.$lang);
                    }
                    
                    $translation->save();
                }
            }
            parent::afterUpdate();
        }
        
    }