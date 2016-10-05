<?php
    
    namespace common\models;
    
    use common\components\AvailableLangs;
    use common\components\MultiLangBehavior;
    use Yii;
    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;
    
    /**
     * This is the model class for table "{{%category}}".
     *
     * @property integer $id
     * @property string  $cover
     * @property integer $createdAt
     * @property integer $updatedAt
     *
     * @property Offer[] $offers
     */
    class Category extends ActiveRecord{
        
        public function behaviors(){
            return [
                'ml'                => [
                    'class'           => MultiLangBehavior::className(),
                    'languages'       => Lang::getLanguagesAsCodeTitle(),
                    'defaultLanguage' => Yii::$app->sourceLanguage,
                    'langForeignKey'  => 'categoryId',
                    'tableName'       => "{{%category_lang}}",
                    'attributes'      => [
                        'title',
                    ]
                ],
                'timestampBehavior' => [
                    'class'      => TimestampBehavior::className(),
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => [
                            'createdAt',
                            'updatedAt'
                        ],
                        ActiveRecord::EVENT_BEFORE_UPDATE => ['updatedAt'],
                    ]
                ],
                'availableLangs'    => [
                    'class' => AvailableLangs::className(),
                ]
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
                    'title',
                    'string'
                ],
                [
                    'title',
                    'default',
                    'value' => null
                ],
                [
                    [
                        'createdAt',
                        'updatedAt'
                    ],
                    'integer'
                ],
                [
                    ['cover', 'title'],
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
        public function getOffers(){
            return $this->hasMany(Offer::className(), ['categoryId' => 'id']);
        }
    }
