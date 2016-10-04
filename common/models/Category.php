<?php
    
    namespace common\models;
    
    use omgdef\multilingual\MultilingualBehavior;
    use Yii;
    use yii\db\ActiveRecord;
    use yii\helpers\ArrayHelper;

    /**
     * This is the model class for table "{{%category}}".
     *
     * @property integer        $id
     * @property string         $cover
     * @property integer        $createdAt
     * @property integer        $updatedAt
     *
     * @property CategoryLang[] $categoryLangs
     * @property Offer[]        $offers
     */
    class Category extends ActiveRecord{
        
        public function behaviors(){
            return [
                'ml' => [
                    'class'           => MultilingualBehavior::className(),
                    'languages'       => ArrayHelper::map(Lang::find()->all(), 'langCode', 'langTitle'),
                    //'languageField' => 'language',
                    //'localizedPrefix' => '',
                    //'requireTranslations' => false',
                    //'dynamicLangClass' => true',
                    //'langClassName' => PostLang::className(), // or namespace/for/a/class/PostLang
                    'defaultLanguage' => Yii::$app->sourceLanguage,
                    'langForeignKey'  => 'categoryId',
                    'tableName'       => "{{%category_lang}}",
                    'attributes'      => [
                        'title',
                    ]
                ],
            ];
        }
        
        /**
         * @inheritdoc
         */
        public static function tableName(){
            return '{{%category}}';
        }
        
        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    [
                        'createdAt',
                        'updatedAt'
                    ],
                    'required'
                ],
                [
                    [
                        'createdAt',
                        'updatedAt'
                    ],
                    'integer'
                ],
                [
                    ['cover'],
                    'string',
                    'max' => 255
                ],
            ];
        }
        
        /**
         * @inheritdoc
         */
        public function attributeLabels(){
            return [
                'id'        => 'ID',
                'cover'     => 'Cover',
                'createdAt' => 'Created At',
                'updatedAt' => 'Updated At',
            ];
        }
        
        /**
         * @return \yii\db\ActiveQuery
         */
        //        public function getCategoryLangs(){
        //            return $this->hasMany(CategoryLang::className(), ['categoryId' => 'id']);
        //        }
        
        /**
         * @return \yii\db\ActiveQuery
         */
        //        public function getOffers(){
        //            return $this->hasMany(Offer::className(), ['categoryId' => 'id']);
        //        }
    }
