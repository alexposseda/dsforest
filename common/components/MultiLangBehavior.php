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
            Yii::$app->session->setFlash('error', Yii::t('app/error', 'Fill at least one field title'));
            return false;
        }
    
        public function afterUpdate(){
            $langModels = $this->getTranslations()->all();
            foreach($langModels as $langModel){
                if(empty($this->getLangAttribute('title_'.$langModel->language))){
                    $langModel->delete();
                }
            }
            
            parent::afterUpdate();
        }
    }