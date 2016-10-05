<?php
    
    namespace common\models;
    
    use omgdef\multilingual\MultilingualBehavior;
    use Yii;
    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;
    
    /**
     * This is the model class for table "{{%product}}".
     *
     * @property integer $id
     * @property integer $offerId
     * @property string  $cover
     * @property integer $createdAt
     * @property integer $updatedAt
     *
     * @property Offer   $offer
     */
    class Product extends ActiveRecord{
        
        public function behaviors(){
            return [
                'ml' => [
                    'class'           => MultilingualBehavior::className(),
                    'languages'       => Lang::getLanguagesAsCodeTitle(),
                    'defaultLanguage' => Yii::$app->sourceLanguage,
                    'langForeignKey'  => 'productId',
                    'tableName'       => "{{%product_lang}}",
                    'attributes'      => [
                        'title'
                    ]
                ],
                [
                    'class'      => TimestampBehavior::className(),
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => [
                            'createdAt',
                            'updatedAt'
                        ],
                        ActiveRecord::EVENT_BEFORE_UPDATE => ['updatedAt'],
                    ]
                ]
            ];
        }
        
        /**
         * @inheritdoc
         */
        public static function tableName(){
            return '{{%product}}';
        }
        
        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    [
                        'offerId',
                        'createdAt',
                        'updatedAt'
                    ],
                    'integer'
                ],
                [
                    [
                        'createdAt',
                        'updatedAt'
                    ],
                    'required'
                ],
                [
                    ['cover'],
                    'string',
                    'max' => 255
                ],
                [
                    ['offerId'],
                    'exist',
                    'skipOnError'     => true,
                    'targetClass'     => Offer::className(),
                    'targetAttribute' => ['offerId' => 'id']
                ],
            ];
        }
        
        /**
         * @inheritdoc
         */
        public function attributeLabels(){
            return [
                'id'        => 'ID',
                'offerId'   => 'Offer ID',
                'cover'     => Yii::t('app', 'Cover'),
                'createdAt' => 'Created At',
                'updatedAt' => 'Updated At',
            ];
        }
        
        /**
         * @return \yii\db\ActiveQuery
         */
        public function getOffer(){
            return $this->hasOne(Offer::className(), ['id' => 'offerId']);
        }
        
    }
