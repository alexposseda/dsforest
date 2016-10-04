<?php

    use yii\db\Migration;

    /**
     * Handles the creation for table `offer_lang`.
     */
    class m161004_090143_create_offer_lang_table extends Migration{
        /**
         * @inheritdoc
         */
        public function up(){
            $tableOptions = null;
            if($this->db->driverName === 'mysql'){
                // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }

            $this->createTable('{{%offer_lang}}', [
                'id'         => $this->primaryKey(),
                'offerId'    => $this->integer(),
                'language'   => $this->string(6)
                                     ->notNull(),
                'title'      => $this->string(),
                'advantages' => $this->text(),
                'createdAt' => $this->integer()
                                    ->notNull(),
                'updatedAt' => $this->integer()
                                    ->notNull(),
            ], $tableOptions);

            $this->createIndex('OfferLangIndex', '{{%offer_lang}}', 'language');
            $this->addForeignKey('OfferLang_FK', '{{%offer_lang}}', 'offerId', '{{%offer}}', 'id', 'CASCADE', 'CASCADE');
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropIndex('OfferLangIndex', '{{%offer_lang}}');
            $this->dropForeignKey('OfferLang_FK', '{{%offer_lang}}');
            $this->dropTable('{{%offer_lang}}');
        }
    }
