<?php
    
    namespace common\models;
    
    use common\components\AvailableLangs;
    use common\components\MultiLangBehavior;
    use Yii;
    use yii\alexposseda\fileManager\FileManager;
    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;
    
    /**
     * This is the model class for table "{{%offer}}".
     *
     * @property integer   $id
     * @property integer   $categoryId
     * @property string    $cover
     * @property string    $gallery
     * @property integer   $createdAt
     * @property integer   $updatedAt
     *
     * @property Category  $category
     * @property Product[] $products
     */
    class Offer extends ActiveRecord{
        
        public function behaviors(){
            return [
                'ml'                => [
                    'class'           => MultiLangBehavior::className(),
                    'languages'       => Lang::getLanguagesAsCodeTitle(),
                    'defaultLanguage' => Yii::$app->language,
                    'langForeignKey'  => 'offerId',
                    'tableName'       => "{{%offer_lang}}",
                    'attributes'      => [
                        'title',
                        'advantages'
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
            return '{{%offer}}';
        }
        
        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    ['title', 'advantages'],
                    'default',
                    'value' => null
                ],
                [
                    [
                        'categoryId',
                        'createdAt',
                        'updatedAt'
                    ],
                    'integer'
                ],
                [
                    [
                        'gallery',
                        'advantages'
                    ],
                    'string'
                ],
                [
                    [
                        'cover',
                        'title'
                    ],
                    'string',
                    'max' => 255
                ],
                [
                    ['categoryId'],
                    'exist',
                    'skipOnError'     => true,
                    'targetClass'     => Category::className(),
                    'targetAttribute' => ['categoryId' => 'id']
                ],
            ];
        }
        
        /**
         * @inheritdoc
         */
        public function attributeLabels(){
            return [
                'id'         => 'ID',
                'categoryId' => 'Category ID',
                'cover'      => Yii::t('app', 'Cover'),
                'gallery'    => Yii::t('app', 'Gallery'),
                'createdAt'  => 'Created At',
                'updatedAt'  => 'Updated At',
            ];
        }
        
        /**
         * @return \yii\db\ActiveQuery
         */
        public function getCategory(){
            return $this->hasOne(Category::className(), ['id' => 'categoryId']);
        }
        
        
        /**
         * @return \yii\db\ActiveQuery
         */
        public function getProducts(){
            return $this->hasMany(Product::className(), ['offerId' => 'id']);
        }
    
        public function afterSave($insert, $changedAttributes){
            $pictures = json_decode($this->gallery);
            if(!empty($pictures)){
                foreach($pictures as $pic){
                    FileManager::getInstance()
                               ->removeFromSession($pic);
                }
            }
        
            $cover = json_decode($this->cover);
            if(!empty($cover)){
                FileManager::getInstance()
                           ->removeFromSession($cover[0]);
            }
            
            return parent::afterSave($insert, $changedAttributes);
        }
    
        public function beforeDelete(){
            $this->deleteGalleryAndCover();
            foreach($this->products as $product){
                $product->deleteCover();
            }
            return parent::beforeDelete();
        }
        
        public function deleteGalleryAndCover(){
            
            $pictures = json_decode($this->gallery);
            if(!empty($pictures)){
                foreach($pictures as $pic){
                    FileManager::getInstance()
                               ->removeFile($pic);
                }
            }
            $cover = json_decode($this->cover);
            if(!empty($cover)){
                FileManager::getInstance()
                           ->removeFile($cover[0]);
            }
        }
    }
