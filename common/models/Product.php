<?php
    
    namespace common\models;
    
    use common\components\AvailableLangs;
    use common\components\MultiLangBehavior;
    use Yii;
    use yii\alexposseda\fileManager\FileManager;
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
                    'class'           => MultiLangBehavior::className(),
                    'languages'       => Lang::getLanguagesAsCodeTitle(),
                    'defaultLanguage' => Yii::$app->language,
                    'langForeignKey'  => 'productId',
                    'tableName'       => "{{%product_lang}}",
                    'attributes'      => [
                        'title'
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
            return '{{%product}}';
        }
        
        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    'title',
                    'default',
                    'value' => null
                ],
                [
                    [
                        'offerId',
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
    
        public function afterSave($insert, $changedAttributes){
            $cover = json_decode($this->cover);
            if(!empty($cover)){
                FileManager::getInstance()
                           ->removeFromSession($cover[0]);
            }
        
            return parent::afterSave($insert, $changedAttributes);
        }
    
        public function beforeDelete(){
            $this->deleteCover();
        
            return parent::beforeDelete();
        }
        public function deleteCover(){
            $cover = json_decode($this->cover);
            if(!empty($cover)){
                FileManager::getInstance()
                           ->removeFile($cover[0]);
            }
        }
    }
