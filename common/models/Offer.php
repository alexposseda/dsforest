<?php

    namespace common\models;

    use common\components\MultiLangBehavior;
    use Yii;
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
                'ml' => [
                    'class'           => MultiLangBehavior::className(),
                    'languages'       => Lang::getLanguagesAsCodeTitle(),
                    'defaultLanguage' => Yii::$app->sourceLanguage,
                    'langForeignKey'  => 'offerId',
                    'tableName'       => "{{%offer_lang}}",
                    'attributes'      => [
                        'title',
                        'advantages'
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
            return '{{%offer}}';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    [
                        'categoryId',
                        'createdAt',
                        'updatedAt'
                    ],
                    'integer'
                ],
                [
                    ['gallery', 'advantages'],
                    'string'
                ],
                [
                    ['cover', 'title'],
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
                'cover'      => Yii::t('app','Cover'),
                'gallery'    => Yii::t('app','Gallery'),
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
    }
