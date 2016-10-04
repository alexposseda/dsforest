<?php
    
    namespace common\models;
    
    use Yii;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "{{%lang}}".
     *
     * @property integer $id
     * @property string  $langCode
     * @property string  $langTitle
     * @property integer $createdAt
     * @property integer $updatedAt
     */
    class Lang extends ActiveRecord{
        /**
         * @inheritdoc
         */
        public static function tableName(){
            return '{{%lang}}';
        }
        
        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    [
                        'langCode',
                        'langTitle',
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
                    ['langCode'],
                    'string',
                    'max' => 4
                ],
                [
                    ['langTitle'],
                    'string',
                    'max' => 12
                ],
                [
                    ['langCode'],
                    'unique'
                ],
            ];
        }
        
        /**
         * @inheritdoc
         */
        public function attributeLabels(){
            return [
                'id'        => 'ID',
                'langCode'  => 'Lang Code',
                'langTitle' => 'Lang Title',
                'createdAt' => 'Created At',
                'updatedAt' => 'Updated At',
            ];
        }
        
    }