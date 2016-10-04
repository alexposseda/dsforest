<?php

    use yii\db\Migration;

    /**
     * Handles the creation for table `lang`.
     */
    class m161004_083542_create_lang_table extends Migration{
        /**
         * @inheritdoc
         */
        public function up(){
            $tableOptions = null;
            if($this->db->driverName === 'mysql'){
                // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }

            $this->createTable('{{%lang}}', [
                'id'        => $this->primaryKey(),
                'langCode'  => $this->string()
                                    ->notNull()
                                    ->unique(),
                'langTitle' => $this->string()
                                    ->notNull(),
                'createdAt' => $this->integer()
                                    ->notNull(),
                'updatedAt' => $this->integer()
                                    ->notNull(),
            ], $tableOptions);

            $createdTime = time();
            $this->batchInsert('{{%lang}}', [
                                              'langCode',
                                              'langTitle',
                                              'createdAt',
                                              'updatedAt'
                                          ], [
                                   [
                                       'en',
                                       'english',
                                       $createdTime,
                                       $createdTime
                                   ],
                                   [
                                       'ru',
                                       'русский',
                                       $createdTime,
                                       $createdTime
                                   ],
                                   [
                                       'de',
                                       'deutsch',
                                       $createdTime,
                                       $createdTime
                                   ],
                                   [
                                       'fr',
                                       'français',
                                       $createdTime,
                                       $createdTime
                                   ],
                                   [
                                       'it',
                                       'italiano',
                                       $createdTime,
                                       $createdTime
                                   ],
                                   [
                                       'po',
                                       'polski',
                                       $createdTime,
                                       $createdTime
                                   ],
                                   [
                                       'cs',
                                       'čeština',
                                       $createdTime,
                                       $createdTime
                                   ],
                               ]);
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropTable('{{%lang}}');
        }
    }
