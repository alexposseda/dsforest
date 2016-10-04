<?php

use yii\db\Migration;

/**
 * Handles the creation for table `product_lang`.
 */
class m161004_090502_create_product_lang_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('product_lang', [
            'id' => $this->primaryKey(),
            'productId' => $this->integer(),
            'language' => $this->string()->notNull(),
            'title' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('product_lang');
    }
}
