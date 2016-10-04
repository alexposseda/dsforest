<?php

    use yii\db\Migration;

    /**
     * Handles the creation for table `product`.
     */
    class m161004_084829_create_product_table extends Migration{
        /**
         * @inheritdoc
         */
        public function up(){
            $tableOptions = null;
            if($this->db->driverName === 'mysql'){
                // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }

            $this->createTable('{{%product}}', [
                'id'      => $this->primaryKey(),
                'offerId' => $this->integer(),
                'cover'   => $this->string(),
                'createdAt' => $this->integer()
                                    ->notNull(),
                'updatedAt' => $this->integer()
                                    ->notNull(),
            ], $tableOptions);

            $this->addForeignKey('OfferId_FK', '{{%product}}','offerId', '{{%offer}}', 'id', 'CASCADE', 'CASCADE');
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropForeignKey('OfferId_FK', '{{%product}}');
            $this->dropTable('{{%product}}');
        }
    }
