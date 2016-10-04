<?php

    use yii\db\Migration;

    /**
     * Handles the creation for table `product_lang`.
     */
    class m161004_090502_create_product_lang_table extends Migration{
        /**
         * @inheritdoc
         */
        public function up(){
            $tableOptions = null;
            if($this->db->driverName === 'mysql'){
                // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }

            $this->createTable('{{%product_lang}}', [
                'id'        => $this->primaryKey(),
                'productId' => $this->integer(),
                'language'  => $this->string()
                                    ->notNull(),
                'title'     => $this->string(),
                'createdAt' => $this->integer()
                                    ->notNull(),
                'updatedAt' => $this->integer()
                                    ->notNull(),
            ], $tableOptions);

            $this->createIndex('ProductLangIndex', '{{%product_lang}}', 'language');
            $this->addForeignKey('ProductLang_FK', '{{%product_lang}}', 'productId', '{{%product}}', 'id', 'CASCADE', 'CASCADE');
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropIndex('ProductLangIndex', '{{%product_lang}}');
            $this->dropForeignKey('ProductLang_FK', '{{%product_lang}}');
            $this->dropTable('{{%product_lang}}');
        }
    }
