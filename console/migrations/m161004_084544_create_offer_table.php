<?php

    use yii\db\Migration;

    /**
     * Handles the creation for table `offer`.
     */
    class m161004_084544_create_offer_table extends Migration{
        /**
         * @inheritdoc
         */
        public function up(){
            $tableOptions = null;
            if($this->db->driverName === 'mysql'){
                // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable('{{%offer}}', [
                'id'         => $this->primaryKey(),
                'categoryId' => $this->integer(),
                'cover'      => $this->string(),
                'gallery'    => $this->text(),
                'createdAt'  => $this->integer()
                                     ->notNull(),
                'updatedAt'  => $this->integer()
                                     ->notNull(),
            ], $tableOptions);

            $this->addForeignKey('CategoryId_FK', '{{%offer}}', 'categoryId', '{{%category}}', 'id', 'CASCADE', 'CASCADE');
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropForeignKey('CategoryId_FK', '{{%offer}}');
            $this->dropTable('{{%offer}}');
        }
    }
