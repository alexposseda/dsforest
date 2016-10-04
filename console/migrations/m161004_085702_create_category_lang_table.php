<?php

    use yii\db\Migration;

    /**
     * Handles the creation for table `category_lang`.
     */
    class m161004_085702_create_category_lang_table extends Migration{
        /**
         * @inheritdoc
         */
        public function up(){
            $tableOptions = null;
            if($this->db->driverName === 'mysql'){
                // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }

            $this->createTable('{{%category_lang}}', [
                'id'         => $this->primaryKey(),
                'categoryId' => $this->integer(),
                'language'   => $this->string(6)
                                     ->notNull(),
                'title'      => $this->string(12),
                'createdAt' => $this->integer()
                                    ->notNull(),
                'updatedAt' => $this->integer()
                                    ->notNull(),
            ], $tableOptions);

            $this->createIndex('CategoryLangIndex', '{{%category_lang}}', 'language');
            $this->addForeignKey('CategoryLang', '{{%category_lang}}', 'categoryId', '{{%category}}', 'id', 'CASCADE', 'CASCADE');
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropIndex('CategoryLangIndex', '{{%category_lang}}');
            $this->dropForeignKey('CategoryLang', '{{%category_lang}}');
            $this->dropTable('{{%category_lang}}');
        }
    }
