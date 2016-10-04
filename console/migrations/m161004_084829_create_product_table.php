<?php

use yii\db\Migration;

/**
 * Handles the creation for table `product`.
 */
class m161004_084829_create_product_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('product', [
            'id' => $this->primaryKey(),
            'offerId' => $this->integer(),
            'cover' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('product');
    }
}
